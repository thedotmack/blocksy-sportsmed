<?php

/**
 * Service Locations Map Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Support custom "anchor" values.
$anchor = '';
if (!empty($block['anchor'])) {
  $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'related-services-block';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

global $wpdb;

// Step 1: Prepare the wpseo_locations_ids
$service_locations = get_field('service_locations', $post_id) ?: 'Service Locations List';

foreach ($service_locations as $service_location) {
  $wpseo_locations_ids[] = $service_location->ID;
}

$asl_stores_ids = array(); // Array to store the corresponding wp_asl_stores IDs

// Loop through the wpseo_locations_ids
foreach ($wpseo_locations_ids as $wpseo_locations_id) {
  // Creating the specific pattern to search
  $pattern = '{"wpseo_locations_id":"' . $wpseo_locations_id . '"';

  // Preparing the SQL query to find a match within the custom field
  $query = $wpdb->prepare("SELECT id FROM {$wpdb->prefix}asl_stores WHERE custom LIKE %s", '%' . $wpdb->esc_like($pattern) . '%');

  // Execute the Query
  $results = $wpdb->get_results($query);

  // Handle the Result
  if ($results) {
    foreach ($results as $result) {
      $asl_stores_ids[] = $result->id; // Storing the corresponding wp_asl_stores ID
    }
  } else {
    echo "No matching records found for wpseo_locations_id: $wpseo_locations_id.<br>";
  }
}
?>

<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
  <?php echo do_shortcode('[ASL_STORELOCATOR icon_size="30x48" stores="'. implode(',', $asl_stores_ids) .'"]'); ?>
</div> 