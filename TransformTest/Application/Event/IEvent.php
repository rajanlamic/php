<?php

namespace Application\Event;

interface IEvent
{
    /**
     * Register the events
     * 
     * @param type $event
     * @param \Application\Event\IFactory $factory
     */
    public function on($event, $factory);

    /**
     * Triger the events
     * 
     * @param type $event
     * @param type $arguments
     */
    public function trigger($event, Array $arguments);
}