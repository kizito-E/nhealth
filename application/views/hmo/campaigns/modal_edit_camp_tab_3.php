<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane" id="_3">

    <div class="form-group">
        <label>
            <?php _e('Блэклист сайтов'); ?> 
            <i class="fa fa-question-circle text-primary"
               data-toggle="tooltip"
               title="<?php _e('Обьявления НЕ будут показаны на выбранных сайтах.'); ?>">
            </i> 
        </label>
        <span class="pull-right"><?php _e('Заблокированных сайтов:') ?> {{countBlSites || 0}}</span>

        <textarea v-model="computedBlSites" class="form-control" rows="11" placeholder="<?php _e('Каждый сайт с новой строки.'); ?>"></textarea>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <i class="text-muted"><?php _e('Обявления данной рекламной кампании не будут показаны на этих сайтах.'); ?></i>
        </div>
    </div>
</div>