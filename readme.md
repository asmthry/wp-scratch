## WP Scratch

This plugin will help you reduce your coding effort.

### Add Theme Support To Your Theme.

```php
WPScratch_Theme_Support::add( 'title-tag' );
```

#### All Available Methods

#### 1) add - Add Theme Support

| Parameter  | Type   | Default | Description  |
| ---------- | ------ | ------- | ------------ |
| $feature   | string |         | Support Name |
| $arguments | array  | array() | Arguments    |

### Enqueue Styles and Scripts

With the WPScratch_Enqueue class you can enqueue the script and style and control page-wise loading

```php
( new WPScratch_Enqueue() )
	->style(
		'first-style',
		ASMTHRY_THEME_URL . 'assets/css/style.css'
	)->style(
		'second-style',
		ASMTHRY_THEME_URL . 'assets/css/page.css'
	)->except( 'home-page' )
	->style(
		'first-script',
		ASMTHRY_THEME_URL . 'assets/js/script.js'
	)->only( 'home-page' );
```

#### All Available Methods

#### 1) style - Enqueue Style

| Parameter     | Type   | Default            | Description          |
| ------------- | ------ | ------------------ | -------------------- |
| $id           | string |                    | Style Id             |
| $path         | string |                    | Path to the css file |
| $dependencies | array  | array()            | Dependencies         |
| $version      | string | WP_SCRATCH_VERSION | Version              |
| $media        | string | 'all'              | Media                |

#### 2) script - Enqueue Script

| Parameter     | Type   | Default            | Description           |
| ------------- | ------ | ------------------ | --------------------- |
| $id           | string |                    | Style Id              |
| $path         | string |                    | Path to the css file  |
| $dependencies | array  | array()            | Dependencies          |
| $version      | string | WP_SCRATCH_VERSION | Version               |
| $media        | string | 'all'              | Media                 |
| $in_footer    | bool   | true               | Load script in footer |
| $strategy     | string | null               | Strategy              |

#### 3) only - Enqueue Script/Style Only On Some Pages

| Parameter | Type   | Default | Description     |
| --------- | ------ | ------- | --------------- |
| $pages    | string | array   | Page slug or id |

#### 4) except - Enqueue Script/Style Except Some Pages

| Parameter | Type   | Default | Description     |
| --------- | ------ | ------- | --------------- |
| $pages    | string | array   | Page slug or id |

### Create customizer

```php
// Create customizer
( new WPScratch_Customizer() )
	->section( 'Contact Details' )
	->settings( 'Phone Number 1' )
	->section( 'Address' )
	->settings( 'Text Color' )
	->control( 'WP_Customize_Color_Control' )
	->settings( 'Address1', 'textarea' )
	->settings( 'Address 2' )
	->type( 'textarea' );

// Display customizer value
echo WPScratch_Customizer::get( 'Phone Number 1' );
```

#### All Available Methods

#### 1) section - Create New Customizer Section

| Parameter    | Type   | Default | Description                     |
| ------------ | ------ | ------- | ------------------------------- |
| $title       | string |         | Title of the customizer section |
| $description | string | ''      | Description                     |
| $priority    | int    | 70      | Priority                        |

#### 2) settings - Create Settings Section

| Parameter | Type   | Default | Description           |
| --------- | ------ | ------- | --------------------- |
| $title    | string |         | Title of the settings |
| $type     | string | 'text'  | Setting field type    |

#### 3) type - Change Settings Field Type

| Parameter | Type   | Default | Description        |
| --------- | ------ | ------- | ------------------ |
| $type     | string | 'text'  | Setting field type |

#### 4) control - Add Control

| Parameter | Type   | Default | Description        |
| --------- | ------ | ------- | ------------------ |
| $control  | string |         | Control class name |

#### 4) get - Get Settings Value

| Parameter | Type   | Default | Description   |
| --------- | ------ | ------- | ------------- |
| $settings | string |         | Settings name |

### Create custom post type

```php
( new WPScratch_Cpt( 'Blog' ) )
```

#### Filter post arguments and labels

If your post name is Blog, then the post slug will be blog.\
My Blog => my_blog

```php
function filter_post_arguments_values( $post_name, $post_slug ) {
	$array['supports'] = array( 'title', 'editor', 'thumbnail' );
	return $array;
}
add_filter( 'wpscratch_cpt_{Post Slug}', 'filter_post_arguments_values', 10, 2 );
```

#### All Available Methods

#### 1) set_name - Set Custom Post Type Name

| Parameter | Type   | Default | Description                   |
| --------- | ------ | ------- | ----------------------------- |
| $name     | string |         | Name of the custom post type. |

#### 2) set_show_ui - Set Custom Post Type UI

| Parameter | Type | Default | Description                        |
| --------- | ---- | ------- | ---------------------------------- |
| $status   | bool |         | This custom post type requires UI? |

#### 3) set_show_in_menu - Show Post In Side Menu

| Parameter | Type | Default | Description                            |
| --------- | ---- | ------- | -------------------------------------- |
| $status   | bool |         | Do we need to show the side menu item? |

#### 3) set_query_var - Set Argument query_var

| Parameter | Type | Default | Description |
| --------- | ---- | ------- | ----------- |
| $status   | bool |         | query_var   |

#### 4) set_rewrite - Set Argument rewrite

| Parameter | Type  | Default | Description |
| --------- | ----- | ------- | ----------- |
| $rewrite  | array |         | set_rewrite |

#### 5) set_labels - Set Argument labels

| Parameter | Type  | Default | Description |
| --------- | ----- | ------- | ----------- |
| $labels   | array |         | labels      |

#### 6) taxonomy - Create Taxonomy For This Custom Post Type

| Parameter | Type     | Default | Description              |
| --------- | -------- | ------- | ------------------------ |
| $name     | string   |         | Name of the taxonomy     |
| $fun      | callable | null    | Change taxonomy instance |

### Create Taxonomies

```php
( new WPScratch_Taxonomy( 'Options', 'Slide' ) );
// OR - Create post with some taxonomies
( new WPScratch_Cpt( 'Slide' ) )
	->taxonomy( 'Titles' )
	->taxonomy(
		'Stories',
		function ( $taxonomy ) {
			$taxonomy->set_name( 'Story' );
		}
	);
```

#### You can filter taxonomy arguments and labels.

```php
function change_taxonomy_arguments( $array ) {
	$array['show_in_menu'] = false;
	return $array;
}
add_filter( 'wpscratch_taxonomy_options', 'change_taxonomy_arguments', 10, 2 );
// OR
( new WPScratch_Taxonomy( 'Options', 'Slide' ) );
```

#### All Available Methods

#### 1) set_name - Set Taxonomy Name

| Parameter | Type   | Default | Description           |
| --------- | ------ | ------- | --------------------- |
| $name     | string |         | Name of the taxonomy. |

#### 2) set_show_in_rest - Set Argument show_in_rest

| Parameter | Type | Default | Description  |
| --------- | ---- | ------- | ------------ |
| $status   | bool |         | show_in_rest |

#### 3) set_show_admin_column - Set Argument show_admin_column

| Parameter | Type | Default | Description       |
| --------- | ---- | ------- | ----------------- |
| $status   | bool |         | show_admin_column |

#### 3) set_show_ui - Set Argument show_ui

| Parameter | Type | Default | Description |
| --------- | ---- | ------- | ----------- |
| $status   | bool |         | show_ui     |

#### 4) set_show_in_menu - Set Argument show_in_menu

| Parameter | Type | Default | Description  |
| --------- | ---- | ------- | ------------ |
| $status   | bool |         | show_in_menu |

#### 5) set_query_var - Set Argument query_var

| Parameter | Type | Default | Description |
| --------- | ---- | ------- | ----------- |
| $status   | bool |         | query_var   |

#### 6) set_rewrite - Set Argument rewrite

| Parameter | Type  | Default | Description |
| --------- | ----- | ------- | ----------- |
| $rewrite  | array |         | rewrite     |

#### 7) set_update_count_callback - Set Argument update_count_callback

| Parameter | Type   | Default | Description           |
| --------- | ------ | ------- | --------------------- |
| $name     | string |         | update_count_callback |

#### 8) set_labels - Set Argument labels

| Parameter | Type  | Default | Description |
| --------- | ----- | ------- | ----------- |
| $labels   | array |         | labels      |
