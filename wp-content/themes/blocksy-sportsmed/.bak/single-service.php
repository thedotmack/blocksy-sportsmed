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

<div class="bg-gradient-to-b from-blue-900 to-blue-700">
  <section class=" max-w-5xl mx-auto py-16 text-white">
    <div class="flex justify-between items-center">
      <div class="w-1/2">
        <h2 class="text-4xl font-bold mb-4 text-white">Physical Therapy</h2>
        <p class="text-gray-200 mb-6">
          At SportsMed, our goal is to make you feel at home. Physical Therapy is not something any of us love to do,
          but often when seeking our care, it’s because it’s something you need to do.
        </p>
        <p class="text-gray-200 mb-6">
          We strive to help our physical therapy patients feel comfortable within our care and work alongside you to
          help you achieve your goals. We have an amazing staff, many of whom specialize in conditions that
          challenge our patients’ day in and day out. Whatever your physical therapy needs, we are here to help. And we
          also offer chiropractic care, occupational therapy, and more! Please reach out to us and ask us questions; we
          have the answers!
        </p>
        <a href="#" class="bg-white text-blue-700 py-2 px-4 rounded hover:bg-blue-200">Contact Us</a>
      </div>
      <div class="w-2/5">
        <img src="https://via.placeholder.com/400" alt="Physical Therapy" class="w-full rounded-lg shadow-lg">
      </div>
    </div>
  </section>
</div>
<section class="bg-white py-16">
  <div class="max-w-5xl mx-auto">
    <h2 class="text-4xl font-bold text-center mb-8">Why Choose Us?</h2>
    <div class="grid grid-cols-3 gap-8">
      <div class="text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M2 4a2 2 0 012-2h12a2 2 0 012 2v5a7 7 0 11-14 0V4zm14 7a5 5 0 11-10 0V6h10v5z" clip-rule="evenodd" />
        </svg>
        <h3 class="text-2xl font-semibold mb-2">Comfortable Treatment</h3>
        <p class="text-gray-800">Our staff takes pride in helping you feel comfortable during your physical therapy
          sessions; which is why we build a relationship with our patients before they ever walk through the door.</p>
      </div>
      <div class="text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M2 4a2 2 0 012-2h12a2 2 0 012 2v5a7 7 0 11-14 0V4zm14 7a5 5 0 11-10 0V6h10v5z" clip-rule="evenodd" />
        </svg>
        <h3 class="text-2xl font-semibold mb-2">Specialized Staff</h3>
        <p class="text-gray-800">Every single one of our therapists specializes in an array of conditions; and each
          one of them works hard to make sure that their patients feel comfortable throughout their treatment plan.</p>
      </div>
      <div class="text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M2 4a2 2 0 012-2h12a2 2 0 012 2v5a7 7 0 11-14 0V4zm14 7a5 5 0 11-10 0V6h10v5z" clip-rule="evenodd" />
        </svg>
        <h3 class="text-2xl font-semibold mb-2">Flexible Treatment Options</h3>
        <p class="text-gray-800">If you see one therapist here at SportsMed Physical Therapy, you can see any other
          therapist here! That way, if there is something specific that you need help with; or maybe even a different
          approach to healing than someone else would use; we can make sure that you get what you need.</p>
      </div>
    </div>
  </div>
</section>

<section class="max-w-5xl mx-auto bg-gray-300 p-16">
  <h2 class="text-4xl font-bold mb-8 text-center">Our Services</h2>
  <div class="grid grid-cols-3 gap-8">
    <div>
      <h3 class="text-2xl font-semibold mb-4">Chiropractic Care</h3>
      <p class="text-gray-800 mb-6">We offer chiropractic care services to alleviate pain and promote overall wellness.
        Our chiropractors are skilled in various techniques to address a wide range of conditions.</p>
      <a href="#" class="text-blue-500">Learn More</a>
    </div>
    <div>
      <h3 class="text-2xl font-semibold mb-4">Occupational Therapy</h3>
      <p class="text-gray-800 mb-6">Our occupational therapy services focus on helping individuals regain their
        independence and improve their ability to perform daily activities after an injury or illness.</p>
      <a href="#" class="text-blue-500">Learn More</a>
    </div>
    <div>
      <h3 class="text-2xl font-semibold mb-4">Sports Rehabilitation</h3>
      <p class="text-gray-800 mb-6">Our sports rehabilitation programs are designed to help athletes recover from
        injuries and improve their performance. We tailor our treatment plans to meet the specific needs of each
        athlete.</p>
      <a href="#" class="text-blue-500">Learn More</a>
    </div>
  </div>
</section>

<section class="bg-white py-16">
  <div class="max-w-5xl mx-auto">
    <h2 class="text-4xl font-bold text-center mb-8">Testimonials</h2>
    <div class="grid grid-cols-3 gap-8">
      <div>
        <p class="text-gray-800 mb-4">"I had a great experience with SportsMed Physical Therapy. The staff was
          knowledgeable and friendly, and the therapy sessions were effective in helping me recover from my injury.
          Highly recommend!"</p>
        <h4 class="text-lg font-semibold">John - Soccer Player</h4>
      </div>
      <div>
        <p class="text-gray-800 mb-4">"After my car accident, I went to SportsMed for physical therapy. The therapists
          were extremely caring and supportive throughout my recovery journey. I'm grateful for their expertise and
          guidance."</p>
        <h4 class="text-lg font-semibold">Emily - Car Accident Survivor</h4>
      </div>
      <div>
        <p class="text-gray-800 mb-4">"The physical therapists at SportsMed have helped me overcome my chronic pain
          issues. They listened to my concerns and developed a personalized treatment plan that has made a significant
          difference in my quality of life."</p>
        <h4 class="text-lg font-semibold">Michael - Chronic Pain Patient</h4>
      </div>
    </div>
  </div>
</section>

<section class="max-w-5xl mx-auto py-16">
  <h2 class="text-4xl font-bold mb-8 text-center">Contact Us</h2>
  <p class="text-gray-800 text-center mb-8">Have any questions or want to schedule an appointment? Feel free to reach
    out to us.</p>
  <div class="flex justify-center">
    <a href="#" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Contact Us</a>
  </div>
</section>


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

    <div class="relative z-1 mx-auto max-w-5xl lg:flex lg:space-x-10">
      <div class="sm:w-7/12">
        <div class="relative py-8">
          <div class="bg-blue-950/80 backdrop-blur absolute inset-0 z-0 -mx-[100%]"></div>
          <h1 class="mt-0 mb-3 relative text-4xl font-bold tracking-tight text-white sm:text-5xl">
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
      <div class="sm:w-5/12 pt-6">

        <div class="rounded-md bg-white/5 shadow-2xl ring-1 ring-white/10 overflow-hidden mb-7">

          <!-- Desktop Map -->
          <div class="block hidden:sm">
            <?php
            if (function_exists('wpseo_local_show_map')) {
              $params = array(
                'echo' => true,
                'id' => $post->ID,
                'width' => 600,
                'height' => 500,
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

          <div class="flex p-3 bg-blue-950/80 justify-center">

            <a href="/get-started-now/" class="rounded-md bg-gradient-to-b from-blue-500 to-blue-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-400 hover:text-white">Schedule an Appointment</a>
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
