/* Suscripción progresiva: solo presenta éxito cuando el servidor lo confirma. */
(() => {
	'use strict';
	const request = async (endpoint, data) => {
		if (!endpoint) throw new Error('Falta la dirección del endpoint REST de suscripción. Recarga la página.');
		const controller = new AbortController();
		const timer = setTimeout(() => controller.abort(), 30000);
		try {
			const response = await fetch(endpoint, { method: 'POST', credentials: 'omit', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(data), signal: controller.signal });
			if (response.status === 404 || response.status === 405) throw new Error('No se encontró el endpoint REST de suscripción. Revisa la URL del sitio y la disponibilidad de la REST API.');
			const result = await response.json().catch(() => { throw new Error('El servidor no devolvió una respuesta REST válida. Revisa la configuración de WordPress y del servidor.'); });
			if (!response.ok || !result || result.accepted !== true) {
				const failure = new Error(result?.message || 'La REST API no confirmó la solicitud. Inténtalo más tarde.');
				failure.code = result?.code;
				failure.status = response.status;
				throw failure;
			}
			return result;
		} catch (error) {
			if (error.name === 'AbortError' || error instanceof TypeError) {
				const failure = new Error('No pudimos comprobar el resultado. Revisa tu conexión y tu correo antes de volver a intentarlo.');
				failure.code = 'subscription_connection';
				throw failure;
			}
			throw error;
		} finally { clearTimeout(timer); }
	};
	document.querySelectorAll('[data-subscription-form]').forEach(form => {
		const email = form.elements.email;
		const submit = form.querySelector('button[type="submit"]');
		const error = form.querySelector('[role="alert"]');
		const spinner = submit.querySelector('.subscription-spinner');
		const icon = submit.querySelector('.site-footer__icon');
		const showError = message => window.SiteFeedback.open({ type: 'error', message, returnFocus: email });
		let busy = false;
		submit.disabled = false;
		email.addEventListener('input', () => email.removeAttribute('aria-invalid'));
		form.addEventListener('submit', async event => {
			event.preventDefault();
			if (busy) return;
			error.textContent = '';
			email.value = email.value.trim();
			email.removeAttribute('aria-invalid');
			if (!email.value || !email.validity.valid) {
				email.setAttribute('aria-invalid', 'true');
				showError(!email.value ? 'Ingresa tu correo electrónico para suscribirte' : 'Ingresa un correo electrónico válido');
				return;
			}
			busy = true; submit.disabled = true;
			form.setAttribute('aria-busy', 'true');
			submit.setAttribute('aria-label', 'Enviando solicitud');
			spinner.hidden = false; icon.hidden = true;
			try {
				await request(form.dataset.endpoint, { email: email.value, website: form.elements.website.value });
				form.reset();
				window.SiteFeedback.open({ type: 'success', title: '¡Revisa tu correo!', message: 'Te enviamos un enlace para confirmar tu suscripción. Confírmala para comenzar a recibir nuestras nuevas publicaciones.', returnFocus: submit });
			} catch (failure) {
				let message = 'No pudimos completar la solicitud. Inténtalo de nuevo más tarde.';
				if (failure.code === 'subscription_mail_failed') message = 'No pudimos enviar el correo de confirmación. Inténtalo de nuevo en unos minutos.';
				else if (failure.code === 'subscription_connection') message = 'No pudimos comprobar el resultado. Revisa tu conexión y tu correo antes de volver a intentarlo.';
				else if (failure.status === 429) message = 'Espera unos minutos antes de volver a intentarlo.';
				else if (failure.status === 422) {
					message = 'Ingresa un correo electrónico válido';
					email.setAttribute('aria-invalid', 'true');
				}
				showError(message);
			}
			finally {
				busy = false; submit.disabled = false; spinner.hidden = true; icon.hidden = false;
				form.removeAttribute('aria-busy'); submit.setAttribute('aria-label', 'Suscribirse');
			}
		});
	});
	const manage = document.querySelector('[data-subscription-manage]');
	if (manage) {
		let token = new URLSearchParams(location.hash.slice(1)).get('token') || '';
		history.replaceState(null, '', location.pathname + location.search);
		const button = manage.querySelector('button');
		const status = manage.querySelector('[data-subscription-status]');
		button.disabled = !/^[a-f0-9]{64}$/.test(token);
		if (button.disabled) status.textContent = 'El enlace está incompleto. Ábrelo de nuevo desde el correo recibido.';
		let busy = false;
		manage.addEventListener('submit', async event => {
			event.preventDefault();
			if (busy || button.disabled) return;
			busy = true; button.disabled = true;
			manage.setAttribute('aria-busy', 'true'); status.textContent = 'Procesando…';
			try {
				const result = await request(manage.dataset.endpoint, { token });
				token = ''; status.textContent = result.message; button.hidden = true;
				if (result.unsubscribe_url) {
					const url = new URL(result.unsubscribe_url);
					if (url.origin === location.origin) {
						const link = document.createElement('a'); link.href = url.href;
						link.textContent = 'Cancelar suscripción'; manage.append(link);
					}
				}
			} catch (failure) { status.textContent = failure.message; button.disabled = false; }
			finally { busy = false; manage.removeAttribute('aria-busy'); }
		});
	}
})();
