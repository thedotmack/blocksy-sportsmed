<?php
/*
Plugin Name: WPSEO to ASL Syncer 2.1
Plugin URI: https://www.openai.com/
Description: An updated plugin to sync WPSEO Locations data with Agile Store Locator data and includes a dry run preview.
Version: 2.1
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

function asl_sync_preview_menu() {
    add_submenu_page('edit.php?post_type=wpseo_locations', 'Preview Sync', 'Preview Sync', 'manage_options', 'preview-sync', 'preview_sync_data');
}
add_action('admin_menu', 'asl_sync_preview_menu');

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
    echo '<th scope="col">WPSEO Fields</th>';
    echo '<th scope="col">ASL Fields to be Synced</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($locations as $location) {
        $title = get_the_title($location->ID);
        $existing_store = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table_name} WHERE title = %s", $title));

        echo '<tr>';
        echo '<td>' . $title . '</td>';
        echo '<td>' . ($existing_store ? $existing_store->title : 'N/A') . '</td>';
        echo '<td><pre>';
        print_r(get_post_custom($location->ID));
        echo '</pre></td>';
        echo '<td><pre>';
        if ($existing_store) {
            print_r((array) $existing_store);
        } else {
            echo 'New entry will be created in ASL stores.';
        }
        echo '</pre></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}
?>

