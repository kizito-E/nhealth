<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="add-dsa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4><?php _e('Добавление обьявления'); ?></h4>
            </div>
            <div class="modal-body">

                <div class="row form-group">
                    <div class="col-md-12">
                        <div v-if="!img_src" class="advertiser-upload-banner-box">
                            <label class="btn btn-default">
                                <i class="fa fa-folder-open"></i> <?php _e('Выбрать изображение'); ?>
                                <input @change="changeInputFile" type="file" class="hidden">
                            </label>
                            <div>
                                <strong><?php _e('Разрешенные форматы изображений:'); ?></strong>
                                <p class="text-muted">JPEG, PNG, GIF</p>
                            </div>
                        </div>

                        <div v-else class="advertiser-preview-image-box">
                            <img v-bind:src="img_src">
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-xs-12 form-group">
                        <label><?php _e('Заголовок'); ?><span class="text-red"> *</span></label>
                        <input v-model="title" type="text" maxlength="<?php echo config_item('max_title_len') ?>" class="form-control" placeholder="<?php printf(__('Максимум %s символов'), config_item('max_title_len')); ?>">
                    </div>

                    <div class="col-xs-12 form-group">
                        <label><?php _e('Описание'); ?><span class="text-red"> *</span></label>
                        <textarea v-model="description" maxlength="<?php echo config_item('max_descr_len') ?>" class="form-control" placeholder="<?php printf(__('Максимум %s символов'), config_item('max_descr_len')); ?>"></textarea>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label><?php _e('URL'); ?><span class="text-red"> *</span></label>
                        <div class="input-group">
                            <input v-model="ad_url" type="text" class="form-control" placeholder="http://...">
                            <span class="input-group-btn">
                                <button @click="macros_box = !macros_box" class="btn btn-default btn-flat"> <b>{<?php _e('Макросы'); ?>}</b></button>
                            </span>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label><?php _e('Текст на кнопке (Призыв к действию)'); ?></label>
                        <input v-model="action_text" type="text" maxlength="20" class="form-control" placeholder="<?php _e('Например: Купить'); ?>">
                    </div>

                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div v-if="macros_box" class="alert alert-default alert-dismissible text-sm animated fadeIn">
                            <button @click="macros_box = !macros_box" class="close">×</button>
                            <strong><i class="fa fa-info-circle"></i> <?php _e('Используйте макросы для подстановки значений в ссылку.') ?></strong>
                            <br>
                            <span class="text-muted text-dashed">
                                http://advertised-site.com/?site_id=<b class="text-red">{site}</b>&camp_id=<b class="text-red">{camp-id}</b>&ad_id=<b class="text-red">{ad-id}</b>&date=<b class="text-red">{datetime}</b>
                            </span>
                            <br>
                            <b class="text-black">{site}</b> - <?php _e('Подставит в ссылку домен.') ?><br>
                            <b class="text-black">{camp-id}</b> - <?php _e('Подставит в ссылку ID кампании.') ?><br>
                            <b class="text-black">{ad-id}</b> - <?php _e('Подставит в ссылку ID обьявления.') ?><br>
                            <b class="text-black">{date}</b> - <?php _e('Подставит в ссылку дату клика в формате "2019-05-25"') ?><br>
                            <b class="text-black">{time}</b> - <?php _e('Подставит в ссылку время клика в формате "19-45"') ?><br>
                            <b class="text-black">{fulltime}</b> - <?php _e('Подставит в ссылку время клика в формате "19-45-58"') ?><br>
                            <b class="text-black">{device}</b> - <?php _e('Подставит в ссылку тип устройства (Computer, Tablet, Mobile)') ?><br>
                        </div>
                    </div>
                </div>

                <div v-if="camp_isolated == 0" class="row">

                    <div class="col-xs-6 form-group">
                        <label><?php _e('Тип оплаты'); ?><span class="text-red"> *</span></label>
                        <select v-model="payment_mode" class="selectpicker" data-style="btn-default btn-flat" data-width="100%">
                            <option value="cpc"><?php _e('Оплата за клики (CPC)'); ?></option>
                            <option value="cpv"><?php _e('Оплата за показы (CPV)'); ?></option>
                        </select>
                    </div>

                    <div class="col-xs-6">
                        <label>
                            <span v-if="payment_mode == 'cpc'"><?php _e('Цена за клик'); ?></span>
                            <span v-else><?php _e('Цена за 1000 показов'); ?></span>
                            <span class="text-red"> *</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo get_globalsettings('current_currency', 'USD')?></span>
                            <input v-if="(payment_mode == 'cpc')" v-model="cpc" @change="formatedCPC" class="form-control">
                            <input v-else v-model="cpv" @change="formatedCPV" class="form-control">
                        </div>
                    </div>

                </div>

            </div>

            <div v-if="add_success" class="modal-footer">
                <button @click="closeModal" data-dismiss="modal" class="btn btn-default pull-left"><?php _e('Закрыть') ?></button>
                <button @click="addMore" class="btn btn-primary"><i class="fa fa-plus"></i> <?php _e('Еще одно') ?></button>
            </div>

            <div v-else>
                <div class="modal-footer">
                    <button @click="resetInputFile" class="btn btn-danger pull-left"><?php _e('Очистить изображение') ?></button>
                    <button @click="addDsa" class="btn btn-success">
                        <i v-if="active_button" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                        <i v-else class="fa fa-check"></i>
                        <?php _e('Сохранить') ?>
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>



