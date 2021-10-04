<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>



<script id="status" type="text/html">
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


<script id="type" type="text/html">
    {% if (o.type == 'banner') { %}
    <span class="label bg-teal"><?php _e('Баннер'); ?></span>
    {% } else { %}
    <span class="label bg-olive"><?php _e('Обьявление'); ?></span>
    {% } %}
</script>


<script id="camp" type="text/html">
    <ul class="list-group list-group-sm">
        <li class="list-group-item list-group-item-sm ">
            <b>Camp ID:</b> {%=o.camp_id%}
        </li>
        <li class="list-group-item list-group-item-sm ">
            <b>Camp name:</b> {%=o.camp_name%}
        </li>
        <li class="list-group-item list-group-item-sm ">
            <b>Theme:</b>

            {% if (o.camp_theme == 'auto_moto') { %}
            <span><?php _e('Авто / Мото'); ?></span>
            {% } else if(o.camp_theme == 'business_finance') { %}
            <span><?php _e('Бизнес / Финансы'); ?></span>
            {% } else if(o.camp_theme == 'house_family') { %}
            <span><?php _e('Дом /Семья'); ?></span>
            {% } else if(o.camp_theme == 'health_fitness') { %}
            <span><?php _e('Здоровье / Фитнесс'); ?></span>
            {% } else if(o.camp_theme == 'games') { %}
            <span><?php _e('Игры'); ?></span>
            {% } else if(o.camp_theme == 'career_work') { %}
            <span><?php _e('Карьера / Работа'); ?></span>
            {% } else if(o.camp_theme == 'cinema') { %}
            <span><?php _e('Кино'); ?></span>
            {% } else if(o.camp_theme == 'beauty_cosmetics') { %}
            <span><?php _e('Красота / Косметика'); ?></span>
            {% } else if(o.camp_theme == 'cookery') { %}
            <span><?php _e('Кулинария'); ?></span>
            {% } else if(o.camp_theme == 'fashion_clothes') { %}
            <span><?php _e('Одежда / Мода'); ?></span>
            {% } else if(o.camp_theme == 'music') { %}
            <span><?php _e('Музыка'); ?></span>
            {% } else if(o.camp_theme == 'the_property') { %}
            <span><?php _e('Недвижимость'); ?></span>
            {% } else if(o.camp_theme == 'news') { %}
            <span><?php _e('Новости'); ?></span>
            {% } else if(o.camp_theme == 'society') { %}
            <span><?php _e('Общество'); ?></span>
            {% } else if(o.camp_theme == 'entertainment') { %}
            <span><?php _e('Развлечения'); ?></span>
            {% } else if(o.camp_theme == 'sport') { %}
            <span><?php _e('Спорт'); ?></span>
            {% } else if(o.camp_theme == 'science') { %}
            <span><?php _e('Наука'); ?></span>
            {% } else if(o.camp_theme == 'goods') { %}
            <span><?php _e('Товары'); ?></span>
            {% } else if(o.camp_theme == 'tourism') { %}
            <span><?php _e('Туризм'); ?></span>
            {% } else if(o.camp_theme == 'adult') { %}
            <span><?php _e('Для взрослых'); ?></span>
            {% } else if(o.camp_theme == 'other') { %}
            <span><?php _e('Другое'); ?></span>
            {% } %}



        </li>
    </ul>
</script>

<script id="userdata" type="text/html">
    <ul class="list-group list-group-sm">
        <li class="list-group-item list-group-item-sm ">
            <b>User ID:</b>

            {% if(window.filter_user_id === null) { %}
            <a href="/moderator/ads?user_id={%=o.user_id%}">{%=o.user_id%}</a>
            {% } else { %}
            {%=o.user_id%}
            {% } %}

        </li>
        <li class="list-group-item list-group-item-sm ">
            <b>Username:</b>

            {% if(window.filter_user_id === null) { %}
            <a href="/moderator/ads?user_id={%=o.user_id%}">{%=o.username%}</a>
            {% } else { %}
            {%=o.username%}
            {% } %}

        </li>
        <li class="list-group-item list-group-item-sm ">
            <b>Email:</b>

            {% if(window.filter_user_id === null) { %}
            <a href="/moderator/ads?user_id={%=o.user_id%}">{%=o.email%}</a>
            {% } else { %}
            {%=o.email%}
            {% } %}

        </li>
    </ul>
</script>


<script id="payment" type="text/html">
    <ul class="list-group list-group-sm">
        <li class="list-group-item list-group-item-sm">
            <b>Mode:</b> {%=o.mode%}
        </li>
        {% if (o.mode == 'cpc') { %}
        <li class="list-group-item list-group-item-sm">
            <b>CPC:</b> {%=o.cpc%}
        </li>
        {% } else { %}
        <li class="list-group-item list-group-item-sm">
            <b>CPV:</b> {%=o.cpv%}
        </li>
        {% } %}
    </ul>
</script>



<script id="preview" type="text/html">
    <div style="cursor: pointer;" class="ad-preview" data="{%=o.ad_id%}">
        {% if(o.type == 'banner') { %}
        <img class="thumbnail" src="{%=o.img_url%}" style="max-width: 150px; max-height: 74px;"/>
        {% } else {  %}

        <img class="pull-left thumbnail" src="{%=o.img_url || '/assets/imgs/no-image.png'%}" style="width: 74px; height: 74px; object-fit: cover;"/>

        <ul class="list-group list-group-sm" style="margin-left: 80px;">
            <li class="list-group-item list-group-item-sm text-blue">
                <b>{%=o.title.slice(0, 20) + '...' %}</b>
            </li>
            <li class="list-group-item list-group-item-sm">
                {%=o.description.slice(0, 20) + '...' %}
            </li>
            <li class="list-group-item list-group-item-sm text-green">
                {%=o.ad_url.split('/')[2] %}
            </li>
        </ul>
        {% } %}
    </div>
</script>


<script id="actions" type="text/html">
    <div class="btn-group">
        <button class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown">
            <i class="fa fa-fw fa-cogs"></i>
            <?php _e('Действия'); ?>
            <span class="fa fa-fw fa-caret-down"></span>
        </button>
        <ul class="dropdown-menu pull-right" role="menu">

            <li class="dsa-action" data-id="{%=o.ad_id%}" data-action="moderate">
                <a href="javascript:void(0);">
                    <i class="fa fa-fw fa-lightbulb-o"></i> <?php _e('Модерация'); ?>
                </a>
            </li>

            {% if (o.status == 0) { %}
            <li class="dsa-action" data-id="{%=o.ad_id%}" data-action="play">
                <a href="javascript:void(0);">
                    <i class="fa fa-fw fa-play"></i> <?php _e('Включить'); ?>
                </a>
            </li>
            {% } else if (o.status == 1) { %}
            <li class="dsa-action" data-id="{%=o.ad_id%}" data-action="stop">
                <a href="javascript:void(0);">
                    <i class="fa fa-fw fa-stop"></i> <?php _e('Отключить'); ?>
                </a>
            </li>
            {% } %}

            <li class="divider"></li>

            {% if (o.status == -2) { %}
            <li class="dsa-action" data-id="{%=o.ad_id%}" data-action="unban">
                <a href="javascript:void(0);">
                    <i class="fa fa-fw fa-play-circle"></i> <?php _e('Разбанить'); ?>
                </a>
            </li>

            {% } else { %}
            <li class="dsa-action" data-id="{%=o.ad_id%}" data-action="ban">
                <a href="javascript:void(0);">
                    <i class="fa fa-ban"></i> <?php _e('Забанить'); ?>
                </a>
            </li>
            {% } %}
        </ul>
    </div>
</script>


<script id="dsa-preview" type="text/html">
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">
                        <?php _e('Превью'); ?>
                    </h4>
                </div>

                <div class="modal-body">
                    {% if(o.type == 'banner') { %}
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="list-group list-group-sm pull-right" style="display: inline-block;">
                                <li class="list-group-item list-group-item-sm">
                                    <b><?php _e('ширина:'); ?> </b>{%=o.img_width %}px
                                </li>
                                <li class="list-group-item list-group-item-sm">
                                    <b><?php _e('высота:'); ?> </b>{%=o.img_height %}px
                                </li>
                            </ul>
                            <div class="col-sm-12 form-group">
                                <img class="center-block" style="max-width: 400px; max-height: 300px;" src="{%=o.img_url%}"/>
                            </div>
                        </div>
                    </div>
                    {% } else { %}
                    <div class="row">
                        <div class="col-sm-3 form-group">
                            <img class="" style="width: 140px; height: 140px; object-fit: cover;" src="{%=o.img_url || '/assets/imgs/no-image.png'%}"/>
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <b class="text-blue" style="font-size: 18px;">{%=o.title%}</b>
                                </div>
                                <div class="col-sm-12 form-group">
                                    {%=o.description%}
                                </div>
                                <div class="col-sm-12 text-green">
                                    {%=o.ad_url.split('/')[2]%}
                                </div>
                            </div>
                        </div>
                    </div>
                    {% } %}
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