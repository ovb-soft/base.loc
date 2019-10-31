<?php

namespace Run\model\data\install;

class Param {

    private $param;

    public function __construct()
    {
        $this->param = dirname(__DIR__) . '/param/';
        file_exists($this->param) ?: mkdir($this->param);
        $this->_branch_run();
    }

    private function _branch_run()
    {
        file_put_contents($this->param . 'branch.run.sz', serialize([
            'user' => false,
            'ext' => '.ww'
        ]));
        $this->_date_time();
    }

    private function _date_time()
    {
        file_put_contents($this->param . 'date.time.sz', serialize([
            'time_zone' => 'Europe/Moscow',
            'region' => 'europe'
        ]));
        $this->_panel_access();
    }

    private function _panel_access()
    {
        file_put_contents($this->param . 'panel.access.sz', serialize([
            'settings' => [
                'access:array' => [
                    'root'
                ]
            ]
        ]));
        $this->_panel_langs();
    }

    private function _panel_langs()
    {
        file_put_contents($this->param . 'panel.langs.sz', serialize([
            'lang' => 'ru',
            'langs' => [
                'en' => 'English',
                'ru' => 'Русский'
            ],
            'multilang' => false
        ]));
        $this->_header();
    }

    private function _header()
    {
        header('Location: /');
        exit;
    }

}
