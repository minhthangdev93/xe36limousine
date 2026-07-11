/**
 * Gallery carousel — native touch scroll + snap; mouse drag on desktop; autoplay.
 */
(function () {
	'use strict';

	function initCarousel(root) {
		var viewport = root.querySelector('[data-gallery-viewport]');
		var track = root.querySelector('[data-gallery-track]');
		var slides = Array.prototype.slice.call(root.querySelectorAll('[data-gallery-slide]'));
		var prevBtn = root.querySelector('[data-gallery-prev]');
		var nextBtn = root.querySelector('[data-gallery-next]');
		var dots = Array.prototype.slice.call(root.querySelectorAll('[data-gallery-dot]'));

		if (!viewport || !track || slides.length < 2) {
			return;
		}

		var intervalMs = parseInt(root.getAttribute('data-interval'), 10) || 3000;
		var index = 0;
		var timer = null;
		var resumeTimer = null;
		var scrollRaf = 0;
		var interacting = false;

		var isPointerDown = false;
		var startX = 0;
		var startScroll = 0;
		var dragged = false;

		function clampIndex(i) {
			var n = slides.length;
			return ((i % n) + n) % n;
		}

		function goTo(i, smooth) {
			index = clampIndex(i);
			var left = slides[index].offsetLeft;
			viewport.scrollTo({
				left: left,
				behavior: smooth === false ? 'auto' : 'smooth',
			});
			updateDots();
		}

		function updateDots() {
			dots.forEach(function (dot, i) {
				var active = i === index;
				dot.classList.toggle('is-active', active);
				dot.setAttribute('aria-selected', active ? 'true' : 'false');
			});
		}

		function next() {
			goTo(index + 1, true);
		}

		function prev() {
			goTo(index - 1, true);
		}

		function stopAutoplay() {
			if (timer) {
				clearInterval(timer);
				timer = null;
			}
		}

		function startAutoplay() {
			stopAutoplay();
			if (interacting) {
				return;
			}
			if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
				return;
			}
			timer = setInterval(function () {
				if (!interacting) {
					next();
				}
			}, intervalMs);
		}

		function pauseThenResume() {
			stopAutoplay();
			if (resumeTimer) {
				clearTimeout(resumeTimer);
			}
			resumeTimer = setTimeout(function () {
				interacting = false;
				startAutoplay();
			}, intervalMs + 1200);
		}

		function syncIndexFromScroll() {
			var left = viewport.scrollLeft;
			var best = 0;
			var bestDist = Infinity;
			for (var i = 0; i < slides.length; i++) {
				var dist = Math.abs(slides[i].offsetLeft - left);
				if (dist < bestDist) {
					bestDist = dist;
					best = i;
				}
			}
			if (best !== index) {
				index = best;
				updateDots();
			}
		}

		function onScroll() {
			if (scrollRaf) {
				return;
			}
			scrollRaf = window.requestAnimationFrame(function () {
				scrollRaf = 0;
				syncIndexFromScroll();
			});
		}

		if (prevBtn) {
			prevBtn.addEventListener('click', function () {
				interacting = true;
				prev();
				pauseThenResume();
			});
		}

		if (nextBtn) {
			nextBtn.addEventListener('click', function () {
				interacting = true;
				next();
				pauseThenResume();
			});
		}

		dots.forEach(function (dot) {
			dot.addEventListener('click', function () {
				var i = parseInt(dot.getAttribute('data-gallery-dot'), 10);
				if (!isNaN(i)) {
					interacting = true;
					goTo(i, true);
					pauseThenResume();
				}
			});
		});

		viewport.addEventListener('scroll', onScroll, { passive: true });

		if ('onscrollend' in window) {
			viewport.addEventListener(
				'scrollend',
				function () {
					syncIndexFromScroll();
				},
				{ passive: true }
			);
		}

		/* Touch: native overflow scroll + CSS snap only (no JS scrollLeft). */
		viewport.addEventListener(
			'touchstart',
			function () {
				interacting = true;
				stopAutoplay();
				pauseThenResume();
			},
			{ passive: true }
		);

		/* Mouse drag only — avoids fighting iOS/Android touch scrolling. */
		viewport.addEventListener('pointerdown', function (e) {
			if (e.pointerType !== 'mouse' || e.button !== 0) {
				return;
			}
			isPointerDown = true;
			dragged = false;
			startX = e.clientX;
			startScroll = viewport.scrollLeft;
			interacting = true;
			viewport.classList.add('is-dragging');
			pauseThenResume();
			try {
				viewport.setPointerCapture(e.pointerId);
			} catch (err) {
				/* ignore */
			}
		});

		viewport.addEventListener('pointermove', function (e) {
			if (!isPointerDown || e.pointerType !== 'mouse') {
				return;
			}
			var dx = e.clientX - startX;
			if (Math.abs(dx) > 4) {
				dragged = true;
			}
			viewport.scrollLeft = startScroll - dx;
		});

		function endPointer(e) {
			if (!isPointerDown) {
				return;
			}
			isPointerDown = false;
			viewport.classList.remove('is-dragging');

			if (dragged) {
				var dx = e.clientX - startX;
				if (dx < -40) {
					next();
				} else if (dx > 40) {
					prev();
				} else {
					goTo(index, true);
				}
			}
		}

		viewport.addEventListener('pointerup', endPointer);
		viewport.addEventListener('pointercancel', endPointer);

		viewport.addEventListener('keydown', function (e) {
			if (e.key === 'ArrowRight') {
				e.preventDefault();
				interacting = true;
				next();
				pauseThenResume();
			} else if (e.key === 'ArrowLeft') {
				e.preventDefault();
				interacting = true;
				prev();
				pauseThenResume();
			}
		});

		root.addEventListener('mouseenter', stopAutoplay);
		root.addEventListener('mouseleave', function () {
			if (!interacting) {
				startAutoplay();
			}
		});

		document.addEventListener('visibilitychange', function () {
			if (document.hidden) {
				stopAutoplay();
			} else if (!interacting) {
				startAutoplay();
			}
		});

		window.addEventListener(
			'resize',
			function () {
				goTo(index, false);
			},
			{ passive: true }
		);

		goTo(0, false);
		startAutoplay();
	}

	function boot() {
		document.querySelectorAll('[data-gallery-carousel]').forEach(initCarousel);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
