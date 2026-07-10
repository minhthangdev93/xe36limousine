/**
 * Lite YouTube facade — load iframe only on click (saves LCP / INP).
 */
(function () {
	'use strict';

	function mount(btn) {
		var id = btn.getAttribute('data-youtube-id');
		if (!id) {
			return;
		}
		var title = btn.getAttribute('data-youtube-title') || 'YouTube video';
		var iframe = document.createElement('iframe');
		iframe.src =
			'https://www.youtube.com/embed/' +
			encodeURIComponent(id) +
			'?rel=0&modestbranding=1&autoplay=1';
		iframe.title = title;
		iframe.allow =
			'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
		iframe.allowFullscreen = true;
		iframe.setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
		iframe.className = 'home-offers__iframe';
		btn.replaceWith(iframe);
	}

	document.addEventListener('click', function (event) {
		var btn = event.target.closest('[data-youtube-facade]');
		if (!btn) {
			return;
		}
		event.preventDefault();
		mount(btn);
	});

	document.addEventListener('keydown', function (event) {
		if (event.key !== 'Enter' && event.key !== ' ') {
			return;
		}
		var btn = event.target.closest('[data-youtube-facade]');
		if (!btn) {
			return;
		}
		event.preventDefault();
		mount(btn);
	});
})();
