<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="add-adunit">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 v-if="!edit_mode" class="modal-title"><?php _e('Добавление тексто-графического блока'); ?></h4>
                <h4 v-else class="modal-title"><?php _e('Редактирование тексто-графического блока'); ?></h4>
            </div>

            <div class="nav-tabs-custom" style="margin-bottom:0;">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1" data-toggle="tab" aria-expanded="true">
                            <i class="fa fa-cog" aria-hidden="true"></i>
                            <?php _e('Параметры'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#tab_2" data-toggle="tab" aria-expanded="false">
                            <i class="fa fa-paint-brush" aria-hidden="true"></i>
                            <?php _e('Стилизация'); ?>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="modal-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <ad-unit-params :config="config" v-model="unit_params"></ad-unit-params>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <ad-unit-visual-builder :close="close_modal" v-model="unit_visual_params"></ad-unit-visual-builder>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button @click="closeModal" class="pull-left btn btn-default" data-dismiss="modal" aria-label="Close">
                    <?php _e('Закрыть'); ?>
                </button>
                <button v-if="!button_hidden" @click="save" class="btn btn-primary">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    <?php _e('Сохранить'); ?>
                </button>
            </div>
        </div>
    </div>
</div>