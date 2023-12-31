<?php
/*
Plugin Name: Academist Core
Description: Plugin that adds all post types needed by our theme
Author: Elated Themes
Version: 1.4
*/

require_once 'load.php';

add_action( 'after_setup_theme', array( AcademistCore\CPT\PostTypesRegister::getInstance(), 'register' ) );

if ( ! function_exists( 'academist_core_activation' ) ) {
	/**
	 * Triggers when plugin is activated. It calls flush_rewrite_rules
	 * and defines academist_elated_action_core_on_activate action
	 */
	function academist_core_activation() {
		do_action( 'academist_elated_action_core_on_activate' );
		
		AcademistCore\CPT\PostTypesRegister::getInstance()->register();
		flush_rewrite_rules();
	}
	
	register_activation_hook( __FILE__, 'academist_core_activation' );
}

if ( ! function_exists( 'academist_core_text_domain' ) ) {
	/**
	 * Loads plugin text domain so it can be used in translation
	 */
	function academist_core_text_domain() {
		load_plugin_textdomain( 'academist-core', false, ACADEMIST_CORE_REL_PATH . '/languages' );
	}
	
	add_action( 'plugins_loaded', 'academist_core_text_domain' );
}

if ( ! function_exists( 'academist_core_version_class' ) ) {
	/**
	 * Adds plugins version class to body
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	function academist_core_version_class( $classes ) {
		$classes[] = 'academist-core-' . ACADEMIST_CORE_VERSION;
		
		return $classes;
	}
	
	add_filter( 'body_class', 'academist_core_version_class' );
}

if ( ! function_exists( 'academist_core_theme_installed' ) ) {
	/**
	 * Checks whether theme is installed or not
	 * @return bool
	 */
	function academist_core_theme_installed() {
		return defined( 'ELATED_ROOT' );
	}
}

if ( ! function_exists( 'academist_core_visual_composer_installed' ) ) {
	/**
	 * Function that checks if Visual Composer plugin installed
	 * @return bool
	 */
	function academist_core_visual_composer_installed() {
		return class_exists( 'WPBakeryVisualComposerAbstract' );
	}
}

if ( ! function_exists( 'academist_core_is_woocommerce_installed' ) ) {
	/**
	 * Function that checks if woocommerce is installed
	 * @return bool
	 */
	function academist_core_is_woocommerce_installed() {
		return function_exists( 'is_woocommerce' );
	}
}

if ( ! function_exists( 'academist_core_is_woocommerce_integration_installed' ) ) {
	//is Elated Woocommerce Integration installed?
	function academist_core_is_woocommerce_integration_installed() {
		return defined( 'ACADEMIST_CHECKOUT_INTEGRATION' );
	}
}

if ( ! function_exists( 'academist_core_is_revolution_slider_installed' ) ) {
	function academist_core_is_revolution_slider_installed() {
		return class_exists( 'RevSliderFront' );
	}
}

if ( ! function_exists( 'academist_core_is_wpml_installed' ) ) {
	/**
	 * Function that checks if WPML plugin is installed
	 * @return bool
	 *
	 * @version 0.1
	 */
	function academist_core_is_wpml_installed() {
		return defined( 'ICL_SITEPRESS_VERSION' );
	}
}

if ( ! function_exists( 'academist_core_theme_menu' ) ) {
	/**
	 * Function that generates admin menu for options page.
	 * It generates one admin page per options page.
	 */
	function academist_core_theme_menu() {
		if ( academist_core_theme_installed() && academist_core_is_theme_registered()) {
			
			global $academist_elated_global_Framework;
			academist_elated_init_theme_options();
			
			$page_hook_suffix = add_menu_page(
				esc_html__( 'Academist Options', 'academist-core' ),                                             // The value used to populate the browser's title bar when the menu page is active
				esc_html__( 'Academist Options', 'academist-core' ),                                             // The text of the menu in the administrator's sidebar
				'administrator',                                                                               // What roles are able to access the menu
				ELATED_OPTIONS_SLUG,                                                                             // The ID used to bind submenu items to this menu
				array( $academist_elated_global_Framework->getSkin(), 'renderOptions' ),                         // The callback function used to render this menu
				$academist_elated_global_Framework->getSkin()->getSkinURI() . '/assets/img/admin-logo-icon.png', // Icon For menu Item
				4                                                                                            // Position
			);
			
			foreach ( $academist_elated_global_Framework->eltdOptions->adminPages as $key => $value ) {
				$slug = ! empty( $value->slug ) ? '_tab' . $value->slug : '';
				
				$subpage_hook_suffix = add_submenu_page(
					ELATED_OPTIONS_SLUG,
					esc_html__( 'Academist Options - ', 'academist-core' ) . $value->title, // The value used to populate the browser's title bar when the menu page is active
					$value->title,                                                        // The text of the menu in the administrator's sidebar
					'administrator',                                                      // What roles are able to access the menu
					ELATED_OPTIONS_SLUG . $slug,                                            // The ID used to bind submenu items to this menu
					array( $academist_elated_global_Framework->getSkin(), 'renderOptions' )
				);
				
				add_action( 'admin_print_scripts-' . $subpage_hook_suffix, 'academist_elated_enqueue_admin_scripts' );
				add_action( 'admin_print_styles-' . $subpage_hook_suffix, 'academist_elated_enqueue_admin_styles' );
			};
			
			add_action( 'admin_print_scripts-' . $page_hook_suffix, 'academist_elated_enqueue_admin_scripts' );
			add_action( 'admin_print_styles-' . $page_hook_suffix, 'academist_elated_enqueue_admin_styles' );
		}
	}
	
	add_action( 'admin_menu', 'academist_core_theme_menu' );
}

if ( ! function_exists( 'academist_core_theme_menu_backup_options' ) ) {
	/**
	 * Function that generates admin menu for options page.
	 * It generates one admin page per options page.
	 */
	function academist_core_theme_menu_backup_options() {
		if ( academist_core_theme_installed() ) {
			global $academist_elated_global_Framework;
			
			$slug             = "_backup_options";
			$page_hook_suffix = add_submenu_page(
				ELATED_OPTIONS_SLUG,
				esc_html__( 'Academist Options - Backup Options', 'academist-core' ), // The value used to populate the browser's title bar when the menu page is active
				esc_html__( 'Backup Options', 'academist-core' ),                // The text of the menu in the administrator's sidebar
				'administrator',                                             // What roles are able to access the menu
				ELATED_OPTIONS_SLUG . $slug,                     // The ID used to bind submenu items to this menu
				array( $academist_elated_global_Framework->getSkin(), 'renderBackupOptions' )
			);
			
			add_action( 'admin_print_scripts-' . $page_hook_suffix, 'academist_elated_enqueue_admin_scripts' );
			add_action( 'admin_print_styles-' . $page_hook_suffix, 'academist_elated_enqueue_admin_styles' );
		}
	}
	
	add_action( 'admin_menu', 'academist_core_theme_menu_backup_options' );
}

if ( ! function_exists( 'academist_core_theme_admin_bar_menu_options' ) ) {
	/**
	 * Add a link to the WP Toolbar
	 */
	function academist_core_theme_admin_bar_menu_options( $wp_admin_bar ) {
		if ( academist_core_theme_installed() ) {
			global $academist_elated_global_Framework;
			
			$args = array(
				'id'    => 'academist-admin-bar-options',
				'title' => sprintf( '<span class="ab-icon dashicons-before dashicons-admin-generic"></span> %s', esc_html__( 'Academist Options', 'academist-core' ) ),
				'href'  => esc_url( admin_url( 'admin.php?page=' . ELATED_OPTIONS_SLUG ) )
			);
			
			$wp_admin_bar->add_node( $args );
			
			foreach ( $academist_elated_global_Framework->eltdOptions->adminPages as $key => $value ) {
				$suffix = ! empty( $value->slug ) ? '_tab' . $value->slug : '';
				
				$args = array(
					'id'     => 'academist-admin-bar-options-' . $suffix,
					'title'  => $value->title,
					'parent' => 'academist-admin-bar-options',
					'href'   => esc_url( admin_url( 'admin.php?page=' . ELATED_OPTIONS_SLUG . $suffix ) )
				);
				
				$wp_admin_bar->add_node( $args );
			};
		}
	}
	
	add_action( 'admin_bar_menu', 'academist_core_theme_admin_bar_menu_options', 999 );
}

if ( ! function_exists( 'academist_core_enqueue_our_prettyphoto_scripts_for_theme' ) ) {
	/**
	 * Function that includes our prettyphoto script
	 */
	function academist_core_enqueue_our_prettyphoto_scripts_for_theme() {
		
		if ( academist_core_theme_installed() && academist_core_visual_composer_installed() ) {
			wp_deregister_script( 'prettyphoto' );
			wp_enqueue_script( 'prettyphoto', ELATED_ASSETS_ROOT . '/js/modules/plugins/jquery.prettyPhoto.js', array( 'jquery' ), false, true );
		}
	}
	
	add_action( 'academist_elated_action_enqueue_third_party_scripts', 'academist_core_enqueue_our_prettyphoto_scripts_for_theme' );
}

if( ! function_exists( 'academist_core_is_theme_registered' ) ) {
	function academist_core_is_theme_registered() {
		return class_exists('AcademistCoreDashboard') ? AcademistCoreDashboard::get_instance()->is_theme_registered() : true;
	}
}