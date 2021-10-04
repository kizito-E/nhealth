<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        is_moderator() OR exit_json(1, __('Ошибка доступа!'));
        check_csrf_token() OR exit_json(1, __('Некорректный CSRF токен!'));
    }


    public function index()
    {
        exit;
    }


    public function fetch()
    {
        $where = [];

        if ($this->input->post('filter_user_id')) {
            $where['user_id'] = $this->input->post_get('filter_user_id');
        }

        $tickets = $this->Ticket2->fetch_dt($where);

        // count unread messages
        foreach ($tickets['data'] as &$ticket) {

            $user_obj = $this->User2->get(['id' => $ticket['user_id']]);

            $ticket['username'] = isset($user_obj->username) ? $user_obj->username : "";
            $ticket['email']    = isset($user_obj->email) ? $user_obj->email : "";

            //
            $ticket['count_new_messages'] = $this->Message2->count([
                'ticket_id'  => $ticket['ticket_id'],
                'user_id !=' => userdata()->id,
                'read_at'    => null,
            ]);

            $ticket['count_all_messages'] = $this->Message2->count([
                'ticket_id' => $ticket['ticket_id']
            ]);
        }

        exit(json_encode($tickets + ['error' => 0], JSON_PRETTY_PRINT));
    }


    public function get()
    {
        $ticket = $this->Ticket2->get([
            'ticket_id' => $this->input->post_get('ticket_id')
        ]);

        exit_json(0, '', $ticket);
    }


    public function add()
    {
        $this->validation->make([
            "user_id" => "required|is_exists[users.id]",
            "subject" => "required|max_length[100]",
            "message" => "required|max_length[3000]"
                ], [
            "user_id.*"          => __('Некорректный ID пользователя!'),
            "subject.required"   => __('Тема тикета не может быть пустым!'),
            "subject.max_length" => __('Тема тикета не может быть больше {param} символов!'),
            "message.required"   => __('Сообщение не может быть пустым!'),
            "message.max_length" => __('Сообщение не может быть больше {param} символов!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $ticket_obj = $this->Ticket2->add([
            'user_id'    => $this->input->post('user_id'),
            'subject'    => $this->input->post('subject'),
            'status'     => 1,
            'created_at' => gmdate('Y-m-d H:i:s')
        ]);

        if (isset($ticket_obj->ticket_id)) {

            $this->Message2->add([
                'ticket_id'  => $ticket_obj->ticket_id,
                'user_id'    => userdata()->id,
                'message'    => $this->input->post('message'),
                'created_at' => gmdate('Y-m-d H:i:s'),
            ]);

            exit_json(0, __('Тикет успешно создан!'));
        }

        exit_json(1, __('Ошибка!'));
    }


    public function close()
    {
        if (!$this->Ticket2->close($this->input->post_get('ticket_id'))) {
            exit_json(1, __('Не удалось изменить статус тикета!'));
        }

        exit_json(0, __('Тикет закрыт.'));
    }


    public function open()
    {
        if (!$this->Ticket2->open($this->input->post_get('ticket_id'))) {
            exit_json(1, __('Не удалось изменить статус тикета!'));
        }

        exit_json(0, __('Тикет открыт.'));
    }


}
