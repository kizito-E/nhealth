<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Settings | nHealth</title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include_once dirname(dirname(__DIR__)) . "/_styles.php"; ?>
    </head>

    <body class="hold-transition skin-blue fixed sidebar-mini">

        <div class="wrapper">

            <?php include_once dirname(__DIR__) . "/_header.php"; ?>
            <?php include_once dirname(__DIR__) . "/_sidebar.php"; ?>

            <div class="content-wrapper">

                <section class="content-header">
                    <h1>Settings</h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="/"><i class="fa fa-dashboard"></i> HMO</a></li>
                        <li>Settings</li>
                    </ol>
                </section>

                <section class="content" id="app-settings">
                    <div class="row">
                        <div class="col-md-12">

                            <fieldset class="form-group mb25">

                                <legend>Change password</legend>
                                <div class="row">
                                    <div class="col-md-5">
                                        <p v-cloak v-if="error && status_message" class="bg-danger">{{status_message}}</p>
                                        <p v-cloak v-if="!error && status_message" class="bg-success">{{status_message}}</p>

                                        <div class="form-group">
                                            <label>Old password</label>
                                            <input v-model="old_password" class="form-control" type="password"  autocomplete="off">
                                        </div>


                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input v-model="new_password" class="form-control" type="password" autocomplete="off">
                                        </div>

                                    </div>
                                </div>

                            </fieldset>
                        </div>

                        <div class="col-md-12">
                            <button @click="update" class="btn btn-primary"><i class="fa fa-check fa-fw"></i>Save</button>
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
