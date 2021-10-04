<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> > <?php _e('Настройки'); ?> > <?php _e('Кабинет модератора'); ?></title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include_once dirname(dirname(__DIR__)) . "/_styles.php"; ?>
    </head>

    <body class="hold-transition skin-purple fixed sidebar-mini">

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
                        <div class="col-md-12">
                            <fieldset class="form-group mb25">
                                <legend><?php _e('Основные') ?></legend>
                                <div class="row">
                                    <div class="col-md-5">

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
                                            <label>
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

                                    </div>
                                </div>

                            </fieldset>


                            <fieldset class="form-group mb25">

                                <legend><?php _e('Смена пароля') ?></legend>
                                <div class="row">
                                    <div class="col-md-5">

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
                                </div>

                            </fieldset>
                        </div>

                        <div class="col-md-12">
                            <button @click="set" class="btn bg-purple">
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
