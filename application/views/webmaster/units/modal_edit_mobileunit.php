<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="edit-mobileunit">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?php _e('Редактирование мобильного блока'); ?> - [ID: {{unit_id}}]</h4>
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
                        <?php _e('Положение обьявления'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           data-placement="right"
                           title="<img width='200' height='178' src='/assets/imgs/mobile_units_example.jpg'>">
                        </i>
                    </label>
                    <select v-model="params.position"
                            class="form-control selectpicker"
                            data-style="btn-default btn-flat"
                            data-width="100%">
                        <option value="top"><?php _e('Вверху экрана'); ?></option>
                        <option value="bottom"><?php _e('Внизу экрана'); ?></option>
                    </select>
                </div>


                <div class="row form-group">

                    <div class="col-sm-12">
                        <label>
                            <?php _e('Не показывать после закрытия:'); ?>
                            <i class="fa fa-question-circle text-primary"
                               data-toggle="tooltip"
                               title="<?php _e('После того как пользователь закрыл обьявление, оно будет скрыто указанное количество секунд.'); ?>">
                            </i>
                        </label>

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </div>

                            <input-number
                                    v-model="params.hidden_period"
                                    min="0"
                                    max="86400">
                            </input-number>

                        </div>
                    </div>


<!--                    <div class="col-lg-6">-->
<!--                        <label>-->
<!--                            --><?php //_e('Задержка появления:'); ?>
<!--                            <i class="fa fa-question-circle text-primary"-->
<!--                               data-toggle="tooltip"-->
<!--                               title="--><?php //_e('Обьявление будет показано через указанное количество секунд после загрузки страници.'); ?><!--">-->
<!--                            </i>-->
<!--                        </label>-->
<!---->
<!--                        <div class="input-group">-->
<!--                            <div class="input-group-addon">-->
<!--                                <i class="fa fa-clock-o"></i>-->
<!--                            </div>-->
<!---->
<!--                            <input-number -->
<!--                                v-model="params.show_delay"-->
<!--                                min="0"-->
<!--                                max="300">-->
<!--                            </input-number>-->
<!---->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="col-lg-6">-->
<!--                        <label>-->
<!--                            --><?php //_e('Не показывать после закрытия:'); ?>
<!--                            <i class="fa fa-question-circle text-primary"-->
<!--                               data-toggle="tooltip"-->
<!--                               title="--><?php //_e('После того как пользователь закрыл обьявление, оно будет скрыто указанное количество секунд.'); ?><!--">-->
<!--                            </i>-->
<!--                        </label>-->
<!---->
<!--                        <div class="input-group">-->
<!--                            <div class="input-group-addon">-->
<!--                                <i class="fa fa-clock-o"></i>-->
<!--                            </div>-->
<!---->
<!--                            <input-number -->
<!--                                v-model="params.hidden_period"-->
<!--                                min="0"-->
<!--                                max="86400">-->
<!--                            </input-number>-->
<!---->
<!--                        </div>-->
<!--                    </div>-->
                </div>

                <div class="form-group">
                    <label>
                        <?php _e('Показывать в блоке обьявления с оплатой за:'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php _e('Вы можете разрешить или запретить показывать в блоке обьявления с оплатой за клики или показы.'); ?>">
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


                <div class="row form-group">

                    <div class="col-lg-6">
                        <label>
                            <?php _e('Минимальная цена за клик'); ?>
                            <i class="fa fa-question-circle text-primary"
                               data-toggle="tooltip"
                               title="<?php _e('Вы можете отключить показ обьявлений, у которых цена за клик ниже требуемой.'); ?>">
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
                               title="<?php _e('Вы можете отключить показ обьявлений, у которых цена за 1000 показов ниже требуемой.'); ?>">
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

                <div class="row">
                    <div class="col-lg-12">
                        <i class="text-muted">
                            <?php _e('Все поля обязательны для заполнения.'); ?><br>
                        </i>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button @click="closeModal" data-dismiss="modal" class="btn btn-default pull-left">
                    <?php _e('Закрыть'); ?>
                </button>

                <button @click="updateMobileUnit" v-bind:disabled="button_active" class="btn btn-primary">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    <?php _e('Сохранить'); ?>
                </button>


            </div>
        </div>
    </div>
</div>