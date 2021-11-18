<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Create an account | nHealth</title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php include_once dirname(__DIR__) . "/_styles.php"; ?>

    </head>

    <body class="hold-transition register-page">

        <div id="app-register">

            <div class="register-box">

                <div class="register-logo">
                    <a href="/auth/register/">
                      <!--<img class="auth-logo" src="">-->
                    </a>
                </div>

                <div class="register-box-body">
                    <p class="login-box-msg">Create an account</p>

                    <div v-cloak v-if="error_message" class="callout callout-danger animated fadeIn">
                        {{error_message}}
                    </div>

                    <div class="form-group has-feedback">
                        <input v-model="username" type="text" name="username" class="form-control" placeholder="Username">
                        <span class="fa fa-user form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input v-model="email" type="email" name="email" class="form-control" placeholder="Email">
                        <span class="fa fa-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input v-model="password" type="text" name="password" class="form-control" placeholder="Password">
                        <span class="ion-locked form-control-feedback"></span>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-12">
                            <button @click="register" class="btn btn-primary btn-block btn-flat">
                                <i v-if="active_button" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                                <span v-else>Create account</span>
                            </button>
                        </div>
                    </div>

                    <a href="/auth/login/" class="text-center">Have an account? Login</a>

                </div>
            </div>

        </div>

        <?php include_once dirname(__DIR__) . "/_scripts.php"; ?>

    </body>
</html>

