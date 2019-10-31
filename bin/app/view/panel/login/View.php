<?php

namespace Run\view\panel\login;

class View {

    private $lt,
            $wg,
            $mail,
            $warning;

    public function __construct(array $param)
    {
        $this->mail = filter_has_var(0, 'mail') ? trim(filter_input(0, 'mail')) : '';
        $this->lt = require 'lang/' . $param['lang'] . '.php';
        $this->wg = require dirname(__DIR__, 3) . '/view/panel/html/wg.php';
        $this->warning = $this->_switch($param['user']['wg']);
        $this->_view($param);
    }

    private function _switch($switch)
    {
        switch ($switch) {
            case 1: $wg = $this->lt['wg_incorrect'];
                break;
            case 2: $wg = $this->lt['wg_blocked'];
                break;
            case 3: $wg = $this->lt['wg_timeout'];
                break;
            case 4: $wg = $this->lt['wg_server'];
                break;
            case 5: $wg = $this->lt['wg_cookie'];
                break;
        }
        return isset($wg) ? str_replace('[W]', $wg, $this->wg) : '';
    }

    private function _view($param)
    {
        $view = [
            '{ LANG }' => $param['lang'],
            '{ TITLE }' => $this->lt['title'],
            '{ SIGN_OUT-UPP }' => $this->lt['sign_out-upp'],
            '{ MULTILANG }' => $param['multilang'],
            '{ ROUTE }' => $this->lt['route'],
            '{ FORM }' => require 'html/form.php',
            '{ REQUEST }' => $param['request']
        ];
        echo str_replace(
                array_keys($view),
                array_values($view),
                file_get_contents(__DIR__ . '/html/tpl.php')
        );
    }

}
