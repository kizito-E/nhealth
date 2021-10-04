<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Session extends CI_Session
{
    // Для этих URI класс сессий НЕ подключаем
    private $ignore_uris = [
        'provider',
        'view',
        'click'
    ];

    public function __construct(array $params = [])
    {
        if ($this->is_ignore_uri()) {
            return;
        }

        parent::__construct();
    }

    public function is_ignore_uri()
    {
        $uri_segments = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $first_segment = isset($uri_segments[0]) ? $uri_segments[0] : null;

        return in_array($first_segment, $this->ignore_uris);
    }
}