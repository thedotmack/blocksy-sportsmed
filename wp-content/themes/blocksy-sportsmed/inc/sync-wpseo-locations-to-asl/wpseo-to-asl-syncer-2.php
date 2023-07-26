<?php
/*
Plugin Name: WPSEO to ASL Syncer 2.0
Plugin URI: https://www.openai.com/
Description: An updated plugin to sync WPSEO Locations data with Agile Store Locator data.
Version: 2.0
Author: ChatGPT
Author URI: https://www.openai.com/
*/

function sync_location_to_asl($post_id) {
    global $wpdb;

    if (get_post_type($post_id) != 'wpseo_locations') return;

    $title = get_the_title($post_id);
    $address = get_post_meta($post_id, '_wpseo_business_address', true);
    $city = get_post_meta($post_id, '_wpseo_business_city', true);
    $state = get_post_meta($post_id, '_wpseo_business_state', true);
    $zipcode = get_post_meta($post_id, '_wpseo_business_zipcode', true);
    $phone = get_post_meta($post_id, '_wpseo_business_phone', true);
    $website = get_post_meta($post_id, '_wpseo_business_url', true);

    // Sync with ASL
    $table_name = $wpdb->prefix . 'asl_stores';
    $existing_store = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table_name} WHERE title = %s", $title));

    if ($existing_store) {
        // Update
        $wpdb->update($table_name, array(
            'street' => $address,
            'city' => $city,
            'state' => $state,
            'postal_code' => $zipcode,
            'phone' => $phone,
            'website' => $website
        ), array('id' => $existing_store->id));
        
        // Store ASL ID in WPSEO post meta
        update_post_meta($post_id, '_asl_store_id', $existing_store->id);
    } else {
        // Insert
        $wpdb->insert($table_name, array(
            'title' => $title,
            'street' => $address,
            'city' => $city,
            'state' => $state,
            'postal_code' => $zipcode,
            'phone' => $phone,
            'website' => $website
        ));
        
        // Store new ASL ID in WPSEO post meta
        update_post_meta($post_id, '_asl_store_id', $wpdb->insert_id);
    }
}
add_action('save_post', 'sync_location_to_asl');

function asl_syncer_menu() {
    add_submenu_page('edit.php?post_type=wpseo_locations', 'Sync All Locations', 'Sync All Locations', 'manage_options', 'sync-all-locations', 'sync_all_locations');
}
add_action('admin_menu', 'asl_syncer_menu');

function sync_all_locations() {
    $locations = get_posts(array(
        'post_type' => 'wpseo_locations',
        'numberposts' => -1
    ));

    foreach ($locations as $location) {
        sync_location_to_asl($location->ID);
    }

    echo '<div class="wrap">';
    echo '<h1>All Done!</h1>';
    echo '<p>All WPSEO Locations have been synced with Agile Store Locator.</p>';
    echo '</div>';
}
?>
