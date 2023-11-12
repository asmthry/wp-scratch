<?php
/**
 * Author: ASMTHRY
 * Asmthry theme support class helps to add taxonomies to WordPress
 *
 * @package ASMTHRY WP Scratch
 */

if ( ! class_exists( 'WPScratch_Taxonomy' ) ) {
	/** Create Taxonomies Class */
	class WPScratch_Taxonomy {
		/**
		 * Store taxonomy name
		 *
		 * @var string $name
		 */
		protected string $name;

		/**
		 * Set if the taxonomy show in rest
		 *
		 * @var bool $show_in_rest
		 */
		protected bool $show_in_rest = true;

		/**
		 * Taxonomy show admin column
		 *
		 * @var bool $show_admin_column
		 */
		protected bool $show_admin_column = true;

		/**
		 * Allow to show ui for this taxonomy
		 *
		 * @var bool $show_ui
		 */
		protected bool $show_ui = true;

		/**
		 * Show this taxonomy on admin menu
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
		 * Set taxonomy slug
		 *
		 * @var array $rewrite
		 */
		protected array $rewrite = array();

		/**
		 * Store taxonomy update count callback
		 *
		 * @var string $update_count_callback
		 */
		protected string $update_count_callback = '_update_post_term_count';

		/**
		 * Store labels fot taxonomy
		 *
		 * @var array $labels
		 */
		protected array $labels = array();

		/**
		 * Store post name
		 *
		 * @var string $post
		 */
		protected string $post = 'post';

		/** Construct.
		 *
		 * @param string $name - Give your taxonomy name.
		 * @param string $post - Give your post name.
		 */
		public function __construct( string $name, string $post ) {
			$this->post = $post;
			$this->name = $name;
			$this->prepare_labels();
		}

		/**
		 * Create taxonomy filter
		 *
		 * @param string   $name - Name of the taxonomy.
		 * @param callable $fun - Filter function.
		 */
		public static function filter( string $name, callable $fun ) {
			add_filter(
				'wpscratch_taxonomy_' . WPScratch_Helper::slug( $name ),
				$fun,
				10,
				2
			);
		}

		/**
		 * Prepare Taxonomy Labels Based On Name.
		 */
		private function prepare_labels() {
            //@codingStandardsIgnoreStart
			$this->labels['name']                       = _x( $this->name , 'wpscratch' );
			$this->labels['singular_name']              = _x( $this->name, 'wpscratch' );
			$this->labels['search_items']               = __( 'Search '.$this->name );
			$this->labels['popular_items']              = __( 'Popular '.$this->name );
			$this->labels['all_items']                  = __( 'All '.$this->name );
			$this->labels['edit_item']                  = __( 'Edit ' . $this->name );
			$this->labels['update_item']                = __( 'Update '.$this->name );
			$this->labels['add_new_item']               = __( 'Add New '.$this->name );
			$this->labels['new_item_name']              = __( 'New ' . $this->name . ' Name' );
			$this->labels['separate_items_with_commas'] = __( 'Separate ' . $this->name . 's with commas' );
			$this->labels['add_or_remove_items']        = __( 'Add or remove ' . $this->name );
			$this->labels['choose_from_most_used']      = __( 'Choose from the most used ' . $this->name );
			$this->labels['menu_name']                  = __( $this->name );
			// @codingStandardsIgnoreEnd
		}

		/**
		 * Apply WordPress custom post filter
		 */
		private function get_filtered_parameters() {

			$filters = apply_filters(
				'wpscratch_taxonomy_' . WPScratch_Helper::slug( $this->name ),
				get_object_vars( $this )
			);

			return WPScratch_Helper::apply_filter( get_object_vars( $this ), $filters );
		}

		/**
		 * Register taxonomy
		 */
		public function __destruct() {
			add_action(
				'init',
				function () {
					register_taxonomy(
						$this->name,
						WPScratch_Helper::slug( $this->post ),
						$this->get_filtered_parameters()
					);
				}
			);
		}
	}
}
