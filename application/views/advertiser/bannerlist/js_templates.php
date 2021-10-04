<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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
                <a class="text-green" href="{%=o.ad_url%}">{%=o.ad_url.split('/')[2] %}</a>
            </li>
        </ul>
        {% } %}
    </div>
</script>





<script id="status" type="text/html">
    {% if (o.status == 1) { %}
    <span class="label label-success"><?php _e('Активен'); ?></span>
    {% } else if(o.status == -1) { %}
    <span class="label label-primary"><?php _e('На модерации'); ?></span>
    {% } else if(o.status == -2) { %}
    <span class="label label-default"><?php _e('Забанен'); ?></span>
    {% } else { %}
    <span class="label label-danger"><?php _e('Остановлен'); ?></span>
    {% } %}

    {% if (o.status == -2 && o.status_message) { %}
    <i class="fa fa-question-circle" data-toggle="tooltip" title="{%=o.status_message%}"></i>
    {% } %}

</script>


<script id="actions" type="text/html">
    <div class="btn-group">
        <button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-sm fix-dropdown">
            <i class="fa fa-cogs"></i> <?php _e('Действия'); ?> <span class="fa fa-caret-down"></span>
        </button>
        <ul role="menu" class="dropdown-menu pull-right">
            {% if (o.status == 0) { %}
            <li class="item-action" data-id="{%=o.ad_id%}" data-action="play">
                <a href="javascript:void(0);">
                    <i class="fa fa-play"></i> <?php _e('Включить'); ?>
                </a>
            </li>
            {% } else if(o.status == 1) { %}
            <li class="item-action" data-id="{%=o.ad_id%}" data-action="stop">
                <a href="javascript:void(0);">
                    <i class="fa fa-stop"></i> <?php _e('Отключить'); ?>
                </a>
            </li>
            {% } %}

            <li class="item-action" data-id="{%=o.ad_id%}" data-action="edit">
                <a href="javascript:void(0);"><i class="fa fa-pencil"></i> <?php _e('Редактировать'); ?></a>
            </li>

            <li><a href="/advertiser/statistics/ads?camp_id={%=o.camp_id%}"><i class="fa fa-line-chart"></i> <?php _e('Статистика'); ?></a></li>

            <li class="divider"></li>

            <li class="item-action" data-id="{%=o.ad_id%}" data-action="delete">
                <a href="javascript:void(0);"><i class="fa fa-trash-o"></i> <?php _e('Удалить'); ?></a>
            </li>
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
                        <div class="col-sm-12 form-group">

                            <ul class="list-group list-group-sm pull-right" style="display: inline-block;">
                                <li class="list-group-item list-group-item-sm">
                                    <b><?php _e('ширина:'); ?> </b>{%=o.img_width %}px
                                </li>
                                <li class="list-group-item list-group-item-sm">
                                    <b><?php _e('высота:'); ?> </b>{%=o.img_height %}px
                                </li>
                            </ul>

                            <img class="center-block" style="max-width: 400px; max-height: 300px;" src="{%=o.img_url%}"/>
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
