<?php
if (!defined('WP_DEBUG')) {
  die('Direct access forbidden.');
}
add_action('wp_enqueue_scripts', function () {

  wp_enqueue_style('custom-agile-store-locator-tmpl-0', get_stylesheet_directory_uri() . '/tmpl-0-fixed.css');
  wp_enqueue_style('custom-agile-store-locator-sl-bootstrap', get_stylesheet_directory_uri() . '/sl-bootstrap.css');

  wp_enqueue_style('animate-css-style', get_stylesheet_directory_uri() . '/dist/animate.min.css');

  wp_enqueue_style('blocksy-parent-style', get_template_directory_uri() . '/style.css');
  if (is_front_page() || is_page('get-started-now')) {
    wp_enqueue_style('blocksy-child-style', get_stylesheet_directory_uri() . '/dist/tailwind.min.css?cachebuster=3', array('custom-agile-store-locator-tmpl-0', 'custom-agile-store-locator-sl-bootstrap'));
  } else {
    wp_enqueue_style('blocksy-child-style', get_stylesheet_directory_uri() . '/dist/tailwind.min.css?cachebuster=3');
  }

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



function load_my_gutenberg_assets()
{
  wp_enqueue_style('editor_style_blocksy-parent', get_template_directory_uri() . '/style.css');
  wp_enqueue_style('editor_style_blocksy-child-other', get_stylesheet_directory_uri() . '/dist/tailwind.min.css');
  wp_enqueue_script('editor_style_child-main-js', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), '1.0.3', false);
  wp_enqueue_style('editor_style_swiperjs', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css');
  wp_enqueue_script('editor_style_swiperjs-script', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), '', false);
}

add_action('enqueue_block_editor_assets', 'load_my_gutenberg_assets');


include_once('inc/sync-wpseo-locations-to-asl/wpseo-to-asl-syncer-v5.php');

function get_wpseo_locations_count($exclude_category = '')
{
  $post_type = 'wpseo_locations';

  $args = array(
    'post_type' => $post_type,
    'post_status' => 'publish',
    'posts_per_page' => -1,
  );

  // If an exclude category is provided, add a tax_query to the arguments
  if (!empty($exclude_category)) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'wpseo_locations_category', // change this if you're using a custom taxonomy
        'field'    => 'slug',
        'terms'    => $exclude_category,
        'operator' => 'NOT IN'
      ),
    );
  }

  $query = new WP_Query($args);

  if ($query->have_posts()) {
    return $query->found_posts;
  }

  return 0;
}

function wpseo_locations_count_shortcode($atts)
{
  // Extract attributes from the shortcode
  $attributes = shortcode_atts(
    array(
      'exclude_category' => '',  // Default value is an empty string
    ),
    $atts
  );

  return get_wpseo_locations_count($attributes['exclude_category']);
}
add_shortcode('total_locations', 'wpseo_locations_count_shortcode');



function wpb_custom_image_sizes($size_names)
{
  $new_sizes = array(
    'staff_portrait' => 'Staff Portrait',
  );
  return array_merge($size_names, $new_sizes);
}
add_filter('image_size_names_choose', 'wpb_custom_image_sizes');


function sportsmed_callrail_tracking()
{ ?>
  <script type="text/javascript" src="//cdn.callrail.com/group/163151525/73e9242b75d65efe233d001d/12/swap.js"></script>
<?php }
add_action('wp_footer', 'sportsmed_callrail_tracking');


// function hide_admin_bar_for_specific_page()
// {
//   if (is_page('get-started-now-full-screen')) {
//     return false;
//   }
//   return true;
// }
// add_filter('show_admin_bar', 'hide_admin_bar_for_specific_page');

/* Tracking stuff 


  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-KLXT56');
  </script>
  <!-- End Google Tag Manager -->


  */

add_action('wp_body_open', 'add_page_loader');
function add_page_loader()
{ ?>
  <script>
    jQuery(document).ready(function($) {
      setTimeout(function() {
        $("#sportsmed_page_loader").fadeOut(166, function() {
          $(this).remove();
        });
      }, 333);
    });
  </script>
  <div id="sportsmed_page_loader" class="fixed z-[100] flex bg-white w-[100vw] h-[100vh] p-28 !max-w-full items-center justify-center">
    <div>
      <svg id="Layer_2" class="sportsmed-dancer -ml-[10%] -mt-[10%] animate-pulse h-60 max-w-full" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 481.63 295.4">
        <defs>
          <style>
            .cls-1 {
              fill: url(#linear-gradient);
            }

            .cls-1,
            .cls-2,
            .cls-3,
            .cls-4,
            .cls-5,
            .cls-6,
            .cls-7 {
              stroke-width: 0px;
            }

            .cls-2 {
              fill: url(#linear-gradient-4);
            }

            .cls-3 {
              fill: url(#linear-gradient-2);
            }

            .cls-4 {
              fill: url(#linear-gradient-3);
            }

            .cls-5 {
              fill: url(#linear-gradient-7);
            }

            .cls-6 {
              fill: url(#linear-gradient-5);
            }

            .cls-7 {
              fill: url(#linear-gradient-6);
            }
          </style>
          <!-- Gradient 1 -->
          <linearGradient id="linear-gradient" x1="294.63" y1="32.77" x2="368.68" y2="32.77" gradientTransform="translate(82.39 -188.44) rotate(35.95)" gradientUnits="userSpaceOnUse">
            <stop offset="0" stop-color="#002760">
              <animate attributeName="stop-color" values="#002760; #1396c9; #002760" dur="5s" repeatCount="indefinite" />
            </stop>
            <stop offset="1" stop-color="#1396c9">
              <animate attributeName="stop-color" values="#1396c9; #002760; #1396c9" dur="5s" repeatCount="indefinite" />
            </stop>
          </linearGradient>
          <!-- Gradient 2 -->
          <linearGradient id="linear-gradient-2" x1="0" y1="188.27" x2="481.63" y2="188.27" gradientTransform="matrix(1,0,0,1,0,0)" xlink:href="#linear-gradient">
            <!-- Animation will be inherited from gradient 1 -->
          </linearGradient>
          <!-- Gradient 3 -->
          <linearGradient id="linear-gradient-3" x1="91.48" y1="128.35" x2="391.04" y2="128.35" gradientTransform="matrix(1,0,0,1,0,0)" xlink:href="#linear-gradient">
            <!-- Animation will be inherited from gradient 1 -->
          </linearGradient>
          <!-- Gradient 4 -->
          <linearGradient id="linear-gradient-4" x1="0" y1="219.42" x2="333.15" y2="219.42" gradientTransform="matrix(1,0,0,1,0,0)" xlink:href="#linear-gradient">
            <!-- Animation will be inherited from gradient 1 -->
          </linearGradient>
          <!-- Gradient 5 -->
          <linearGradient id="linear-gradient-5" x1="333.15" y1="146.86" x2="333.7" y2="146.86" gradientTransform="matrix(1,0,0,1,0,0)" xlink:href="#linear-gradient">
            <!-- Animation will be inherited from gradient 1 -->
          </linearGradient>
          <!-- Gradient 6 -->
          <linearGradient id="linear-gradient-6" x1="225.2" y1="115.01" x2="481.23" y2="115.01" gradientTransform="matrix(1,0,0,1,0,0)" xlink:href="#linear-gradient">
            <!-- Animation will be inherited from gradient 1 -->
          </linearGradient>
          <!-- Gradient 7 -->
          <linearGradient id="linear-gradient-7" x1="172.4" y1="209.88" x2="479.66" y2="209.88" gradientUnits="userSpaceOnUse">
            <stop offset="0" stop-color="#01417b">
              <animate attributeName="stop-color" values="#01417b; #018ec5; #01417b" dur="5s" repeatCount="indefinite" />
            </stop>
            <stop offset="1" stop-color="#018ec5">
              <animate attributeName="stop-color" values="#018ec5; #01417b; #018ec5" dur="5s" repeatCount="indefinite" />
            </stop>
          </linearGradient>
        </defs>
        <!-- Rest of your SVG content -->

        <g id="Layer_1-2" data-name="Layer 1">
          <g>
            <ellipse class="cls-1" cx="331.65" cy="32.77" rx="41.21" ry="27.31" transform="translate(43.92 200.93) rotate(-35.95)" />
            <g id="dgiRrA.tif">
              <path class="cls-3" d="m0,274.67c8.87,1.1,17.74,2.15,26.6,3.32,15.68,2.06,31.13.93,46.26-3.62,22.01-6.61,40.25-19.62,57.3-34.49,21.25-18.53,40.06-39.51,59.54-59.8,11.19-11.66,22.89-22.78,34.43-34.08.19-.18.22-.53.42-1.05-45.99,3.91-90.82,12.35-133.47,30.6-.2-.4-.4-.8-.59-1.19,6.44-5.29,12.73-10.79,19.35-15.85,30.15-23.05,63.07-40.79,98.83-53.82,48.2-17.56,97.88-25.01,148.85-23.3,41.21,1.38,80.97,9.63,116.74,31.76,2.12,1.31,4.14,2.79,6.17,4.23.35.25.52.74,1.23,1.8-30.8-6.99-60.91-6.94-90.88.94-20.88,5.49-40.11,14.71-59.03,26.32,6.8,1.26,13.05,2.28,19.23,3.59,34.38,7.28,66.56,19.53,93.93,42.35,13.83,11.53,25.31,25.06,33.63,41.11.8,1.55,2.2,2.97,1.74,5.46-9.47-7.71-19.34-14.33-29.99-19.75-34.24-17.43-70.45-23.27-108.5-18.75-33.94,4.02-64.82,16.74-94.78,32.43-15.9,8.32-31.09,17.87-46.97,26.2-13.9,7.28-27.62,14.86-42.35,20.51-11.41,4.37-22.75,8.83-34.7,11.36-42.74,9.06-83.86,4.63-122.96-16.27Z" />
            </g>
            <path class="cls-4" d="m225.55,144.95s61.84-66.1,165.5-60.86c-10.71-1.47-21.57-2.33-32.54-2.7-50.96-1.71-100.65,5.74-148.85,23.3-35.75,13.03-68.68,30.77-98.83,53.82-6.62,5.06-12.91,10.55-19.35,15.85.2.4.4.8.59,1.19,42.65-18.26,87.47-26.69,133.47-30.6Z" />
            <g>
              <path class="cls-2" d="m224.55,144.95c-.2.53-.23.87-.42,1.05-11.54,11.29-23.24,22.42-34.43,34.08-19.48,20.29-38.3,41.27-59.54,59.8-17.05,14.87-35.29,27.88-57.3,34.49-15.13,4.55-30.57,5.68-46.26,3.62-8.86-1.17-17.73-2.21-26.6-3.32,39.1,20.91,80.22,25.33,122.96,16.27,11.95-2.53,23.29-7,34.7-11.36,5.26-2.01,10.39-4.28,15.45-6.69.49-.31.97-.61,1.46-.92,24-15,52.04-35.7,74-57,29.99-29.08,78.71-64.86,84.58-68.06-45.81-6.44-108.61-1.97-108.61-1.97Z" />
              <path class="cls-6" d="m333.7,146.8c-.08-.01-.16-.03-.24-.04-.09.04-.19.09-.31.16.14.02.28.04.42.06.06-.07.11-.13.13-.17Z" />
            </g>
            <path class="cls-7" d="m333.07,146.41c-.59-.11-1.16-.21-1.75-.32,18.92-11.61,38.15-20.83,59.03-26.32,29.96-7.88,60.08-7.93,90.88-.94-.71-1.06-.88-1.55-1.23-1.8-2.03-1.45-4.05-2.92-6.17-4.23-26.37-16.32-54.92-25.08-84.61-29.12-100.92-4.49-161.82,58.53-164.02,60.84,8.43-.55,65.23-3.91,107.54,2.04.12-.07.23-.12.31-.16h.01Z" />
            <path class="cls-5" d="m444.19,192.42c-27.36-22.82-59.54-35.07-93.93-42.35-5.58-1.18-11.22-2.13-17.26-3.23-.03.04-.07.1-.13.17-.14-.02-.28-.04-.42-.06-5.87,3.2-54.59,38.98-84.58,68.06-21.96,21.3-50,42-74,57-.49.31-.97.61-1.46.92,0,0,0,0-.01,0,9.11-4.34,17.98-9.14,26.91-13.82,15.88-8.32,31.08-17.87,46.97-26.2,29.96-15.69,60.84-28.41,94.78-32.43,38.05-4.51,74.27,1.32,108.5,18.75,10.65,5.42,20.52,12.04,29.99,19.75.46-2.49-.93-3.91-1.74-5.46-8.33-16.05-19.81-29.58-33.63-41.11Z" />
          </g>
        </g>
      </svg>
    </div>
  </div>
<?php }
