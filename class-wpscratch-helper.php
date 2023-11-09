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

		/**
		 * Change array value based on key of another array
		 *
		 * @param array $parameters - Give default value array.
		 * @param array $filters - Give replacing array.
		 */
		public static function apply_filter( array $parameters, $filters ) {
			if ( is_array( $filters ) ) {
				return array_replace( $parameters, $filters );
			} else {
				return $parameters;
			}
		}
	}
}
