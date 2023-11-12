<?php
/**
 * Author: ASMTHRY
 * This class will helps to enqueue script and style to WordPress
 *
 * @package WP Scratch
 */

// Check if WPScratch_Enqueue exists.
if ( ! class_exists( 'WPScratch_Enqueue' ) ) {
	/**
	 * Use this class to create custom post type
	 *
	 * @class WPScratch_Enqueue
	 */
	class WPScratch_Enqueue {
		/**
		 * Enqueue styles array
		 *
		 * @var array $styles is.
		 */
		public array $styles = array();

		/**
		 * Enqueue scripts array
		 *
		 * @var array $scripts is.
		 */
		public array $scripts = array();

		/**
		 * Current Enqueueing file id
		 *
		 * @var string $current_id is.
		 */
		public string $current_id;

		/**
		 * Current Enqueueing file type
		 *
		 * @var string $type is.
		 */
		public string $type;

		/**
		 * Use ::.
		 *
		 * @return $this;
		 */
		public static function init() {

			return new self();
		}

		/**
		 * Add files to enqueueing list
		 *
		 * @param string $id - id for the enqueue.
		 * @param string $path - path to the enqueue script or style .
		 * @param array  $dependencies - dependance array.
		 * @param string $version - Version of the file.
		 * @param string $media - media details.
		 *
		 * @return $this;
		 */
		public function style(
			string $id,
			string $path,
			array $dependencies = array(),
			string $version = WP_SCRATCH_VERSION,
			string $media = 'all'
		) {
			wp_register_style(
				$id,
				$path,
				$dependencies,
				$version,
				$media
			);
			$this->styles[ $id ] = func_get_args();
			$this->current_id    = $id;
			$this->type          = 'style';

			return $this;
		}

		/**
		 * Add files to enqueueing list
		 *
		 * @param string $id - id for the enqueue.
		 * @param string $path - path to the enqueue script or style .
		 * @param array  $dependencies - dependance array.
		 * @param string $version - Version of the file.
		 * @param string $media - media details.
		 * @param bool   $in_footer - Add file in footer.
		 * @param string $strategy - File strategy.
		 *
		 * @return $this;
		 */
		public function script(
			string $id,
			string $path,
			array $dependencies = array(),
			string $version = WP_SCRATCH_VERSION,
			string $media = 'all',
			bool $in_footer = true,
			string $strategy = null
		) {
			wp_register_script(
				$id,
				$path,
				$dependencies,
				$version,
				$media,
				array(
					'in_footer' => $in_footer,
					'strategy'  => $strategy,
				)
			);
			$this->scripts[ $id ] = func_get_args();
			$this->current_id     = $id;
			$this->type           = 'script';

			return $this;
		}

		/**
		 * Restrict script/style loading only for some pages
		 *
		 * @param string|array $pages - List of all pages you want.
		 */
		public function only( string|array $pages ) {
			if ( 'script' === $this->type ) {
				$this->scripts[ $this->current_id ]['page'] = $pages;
			} else {
				$this->styles[ $this->current_id ]['page'] = $pages;
			}

			return $this;
		}

		/**
		 * Load script/style except some pages
		 *
		 * @param string|array $pages - List of all pages you want.
		 */
		public function except( string|array $pages ) {
			if ( 'script' === $this->type ) {
				$this->scripts[ $this->current_id ]['except'] = $pages;
			} else {
				$this->styles[ $this->current_id ]['except'] = $pages;
			}

			return $this;
		}

		/**
		 * Load all scripts and styles
		 */
		public function __destruct() {

			add_action(
				'wp_enqueue_scripts',
				function () {
					foreach ( $this->styles as $key => $value ) {
						if ( isset( $value['except'] ) ) {
							! is_page( $value['except'] ) && wp_enqueue_style( $key );
						} elseif ( isset( $value['page'] ) ) {
							is_page( $value['page'] ) && wp_enqueue_style( $key );
						} else {
							wp_enqueue_style( $key );
						}
					}

					foreach ( $this->scripts as $key => $value ) {
						if ( isset( $value['except'] ) ) {
							! is_page( $value['except'] ) && wp_enqueue_script( $key );
						} elseif ( isset( $value['page'] ) ) {
							is_page( $value['page'] ) && wp_enqueue_script( $key );
						} else {
							wp_enqueue_script( $key );
						}
					}
				}
			);
		}
	}

}
