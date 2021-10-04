<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Event {

    public $events = [];

    public function on($name, $handler)
    {
        $this->events[] = [
            'name'    => $name,
            'handler' => $handler
        ];
    }


    public function trigger($name, $params)
    {
        foreach ($this->events as $event) {
            if ($event['name'] == $name && is_callable($event['handler'])) {
                call_user_func($event['handler'], $params);
            }
        }
    }


}
