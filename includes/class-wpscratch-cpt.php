<?php
/**
 * Author: ASMTHRY
 * This class will helps to add custom post type to WordPress
 *
 * @package WP Scratch
 */

// Check if WPScratch_Cpt exists.
if ( ! class_exists( 'WPScratch_Cpt' ) ) {
	/**
	 * Use this class to create custom post type
	 *
	 * @class WPScratch_Cpt
	 */
	class WPScratch_Cpt {
		/**
		 * Store custom post type name
		 *
		 * @var string $name
		 */
		protected string $name;

		/**
		 * Store labels fot custom post type
		 *
		 * @var array $labels
		 */
		protected array $labels = array();

		/**
		 * Set if the custom post type is for public
		 *
		 * @var bool $public
		 */
		protected bool $public = true;

		/**
		 * Allow to query custom post type publicly
		 *
		 * @var bool $publicly_queryable
		 */
		protected bool $publicly_queryable = true;

		/**
		 * Allow to show ui for this custom post type
		 *
		 * @var bool $show_ui
		 */
		protected bool $show_ui = true;

		/**
		 * Show this custom post type on admin menu
		 *
		 * @var bool $show_in_menu
		 */
		protected bool $show_in_menu = true;

		/**
		 * Allow query var
		 *
		 * @var bool $query_var
		 */
		protected bool $query_var = true;

		/**
		 * Set custom post type slug
		 *
		 * @var array $rewrite
		 */
		protected array $rewrite = array();

		/**
		 * Set capability of this custom post type
		 *
		 * @var string $rewrite
		 */
		protected string $capability_type = 'post';

		/**
		 * Set false if this custom post type does not have archive
		 *
		 * @var bool $rewrite
		 */
		protected bool $has_archive = true;

		/**
		 * Set hierarchical
		 *
		 * @var bool $rewrite
		 */
		protected bool $hierarchical = false;

		/**
		 * Set menu position
		 *
		 * @var string|null $menu_position
		 */
		protected $menu_position = null;

		/**
		 * Add additional support for this custom post type
		 *
		 * @var array $supports
		 */
		protected array $supports = array( 'title', 'editor', 'thumbnail' );

		/**
		 * Initialize custom post type name when the instance create
		 *
		 * @param string $name - Name of the custom post type.
		 */
		public function __construct( string $name ) {
			$this->name = $name;
			$this->prepare_cpt_labels();
		}

		/**
		 * Set custom post type name when the instance create
		 *
		 * @param string $name - Name of the custom post type.
		 */
		public function set_name( string $name ) {
			$this->name = $name;
			$this->prepare_cpt_labels();
		}

		/**
		 * Set taxonomy show_ui.
		 *
		 * @param bool $status - This custom post type requires UI?.
		 *
		 * @return $this
		 */
		public function set_show_ui( bool $status ) {
			$this->show_ui = $status;
			return $this;
		}

		/**
		 * Set taxonomy show_in_menu.
		 *
		 * @param bool $status - show_in_menu.
		 *
		 * @return $this
		 */
		public function set_show_in_menu( bool $status ) {
			$this->show_in_menu = $status;
			return $this;
		}

		/**
		 * Set taxonomy query_var.
		 *
		 * @param bool $status - query_var.
		 *
		 * @return $this
		 */
		public function set_query_var( bool $status ) {
			$this->query_var = $status;
			return $this;
		}

		/**
		 * Set taxonomy rewrite.
		 *
		 * @param array $rewrite - rewrite.
		 *
		 * @return $this
		 */
		public function set_rewrite( array $rewrite ) {
			$this->rewrite = $rewrite;
			return $this;
		}

		/**
		 * Set taxonomy labels.
		 *
		 * @param array $labels - labels.
		 *
		 * @return $this
		 */
		public function set_labels( array $labels ) {
			$this->labels = $labels;
			return $this;
		}

		/**
		 * Set taxonomy for the custom post type
		 *
		 * @param string        $name - Name of the taxonomy.
		 * @param callable|null $fun - Do some actions on taxonomy instance.
		 *
		 * @return $this
		 */
		public function taxonomy( string $name, callable|null $fun = null ) {
			if ( $fun ) {
				$fun( new WPScratch_Taxonomy( $name, $this->name ) );
			} else {
				new WPScratch_Taxonomy( $name, $this->name );
			}

			return $this;
		}

		/**
		 * Apply WordPress custom post filter
		 */
		private function get_filtered_parameters() {

			$filters = apply_filters(
				'wpscratch_cpt_' . WPScratch_Helper::slug( $this->name ),
				get_object_vars( $this )
			);

			return WPScratch_Helper::apply_filter( get_object_vars( $this ), $filters );
		}

		/** Prepare Custom Post Type Labels Based On Name. */
		private function prepare_cpt_labels() {
			// @codingStandardsIgnoreStart
			$this->labels = array(
				'name'                  => __( $this->name, 'asmthry' ),
				'singular_name'         => __( $this->name, 'asmthry' ),
				'menu_name'             => __( $this->name, 'asmthry' ),
				'name_admin_bar'        => __( $this->name, 'asmthry' ),
				'add_new'               => __( 'Add New', 'asmthry' ),
				'add_new_item'          => __( 'Add New ' . $this->name, 'asmthry' ),
				'new_item'              => __( 'New ' . $this->name, 'asmthry' ),
				'edit_item'             => __( 'Edit ' . $this->name, 'asmthry' ),
				'view_item'             => __( 'View ' . $this->name, 'asmthry' ),
				'all_items'             => __( 'All ' . $this->name, 'asmthry' ),
				'search_items'          => __( 'Search ' . $this->name, 'asmthry' ),
				'parent_item_colon'     => __( 'Parent ' . $this->name, 'asmthry' ),
				'not_found'             => __( 'No ' . $this->name . 's found.', 'asmthry' ),
				'not_found_in_trash'    => __( 'No ' . $this->name . ' found in Trash.', 'asmthry' ),
				'featured_image'        => __( $this->name . ' Cover Image', 'asmthry' ),
				'set_featured_image'    => __( 'No ' . $this->name . ' found in Trash.', 'asmthry' ),
				'remove_featured_image' => __( $this->name . ' Cover Image', 'asmthry' ),
				'archives'              => __( $this->name . ' archives', 'asmthry' ),
			);
			// @codingStandardsIgnoreEnd
		}

		/**
		 * Register custom post type
		 */
		public function __destruct() {
			add_action(
				'init',
				function () {
					register_post_type(
						WPScratch_Helper::slug( $this->name ),
						$this->get_filtered_parameters()
					);
				}
			);
		}
	}
}
