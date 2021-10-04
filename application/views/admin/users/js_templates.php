<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<script id="to-account" type="text/html">
    <button class="btn btn-sm btn-success" go-to-user-account data-user-id="{%=o.id%}">
        <i class="fa fa-sign-in"></i>
        <?php _e('В аккаунт'); ?>
    </button>
</script>


<script id="role" type="text/html">
    {% if (o.role == 'user' && (o.subrole == 'webmaster' || o.subrole == 'advertiser')) { %}
    <span class="label label-primary"><i class="fa fa-fw fa-user"></i> <?php _e('Юзер'); ?></span>
    {% } else if(o.role == 'user' && o.subrole =='moderator') { %}
    <span class="label label-warning"><i class="fa fa-fw fa-user"></i> <?php _e('Модератор'); ?></span>
    {% } else if(o.role =='administrator') { %}
    <span class="label label-danger"><i class="fa fa-fw fa-user"></i> <?php _e('Администратор'); ?></span>
    {% } %}
</script>



<script id="status" type="text/html">
    {% if (o.status == 1) { %}
    <span class="label label-success"><?php _e('Активен'); ?></span>
    {% } else if(o.status == 0) { %}
    <span class="label label-danger"><?php _e('Остановлен'); ?></span>
    {% } else if(o.status == -1) { %}
    <span class="label label-primary"><?php _e('Забанен'); ?></span>
    {% } %}

    {% if (o.status_message) { %}
    <i class="fa fa-question-circle" data-toggle="tooltip" title="{%=o.status_message%}"></i>
    {% } %}
</script>



<script id="actions" type="text/html">
    <div class="btn-group">
        <button class="btn btn-default dropdown-toggle btn-sm fix-dropdown" data-toggle="dropdown">
            <i class="fa fa-cogs"></i>
            <?php _e('Действия'); ?>
            <span class="fa fa-caret-down"></span>
        </button>
        <ul class="dropdown-menu pull-right" role="menu">

            <li class="item-action" data-id="{%=o.id%}" data-action="edit-balance">
                <a href="javascript:void(0);">
                    <i class="fa fa-fw fa-usd"></i> <?php _e('Редактировать баланс'); ?>
                </a>
            </li>

            <li class="item-action" data-id="{%=o.id%}" data-action="edit-role">
                <a href="javascript:void(0);">
                    <i class="fa fa-fw fa-pencil"></i> <?php _e('Редактировать роль'); ?>
                </a>
            </li>

            <li class="divider"></li>
            {% if (o.status == 0) { %}
            <li class="item-action" data-id="{%=o.id%}" data-action="unban">
                <a href="javascript:void(0);">
                    <i class="fa fa-fw fa-play-circle"></i> <?php _e('Разбанить'); ?>
                </a>
            </li>
            {% } else  { %}
            <li class="item-action" data-id="{%=o.id%}" data-action="ban">
                <a href="javascript:void(0);">
                    <i class="fa fa-fw fa-ban"></i> <?php _e('Забанить'); ?>
                </a>
            </li>
            {% } %}

        </ul>
    </div>
</script>


<script id="info" type="text/html">
    <div class="btn-group">
        <button class="btn btn-default dropdown-toggle btn-sm fix-dropdown" data-toggle="dropdown">
            <i class="fa fa-info-circle"></i>
            <?php _e('Информация'); ?>
            <span class="fa fa-caret-down"></span>
        </button>
        <ul class="dropdown-menu" role="menu">

            <li>
                <a href="/administrator/sites/?user_id={%=o.id%}">
                    <i class="fa fa-fw fa-globe"></i> <?php _e('Сайты'); ?> ({%=o.count_sites%})
                </a>
            </li>

            <li>
                <a href="/administrator/campaigns/?user_id={%=o.id%}">
                    <i class="fa fa-fw fa-shopping-basket"></i> <?php _e('Кампании'); ?> ({%=o.count_camps%})
                </a>
            </li>

            <li>
                <a href="/administrator/ads/?user_id={%=o.id%}">
                    <i class="fa fa-fw fa-bullhorn"></i> <?php _e('Обьявления'); ?> ({%=o.count_ads%})
                </a>
            </li>

<!--            <li>
                <a href="/administrator/statistics/?user_id={%=o.id%}">
                    <i class="fa fa-fw fa-pie-chart"></i> <?php _e('Статистика'); ?>
                </a>
            </li>-->

            <li>
                <a href="/administrator/support/?user_id={%=o.id%}">
                    <i class="fa fa-fw fa-life-ring"></i> <?php _e('Тикеты'); ?> ({%=o.count_tickets%})
                </a>
            </li>

            <li>
                <a href="/administrator/payments/?user_id={%=o.id%}">
                    <i class="fa fa-fw fa-plus"></i> <?php _e('Платежи'); ?> ({%=o.count_payments%})
                </a>
            </li>
            <li>
                <a href="/administrator/payouts/?user_id={%=o.id%}">
                    <i class="fa fa-fw fa-minus"></i> <?php _e('Выплаты'); ?> ({%=o.count_payouts%})
                </a>
            </li>

        </ul>
    </div>
</script>