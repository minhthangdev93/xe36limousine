/**
 * Contact form page.
 */
(function () {
	'use strict';

	function ready(fn) {
		if (document.readyState !== 'loading') {
			fn();
		} else {
			document.addEventListener('DOMContentLoaded', fn);
		}
	}

	ready(function () {
		var form = document.getElementById('xe36-contact-form');
		if (!form || typeof xe36Contact === 'undefined') {
			return;
		}

		var submitBtn = form.querySelector('[data-contact-submit]');
		var responseEl = form.querySelector('[data-contact-response]');
		var defaultLabel = submitBtn ? submitBtn.textContent : '';

		form.addEventListener('submit', function (event) {
			event.preventDefault();

			if (responseEl) {
				responseEl.textContent = '';
				responseEl.className = 'contact-form__response';
			}

			var name = (form.elements.namedItem('name') || {}).value || '';
			var phone = (form.elements.namedItem('phone') || {}).value || '';
			var message = (form.elements.namedItem('message') || {}).value || '';

			if (!name.trim() || !phone.trim() || !message.trim()) {
				if (responseEl) {
					responseEl.textContent = 'Vui lòng điền họ tên, số điện thoại và nội dung tin nhắn.';
					responseEl.className = 'contact-form__response is-error';
				}
				return;
			}

			if (submitBtn) {
				submitBtn.disabled = true;
				submitBtn.textContent = 'Đang gửi…';
			}

			var body = new FormData(form);
			body.append('action', 'submit_contact_form');
			body.append('nonce', xe36Contact.nonce || '');

			fetch(xe36Contact.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				body: body,
			})
				.then(function (res) {
					return res.json();
				})
				.then(function (json) {
					var ok = json && json.success;
					var msg =
						json && json.data && json.data.message
							? json.data.message
							: ok
								? 'Gửi thành công.'
								: 'Không gửi được. Vui lòng thử lại.';

					if (responseEl) {
						responseEl.textContent = msg;
						responseEl.className =
							'contact-form__response ' + (ok ? 'is-success' : 'is-error');
					}

					if (ok) {
						form.reset();
					}
				})
				.catch(function () {
					if (responseEl) {
						responseEl.textContent = 'Lỗi kết nối. Vui lòng thử lại.';
						responseEl.className = 'contact-form__response is-error';
					}
				})
				.finally(function () {
					if (submitBtn) {
						submitBtn.disabled = false;
						submitBtn.textContent = defaultLabel;
					}
				});
		});
	});
})();
