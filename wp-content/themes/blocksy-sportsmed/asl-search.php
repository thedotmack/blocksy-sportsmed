<?php

$geo_btn_class      = ($all_configs['geo_button'] == '1')?'asl-geo icon-direction-outline':'icon-search';
$search_type_class  = ($all_configs['search_type'] == '1')?'asl-search-name':'asl-search-address';

$with_categories    = (isset($all_configs['category_control']) && $all_configs['category_control'] == '0')? false: true;
$bg_color           = (isset($all_configs['bg-color']))? 'style="background-color:'.$all_configs['bg-color'].'"': '';
$btn_color          = (isset($all_configs['btn-color']))? 'style="background-color:'.$all_configs['btn-color'].'"': '';

$btn_color_hex      = (isset($all_configs['btn-color']) && $all_configs['btn-color'])? $all_configs['btn-color']: '';

$dropdown_count  = ($with_categories)? 1: 0;
$dropdown_count += ($filter_ddl)? count($filter_ddl): 0;


$search_columns   = 10;
$search_columns  -= ($dropdown_count * 2);


?>
<div id="asl-search" class="asl-cont asl-search">
    <div class="sl-container">
      <section class="asl-search-cont" <?php echo $bg_color ?>>
        <!-- <h3><?php echo asl_esc_lbl('search_loc1') ?></h3> -->
        <div class="sl-row">
            <div class="pol-lg-12">
                <div class="sl-row asl-search-widget text-center center-block">
                    <div class="pol-md-10 p-0">
                        <button class="asl-clear-btn" type="button"><svg width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg"><path d="M.566 1.698L0 1.13 1.132 0l.565.566L6 4.868 10.302.566 10.868 0 12 1.132l-.566.565L7.132 6l4.302 4.3.566.568L10.868 12l-.565-.566L6 7.132l-4.3 4.302L1.13 12 0 10.868l.566-.565L4.868 6 .566 1.698z"></path></svg></button>
                        <input data-submit="disable"  id="sl-search-widget-text" class="form-control asl-search-cntrl isp_ignore border-r-0" placeholder="<?php echo asl_esc_lbl('enter_loc') ?>">
                        <span class="err-spn"><?php echo asl_esc_lbl('missing_dest') ?></span>
                        <a title="<?php echo asl_esc_lbl('current_location') ?>" class="sl-geo-btn asl-geo">
                            <svg width="20px" height="20px" viewBox="0 0 561 561" fill="<?php echo $btn_color_hex ?>">
                                <path d="M280.5,178.5c-56.1,0-102,45.9-102,102c0,56.1,45.9,102,102,102c56.1,0,102-45.9,102-102 C382.5,224.4,336.6,178.5,280.5,178.5z M507.45,255C494.7,147.9,410.55,63.75,306,53.55V0h-51v53.55 C147.9,63.75,63.75,147.9,53.55,255H0v51h53.55C66.3,413.1,150.45,497.25,255,507.45V561h51v-53.55 C413.1,494.7,497.25,410.55,507.45,306H561v-51H507.45z M280.5,459C181.05,459,102,379.95,102,280.5S181.05,102,280.5,102 S459,181.05,459,280.5S379.95,459,280.5,459z"></path>
                            </svg>
                        </a>
                    </div>
                    <?php if($with_categories): ?>
                     <div class="pol-md p-0">
                        <div class="categories_filter">
                          <select class="form-control border-0" id="asl-categories"></select>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($filter_ddl): ?>
                    <?php foreach ($filter_ddl as $a_filter):?>
                    <div class="pol-md p-0">
                        <div class="categories_filter">
                          <select class="form-control border-0" id="asl-<?php echo $a_filter ?>"></select>
                        </div>
                    </div>
                    <?php 
                    endforeach;
                    endif;
                    ?>
                    <div class="pol-md p-0">
                        <button id="asl-btn-search" type="button" <?php echo $btn_color ?> class="asl-search-btn border-l-0 btn btn-primary"><?php echo asl_esc_lbl( 'search') ?></button>
                    </div>
                </div>
            </div>
        </div>
      </section>
    </div>
</div>