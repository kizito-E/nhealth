<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> | <?php _e('Новый пароль'); ?></title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php include_once dirname(__DIR__) . "/_styles.php"; ?>

    </head>

    <body class="hold-transition register-page">
        <div id="app-reset-password" class="register-box">

            <div class="register-logo">
                <a href="/auth/login/">
                  <img class="auth-logo" src="<?php echo get_globalsettings('custom_logo', '/assets/imgs/adflex-logo.png')?>">
                </a>
            </div>

            <div class="register-box-body">

                <p class="login-box-msg"><?php _e('Установка нового пароля'); ?></p>

                <div v-cloak v-if="error_message" class="callout callout-danger animated fadeIn">
                    {{error_message}}
                </div>

                <div v-cloak v-if="step_two" class="callout callout-success animated fadeIn">
                    <?php _e('Пароль успешно изменен!'); ?>
                </div>

                <div v-if="!step_two" class="form-group has-feedback">
                    <input v-model="new_password" type="text" class="form-control" placeholder="<?php _e('Новый пароль'); ?>">
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>

                <div class="row">

                    <div class="col-xs-12">

                        <button @click="resetPassword" v-if="!step_two" class="btn btn-primary btn-block btn-flat">
                            <i v-if="active_button" v-cloak class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                            <span v-else v-cloak><?php _e('Сменить пароль'); ?></span>
                        </button>

                        <a v-else href="/" class="btn btn-primary btn-block btn-flat"><?php _e('Вход'); ?></a>

                    </div>

                </div>
            </div>
        </div>

        <?php include_once dirname(__DIR__) . "/_scripts.php"; ?>

    </body>
</html>
