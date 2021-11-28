<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SP Report -nHealth</title>
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
                    <h1>Service Provider Report</h1>
                    <ol class="breadcrumb">
                        <li class="active"><a href="/"><i class="fa fa-hospital-o"></i> SP Report</a></li>
                    </ol>
                </section>

                <section class="content invoice">
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                        Health Service Provider:
                        <address>
                            Name: <strong><?php echo $sp_name ?></strong><br>
                            Email: <strong><?php echo $sp_email ?></strong>
                        </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                        <b>Report Generated:</b> <?php echo gmdate('Y-m-d H:i:s') ?><br>
                        <b>Account ID:</b> #<?php echo $sp_id ?>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Beneficiary</th>
                                    <th>Description</th>
                                    <th>Amount Covered</th>
                                    <th>Total Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($records as $record): ?>
                                <tr>
                                    <td><?php echo $record->id ?></td>
                                    <td><?php echo $record->beneficiary ?></td>
                                    <td><?php echo $record->description ?></td>
                                    <td>NGN <?php echo number_format($record->amount_due, 2) ?></td>
                                    <td>NGN <?php echo number_format($record->cost, 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-6">

                        <div class="table-responsive">
                            <table class="table">
                            <tr>
                                <th style="width:50%">Cost:</th>
                                <td>NGN <?php echo number_format($total_cost, 2) ?></td>
                            </tr>
                            <tr>
                                <th>Out-Of-Pocket Payment:</th>
                                <td>NGN <?php echo number_format($out_of_pocket, 2) ?></td>
                            </tr>
                            <tr>
                                <th>Amount Covered/Due:</th>
                                <td>NGN <?php echo number_format($amount_due, 2) ?></td>
                            </tr>
                            </table>
                        </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
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