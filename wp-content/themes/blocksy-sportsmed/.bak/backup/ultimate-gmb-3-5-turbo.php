<?php

// Define the Google API key as a constant
define('GOOGLE_API_KEY', 'AIzaSyC8CiBVNeMwe0x7UVQlJ8TUmG7GYjbD_zE');

class GooglePlaceAPI
{
  protected $placeId;

  public function __construct($placeId)
  {
    $this->placeId = $placeId;
  }

  public function makeApiRequest($fields)
  {
    $url = sprintf(
      'https://maps.googleapis.com/maps/api/place/details/json?place_id=%s&fields=%s&key=%s',
      $this->placeId,
      $fields,
      GOOGLE_API_KEY
    );

    $response = wp_remote_get(esc_url_raw($url));

    if (is_wp_error($response)) {
      return $response;
    }

    $body = wp_remote_retrieve_body($response);
    return json_decode($body);
  }
}

class GooglePlaceReviews extends GooglePlaceAPI
{
  public function getReviews()
  {
    $data = $this->makeApiRequest('rating,user_ratings_total,reviews');

    if (is_wp_error($data)) {
      return 'Error occurred: ' . $data->get_error_message();
    }

    if (isset($data->result) && isset($data->result->reviews)) {
      $reviewData = $data->result;

      $rating = $reviewData->rating ?? 'N/A';
      $reviews = $reviewData->user_ratings_total ?? 'N/A';

      $full_stars = floor($rating);
      $half_stars = $rating - $full_stars > 0 ? 1 : 0;


      $star_output = '';
      for ($i = 0; $i < $full_stars; $i++) {
        $star_output .= '<img src="' . get_stylesheet_directory_uri() . '/images/star.svg" alt="Full Star" class="h-6 w-auto">';
      }
      for ($i = 0; $i < $half_stars; $i++) {
        $star_output .= '<img src="' . get_stylesheet_directory_uri() . '/images/star-half.svg" alt="Half Star" class="h-6 w-auto">';
      }

      echo '<div>' . $star_output . '</div>';
      echo '<div class="text-white mb-4">' . $reviewData->user_ratings_total . ' Reviews</div>';


      $carousel_output = '<div class="swiper-container">
                            <div class="swiper-wrapper">';

      foreach ($reviewData->reviews as $review) {
        $carousel_output .= '<div class="swiper-slide">
                               <figure class="rounded-2xl bg-white p-3.5 shadow-lg ring-1 ring-gray-900/5">
                                 <blockquote class="text-sm text-gray-900">
                                   <p>' . $review->text . '</p>
                                 </blockquote>
                                 <figcaption class="mt-3 flex items-center gap-x-2">
                                   <img class="h-8 w-8 rounded-full bg-gray-50" src="' . $review->profile_photo_url . '" alt="Reviewer Profile Photo">
                                   <div>
                                     <div class="font-semibold">' . $review->author_name . '</div>
                                     <div class="text-gray-600">@' . strtolower(str_replace(' ', '', $review->author_name)) . '</div>
                                   </div>
                                 </figcaption>
                               </figure>

                                <svg class="progress-bar" viewBox="0 0 200 200" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                  <circle r="90" cx="100" cy="100" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0" stroke-width="4"></circle>
                                  <circle class="bar" r="90" cx="100" cy="100" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0" stroke-width="4"></circle>
                                </svg>

                             </div>';
      }

      $carousel_output .= '</div>      
                          <!-- div class="swiper-button-next"></div>
                          <div class="swiper-button-prev"></div -->
                        </div>';


      return $carousel_output;
    } else {
      return 'No data available for this place.';
    }
  }
}

class GooglePlaceReviewsContent extends GooglePlaceAPI
{
  public function getReviewContent($numberOfReviews = 5)
  {
    $data = $this->makeApiRequest('reviews');

    if (is_wp_error($data)) {
      return 'Error occurred: ' . $data->get_error_message();
    }

    if (isset($data->result) && isset($data->result->reviews)) {
      $reviews = $data->result->reviews;

      $reviews_output = '';
      $counter = 0;
      foreach ($reviews as $review) {
        if ($counter == $numberOfReviews) break;

        ob_start();
?>
        <figure class="rounded-2xl bg-white p-3 shadow-lg ring-1 ring-gray-900/5">
          <blockquote class="text-sm text-gray-900">
            <p><?php echo $review->text; ?></p>
          </blockquote>
          <figcaption class="mt-3 flex items-center gap-x-2">
            <img class="h-8 w-8 rounded-full bg-gray-50" src="<?php echo $review->profile_photo_url; ?>" alt="Reviewer Profile Photo">
            <div>
              <div class="font-semibold"><?php echo $review->author_name; ?></div>
              <div class="text-gray-600">@<?php echo strtolower(str_replace(' ', '', $review->author_name)); ?></div>
            </div>
          </figcaption>
        </figure>
  <?php

        $reviews_output .= ob_get_clean();

        $counter++;
      }

      return $reviews_output;
    } else {
      return 'No data available for this place.';
    }
  }
}

class GooglePlacePhotos extends GooglePlaceAPI
{
  protected $postId;

  public function __construct($placeId, $postId)
  {
    parent::__construct($placeId);
    $this->postId = $postId;
  }

  public function getPhotos()
  {
    $data = $this->makeApiRequest('photos');

    if (is_wp_error($data)) {
      return 'Error occurred: ' . $data->get_error_message();
    }

    if (isset($data->result) && isset($data->result->photos)) {
      $photos = $data->result->photos;

      $image_urls = [];
      foreach ($photos as $photo) {
        $photo_reference = $photo->photo_reference;
        $image_url = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=2048&photo_reference=' . $photo_reference . '&key=' . GOOGLE_API_KEY;
        $image_urls[] = $image_url;
      }

      update_post_meta($this->postId, 'google_place_photos', $image_urls);

      return $image_urls;
    } else {
      return 'No data available for this place.';
    }
  }
}

class GooglePlaceDetails extends GooglePlaceAPI
{
  protected $postId;

  public function __construct($placeId, $postId)
  {
    parent::__construct($placeId);
    $this->postId = $postId;
  }

  public function updatePlaceDetails()
  {
    $data = $this->makeApiRequest('address_component,adr_address,formatted_address,geometry,icon,name,permanently_closed,place_id,plus_code,types,url,utc_offset,vicinity,website,rating,user_ratings_total,current_opening_hours,formatted_phone_number,international_phone_number,opening_hours,secondary_opening_hours,website');

    if (!is_wp_error($data) && isset($data->result)) {
      update_post_meta($this->postId, 'google_place_details', $data->result);
      return $data->result;
    }

    return false;
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

/**
 * Callback function for rendering the location photos meta box.
 *
 * @param WP_Post $post The current post object.
 */
function location_photos_meta_box_cb($post)
{
  wp_nonce_field('save_primary_photo', 'primary_photo_nonce');

  $existingPhotos = get_post_meta($post->ID, 'google_place_photos', true);

  $placeId = get_field('place_id', $post->ID);

  if (!empty($existingPhotos)) {
    $photos = $existingPhotos;
  } else {
    $googlePlacePhotos = new GooglePlacePhotos($placeId, $post->ID);
    $photos = $googlePlacePhotos->getPhotos();

    if (!is_wp_error($photos)) {
      // Save the photos to post meta
      update_post_meta($post->ID, 'google_place_photos', $photos);
    }
  }

  $primary_photo_url = get_post_meta($post->ID, 'primary_photo_url', true);


  if ($photos !== 'No data available for this place.') {
    echo '<div style="display: flex; flex-wrap: wrap;">';

    echo $primary_photo_url ? "<img src='$primary_photo_url' style='width: 100%; height: auto; margin-bottom: 10px;'>" : "";

    foreach ($photos as $photo) {
      $checked = ($photo === $primary_photo_url) ? 'checked' : '';

      echo '<label style="flex: 1 0 30%; margin: 5px; padding: 10px; border: 1px solid #ddd; position: relative;">';
      echo '<img src="' . esc_url($photo) . '" style="width:100%;height:auto;">';
      echo '<input type="radio" name="primary_photo_url" value="' . esc_url($photo) . '" ' . $checked . ' style="position: absolute; top: 10px; right: 10px;">';
      echo '</label>';
    }
    echo '</div>';

    echo '
        <script>
        const radioButtons = document.querySelectorAll("input[type=\'radio\']");
        radioButtons.forEach(radioButton => {
          radioButton.addEventListener("change", function() {
            radioButtons.forEach(rb => {
              rb.parentElement.style.backgroundColor = "";
            });
            if (this.checked) {
              this.parentElement.style.backgroundColor = "lightblue";
            }
          });
        });
        </script>
        ';
  }
}

/**
 * Save the selected primary photo.
 *
 * @param int $post_id The post ID.
 */
function save_primary_photo($post_id)
{
  if (!isset($_POST['primary_photo_nonce']) || !wp_verify_nonce($_POST['primary_photo_nonce'], 'save_primary_photo')) {
    return;
  }
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;
  if (isset($_POST['primary_photo_url'])) {
    $photo_url = esc_url_raw($_POST['primary_photo_url']);

    update_post_meta($post_id, 'primary_photo_url', $photo_url);
  }
}
add_action('save_post', 'save_primary_photo');


function get_primary_photo_url($post_id)
{
  return get_post_meta($post_id, 'primary_photo_url', true);
}

function getOpeningHours($placeDetails)
{
  if (isset($placeDetails->current_opening_hours)) {
    $openingHours = $placeDetails->current_opening_hours->periods;
    $hours = [];

    foreach ($openingHours as $period) {
      $openTime = $period->open->time;
      $closeTime = $period->close->time;

      $openTimeParsed = DateTime::createFromFormat('Hi', $openTime);
      $closeTimeParsed = DateTime::createFromFormat('Hi', $closeTime);

      $openTimeFormatted = $openTimeParsed->format('g:i A');
      $closeTimeFormatted = $closeTimeParsed->format('g:i A');

      $hours[] = ['open' => $openTimeFormatted, 'close' => $closeTimeFormatted];
    }

    return $hours;
  }

  return null;
}

function display_opening_hours()
{
  global $post;

  $placeDetails = get_post_meta($post->ID, 'google_place_details', true);

  $opening_hours = getOpeningHours($placeDetails);

  if ($opening_hours === null) {
    return '<p>No opening hours available.</p>';
  }

  $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
  ?>

  <div class="mt-1 flow-root">
    <div class="-mx-2 -my-1 overflow-x-auto sm:-mx-3 lg:-mx-4">
      <div class="inline-block min-w-full py-1 align-middle sm:px-3 lg:px-4">
        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50/80 backdrop-blur">
              <tr>
                <th scope="col" class="py-1.5 pl-2 pr-1.5 text-left text-sm font-semibold text-gray-900 sm:pl-3">Day
                </th>
                <th scope="col" class="px-1.5 py-1.5 text-left text-sm font-semibold text-gray-900">Open
                </th>
                <th scope="col" class="px-1.5 py-1.5 text-left text-sm font-semibold text-gray-900">Close
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white/50 backdrop-blur">
              <?php foreach ($opening_hours as $index => $day_hours) : ?>
                <tr>
                  <td class="whitespace-nowrap py-2 pl-2 pr-1.5 text-sm font-medium text-gray-900 sm:pl-3"><?= esc_html($days[$index]) ?></td>
                  <td class="whitespace-nowrap px-1.5 py-2 text-sm text-gray-500"><?= esc_html($day_hours['open']) ?></td>
                  <td class="whitespace-nowrap px-1.5 py-2 text-sm text-gray-500"><?= esc_html($day_hours['close']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

<?php
}

function get_address()
{
  global $post;

  $placeDetails = get_post_meta($post->ID, 'google_place_details', true);

  if (empty($placeDetails)) {
    return '<p>No address available.</p>';
  }

  $formatted_address = $placeDetails->formatted_address ?? null;

  if ($formatted_address === null) {
    return '<p>No address available.</p>';
  }

  return esc_html($formatted_address);
}

function get_phone_number()
{
  global $post;

  $placeDetails = get_post_meta($post->ID, 'google_place_details', true);

  if (empty($placeDetails)) {
    return '<p>No phone number available.</p>';
  }

  $formatted_phone_number = $placeDetails->formatted_phone_number ?? null;

  if ($formatted_phone_number === null) {
    return '<p>No phone number available.</p>';
  }

  return esc_html($formatted_phone_number);
}

function enqueue_swiper_scripts()
{
  wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css');
  wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), '', false);
}
add_action('wp_enqueue_scripts', 'enqueue_swiper_scripts');


function load_places_data()
{
  global $post;
  $placeId = get_field('google_place_id', $post->ID);
  $reviews = new GooglePlaceReviews($placeId);
  $reviewContent = new GooglePlaceReviewsContent($placeId);
  $photos = new GooglePlacePhotos($placeId, $post->ID);
  $placeDetails = new GooglePlaceDetails($placeId, $post->ID);
  $details = $placeDetails->updatePlaceDetails();
  $savePhotos = $photos->getPhotos();
}
add_action('save_post', 'load_places_data');
