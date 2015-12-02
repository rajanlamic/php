<?php

namespace Application;

use Application\Event\Pubsub;
use Application\Factory\Log;

class Application
{
    protected $_config;

    public function init($config)
    {
        $this->_setConfig($config);
        return $this;
    }

    protected function _setConfig($config)
    {
        $this->_config = $config;
    }

    public function getConfig()
    {
        return $this->_config;
    }

    public function run(Pubsub $Pubsub )
    {
        $Pubsub->on('startup', new Log());
        $Pubsub->trigger('startup', array('first', 'second'));
    }

}