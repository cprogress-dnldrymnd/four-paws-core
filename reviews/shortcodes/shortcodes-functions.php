<?php

if ( ! function_exists( 'academist_core_include_reviews_shortcodes_files' ) ) {
	/**
	 * Loades all shortcodes by going through all folders that are placed directly in shortcodes folder
	 */
	function academist_core_include_reviews_shortcodes_files() {
		if(academist_core_is_theme_registered()){
			foreach ( glob( ACADEMIST_CORE_ABS_PATH . '/reviews/shortcodes/*/load.php' ) as $shortcode_load ) {
				include_once $shortcode_load;
			}
		}
	}
	
	add_action( 'academist_core_action_include_shortcodes_file', 'academist_core_include_reviews_shortcodes_files' );
}