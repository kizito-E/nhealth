<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<div class="modal fade" id="add-ticket">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?php _e('Новый тикет'); ?></h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label><?php _e('Получатель (ID Пользователя)'); ?></label>
                    <user-search v-model="user_id" api_url="/api/moderator/user/search" placeholder="Search: User ID or Username or E-mail"></user-search>
                </div>
                <div class="form-group">
                    <label><?php _e('Тема'); ?></label>
                    <input v-model="subject" type="text" class="form-control">
                </div>
                <label><?php _e('Сообщение'); ?></label>
                <textarea class="form-control form-group"
                          v-model="message"
                          rows="3"
                          style="resize:none;">
                </textarea>
            </div>


            <div class="modal-footer">
                <button @click="closeModal" data-dismiss="modal" class="btn btn-default pull-left">
                    <?php _e('Закрыть'); ?>
                </button>
                <button @click="createTicket" v-bind:disabled="button_active" class="btn btn-danger">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-check fa-fw"></i>
                    <?php _e('Сохранить'); ?>
                </button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="ticket-messages">
    <div class="modal-dialog">
        <div class="modal-content" >

            <div class="modal-header">
                <button @click="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ticket_id}} - {{subject}}</h4>
            </div>

            <div class="modal-body" style="padding:0; border-bottom: 1px solid #F4F4F4;">

                <div class="direct-chat-messages" style="max-height: 350px; height: auto; padding: 10px 15px;">

                    <div v-for="message in messages">

                        <div v-if="message.role == 'administrator'" class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left">
                                    <strong> {{message.username | capitalize}} </strong>
                                    <i class="text-muted"> ({{message.role}}) </i>
                                </span>
                                <span class="direct-chat-timestamp pull-right">
                                    {{message.created_at | toLocalDateFromNow}}
                                </span>
                            </div>
                            <img class="direct-chat-img" src="/assets/imgs/avatar_admin.png">
                            <div class="direct-chat-text left-direct-chat-text-red" v-html="message.message"></div>
                        </div>

                        <div v-else-if="message.subrole == 'moderator'" class="direct-chat-msg right">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-right">
                                    <strong> {{message.username | capitalize}} </strong>
                                    <i class="text-muted"> ({{message.subrole}}) </i>
                                </span>
                                <span class="direct-chat-timestamp pull-left">
                                    {{message.created_at | toLocalDateFromNow}}
                                    <span class="text-light-gray" v-bind:class="{ 'text-green' : Date.parse(message.read_at)}">
                                        <i class="fa fa-check"></i>
                                        <i class="fa fa-check" style="margin-left: -5px;"></i>
                                    </span>
                                </span>
                            </div>
                            <img class="direct-chat-img" src="/assets/imgs/avatar_moderator.png">
                            <div class="direct-chat-text direct-chat-text-purple" v-html="message.message"></div>
                        </div>


                        <div v-else-if="message.subrole == 'advertiser' || message.subrole == 'webmaster'" class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left">
                                    <strong> {{message.username | capitalize}} </strong>
                                    <i class="text-muted"> ({{message.role}}) </i>
                                </span>
                                <span class="direct-chat-timestamp pull-right">
                                    {{message.created_at | toLocalDateFromNow}}
                                </span>
                            </div>
                            <img class="direct-chat-img" src="/assets/imgs/avatar_user.png">
                            <div class="direct-chat-text" v-html="message.message"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="status == 1" class="modal-body">

                <div class="form-group pull-right"><?php _e('Сообщения:'); ?> {{messages.length}}</div>

                <label><?php _e('Сообщение'); ?></label>
                <textarea class="form-control"
                          v-model="message"
                          rows="3"
                          style="resize:none;"
                          maxlength="1500"
                          placeholder="<?php _e('HTML теги не поддерживаются!') ?>">
                </textarea>



            </div>


            <div v-else class="modal-body text-center">
                <i>
                    <?php _e('Тикет закрыт. Отправка сообщений недоступна.'); ?>
                </i>
            </div>


            <div v-if="status == 1" class="modal-footer">

                <button @click="closeModal" data-dismiss="modal" class="btn btn-default pull-left">
                    <?php _e('Закрыть'); ?>
                </button>

                <button @click="sendMessage" v-bind:disabled="button_active" class="btn btn-danger">
                    <i v-if="button_active" class="fa fa-circle-o-notch fa-spin fa-fw"></i>
                    <i v-else class="fa fa-comment fa-fw"></i>
                    <?php _e('Отправить'); ?>
                </button>
            </div>
        </div>
    </div>
</div>


