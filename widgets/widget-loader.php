<?php

if ( ! function_exists( 'academist_core_register_widgets' ) ) {
	function academist_core_register_widgets() {
		$widgets = apply_filters( 'academist_core_filter_register_widgets', $widgets = array() );
		
		foreach ( $widgets as $widget ) {
			register_widget( $widget );
		}
	}
	
	add_action( 'widgets_init', 'academist_core_register_widgets' );
}