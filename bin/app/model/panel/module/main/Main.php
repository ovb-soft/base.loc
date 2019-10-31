<?php

namespace Run\model\panel\module\main;

class Main extends \Run\model\panel\Main {

    public function __construct($param)
    {
        parent::__construct($param);
        parent::view();
    }

}
