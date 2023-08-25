<?php

/**
 * Service Locations Cards Block Template.
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


// Step 1: Prepare the wpseo_locations_ids
$service_locations = get_field('service_locations', $post_id) ?: 'Service Locations List';
?>

<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?> grid grid-cols-3">
  <?php foreach ($service_locations as $service_location): ?>
    <div class="tw_card-container tw_card-container__infobox !mb-5 !mx-2.5">
      <div class="tw_card-content">
        <img class="tw_card-image" src="<?php echo get_the_post_thumbnail_url($service_location->ID, 'thumbnail') ?>">

        <div class="tw_card-body">
          <div class="tw_card-header">
            <?php $logomark = wp_get_attachment_image_src(25165, 'full'); ?>

            <img class="tw_card-logo" src="<?= $logomark[0] ?>" alt="SportsMed <?php echo $service_location->post_title; ?> Logo">
            <div>
              <div class="tw_card-title text-[--custom-color-title]"><?php echo $service_location->post_title; ?></div>
              <div class="tw_card-subtitle">
                <?php

                // Retrieve all terms associated with the post in the 'wpseo_locations_category' taxonomy.
                $custom_taxterms = wp_get_object_terms($service_location->ID, 'wpseo_locations_category', array('fields' => 'all'));

                // Initialize an array to store child categories.
                $child_categories = array();

                // Loop through the terms and filter out those that have a parent.
                foreach ($custom_taxterms as $term) {
                  if ($term->parent > 0) { // Check if the term has a parent, meaning it's a child category.
                    $county = $term;
                  } else {
                    $state = $term;
                  }
                }
                ?>
                <a href="<?= get_term_link($county) ?>"><?= $county->name ?></a>, 
                <a href="<?= get_term_link($state) ?>"><?= $state->name ?></a>

              </div>
            </div>
          </div>
          <div class="tw_card-info">
            <div>
              <?php

              // Get the street
              $street = get_post_meta($service_location->ID, '_wpseo_business_address', true);

              // Get the city
              $city = get_post_meta($service_location->ID, '_wpseo_business_city', true);

              // Get the state
              $state = get_post_meta($service_location->ID, '_wpseo_business_state', true);

              // Get the postal code
              $zipcode = get_post_meta($service_location->ID, '_wpseo_business_zipcode', true);

              // Get the phone number
              $phone = get_post_meta($service_location->ID, '_wpseo_business_phone', true);
              ?>

              <div>
                <?php echo $street; ?><br>
                <?php echo $city; ?>, <?php echo $state; ?> <?php echo $zipcode; ?>
              </div>

            </div>

            <a href="tel:<?php echo $phone; ?>" class="tw_map-phone map-phone">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M5.58685 5.90223C6.05085 6.86865 6.68337 7.77441 7.48443 8.57546C8.28548 9.37651 9.19124 10.009 10.1577 10.473C10.2408 10.5129 10.2823 10.5329 10.3349 10.5482C10.5218 10.6027 10.7513 10.5636 10.9096 10.4502C10.9542 10.4183 10.9923 10.3802 11.0685 10.304C11.3016 10.071 11.4181 9.95443 11.5353 9.87824C11.9772 9.59091 12.5469 9.59091 12.9889 9.87824C13.106 9.95443 13.2226 10.071 13.4556 10.304L13.5856 10.4339C13.9398 10.7882 14.117 10.9654 14.2132 11.1556C14.4046 11.534 14.4046 11.9809 14.2132 12.3592C14.117 12.5495 13.9399 12.7266 13.5856 13.0809L13.4805 13.186C13.1274 13.5391 12.9508 13.7156 12.7108 13.8505C12.4445 14.0001 12.0308 14.1077 11.7253 14.1068C11.45 14.1059 11.2619 14.0525 10.8856 13.9457C8.86333 13.3718 6.95509 12.2888 5.36311 10.6968C3.77112 9.10479 2.68814 7.19655 2.11416 5.17429C2.00735 4.79799 1.95395 4.60984 1.95313 4.33455C1.95222 4.02906 2.0598 3.6154 2.20941 3.34907C2.34424 3.10904 2.52078 2.9325 2.87386 2.57942L2.97895 2.47433C3.33325 2.12004 3.5104 1.94289 3.70065 1.84666C4.07903 1.65528 4.52587 1.65528 4.90424 1.84666C5.0945 1.94289 5.27164 2.12004 5.62594 2.47433L5.75585 2.60424C5.98892 2.83732 6.10546 2.95385 6.18165 3.07104C6.46898 3.51296 6.46898 4.08268 6.18165 4.52461C6.10546 4.6418 5.98892 4.75833 5.75585 4.9914C5.67964 5.06761 5.64154 5.10571 5.60965 5.15026C5.4963 5.30854 5.45717 5.53805 5.51165 5.72495C5.52698 5.77754 5.54694 5.81911 5.58685 5.90223Z" stroke="#475467" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <span><?php echo $phone; ?></span>
            </a>
          </div>
        </div>
      </div>
      <div class="tw_card-footer">
        <a class="tw_btn-primary" href="/get-started-now/location/?title=<?php echo $service_location->post_title; ?>">Make Appointment</a>
        <a class="tw_btn-secondary" href="<?php echo get_permalink($service_location->ID); ?>">Learn More &rarr;</a>
      </div>
    </div>
  <?php endforeach; ?>
</div>