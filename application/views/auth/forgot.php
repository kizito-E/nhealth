<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> | <?php _e('Сброс пароля'); ?></title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include_once dirname(__DIR__) . "/_styles.php"; ?>
    </head>

    <body class="hold-transition register-page">


        <div id="app-forgot-password" class="register-box">

            <div class="register-logo">
                <a href="/auth/forgot/">
                  <img class="auth-logo" src="<?php echo get_globalsettings('custom_logo', '/assets/imgs/adflex-logo.png')?>">
                </a>
            </div>

            <div v-if="!step_two" class="register-box-body">

                <p class="login-box-msg"><?php _e('Сброс пароля'); ?></p>

                <div v-cloak v-if="error_message" class="callout callout-danger animated fadeIn">
                    {{error_message}}
                </div>

                <div class="form-group has-feedback">
                    <input v-model="email" type="text" class="form-control" placeholder="<?php _e('Email'); ?>">
                    <span class="fa fa-envelope form-control-feedback"></span>
                </div>

                <div class="row form-group">

                    <div class="col-xs-12">

                        <button @click="forgot" class="btn btn-primary btn-block btn-flat">
                            <i v-if="active_button" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                            <span v-else><?php _e('Сбросить пароль'); ?></span>
                        </button>

                    </div>

                </div>

                <a href="/auth/login/"> <?php _e('Назад'); ?></a><br>

            </div>

            <div v-cloak v-else class="register-box-body">

                <p class="login-box-msg"><?php _e('Сброс пароля'); ?></p>

                <div class="callout callout-success animated fadeIn">
                    <?php _e('Ссылка для сброса пароля отпрвлена на ваш Email'); ?>
                </div>
            </div>

        </div>

        <?php include_once dirname(__DIR__) . "/_scripts.php"; ?>

    </body>
</html>
