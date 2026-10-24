<?php
/** Página Contacto: mapa verificado y formulario compartido, sin servicio inicial. */
defined( 'ABSPATH' ) || exit;
get_header();
?>
<main id="primary" class="contact-page">
	<div class="container contact-page__main">
		<div class="contact-page__card">
			<div class="contact-page__location">
				<?php // CID obtenido del destino del enlace corto proporcionado; sin clave API. ?>
				<iframe src="https://maps.google.com/maps?cid=3878316159961228148&amp;output=embed" title="Ubicación de Tu Contador de Confianza en Managua" width="600" height="650" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
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
