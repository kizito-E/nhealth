<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="add-camp">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?php _e('Новая кампания'); ?></h4>
            </div>

            <div class="nav-tabs-custom" style="margin-bottom:0;">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-cog" aria-hidden="true"></i> <?php _e('Параметры'); ?></a>
                    </li>
                    <li>
                        <a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-bullseye" aria-hidden="true"></i> <?php _e('Таргетинг'); ?></a>
                    </li>
                    <li>
                        <a href="#tab_3" data-toggle="tab" aria-expanded="false"><i class="fa fa-ban" aria-hidden="true"></i> <?php _e('Блэклист'); ?></a>
                    </li>
                </ul>
            </div>

            <div class="modal-body">

                <div class="tab-content">
                    <?php include_once __DIR__ . "/modal_add_camp_tab_1.php"; ?>

                    <?php include_once __DIR__ . "/modal_add_camp_tab_2.php"; ?>

                    <?php include_once __DIR__ . "/modal_add_camp_tab_3.php"; ?>

                </div>

            </div>

            <div class="modal-footer">
                <button @click="closeModal" class="btn btn-default pull-left" data-dismiss="modal" aria-label="Close"><?php _e('Закрыть'); ?></button>
                <button v-if="!is_complete" @click="addCamp" v-bind:disabled="button_active" class="btn btn-primary">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    <?php _e('Сохранить'); ?>
                </button>

            </div>
        </div>
    </div>
</div>
