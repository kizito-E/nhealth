<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> > <?php _e('Платежи'); ?> > <?php _e('Кабинет админиcтратора'); ?></title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include_once dirname(dirname(__DIR__)) . "/_styles.php"; ?>
        <?php print_js_var('filter_user_id', $filter_user_id) ?>
    </head>
    <body class="hold-transition skin-red fixed sidebar-mini">

        <div class="wrapper">

            <?php include_once dirname(__DIR__) . "/_header.php"; ?>
            <?php include_once dirname(__DIR__) . "/_sidebar.php"; ?>

            <div class="content-wrapper">
                <section class="content-header">
                    <h1><?php _e('Платежи'); ?>
                    </h1>

                    <ol class="breadcrumb">
                        <li class="active"><a href="/"><i class="fa fa-dashboard"></i> <?php _e('Консоль'); ?></a></li>
                        <li><?php _e('Платежи'); ?></li>
                    </ol>
                </section>

                <section class="content">

                    <?php if ($filter_username): ?>
                        <div class="filter-box">
                            <div class="filter-label">
                                Filtered:
                            </div>
                            <div class="filter-item">
                                <i class="fa fa-fw fa-filter"></i>
                                <?php echo $filter_username; ?>
                                <a href="/administrator/payments/" class="close"><span>×</span></a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div id="_datatable-wrapper" class="row">
                        <div class="col-md-12">
                            <div class="box box-danger">
                                <div class="box-body table-responsive">
                                    <table id="_datatable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php _e('ID платежа'); ?></th>
                                                <th><?php _e('ID пользователя'); ?></th>
                                                <th><?php _e('Никнейм'); ?></th>
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
