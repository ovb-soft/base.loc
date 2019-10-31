<?php

namespace Run\route;

class Website {

    public function __construct($param)
    {
        new \Run\model\website\Sample($param);
    }

}
