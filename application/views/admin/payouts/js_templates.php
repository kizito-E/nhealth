<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<script id="gateway" type="text/html">
    {% if (o.payout_gateway.toLowerCase() == 'paypal') { %}
    <i class="fa fa-fw fa-paypal fa-lg" style="color:#002E82;"></i> PayPal
    {% } else if(o.payout_gateway.toLowerCase() == 'stripe') { %}
    <i class="fa fa-fw fa-cc-stripe fa-lg" style="color:#646EDE;"></i> Stripe
    {% } %}
</script>


<script id="payout-actions" type="text/html">
    <div class="btn-group">

        {% if (o.status == 'new') { %}

        <button class="btn btn-info btn-sm payout-action-btn" data-payout-action="start" data-payout-id="{%=o.id%}">
            <i class="fa fa-fw fa-play"></i>
            <?php _e('Начать обработку'); ?>
        </button>

        {% } else if(o.status == 'processing') { %}

        <button class="btn btn-sm payout-action-btn btn-warning" data-payout-action="end" data-payout-id="{%=o.id%}">
            <i class="fa fa-fw fa-clock-o"></i>
            <?php _e('Завершить обработку'); ?>
        </button>

        {% } else { %}

        &mdash;

        <!--        <button class="btn btn-default btn-sm payout-action-btn"data-payout-action="edit" data-payout-id="{%=o.id%}">
                    <i class="fa fa-fw fa-pencil"></i>
        <?php _e('Изменить статус'); ?>
                </button>-->

        {% } %}
    </div>
</script>


<script id="payout-details-modal" type="text/html">
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title"><?php _e('Платеж: '); ?>{%=o.id%}</h4>
                </div>
                <div class="modal-body">

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2"><?php _e('Основная информация'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php _e('ID платежа'); ?></td>
                                <td>{%=o.id%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Статус'); ?></td>
                                <td>{%=o.status%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Шлюз'); ?></td>
                                <td>{%=o.payout_gateway%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Аккаунт'); ?></td>
                                <td>{%=o.payout_account%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Сумма'); ?></td>
                                <td>{%=numeral(o.amount).format('0,0.00')%}</td>
                            </tr>
                            <tr>
                                <td><?php _e('Дата создания заявки'); ?></td>
                                <td>{%=o.created_at%} UTC</td>
                            </tr>
                            <tr>
                                <td><?php _e('Дата исполнения заявки'); ?></td>
                                <td>{%= o.completed_at ? o.completed_at + " UTC" : ''%} </td>
                            </tr>
                        </tbody>
                    </table>

<!--                    {% if(Object.keys(o.details).length) { %}

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2"><?php _e('Дополнительная информация'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for (var i in o.details) { %}
                            <tr>
                                <td>{%=i%}</td>
                                <td>{%=o.details[i]%}</td>
                            </tr>
                            {% } %}
                        </tbody>
                    </table>

                    {% } %}-->

                </div>
                <div class="modal-footer">
                    <button  class="btn btn-default" data-dismiss="modal">
                        <?php _e('Закрыть'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</script>