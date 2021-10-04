<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<script id="status" type="text/html">
    {% if (o.status == 1) { %}
    <span class="label label-success"><?php _e('Открыт'); ?></span>
    {% } else if(o.status == 0) { %}
    <span class="label label-default"><?php _e('Закрыт'); ?></span>
    {% } %}
</script>


<script id="messages" type="text/html">
    <button class="ticket-messages btn btn-default btn-sm" style="position: relative;" data-id="{%=o.ticket_id%}">
        <span class="badge bg-red" style="position: absolute; top: -8px; right: -12px;">{%= o.count_new_messages || ''%}</span>
        <i class="fa fa-comments"></i>
        <?php _e('Сообщения'); ?>
        [{%= o.count_all_messages%}]
    </button>
</script> 

<script id="actions" type="text/html">
    <div class="btn-group">
        <button class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">
            <i class="fa fa-cogs"></i>
            <?php _e('Действия'); ?>
            <span class="fa fa-caret-down"></span>
        </button>
        <ul class="dropdown-menu pull-right" role="menu">
            {% if (o.status == 0) { %}
            <li class="item-action" data-id="{%=o.ticket_id%}" data-action="open">
                <a href="javascript:void(0);">
                    <i class="fa fa-play"></i> <?php _e('Открыть'); ?>
                </a>
            </li>
            {% } else { %}
            <li class="item-action" data-id="{%=o.ticket_id%}" data-action="close">
                <a href="javascript:void(0);">
                    <i class="fa fa-stop"></i> <?php _e('Закрыть'); ?>
                </a>
            </li>
            {% } %}
        </ul>
    </div>
</script>