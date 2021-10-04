<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<div class="modal fade" id="moderate-dsa">
    <div class="modal-dialog" style="width: 700px">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ad_id}} - <?php _e('Модерация обьявления'); ?></h4>
            </div>

            <div class="modal-body">

                <div class="callout callout-warning">
                    <i class="fa fa-info-circle fa-fw"></i>
                    <b><?php _e('Советы по модерации'); ?></b><br>
                    <?php _e('1. Проверьте совпадает ли тематика обьявления с тематикой кампании - '); ?><b>{{camp_theme}}</b><br>
                    <?php _e('2. Проверьте соответствует ли изображение (если оно есть) тексту обьявления.'); ?><br>
                    <?php _e('3. Проверьте ссылку обьявления. Соответствует ли тематика страници тематике обьявления.'); ?>
                </div>

                <hr>

                <div class="row" v-if="type === 'ad'">
                    <div class="col-sm-3">
                        <img style="max-width: 150px; height: 150px; object-fit: cover;" class="img-responsive" :src="img_url || '/assets/imgs/no-image.png'"/>
                    </div>

                    <div class="col-sm-9">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <b class="text-blue">{{title}}</b>
                            </li>
                            <li class="list-group-item" style="min-height: 70px;">
                                {{description}}
                            </li>
                            <li class="list-group-item">
                                <span class="text-green">{{ad_url.split('/')[2]}}</span>
                            </li>
                            <li v-if="action_text" class="list-group-item">
                                <span>{{action_text}}</span>
                            </li>
                        </ul>
                    </div>
                </div>


                <div class="row" v-else>

                    <div class="col-sm-12">

                        <div class="form-group" style="position: relative; min-height: 150px;">
                            <img class="img-responsive center-block"
                                 :src="img_url"
                                 style="max-width: 400px; max-height: 300px;"/>

                            <ul class="list-group list-group-sm"
                                style="display: inline-block; position: absolute; top: 20px; right: 10px;">
                                <li class="list-group-item list-group-item-sm">
                                    <b><?php _e('ширина:'); ?> </b>{{img_width}}px
                                </li>
                                <li class="list-group-item list-group-item-sm">
                                    <b><?php _e('высота:'); ?> </b>{{img_height}}px
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">

                    <div class="col-sm-12">


                        <div class="form-group">
                            <div class="callout callout-danger">
                                <i class="fa fa-exclamation-triangle fa-fw"></i>
                                <?php _e('Тематика обьявления должна соответствовать тематике - '); ?>
                                <b>{{camp_theme}}</b>
                            </div>
                        </div>

                    </div>


                    <div class="col-sm-6">
                        <label><?php _e('Тематика кампании'); ?></label>
                        <select v-model="camp_theme" class="form-control selectpicker"
                                data-style="btn-default btn-flat"
                                data-width="100%"
                                disabled>
                            <option value='auto_moto'><?php _e('Авто / Мото'); ?></option>
                            <option value='business_finance'><?php _e('Бизнес / Финансы'); ?></option>
                            <option value='house_family'><?php _e('Дом /Семья'); ?></option>
                            <option value='health_fitness'><?php _e('Здоровье / Фитнесс'); ?></option>
                            <option value='games'><?php _e('Игры'); ?></option>
                            <option value='career_work'><?php _e('Карьера / Работа'); ?></option>
                            <option value='cinema'><?php _e('Кино'); ?></option>
                            <option value='beauty_cosmetics'><?php _e('Красота / Косметика'); ?></option>
                            <option value='cookery'><?php _e('Кулинария'); ?></option>
                            <option value='fashion_clothes'><?php _e('Одежда / Мода'); ?></option>
                            <option value='music'><?php _e('Музыка'); ?></option>
                            <option value='the_property'><?php _e('Недвижимость'); ?></option>
                            <option value='news'><?php _e('Новости'); ?></option>
                            <option value='society'><?php _e('Общество'); ?></option>
                            <option value='entertainment'><?php _e('Развлечения'); ?></option>
                            <option value='sport'><?php _e('Спорт'); ?></option>
                            <option value='science'><?php _e('Наука'); ?></option>
                            <option value='goods'><?php _e('Товары'); ?></option>
                            <option value='tourism'><?php _e('Туризм'); ?></option>
                            <option value='adult'><?php _e('Для взрослых'); ?></option>
                            <option value='other'><?php _e('Другое'); ?></option>
                        </select>
                    </div>


                    <div class="col-sm-6">
                        <label><?php _e('Рекламный URL'); ?></label>
                        <div class="input-group">
                            <input v-model="ad_url" readonly type="text" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-flat btn-clipboard">
                                    <i class="fa fa-clipboard"></i>
                                </button>
                            </span>
                        </div>
                    </div>


                </div>


            </div>

            <div class="modal-footer">

                <div class="form-group" :class="{ 'has-error' : rejectMessageError }">
                    <label class="pull-left"><?php _e('Причина отклонения'); ?></label>
                    <textarea class="form-control"
                              v-model="reject_message"
                              rows="3">
                    </textarea>
                    <span class="help-block" :class="{ 'hidden' : !rejectMessageError }">
                        <?php _e('Укажите причину отклонения обьявления.') ?>
                    </span>
                </div>

                <div class="row">

                    <div class="col-sm-3">
                        <button @click="reject" class="btn btn-danger btn-block">
                            <i v-if="button_reject_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                            <i v-else class="fa fa-ban fa-fw"></i>
                            <?php _e('Отклонить'); ?>
                        </button>
                    </div>

                    <div class="col-sm-3">
                        <button @click="closeModal" data-dismiss="modal" class="btn btn-default btn-block">
                            <?php _e('Закрыть'); ?>
                        </button>
                    </div>

                    <div class="col-sm-3">
                        <button @click="moderateNext" class="btn btn-primary btn-block">
                            <i class="fa fa-chevron-right"></i>
                            <?php _e('Cледующее'); ?>
                        </button>
                    </div>

                    <div class="col-sm-3">
                        <button @click="accept" class="btn btn-success btn-block">
                            <i v-if="button_success_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                            <i v-else class="fa fa-check fa-fw"></i>
                            <?php _e('Одобрить'); ?>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>