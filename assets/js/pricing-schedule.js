(function () {
	'use strict';

	function initScheduleCard(card) {
		var tabs = card.querySelectorAll('[data-schedule-dir]');
		var panels = card.querySelectorAll('[data-schedule-panel]');
		var foot = card.querySelector('[data-schedule-foot]');

		if (!tabs.length || !panels.length) {
			return;
		}

		function setDirection(dir) {
			tabs.forEach(function (tab) {
				var active = tab.getAttribute('data-schedule-dir') === dir;
				tab.setAttribute('aria-pressed', active ? 'true' : 'false');
			});

			panels.forEach(function (panel) {
				if (panel.getAttribute('data-schedule-panel') === dir) {
					panel.removeAttribute('hidden');
				} else {
					panel.setAttribute('hidden', '');
				}
			});

			if (foot) {
				var text = foot.getAttribute('data-foot-' + dir) || '';
				foot.textContent = text;
			}
		}

		tabs.forEach(function (tab) {
			tab.addEventListener('click', function () {
				setDirection(tab.getAttribute('data-schedule-dir') || 'outbound');
			});
		});
	}

	document.querySelectorAll('[data-schedule-card]').forEach(initScheduleCard);
})();
