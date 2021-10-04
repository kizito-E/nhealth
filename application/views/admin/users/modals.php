<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="add-user">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title"><?php _e('Добавление пользователя'); ?></h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label><?php _e('E-mail пользователя'); ?><span class="text-red"> *</span></label>
                    <input @focus="emailNotise = true" @blur="emailNotise = false" type="text" class="form-control"  v-model="email">
                </div>
                <div v-if="emailNotise" class="callout callout-info animated fadeIn">
                    <?php _e('E-mail пользователя которого вы хотите зарегистрировать.'); ?>
                    <?php _e('На этот e-mail будут отправлены данные для авторизации.'); ?>
                </div>

                <label><?php _e('Имя пользователя'); ?><span class="text-red"> *</span></label>
                <div class="input-group form-group">
                    <input type="text" class="form-control" v-model="username">
                    <span class="input-group-btn">
                        <button @click="randomUsername" type="button" class="btn btn-flat btn-default">
                            <i class="fa fa-random"></i>
                        </button>
                    </span>
                </div>
                <label><?php _e('Пароль'); ?><span class="text-red"> *</span></label>
                <div class="input-group form-group">
                    <input type="text" class="form-control" v-model="password">
                    <span class="input-group-btn">
                        <button @click="randomPassword" type="button" class="btn btn-flat btn-default">
                            <i class="fa fa-random"></i>
                        </button>
                    </span>
                </div>
                <div class="form-group">
                    <label><?php _e('Роль'); ?><span class="text-red"> *</span></label>
                    <select class="form-control" v-model="subrole">
                        <option value="webmaster"><?php _e('Вебмастер'); ?></option>
                        <option value="advertiser"><?php _e('Рекламодатель'); ?></option>
                        <option value="moderator"><?php _e('Модератор'); ?></option>
                    </select>
                </div>


            </div>
            <div class="modal-footer">
                <button @click="closeModal" class="btn btn-default pull-left" data-dismiss="modal">
                    <?php _e('Закрыть'); ?>
                </button>
                <button v-if="!is_complete" @click="addUser" v-bind:disabled="button_active" class="btn btn-danger">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    <?php _e('Сохранить'); ?>
                </button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="role-user">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">{{username}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><?php _e('Роль'); ?></label>
                    <select class="form-control" v-model="subrole">
                        <option value="webmaster"><?php _e('Вебмастер'); ?></option>
                        <option value="advertiser"><?php _e('Рекламодатель'); ?></option>
                        <option value="moderator"><?php _e('Модератор'); ?></option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button @click="closeModal" class="btn btn-default pull-left" data-dismiss="modal">
                    <?php _e('Закрыть'); ?>
                </button>
                <button @click="setRole" v-bind:disabled="button_active" class="btn btn-danger">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    <?php _e('Сохранить'); ?>
                </button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="balance-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">{{username}} - <?php _e('редактирование баланса'); ?></h4>
            </div>
            <div class="modal-body">


                <div class="callout callout-info">
                    <p><?php _e('Все изменения баланса будут сохранены в истории платежей, и будут видны пользователю.'); ?></p>
                </div>
                <div class="row">

                    <div class="col-sm-6">
                        <label><?php _e('Баланс вебмастера'); ?> - <?php echo get_globalsettings('current_currency', 'USD')?></label>

                        <div class="input-group form-group">
                            <span class="input-group-btn">
                                <button @click="webmasterDownBalance" v-longclick="() => webmasterDownBalance()" class="btn btn-danger btn-flat">
                                    <i class="fa fa-fw fa-minus"></i>
                                </button>
                            </span>
                            <input-amount v-model="new_webmaster_balance" min="-1000000" max="1000000"></input-amount>
                            <span class="input-group-btn">
                                <button @click="webmasterUpBalance" v-longclick="() => webmasterUpBalance()" class="btn btn-success btn-flat">
                                    <i class="fa fa-fw fa-plus"></i>
                                </button>
                            </span>
                        </div>

                        <div v-if="diffWebmasterBalance != 0" class="text-center">
                            <b style='font-size: 16px;' v-bind:class="{'text-danger' : diffWebmasterBalance < 0 , 'text-success' : diffWebmasterBalance > 0 }">
                                {{ diffWebmasterBalance }}  <?php echo get_globalsettings('current_currency', 'USD')?> </b>
                            <button style="position: relative; right: -10px; top: -3px;" class="btn btn-xs btn-warning" @click="resetWebmasterDiff">Reset</button>
                        </div>

                    </div>

                    <div class="col-sm-6">
                        <label><?php _e('Баланс рекламодателя'); ?> - <?php echo get_globalsettings('current_currency', 'USD')?></label>
                        <div class="input-group form-group">
                            <span class="input-group-btn">
                                <button @click="advertiserDownBalance" v-longclick="() => advertiserDownBalance()" class="btn btn-danger btn-flat">
                                    <i class="fa fa-fw fa-minus"></i>
                                </button>
                            </span>
                            <input-amount v-model="new_advertiser_balance" min="-1000000" max="1000000"></input-amount>
                            <span class="input-group-btn">
                                <button @click="advertiserUpBalance" v-longclick="() => advertiserUpBalance()" class="btn btn-success btn-flat">
                                    <i class="fa fa-fw fa-plus"></i>
                                </button>
                            </span>
                        </div>

                        <div v-if="diffAdvertiserBalance != 0" class="text-center">
                            <b style='font-size: 16px;' v-bind:class="{'text-danger' : diffAdvertiserBalance < 0 , 'text-success' : diffAdvertiserBalance > 0 }">
                                {{ diffAdvertiserBalance }} <?php echo get_globalsettings('current_currency', 'USD')?> </b>
                            <button style="position: relative; right: -10px; top: -3px;" class="btn btn-xs btn-warning" @click="resetAdvertiserDiff">Reset</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button @click="closeModal" class="btn btn-default pull-left" data-dismiss="modal">
                    <?php _e('Закрыть'); ?>
                </button>
                <button v-if="!complete" v-bind:disabled="button_active" @click="editBalance" data-toggle="confirmation" class="btn btn-danger">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    <?php _e('Сохранить'); ?>
                </button>
            </div>

        </div>
    </div>
</div>