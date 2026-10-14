<?php
/** Índice nativo de herramientas existentes: página con slug calculadoras. */
defined( 'ABSPATH' ) || exit;
$tools = array(
	array( 'Calcula tu IR e INSS', 'ir-inss', 'calculator' ),
	array( 'Calcula tu aguinaldo', 'aguinaldo', 'benefits' ),
	array( 'Calcula tus vacaciones', 'vacaciones', 'calendar' ),
	array( 'Calcula tu liquidación', 'liquidacion-laboral', 'document' ),
);
get_header();
?>
<main id="primary" class="calculators-index">
	<div class="container">
		<header class="calculators-index__header">
			<h1>Calculadoras contables para Nicaragua</h1>
			<p>Consulta tu salario neto, aguinaldo, vacaciones y liquidación laboral con herramientas gratuitas diseñadas para Nicaragua</p>
		</header>
		<div class="calculators-index__grid">
			<?php foreach ( $tools as $tool ) :
				$tool_page = get_page_by_path( 'calculadoras/' . $tool[1] );
				$url = $tool_page instanceof WP_Post && 'publish' === $tool_page->post_status ? get_permalink( $tool_page ) : '';
				?>
				<?php if ( $url ) : ?>
					<a class="calculators-index__card" href="<?php echo esc_url( $url ); ?>">
				<?php else : ?>
					<div class="calculators-index__card calculators-index__card--unavailable">
				<?php endif; ?>
					<span class="calculators-index__icon calculators-index__icon--<?php echo esc_attr( $tool[2] ); ?>" aria-hidden="true"></span>
					<h2><?php echo esc_html( $tool[0] ); ?></h2>
					<?php if ( ! $url ) : ?><p>Herramienta no disponible en este momento.</p><?php endif; ?>
				<?php echo $url ? '</a>' : '</div>'; ?>
			<?php endforeach; ?>
		</div>
	</div>
</main>
<?php get_footer(); ?>
