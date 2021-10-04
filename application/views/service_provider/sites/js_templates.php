<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<script id="site-status" type="text/html">
    {% if (o.status == 1) { %}
    <span class="label label-success"><?php _e('Активен'); ?></span>
    {% } else if(o.status == 0) { %}
    <span class="label label-danger"><?php _e('Остановлен'); ?></span>
    {% } else if(o.status == -1) { %}
    <span class="label label-primary"><?php _e('На модерации'); ?></span>
    {% } else if(o.status == -2) { %}
    <span class="label label-default"><?php _e('Забанен'); ?></span>
    {% } %}

    {% if (o.status == -2 && o.status_message) { %}
    <i class="fa fa-question-circle" data-toggle="tooltip" title="{%=o.status_message%}"></i>
    {% } %}
</script>


<script id="site-theme" type="text/html">
    {% if (o.theme == 'auto_moto') { %}
    <span><?php _e('Авто / Мото'); ?></span>
    {% } else if(o.theme == 'business_finance') { %}
    <span><?php _e('Бизнес / Финансы'); ?></span>
    {% } else if(o.theme == 'house_family') { %}
    <span><?php _e('Дом /Семья'); ?></span>
    {% } else if(o.theme == 'health_fitness') { %}
    <span><?php _e('Здоровье / Фитнесс'); ?></span>
    {% } else if(o.theme == 'games') { %}
    <span><?php _e('Игры'); ?></span>
    {% } else if(o.theme == 'career_work') { %}
    <span><?php _e('Карьера / Работа'); ?></span>
    {% } else if(o.theme == 'cinema') { %}
    <span><?php _e('Кино'); ?></span>
    {% } else if(o.theme == 'beauty_cosmetics') { %}
    <span><?php _e('Красота / Косметика'); ?></span>
    {% } else if(o.theme == 'cookery') { %}
    <span><?php _e('Кулинария'); ?></span>
    {% } else if(o.theme == 'fashion_clothes') { %}
    <span><?php _e('Одежда / Мода'); ?></span>
    {% } else if(o.theme == 'music') { %}
    <span><?php _e('Музыка'); ?></span>
    {% } else if(o.theme == 'the_property') { %}
    <span><?php _e('Недвижимость'); ?></span>
    {% } else if(o.theme == 'news') { %}
    <span><?php _e('Новости'); ?></span>
    {% } else if(o.theme == 'society') { %}
    <span><?php _e('Общество'); ?></span>
    {% } else if(o.theme == 'entertainment') { %}
    <span><?php _e('Развлечения'); ?></span>
    {% } else if(o.theme == 'sport') { %}
    <span><?php _e('Спорт'); ?></span>
    {% } else if(o.theme == 'science') { %}
    <span><?php _e('Наука'); ?></span>
    {% } else if(o.theme == 'goods') { %}
    <span><?php _e('Товары'); ?></span>
    {% } else if(o.theme == 'tourism') { %}
    <span><?php _e('Туризм'); ?></span>
    {% } else if(o.theme == 'adult') { %}
    <span><?php _e('Для взрослых'); ?></span>
    {% } else if(o.theme == 'other') { %}
    <span><?php _e('Другое'); ?></span>
    {% } %}
</script>



<script id="site-allowed-camp-themes" type="text/html">
    <button class="site-allowed-ad-themes  btn btn-sm btn-default" data="{%=o.themes%}">
        <span class="text-green"><i class="fa fa-fw fa-check-circle"></i> </span> - {%=o.count_enabled_themes%}
        <span class="text-red"><i class="fa fa-fw fa-ban"></i> </span>  - {%=o.count_disabled_themes%}
    </button>
</script>


<script id="site-actions" type="text/html">
    <div class="btn-group">
        <button class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">
            <i class="fa fa-cogs fa-fw"></i>
            <?php _e('Действия'); ?>
            <span class="fa fa-caret-down"></span>
        </button>
        <ul class="dropdown-menu pull-right" role="menu">

            {% if (o.status == 0) { %}
            <li class="site-action" data-id="{%=o.site_id%}" data-action="play">
                <a href="javascript:void(0);">
                    <i class="fa fa-fw fa-play"></i> <?php _e('Включить'); ?>
                </a>
            </li>
            {% } else if (o.status == 1) { %}
            <li class="site-action" data-id="{%=o.site_id%}" data-action="stop">
                <a href="javascript:void(0);">
                    <i class="fa fa-fw fa-stop"></i> <?php _e('Отключить'); ?>
                </a>
            </li>

            {% } else if (o.status == -1) { %}
            <li class="site-action" data-id="{%=o.site_id%}" data-action="moderate">
                <a href="javascript:void(0);">
                    <i class="fa fa-fw fa-lightbulb-o"></i> <?php _e('Модерация'); ?>
                </a>
            </li>
            {% } %}

            <li class="site-action" data-id="{%=o.site_id%}" data-action="edit">
                <a href="javascript:void(0);">
                    <i class="fa fa-fw fa-pencil"></i> <?php _e('Редактировать'); ?>
                </a>
            </li>
            <li class="divider"></li>

            {% if (o.status != -2) { %}
            <li class="site-action" data-id="{%=o.site_id%}" data-action="ban">
                <a href="javascript:void(0);">
                    <i class="fa fa-fw fa-ban"></i> <?php _e('Забанить'); ?>
                </a>
            </li>
            {% } else { %}
            <li class="site-action" data-id="{%=o.site_id%}" data-action="unban">
                <a href="javascript:void(0);">
                    <i class="fa fa-fw fa-play-circle"></i> <?php _e('Разбанить'); ?>
                </a>
            </li>
            {% } %}

        </ul>
    </div>
</script>


<script id="allowed-ad-themes-tmpl" type="text/html">
    <div class="modal fade" id="allowed-ad-themes">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">
                        {%=o.domain.toUpperCase()%} - <?php _e('Разрешенные тематики обьявлений'); ?>
                    </h4>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-sm-6">
                            <p>
                                <i class="fa fa-check-circle text-green"></i>
                                <b><?php _e('Разрешенные тематики'); ?> [{%=o.enabled.length%}]</b>
                            </p>

                            <p class="col-sm-12">
                                {% for (var i in o.enabled) { %}
                                <span>{%=o.enabled[i].replace('_', ' / ')%}</span><br>
                                {% } %}
                            </p>

                        </div>

                        <div class="col-sm-6">
                            <p>
                                <i class="fa fa-ban text-red"></i>
                                <b><?php _e('Запрещенные тематики'); ?> [{%=o.disabled.length%}]</b>
                            </p>

                            <p class="col-sm-12">
                                {% for (var i in o.disabled) { %}
                                <span>{%=o.disabled[i].replace('_', ' / ')%}</span><br>
                                {% } %}
                            </p>

                        </div>

                    </div>
                </div>

                <div class="modal-footer">

                    <button class="btn btn-default" data-dismiss="modal" aria-label="Close">
                        <?php _e('Закрыть'); ?>
                    </button>

                </div>
            </div>
        </div>
    </div>
</script>