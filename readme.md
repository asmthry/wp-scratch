## WP Scratch

This plugin will help you reduce your coding effort.

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
