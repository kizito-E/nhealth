<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>HMO Print Report -nHealth</title>
        <meta name="csrf" content="<?php csrf_token(); ?>">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include_once dirname(dirname(__DIR__)) . "/_styles.php"; ?>
    </head>

    <body onload="window.print();">

        <div class="wrapper">

            <section class="content invoice">
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                    Health Management Organization:
                    <address>
                        Name: <strong><?php echo $hmo_name ?></strong><br>
                        Email: <strong><?php echo $hmo_email ?></strong>
                    </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                    <b>Report Generated:</b> <?php echo gmdate('Y-m-d H:i:s') ?><br>
                    <b>Account ID:</b> #<?php echo $hmo_id ?>
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
                                <th>Service Provider</th>
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
                                <td><?php echo $record->sp ?></td>
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
            </section>

        </div>

    </body>
</html>