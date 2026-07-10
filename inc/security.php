<?php
/**
 * Security hardening — admin brute-force + comment spam.
 *
 * @package OceanWP_Child
 */

defined( 'ABSPATH' ) || exit;

/** Max failed logins before lockout. */
define( 'XE36_LOGIN_MAX_ATTEMPTS', 5 );

/** Window to count failed attempts (seconds). */
define( 'XE36_LOGIN_WINDOW', 15 * MINUTE_IN_SECONDS );

/** Lockout duration (seconds). */
define( 'XE36_LOGIN_LOCKOUT', 30 * MINUTE_IN_SECONDS );

/**
 * Client IP (respect common proxy headers only when trusted enough for rate limit).
 *
 * @return string
 */
function xe36_security_client_ip() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? (string) wp_unslash( $_SERVER['REMOTE_ADDR'] ) : '';
	$ip = sanitize_text_field( $ip );
	return $ip ? $ip : '0.0.0.0';
}

/**
 * Transient key for login attempts / lockout.
 *
 * @param string $suffix attempts|lock.
 * @return string
 */
function xe36_security_login_key( $suffix ) {
	return 'xe36_login_' . $suffix . '_' . md5( xe36_security_client_ip() );
}

/**
 * Whether current IP is locked out of login.
 *
 * @return bool
 */
function xe36_security_is_login_locked() {
	return (bool) get_transient( xe36_security_login_key( 'lock' ) );
}

/**
 * Remaining lockout seconds.
 *
 * @return int
 */
function xe36_security_login_lock_remaining() {
	$timeout = get_option( '_transient_timeout_' . xe36_security_login_key( 'lock' ) );
	if ( ! $timeout ) {
		return 0;
	}
	$left = (int) $timeout - time();
	return max( 0, $left );
}

/**
 * Block login form when IP is locked.
 *
 * @param WP_Error|null $errors Errors.
 * @return WP_Error|null
 */
function xe36_security_block_locked_login( $errors ) {
	if ( ! xe36_security_is_login_locked() ) {
		return $errors;
	}

	if ( ! ( $errors instanceof WP_Error ) ) {
		$errors = new WP_Error();
	}

	$mins = (int) ceil( xe36_security_login_lock_remaining() / 60 );
	$errors->add(
		'xe36_locked',
		sprintf(
			/* translators: %d: minutes */
			__( '<strong>Bảo mật:</strong> Quá nhiều lần đăng nhập sai. Thử lại sau %d phút.', 'oceanwp-child' ),
			max( 1, $mins )
		)
	);

	return $errors;
}
add_filter( 'wp_login_errors', 'xe36_security_block_locked_login' );

/**
 * Reject authenticate early when locked.
 *
 * @param WP_User|WP_Error|null $user User.
 * @return WP_User|WP_Error|null
 */
function xe36_security_authenticate_lock( $user ) {
	if ( xe36_security_is_login_locked() ) {
		$mins = (int) ceil( xe36_security_login_lock_remaining() / 60 );
		return new WP_Error(
			'xe36_locked',
			sprintf(
				__( '<strong>Bảo mật:</strong> Quá nhiều lần đăng nhập sai. Thử lại sau %d phút.', 'oceanwp-child' ),
				max( 1, $mins )
			)
		);
	}
	return $user;
}
add_filter( 'authenticate', 'xe36_security_authenticate_lock', 5 );

/**
 * Record failed login attempt.
 *
 * @param string $username Username.
 */
function xe36_security_failed_login( $username ) {
	unset( $username );

	if ( xe36_security_is_login_locked() ) {
		return;
	}

	$key      = xe36_security_login_key( 'attempts' );
	$attempts = (int) get_transient( $key );
	$attempts++;

	set_transient( $key, $attempts, XE36_LOGIN_WINDOW );

	if ( $attempts >= XE36_LOGIN_MAX_ATTEMPTS ) {
		set_transient( xe36_security_login_key( 'lock' ), 1, XE36_LOGIN_LOCKOUT );
		delete_transient( $key );
	}
}
add_action( 'wp_login_failed', 'xe36_security_failed_login' );

/**
 * Clear attempts on successful login.
 *
 * @param string $username Username.
 */
function xe36_security_clear_login_attempts( $username ) {
	unset( $username );
	delete_transient( xe36_security_login_key( 'attempts' ) );
	delete_transient( xe36_security_login_key( 'lock' ) );
}
add_action( 'wp_login', 'xe36_security_clear_login_attempts', 10, 1 );

/**
 * Generic login error — do not reveal whether user/email exists.
 *
 * @param string $error Error HTML.
 * @return string
 */
function xe36_security_generic_login_error( $error ) {
	if ( xe36_security_is_login_locked() ) {
		return $error;
	}

	if ( false !== strpos( $error, 'incorrect' )
		|| false !== strpos( $error, 'invalid' )
		|| false !== strpos( $error, 'unknown' )
		|| false !== strpos( $error, 'không' )
	) {
		return __( '<strong>Lỗi:</strong> Tên đăng nhập hoặc mật khẩu không đúng.', 'oceanwp-child' );
	}

	return $error;
}
add_filter( 'login_errors', 'xe36_security_generic_login_error' );

/**
 * Disable XML-RPC (common brute-force / pingback vector).
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Remove XML-RPC pingback methods.
 *
 * @param array $methods Methods.
 * @return array
 */
function xe36_security_remove_xmlrpc_pingback( $methods ) {
	unset( $methods['pingback.ping'], $methods['pingback.extensions.getPingbacks'] );
	return $methods;
}
add_filter( 'xmlrpc_methods', 'xe36_security_remove_xmlrpc_pingback' );

/**
 * Remove X-Pingback header.
 *
 * @param array $headers Headers.
 * @return array
 */
function xe36_security_remove_pingback_header( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
}
add_filter( 'wp_headers', 'xe36_security_remove_pingback_header' );

/**
 * Disable application passwords (unused on this site).
 */
add_filter( 'wp_is_application_passwords_available', '__return_false' );

/**
 * Block author enumeration via ?author=N and /author/slug for non-logged-in.
 */
function xe36_security_block_author_enum() {
	if ( is_admin() || is_user_logged_in() ) {
		return;
	}

	if ( isset( $_GET['author'] ) && is_numeric( $_GET['author'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}

	if ( is_author() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'xe36_security_block_author_enum', 1 );

/**
 * Hide users from public REST API.
 *
 * @param array $endpoints Endpoints.
 * @return array
 */
function xe36_security_restrict_users_rest( $endpoints ) {
	if ( is_user_logged_in() ) {
		return $endpoints;
	}

	unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	return $endpoints;
}
add_filter( 'rest_endpoints', 'xe36_security_restrict_users_rest' );

/**
 * Disallow file editors in WP admin when not already set in wp-config.
 */
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

/**
 * Remove WordPress generator meta (version leak).
 */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

/* -------------------------------------------------------------------------
 * Comments / spam
 * ---------------------------------------------------------------------- */

/**
 * Disable comments & pingbacks on pages; keep posts moderated.
 *
 * @param bool $open    Open status.
 * @param int  $post_id Post ID.
 * @return bool
 */
function xe36_security_comments_open( $open, $post_id ) {
	$post = get_post( $post_id );
	if ( ! $post ) {
		return false;
	}

	if ( 'page' === $post->post_type ) {
		return false;
	}

	return $open;
}
add_filter( 'comments_open', 'xe36_security_comments_open', 20, 2 );
add_filter( 'pings_open', '__return_false', 20 );

/**
 * Close comments automatically on posts older than 30 days.
 *
 * @param bool $open    Open.
 * @param int  $post_id Post ID.
 * @return bool
 */
function xe36_security_close_old_comments( $open, $post_id ) {
	if ( ! $open ) {
		return false;
	}

	$post = get_post( $post_id );
	if ( ! $post || 'post' !== $post->post_type ) {
		return $open;
	}

	$age = time() - strtotime( $post->post_date_gmt . ' GMT' );
	if ( $age > 30 * DAY_IN_SECONDS ) {
		return false;
	}

	return $open;
}
add_filter( 'comments_open', 'xe36_security_close_old_comments', 30, 2 );

/**
 * Force comment moderation (never auto-approve).
 */
add_filter( 'pre_option_comment_moderation', static function () {
	return '1';
} );
add_filter( 'pre_option_comment_previously_approved', static function () {
	return '0';
} );
add_filter( 'pre_option_default_comment_status', static function () {
	return 'closed';
} );
add_filter( 'pre_option_default_ping_status', static function () {
	return 'closed';
} );

/**
 * Honeypot field on comment form (hidden from humans).
 *
 * @param array $fields Fields.
 * @return array
 */
function xe36_security_comment_honeypot_field( $fields ) {
	$fields['xe36_hp'] = '<p class="xe36-hp-field" aria-hidden="true" style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;">'
		. '<label for="xe36_website_url">Website</label>'
		. '<input type="text" name="xe36_website_url" id="xe36_website_url" value="" tabindex="-1" autocomplete="off" />'
		. '</p>';
	return $fields;
}
add_filter( 'comment_form_default_fields', 'xe36_security_comment_honeypot_field' );

/**
 * Preprocess comment — honeypot, link flood, empty junk.
 *
 * @param array $commentdata Data.
 * @return array
 */
function xe36_security_preprocess_comment( $commentdata ) {
	// Honeypot filled → bot.
	if ( ! empty( $_POST['xe36_website_url'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		wp_die(
			esc_html__( 'Bình luận bị từ chối.', 'oceanwp-child' ),
			esc_html__( 'Spam', 'oceanwp-child' ),
			array( 'response' => 403 )
		);
	}

	$content = isset( $commentdata['comment_content'] ) ? (string) $commentdata['comment_content'] : '';
	$author  = isset( $commentdata['comment_author'] ) ? (string) $commentdata['comment_author'] : '';
	$email   = isset( $commentdata['comment_author_email'] ) ? (string) $commentdata['comment_author_email'] : '';

	if ( '' === trim( wp_strip_all_tags( $content ) ) ) {
		wp_die( esc_html__( 'Nội dung bình luận không hợp lệ.', 'oceanwp-child' ), '', array( 'response' => 400 ) );
	}

	// Too many URLs → spam.
	$link_count = preg_match_all( '#https?://#i', $content );
	if ( $link_count > 2 ) {
		wp_die(
			esc_html__( 'Bình luận chứa quá nhiều liên kết và đã bị từ chối.', 'oceanwp-child' ),
			esc_html__( 'Spam', 'oceanwp-child' ),
			array( 'response' => 403 )
		);
	}

	// Obvious spam keywords (lightweight).
	$haystack = strtolower( $author . ' ' . $email . ' ' . $content );
	$blocked  = array( 'viagra', 'cialis', 'casino', 'crypto free', 'seo service', 'porn', 'xxx' );
	foreach ( $blocked as $word ) {
		if ( false !== strpos( $haystack, $word ) ) {
			wp_die(
				esc_html__( 'Bình luận bị từ chối.', 'oceanwp-child' ),
				esc_html__( 'Spam', 'oceanwp-child' ),
				array( 'response' => 403 )
			);
		}
	}

	// Always hold for moderation.
	add_filter( 'pre_comment_approved', static function () {
		return 0;
	}, 99 );

	return $commentdata;
}
add_filter( 'preprocess_comment', 'xe36_security_preprocess_comment', 1 );

/**
 * Disable comment author cookies (tracking + spam convenience).
 */
remove_action( 'set_comment_cookies', 'wp_set_comment_cookies' );

/**
 * Hide comment form URL field (common spam target).
 *
 * @param array $fields Fields.
 * @return array
 */
function xe36_security_remove_comment_url_field( $fields ) {
	unset( $fields['url'] );
	return $fields;
}
add_filter( 'comment_form_default_fields', 'xe36_security_remove_comment_url_field', 20 );

/**
 * Tighten flood: 60 seconds between comments from same IP.
 */
add_filter( 'comment_flood_filter', static function ( $block, $time_last, $time_new ) {
	if ( $block ) {
		return true;
	}
	return ( ( $time_new - $time_last ) < 60 );
}, 10, 3 );

/**
 * Disable self-pingbacks.
 *
 * @param array $links Links.
 * @return array
 */
function xe36_security_no_self_ping( $links ) {
	$home = home_url();
	foreach ( $links as $i => $link ) {
		if ( 0 === strpos( $link, $home ) ) {
			unset( $links[ $i ] );
		}
	}
	return $links;
}
add_action( 'pre_ping', 'xe36_security_no_self_ping' );

/* -------------------------------------------------------------------------
 * Chặn thực thi PHP trong uploads
 * ---------------------------------------------------------------------- */

/**
 * .htaccess content for uploads (Apache / LiteSpeed).
 *
 * @return string
 */
function xe36_security_uploads_htaccess() {
	return <<<'HTACCESS'
# Xe 36 — chặn thực thi PHP / script trong uploads
<IfModule mod_authz_core.c>
	Require all granted
</IfModule>

<FilesMatch "\.(?i:php|phtml|php[3-8]?|phar|pl|py|jsp|asp|aspx|sh|cgi|shtml)$">
	<IfModule mod_authz_core.c>
		Require all denied
	</IfModule>
	<IfModule !mod_authz_core.c>
		Order Allow,Deny
		Deny from all
	</IfModule>
</FilesMatch>

<IfModule mod_php.c>
	php_flag engine off
</IfModule>
<IfModule mod_php7.c>
	php_flag engine off
</IfModule>
<IfModule mod_php8.c>
	php_flag engine off
</IfModule>

<IfModule mod_mime.c>
	RemoveHandler .php .phtml .php3 .php4 .php5 .php7 .php8 .phar
	RemoveType .php .phtml .php3 .php4 .php5 .php7 .php8 .phar
</IfModule>

Options -Indexes -ExecCGI
DirectoryIndex index.html index.php
HTACCESS;
}

/**
 * Ensure uploads/.htaccess + index.php exist (recreate if missing).
 */
function xe36_security_protect_uploads_dir() {
	$upload = wp_upload_dir();
	if ( ! empty( $upload['error'] ) || empty( $upload['basedir'] ) ) {
		return;
	}

	$dir = trailingslashit( $upload['basedir'] );

	$htaccess = $dir . '.htaccess';
	$expected = xe36_security_uploads_htaccess();
	if ( ! file_exists( $htaccess ) || false === strpos( (string) file_get_contents( $htaccess ), 'Xe 36 — chặn thực thi PHP' ) ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
		file_put_contents( $htaccess, $expected );
	}

	$index = $dir . 'index.php';
	if ( ! file_exists( $index ) ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
		file_put_contents( $index, "<?php\n// Silence is golden.\n" );
	}
}
add_action( 'admin_init', 'xe36_security_protect_uploads_dir' );
add_action( 'after_setup_theme', 'xe36_security_protect_uploads_dir', 1 );

/**
 * Never allow PHP / executable MIME types via Media Library.
 *
 * @param array $mimes Mimes.
 * @return array
 */
function xe36_security_block_dangerous_mimes( $mimes ) {
	$blocked = array( 'php', 'phtml', 'php3', 'php4', 'php5', 'php7', 'php8', 'phar', 'cgi', 'pl', 'asp', 'aspx', 'exe', 'js', 'html', 'htm' );
	foreach ( $blocked as $ext ) {
		unset( $mimes[ $ext ], $mimes[ 'php|' . $ext ] );
	}
	return $mimes;
}
add_filter( 'upload_mimes', 'xe36_security_block_dangerous_mimes', 99 );

/**
 * Extra check: reject uploads whose real extension is PHP-like.
 *
 * @param array $file File array.
 * @return array
 */
function xe36_security_reject_php_upload( $file ) {
	if ( empty( $file['name'] ) ) {
		return $file;
	}

	$name = strtolower( (string) $file['name'] );
	if ( preg_match( '/\.(php|phtml|php[3-8]|phar|cgi|pl|asp|aspx)(\.|$)/i', $name ) ) {
		$file['error'] = __( 'Không được tải lên file thực thi (PHP/script).', 'oceanwp-child' );
	}

	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'xe36_security_reject_php_upload' );

/**
 * Block direct browser hits to *.php under /uploads/ when request reaches WordPress.
 */
function xe36_security_block_uploads_php_request() {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return;
	}

	$uri = (string) wp_unslash( $_SERVER['REQUEST_URI'] );
	if ( preg_match( '#/wp-content/uploads/.*\.(php|phtml|phar)(\?|$)#i', $uri ) ) {
		status_header( 403 );
		nocache_headers();
		wp_die( esc_html__( 'Forbidden.', 'oceanwp-child' ), 'Forbidden', array( 'response' => 403 ) );
	}
}
add_action( 'init', 'xe36_security_block_uploads_php_request', 0 );
