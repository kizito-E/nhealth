<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="modal fade" id="add-site">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">×</span></button>
        <h4 v-if="!is_edit" class="modal-title"><?php _e('Добавление сайта'); ?></h4>
        <h4 v-else class="modal-title"><?php _e('Редактирование сайта'); ?> - [ID: {{site_id}}]</h4>
      </div>
      <div class="modal-body">

        <div class="alert alert-danger">
          <h4><?php _e('Внимание!'); ?></h4>
          <p>
              <?php _e('Префикс важен!'); ?> <br>
            <strong style="text-transform: uppercase;">www.site.com </strong>
              <?php _e(' НЕ тоже самое что '); ?>
            <strong style="text-transform: uppercase;">site.com </strong>
              <?php _e('Для системы это 2 разных сайта.'); ?>
          </p>
        </div>


        <div class="form-group">
          <label>
              <?php _e('Сайт'); ?>
            <i class="fa fa-question-circle text-primary"
               data-toggle="tooltip"
               title="<?php _e('Укажите сайт без http:// https://'); ?>">
            </i>
          </label>
          <input v-model="domain" v-bind:disabled="is_edit" type="text" class="form-control" placeholder="yoursite.com">
        </div>

          <?php if (is_administrator() === true): ?>

            <div class="form-group">
              <label>
                  <?php _e('Изолированный сайт'); ?>
                <i class="fa fa-question-circle text-primary"
                   data-toggle="tooltip"
                   title="<?php _e('На изолированном сайте, будут показаны обьявления, только изолированных кампаний. Подробнее читайте в документации.'); ?>">
                </i>
              </label>
              <select v-model="isolated" class="form-control selectpicker"
                      data-style="btn-default btn-flat"
                      data-width="100%">
                <option value='0'><?php _e('Не изолированный'); ?></option>
                <option value='1'><?php _e('Изолированный'); ?></option>
              </select>
            </div>

          <?php endif; ?>


        <div class="form-group">
          <label>
              <?php _e('Тематика сайта'); ?>
            <i class="fa fa-question-circle text-primary"
               data-toggle="tooltip"
               title="<?php _e('Укажите наиболее подходящую тематику к которой относится ваш сайт.'); ?>">
            </i>
          </label>
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
          <label>
              <?php _e('Тематики обьявлений разрешенных к показу'); ?>
            <i class="fa fa-question-circle text-primary"
               data-toggle="tooltip"
               title="<?php _e('На сайте будут показаны обьявления отмеченных тематик.'); ?>">
            </i>
          </label>
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
          <label>
              <?php _e('URL статистики'); ?>
            <i class="fa fa-question-circle text-primary"
               data-toggle="tooltip"
               title="<?php _e('Ссылка на систему статистики. Мы должны увидеть источники трафика вашего сайта.'); ?>">
            </i>
          </label>
          <input v-model="stat_url" type="text" class="form-control">
        </div>
        <div class="row form-group">
          <div class="col-lg-6">
            <label><?php _e('Логин от статистики (если есть)'); ?></label>
            <input v-model="stat_login" type="text" class="form-control">
          </div>
          <div class="col-lg-6">
            <label><?php _e('Пароль от статистики (если есть)'); ?></label>
            <input v-model="stat_password" type="text" class="form-control">
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button @click="closeModal" data-dismiss="modal" class="btn btn-default pull-left">
            <?php _e('Закрыть'); ?>
        </button>
        <button @click="addSite" class="btn btn-primary">
          <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
          <i v-else class="fa fa-check fa-fw"></i>
            <?php _e('Сохранить'); ?>
        </button>
      </div>
    </div>
  </div>
</div>

