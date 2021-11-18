<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>nHealth | e-Health Insurance</title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php include_once dirname(__DIR__) . "/_styles.php"; ?>

    </head>

    <body class="hold-transition login-page">

        <div v-cloak id="app-login" class="login-box">

            <div class="login-logo">
                <a href="/auth/login/">
                  <!--<img class="auth-logo" src="">-->
                </a>
            </div>

            <div id="login" class="login-box-body">

                <p class="login-box-msg">Welcome! Sign In</p>

                <div v-cloak v-if="error_message" class="callout callout-danger animated fadeIn">
                    {{error_message}}
                </div>

                <div class="form-group has-feedback">
                    <input v-model="email" type="email" class="form-control" placeholder="Email">
                    <span class="fa fa-envelope form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input v-model="password" type="password" class="form-control" placeholder="Password">
                    <span class="ion-locked form-control-feedback"></span>
                </div>

                <div class="row">

                    <div class="col-xs-12 form-group">

                        <button @click="logIn" class="btn btn-primary btn-block btn-flat">
                            <i v-if="active_button" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                            <span v-else>Login</span>
                        </button>

                    </div>

                </div>

                <div class="row">
                    <div class="col-xs-12">

                        <div class="pull-left">
                            <a href="/auth/register/" class="text-center">Create an account</a>
                        </div>

                        <div class="pull-right">
                            <a href="/auth/forgot/">Reset Password</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php include_once dirname(__DIR__) . "/_scripts.php"; ?>

    </body>
</html>
