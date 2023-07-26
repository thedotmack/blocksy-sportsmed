
<?php
/*
Plugin Name: WPSEO to ASL Syncer 3.0
Plugin URI: https://www.openai.com/
Description: A plugin to sync WPSEO Locations data with Agile Store Locator data, with a clear preview and confirmation before syncing.
Version: 3.0
Author: ChatGPT
Author URI: https://www.openai.com/
*/

function add_admin_menu() {
    add_submenu_page('edit.php?post_type=wpseo_locations', 'Sync to ASL', 'Sync to ASL', 'manage_options', 'sync-to-asl', 'sync_to_asl_page');
}

function sync_to_asl_page() {
    global $wpdb;
    if (isset($_POST['confirm_sync']) && $_POST['confirm_sync'] == 'yes') {
        
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
        $data_to_insert = array(
            'title' => $title,
            'street' => $address,
            'city' => $city,
            'state' => $state,
            'postal_code' => $zipcode,
            'phone' => $phone,
            'website' => $website,
            'brand' => $brand,
            'special' => $special
        );
        if ($existing_store) {
            $wpdb->update($table_name, $data_to_insert, array('id' => $existing_store->id));
        } else {
            $wpdb->insert($table_name, $data_to_insert);
        }
    }
    
        // ...
        echo '<div class="notice notice-success is-dismissible"><p>Data Synced Successfully!</p></div>';
    } else if (isset($_POST['start_sync'])) {
        echo '<div class="wrap">';
        echo '<h1>Are you sure you want to sync?</h1>';
        echo '<form method="post">';
        echo '<input type="hidden" name="confirm_sync" value="yes">';
        echo '<input type="submit" value="Yes, Sync Now" class="button button-primary">';
        echo '</form>';
        echo '</div>';
        return;
    }
    
    // Rest of the code is for the preview
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
    echo '<th scope="col">ASL Title</th>';
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
    echo '<form method="post">';
    echo '<input type="hidden" name="start_sync" value="yes">';
    echo '<input type="submit" value="Start Sync" class="button button-primary">';
    echo '</form>';
    echo '</div>';
}

add_action('admin_menu', 'add_admin_menu');
?>

