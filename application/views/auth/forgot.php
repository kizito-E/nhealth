<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Reset Password | nHealth</title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include_once dirname(__DIR__) . "/_styles.php"; ?>
    </head>

    <body class="hold-transition register-page">


        <div id="app-forgot-password" class="register-box">

            <div class="register-logo">
                <a href="/">
                  <b>nHealth</b>
                </a>
            </div>

            <div v-if="!step_two" class="register-box-body">

                <p class="login-box-msg">Reset your password</p>

                <div v-cloak v-if="error_message" class="callout callout-danger animated fadeIn">
                    {{error_message}}
                </div>

                <div class="form-group has-feedback">
                    <input v-model="email" type="text" class="form-control" placeholder="Email">
                    <span class="fa fa-envelope form-control-feedback"></span>
                </div>

                <div class="row form-group">

                    <div class="col-xs-12">

                        <button @click="forgot" class="btn btn-primary btn-block btn-flat">
                            <i v-if="active_button" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                            <span v-else>Submit</span>
                        </button>

                    </div>

                </div>

                <a href="/auth/login/">Return to login</a><br>

            </div>

            <div v-cloak v-else class="register-box-body">

                <p class="login-box-msg">Reset your password</p>

                <div class="callout callout-success animated fadeIn">Success! Password reset instructions sent to your email address</div>
            </div>

        </div>

        <?php include_once dirname(__DIR__) . "/_scripts.php"; ?>

    </body>
</html>
