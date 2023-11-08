<?php
/**
 * Author: ASMTHRY
 * This file trigger when plugin deactivate
 *
 * @package WP Scratch
 */

/** ASMTHRY Plugin deactivation */
if ( ! class_exists( 'WPScratch_Deactivate' ) ) {
	/** Class for doing when plugin deactivating */
	class WPScratch_Deactivate {
		/** Execute code when deactivation Instance created */
		public static function deactivate() {
			/** Write plugin deactivation code here */
			flush_rewrite_rules();
		}
	}
}
