<?php

class Pubsub {

    protected $_storage = array();

    /**
     * Subsrcibe if event is string and factory is object
     * 
     * @param String $event
     * @param Object $factory
     * @param String $method
     */
    public function on($event, $factory, $method) {
        if (is_string($event) && is_object($factory)) {
            $this->_storage[$event] = array($factory, $method);
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
                call_user_func_array(array($registeredEevents[$event][0], $registeredEevents[$event][1]), $arguments);
            }
        }
    }

}
