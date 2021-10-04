<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> > <?php _e('Рекламные блоки'); ?> > <?php _e('Кабинет вебмастера'); ?></title>
    <meta name="csrf" content="<?php csrf_token(); ?>">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php include_once dirname(dirname(__DIR__)) . "/_styles.php"; ?>
    <?php print_js_var('BANNERS_SIZES', config_item('banners_sizes')) ?>
    <?php print_js_var('site_isolated', $site_isolated) ?>
    <?php print_js_var('current_currency', get_globalsettings('current_currency', 'USD')) ?>
    <?php print_js_var('config', $config) ?>
</head>

<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper">

    <?php include_once dirname(__DIR__) . "/_header.php"; ?>
    <?php include_once dirname(__DIR__) . "/_sidebar.php"; ?>

    <div class="content-wrapper">

        <?php if ($site_isolated): ?>
            <div class="notificator notificator-info notificator-static">
                <a class="pull-right close-notificator" href="#">×</a>
                <?php _e('Это изолированный сайт. Настройки цен рекламных блоков недоступны!') ?>
            </div>
        <?php endif; ?>

        <section class="content-header">
            <h1>
                <span>
                    <?php echo $site; ?>
                </span>
                <div class="btn-group">
                    <button class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown">
                        <i class="fa fa-fw fa-plus"></i> <?php _e("Добавить блок"); ?>
                        <span class="fa fa-fw fa-caret-down"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li data-target="#add-bannerunit" data-toggle="modal" data-backdrop="static"
                            data-keyboard="false">
                            <a href="javascript:void(0);">
                                <?php _e('Баннерный'); ?>
                            </a>
                        </li>
                        <li data-target="#add-adunit" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                            <a href="javascript:void(0);">
                                <?php _e('Тексто-графический'); ?>
                            </a>
                        </li>

                        <li data-target="#add-mobileunit" data-toggle="modal" data-backdrop="static"
                            data-keyboard="false">
                            <a href="javascript:void(0);">
                                <?php _e('Мобильный'); ?>
                            </a>
                        </li>
                    </ul>
                </div>

            </h1>

            <ol class="breadcrumb">
                <li><a href="/webmaster/dashboard"><i class="fa fa-dashboard"></i> <?php _e('Консоль'); ?></a></li>
                <li><a href="/webmaster/sites"><i class="fa fa-globe"></i> <?php _e('Сайты'); ?></a></li>
                <li><a href="/webmaster/sites"><i class="fa fa-globe"></i> <?php echo $site; ?></a></li>
                <li class="active"><i class="fa fa-th-large"></i> <?php _e('Рекламные блоки'); ?></li>
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
                                    <th><input type="checkbox" id="_datatable-check-all"></th>
                                    <th><?php _e('ID'); ?></th>
                                    <th><?php _e('Имя'); ?></th>
                                    <th><?php _e('Статус'); ?></th>
                                    <th><?php _e('Тип'); ?></th>
                                    <th><?php _e('Размеры'); ?></th>
                                    <th><?php _e('Тип оплаты'); ?></th>
                                    <th><?php _e('Код блока'); ?></th>
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

<?php include_once __DIR__ . "/modal_add_bannerunit.php"; ?>
<?php include_once __DIR__ . "/modal_edit_bannerunit.php"; ?>
<?php include_once __DIR__ . "/modal_add_mobileunit.php"; ?>
<?php include_once __DIR__ . "/modal_edit_mobileunit.php"; ?>
<?php include_once __DIR__ . "/modal_add_adunit.php"; ?>
<?php include_once __DIR__ . "/modal_unit_code.php"; ?>
<?php include_once __DIR__ . "/js_templates.php"; ?>
<?php include_once dirname(dirname(__DIR__)) . "/_scripts.php"; ?>

</body>
</html>
