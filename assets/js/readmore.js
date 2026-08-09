/**
 * Smooth read-more / collapse for [readmore] shortcode.
 */
(function () {
	'use strict';

	function getCollapsedHeight(wrapper) {
		var value = parseInt(wrapper.getAttribute('data-collapsed-height'), 10);
		return Number.isFinite(value) && value > 0 ? value : 320;
	}

	function measure(wrapper) {
		var panel = wrapper.querySelector('.readmore-panel');
		var body = wrapper.querySelector('.readmore-body');
		var button = wrapper.querySelector('.readmore-btn');
		if (!panel || !body || !button) {
			return;
		}

		var collapsed = getCollapsedHeight(wrapper);
		var needsToggle = body.scrollHeight > collapsed + 24;
		button.hidden = !needsToggle;

		if (!needsToggle) {
			panel.classList.remove('is-collapsed');
			panel.classList.add('is-expanded');
			panel.style.maxHeight = 'none';
			wrapper.classList.add('is-open');
			return;
		}

		if (!wrapper.classList.contains('is-open')) {
			panel.classList.add('is-collapsed');
			panel.classList.remove('is-expanded');
			panel.style.maxHeight = collapsed + 'px';
			button.textContent = wrapper.getAttribute('data-more') || 'Đọc thêm';
		}
	}

	function stickyHeaderOffset() {
		var header = document.querySelector('.xe36-header');
		if (!header) {
			return 16;
		}
		return Math.ceil(header.getBoundingClientRect().height) + 12;
	}

	/**
	 * Keep the SEO block in view after collapse — otherwise page height
	 * shrinks and mobile browsers clamp scroll to the footer.
	 */
	function scrollToWrapper(wrapper) {
		var target =
			wrapper.closest('#home-content') ||
			wrapper.closest('.home-content') ||
			wrapper;
		var top =
			target.getBoundingClientRect().top +
			window.pageYOffset -
			stickyHeaderOffset();

		window.scrollTo({
			top: Math.max(0, top),
			behavior: 'smooth',
		});
	}

	function setOpen(wrapper, open) {
		var panel = wrapper.querySelector('.readmore-panel');
		var body = wrapper.querySelector('.readmore-body');
		var button = wrapper.querySelector('.readmore-btn');
		var fade = wrapper.querySelector('.readmore-fade');
		if (!panel || !body || !button) {
			return;
		}

		var collapsed = getCollapsedHeight(wrapper);
		var more = wrapper.getAttribute('data-more') || 'Đọc thêm';
		var less = wrapper.getAttribute('data-less') || 'Thu gọn';

		if (open) {
			wrapper.classList.add('is-open');
			panel.classList.remove('is-collapsed');
			panel.classList.add('is-expanded');
			panel.style.maxHeight = body.scrollHeight + 'px';
			button.textContent = less;
			if (fade) {
				fade.style.opacity = '0';
			}

			var onEnd = function (event) {
				if (event.propertyName !== 'max-height') {
					return;
				}
				panel.removeEventListener('transitionend', onEnd);
				if (wrapper.classList.contains('is-open')) {
					panel.style.maxHeight = 'none';
				}
			};
			panel.addEventListener('transitionend', onEnd);
			return;
		}

		var current = body.scrollHeight;
		panel.style.maxHeight = current + 'px';
		panel.classList.add('is-collapsed');
		panel.classList.remove('is-expanded');
		wrapper.classList.remove('is-open');
		button.textContent = more;
		if (fade) {
			fade.style.opacity = '';
		}

		// Scroll back before height shrinks so we don't land at page bottom.
		scrollToWrapper(wrapper);

		requestAnimationFrame(function () {
			requestAnimationFrame(function () {
				panel.style.maxHeight = collapsed + 'px';
			});
		});
	}

	function initAll() {
		document.querySelectorAll('.readmore-wrapper').forEach(function (wrapper) {
			measure(wrapper);
		});
	}

	document.addEventListener('click', function (event) {
		var button = event.target.closest('.readmore-btn');
		if (!button) {
			return;
		}

		var wrapper = button.closest('.readmore-wrapper');
		if (!wrapper) {
			return;
		}

		event.preventDefault();
		setOpen(wrapper, !wrapper.classList.contains('is-open'));
	});

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initAll);
	} else {
		initAll();
	}

	window.addEventListener('resize', function () {
		window.clearTimeout(window.__xe36ReadmoreResize);
		window.__xe36ReadmoreResize = window.setTimeout(initAll, 150);
	});
})();
