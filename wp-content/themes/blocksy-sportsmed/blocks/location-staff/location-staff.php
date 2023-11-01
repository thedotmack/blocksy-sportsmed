<?php

/**
 * Location Staff Block Template.
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
$class_name = 'location-staff-block';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

$location_staff = get_field('staff', $post_id) ?: 'Location Staff';

?>
<div <?php echo $anchor; ?>class="<?php echo esc_attr($class_name); ?>">

  <div class="flex space-x-[2.5%] flex-wrap justify-center stk-<?php echo esc_attr($class_name); ?>" data-block-id="<?php echo esc_attr($class_name); ?>">
    <?php foreach ($location_staff as $location_staff_member) : ?>

      <div class="block relative w-[23%] text-blue-900 text-center mb-5">
        <img class="rounded-2xl border-2 border-solid border-gray-200 shadow-xl h-96 w-full object-cover" src="<?php echo get_the_post_thumbnail_url($location_staff_member->ID); ?>" alt="<?php echo $location_staff_member->post_title; ?>">

        <span class="text-xl font-medium mt-2 block"><?php echo $location_staff_member->post_title; ?></span>
      </div>

    <?php endforeach; ?>
  </div>

</div>