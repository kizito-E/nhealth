<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tab-pane active" id="_1">
    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?php _e('Имя кампании'); ?>
                    <i class="fa fa-question-circle text-primary"
                       data-toggle="tooltip"
                       title="<?php _e('Имя кампании, будет видно только вам.'); ?>">
                    </i>
                </label>
                <input v-model="name" type="text" maxlength="50" class="form-control">
            </div>

            <?php if (is_administrator() === true): ?>

                <div class="form-group">
                    <label>
                        <?php _e('Изолированная кампания'); ?>
                        <i class="fa fa-question-circle text-primary"
                           data-toggle="tooltip"
                           title="<?php _e('Обьявления из изолированной кампании, будут показаны только на изолированых сайтах.  Подробнее читайте в документации.'); ?>">
                        </i>
                    </label>
                    <select v-model="isolated" class="form-control selectpicker"
                            data-style="btn-default btn-flat"
                            data-width="100%">
                        <option value='0'><?php _e('Не изолированная'); ?></option>
                        <option value='1'><?php _e('Изолированная'); ?></option>
                    </select>
                </div>

            <?php endif; ?>


        </div>

    </div>

    <div class="row">

        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?php _e('Тип кампании'); ?>
                    <i class="fa fa-question-circle text-primary"
                       data-toggle="tooltip"
                       title="<?php _e('Тип кампании. Баннеры или тексто-графические обьявления.'); ?>">
                    </i>
                </label>
                <select disabled v-model="type" class="selectpicker" data-style="btn-default btn-flat" data-width="100%">
                    <option value="banners"><?php _e('Баннерная'); ?></option>
                    <option value="ads"><?php _e('Тексто-графическая'); ?></option>
                </select>
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?php _e('Тематика'); ?>
                    <i class="fa fa-question-circle text-primary"
                       data-toggle="tooltip"
                       title="<?php _e('Тематика кампании. Все обьявления кампании должны соответствовать этой тематике.'); ?>">
                    </i>
                </label>
                <select v-model="theme"
                        disabled
                        class="selectpicker"
                        data-style="btn-default btn-flat"
                        data-width="100%"
                        data-size="12"
                        data-actions-box="true"
                        data-selected-text-format="count > 0">
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
                    <option value='other'><?php _e('Другое'); ?></option>
                    <option value='adult'><?php _e('Для взрослых'); ?></option>
                </select>
            </div>

        </div>
    </div>


    <div class="form-group">
        <div class="row">

            <div class="col-md-6">
                <label>
                    <?php _e('Дата старта'); ?>
                    <i class="fa fa-question-circle text-primary"
                       data-toggle="tooltip"
                       title="<?php _e('Дата начала показа обьявлений.'); ?>">
                    </i>
                </label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input v-model="start_date" @click="updateStartDate($event.target.value)" type="text" class="form-control pull-right _datepicker">
                </div>
            </div>

            <div class="col-md-6">
                <label>
                    <?php _e('Дата остановки'); ?>
                    <i class="fa fa-question-circle text-primary"
                       data-toggle="tooltip"
                       title="<?php _e('При наступлении этой даты - показ обьявлений этой кампании прекратится.'); ?>">
                    </i>
                </label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input v-model="end_date" @click="updateEndDate($event.target.value)" type="text" class="form-control pull-right _datepicker">
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?php _e('Часы показов'); ?>
                    <i class="fa fa-question-circle text-primary"
                       data-toggle="tooltip"
                       title="<?php _e('Обьявления кампании будут показыватся только в выбранные часы.'); ?>">
                    </i>
                </label>
                <select v-model="hours" multiple class="selectpicker"
                        data-style="btn-default btn-flat"
                        data-width="100%"
                        data-size="12"
                        data-actions-box="true"
                        data-selected-text-format="count > 0">
                    <option value="00">00 - 01</option>
                    <option value="01">01 - 02</option>
                    <option value="02">02 - 03</option>
                    <option value="03">03 - 04</option>
                    <option value="04">04 - 05</option>
                    <option value="05">05 - 06</option>
                    <option value="06">06 - 07</option>
                    <option value="07">07 - 00</option>
                    <option value="08">08 - 09</option>
                    <option value="09">09 - 10</option>
                    <option value="10">10 - 11</option>
                    <option value="11">11 - 12</option>
                    <option value="12">12 - 13</option>
                    <option value="13">13 - 14</option>
                    <option value="14">14 - 15</option>
                    <option value="15">15 - 16</option>
                    <option value="16">16 - 17</option>
                    <option value="17">17 - 18</option>
                    <option value="18">18 - 19</option>
                    <option value="19">19 - 20</option>
                    <option value="20">20 - 21</option>
                    <option value="21">21 - 22</option>
                    <option value="22">22 - 23</option>
                    <option value="23">23 - 00</option>
                </select>
            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?php _e('Дни показов'); ?>
                    <i class="fa fa-question-circle text-primary"
                       data-toggle="tooltip"
                       title="<?php _e('Обьявления кампании будут показыватся только в выбранные дни.'); ?>">
                    </i>
                </label>
                <select v-model="days" multiple class="selectpicker"
                        data-style="btn-default btn-flat"
                        data-width="100%"
                        data-size="7"
                        data-actions-box="true"
                        data-selected-text-format="count > 0">
                    <option value="1"><?php _e('Понедельник'); ?></option>
                    <option value="2"><?php _e('Вторник'); ?></option>
                    <option value="3"><?php _e('Среда'); ?></option>
                    <option value="4"><?php _e('Четверг'); ?></option>
                    <option value="5"><?php _e('Пятница'); ?></option>
                    <option value="6"><?php _e('Суббота'); ?></option>
                    <option value="7"><?php _e('Воскресенье'); ?></option>
                </select>
            </div>

        </div>
    </div>

</div>