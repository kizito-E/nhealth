<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends MY_Controller {

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
        $tickets = $this->Ticket2->fetch_dt([
            'user_id' => userdata()->id
        ]);

        // count unread messages
        foreach ($tickets['data'] as &$ticket) {
            //
            $ticket['count_new_messages'] = $this->Message2->count([
                'ticket_id'  => $ticket['ticket_id'],
                'user_id !=' => $ticket['user_id'],
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
            'user_id'   => userdata()->id,
            'ticket_id' => $this->input->post_get('ticket_id')
        ]);

        exit_json(0, '', $ticket);
    }


    public function add()
    {
        $this->validation->make([
            "subject" => "required|max_length[100]",
            "message" => "required|max_length[3000]"
                ], [
            "subject.required"   => __('Тема тикета не может быть пустым!'),
            "subject.max_length" => __('Тема тикета не может быть больше {param} символов!'),
            "message.required"   => __('Сообщение не может быть пустым!'),
            "message.max_length" => __('Сообщение не может быть больше {param} символов!'),
        ]);

        if ($this->validation->status() === false) {
            exit_json(1, $this->validation->first_error());
        }

        $ticket_obj = $this->Ticket2->add([
            'user_id'    => userdata()->id,
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
        $ret = $this->Ticket2->close($this->input->post_get('ticket_id'), [
            'user_id' => userdata()->id,
        ]);

        if (!$ret) {
            exit_json(1, __('Не удалось изменить статус тикета!'));
        }

        exit_json(0, __('Тикет закрыт.'));
    }


    public function open()
    {
        $ret = $this->Ticket2->open($this->input->post_get('ticket_id'), [
            'user_id' => userdata()->id,
        ]);

        if (!$ret) {
            exit_json(1, __('Не удалось изменить статус тикета!'));
        }

        exit_json(0, __('Тикет открыт.'));
    }


}
