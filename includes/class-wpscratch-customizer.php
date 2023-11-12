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
		 * Use this variable to handle current section
		 *
		 * @var $customize
		 */
		public string $section;

		/**
		 * Use this variable to handle current control
		 *
		 * @var string $control
		 */
		public string $control;

		/**
		 * Handle customizer configuration
		 *
		 * @var $sections
		 */
		public $sections = array();

		/**
		 * Handle customizer control option configuration
		 *
		 * @var $controls
		 */
		public $controls = array();

		/**
		 * Add customizer settings section
		 *
		 * @param string $title - Name of the settings.
		 * @param string $description - Describe the settings.
		 * @param int    $priority - Priority of the settings.
		 *
		 * @return $this;
		 */
		public function section( string $title, string $description = '', int $priority = 70 ) {
			$slug                    = WPScratch_Helper::slug( $title );
			$this->controls[ $slug ] = array();
			$this->section           = $slug;
			$this->control           = '';
			$this->sections[ $slug ] = array(
				'id'          => $slug,
				'title'       => $title,
				'description' => $description,
				'priority'    => $priority,
			);

			return $this;
		}

		/**
		 * Add customizer settings controls
		 *
		 * @param string $title - Name of the settings.
		 * @param string $type - Type of the settings field.
		 *
		 * @return $this;
		 */
		public function settings( string $title, string $type = 'text' ) {
			$slug                                      = WPScratch_Helper::slug( $title );
			$this->control                             = $slug;
			$this->controls[ $this->section ][ $slug ] =
			array(
				'id'       => $slug,
				'type'     => $type,
				'title'    => $title,
				'settings' => $slug,
			);

			return $this;
		}

		/**
		 * Change customizer control type
		 *
		 * @param string $type - Type of the control.
		 *
		 * @return $this;
		 */
		public function type( string $type ) {
			$this->controls[ $this->section ][ $this->control ]['type'] = $type;

			return $this;
		}

		/**
		 * Change customizer control
		 *
		 * @param string $control - Change customizer control class name.
		 *
		 * @return $this;
		 */
		public function control( string $control ) {
			$this->controls[ $this->section ][ $this->control ]['control'] = $control;

			return $this;
		}

		/**
		 * Set all customizer options
		 */
		public function __destruct() {
			add_action(
				'customize_register',
				function ( $wp_customize ) {
					foreach ( $this->sections as $value ) {
						if ( ! isset( $this->controls[ $value['id'] ] ) ) {
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

						foreach ( $this->controls[ $value['id'] ] as $option ) {
							$wp_customize->add_setting(
								$option['id'],
								array(
									'capability' => 'edit_theme_options',
								)
							);
							if ( isset( $option['control'] ) ) {
								$wp_customize->add_control(
									new $option['control'](
										$wp_customize,
										$option['id'],
										array(
											'label'   => $option['title'],
											'section' => $value['id'],
										)
									)
								);
							} else {
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
				}
			);
		}
	}
}
