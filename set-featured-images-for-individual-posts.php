<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 *  Set featured images for individual posts Plugin is show Set featured images for individual posts as full, large, medium, thumbnail size.
 *  Add Featured Images or Post Thumbnails in the content area.
 *
 * @package Set featured images for individual posts
 * @author Pakainfo
 * @license GPLv2
 * @link https://www.pakainfo.com/
 * @copyright 2019 Pakainfo, LLC. All rights reserved.
 *
 *            @wordpress-plugin
 *            Plugin Name: Set featured images for individual posts
 *            Plugin URI: https://www.pakainfo.com/set-featured-images-for-individual-posts
 *            Description: Set featured images for individual posts Plugin is show Set featured images for individual posts as full, large, medium, thumbnail size. Add Featured Images or Post Thumbnails in the content area.
 			  Tags: post image, post pictures, thumbnail image, featured photos, pic blogs, thumbnail pictures, featured image, image content
 *            Version: 1.0
 *            Author: Pakainfo
 *            Author URI: https://www.pakainfo.com/
 *            Text Domain: set-featured-images-for-individual-posts
 *            Contributors: Pakainfo
 *            License: GPLv2
 *            License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Adding Submenu under Settings Tab
 *
 * @since 1.0
 */
function featured_image_add_menu() {
	add_submenu_page ( "options-general.php", "Featured Image", "Featured Image", "manage_options", "set-featured-images-into-post", "featured_image_settings_page" );
}
add_action ( "admin_menu", "featured_image_add_menu" );
 
/**
 * Setting Page Options
 * - add setting page
 * - save setting page
 *
 * @since 1.0
 */
function featured_image_settings_page() {
	?>
<div class="wrap">
	
	<h1>
		Featured Image in Single Post : <a
			href="https://www.pakainfo.com/" target="_blank">Pakainfo</a>
	</h1><br/><br/>
 	<div class="postbox" style="width: 65%; padding: 30px;">
	<form method="post" action="options.php">
            <?php
	settings_fields ( "featured_images_into_post_config" );
	do_settings_sections ( "set-featured-images-into-post" );
	submit_button ();
	?>
    </form>
	</div>
</div>
 
<?php
}
 
/**
 * Init setting section, Init setting field and register settings page
 *
 * @since 1.0
 */
function featured_images_into_post_settings() {
	add_settings_section ( "featured_images_into_post_config", "", null, "set-featured-images-into-post" );
	add_settings_field ( "set-featured-images-into-post-text", "Featured Image Settings size", "featured_images_options", "set-featured-images-into-post", "featured_images_into_post_config" );
	register_setting ( "featured_images_into_post_config", "set-featured-images-into-post-text" );
}
add_action ( "admin_init", "featured_images_into_post_settings" );
 
/**
 * Add simple selected value to setting page
 *
 * @since 1.0
 */
function featured_images_options() {
	?>

	<?php
	$selected_futured_image = stripslashes_deep ( esc_attr ( get_option ( 'set-featured-images-into-post-text' ) ) );
	?>
	<select name="set-featured-images-into-post-text">
		<option <?php if($selected_futured_image=='thumbnail'){ ?> selected <?php }?> value="thumbnail">Thumbnail</option>
		<option <?php if($selected_futured_image=='medium'){ ?> selected <?php }?> value="medium">Medium</option>
		<option <?php if($selected_futured_image=='large'){ ?> selected <?php }?> value="large">Large</option>
		<option <?php if($selected_futured_image=='full'){ ?> selected <?php }?> value="full">Full</option>
	</select>
<?php
}
 
/**
 * Append saved selected value to each post
 *
 * @since 1.0
 */
add_filter( 'the_content', 'featured_image_in_content_add_to_content' );
function featured_image_in_content_add_to_content( $content ) {
	$selected_futured_image = stripslashes_deep ( esc_attr ( get_option ( 'set-featured-images-into-post-text' ) ) );
	if ( is_singular() && has_post_thumbnail() ) {
		return get_the_post_thumbnail( null, $selected_futured_image ) . $content;
	} else {
		return $content;
	}
}
