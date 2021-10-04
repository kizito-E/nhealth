<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="payout-start">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">{{id}} - <?php _e('начало обработки выплаты'); ?></h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <div class="callout callout-info">
                        <p>
                            <?php _e('В целях безопасности, выплаты производятся в ручном режиме.'); ?>
                        </p>
                        <p>
                            <?php _e('Это значит что вам нужно самостоятельно перевести деньги со своего PayPal счета на PayPal счет вебмастера. И после этого подтвердить успешность платежа на этой странице.'); ?>
                        </p>
                        <p>
                            <?php _e('PayPal аккаунт вебмастера и сумма для перевода указаны ниже.'); ?>
                        </p>
                    </div>
                </div>


                <div class="form-group">
                    <label><?php _e('PayPal аккаунт вебмастера'); ?></label>

                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-fw fa-paypal"></i>
                        </span>
                        <input ref="payout_account" v-model="payout_account" @focus="$event.target.select()" type="text" class="form-control" readonly>
                        <span class="input-group-btn">
                            <button @click="copy('payout_account')" class="btn btn-default btn-flat">
                                <i class="fa fa-fw fa-clipboard"></i>
                            </button>
                        </span>
                    </div>

                    <span class="text-muted">
                        <?php _e('На этот PayPal аккаунт нужно перевести деньги.'); ?>
                    </span>
                </div>

                <div class="form-group">
                    <label><?php _e('Сумма для перевода'); ?></label>

                    <div class="input-group">
                        <span class="input-group-addon">
                            {{ currency }}
                        </span>
                        <input ref="amount" v-model="amount" @focus="$event.target.select()" type="text" class="form-control" readonly>
                        <span class="input-group-btn">
                            <button @click="copy('amount')" class="btn btn-default btn-flat">
                                <i class="fa fa-fw fa-clipboard"></i>
                            </button>
                        </span>
                    </div>

                    <span class="text-muted">
                        <?php _e('Сумма которую нужно перевести.'); ?>
                    </span>
                </div>

                <!--                <div class="form-group">
                                    <label><?php _e('Описание платежа'); ?></label>


                                    <textarea v-model="description"
                                              @focus="$event.target.select()"
                                              rows="3"
                                              class="form-control"
                                              readonly>
                                    </textarea>


                                    <span class="text-muted">
                <?php _e('Сумма которую нужно перевести.'); ?>
                                    </span>
                                </div>-->
            </div>

            <div class="modal-footer">

                <vue-button @click="closeModal"
                             class="pull-left"
                             title="<?php _e('Закрыть'); ?>">
                </vue-button>


                <vue-button @click="start"
                             ref="start"
                             title="<?php _e('Я скопировал все данные и буду совершать платеж!'); ?>"
                             fa="fa-check"
                             btn="success">
                </vue-button>



            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="payout-end">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">{{id}} - <?php _e('завершение обработки выплаты'); ?></h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <div class="callout callout-info">
                        <p>
                            <?php _e('Укажите - совершен ли платеж?'); ?>
                        </p>
                    </div>
                </div>


                <div class="form-group">
                    <label><?php _e('PayPal аккаунт вебмастера'); ?></label>

                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-fw fa-paypal"></i>
                        </span>
                        <input ref="payout_account" v-model="payout_account" @focus="$event.target.select()" type="text" class="form-control" readonly>
                        <span class="input-group-btn">
                            <button @click="copy('payout_account')" class="btn btn-default btn-flat">
                                <i class="fa fa-fw fa-clipboard"></i>
                            </button>
                        </span>
                    </div>

                    <span class="text-muted">
                        <?php _e('На этот PayPal аккаунт нужно перевести деньги.'); ?>
                    </span>
                </div>

                <div class="form-group">
                    <label><?php _e('Сумма для перевода'); ?></label>

                    <div class="input-group">
                        <span class="input-group-addon">
                            {{ currency }}
                        </span>
                        <input ref="amount" v-model="amount" @focus="$event.target.select()" type="text" class="form-control" readonly>
                        <span class="input-group-btn">
                            <button @click="copy('amount')" class="btn btn-default btn-flat">
                                <i class="fa fa-fw fa-clipboard"></i>
                            </button>
                        </span>
                    </div>

                    <span class="text-muted">
                        <?php _e('Сумма которую нужно перевести.'); ?>
                    </span>
                </div>


                <div class="">
                    <label><?php _e('Комментарий'); ?></label>

                    <textarea v-model="details"
                              rows="3"
                              class="form-control">
                    </textarea>
                </div>
            </div>

            <div class="modal-footer">


                <vue-button @click="end_error"
                             class="pull-left"
                             ref="end_error"
                             title="<?php _e('Платеж не удался!'); ?>"
                             fa="fa-times"
                             btn="danger">
                </vue-button>


                <vue-button @click="end_success"
                             ref="end_success"
                             title="<?php _e('Платеж отпрален!'); ?>"
                             fa="fa-check"
                             btn="success">
                </vue-button>

            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="payout-edit">
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

                <button @click="run" class="btn btn-danger">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    <?php _e('Сохранить'); ?>
                </button>

            </div>
        </div>
    </div>
</div>
