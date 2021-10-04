<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> | <?php _e('Авторизация'); ?></title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php include_once dirname(__DIR__) . "/_styles.php"; ?>

    </head>

    <body class="hold-transition login-page">

        <div v-cloak id="app-login" class="login-box">

            <div class="login-logo">
                <a href="/auth/login/">
                  <img class="auth-logo" src="<?php echo get_globalsettings('custom_logo', '/assets/imgs/adflex-logo.png')?>">
                </a>
            </div>

            <div id="login" class="login-box-body">

                <p class="login-box-msg"><?php _e('Авторизация'); ?></p>

                <div v-cloak v-if="error_message" class="callout callout-danger animated fadeIn">
                    {{error_message}}
                </div>

                <div class="form-group has-feedback">
                    <input v-model="email" type="email" class="form-control" placeholder="<?php _e('Email'); ?>">
                    <span class="fa fa-envelope form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input v-model="password" type="password" class="form-control" placeholder="<?php _e('Пароль'); ?>">
                    <span class="ion-locked form-control-feedback"></span>
                </div>

                <div class="row">

                    <div class="col-xs-12 form-group">

                        <button @click="logIn" class="btn btn-primary btn-block btn-flat">
                            <i v-if="active_button" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                            <span v-else><?php _e('Вход'); ?></span>
                        </button>

                    </div>

                </div>

                <div class="row">
                    <div class="col-xs-12">

                        <? if (get_globalsettings('users_registration', 1)): ?>

                            <div class="pull-left">
                                <a href="/auth/register/" class="text-center"><?php _e('Регистрация'); ?></a>
                            </div>

                        <? endif; ?>

                        <div class="pull-right">
                            <a href="/auth/forgot/"><?php _e('Забыли пароль?'); ?></a>
                        </div>

                        <div v-if="show_autologin_box" class="autologin-box" style="margin-top: 50px;">

                            <button @click="loginAdmin()" class="btn btn-danger btn-block btn-flat margin-bottom">
                                Go to Administrator account
                            </button>

                            <button @click="loginAdvertiser()" class="btn btn-success btn-block btn-flat margin-bottom">
                                Go to Advertiser account
                            </button>

                            <button @click="loginWebmaster()" class="btn btn-primary btn-block btn-flat margin-bottom">
                                Go to Webmaster account
                            </button>

                            <button @click="loginModerator()" class="btn bg-purple btn-block btn-flat margin-bottom">
                                Go to Moderator account
                            </button>

                        </div>


                    </div>
                </div>
            </div>
        </div>

        <?php include_once dirname(__DIR__) . "/_scripts.php"; ?>

    </body>
</html>
