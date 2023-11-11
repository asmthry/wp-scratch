<?php
/**
 * Author: ASMTHRY
 * This class will helps to add custom post type to WordPress
 *
 * @package WP Scratch
 */

// Check if WPScratch_Theme_Support exists.
if ( ! class_exists( 'WPScratch_Theme_Support' ) ) {
	/**
	 * Use this class to create custom post type
	 *
	 * @class WPScratch_Theme_Support
	 */
	class WPScratch_Theme_Support {
		/**
		 * Add theme support
		 *
		 * @param string $feature - Name of the feature you want to add.
		 * @param array  $arguments - Arguments for the theme feature.
		 */
		public static function add( string $feature, array $arguments = array() ) {
			add_action(
				'after_setup_theme',
				fn () => add_theme_support( $feature, $arguments )
			);
		}
	}
}
