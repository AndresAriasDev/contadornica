<?php defined( 'ABSPATH' ) || exit; ?>
<form novalidate class="subscription-form" method="post" action="<?php echo esc_url( rest_url( 'tucontador/v1/subscriptions/subscribe' ) ); ?>" data-subscription-form data-endpoint="<?php echo esc_url( rest_url( 'tucontador/v1/subscriptions/subscribe' ) ); ?>" aria-labelledby="footer-subscribe-title">
	<div class="site-footer__email-field">
		<input id="footer-subscription-email" type="email" name="email" placeholder="Tu correo electrónico" aria-label="Tu correo electrónico" aria-describedby="subscription-error" autocomplete="email" maxlength="254" required>
		<button type="submit" aria-label="Suscribirse" disabled><span class="site-footer__icon site-footer__icon--send" aria-hidden="true"></span><span class="subscription-spinner" hidden aria-hidden="true"></span></button>
	</div>
	<div class="subscription-trap" aria-hidden="true"><label>Sitio web<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
	<p id="subscription-error" class="subscription-error" role="alert"></p>
	<noscript><p>Activa JavaScript para solicitar la confirmación de tu suscripción.</p></noscript>
</form>
