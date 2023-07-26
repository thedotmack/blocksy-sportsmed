<?php

/**
 * Related Services Block Template.
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

if (get_post_type() == 'service') {
  $related_services = get_field('related_services_links', $post_id) ?: 'Related Service Links';
} else if (get_post_type() == 'wpseo_locations') {
  $related_services = get_field('services_offered', $post_id) ?: 'Related Service Links';
}
// Load values and assign defaults.

?>
<div <?php echo $anchor; ?>class="<?php echo esc_attr($class_name); ?>">

  <div class="wp-block-stackable-icon-list stk-block-icon-list stk-block stk-<?php echo esc_attr($class_name); ?>" data-block-id="<?php echo esc_attr($class_name); ?>">
    <style>
      .stk-<?php echo esc_attr($class_name); ?> {
        column-count: 2 !important;
        column-gap: 20px !important;

      }

      .stk-<?php echo esc_attr($class_name); ?> li {
        margin-bottom: 15px !important
      }

      .stk-<?php echo esc_attr($class_name); ?> ul,
      .stk-<?php echo esc_attr($class_name); ?> ol {
        padding-left: 30px !important
      }

      .stk-<?php echo esc_attr($class_name); ?> ul li {
        list-style-image: url('data:image/svg+xml;base64,PHN2ZyBhcmlhLWhpZGRlbj0idHJ1ZSIgZm9jdXNhYmxlPSJmYWxzZSIgZGF0YS1wcmVmaXg9ImZhcyIgZGF0YS1pY29uPSJjaGVjay1jaXJjbGUiIGNsYXNzPSJzdmctaW5saW5lLS1mYSBmYS1jaGVjay1jaXJjbGUgZmEtdy0xNiIgcm9sZT0iaW1nIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBzdHlsZT0iZmlsbDogIzE0NzBlZiAhaW1wb3J0YW50OyBjb2xvcjogIzE0NzBlZiAhaW1wb3J0YW50O3RyYW5zZm9ybTogcm90YXRlKGRlZykgIWltcG9ydGFudDsiPjxwYXRoIGZpbGw9IiMxNDcwZWYiIGQ9Ik01MDQgMjU2YzAgMTM2Ljk2Ny0xMTEuMDMzIDI0OC0yNDggMjQ4UzggMzkyLjk2NyA4IDI1NiAxMTkuMDMzIDggMjU2IDhzMjQ4IDExMS4wMzMgMjQ4IDI0OHpNMjI3LjMxNCAzODcuMzE0bDE4NC0xODRjNi4yNDgtNi4yNDggNi4yNDgtMTYuMzc5IDAtMjIuNjI3bC0yMi42MjctMjIuNjI3Yy02LjI0OC02LjI0OS0xNi4zNzktNi4yNDktMjIuNjI4IDBMMjE2IDMwOC4xMThsLTcwLjA1OS03MC4wNTljLTYuMjQ4LTYuMjQ4LTE2LjM3OS02LjI0OC0yMi42MjggMGwtMjIuNjI3IDIyLjYyN2MtNi4yNDggNi4yNDgtNi4yNDggMTYuMzc5IDAgMjIuNjI3bDEwNCAxMDRjNi4yNDkgNi4yNDkgMTYuMzc5IDYuMjQ5IDIyLjYyOC4wMDF6IiBzdHJva2U9IiMxNDcwZWYiIHN0eWxlPSJmaWxsOiByZ2IoMjAsIDExMiwgMjM5KTsgc3Ryb2tlOiByZ2IoMjAsIDExMiwgMjM5KTsiLz48L3N2Zz4=') !important
      }

      .stk-<?php echo esc_attr($class_name); ?> ul li a {
        color: inherit !important;
        font-size: 18px !important;
        margin-left: 5px;
        position: relative;
        top: -3px;
      }

      .stk-<?php echo esc_attr($class_name); ?> ul li a:hover {
        color: var(--paletteColor1, #1470ef) !important;
      }

      .stk-<?php echo esc_attr($class_name); ?> li::marker {
        color: var(--paletteColor1, #1470ef) !important;
        font-size: 2em !important
      }

      @media screen and (max-width:1023px) {
        .stk-<?php echo esc_attr($class_name); ?> {
          column-count: 2 !important
        }
      }
    </style>


    <ul>
      
      <?php foreach ($related_services as $related_service) : ?>
        <li><a href="<?php echo get_permalink($related_service->ID); ?>"><?php echo $related_service->post_title; ?></a></li>
      <?php endforeach; ?>
    </ul>


  </div>

</div>