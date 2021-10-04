<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> > <?php _e('Платежи'); ?> > <?php _e('Кабинет рекламодателя'); ?></title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include_once dirname(dirname(__DIR__)) . "/_styles.php"; ?>
    </head>

    <body class="hold-transition skin-green fixed sidebar-mini">
        <div class="wrapper">

            <?php include_once dirname(__DIR__) . "/_header.php"; ?>
            <?php include_once dirname(__DIR__) . "/_sidebar.php"; ?>

            <div class="content-wrapper">

                <?php if ($this->session->flashdata('payment_message')): ?>
                    <div class="notificator notificator-static">
                        <a class="pull-right close-notificator" href="#">×</a>
                        <?php echo $this->session->flashdata('payment_message'); ?>
                    </div>
                <?php endif; ?>

                <section class="content-header">
                    <h1>
                        <?php _e('Платежи'); ?>

                        <?php
                        if ((get_globalsettings('stripe_payments') && get_globalsettings('admin_stripe_pub_key') && get_globalsettings('admin_stripe_secret_key')) ||
                            (get_globalsettings('paypal_payments') && get_globalsettings('admin_paypal_account'))):
                            ?>
                            <button class="btn bg-green btn-sm"  data-toggle="modal" data-target="#pay-modal" data-backdrop="static">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                <?php _e("Пополнить баланс"); ?>

                            </button>

                        <?php endif; ?>

                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> <?php _e('Консоль'); ?></a></li>
                        <li class="active"><?php _e('Платежи'); ?></li>
                    </ol>
                </section>


                <section class="content">

                    <div id="_datatable-wrapper" class="row">
                        <div class="col-md-12">
                            <div class="box box-success">
                                <div class="box-body table-responsive">
                                    <table id="_datatable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php _e('ID платежа'); ?></th>
                                                <th><?php _e('Шлюз'); ?></th>
                                                <th><?php _e('Направление'); ?></th>
                                                <th><?php _e('Сумма'); ?></th>
                                                <th><?php _e('Информация'); ?></th>
                                                <th><?php _e('Дата'); ?></th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
