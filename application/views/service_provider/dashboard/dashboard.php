<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SP Dashboard -nHealth</title>
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
                    <h1>SP dashboard</h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    </ol>
                </section>

                <section class="content">

                    <div class="row">

                        <div class="col-lg-3 col-xs-4">
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h3></h3>
                                    <p></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-crosshairs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-xs-4">
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h3></h3>
                                    <p></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-percent"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-xs-4">
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h3><span></span>
                                      <sup style="font-size: 20px">NGN</sup></h3>
                                    <p></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-arrow-up"></i>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="_datatable-wrapper" class="row">
                        <div class="col-md-9 col-xs-12 mt25">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Health Services/Claims</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="box-body table-responsive">
                                    <table id="_datatable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Hospital</th>
                                                <th>Description</th>
                                                <th>Cost</th>
                                                <th>Claim Amount</th>
                                                <th>Status</th>
                                                <th>Initiated</th>
                                                <th>Completed</th>
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
