(function ($) {
	'use strict';

	function pad(n) {
		return String(n).padStart(2, '0');
	}

	function toISODate(d) {
		return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate());
	}

	function todayISO() {
		return toISODate(new Date());
	}

	function addDaysISO(iso, days) {
		var parts = String(iso || '').split('-');
		var d = new Date(
			Number(parts[0]),
			Number(parts[1]) - 1,
			Number(parts[2]) || 1
		);
		d.setDate(d.getDate() + days);
		return toISODate(d);
	}

	function nowHHMM() {
		var d = new Date();
		return pad(d.getHours()) + ':' + pad(d.getMinutes());
	}

	/**
	 * After last trip (20:00), default booking date is tomorrow.
	 */
	function defaultTravelDate() {
		var d = new Date();
		if (d.getHours() >= 20) {
			d.setDate(d.getDate() + 1);
		}
		return toISODate(d);
	}

	function rebuildHours($time, selectedDate) {
		$time.empty();
		var isToday = selectedDate === todayISO();
		var now = nowHHMM();
		var added = 0;

		for (var hour = 4; hour <= 20; hour++) {
			var value = pad(hour) + ':00';
			if (isToday && value <= now) {
				continue;
			}
			$time.append(new Option(value, value));
			added++;
		}

		if (!added) {
			$time.append(new Option('—', ''));
			return false;
		}

		// Earliest remaining trip.
		$time.prop('selectedIndex', 0);
		return true;
	}

	/**
	 * Ensure date/time are bookable (bump past last trip of the day).
	 */
	function syncTravelDateTime($date, $time) {
		var minDate = defaultTravelDate();
		var val = $date.val() || minDate;

		if (val < minDate) {
			val = minDate;
		}

		$date.attr('min', minDate).val(val);

		if (!rebuildHours($time, val) && val === todayISO()) {
			val = addDaysISO(todayISO(), 1);
			$date.attr('min', val).val(val);
			rebuildHours($time, val);
		}
	}

	function loadCountries(cfg) {
		if (cfg && Array.isArray(cfg.countries) && cfg.countries.length) {
			return cfg.countries;
		}

		var el = document.getElementById('xe36-countries-json');
		if (!el) {
			return [];
		}

		try {
			var parsed = JSON.parse(el.textContent || '[]');
			return Array.isArray(parsed) ? parsed : [];
		} catch (e) {
			return [];
		}
	}

	function dialDigits(str) {
		var m = String(str || '').match(/\+?[\d-]+/g);
		if (!m) {
			return '';
		}
		return m.join('').replace(/[^\d+]/g, '');
	}

	function formatPrice(amount) {
		return (
			String(Math.round(amount)).replace(/\B(?=(\d{3})+(?!\d))/g, '.') + 'đ'
		);
	}

	function seatPrice(seatKey, route, cfg) {
		var seats = cfg.seats || {};
		var meta = seats[seatKey];
		if (!meta) {
			return 0;
		}
		var price = Number(meta.basePrice) || 0;
		var surchargeRoutes = cfg.surchargeRoutes || [];
		if (surchargeRoutes.indexOf(route) !== -1) {
			price += Number(cfg.surcharge) || 0;
		}
		return price;
	}

	function refreshSeatOptions($seat, route, cfg) {
		if (!$seat.length) {
			return;
		}
		var seats = cfg.seats || {};
		var current = $seat.val() || 'middle';
		$seat.empty();
		Object.keys(seats).forEach(function (key) {
			var label = seats[key].label + ' — ' + formatPrice(seatPrice(key, route, cfg));
			$seat.append(new Option(label, key));
		});
		if (seats[current]) {
			$seat.val(current);
		}
	}

	function initCountryCombobox($root, countries) {
		if (!$root.length || !countries.length) {
			return;
		}

		var $hidden = $root.find('#country-code');
		var $input = $root.find('.xe36-country-combobox__input');
		var $list = $root.find('.xe36-country-combobox__list');
		var committed = true;

		$input.off('.xe36Country');
		$list.off('.xe36Country');

		var defaultItem =
			countries.find(function (c) {
				return c.value === 'Vietnam +84';
			}) || countries[0];

		function setCountry(item) {
			if (!item) {
				return;
			}
			$hidden.val(item.value);
			$input.val(item.label);
			committed = true;
		}

		setCountry(defaultItem);

		function closeList() {
			$list.attr('hidden', true).empty();
			$input.attr('aria-expanded', 'false');
		}

		function openList(items) {
			$list.empty();
			if (!items.length) {
				$list
					.append(
						$('<li class="xe36-country-combobox__empty"></li>').text(
							'Không tìm thấy. Thử “Vietnam”, “+84”, “Japan”…'
						)
					)
					.removeAttr('hidden');
				$input.attr('aria-expanded', 'true');
				return;
			}

			items.slice(0, 15).forEach(function (item) {
				var $li = $('<li role="option" tabindex="-1"></li>')
					.text(item.label)
					.attr('data-value', item.value)
					.attr('data-label', item.label);
				$list.append($li);
			});

			$list.removeAttr('hidden');
			$input.attr('aria-expanded', 'true');
		}

		function filterCountries(query) {
			var q = (query || '').toLowerCase().trim();
			if (!q) {
				return countries.slice(0, 15);
			}

			var qDigits = q.replace(/[^\d+]/g, '');

			return countries.filter(function (c) {
				var label = (c.label || '').toLowerCase();
				var value = (c.value || '').toLowerCase();
				var digits = dialDigits(c.value).toLowerCase();

				if (label.indexOf(q) !== -1 || value.indexOf(q) !== -1) {
					return true;
				}
				if (qDigits && digits.indexOf(qDigits) !== -1) {
					return true;
				}
				return false;
			});
		}

		function isPrintableKey(event) {
			if (event.ctrlKey || event.metaKey || event.altKey) {
				return false;
			}
			return event.key.length === 1;
		}

		$input.on('focus.xe36Country', function () {
			openList(countries.slice(0, 15));
			// Select all so next key replaces without manual delete.
			requestAnimationFrame(function () {
				$input[0].select();
			});
		});

		$input.on('keydown.xe36Country', function (event) {
			if (event.key === 'Escape') {
				setCountry(
					countries.find(function (c) {
						return c.value === $hidden.val();
					}) || defaultItem
				);
				closeList();
				$input.blur();
				return;
			}

			// First character while value is "committed" → clear & start search.
			if (committed && isPrintableKey(event)) {
				committed = false;
				event.preventDefault();
				$input.val(event.key);
				openList(filterCountries(event.key));
			}
		});

		$input.on('input.xe36Country', function () {
			committed = false;
			openList(filterCountries($input.val()));
		});

		$list.on('mousedown.xe36Country', 'li[data-value]', function (event) {
			event.preventDefault();
			setCountry({
				value: $(this).attr('data-value'),
				label: $(this).attr('data-label'),
			});
			closeList();
		});

		$input.on('blur.xe36Country', function () {
			setTimeout(function () {
				var current = $input.val().toLowerCase().trim();
				var match = countries.find(function (c) {
					return (
						(c.label || '').toLowerCase() === current ||
						(c.value || '').toLowerCase() === current ||
						dialDigits(c.value) === dialDigits(current)
					);
				});

				if (!match && current) {
					match = filterCountries(current)[0];
				}

				setCountry(match || defaultItem);
				closeList();
			}, 180);
		});
	}

	$(function () {
		var $form = $('#booking-form');
		if (!$form.length) {
			return;
		}

		var cfg = window.xe36Booking || {};
		var countries = loadCountries(cfg);
		var $date = $('#date');
		var $time = $('#time');
		var $route = $('#route');
		var $seat = $('#seat');
		var $response = $('#response');
		var $submit = $form.find('button[type="submit"]');
		var submitLabel = $submit.data('submit-label') || $submit.text();
		var $combo = $form.find('[data-country-combobox]');

		$route.val('hn-th');
		refreshSeatOptions($seat, 'hn-th', cfg);

		syncTravelDateTime($date, $time);

		// Open native date picker when clicking anywhere on the field.
		$date.on('click', function () {
			var el = this;
			if (typeof el.showPicker === 'function') {
				try {
					el.showPicker();
				} catch (e) {
					// Ignore if browser blocks showPicker.
				}
			}
		});

		$date.on('change', function () {
			syncTravelDateTime($date, $time);
		});

		$route.on('change', function () {
			refreshSeatOptions($seat, $route.val() || 'hn-th', cfg);
		});

		initCountryCombobox($combo, countries);

		function applyBookingRoute(route) {
			if (!route || !$route.find('option[value="' + route + '"]').length) {
				return false;
			}
			$route.val(route).trigger('change');
			return true;
		}

		function scrollToBooking() {
			var el = document.getElementById('home-booking');
			if (!el) {
				return;
			}
			el.scrollIntoView({ behavior: 'smooth', block: 'start' });
			window.setTimeout(function () {
				var name = document.getElementById('name');
				if (name) {
					name.focus({ preventScroll: true });
				}
			}, 450);
		}

		$(document).on('click', '[data-booking-route]', function (event) {
			var route = $(this).attr('data-booking-route');
			if (!applyBookingRoute(route)) {
				return;
			}
			event.preventDefault();
			scrollToBooking();
			if (history.replaceState) {
				history.replaceState(null, '', '#home-booking');
			}
		});

		var params = new URLSearchParams(window.location.search);
		var preset = params.get('route') || '';
		if (preset) {
			applyBookingRoute(preset);
		}

		$form.on('submit', function (event) {
			event.preventDefault();

			var route = $route.val() || 'hn-th';
			var seat = $seat.val() || '';
			var phone = $('#phone').val().replace(/\s+/g, '');
			var phonePattern = /^\d{9,15}$/;
			var i18n = cfg.i18n || {};

			if (!route) {
				$response.html(
					'<p class="xe36-booking-response xe36-booking-response--error">' +
						(i18n.routeRequired || 'Vui lòng chọn tuyến.') +
						'</p>'
				);
				return;
			}

			if (!seat) {
				$response.html(
					'<p class="xe36-booking-response xe36-booking-response--error">' +
						(i18n.seatRequired || 'Vui lòng chọn ghế muốn ngồi.') +
						'</p>'
				);
				return;
			}

			if (!phonePattern.test(phone)) {
				$response.html(
					'<p class="xe36-booking-response xe36-booking-response--error">' +
						(i18n.phoneInvalid || 'Số điện thoại không hợp lệ.') +
						'</p>'
				);
				return;
			}

			var countdown = 3;
			$submit.prop('disabled', true).text((i18n.sending || 'Đang gửi...') + ' ' + countdown);

			var countdownInterval = setInterval(function () {
				countdown -= 1;
				$submit.text((i18n.sending || 'Đang gửi...') + ' ' + countdown);
				if (countdown <= 0) {
					clearInterval(countdownInterval);
				}
			}, 1000);

			$.ajax({
				url: cfg.ajaxUrl || '/wp-admin/admin-ajax.php',
				type: 'POST',
				data: {
					action: 'submit_booking_form',
					route: route,
					date: $date.val(),
					time: $time.val(),
					seat: seat,
					ticket_quantity: $('#ticket-quantity').val(),
					name: $('#name').val(),
					country_code: $('#country-code').val(),
					phone: phone,
				},
				success: function (response) {
					clearInterval(countdownInterval);
					$response.html(response);
					$submit.prop('disabled', false).text(submitLabel);
					$form[0].reset();
					$route.val('hn-th');
					syncTravelDateTime($date, $time);
					refreshSeatOptions($seat, 'hn-th', cfg);
					initCountryCombobox($combo, countries);
				},
				error: function () {
					clearInterval(countdownInterval);
					$response.html(
						'<p class="xe36-booking-response xe36-booking-response--error">' +
							(i18n.error || 'Lỗi gửi yêu cầu.') +
							'</p>'
					);
					$submit.prop('disabled', false).text(submitLabel);
				},
			});
		});
	});
})(jQuery);
