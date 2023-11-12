## WP Scratch

This plugin will help you reduce your coding effort.

### Add Theme Support To Your Theme.

```php
WPScratch_Theme_Support::add( 'title-tag' );
```

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

### Create customizer
```php
( new WPScratch_Customizer() )
	->section( 'Contact Details' )
	->settings( 'Phone Number 1' )
	->settings( 'Text Color' )
	->control( 'WP_Customize_Color_Control' )
	->settings( 'Address1', 'textarea' )
	->settings( 'Address 2' )
	->type( 'textarea' );
```

### Create custom post type

```php
WPScratch_Cpt::init( 'Blog' )->create();
```

#### Filter post arguments and labels

If your post name is Blog, then the post slug will be blog.\
My Blog => my_blog

```php
function filter_post_arguments_values( $post_name, $post_slug ) {
	$array['supports'] = array( 'title', 'editor', 'thumbnail' );
	return $array;
}
add_filter( 'asmthry_cpt_{Post Slug}', 'filter_post_arguments_values', 10, 2 );
// OR
WPScratch_Cpt::filter(
	'Blog',
	function ( $args ) {
		$array['supports'] = array( 'title', 'editor', 'thumbnail' );
		return $args;
	}
);
```
