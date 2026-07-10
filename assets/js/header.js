/**
 * Custom header — mobile drawer toggle.
 */
(function () {
	'use strict';

	function initHeader(root) {
		var toggle = root.querySelector('[data-xe36-nav-toggle]');
		var drawer = root.querySelector('[data-xe36-nav-drawer]');
		if (!toggle || !drawer) {
			return;
		}

		function setOpen(open) {
			root.classList.toggle('is-open', open);
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			toggle.setAttribute('aria-label', open ? 'Đóng menu' : 'Mở menu');
			if (open) {
				drawer.removeAttribute('hidden');
			} else {
				drawer.setAttribute('hidden', '');
			}
		}

		toggle.addEventListener('click', function () {
			setOpen(!root.classList.contains('is-open'));
		});

		drawer.querySelectorAll('a').forEach(function (link) {
			link.addEventListener('click', function () {
				setOpen(false);
			});
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') {
				setOpen(false);
			}
		});

		window.addEventListener('resize', function () {
			if (window.matchMedia('(min-width: 1024px)').matches) {
				setOpen(false);
			}
		});
	}

	function boot() {
		document.querySelectorAll('[data-xe36-header]').forEach(initHeader);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
