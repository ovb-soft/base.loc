<?php

namespace Run\view\sample;

class View {

    private $param, $lt;

    public function __construct(array $param)
    {
        $this->param = $param;
        $this->lt = require 'lang/ru.php';
        $this->_echo();
    }

    private function _echo()
    {
        $tpl = [
            '{ LT:TITLE }' => $this->lt['title'],
            '{ LT:SIGN_IN:UPP }' => $this->lt['sign_in:upp'],
            '{ RUN:EXT }' => $this->param['run:ext']
        ];
        echo str_replace(
                array_keys($tpl),
                array_values($tpl),
                file_get_contents(__DIR__ . '/html/tpl.php')
        );
    }

}
