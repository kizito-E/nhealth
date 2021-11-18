<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"><?php _e('123'); ?></h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label><?php _e('Сайт'); ?><span class="text-red"> *</span></label>
                    <input type="text" class="form-control" placeholder="">
                </div>

            </div>

            <div class="modal-footer">

                <button @click="closeModal" class="btn btn-default pull-left">
                    <?php _e('Закрыть'); ?>
                </button>

                <button @click="addSite" class="btn btn-danger">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    <?php _e('Сохранить'); ?>
                </button>

            </div>
        </div>
    </div>
</div>

