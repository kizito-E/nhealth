<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script id="camp-type" type="text/html">
    {% if (o.type == 'banners') { %}
    <span class="label label-default bg-purple"><?php _e('Баннерная'); ?></span>
    {% } else { %}
    <span class="label label-default bg-aqua"><?php _e('Тексто-графическая'); ?></span>
    {% } %}
</script>


<script id="camp-status" type="text/html">
    {% if (o.status == 1) { %}
    <span class="label label-success"><?php _e('Активна'); ?></span>
    {% } else { %}
    <span class="label label-danger"><?php _e('Остановлена'); ?></span>
    {% } %}
</script>


<script id="camp-theme" type="text/html">
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



<script id="camp-properties" type="text/html">
    <span class="label label-primary" data-toggle="tooltip" data-placement="auto" title="<b><?php _e('Страны'); ?></b> <p>{%=o.geos%}</p>">
        <i class="fa fa-globe fa-fw"></i>
    </span>&nbsp;
    <span class="label label-success" data-toggle="tooltip" data-placement="auto" title="<b><?php _e('Устройства'); ?></b> <p>{%=o.devs%}</p>">
        <i class="fa fa-desktop fa-fw"></i>
    </span>&nbsp;
    <span class="label label-info" data-toggle="tooltip" data-placement="auto" title="<b><?php _e('Операционные системы'); ?></b> <p>{%=o.platforms%}</p>">
        <i class="fa fa-windows fa-fw"></i>
    </span>&nbsp;
    <span class="label label-warning" data-toggle="tooltip" data-placement="auto" title="<b><?php _e('Браузеры'); ?></b> <p>{%=o.browsers%}</p>">
        <i class="fa fa-internet-explorer fa-fw"></i>
    </span>&nbsp;
    <span class="label label-default bg-purple" data-toggle="tooltip" data-placement="auto" title="<b><?php _e('Дни'); ?></b> <p>{%=o.days%}</p>">
        <i class="fa fa-calendar-check-o fa-fw"></i>
    </span>&nbsp;
    <span class="label label-default bg-olive" data-toggle="tooltip" data-placement="auto" title="<b><?php _e('Часы'); ?></b> <p>{%=o.hours%}</p>">
        <i class="fa fa-clock-o fa-fw"></i>
    </span>&nbsp;
    <span class="label label-default bg-maroon" data-toggle="tooltip" data-placement="auto" title="<b><?php _e('Разрешенные тематики сайтов'); ?></b> <p>{%=o.allowed_site_themes%}</p>">
        <i class="fa fa-bullseye fa-fw"></i>
    </span>
</script>


<script id="camp-dsamanage" type="text/html">
    {% if (o.type == 'banners') { %}
    <a href="/advertiser/bannerlist/{%=o.id%}" class="btn btn-sm btn-default"> <i class="fa fa-bullhorn"></i> <?php _e('Баннеры'); ?> [{%=o.count_items%}]</a>
    {% } else { %}
    <a href="/advertiser/dsalist/{%=o.id%}" class="btn btn-sm btn-default"> <i class="fa fa-bullhorn"></i> <?php _e('Обьявления'); ?> [{%=o.count_items%}]</a>
    {% } %}
</script>


<script id="camp-actions" type="text/html">
    <div class="btn-group">
        <button class="btn btn-default dropdown-toggle btn-sm fix-dropdown" data-toggle="dropdown">
            <i class="fa fa-cogs"></i>
            <?php _e('Действия'); ?>
            <span class="fa fa-caret-down"></span>
        </button>
        <ul class="dropdown-menu pull-right" role="menu">

            {% if (o.status == 0) { %}
            <li class="item-action" data-id="{%=o.id%}" data-action="play">
                <a href="javascript:void(0);">
                    <i class="fa fa-play"></i> <?php _e('Включить'); ?>
                </a>
            </li>
            {% } else { %}
            <li class="item-action" data-id="{%=o.id%}" data-action="stop">
                <a href="javascript:void(0);">
                    <i class="fa fa-stop"></i> <?php _e('Отключить'); ?>
                </a>
            </li>
            {% } %}

            <li class="item-action" data-id="{%=o.id%}" data-action="edit">
                <a href="javascript:void(0);">
                    <i class="fa fa-pencil"></i> <?php _e('Редактировать'); ?>
                </a>
            </li>
            <li>
                <a href="/advertiser/statistics/ads?camp_id={%=o.id%}">
                    <i class="fa fa-line-chart"></i> <?php _e('Статистика'); ?>
                </a>
            </li>
            <li class="divider"></li>
            <li class="item-action" data-id="{%=o.id%}" data-action="delete">
                <a href="javascript:void(0);">
                    <i class="fa fa-trash"></i> <?php _e('Удалить'); ?>
                </a>
            </li>
        </ul>
    </div>
</script>
