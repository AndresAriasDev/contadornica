/* Modal compartido: SiteFeedback.open({ type, title, message, returnFocus }). */
(() => {
	'use strict';
	let dialog, icon, title, message, close, returnFocus;
	const create = () => {
		dialog = document.createElement('dialog');
		dialog.className = 'site-feedback-dialog';
		dialog.setAttribute('aria-labelledby', 'site-feedback-title');
		dialog.setAttribute('aria-describedby', 'site-feedback-message');
		icon = document.createElement('div');
		icon.className = 'site-feedback-dialog__icon';
		icon.setAttribute('aria-hidden', 'true');
		title = document.createElement('h2'); title.id = 'site-feedback-title';
		message = document.createElement('p'); message.id = 'site-feedback-message';
		close = document.createElement('button');
		close.type = 'button'; close.className = 'btn btn-primary';
		close.autofocus = true;
		close.addEventListener('click', () => dialog.close());
		dialog.addEventListener('close', () => {
			if (returnFocus?.isConnected) returnFocus.focus({ preventScroll: true });
		});
		dialog.append(icon, title, message, close);
		document.body.append(dialog);
	};
	window.SiteFeedback = {
		open(options = {}) {
			if (!dialog) create();
			const isError = options.type === 'error';
			returnFocus = options.returnFocus || document.activeElement;
			dialog.dataset.type = isError ? 'error' : 'success';
			icon.textContent = isError ? '!' : '✓';
			title.textContent = options.title || (isError ? 'No pudimos completar tu solicitud' : '¡Revisa tu correo!');
			message.textContent = options.message || '';
			close.textContent = isError ? 'Entendido' : 'Cerrar';
			if (!dialog.open) dialog.showModal();
			close.focus({ preventScroll: true });
		},
		close() { if (dialog?.open) dialog.close(); }
	};
})();
