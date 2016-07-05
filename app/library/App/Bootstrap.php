<?php

namespace App;

class Bootstrap
{
    protected $_executables;

    public function __construct($executables)
    {
        $this->_executables = func_get_args();
    }

    public function run($app, $di, $config)
    {
        foreach ($this->_executables as $executable) {
            call_user_func_array([$executable, 'run'], [$app, $di, $config]);
        }
    }
}
