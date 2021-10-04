<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<script id="status" type="text/html">
    {% if (o.status == 1) { %}
    <span class="label label-success"><?php _e('Активен'); ?></span>
    {% } else { %}
    <span class="label label-danger"><?php _e('Остановлен'); ?></span>
    {% } %}
</script>

<script id="type" type="text/html">
    {% if (o.type == 'banner') { %}
    <span class="label bg-purple"><?php _e('Баннерный'); ?></span>
    {% } else if(o.type == 'ad') { %}
    <span class="label bg-aqua"><?php _e('Тексто-графический'); ?></span>
    {% } else if(o.type == 'mobile') { %}
    <span class="label bg-teal"><?php _e('Мобильный'); ?></span>
    {% } %}
</script>

<script id="get-code" type="text/html">
    <button class="show-unit-code btn btn-primary btn-sm" data-hash="{%=o.hash_id%}">
        <i class="fa fa-code"></i> <?php _e('Код блока'); ?>
    </button>
</script>

<script id="actions" type="text/html">
    <div class="btn-group">
        <button class="btn btn-default dropdown-toggle btn-sm fix-dropdown" data-toggle="dropdown">
            <i class="fa fa-cogs"></i>
            <?php _e('Действия'); ?>
            <span class="fa fa-caret-down"></span>
        </button>
        <ul class="dropdown-menu pull-right" role="menu">

            {% if (o.status == 0) { %}
            <li class="unit-actions" data-id="{%=o.unit_id%}" data-action="play">
                <a href="javascript:void(0);">
                    <i class="fa fa-play"></i> <?php _e('Включить'); ?>
                </a>
            </li>
            {% } else if (o.status == 1) { %}
            <li class="unit-actions" data-id="{%=o.unit_id%}" data-action="stop">
                <a href="javascript:void(0);">
                    <i class="fa fa-stop"></i> <?php _e('Отключить'); ?>
                </a>
            </li>
            {% } %}

            <li class="unit-actions" data-id="{%=o.unit_id%}" data-unit-type="{%=o.type%}" data-action="edit">
                <a href="javascript:void(0);">
                    <i class="fa fa-pencil"></i> <?php _e('Редактировать'); ?>
                </a>
            </li>
            <li>
                <a href="/webmaster/statistics/">
                    <i class="fa fa-line-chart"></i> <?php _e('Статистика'); ?>
                </a>
            </li>
            <li class="divider"></li>
            <li class="unit-actions" data-id="{%=o.unit_id%}" data-action="delete">
                <a href="javascript:void(0);">
                    <i class="fa fa-trash"></i> <?php _e('Удалить'); ?>
                </a>
            </li>
        </ul>
    </div>
</script>