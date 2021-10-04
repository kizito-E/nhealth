<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo get_globalsettings('custom_name', 'AdFlex')?> > <?php _e('ЧаВо'); ?> > <?php _e('Кабинет вебмастера'); ?></title>
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
                    <h1><?php _e('ЧаВо'); ?></h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="/"><i class="fa fa-dashboard"></i> <?php _e('Консоль'); ?></a></li>
                        <li><?php _e('ЧаВо'); ?></li>
                    </ol>
                </section>

                <section class="content">

                    <div class="row">

                        <div class="col-md-10">



                            <div class="box-group" id="accordion">
                                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                <div class="panel box box-primary">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="">
                                                Collapsible Group Item #1
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse" aria-expanded="true" style="">
                                        <div class="box-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                                            labore sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel box box-primary">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">
                                                Collapsible Group Danger
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                        <div class="box-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                                            labore sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <div class="panel box box-primary">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed" aria-expanded="false">
                                                Collapsible Group Success
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                        <div class="box-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                                            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                                            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                                            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                                            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                                            labore sustainable VHS.
                                        </div>
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
