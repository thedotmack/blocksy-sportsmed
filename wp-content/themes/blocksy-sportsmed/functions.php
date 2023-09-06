<?php
if (!defined('WP_DEBUG')) {
  die('Direct access forbidden.');
}
add_action('wp_enqueue_scripts', function () {
  
  wp_enqueue_style('custom-agile-store-locator-tmpl-0', get_stylesheet_directory_uri() . '/tmpl-0-fixed.css');
  wp_enqueue_style('custom-agile-store-locator-sl-bootstrap', get_stylesheet_directory_uri() . '/sl-bootstrap.css');

  wp_enqueue_style('blocksy-parent-style', get_template_directory_uri() . '/style.css');
  if (is_front_page() || is_page('get-started-now')) {
    wp_enqueue_style('blocksy-child-style', get_stylesheet_directory_uri() . '/dist/tailwind.min.css', array('custom-agile-store-locator-tmpl-0','custom-agile-store-locator-sl-bootstrap'));
  } else {
    wp_enqueue_style('blocksy-child-style', get_stylesheet_directory_uri() . '/dist/tailwind.min.css');
  }
  wp_enqueue_script('pivot-js', get_stylesheet_directory_uri() . '/js/pivot.js', array('jquery'), '1.0.5', false);
  wp_enqueue_script('child-main-js', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), '1.0.5', false);
}, 100);



add_action('init', 'register_acf_blocks');
function register_acf_blocks()
{
  register_block_type(__DIR__ . '/blocks/related-services');
  register_block_type(__DIR__ . '/blocks/location-staff');
  register_block_type(__DIR__ . '/blocks/acf-gallery-carousel');
  register_block_type(__DIR__ . '/blocks/service-locations');
  register_block_type(__DIR__ . '/blocks/service-locations-map');
}


function enqueue_swiperjs_scripts()
{
  wp_enqueue_style('swiperjs', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css');
  wp_enqueue_script('swiperjs', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), '', false);
}
add_action('wp_enqueue_scripts', 'enqueue_swiperjs_scripts');



function load_my_gutenberg_assets() {
  wp_enqueue_style('editor_style_blocksy-parent', get_template_directory_uri() . '/style.css');
  wp_enqueue_style('editor_style_blocksy-child-other', get_stylesheet_directory_uri() . '/dist/tailwind.min.css');
  wp_enqueue_script('editor_style_child-main-js', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), '1.0.3', false);
  wp_enqueue_style('editor_style_swiperjs', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css');
  wp_enqueue_script('editor_style_swiperjs-script', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), '', false);
}

add_action('enqueue_block_editor_assets', 'load_my_gutenberg_assets');


include_once('inc/sync-wpseo-locations-to-asl/wpseo-to-asl-syncer-v5.php');

function get_wpseo_locations_count() {
  $post_type = 'wpseo_locations';

  $args = array(
      'post_type' => $post_type,
      'post_status' => 'publish',
      'posts_per_page' => -1,
  );

  $query = new WP_Query($args);

  if ($query->have_posts()) {
      return $query->found_posts;
  }

  return 0;
}

// Step 3: Create the shortcode
function wpseo_locations_count_shortcode() {
  return get_wpseo_locations_count();
}
add_shortcode('total_locations', 'wpseo_locations_count_shortcode');




function wpb_custom_image_sizes( $size_names ) {
    $new_sizes = array(
        'staff_portrait' => 'Staff Portrait', 
    );
    return array_merge( $size_names, $new_sizes );
}
add_filter( 'image_size_names_choose', 'wpb_custom_image_sizes' );
