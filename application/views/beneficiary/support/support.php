<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> > <?php _e('Поддержка'); ?> > <?php _e('Кабинет вебмастера'); ?></title>
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
                    <h1><?php _e('Поддержка'); ?>

                        <button class="btn btn-primary btn-sm" data-target="#create-ticket" data-toggle="modal">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            <?php _e("Создать тикет"); ?>
                        </button>

                    </h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="/"><i class="fa fa-dashboard"></i> <?php _e('Консоль'); ?></a></li>
                        <li><?php _e('Поддержка'); ?> </li>
                    </ol>
                </section>

                <section class="content">
                    <div id="_datatable-wrapper" class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-body table-responsive">
                                    <table id="_datatable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php _e('ID Тикета'); ?></th>
                                                <th><?php _e('Тема'); ?></th>
                                                <th><?php _e('Статус'); ?></th>
                                                <th><?php _e('Открыт'); ?></th>
                                                <th><?php _e('Закрыт'); ?></th>
                                                <th><?php _e('Сообщения'); ?></th>
                                                <th><?php _e('Действия'); ?></th>
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
