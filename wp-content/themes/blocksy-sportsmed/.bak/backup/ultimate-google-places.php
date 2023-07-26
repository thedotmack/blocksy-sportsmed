<?php

function google_places_reviews($google_place_id)
{
  if ($google_place_id != '') {
    $url = 'https://maps.googleapis.com/maps/api/place/details/json?place_id=' . $google_place_id . '&fields=rating,user_ratings_total&key=AIzaSyC8CiBVNeMwe0x7UVQlJ8TUmG7GYjbD_zE';
    $response = wp_remote_get(esc_url_raw($url));
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    if (!is_wp_error($data)) {
      if (isset($data->result)) {
        $rating = isset($data->result->rating) ? $data->result->rating : 'N/A';
        $reviews = isset($data->result->user_ratings_total) ? $data->result->user_ratings_total : 'N/A';

        $full_stars = floor($rating);
        $half_stars = $rating - $full_stars > 0 ? 1 : 0;

        $star_output = '';
        for ($i = 0; $i < $full_stars; $i++) {
          $star_output .= '<img src="' . get_stylesheet_directory_uri() . '/images/star.svg" alt="Full Star">';
        }
        for ($i = 0; $i < $half_stars; $i++) {
          $star_output .= '<img src="' . get_stylesheet_directory_uri() . '/images/star-half.svg" alt="Half Star">';
        }
        return $star_output . ' - Reviews: ' . $reviews;
      } else {
        return 'No data available for this place.';
      }
    } else {
      return 'Error occurred: ' . $data->get_error_message();
    }
  } else {
    return 'No Place ID provided.';
  }
}




function google_places_reviews_content($google_place_id)
{
  if ($google_place_id != '') {
    $url = 'https://maps.googleapis.com/maps/api/place/details/json?place_id=' . $google_place_id . '&fields=reviews&key=AIzaSyC8CiBVNeMwe0x7UVQlJ8TUmG7GYjbD_zE';
    $response = wp_remote_get(esc_url_raw($url));
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    if (!is_wp_error($data)) {
      if (isset($data->result)) {
        $reviews = isset($data->result->reviews) ? $data->result->reviews : array();

        $reviews_output = '';
        foreach ($reviews as $review) {
          $reviews_output .= '<div>';
          $reviews_output .= '<p>Author: ' . $review->author_name . '</p>';
          $reviews_output .= '<p>Rating: ' . $review->rating . '</p>';
          $reviews_output .= '<p>Review: ' . $review->text . '</p>';
          $reviews_output .= '</div>';
        }

        return $reviews_output;
      } else {
        return 'No data available for this place.';
      }
    } else {
      return 'Error occurred: ' . $data->get_error_message();
    }
  } else {
    return 'No Place ID provided.';
  }
}

// Function to retrieve the location data from post meta
function get_location_post_meta($post_id)
{
  // Check if we already have the data
  $place_details = get_post_meta($post_id, 'google_place_details', true);

  if (!empty($place_details)) {
    return $place_details;
  } else {
    return false;
  }
}

// Function to update the location data in post meta
function update_location_post_meta($post_id)
{
  // Get the Google Place ID for the location post
  $google_place_id = get_post_meta($post_id, 'google_place_id', true);

  // Use Google Places API to get place details
  if ($google_place_id != '') {
    $url = 'https://maps.googleapis.com/maps/api/place/details/json?place_id=' . $google_place_id . '&fields=address_component,adr_address,formatted_address,geometry,icon,name,permanently_closed,place_id,plus_code,types,url,utc_offset,vicinity,website,rating,user_ratings_total&key=AIzaSyC8CiBVNeMwe0x7UVQlJ8TUmG7GYjbD_zE';
    $response = wp_remote_get(esc_url_raw($url));
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    // If no errors, update post meta
    if (!is_wp_error($data) && isset($data->result)) {
      update_post_meta($post_id, 'google_place_details', $data->result);
      return $data->result;
    }
  }

  // Return false if we couldn't update the data
  return false;
}

function google_places_photos($google_place_id, $post_id)
{
  if ($google_place_id != '') {
    $url = 'https://maps.googleapis.com/maps/api/place/details/json?place_id=' . $google_place_id . '&fields=photos&key=AIzaSyC8CiBVNeMwe0x7UVQlJ8TUmG7GYjbD_zE';
    $response = wp_remote_get(esc_url_raw($url));
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    if (!is_wp_error($data)) {
      if (isset($data->result)) {
        $photos = isset($data->result->photos) ? $data->result->photos : [];
        $image_urls = [];
        foreach ($photos as $photo) {
          $photo_reference = $photo->photo_reference;
          $image_url = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=2048&photo_reference=' . $photo_reference . '&key=AIzaSyC8CiBVNeMwe0x7UVQlJ8TUmG7GYjbD_zE';
          $image_urls[] = $image_url;
        }
        // Store the photo URLs in post meta
        update_post_meta($post_id, 'google_place_photos', $image_urls);
        return $image_urls;
      } else {
        return 'No data available for this place.';
      }
    } else {
      return 'Error occurred: ' . $data->get_error_message();
    }
  } else {
    return 'No Place ID provided.';
  }
}

// Add the meta box
add_action('add_meta_boxes', 'add_location_photos_meta_box');

function add_location_photos_meta_box()
{
  add_meta_box(
    'location_photos_meta_box', // id
    'Location Photos', // title
    'location_photos_meta_box_cb', // callback
    'wpseo_locations', // post type
    'side', // context
    'default' // priority
  );
}



function location_photos_meta_box_cb($post)
{
  wp_nonce_field('save_primary_photo', 'primary_photo_nonce');

  // Retrieve the array of photos
  $photos = get_post_meta($post->ID, 'google_place_photos', true);

  // Retrieve the primary photo URL
  $primary_photo_url = get_post_meta($post->ID, 'primary_photo_url', true);

  // Check if photos are not empty
  if (!empty($photos)) {
    echo '<div style="display: flex; flex-wrap: wrap;">'; // Add flex container
    foreach ($photos as $photo) {
      // Compare the current photo URL with the primary photo URL
      $checked = ($photo === $primary_photo_url) ? 'checked' : '';
      echo '<label style="flex: 1 0 30%; margin: 5px; padding: 10px; border: 1px solid #ddd; position: relative;">'; // Add flex item
      echo '<img src="' . esc_url($photo) . '" style="width:100%;height:auto;">';
      echo '<input type="radio" name="primary_photo_url" value="' . esc_url($photo) . '" ' . $checked . ' style="position: absolute; top: 10px; right: 10px;">'; // Move the radio button to the top right corner
      echo '</label>'; // Close flex item
    }
    echo '</div>'; // Close flex container

    // Display the selected image thumbnail
    if (!empty($primary_photo_url)) {
      echo '<h3>Selected Image Thumbnail:</h3>';
      echo '<img src="' . esc_url($primary_photo_url) . '" style="max-width: 100%; height: auto;">';
    }

    // Add JavaScript code to highlight the selected image
    echo '
    <script>
    const radioButtons = document.querySelectorAll("input[type=\'radio\']");
    radioButtons.forEach(radioButton => {
      radioButton.addEventListener("change", function() {
        // Remove the highlight from all images
        radioButtons.forEach(rb => {
          rb.parentElement.style.backgroundColor = "";
        });
        // Highlight the selected image
        if (this.checked) {
          this.parentElement.style.backgroundColor = "lightblue";
          // Update the selected photo URL in a hidden input field
          document.getElementById("selected_photo_url").value = this.value;
        }
      });
    });
    </script>
    ';
  }

  // Add a hidden input field to store the selected photo URL
  echo '<input type="hidden" id="selected_photo_url" name="selected_photo_url" value="' . esc_url($primary_photo_url) . '">';
}



function save_primary_photo($post_id)
{
  if (!isset($_POST['primary_photo_nonce']) || !wp_verify_nonce($_POST['primary_photo_nonce'], 'save_primary_photo')) {
    return;
  }
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;
  if (isset($_POST['selected_photo_url'])) {
    $photo_url = esc_url_raw($_POST['selected_photo_url']);

    // Update the primary photo URL in post meta
    update_post_meta($post_id, 'primary_photo_url', $photo_url);
  }
}

// Save the primary photo selection
add_action('save_post', 'save_primary_photo');


function get_photo_reference($url)
{
  $parts = parse_url($url);
  parse_str($parts['query'], $query);
  return $query['photo_reference'] ?? null;
}
