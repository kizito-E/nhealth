<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="add-bannerunit">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?php _e('Добавление баннерного блока'); ?></h4>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>
                        <?php _e('Имя блока'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php _e('Имя блока, будет видно только вам.'); ?>">
                        </i>
                    </label>
                    <input v-model="name" type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label>
                        <?php _e('Размер баннера'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php _e('Укажите размер баннера для этого рекламного блока. В этом блоке будут показаны баннеры только этого размера.'); ?>">
                        </i>
                    </label>
                    <select v-model="banner_size"
                            class="form-control selectpicker"
                            data-style="btn-default btn-flat"
                            data-width="100%">
                        <option v-for="size in allowed_banners_sizes" v-bind:value="size">
                            {{size}}
                        </option>
                    </select>
                </div>

                <div v-if="site_isolated == 0" class="form-group">
                    <label>
                        <?php _e('Показывать в блоке баннеры с оплатой за:'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php _e('Вы можете разрешить или запретить показывать в блоке баннеры с оплатой за клики или показы.'); ?>">
                        </i>
                    </label>
                    <select v-model="allowed_payments"
                            multiple
                            class="form-control selectpicker"
                            data-style="btn-default btn-flat"
                            data-width="100%">
                        <option value='cpc'><?php _e('Клики'); ?></option>
                        <option value='cpv'><?php _e('Показы'); ?></option>
                    </select>
                </div>

                <div v-if="site_isolated == 0" class="row form-group">

                    <div class="col-lg-6">
                        <label>
                            <?php _e('Минимальная цена за клик'); ?>
                            <i class="fa fa-question-circle text-primary"
                               data-toggle="tooltip"
                               title="<?php _e('Вы можете отключить показ баннеров, у которых цена за клик ниже требуемой.'); ?>">
                            </i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo get_globalsettings('current_currency', 'USD')?></span>
                            <input-amount
                                v-model="min_cpc"
                                min="<?php echo config_item('min_cpc'); ?>"
                                max="<?php echo config_item('max_cpc'); ?>">
                            </input-amount>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <label>
                            <?php _e('Минимальная цена за 1000 показов'); ?>
                            <i class="fa fa-question-circle text-primary"
                               data-toggle="tooltip"
                               title="<?php _e('Вы можете отключить показ баннеров, у которых цена за 1000 показов ниже требуемой.'); ?>">
                            </i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo get_globalsettings('current_currency', 'USD')?></span>
                            <input-amount
                                v-model="min_cpv"
                                min="<?php echo config_item('min_cpv'); ?>"
                                max="<?php echo config_item('max_cpv'); ?>">
                            </input-amount>
                        </div>

                    </div>
                </div>

                <div class="row form-group">

                    <div class="col-lg-12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                       v-model="params.third_party_status"
                                       true-value="1"
                                       false-value="0">
                                <b><?php _e('Транслировать код заглушки'); ?></b>
                                <i class="fa fa-question-circle text-primary"
                                   data-toggle="tooltip"
                                   title="<?php _e('При отсутствии подходящих баннеров от рекламодателей, вы можете настроить трансляцию кода сторонней рекламной системы. Например Google Adsense.'); ?>">
                                </i>
                            </label>
                        </div>

                        <textarea
                            v-model="params.third_party_code"
                            class="form-control text-sm"
                            rows="5"
                            placeholder="<?php _e('Вставьте сюда валидный javascript код. Например &lt;script&gt;alert(&quot;Test!&quot;);&lt;/script&gt;'); ?>">
                        </textarea>

                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <p class="text-muted">
                            <?php _e('Все поля обязательны для заполнения.'); ?>
                        </p>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button @click="closeModal" data-dismiss="modal" class="btn btn-default pull-left">
                    <?php _e('Закрыть'); ?>
                </button>

                <button v-if="!complete" @click="addBannerUnit" v-bind:disabled="button_active" class="btn btn-primary">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    <?php _e('Сохранить'); ?>
                </button>

            </div>
        </div>
    </div>
</div>