<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="modal fade" id="add-site">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?php _e('Добавление сайта'); ?> </h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label><?php _e('Сайт'); ?></label>
                    <input v-model="domain" type="text" class="form-control" placeholder="yoursite.com">
                </div>

                <div class="form-group">
                    <label><?php _e('ID Пользователя'); ?></label>
                    <user-search v-model="user_id" api_url="/api/moderator/user/search"
                                 placeholder="Search: User ID or Username or E-mail"></user-search>
                </div>

                <div class="form-group">
                    <label><?php _e('Тематика сайта'); ?></label>

                    <select v-model="theme" class="form-control selectpicker"
                            data-style="btn-default btn-flat"
                            data-width="100%"
                            title="<?php _e('Выбирите тематику сайта'); ?>"
                            data-size="12">
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

                <div class="form-group">
                    <label><?php _e('Тематики обьявлений разрешенных к показу'); ?></label>
                    <select multiple v-model="allowed_camp_themes" class="form-control selectpicker"
                            data-style="btn-default btn-flat"
                            data-width="100%"
                            title="<?php _e('Выбирите тематики обьявлений'); ?>"
                            data-selected-text-format="count > 0"
                            data-actions-box="true"
                            data-size="12">
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


                <div class="form-group">
                    <label><?php _e('URL статистики'); ?></label>
                    <input v-model="stat_url" type="text" class="form-control">
                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label><?php _e('Логин статистики'); ?></label>
                            <input v-model="stat_login" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label><?php _e('Пароль статистики'); ?></label>
                            <input v-model="stat_password" type="text" class="form-control">
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button @click="closeModal" data-dismiss="modal" class="btn btn-default pull-left">
                    <?php _e('Закрыть'); ?>
                </button>

                <button v-if="!is_complete" @click="addSite" v-bind:disabled="button_active" class="btn btn-danger">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    <?php _e('Добавить'); ?>
                </button>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit-site">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?php _e('Редактирование сайта'); ?> - [ID: {{site_id}}]</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label><?php _e('Сайт'); ?></label>
                    <input v-model="domain" readonly type="text" class="form-control" placeholder="yoursite.com">
                </div>

                <div class="form-group">
                    <label><?php _e('Тематика сайта'); ?></label>
                    <select v-model="theme" class="form-control selectpicker"
                            data-style="btn-default btn-flat"
                            data-width="100%"
                            title="<?php _e('Выбирите тематику сайта'); ?>"
                            data-size="12">
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

                <div class="form-group">
                    <label><?php _e('Тематики обьявлений разрешенных к показу'); ?></label>
                    <select multiple v-model="allowed_camp_themes" class="form-control selectpicker"
                            data-style="btn-default btn-flat"
                            data-width="100%"
                            title="<?php _e('Выбирите тематики обьявлений'); ?>"
                            data-selected-text-format="count > 0"
                            data-actions-box="true"
                            data-size="12">
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


                <div class="form-group">
                    <label><?php _e('URL статистики'); ?></label>
                    <input v-model="stat_url" type="text" class="form-control">
                </div>


                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label><?php _e('Логин статистики'); ?></label>
                            <input v-model="stat_login" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label><?php _e('Пароль статистики'); ?></label>
                            <input v-model="stat_password" type="text" class="form-control">
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button @click="closeModal" data-dismiss="modal" class="btn btn-default pull-left">
                    <?php _e('Закрыть'); ?>
                </button>

                <button @click="update" class="btn btn-danger">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    <?php _e('Сохранить'); ?>
                </button>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="moderate-site">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?php _e('Модерация сайта'); ?></h4>
            </div>

            <div class="modal-body">

                <div class="callout callout-warning">
                    <b><?php _e('Советы по модерации'); ?></b><br>
                    <?php _e('1. Проверьте совпадает ли тематика сайта с той которую указал вебмастер.'); ?>
                    <?php _e('Если не совпадает, вы можете указать подходящую тематику в выпадающем списке.'); ?><br>
                    <?php _e('2. Проверьте источники трафика - хороший показатель если 70% посетителей сайта заходят из поисковых систем.'); ?>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6">
                        <label><?php _e('Сайт'); ?></label>
                        <div class="input-group">
                            <input v-model="domain" readonly type="text" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-flat btn-clipboard">
                                    <i class="fa fa-clipboard"></i>
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label><?php _e('Тематика сайта'); ?></label>
                        <select v-model="theme" class="form-control selectpicker"
                                data-style="btn-default btn-flat"
                                data-width="100%"
                                title="<?php _e('Выбирите тематику сайта'); ?>"
                                data-size="12">
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

                </div>

                <div class="form-group">
                    <label><?php _e('URL статистики'); ?></label>
                    <div class="input-group">
                        <input v-model="stat_url" readonly type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default btn-flat btn-clipboard">
                                <i class="fa fa-clipboard"></i>
                            </button>
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label><?php _e('Логин статистики'); ?></label>
                        <div class="input-group">
                            <input v-model="stat_login" readonly type="text" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-flat btn-clipboard">
                                    <i class="fa fa-clipboard"></i>
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label><?php _e('Пароль статистики'); ?></label>
                        <div class="input-group">
                            <input v-model="stat_password" readonly type="text" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-flat btn-clipboard">
                                    <i class="fa fa-clipboard"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group" v-bind:class="{ 'has-error' : rejectMessageError }">
                    <label><?php _e('Причина отклонения'); ?></label>
                    <textarea class="form-control"
                              v-model="reject_message"
                              rows="4">
                    </textarea>
                    <span class="help-block" v-bind:class="{ 'hidden' : !rejectMessageError }">
                        <?php _e('Укажите причину отклонения сайта.') ?>
                    </span>
                </div>

            </div>

            <div class="modal-footer">

                <button @click="reject" class="btn btn-danger pull-left">
                    <i v-if="button_reject_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-ban fa-fw"></i>
                    <?php _e('Отклонить сайт'); ?>
                </button>

                <button @click="accept" class="btn btn-success">
                    <i v-if="button_success_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    <?php _e('Одобрить сайт'); ?>
                </button>

            </div>
        </div>
    </div>
</div>

