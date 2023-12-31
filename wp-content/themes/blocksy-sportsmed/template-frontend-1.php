<?php

$geo_btn_class      = ($all_configs['geo_button'] == '1') ? 'asl-geo icon-direction-outline' : 'icon-search';
$search_type_class  = ($all_configs['search_type'] == '1') ? 'asl-search-name' : 'asl-search-address';
$panel_order        = (isset($all_configs['map_top'])) ? $all_configs['map_top'] : '2';

$ddl_class_grid = ($all_configs['search_2']) ? 'pol-lg-6 pol-md-6 pol-sm-12' : 'pol-lg-6 pol-md-6 pol-sm-12';



$ddl_class      = '';


$class = (isset($all_configs['css_class'])) ? ' ' . $all_configs['css_class'] : '';

if ($all_configs['display_list'] == '0' || $all_configs['first_load'] == '3' || $all_configs['first_load'] == '4')
  $class .= ' map-full';
else if ($all_configs['first_load'] == '5') {
  $class .= ' sl-search-only';
}

if ($all_configs['pickup'] || $all_configs['ship_from'])
  $class .= ' sl-pickup-tmpl';

if ($all_configs['full_width'])
  $class .= ' full-width';

if (isset($all_configs['full_map']))
  $class .= ' map-full-width';

if ($all_configs['advance_filter'] == '0')
  $class .= ' no-asl-filters';

if ($all_configs['advance_filter'] == '1' && $all_configs['layout'] == '1')
  $class .= ' asl-adv-lay1';

if ($all_configs['tabs_layout'] == '1') {

  $ddl_class  .= ' asl-tabs-ddl pol-12 pol-lg-12 pol-md-12 pol-sm-12';
  $class      .= ' sl-category-tabs';
}

//add Full height
$class .= ' ' . $all_configs['full_height'];


$default_addr       = (isset($all_configs['default-addr'])) ? $all_configs['default-addr'] : '';


?>
<style type="text/css">
</style>

<div id="asl-storelocator" class="storelocator-main asl-cont asl-template-0 asl-template-1 asl-layout-1 asl-bg-3 full-width asl-text-2">

  <div class="asl-wrapper flex lg:flex-row">

    <div class="map-column-1 relative">

      <?php if ($all_configs['advance_filter']) : ?>
        <div class="Filter_section bg-white border-4 border-solid border-l-0 border-b-0 border-t-0 border-slate-200">

          <img class="absolute z-0 inset-0 object-contain object-center w-full h-full animate__animated animate__fadeIn animate__delay-4s" src="https://spineandsportsmed.local/wp-content/uploads/2023/07/bg-sportsman@2x.jpg">

          <div class="search_filter">
            <style>
              :root {
                --animate-delay: 0.25s;
              }
            </style>

            <h1 class="search_filter__title animate__animated animate__fadeIn animate__delay-1s"><?php echo asl_esc_lbl('search_loc') ?></h1>

            <p class="!text-base !text-slate-500 mb-3 animate__animated animate__fadeIn animate__delay-2s hidden lg:block"><strong class="text-[--custom-color-primary-blue]">Let&rsquo;s start by finding the closest SportsMed to you.</strong> You can search by address, zip code, state, or county. Same day or next day appointments are available by request.</p>

            <div class="flex space-x-2 animate__animated animate__fadeIn animate__delay-3s">

              <div class="sl-search-group flex flex-1">
                <input type="text" value="<?php echo $default_addr ?>" data-submit="disable" tabindex="2" id="auto-complete-search" placeholder="<?php echo asl_esc_lbl('enter_loc') ?>" class="<?php echo $search_type_class ?> form-control isp_ignore">
                <button type="button" class="span-geo"><i class="<?php echo $geo_btn_class ?>" title="<?php echo ($all_configs['geo_button'] == '1') ? __('Current Location', 'asl_locator') : __('Search Location', 'asl_locator') ?>"></i></button>
              </div>

              <div class="sl-form-group range_filter asl-ddl-filters flex-2 hidden">
                <label><?php echo asl_esc_lbl('in') ?></label>
                <div class="rangeFilter asl-filter-cntrl">
                  <input id="asl-radius-slide" type="text" class="span2" />
                  <span class="rad-unit"><?php echo asl_esc_lbl('radius') ?>: <span id="asl-radius-input"></span><span id="asl-dist-unit"><?php echo asl_esc_lbl('km', 'asl_locator') ?></span></span>
                </div>
              </div>

            </div>

            <div class="asl-advance-filters animate__animated animate__fadeIn animate__delay-4s hidden lg:flex">
              <div class="asl-ddl-filters w-1/2">
                <div class="asl-filter-cntrl">
                  <!-- <label class="asl-cntrl-lbl"><?php echo asl_esc_lbl($filter_ddl[0]) ?></label> -->
                  <div class="sl-dropdown-cont" id="<?php echo $filter_ddl[0] ?>_filter">
                  </div>
                </div>
              </div>

              <div class="asl-ddl-filters w-1/2">
                <div class="asl-filter-cntrl">
                  <!-- <label class="asl-cntrl-lbl"><?php echo asl_esc_lbl($filter_ddl[1]) ?></label> -->
                  <div class="sl-dropdown-cont" id="<?php echo $filter_ddl[1] ?>_filter">
                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>
      <?php endif; ?>

      <div id="asl-panel" class="asl-panel asl_locator-panel">

        <!-- OVERLAY -->
        <div class="asl-overlay" id="map-loading">
          <div class="white"></div>
          <div class="sl-loading">
            <i class="animate-sl-spin icon-spin3"></i>
            <?php echo asl_esc_lbl('loading') ?>
          </div>
        </div>

        <!-- LIST -->
        <div class="asl-panel-inner">
          <div class="top-title Num_of_store hidden">
            <span><span class="sl-head-title"><?php echo $all_configs['head_title'] ?></span>: <span class="count-result">0</span></span>
            <?php if ($all_configs['branches'] == '1') : ?>
              <a title="<?php echo asl_esc_lbl('bck_to_list') ?>" class="sl-hide-branches d-none"><i class="icon-back mr-1"></i><?php echo asl_esc_lbl('bck_to_list') ?></a>
            <?php else : ?>
              <a class="asl-print-btn"><span><?php echo asl_esc_lbl('print') ?></span><span class="asl-print"></span></a>
            <?php endif; ?>
          </div>
          <div class="sl-main-cont-box">
            <div id="asl-list" class="sl-list-wrapper">
              <ul id="p-statelist" class="sl-list">
              </ul>
            </div>
          </div>
        </div>

      </div>

    </div>

    <div class="map-column-2">
      <!-- MAP -->
      <div id="asl-map-canv" class="asl-map-canv"></div>
      <?php include ASL_PLUGIN_PATH . 'public/partials/_agile_modal.php'; ?>
    </div>

  </div>
</div>



<script>
  // body onload
  jQuery(document).ready(function($) {
    jQuery('#agile-store-locator-tmpl-1-css, #agile-store-locator-sl-bootstrap-css').remove();
  });
</script>

<script id="tmpl_list_item" type="text/x-jsrender">
  <div class="tw_card-container" data-id="{{:id}}">

  <div class="tw_card-content">

    <div class="tw_card-body">
      <div class="tw_card-header">
        <?php $logomark = wp_get_attachment_image_src(25165, 'full'); ?>
        <img class="tw_card-logo" src="<?= $logomark[0] ?>" alt="SportsMed {{:title}} Logo">
        <div>
          <div class="tw_card-title text-[--custom-color-title]">{{:title}}</div>
          <div class="tw_card-subtitle">{{:str_special}}</div>
        </div>
      </div>
      <div class="tw_card-info">
        <div>
          {{:street}}<br>
          {{:city}}, {{:state}} {{:postal_code}}
          {{if dist_str}}
            <br><small>{{:dist_str}}</small>
          {{/if}}
        </div>
        <a href="tel:{{:phone}}" class="tw_map-phone map-phone">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M5.58685 5.90223C6.05085 6.86865 6.68337 7.77441 7.48443 8.57546C8.28548 9.37651 9.19124 10.009 10.1577 10.473C10.2408 10.5129 10.2823 10.5329 10.3349 10.5482C10.5218 10.6027 10.7513 10.5636 10.9096 10.4502C10.9542 10.4183 10.9923 10.3802 11.0685 10.304C11.3016 10.071 11.4181 9.95443 11.5353 9.87824C11.9772 9.59091 12.5469 9.59091 12.9889 9.87824C13.106 9.95443 13.2226 10.071 13.4556 10.304L13.5856 10.4339C13.9398 10.7882 14.117 10.9654 14.2132 11.1556C14.4046 11.534 14.4046 11.9809 14.2132 12.3592C14.117 12.5495 13.9399 12.7266 13.5856 13.0809L13.4805 13.186C13.1274 13.5391 12.9508 13.7156 12.7108 13.8505C12.4445 14.0001 12.0308 14.1077 11.7253 14.1068C11.45 14.1059 11.2619 14.0525 10.8856 13.9457C8.86333 13.3718 6.95509 12.2888 5.36311 10.6968C3.77112 9.10479 2.68814 7.19655 2.11416 5.17429C2.00735 4.79799 1.95395 4.60984 1.95313 4.33455C1.95222 4.02906 2.0598 3.6154 2.20941 3.34907C2.34424 3.10904 2.52078 2.9325 2.87386 2.57942L2.97895 2.47433C3.33325 2.12004 3.5104 1.94289 3.70065 1.84666C4.07903 1.65528 4.52587 1.65528 4.90424 1.84666C5.0945 1.94289 5.27164 2.12004 5.62594 2.47433L5.75585 2.60424C5.98892 2.83732 6.10546 2.95385 6.18165 3.07104C6.46898 3.51296 6.46898 4.08268 6.18165 4.52461C6.10546 4.6418 5.98892 4.75833 5.75585 4.9914C5.67964 5.06761 5.64154 5.10571 5.60965 5.15026C5.4963 5.30854 5.45717 5.53805 5.51165 5.72495C5.52698 5.77754 5.54694 5.81911 5.58685 5.90223Z" stroke="#475467" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>{{:phone}}</span>
        </a>
      </div>
    </div>

    <img class="tw_card-image" src="{{:featured_image_url}}.webp" alt="{{:title}}">

  </div>

  <div class="tw_card-footer">
    <a class="tw_btn-secondary" href="{{:link}}">Learn More</a>
    <a class="tw_btn-primary" href="/get-started-now/location/?title={{:title}}">Make An Appointment</a>
  </div>

</div>
</script>


<!-- <div class="backdrop-blur-sm"> -->

<script id="asl_too_tip" type="text/x-jsrender">

  <div class="tw_card-container tw_card-container__infobox tw_card-container__tooltip" data-id="{{:id}}">
<div class="tw_card-content">

  <div class="tw_card-body">
    <div class="tw_card-header">
      <?php $logomark = wp_get_attachment_image_src(25165, 'full'); ?>
      <img class="tw_card-logo" src="<?= $logomark[0] ?>" alt="SportsMed {{:title}} Logo">
      <div>
        <div class="tw_card-title">{{:title}}</div>
        <div class="tw_card-subtitle">{{:str_special}}</div>
      </div>
    </div>
    <div class="tw_card-info pb-0">
      <div>
        {{:street}}<br>
        {{:city}}, {{:state}} {{:postal_code}}
        {{if dist_str}}
          <br><small>{{:dist_str}}</small>
        {{/if}}
      </div>
      <a href="tel:{{:phone}}" class="tw_map-phone map-phone">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
          <path d="M5.58685 5.90223C6.05085 6.86865 6.68337 7.77441 7.48443 8.57546C8.28548 9.37651 9.19124 10.009 10.1577 10.473C10.2408 10.5129 10.2823 10.5329 10.3349 10.5482C10.5218 10.6027 10.7513 10.5636 10.9096 10.4502C10.9542 10.4183 10.9923 10.3802 11.0685 10.304C11.3016 10.071 11.4181 9.95443 11.5353 9.87824C11.9772 9.59091 12.5469 9.59091 12.9889 9.87824C13.106 9.95443 13.2226 10.071 13.4556 10.304L13.5856 10.4339C13.9398 10.7882 14.117 10.9654 14.2132 11.1556C14.4046 11.534 14.4046 11.9809 14.2132 12.3592C14.117 12.5495 13.9399 12.7266 13.5856 13.0809L13.4805 13.186C13.1274 13.5391 12.9508 13.7156 12.7108 13.8505C12.4445 14.0001 12.0308 14.1077 11.7253 14.1068C11.45 14.1059 11.2619 14.0525 10.8856 13.9457C8.86333 13.3718 6.95509 12.2888 5.36311 10.6968C3.77112 9.10479 2.68814 7.19655 2.11416 5.17429C2.00735 4.79799 1.95395 4.60984 1.95313 4.33455C1.95222 4.02906 2.0598 3.6154 2.20941 3.34907C2.34424 3.10904 2.52078 2.9325 2.87386 2.57942L2.97895 2.47433C3.33325 2.12004 3.5104 1.94289 3.70065 1.84666C4.07903 1.65528 4.52587 1.65528 4.90424 1.84666C5.0945 1.94289 5.27164 2.12004 5.62594 2.47433L5.75585 2.60424C5.98892 2.83732 6.10546 2.95385 6.18165 3.07104C6.46898 3.51296 6.46898 4.08268 6.18165 4.52461C6.10546 4.6418 5.98892 4.75833 5.75585 4.9914C5.67964 5.06761 5.64154 5.10571 5.60965 5.15026C5.4963 5.30854 5.45717 5.53805 5.51165 5.72495C5.52698 5.77754 5.54694 5.81911 5.58685 5.90223Z" stroke="#475467" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span>{{:phone}}</span>
      </a>
    </div>
  </div>

  <img class="tw_card-image" src="{{:featured_image_url}}.webp" alt="{{:title}}">

</div>

<div class="tw_card-footer !hidden lg:!flex">
  <a class="tw_btn-primary" href="/get-started-now/location/?title={{:title}}">Make Appointment</a>
  <a class="tw_btn-secondary" href="{{:link}}">Learn More &rarr;</a>
</div>

</div>
</script>


<!-- <div class="text-3xl !hidden lg:!flex"></div> -->


<script type="text/javascript">
  document.addEventListener('readystatechange', function() {
    window['asl_tmpls'] = {};
    window['asl_tmpls']['list'] = '#tmpl_list_item';
    window['asl_tmpls'] = {};
    window['asl_tmpls']['infobox'] = '#asl_too_tip';
  });
</script>

<!-- <div class="border-blue-600 border-2 !border-blue-600 !border-2"></div> -->

<script type="text/javascript">
  function asl_event_hook(_event) {
    if (_event.type == 'select') {
      jQuery(".tw_card-container").removeClass('!border-2 !border-blue-600');
      jQuery(".tw_card-container[data-id='" + _event.data.id + "']").addClass('!border-blue-600 !border-2');
    }
  }
</script>