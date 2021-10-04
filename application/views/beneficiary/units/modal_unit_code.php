<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="unit-code-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button  type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?php _e('Получение кода блока для сайта - '); ?><?php echo $site; ?></h4>
            </div>

            <div class="modal-body">
                <div class="callout callout-info">
                    <?php _e('Добавьте этот код на сайт - '); ?><b><?php echo strtoupper($site); ?></b><br>
                    <?php _e('В то место где вы хотите показывать рекламу.'); ?>
                </div>
                <textarea id="unit-code" readonly class="form-control text-sm" rows="15" style="resize: none;"></textarea>
            </div>

            <div class="modal-footer">
                <button id="copy-unit-code-btn" class="pull-left btn btn-success">
                    <i class="fa fa-clipboard"></i>
                    <?php _e('Копировать код в буффер обмена'); ?>
                </button>

                <button class="btn btn-default" data-dismiss="modal" aria-label="Close">
                    <?php _e('Закрыть'); ?>
                </button>
            </div>
        </div>
    </div>
</div>