<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> > <?php _e('Обьявления'); ?> > <?php _e('Кабинет рекламодателя'); ?></title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include_once dirname(dirname(__DIR__)) . "/_styles.php"; ?>
        <?php print_js_var('camp_isolated', $camp_isolated) ?>
        <?php print_js_var('current_currency', get_globalsettings('current_currency', 'USD')) ?>
    </head>
    <body class="hold-transition skin-green fixed sidebar-mini">

        <div id="app-camp" class="wrapper">

            <?php include_once dirname(__DIR__) . "/_header.php"; ?>
            <?php include_once dirname(__DIR__) . "/_sidebar.php"; ?>

            <div class="content-wrapper">

                <?php if ($camp_status != 1): ?>
                    <div class="notificator notificator-error notificator-static">
                        <a class="pull-right close-notificator" href="#">×</a>
                        <?php _e('Обьявления  из этой кампании не показываются, так как эта кампания остановлена!') ?>
                    </div>
                <?php endif; ?>

                <?php if ($camp_isolated): ?>
                    <div class="notificator notificator-info notificator-static">
                        <a class="pull-right close-notificator" href="#">×</a>
                        <?php _e('Это изолированная кампания. Настройки цен обьявлений недоступны!') ?>
                    </div>
                <?php endif; ?>


                <section class="content-header">
                    <h1>
                        <?php echo htmlspecialchars($camp_name); ?>

                        <button data-target="#add-dsa" data-toggle="modal" data-backdrop="static" data-keyboard="false" class="btn bg-green btn-sm">
                            <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;
                            <?php _e("Добавить обьявление"); ?>
                        </button>

                    </h1>

                    <ol class="breadcrumb">
                        <li><a href="/"><i class="fa fa-dashboard"></i> <?php _e('Консоль'); ?></a></li>
                        <li><a href="/advertiser/campaigns"> <?php _e('Кампании'); ?></a></li>
                        <li class="active"> <?php _e('Обьявления'); ?></li>
                    </ol>
                </section>

                <section class="content">

                    <div id="_datatable-wrapper" class="row">
                        <div class="col-md-12">
                            <div class="box box-success" style="min-width: 800px;">
                                <div class="box-body">
                                    <table id="_datatable" class="table table-bordered table-striped" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="_datatable-check-all"></th>
                                                <th><?php _e('ID'); ?></th>
                                                <th><?php _e('Превью'); ?></th>
                                                <th><?php _e('Статус'); ?></th>
                                                <th><?php _e('Показы'); ?></th>
                                                <th><?php _e('Клики'); ?></th>
                                                <th><?php _e('CTR'); ?></th>
                                                <th><?php _e('Тип'); ?></th>
                                                <th>
                                                    <?php _e('CPC / CPV'); ?>
                                                    <i class="fa fa-question-circle text-primary"
                                                       data-toggle="tooltip"
                                                       data-placement="auto"
                                                       title="<?php _e('CPC - цена за 1 клик.'); ?><br><?php _e('CPV - цена за 1000 показов.'); ?>"></i>
                                                </th>
                                                <th><?php _e('Действия'); ?></th>
                                            </tr>
                                        </thead>

                                        <tbody></tbody>
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

        <?php include_once __DIR__ . "/modal_add_dsa.php"; ?>
        <?php include_once __DIR__ . "/modal_edit_dsa.php"; ?>
        <?php include_once __DIR__ . "/js_templates.php"; ?>
        <?php include_once dirname(dirname(__DIR__)) . "/_scripts.php"; ?>

    </body>
</html>
