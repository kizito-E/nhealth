<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> > <?php _e('Консоль'); ?> > <?php _e('Кабинет рекламодателя'); ?></title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include_once dirname(dirname(__DIR__)) . "/_styles.php"; ?>
        <?php print_js_var('views_clicks_chart', $views_clicks_chart); ?>
        <?php print_js_var('ctr_chart', $ctr_chart); ?>
        <?php print_js_var('costs_chart', $costs_chart); ?>
    </head>
    <body class="hold-transition skin-green fixed sidebar-mini">

        <div class="wrapper">

            <?php include_once dirname(__DIR__) . "/_header.php"; ?>
            <?php include_once dirname(__DIR__) . "/_sidebar.php"; ?>

            <div class="content-wrapper">

                <section class="content-header">
                    <h1><?php _e('Консоль рекламодателя'); ?></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="/"><i class="fa fa-dashboard"></i> <?php _e('Консоль'); ?></a></li>
                    </ol>
                </section>

                <section class="content">

                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3 id="today-views"><?= number_format($today_views) ?></h3>
                                    <p><?php _e('Показов сегодня:') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-eye"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3 id="today-clicks"><?= number_format($today_clicks) ?></h3>
                                    <p><?php _e('Кликов сегодня:') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-crosshairs"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3 id="today-ctr"><?= number_format($today_ctr, 2) ?></h3>
                                    <p><?php _e('CTR за сегодня:') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-percent"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3><span id="today-costs"><?= number_format($today_costs, 2) ?></span>
                                      <sup style="font-size: 20px"><?php echo get_globalsettings('current_currency', 'USD');?></sup></h3>
                                    <p><?php _e('Расход за сегодня:') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-arrow-down"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>


                    <div class="row">

                        <div class="col-sm-12">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php _e('Показы / Клики') ?></h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="chart">
                                        <canvas id="chart-ciews-clicks" style="height:250px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-sm-6">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php _e('CTR') ?></h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="chart">
                                        <canvas id="lineChart" style="height:150px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">

                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php _e('Расход') ?></h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>

                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="chart">
                                        <canvas id="barChart" style="height:150px"></canvas>
                                    </div>
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
