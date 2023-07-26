
<?php
/*
Plugin Name: WPSEO to ASL Syncer 2.5
Plugin URI: https://www.openai.com/
Description: A plugin to sync WPSEO Locations data with Agile Store Locator data, includes a concise dry run preview with detailed columns and syncs brand and special fields.
Version: 2.5
Author: ChatGPT
Author URI: https://www.openai.com/
*/

// ... [Rest of the functions remain unchanged] ...

function preview_sync_data() {
    global $wpdb;
    $locations = get_posts(array(
        'post_type' => 'wpseo_locations',
        'numberposts' => -1
    ));
    $table_name = $wpdb->prefix . 'asl_stores';
    echo '<div class="wrap">';
    echo '<h1>Preview Sync Data</h1>';
    echo '<p>This is a dry run. No data will be modified.</p>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">WPSEO Title</th>';
    echo '<th scope="col">ASL Title (if matched)</th>';
    echo '<th scope="col">Address</th>';
    echo '<th scope="col">City</th>';
    echo '<th scope="col">State</th>';
    echo '<th scope="col">Zipcode</th>';
    echo '<th scope="col">Phone</th>';
    echo '<th scope="col">Website</th>';
    echo '<th scope="col">Brand</th>';
    echo '<th scope="col">Special</th>';
    echo '<th scope="col">Status</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($locations as $location) {
        $title = get_the_title($location->ID);
        $address = get_post_meta($location->ID, '_wpseo_business_address', true);
        $city = get_post_meta($location->ID, '_wpseo_business_city', true);
        $state = get_post_meta($location->ID, '_wpseo_business_state', true);
        $zipcode = get_post_meta($location->ID, '_wpseo_business_zipcode', true);
        $phone = get_post_meta($location->ID, '_wpseo_business_phone', true);
        $website = get_post_meta($location->ID, '_wpseo_business_url', true);
        $terms = wp_get_post_terms($location->ID, 'wpseo_locations_category');
        $brand = '';
        $special = '';
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                if ($term->parent == 0) {
                    $brand = $term->name;
                } else {
                    $special = $term->name;
                }
            }
        }
        $existing_store = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table_name} WHERE title = %s", $title));
        echo '<tr>';
        echo '<td>' . $title . '</td>';
        echo '<td>' . ($existing_store ? $existing_store->title : 'N/A') . '</td>';
        echo '<td>' . $address . '</td>';
        echo '<td>' . $city . '</td>';
        echo '<td>' . $state . '</td>';
        echo '<td>' . $zipcode . '</td>';
        echo '<td>' . $phone . '</td>';
        echo '<td>' . $website . '</td>';
        echo '<td>' . $brand . '</td>';
        echo '<td>' . $special . '</td>';
        echo '<td>';
        if ($existing_store) {
            echo 'Data will be updated in ASL stores.';
        } else {
            echo 'New entry will be created in ASL stores.';
        }
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}
?>

