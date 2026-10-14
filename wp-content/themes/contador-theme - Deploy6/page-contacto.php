<?php
/** Página Contacto: mapa verificado y formulario compartido, sin servicio inicial. */
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="primary" class="contact-page">
	<header class="contact-page__header container">
		<h1>Contacta con Tu Contador de Confianza</h1>
		<p>¿Necesitas ayuda con tu contabilidad, declaraciones de impuestos o tienes alguna consulta tributaria? Cuéntanos tu situación y recibe orientación de nuestro equipo en Nicaragua</p>
	</header>
	<div class="container contact-page__main">
		<div class="contact-page__card">
			<div class="contact-page__location">
				<?php // CID obtenido del destino del enlace corto proporcionado; sin clave API. ?>
				<iframe src="https://maps.google.com/maps?cid=3878316159961228148&amp;output=embed" title="Ubicación de Tu Contador de Confianza en Managua" width="600" height="650" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
				<a href="https://maps.app.goo.gl/caPMzKeApwz7Qk8N6" target="_blank" rel="noopener noreferrer">Ver ubicación en Google Maps<span class="contact-page__sr-only"> (abre en una nueva pestaña)</span></a>
			</div>
			<?php get_template_part( 'template-parts/components/advisory-form', null, array(
				'id' => 'solicitar-asesoria',
				'title' => 'Cuéntanos qué necesitas',
				'service' => '',
				'presentation' => 'embedded',
			) ); ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>
