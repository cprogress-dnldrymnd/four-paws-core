<?php
if ( ! function_exists( 'academist_core_dashboard_load_files' ) ) {
	function academist_core_dashboard_load_files() {
		require_once ACADEMIST_CORE_ABS_PATH . '/core-dashboard/core-dashboard.php';
		require_once ACADEMIST_CORE_ABS_PATH . '/core-dashboard/rest/include.php';
		require_once ACADEMIST_CORE_ABS_PATH . '/core-dashboard/registration-rest.php';
		require_once ACADEMIST_CORE_ABS_PATH . '/core-dashboard/sub-pages/sub-page.php';

		foreach (glob(ACADEMIST_CORE_ABS_PATH . '/core-dashboard/sub-pages/*/load.php') as $subpages) {
			include_once $subpages;
		}
	}

	add_action('after_setup_theme', 'academist_core_dashboard_load_files');
}