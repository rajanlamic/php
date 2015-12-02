<?php

namespace Application\Event;

use Application\Event\IEvent;

class Pubsub implements IEvent {

    protected $_storage = array();

    /**
     * Subsrcibe if event is string and factory is object
     * 
     * @param String $event
     * @param Object $factory
     */
    public function on($event, $factory) {
        if (is_string($event) && is_object($factory)) {
            $this->_storage[$event] = $factory;
        }
    }

    /**
     * Trigger the subscribed event if event is string and either argument is array or not present
     * 
     * @param String $event
     * @param type $arguments
     */
    public function trigger($event, Array $arguments = array()) {
        if (is_string($event) && (is_array($arguments) || !$arguments)) {
            $registeredEevents = $this->_storage;
            $len = count($this->_storage);

            if ($len > 0) {
                $this->_runFactory($event, $registeredEevents, $arguments);
            }
        }
    }

    /**
     * Run factory if all condition met for trigger
     * 
     * @param Array $registeredEevents
     * @param Array $arguments
     * @return call factory
     */
    protected function _runFactory($event, $registeredEevents, array $arguments = array()) {
        foreach ($registeredEevents as $name => $factory) {
            if ($name === $event) {
                call_user_func_array(array($factory, "run"), $arguments);
                return;
            }
        }
    }

}
