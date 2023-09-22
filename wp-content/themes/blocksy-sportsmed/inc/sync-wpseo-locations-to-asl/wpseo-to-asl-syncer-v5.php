<?php
// Prevent direct access
if (!defined('ABSPATH')) {
  exit;
}

function add_sync_submenu()
{
  add_submenu_page(
    'edit.php?post_type=wpseo_locations',
    'Sync Locations to CSV',
    'Sync to CSV',
    'manage_options',
    'sync-wpseo-to-csv',
    'sync_wpseo_to_csv_callback'
  );
}
add_action('admin_menu', 'add_sync_submenu');

function sync_wpseo_to_csv_callback()
{
  // Check user permissions
  if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
  }

  // Export the data
  export_wpseo_to_asl_csv();
  exit;
}

function export_wpseo_to_asl_csv()
{
  global $wpdb;

  // Clean any output buffers
  ob_end_clean();

  // Set headers
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename=wpseo-locations-export.csv');

  $output = fopen('php://output', 'w');

  // Column headers
  fputcsv($output, array(
    'title', 'description', 'street', 'city', 'state', 'postal_code', 'country',
    'lat', 'lng', 'phone', 'fax', 'email', 'website', 'description_2',
    'marker_id', 'is_disabled', 'open_hours', 'brand', 'special',
    'slug', 'lang', 'pending', 'updated_on', 'logo_name', 'categories',
    'order', 'update_id', 'wpseo_locations_id', 'featured_image_url'
  ));

  // Get all wpseo_locations posts
  $locations = get_posts([
    'post_type' => 'wpseo_locations',
    'numberposts' => -1
  ]);

  foreach ($locations as $post) {
    // Fetch meta data for the location
    $address = get_post_meta($post->ID, '_wpseo_business_address', true);
    $city = get_post_meta($post->ID, '_wpseo_business_city', true);
    $phone = get_post_meta($post->ID, '_wpseo_business_phone', true);
    $state = get_post_meta($post->ID, '_wpseo_business_state', true);
    $url = get_permalink($post->ID);
    $zipcode = get_post_meta($post->ID, '_wpseo_business_zipcode', true);
    $lat = get_post_meta($post->ID, '_wpseo_coordinates_lat', true);
    $lng = get_post_meta($post->ID, '_wpseo_coordinates_long', true);

    $featured_image_url = get_the_post_thumbnail_url($post->ID, 'medium');

    // Fetch categories associated with this post
    $categories = get_the_terms($post->ID, 'wpseo_locations_category');
    $parent_category = '';
    $child_category = '';
    if ($categories && !is_wp_error($categories)) {
      foreach ($categories as $category) {
        if ($category->parent == 0) {
          $parent_category = $category->name;
        } else {
          $child_category = $category->name;
        }
      }
    }

    // Construct the opening hours array
    $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
    $opening_hours = [];
    foreach ($days as $day) {
      $from = get_post_meta($post->ID, "_wpseo_opening_hours_{$day}_from", true);
      $to = get_post_meta($post->ID, "_wpseo_opening_hours_{$day}_to", true);
      $opening_hours_str = $from ? "{$from}-{$to}" : "0";
      $opening_hours[] = "{$day}={$opening_hours_str}";
    }

    // Generate slug
    $city_slug = str_replace(' ', '-', strtolower($city));
    $slug = "{$city_slug}-{$state}-{$city_slug}";

    // Try to get the asl_store_id from post meta first
    $asl_store_id = get_post_meta($post->ID, '_asl_store_id', true);

    // If not found in post meta, try to fetch from the asl_stores table
    if (!$asl_store_id) {
      $store = $wpdb->get_row($wpdb->prepare(
        "SELECT id FROM {$wpdb->prefix}asl_stores WHERE title = %s LIMIT 1",
        $post->post_title
      ));

      if ($store) {
        $asl_store_id = $store->id;

        // Store this ID in post meta for future reference
        update_post_meta($post->ID, '_asl_store_id', $asl_store_id);
      }
    }

    // Create the CSV row
    $row = [
      $post->post_title,
      $post->post_content,
      $address,
      $city,
      $state,
      sprintf('%05d', $zipcode),
      "United States",
      $lat,
      $lng,
      $phone,
      "", "", $url, "", 1, 0,
      implode('|', $opening_hours),
      $parent_category, $child_category, $slug, "", "",
      "", "", "", "", $asl_store_id, $post->ID, $featured_image_url
    ];

    // Output row to the CSV
    fputcsv($output, $row);
  }

  fclose($output);
  exit;
}
