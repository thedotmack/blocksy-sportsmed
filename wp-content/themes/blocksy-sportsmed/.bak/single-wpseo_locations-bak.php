<?php

/**
 * The template for displaying single posts, also works width custom post types by default
 *
 * @package Crunch
 * @version 6.0
 */

defined('ABSPATH') || exit;

get_header();
the_post();
?>

<main id="main">

  <div class="relative overflow-hidden bg-gradient-to-r from-blue-700 to-blue-50/20">
    <?php
    if (has_post_thumbnail($post->ID)) {
      $thumbnail_id = get_post_thumbnail_id($post->ID);
      $primary_photo_url = wp_get_attachment_image_src($thumbnail_id, 'full')[0];
    } else {
      $primary_photo_url = get_primary_photo_url($post->ID);
    }
    ?>
    <img src='<?= $primary_photo_url ?>' class="absolute object-cover w-full h-full z-0 mix-blend-overlay opacity-30">

    <div class="relative z-1 mx-auto max-w-6xl lg:flex lg:space-x-10">
      <div class="sm:w-6/12">
        <div class="relative py-8">
          <div class="bg-blue-950/80 backdrop-blur absolute inset-0 z-0 -mx-[150%]"></div>
          <h1 class="mt-0 mb-3 relative text-4xl font-bold tracking-tight text-white sm:text-5xl sm:tracking-tighter">
            <div class="relative z-1">SportsMed <?php the_title(); ?></div>
          </h1>
          <div class="flex font-bold text-sm text-white relative z-1">
            <div class="ugmb__address"><?php echo get_address(); ?></div>
            <div class="ugmb__phone ml-1.5"><?php echo get_phone_number(); ?></div>
          </div>
        </div>

        <div class="pt-2.5">

          <?php

          $placeId = get_field('google_place_id');

          $reviews = new GooglePlaceReviews($placeId);
          $reviewContent = new GooglePlaceReviewsContent($placeId);

          echo $reviews->getReviews();


          // Get reviews
          $reviewData = $reviewContent->getReviewContent();

          // prebug($reviewData);
          // echo $reviewData;

          ?>

        </div>
      </div>

      <!-- Hero Map -->
      <div class="sm:w-6/12 pt-6">

        <?php
        $googlePlacePhotos = new GooglePlacePhotos($placeId, $post->ID);
        $photos = $googlePlacePhotos->getPhotos();
        ?>
        <div class="rounded-md bg-white/5 shadow-2xl ring-1 ring-white/10 overflow-hidden mb-2.5">

          <!-- Slider main container -->
          <div class="swiper swiper-gallery">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">

              <!-- Slides -->
              <?php foreach ($photos as $photo) : ?>
                <div class="swiper-slide">
                  <img class="object-cover aspect-[4/3]" src=" <?php echo $photo; ?>">
                </div>
              <?php endforeach; ?>
              <div class="swiper-slide">
                <!-- Desktop Map -->
                <div class="block hidden:sm">
                  <?php
                  if (function_exists('wpseo_local_show_map')) {
                    $params = array(
                      'echo' => true,
                      'id' => $post->ID,
                      'width' => 640,
                      'height' => 480,
                      'zoom' => 13,
                      'show_route' => false,
                      'map_style' => 'roadmap'
                    );
                    wpseo_local_show_map($params);
                  }
                  ?>
                </div>

                <!-- Mobile Map -->
                <div class="hidden block:sm">
                  <?php
                  if (function_exists('wpseo_local_show_map')) {
                    $params = array(
                      'echo' => true,
                      'id' => $post->ID,
                      'width' => 480,
                      'height' => 360,
                      'zoom' => 13,
                      'show_route' => false,
                      'map_style' => 'roadmap'
                    );
                    wpseo_local_show_map($params);
                  }
                  ?>
                </div>

              </div>

            </div>

            <!-- If we need navigation buttons -->
            <div class="swiper-gallery-prev swiper-gallery-button-prev"></div>
            <div class="swiper-gallery-next swiper-gallery-button-next"></div>

          </div>
        </div>

        <div class="swiper-container gallery-thumbs overflow-hidden mb-5">
          <div class="swiper-wrapper">
            <?php foreach ($photos as $photo) : ?>
              <div class="swiper-slide">
                <img class="object-cover aspect-square w-full rounded-md shadow-sm" src=" <?php echo $photo; ?>">
              </div>
            <?php endforeach; ?>
          </div>
        </div>


      </div>
    </div>
  </div>


  <!-- services -->
  <div class="pt-16 sm:pt-24">

    <?php
    $services = get_field('services_offered', $post->ID);
    ?>
    <div class="mx-auto max-w-5xl">

      <div class="grid grid-cols-1 gap-x-20 gap-y-0 sm:gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
        <div>
          <h2 class="text-base font-semibold leading-7 text-blue-600"><?php the_title(); ?></h2>
          <p class="mt-2 text-3xl font-bold tracking-tight text-blue-950 sm:text-4xl">Services Available</p>
          <p class="mt-6 text-base leading-7 text-gray-600">SportsMed <?php the_title() ?> offers the following services:</p>
        </div>

        <dl class="col-span-2 grid grid-cols-1 text-base leading-7 text-gray-600 sm:grid-cols-2 lg:gap-y-4">

          <?php foreach ($services as $service_id) : ?>
            <div class="relative pl-9">
              <dt class="font-semibold text-gray-900">
                <svg class="absolute top-1 left-0 h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                </svg>
                <a class="text-gray-600 hover:text-blue-600" href="<?= get_permalink($service_id) ?>">
                  <?php echo get_the_title($service_id) ?>
                </a>
              </dt>
            </div>
          <?php endforeach; ?>
        </dl>
      </div>
    </div>
  </div>

  <div class="pt-10 pb-16 sm:pb-24 max-w-5xl mx-auto">
    <div class="flex justify-between">
      <div class="text-gray-500 text-sm font-medium w-7/12">
        <?php the_content(); ?>
      </div>
      <div class="w-1/3 mr-3">
        <h3 class="text-lg text-blue-950 text-center">Hours of Operation</h3>
        <?php echo display_opening_hours(); ?>
      </div>
    </div>
  </div>

  <?php
  $location_staff = get_field('staff');
  ?>
  <div id="providers" class="bg-blue-50 py-16 sm:py-24">
    <div class="mx-auto max-w-6xl px-6 lg:px-8">
      <div class="mx-auto max-w-2xl text-center">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Meet The Providers</h2>
        <p class="mt-2 sm:mt-6 text-lg leading-8 text-gray-600">Our Team at SportsMed Physical Therapy in <?php the_title(); ?></p>
      </div>

      <div role="list" class="mx-auto mt-12 sm:mt-20 grid max-w-2xl grid-cols-1 gap-x-6 gap-y-10 sm:gap-y-20 sm:grid-cols-3 lg:max-w-4xl lg:gap-x-8 xl:max-w-none">

        <?php foreach ($location_staff as $staff) : ?>

          <div class="text-center">
            <?php
            echo get_the_post_thumbnail($staff->ID, 'large', array('class' => 'aspect-[4/5] w-80 h-auto flex-none rounded-2xl object-cover max-w-full'));
            ?>
            <h3 class="mt-6 text-base font-semibold leading-7 tracking-tight text-gray-900"><?php echo $staff->post_title ?></h3>
            <p class="text-sm leading-6 text-gray-600"><?php the_field('job_title', $staff->ID) ?></p>
          </div>
        <?php endforeach; ?>


        <!-- More people... -->
      </div>
    </div>
    <div class="mx-auto max-w-2xl text-center">
      <div class="mt-10 sm:mt-20 flex items-center justify-center">
        <a href="/get-started-now/" class="rounded-md bg-blue-600 px-4 sm:px-5 py-3 text-lg font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Get started now at SportsMed <?php the_title(); ?> <span aria-hidden="true">→</span></a>
      </div>
    </div>



</main>

<?php

get_footer();
