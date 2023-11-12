<?php
/**
 * Author: ASMTHRY
 * Add method to create customizer
 *
 * @package WP Scratch
 */

if ( ! class_exists( 'WPScratch_Customizer' ) ) {
	/**
	 *  Customizer Creating Class
	 */
	class WPScratch_Customizer {
		/**
		 * Use this variable to handle current settings
		 *
		 * @var $customize
		 */
		public string $settings;

		/**
		 * Use this variable to handle current option
		 *
		 * @var $option
		 */
		public string $option;

		/**
		 * Handle customizer configuration
		 *
		 * @var $customize
		 */
		public $customizer = array();

		/**
		 * Handle customizer control option configuration
		 *
		 * @var $options
		 */
		public $options = array();

		/**
		 * Add customizer settings section
		 *
		 * @param string $title - Name of the settings.
		 * @param string $description - Describe the settings.
		 * @param int    $priority - Priority of the settings.
		 *
		 * @return $this;
		 */
		public function settings( string $title, string $description = '', int $priority = 70 ) {
			$slug                      = WPScratch_Helper::slug( $title );
			$this->options[ $slug ]    = array();
			$this->settings            = $slug;
			$this->customizer[ $slug ] = array(
				'id'          => $slug,
				'title'       => $title,
				'description' => $description,
				'priority'    => $priority,
			);

			return $this;
		}

		/**
		 * Add customizer settings section
		 *
		 * @param string $title - Name of the settings.
		 * @param string $type - Type of the settings field.
		 *
		 * @return $this;
		 */
		public function control( string $title, string $type = 'text' ) {
			$slug         = WPScratch_Helper::slug( $title );
			$this->option = $slug;
			array_push(
				$this->options[ $this->settings ],
				array(
					'id'       => $slug,
					'type'     => $type,
					'title'    => $title,
					'settings' => $slug,
				)
			);

			return $this;
		}

		/**
		 * Set all customizer options
		 */
		public function __destruct() {
			add_action(
				'customize_register',
				function ( $wp_customize ) {
					foreach ( $this->customizer as $value ) {
						if ( ! isset( $this->options[ $value['id'] ] ) ) {
							continue;
						}
						$wp_customize->add_section(
							$value['id'],
							array(
								'title'       => $value['title'],
								'description' => $value['description'],
								'priority'    => $value['priority'],
							)
						);

						foreach ( $this->options[ $value['id'] ] as $option ) {
							$wp_customize->add_setting(
								$option['id'],
								array(
									'capability' => 'edit_theme_options',
								)
							);
							$wp_customize->add_control(
								$option['id'] . '_input',
								array(
									'type'     => $option['type'],
									'label'    => $option['title'],
									'section'  => $value['id'],
									'settings' => $option['id'],
								)
							);
						}
					}
				}
			);
		}
	}

}
