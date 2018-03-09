<?php

namespace Note\Events;

class EventsEmitter
{

    /** @var array */
    private $events = [];

    /**
     * @param string $event
     * @param callable $handler
     */
    public function on($event, callable $handler)
    {
        $this->events[$event][] = $handler;
    }

    /**
     * @param string $event
     * @param array ...$args
     */
    public function emit($event, ...$args)
    {
        $events = isset($this->events[$event]) ? $this->events[$event] : [];
        $events = array_reverse($events);
        foreach ($events as $event) {
            call_user_func_array($event, $args);
        }
    }

}
