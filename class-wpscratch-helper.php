<?php
/**
 * Author: ASMTHRY
 * This file trigger when plugin deactivate
 *
 * @package WP Scratch
 */

if ( ! class_exists( 'WPScratch_Helper' ) ) {
	/** Wp Scratch plugin helper functions */
	class WPScratch_Helper {
		/**
		 * This Function will help to create slug
		 *
		 * @param string $name It must be a string.
		 * This function will convert given name to slug.
		 */
		public static function slug( string $name ) {
			return strtolower( str_replace( ' ', '_', $name ) );
		}
	}
}
