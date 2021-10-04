<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        is_webmaster() OR exit_json(1, __('Ошибка доступа!'));
        check_csrf_token() OR exit_json(1, __('Некорректный CSRF токен!'));
    }


    public function index()
    {
        exit;
    }


    public function fetch()
    {
        $ticket_obj = $this->Ticket2->get([
            'ticket_id' => $this->input->get_post('ticket_id')
        ]);

        if (empty($ticket_obj->user_id) || $ticket_obj->user_id != userdata()->id) {
            exit_json(1, __('Нет прав на чтение сообщений этого тикета!'));
        }

        $messages = $this->Message2->fetch([
            'ticket_id' => $this->input->get_post('ticket_id')
        ]);

        foreach ($messages as &$message) {
            $userdata          = $this->User2->get(['id' => $message->user_id]);
            $message->username = isset($userdata->username) ? $userdata->username : '';
            $message->role     = isset($userdata->role) ? $userdata->role : '';
            $message->subrole  = isset($userdata->subrole) ? $userdata->subrole : '';
            $message->email    = isset($userdata->email) ? $userdata->email : '';
            $message->message  = nl2br(htmlspecialchars($message->message));
        }

        unset($message);

        // mark messages as read
        foreach ($messages as $message) {
            if (!$message->read_at && ($message->user_id != userdata()->id)) {
                $this->Message2->seen($message->message_id);
            }
        }

        exit_json(0, '', $messages);
    }


    public function send()
    {
        $ticket_obj = $this->Ticket2->get([
            'ticket_id' => $this->input->get_post('ticket_id')
        ]);

        if (empty($ticket_obj->user_id) || $ticket_obj->user_id != userdata()->id) {
            exit_json(1, __('Вы не можете писать в этот тикет'));
        }

        if (strlen($this->input->post('message')) < 1) {
            exit_json(1, __('Сообщение не может быть пустым'));
        }

        $message_obj = $this->Message2->add([
            'user_id'    => userdata()->id,
            'ticket_id'  => $this->input->post('ticket_id'),
            'message'    => $this->input->post('message'),
            'created_at' => gmdate('Y-m-d H:i:s'),
        ]);

        if (!$message_obj) {
            exit_json(1, __('Ошибка при отправке сообщения!'));
        }

        exit_json(0, __('Сообщение  отправлено.'));
    }


}
