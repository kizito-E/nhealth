<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function _active_btn($segment, $active_class, $default_class = '', $segment_num = 3)
{
    $CI = & get_instance();

    if ($CI->uri->segment($segment_num) == $segment) {
        echo $active_class;
    } else {
        echo $default_class;
    }
}
?>

<div class="row" style="margin-bottom: 15px;">
    <div class="col-md-12">

        <div class="btn-group">
            <a href="/administrator/statistics" class="btn <?php _active_btn(null, 'btn-danger', 'btn-default') ?>"><i class="fa fa-fw fa-calendar-check-o"></i> <?php _e('По дням') ?></a>
            <a href="/administrator/statistics/webmasters" class="btn <?php _active_btn('webmasters', 'btn-danger', 'btn-default') ?>"><i class="fa fa-fw fa-user"></i> <?php _e('По вебмастерам') ?></a>
            <a href="/administrator/statistics/sites" class="btn <?php _active_btn('sites', 'btn-danger', 'btn-default') ?>"><i class="fa fa-fw fa-globe"></i> <?php _e('По сайтам') ?></a>
            <a href="/administrator/statistics/units" class="btn <?php _active_btn('units', 'btn-danger', 'btn-default') ?>"><i class="fa fa-fw fa-th-large"></i> <?php _e('По блокам') ?></a>
            <a href="/administrator/statistics/advertisers" class="btn <?php _active_btn('advertisers', 'btn-danger', 'btn-default') ?>"><i class="fa fa-fw fa-user"></i> <?php _e('По рекламодателям') ?></a>
            <a href="/administrator/statistics/camps" class="btn <?php _active_btn('camps', 'btn-danger', 'btn-default') ?>"><i class="fa fa-fw fa-shopping-basket"></i> <?php _e('По кампаниям') ?></a>
            <a href="/administrator/statistics/ads" class="btn <?php _active_btn('ads', 'btn-danger', 'btn-default') ?>"><i class="fa fa-fw fa-bullhorn"></i> <?php _e('По обьявлениям') ?></a>
        </div>

        <?php if ($this->uri->segment(3) !== null): ?>

            <button type="button" class="btn btn-default" id="reportrange" style="margin-left: 20px;">
                <span>
                    <i class="fa fa-fw fa-calendar"></i>
                    <?php echo gmdate("Y/m/d - Y/m/d") ?>
                </span>
                <i class="fa fa-fw fa-caret-down"></i>
            </button>

        <?php endif; ?>


        <button id="dt-reload-btn" class="btn btn-default">
            <i class="fa fa-fw fa-refresh"></i>
            <?php _e('Обновить') ?>
        </button>

    </div>
</div>

