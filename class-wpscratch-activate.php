<?php
/**
 * Author: ASMTHRY
 * This file trigger when plugin activate
 *
 * @package WP Scratch
 */

/** ASMTHRY Plugin activation */
if ( ! class_exists( 'WPScratch_Activate' ) ) {
	/** Class for doing when plugin activating */
	class WPScratch_Activate {
		/** Execute code when Activation Instance created */
		public static function activate() {
			/** Write plugin activation code here */
			flush_rewrite_rules();
		}
	}
}
