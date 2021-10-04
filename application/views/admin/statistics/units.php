<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> > <?php _e('Статистика по блокам'); ?> > <?php _e('Кабинет админиcтратора'); ?></title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include_once dirname(dirname(__DIR__)) . "/_styles.php"; ?>
        <?php print_js_var('filter_user_id', $filter_user_id); ?>
        <?php print_js_var('filter_site_id', $filter_site_id); ?>
        <?php print_js_var('current_currency', get_globalsettings('current_currency', 'USD')); ?>
    </head>

    <body class="hold-transition skin-red fixed sidebar-mini">

        <div class="wrapper">

            <?php include_once dirname(__DIR__) . "/_header.php"; ?>
            <?php include_once dirname(__DIR__) . "/_sidebar.php"; ?>

            <div class="content-wrapper">

                <section class="content-header">
                    <h1><?php _e('Статистика'); ?></h1>

                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> <?php _e('Консоль'); ?></a></li>
                        <li class="active"><?php _e('Статистика'); ?></li>
                    </ol>
                </section>


                <section class="content">

                    <?php include_once dirname(__FILE__) . "/_nav.php"; ?>

                    <?php if ($filter_user_id): ?>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="filter-box">
                                    <div class="filter-label">
                                        <?php _e("Фильтр:"); ?>
                                    </div>
                                    <div class="filter-item">
                                        <i class="fa fa-fw fa-filter"></i>
                                        <?php echo "User ID: " . $filter_user_id; ?>
                                        <a href="/administrator/statistics/units" class="close"><span>×</span></a>
                                    </div>
                                </div>

                            </div>
                        </div>

                    <?php endif; ?>

                    <?php if ($filter_site_id): ?>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="filter-box">
                                    <div class="filter-label">
                                        <?php _e("Фильтр:"); ?>
                                    </div>
                                    <div class="filter-item">
                                        <i class="fa fa-fw fa-filter"></i>
                                        <?php echo "Site ID: " . $filter_site_id; ?>
                                        <a href="/administrator/statistics/units" class="close"><span>×</span></a>
                                    </div>
                                </div>

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
                                                <th><?php _e('ID блока'); ?></th>
                                                <th><?php _e('ID Сайта'); ?></th>
                                                <th><?php _e('ID Пользователя'); ?></th>
                                                <th><?php _e('Показы'); ?></th>
                                                <th><?php _e('Клики'); ?></th>
                                                <th><?php _e('CTR'); ?></th>
                                                <th><?php _e('CPM'); ?></th>
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

        <?php include_once dirname(dirname(__DIR__)) . "/_scripts.php"; ?>

    </body>
</html>
