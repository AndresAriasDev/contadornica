<?php
/**
 * Solicitud reutilizable. Args: id, title, service, presentation (embedded sin fotografía).
 * Cargar contador_enqueue_advisory_assets() desde wp_enqueue_scripts en la página anfitriona.
 */
defined( 'ABSPATH' ) || exit;
$section_id = sanitize_title( $args['id'] ?? 'solicitar-asesoria' );
$instance_id = wp_unique_id( 'advisory-form-' );
$embedded = 'embedded' === ( $args['presentation'] ?? '' );
?>
<section id="<?php echo esc_attr( $section_id ); ?>" class="advisory-section<?php echo $embedded ? ' advisory-section--embedded' : ''; ?>" aria-labelledby="<?php echo esc_attr( $instance_id . '-title' ); ?>">
  <?php if ( ! $embedded ) : ?>
  <div class="container">
    <div class="advisory-section__card">
      <div class="advisory-section__brand">
        <img class="advisory-section__photo" src="<?php echo esc_url( content_url( '/uploads/2026/09/oficina-contador-eduardo-leon-tu-contador-de-confianza.png' ) ); ?>" alt="" loading="lazy" decoding="async">
        <img class="advisory-section__logo" src="<?php echo esc_url( content_url( '/uploads/2026/09/logo-color-blanco-tu-contador-de-confianza.png' ) ); ?>" alt="Tu Contador de Confianza" loading="lazy" decoding="async">
      </div>
  <?php endif; ?>
      <div class="advisory-section__content">
      <header class="advisory-section__intro">
        <h2 id="<?php echo esc_attr( $instance_id . '-title' ); ?>"><?php if ( isset( $args['title'] ) ) : echo esc_html( $args['title'] ); else : ?>Contacto<?php endif; ?></h2>
      </header>
      <div id="<?php echo esc_attr( $instance_id ); ?>" data-advisory-form data-service="<?php echo esc_attr( $args['service'] ?? '' ); ?>" data-endpoint="<?php echo esc_url( rest_url( 'tucontador/v1/solicitudes' ) ); ?>">
        <p>El formulario no está disponible en este momento. No se están recibiendo solicitudes desde esta sección.</p>
      </div>
      </div>
  <?php if ( ! $embedded ) : ?>
    </div>
  </div>
  <?php endif; ?>
</section>
