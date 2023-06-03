import './style.scss';

document.addEventListener('DOMContentLoaded', function () {
	var triggerButtons = document.querySelectorAll('.optinbee-trigger');
	var optinForms = document.querySelectorAll('.optinbee-form');
	var closeButtons = document.querySelectorAll('.optinbee-close');
	var overlay = document.getElementById('optinbee-1');

	triggerButtons.forEach(function (button) {
		button.addEventListener('click', function () {
			overlay.classList.add('show-popup');
		});
	});

	optinForms.forEach(function (form) {
		var button = form.querySelector('input[type="submit"]');
		var messageBox = document.getElementById('optinbee-message');

		form.addEventListener('submit', function (e) {
			e.preventDefault();

			const xhr = new XMLHttpRequest();
			const formData = new FormData(form);

			formData.append('nonce', optinbee_vars.nonce);
			formData.append('action', 'optinbee_handle_subscribe');

			xhr.addEventListener('loadstart', function () {
				button.setAttribute('disabled', true);
			});

			xhr.addEventListener('load', function () {
				var data = JSON.parse(xhr.response);

				if (data.code === 200) {
					messageBox.innerText = 'Submitted successfully!';
					setTimeout(function () {
						window.location.href = 'https://wppaw.com/thank-you';
					}, 3000);
				} else {
					messageBox.innerText =
						'Submission failed. Please try again.';
				}

				console.log(data);
			});

			xhr.addEventListener('error', function () {
				alert('Error!');
			});

			xhr.addEventListener('loadend', function () {
				button.removeAttribute('disabled');
			});

			xhr.open('POST', optinbee_vars.ajaxurl);
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

			xhr.send(formData);
		});
	});

	closeButtons.forEach(function (button) {
		button.addEventListener('click', function () {
			overlay.classList.remove('show-popup');
		});
	});

	overlay.addEventListener('click', function (event) {
		if (event.target === overlay) {
			overlay.classList.remove('show-popup');
		}
	});
});
