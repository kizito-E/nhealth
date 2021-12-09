<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>nHealth - Set password/Activate account</title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php include_once dirname(__DIR__) . "/_styles.php"; ?>

    </head>

    <body class="hold-transition register-page">
        <div id="app-reset-password" class="register-box">

            <div class="register-logo">
                <a href="/">
                  <b>nHealth</b>
                </a>
            </div>

            <div class="register-box-body">

                <p class="login-box-msg">Password reset & account activation</p>

                <div v-cloak v-if="error" class="callout callout-danger animated fadeIn">
                    {{status_message}}
                </div>

                <div v-cloak v-if="!error && status_message" class="callout callout-success animated fadeIn">
                    {{status_message}}
                </div>

                <div v-if="!step_two" class="form-group has-feedback">
                    <input v-model="new_password" type="password" class="form-control" placeholder="Enter your desired password">
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>

                <div class="row">

                    <div class="col-xs-12">

                        <button v-if="!step_two" @click="resetPassword" class="btn btn-primary btn-block btn-flat">
                            <i v-if="active_button" v-cloak class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                            <span v-else v-cloak>Activate account</span>
                        </button>

                        <a v-else href="/auth/login" class="btn btn-primary btn-block btn-flat">Return to login</a>

                    </div>

                </div>
            </div>
        </div>

        <?php include_once dirname(__DIR__) . "/_scripts.php"; ?>

    </body>
</html>
