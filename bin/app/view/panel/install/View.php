<?php

namespace Run\view\panel\install;

class View {

    private $lt,
            $param;
    protected
            $mail = '',
            $user = '',
            $pass = '',
            $confirm = '',
            $mail_wg = '',
            $user_wg = '',
            $pass_wg = '',
            $confirm_wg = '';

    public function __construct($param)
    {
        $this->_param($param);
    }

    private function _param($param)
    {
        $this->lt = require 'lang/' . $param['lang'] . '.php';
        $this->param = $param;
    }

    protected function view()
    {
        $view = [
            '{ LANG }' => $this->param['lang'],
            '{ TITLE }' => $this->lt['title'],
            '{ MULTILANG }' => $this->param['multilang'],
            '{ ROUTE }' => $this->lt['route'],
            '{ FORM }' => require 'html/form.php',
            '{ REQUEST }' => $this->param['request']
        ];
        echo str_replace(
                array_keys($view),
                array_values($view),
                file_get_contents(__DIR__ . '/html/tpl.php')
        );
    }

}
