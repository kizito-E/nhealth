<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> > <?php _e('Настройки'); ?> > <?php _e('Кабинет админиcтратора'); ?></title>
      <meta name="csrf" content="<?php csrf_token(); ?>">
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <?php include_once dirname(dirname(__DIR__)) . "/_styles.php"; ?>
   </head>
   <body class="hold-transition skin-red fixed sidebar-mini">
      <div class="wrapper">
         <?php include_once dirname(__DIR__) . "/_header.php"; ?>
         <?php include_once dirname(__DIR__) . "/_sidebar.php"; ?>
         <div class="content-wrapper">
            <section class="content-header">
               <h1><?php _e('Настройки'); ?></h1>
               <ol class="breadcrumb">
                  <li class="active"><a href="/"><i class="fa fa-dashboard"></i> <?php _e('Консоль'); ?></a></li>
                  <li><?php _e('Настройки'); ?></li>
               </ol>
            </section>
            <section class="content" v-cloak v-bind:class="{ initapp: !init }" id="app-settings">
               <div class="row">
                  <div class="col-md-12 mb25">
                     <div id="t-btn-container" class="btn-group">
                        <a class="btn btn-danger" href="#t-tab-1"><?php _e('Основные'); ?></a>
                        <a class="btn btn-default" href="#t-tab-2"><?php _e('Прием платежей'); ?></a>
                        <a class="btn btn-default" href="#t-tab-3"><?php _e('Вывод средств'); ?></a>
                        <a class="btn btn-default" href="#t-tab-4"><?php _e('Комиссия системы'); ?></a>
                        <a class="btn btn-default" href="#t-tab-5"><?php _e('Смена пароля'); ?></a>
                        <a class="btn btn-default" href="#t-tab-6"><?php _e('Брендинг'); ?></a>
                     </div>
                  </div>
               </div>
               <div id="app-settings" class="row t-tabs-container">
                  <div id="t-tab-1" class="col-md-4">
                     <div class="form-group">
                        <label>
                        <?php _e('Язык интерфейса') ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php _e('Язык интерфейса личного кабинета'); ?>">
                        </i>
                        </label>
                        <select v-model="lang" class="form-control selectpicker" data-style="btn-default btn-flat">
                           <option value="en"><?php _e('Английский') ?></option>
                           <option value="ru"><?php _e('Русский') ?></option>
                        </select>
                     </div>
                     <div class="form-group">
                        <label >
                        <?php _e('Временная зона') ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php
                              _e('Важно установить свой часовой пояс. Эта настройка влияет на все даты. Статистику, кампании, сообщения и т.д.');
                              ?>">
                        </i>
                        </label>
                        <select-timezone v-model="timezone"></select-timezone>
                     </div>
                     <div class="form-group">
                        <label>
                        <?php _e('Регистрация в системе') ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php _e('Вы можете разрешить или запретить регистрацию в системе новых пользователей.'); ?>">
                        </i>
                        </label>
                        <div>
                           <input v-model="users_registration" true-value="1" false-value="0" type="checkbox" style="position: relative; top:2px; margin-right: 5px;">
                           <?php _e('Разрешить пользователям регистрироваться в системе.'); ?>
                        </div>
                     </div>
                  </div>
                  <div id="t-tab-2" class="hidden col-md-4">

                    <div class="form-group">
                      <label>
                          <?php _e('Основная валюта системы') ?>
                      </label>

                      <select v-model="current_currency" class="form-control" data-style="btn-default btn-flat">
                        <?php foreach(config_item('allowed_payment_currencies') as $currency):?>
                          <option value="<?php echo $currency; ?>" <?php selected($currency, get_globalsettings('current_currency', 'USD')); ?>>
                              <?php echo $currency; ?>
                          </option>
                        <?php endforeach;?>
                      </select>
                    </div>

                    <div class="callout callout-danger">
                        <?php _e('Внимание! Эта настройка изменяет валюту глобально! Валюта балансов вебмастеров и рекламодателей так же будет изменена. Рекомендуется задать эту настройку только один раз!'); ?>
                    </div>

                     <div class="form-group">
                        <label>
                        <?php _e('PayPal аккаунт'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php _e('Ваш PayPal аккаунт - на который вы будете принимать платежи от рекламодателей.'); ?>">
                        </i>
                        </label>
                        <input v-model="admin_paypal_account" placeholder="paypalemail@example.com" class="form-control" type="text" autocomplete="off">
                     </div>
                     <div class="form-group">
                        <label>
                        <?php _e('PayPal платежи'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php _e('Вы можете включить или отключить прием платежей на ваш PayPal счет.'); ?>">
                        </i>
                        </label>
                        <div>
                           <input v-model="paypal_payments"
                              v-bind:disabled="paypal_payments_checkbox"
                              true-value="1"
                              false-value="0"
                              type="checkbox"
                              style="position: relative; top:2px; margin-right: 5px;">
                           <?php _e('Разрешить прием платежей на ваш PayPal счет.'); ?>
                        </div>
                     </div>
                     <div class="form-group">
                        <label>
                        <?php _e('PayPal песочница'); ?>
                        <i class="fa fa-question-circle text-primary"
                           id="paypal-sandbox-message"
                           data-toggle="tooltip"
                           title="<?php _e('Вы можете протестировать прием платежей включив песочницу. Не включайте этот параметр если Вы не знаете зачем он нужен!'); ?>">
                        </i>
                        </label>
                        <div>
                           <input v-model="paypal_sandbox"
                              @change="alertSandbox()"
                              true-value="1"
                              false-value="0"
                              type="checkbox"
                              style="position: relative; top:2px; margin-right: 5px;">
                           <?php _e('Включить режим песочници PayPal.'); ?>
                        </div>
                     </div>
                     <div class="hr-separator"></div>
                     <div class="form-group">
                        <label>
                        <?php _e('Stripe публичный API ключ'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php _e('Stripe публичный ключ.'); ?>">
                        </i>
                        </label>
                        <input v-model="admin_stripe_pub_key"
                           placeholder="pk_live_XXXXXXXXXXXXXXXXXXXXXXXX"
                           class="form-control"
                           type="text"
                           autocomplete="off">
                     </div>
                     <div class="form-group">
                        <label>
                        <?php _e('Stripe приватный API ключ'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php _e('Stripe приватный ключ.'); ?>">
                        </i>
                        </label>
                        <input-hide-show
                           v-model="admin_stripe_secret_key"
                           placeholder="sk_live_XXXXXXXXXXXXXXXXXXXXXXXX">
                        </input-hide-show>
                     </div>
                     <div class="callout callout-info">
                        <?php _e('Как получить публичный и приватный ключи?'); ?>
                        <a class="btn btn-xs btn-default"
                           href="https://stripe.com/docs/keys"
                           target="_blank"
                           style="background: #fff; color: #00C0EF; font-weight: bold; text-decoration: none; box-shadow: none; border: 0px;">
                        <i class="fa fa-external-link"></i>
                        <?php _e('Документация Stripe'); ?>
                        </a>
                     </div>
                     <div class="form-group">
                        <label>
                        <?php _e('Stripe платежи'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php _e('Вы можете включить или отключить прием платежей на ваш Stripe счет.'); ?>">
                        </i>
                        </label>
                        <div>
                           <input v-model="stripe_payments"
                              v-bind:disabled="stripe_payments_checkbox"
                              true-value="1"
                              false-value="0"
                              type="checkbox"
                              style="position: relative; top:2px; margin-right: 5px;">
                           <?php _e('Разрешить прием платежей на ваш Stripe счет.'); ?>
                        </div>
                     </div>
                  </div>
                  <div id="t-tab-3" class="hidden col-md-4">
                     <div class="form-group">
                        <label>
                        <?php _e('Paypal - вывод средств'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php
                              _e('Пользователь сможет указать свой PayPal счет для вывода заработанных средств из системы. '
                                      . 'Учтите что у вас так же должен быть личный PayPal счет, с которого вы будете осуществлять выплаты пользователям.');
                              ?>">
                        </i>
                        </label>
                        <div>
                           <input v-model="enable_payouts"
                              true-value="1"
                              false-value="0"
                              type="checkbox"
                              style="position: relative; top:2px; margin-right: 5px;">
                           <?php _e('Разрешить пользователям вывод средств на свой PayPal счет.'); ?>
                        </div>
                     </div>
                  </div>
                  <div id="t-tab-4" class="hidden col-md-4">
                     <div class="form-group" v-bind:class="{'has-error' : comission == 0}">
                        <label>
                        <?php _e('Процент комиссии'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php
                              _e('Процент который будет списан со стоимости каждого клика или показа в пользу системы.'
                                      . 'Фактически это заработок системы.'
                                      . 'Например рекламодатель назначил цену клика в 1.00 USD, комиссия системы - 20%.'
                                      . 'При клике, с рекламодателя будет списан 1.00 USD, 0.20 USD коммисия системы. '
                                      . 'Вебмастер же получит 80% стоимости клика - 0.80 USD');
                              ?>">
                        </i>
                        </label>
                        <div class="input-group">
                           <span class="input-group-addon">%</span>
                           <input-number v-model="comission" min="1" max="80"></input-number>
                        </div>
                     </div>
                  </div>
                  <div id="t-tab-5" class="hidden col-md-4">
                     <div class="form-group">
                        <label>
                        <?php _e('Старый пароль'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php _e('Введите ваш текущий пароль.'); ?>">
                        </i>
                        </label>
                        <input v-model="old_password" class="form-control" type="text"  autocomplete="off">
                     </div>
                     <div class="form-group">
                        <label>
                        <?php _e('Новый пароль'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php _e('Введите новый пароль.'); ?>">
                        </i>
                        </label>
                        <input v-model="new_password" class="form-control" type="text" autocomplete="off">
                     </div>
                  </div>
                  <div id="t-tab-6" class="hidden col-md-4">
                     <div class="form-group">
                        <div v-if="customLogo">
                           <img :src="customLogo" style="max-width: 150px;">
                           <button @click="customLogo = null, customLogoFile = null" class="btn btn-danger">
                           <?php _e('Удалить логотип'); ?>
                           </button>
                        </div>
                        <div v-else>
                           <label>
                           <?php _e('Логотип (400x100 пикселей) '); ?>
                           </label>
                           <input  type="file" @change="processFile($event)">
                        </div>
                        <br  />
                        <label><?php _e('Название'); ?></label>
                        <input v-model="customName" class="form-control" type="text" autocomplete="off" />
                        <br>
                       <div class="form-group">
                         <label>
                             <?php _e('Показывать пометку "AD" на рекламных блоках'); ?>
                           <i class="fa fa-question-circle text-primary"
                              data-toggle="tooltip"
                              title='<?php
                              _e('Пометка "AD" будет отображатся в правом верхнем углу, каждого рекламного блока. При клике на пометку пользователь попадет на сайт системы.');
                              ?>'>
                           </i>
                         </label>
                         <div>
                           <input v-model="adunit_visible_tip"
                                  true-value="1"
                                  false-value="0"
                                  type="checkbox"
                                  style="position: relative; top:2px; margin-right: 5px;">
                             <?php _e('Показывать пометку "AD" на рекламных блоках'); ?>
                         </div>
                       </div>
                        <button @click="setCustomLogo" v-bind:disabled="button_active" class="btn btn-danger">
                          <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                          <i v-else class="fa fa-check fa-fw"></i>
                          <?php _e('Сохранить') ?>
                        </button>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-5 mt25">
                     <button v-if="isVisibleSaveBtn" @click="update" v-bind:disabled="button_active" class="btn btn-danger">
                     <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                     <i v-else class="fa fa-check fa-fw"></i>
                     <?php _e('Сохранить') ?>
                     </button>
                  </div>
               </div>

            </section>
         </div>
         <footer class="main-footer"></footer>
         <div class="control-sidebar-bg"></div>
      </div>
      <?php include_once __DIR__ . "/modals.php"; ?>
      <?php include_once __DIR__ . "/js_templates.php"; ?>
      <?php include_once dirname(dirname(__DIR__)) . "/_scripts.php"; ?>
   </body>
</html>