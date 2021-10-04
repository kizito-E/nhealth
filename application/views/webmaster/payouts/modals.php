<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="add-payout">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header btn-">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"><?php _e('Заказ выплаты'); ?></h4>
            </div>

            <div class="modal-body">


                <?php if (!get_usersettings('payout_account')): ?>
                    <div class="form-group">
                        <div class="callout callout-danger">
                            <? _e('Не указан аккаунт для выплат! Укажите аккаунт для выплат в <a href="/webmaster/settings">настройках</a>!') ?>
                        </div>
                    </div>
                <?php endif ?>

                <div class="form-group">
                    <label><?php _e('Сумма'); ?></label>

                    <div class="input-group">

                        <input-amount
                            v-bind:class="{ 'input-lg' : true }"
                            v-bind:min="<?php echo round(config_item('min_payout_sum'), 2); ?>"
                            v-bind:max="<?php echo round($balance - 0.01, 2); ?>"
                            v-model="amount">
                        </input-amount>


                        <div class="input-group-addon">
                            <?php echo get_globalsettings('current_currency', 'USD')?>
                        </div>

                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button @click="closeModal" data-dismiss="modal" class="btn btn-default pull-left">
                    <?php _e('Закрыть'); ?>
                </button>

                <button v-if="!is_complete" @click="add" v-bind:disabled="button_active" class="btn btn-success">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    <?php _e('Заказать выплату'); ?>
                </button>

            </div>
        </div>
    </div>
</div>

