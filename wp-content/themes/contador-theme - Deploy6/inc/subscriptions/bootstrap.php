<?php
/** Suscripciones del blog: etapa de doble confirmación, sin campañas. */
defined( 'ABSPATH' ) || exit;
require_once __DIR__ . '/storage.php';
require_once __DIR__ . '/email.php';
require_once __DIR__ . '/http.php';

function contador_subscription_assets() {
	$modal_style = 'assets/css/components/feedback-modal.css';
	$modal_script = 'assets/js/feedback-modal.js';
	wp_enqueue_style( 'contador-feedback-modal', get_theme_file_uri( $modal_style ), array( 'contador-theme-global' ), (string) filemtime( get_theme_file_path( $modal_style ) ) );
	wp_enqueue_script( 'contador-feedback-modal', get_theme_file_uri( $modal_script ), array(), (string) filemtime( get_theme_file_path( $modal_script ) ), true );
	foreach ( array( 'style' => 'assets/css/components/subscription.css', 'script' => 'assets/js/subscription.js' ) as $type => $file ) {
		$version = (string) filemtime( get_theme_file_path( $file ) );
		if ( 'style' === $type ) wp_enqueue_style( 'contador-subscription', get_theme_file_uri( $file ), array( 'contador-theme-global', 'contador-theme-footer' ), $version );
		else wp_enqueue_script( 'contador-subscription', get_theme_file_uri( $file ), array( 'contador-feedback-modal' ), $version, true );
	}
}
add_action( 'wp_enqueue_scripts', 'contador_subscription_assets' );
