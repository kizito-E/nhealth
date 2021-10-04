<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="edit-banner" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span></button>
                <h4><?php _e('Редактирование баннера'); ?> [ID:{{ad_id}}]</h4>
            </div>
            <div class="modal-body">

                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="advertiser-preview-banner-box">

                            <img v-bind:src="img_src">

                            <ul class="list-group list-group-sm pull-right" style="display: inline-block;">
                                <li class="list-group-item list-group-item-sm">
                                    <b><?php _e('ширина:'); ?> </b>{{img_w}}px
                                </li>
                                <li class="list-group-item list-group-item-sm">
                                    <b><?php _e('высота:'); ?> </b>{{img_h}}px
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-xs-12 form-group">
                        <label><?php _e('Заголовок'); ?><span class="text-red"> *</span></label>
                        <input v-model="title" type="text" maxlength="<?php echo config_item('max_title_len') ?>" class="form-control" placeholder="<?php printf(__('Максимум %s символов'), config_item('max_title_len')); ?>">
                    </div>

                    <div class="col-xs-12 form-group">
                        <label><?php _e('URL'); ?><span class="text-red"> *</span></label>
                        <div class="input-group">
                            <input v-model="ad_url" @focus="remoderateNotise = true" @blur="remoderateNotise = false"  type="text" class="form-control" placeholder="http://...">
                            <span class="input-group-btn">
                                <button @click="macros_box = !macros_box" class="btn btn-default btn-flat"> <b><?php _e('UTM-метки'); ?></b></button>
                            </span>
                        </div>

                    </div>

                    <div class="col-xs-12">
                        <div v-if="remoderateNotise && (status == 1 || status == 0)" class="callout callout-info">
                            <?php _e('При изменении URL - обьявление будет отправлено на повторную модерацию!'); ?>
                        </div>

                    </div>


                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div v-if="macros_box" class="alert alert-default alert-dismissible text-sm animated fadeIn">
                            <button @click="macros_box = !macros_box" class="close">×</button>
                            <strong><i class="fa fa-info-circle"></i> <?php _e('Используйте макросы для подстановки значений в ссылку.') ?></strong>
                            <br>
                            <span class="text-muted text-dashed" style="white-space: nowrap; font-size: 14px; font-weight: bold;">
                                http://site.com/?utm_source=<b class="text-red">{site}</b>&utm_campaign=<b class="text-red">{camp-id}</b>&utm_content=<b class="text-red">{ad-id}</b>
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
                        <select v-model="payment_mode" class="form-control" data-style="btn-default btn-flat" data-width="100%">
                            <option value="cpc"><?php _e('Оплата за клики (CPC)'); ?></option>
                            <option value="cpv"><?php _e('Оплата за показы (CPV)'); ?></option>
                        </select>
                    </div>

                    <div class="col-xs-6 form-group">
                        <label>
                            <span v-if="payment_mode == 'cpc'"><?php _e('Цена за клик'); ?></span>
                            <span v-else><?php _e('Цена за 1000 показов'); ?></span>
                            <span class="text-red"> *</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo get_globalsettings('current_currency', 'USD')?></span>

                            <input-amount v-if="(payment_mode == 'cpc')"
                                          v-model="cpc"
                                          min="<?php echo config_item('min_cpc'); ?>"
                                          max="<?php echo config_item('max_cpc'); ?>">
                            </input-amount>

                            <input-amount v-else
                                          v-model="cpv"
                                          min="<?php echo config_item('min_cpv'); ?>"
                                          max="<?php echo config_item('max_cpv'); ?>">
                            </input-amount>

                        </div>
                    </div>

                </div>

                <div class="row">
                    <div  class="col-xs-12">
                        <i class="text-muted">
                            <?php _e('При изменении URL - баннер попадет на повторную модерацию. Редактирование изображения не поддерживается.'); ?>
                        </i>
                    </div>
                </div>

            </div>


            <div>

                <div class="modal-footer">
                    <button @click="closeModal" data-dismiss="modal" class="btn btn-default pull-left"><?php _e('Закрыть') ?></button>
                    <button @click="updateBanner" v-bind:disabled="active_button" class="btn btn-success">
                        <i v-if="active_button" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                        <i v-else class="fa fa-check"></i>
                        <?php _e('Сохранить') ?>
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>



