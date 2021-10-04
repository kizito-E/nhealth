<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Класс обработки событий.
 * Сделан на выворот. По другому было нельзя.
 * Метод "Event::trigger()" добавляет событие в массив событий.
 * Метод "Event::on()" обрабатывает событие
 * Все обработчики должны находится в классе "libraries/Event_handlers.php"
 * Метод "handle()" класса Event_handlers срабатывает после хука "post_controller" - это гарантирует обработку всех событий,
 * обьявленных в моделях и контроллерах.
 */

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
