<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> > <?php _e('Консоль'); ?> > <?php _e('Кабинет админиcтратора'); ?></title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include_once dirname(dirname(__DIR__)) . "/_styles.php"; ?>
        <?php print_js_var("payments_chart", $payments_chart) ?>
        <?php print_js_var("payouts_chart", $payouts_chart) ?>
        <?php print_js_var("views_chart", $views_chart) ?>
        <?php print_js_var("clicks_chart", $clicks_chart) ?>
        <?php print_js_var("ctr_chart", $ctr_chart) ?>
    </head>

    <body class="hold-transition skin-red fixed sidebar-mini">
        <div class="wrapper">

            <?php include_once dirname(__DIR__) . "/_header.php"; ?>
            <?php include_once dirname(__DIR__) . "/_sidebar.php"; ?>

            <div class="content-wrapper">

                <section class="content-header">
                    <h1><?php _e('Консоль'); ?></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="/"><i class="fa fa-dashboard"></i> <?php _e('Консоль'); ?></a></li>
                    </ol>
                </section>

                <section class="content">

                    <div class="row">

                        <div class="col-lg-2 col-xs-6">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3><?php echo $today_views ?></h3>
                                    <p><?php _e('Показов сегодня:') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xs-6">
                            <div class="small-box bg-purple">
                                <div class="inner">
                                    <h3><?php echo $today_clicks ?></h3>
                                    <p><?php _e('Кликов сегодня:') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-crosshairs"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xs-6">
                            <div class="small-box bg-orange">
                                <div class="inner">
                                    <h3><?php echo number_format($today_ctr, 2) ?></h3>
                                    <p><?php _e('CTR за сегодня:') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-percent"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xs-6">
                            <div class="small-box bg-maroon">
                                <div class="inner">
                                    <h3><?php echo $today_sites ?></h3>
                                    <p><?php _e('Сайтов за сегодня:') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-globe"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xs-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?php echo $today_camps ?></h3>
                                    <p><?php _e('Кампаний за сегодня:') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-shopping-basket"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xs-6">
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3><?php echo $today_ads ?></h3>
                                    <p><?php _e('Обьявлений за сегодня:') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bullhorn"></i>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3><?php echo $count_users ?></h3>
                                    <p><?php _e('Всего пользователей') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3><?php echo $count_sites ?></h3>
                                    <p><?php _e('Всего сайтов') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-globe"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3><?php echo $count_camps ?></h3>
                                    <p><?php _e('Всего кампаний') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-shopping-basket"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-purple">
                                <div class="inner">
                                    <h3><?php echo $count_ads ?></h3>
                                    <p><?php _e('Всего обьявлений') ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bullhorn"></i>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">


                        <div class="col-md-12">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php _e("Финансы")?></h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="finance-chart">
                                                <canvas id="finance-chart" style="height: 180px; width: 1073px;" width="1073" height="180"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<!--                                <div class="box-footer">-->
<!--                                    <div class="row">-->
<!--                                        <div class="col-sm-4 col-xs-6">-->
<!--                                            <div class="description-block border-right">-->
<!--                                                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>-->
<!--                                                <h5 class="description-header">$35,210.43</h5>-->
<!--                                                <span class="description-text">--><?php //_e('Введено в систему'); ?><!--</span>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        <div class="col-sm-4 col-xs-6">-->
<!--                                            <div class="description-block border-right">-->
<!--                                                <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>-->
<!--                                                <h5 class="description-header">$10,390.90</h5>-->
<!--                                                <span class="description-text">--><?php //_e('Выведено из системы'); ?><!--</span>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        <div class="col-sm-4 col-xs-6">-->
<!--                                            <div class="description-block border-right">-->
<!--                                                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>-->
<!--                                                <h5 class="description-header">$24,813.53</h5>-->
<!--                                                <span class="description-text">--><?php //_e('Комиссия - заработок системы'); ?><!--</span>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->


                            </div>
                        </div>




                        <div class="col-md-12">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php _e("Динамика показов");?></h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="views-clicks-ctr-chart">
                                                <canvas id="views-chart" style="height: 150px; width: 1073px;" width="1073" height="150"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php _e("Динамика кликов");?></h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="views-clicks-ctr-chart">
                                                <canvas id="clicks-chart" style="height: 150px; width: 1073px;" width="1073" height="150"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                         <div class="col-md-12">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php _e("Динамика CTR");?></h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="views-clicks-ctr-chart">
                                                <canvas id="ctr-chart" style="height: 150px; width: 1073px;" width="1073" height="150"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>





                </section>
                <!-- /.content -->
            </div>

            <footer class="main-footer"></footer>
            <div class="control-sidebar-bg"></div>

        </div>

        <?php include_once __DIR__ . "/modals.php"; ?>
        <?php include_once __DIR__ . "/js_templates.php"; ?>
        <?php include_once dirname(dirname(__DIR__)) . "/_scripts.php"; ?>
    </body>
</html>
