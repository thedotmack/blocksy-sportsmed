<?php

/**
 * ACF Gallery Carousel Block Template.
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
$class_name = 'acf-gallery-carousel-block';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}
?>

<div <?php echo $anchor; ?>class="<?php echo esc_attr($class_name); ?>">

  <?php
  // $googlePlacePhotos = new GooglePlacePhotos($placeId, $post->ID);
  // $photos = $googlePlacePhotos->getPhotos();
  // location_gallery
  // services_gallery


  $photos = get_field('location_gallery', $post_id);
  if (empty($photos)) {
    $photos = get_field('services_gallery', $post_id);
  }


?>
  <div class="rounded-[30px] bg-white/5 shadow-2xl ring-1 ring-white/10 overflow-hidden mb-2.5">
    <!-- Slider main container -->
    <div class="swiper swiper-gallery">
      <!-- Additional required wrapper -->
      <div class="swiper-wrapper">

        <!-- Slides -->
        <?php foreach ($photos as $photo) : ?>
          <div class="swiper-slide">
            <img class="object-cover aspect-[4.5/3]" src="<?= $photo['sizes']['large'] ?>">
          </div>
        <?php endforeach; ?>
      </div>

      <!-- If we need navigation buttons -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>

    </div>
  </div>

  <!-- div class="swiper-container gallery-thumbs overflow-hidden mb-5">
    <div class="swiper-wrapper">
      <?php foreach ($photos as $photo) : ?>
        <div class="swiper-slide">
          <img class="object-cover aspect-square w-full rounded-md shadow-sm" src="<?= $photo['sizes']['thumbnail'] ?>">
        </div>
      <?php endforeach; ?>
    </div>
  </div -->

</div>