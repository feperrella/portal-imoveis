<?php
/**
 * Plugin Name: UQBITZ Hub de Integracao Imobiliaria
 * Plugin URI:  https://github.com/feperrella/uqbitz-hub-imoveis
 * Description: Generates an OpenNavent XML feed to sync WordPress property listings with real estate portals (ImovelWeb, Wimoveis, Casa Mineira).
 * Version:     3.4.2
 * Author:      Fernando Perrella (UQBITZ)
 * Author URI:  https://uqbitz.com
 * License:     GPL-2.0+
 * Text Domain: uqbitz-hub-imoveis
 * Requires at least: 6.5
 * Requires PHP: 8.0
 *
 * @package UQBITZ_Hub_Imoveis
 */

defined( 'ABSPATH' ) || exit;

/*
 * DEFAULT TERMS SEED — tipos e finalidades oficiais.
 */
add_action( 'admin_init', 'uqbhi_maybe_seed_default_terms' );

/*
 * ACF DEPENDENCY CHECK — aceita ACF free ou ACF Pro.
 */
add_action( 'admin_init', 'uqbhi_check_acf_dependency' );

/**
 * Display admin notice if ACF is not installed.
 */
function uqbhi_check_acf_dependency() {
	if ( class_exists( 'ACF' ) ) {
		return;
	}
	add_action(
		'admin_notices',
		function () {
			$install_url = wp_nonce_url(
				admin_url( 'update.php?action=install-plugin&plugin=advanced-custom-fields' ),
				'install-plugin_advanced-custom-fields'
			);
			echo '<div class="notice notice-error"><p>';
			echo '<strong>UQBITZ Hub de Integração Imobiliária</strong> requer o plugin ';
			echo '<strong>Advanced Custom Fields</strong> (gratuito ou Pro) para funcionar. ';
			echo '<a href="' . esc_url( $install_url ) . '">Clique aqui para instalar o ACF gratuitamente</a>.';
			echo '</p></div>';
		}
	);
}

/*
 * CONSTANTES.
 */
define( 'UQBHI_VERSION', '3.4.2' );
define( 'UQBHI_FEED_SLUG', 'feed-imovelweb' );
define( 'UQBHI_BEARER_TOKEN', '259313f5-2c84-4f6c-bd2c-eabad2a8bc83' );
define( 'UQBHI_PATH', plugin_dir_path( __FILE__ ) );

/*
 * INCLUDES.
 */
require UQBHI_PATH . 'includes/cpt.php';
require UQBHI_PATH . 'includes/helpers.php';
require UQBHI_PATH . 'includes/feed.php';
require UQBHI_PATH . 'includes/acf-fields.php';

if ( is_admin() ) {
	require UQBHI_PATH . 'includes/admin.php';
}

/*
 * ACTIVATION / DEACTIVATION.
 */
register_activation_hook( __FILE__, 'uqbhi_activate' );

/**
 * Flush rewrite rules on plugin activation.
 */
function uqbhi_activate() {
	uqbhi_register_post_type_and_taxonomies();
	uqbhi_seed_default_terms();
	update_option( 'uqbhi_seed_version', UQBHI_VERSION, false );
	uqbhi_register_rewrite();
	flush_rewrite_rules();
}

register_deactivation_hook( __FILE__, 'uqbhi_deactivate' );

/**
 * Flush rewrite rules on plugin deactivation.
 */
function uqbhi_deactivate() {
	flush_rewrite_rules();
}

/**
 * Seed the default terms once per plugin version.
 */
function uqbhi_maybe_seed_default_terms() {
	if ( get_option( 'uqbhi_seed_version' ) === UQBHI_VERSION ) {
		return;
	}

	uqbhi_seed_default_terms();
	update_option( 'uqbhi_seed_version', UQBHI_VERSION, false );
}

/**
 * Seed the official type and purpose taxonomies.
 */
function uqbhi_seed_default_terms() {
	$seed = array(
		'uqbhi_tipo'       => array(
			array(
				'name'     => 'Casa',
				'slug'     => 'casa',
				'children' => array(
					array( 'name' => 'Casa de Condomínio', 'slug' => 'casa-condominio' ),
					array( 'name' => 'Casa de Vila', 'slug' => 'casa-de-vila' ),
					array( 'name' => 'Sobrado', 'slug' => 'sobrado' ),
					array( 'name' => 'Quarto (Casa)', 'slug' => 'quarto-casa' ),
				),
			),
			array(
				'name'     => 'Apartamento',
				'slug'     => 'apartamento',
				'children' => array(
					array( 'name' => 'Studio / Kitchenette', 'slug' => 'studio' ),
					array( 'name' => 'Loft', 'slug' => 'loft' ),
					array( 'name' => 'Flat', 'slug' => 'flat' ),
					array( 'name' => 'Cobertura', 'slug' => 'cobertura' ),
					array( 'name' => 'Duplex', 'slug' => 'duplex' ),
					array( 'name' => 'Triplex', 'slug' => 'triplex' ),
					array( 'name' => 'Quarto (Apartamento)', 'slug' => 'quarto-apt' ),
					array( 'name' => 'Garden', 'slug' => 'garden' ),
				),
			),
			array(
				'name'     => 'Terreno',
				'slug'     => 'terreno',
				'children' => array(
					array( 'name' => 'Loteamento / Condomínio', 'slug' => 'loteamento' ),
				),
			),
			array(
				'name'     => 'Rural',
				'slug'     => 'rural',
				'children' => array(
					array( 'name' => 'Chácara', 'slug' => 'chacara' ),
					array( 'name' => 'Sítio', 'slug' => 'sitio' ),
					array( 'name' => 'Fazenda', 'slug' => 'fazenda' ),
					array( 'name' => 'Haras', 'slug' => 'haras' ),
				),
			),
			array(
				'name'     => 'Comercial',
				'slug'     => 'comercial',
				'children' => array(
					array( 'name' => 'Box / Garagem', 'slug' => 'box-garagem' ),
					array( 'name' => 'Prédio Inteiro', 'slug' => 'predio-inteiro' ),
					array( 'name' => 'Conjunto Comercial / Sala', 'slug' => 'conjunto-comercial' ),
					array( 'name' => 'Casa Comercial', 'slug' => 'casa-comercial' ),
					array( 'name' => 'Loja de Shopping', 'slug' => 'loja-shopping' ),
					array( 'name' => 'Loja / Salão', 'slug' => 'loja-salao' ),
					array( 'name' => 'Galpão / Depósito', 'slug' => 'galpao' ),
					array( 'name' => 'Hotel', 'slug' => 'hotel' ),
					array( 'name' => 'Motel', 'slug' => 'motel' ),
					array( 'name' => 'Pousada / Chalé', 'slug' => 'pousada' ),
					array( 'name' => 'Indústria', 'slug' => 'industria' ),
					array( 'name' => 'Área Industrial', 'slug' => 'area-industrial' ),
					array( 'name' => 'Consultório', 'slug' => 'consultorio' ),
					array( 'name' => 'Clínica', 'slug' => 'clinica' ),
					array( 'name' => 'Andar Corrido', 'slug' => 'andar-corrido' ),
					array( 'name' => 'Ponto Comercial', 'slug' => 'ponto-comercial' ),
					array( 'name' => 'Área Comercial', 'slug' => 'area-comercial' ),
				),
			),
		),
		'uqbhi_finalidade' => array(
			array( 'name' => 'Venda', 'slug' => 'venda' ),
			array( 'name' => 'Aluguel', 'slug' => 'aluguel' ),
			array( 'name' => 'Temporada', 'slug' => 'temporada' ),
			array( 'name' => 'Repasse', 'slug' => 'repasse' ),
		),
	);

	foreach ( $seed as $taxonomy => $terms ) {
		foreach ( $terms as $term ) {
			uqbhi_seed_term_tree( $taxonomy, $term, 0 );
		}
	}
}

/**
 * Insert a term tree if it is missing.
 *
 * @param string $taxonomy Taxonomy name.
 * @param array  $term     Term definition.
 * @param int    $parent   Parent term ID.
 */
function uqbhi_seed_term_tree( $taxonomy, array $term, $parent = 0 ) {
	$existing = term_exists( $term['slug'], $taxonomy );
	if ( $existing ) {
		$term_id = is_array( $existing ) ? (int) $existing['term_id'] : (int) $existing;
	} else {
		$result = wp_insert_term(
			$term['name'],
			$taxonomy,
			array(
				'slug'   => $term['slug'],
				'parent' => (int) $parent,
			)
		);
		if ( is_wp_error( $result ) ) {
			return;
		}
		$term_id = (int) $result['term_id'];
	}

	if ( empty( $term['children'] ) ) {
		return;
	}

	foreach ( $term['children'] as $child ) {
		uqbhi_seed_term_tree( $taxonomy, $child, $term_id );
	}
}
