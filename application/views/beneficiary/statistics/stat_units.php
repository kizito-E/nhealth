<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> > <?php _e('Статистика по блокам'); ?> > <?php _e('Кабинет вебмастера'); ?></title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include_once dirname(dirname(__DIR__)) . "/_styles.php"; ?>
        <?php print_js_var('filter_site_id', $filter_site_id); ?>
    </head>

    <body class="hold-transition skin-blue fixed sidebar-mini">

        <div class="wrapper">

            <?php include_once dirname(__DIR__) . "/_header.php"; ?>
            <?php include_once dirname(__DIR__) . "/_sidebar.php"; ?>

            <div class="content-wrapper">

                <section class="content-header">
                    <h1>
                        <?php _e('Статистика'); ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="/"><i class="fa fa-dashboard"></i> <?php _e('Консоль'); ?></a></li>
                        <li><?php _e('Статистика'); ?></li>
                    </ol>
                </section>


                <section class="content">

                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-12">

                            <div class="btn-group">
                                <a href="/webmaster/statistics/days" class="btn btn-default"><?php _e('По дням') ?></a>
                                <a href="/webmaster/statistics/sites" class="btn btn-default"><?php _e('По сайтам') ?></a>
                                <a href="/webmaster/statistics/units" class="btn btn-primary"><?php _e('По блокам') ?></a>
                            </div>

                            <button type="button" class="btn btn-default" id="reportrange" style="margin-left: 20px;">
                                <span>
                                    <i class="fa fa-fw fa-calendar"></i>
                                    <?php echo gmdate("Y/m/d - Y/m/d") ?>
                                </span>
                                <i class="fa fa-fw fa-caret-down"></i>
                            </button>

                            <button id="dt-reload-btn" class="btn btn-default" style="margin-left: 20px;">
                                <i class="fa fa-fw fa-refresh"></i>
                                <?php _e('Обновить') ?>
                            </button>

                        </div>
                    </div>


                    <?php if ($filter_site_id): ?>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="filter-box">
                                    <div class="filter-label">
                                        <?php _e("Фильтр:"); ?>
                                    </div>
                                    <div class="filter-item">
                                        <i class="fa fa-fw fa-filter"></i>
                                        <?php echo htmlspecialchars($domain); ?>
                                        <a href="/webmaster/statistics/units" class="close"><span>×</span></a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    <?php endif; ?>

                    <div id="_datatable-wrapper" class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-body table-responsive">
                                    <table id="_datatable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th><?php _e('ID сайта'); ?></th>
                                                <th><?php _e('Сайт'); ?></th>
                                                <th><?php _e('ID блока'); ?></th>
                                                <th><?php _e('Имя блока'); ?></th>
                                                <th><?php _e('Показы'); ?></th>
                                                <th><?php _e('Клики'); ?></th>
                                                <th><?php _e('CTR'); ?></th>
                                                <th><?php _e('Доход'); ?></th>
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
