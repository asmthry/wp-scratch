<?php
/**
 * Author: ASMTHRY
 * This file trigger when plugin deactivate
 *
 * @package WP Scratch
 */

/** ASMTHRY Plugin deactivation */
if ( ! class_exists( 'Asmthry_Deactivate' ) ) {
	/** Class for doing when plugin deactivating */
	class Asmthry_Deactivate {
		/** Execute code when deactivation Instance created */
		public static function deactivate() {
			/** Write plugin deactivation code here */
			flush_rewrite_rules();
		}
	}
}
