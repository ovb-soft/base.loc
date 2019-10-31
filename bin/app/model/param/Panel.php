<?php

namespace Run\model\param;

class Panel extends \Run\model\panel\access\User {

    protected
            $path,
            $class;

    public function __construct($param)
    {
        $this->path = implode('\\', $param['exp']);
        $this->class = mb_convert_case(end($param['exp']), MB_CASE_TITLE);
        $lang = new \Run\model\panel\corporate\Lang();
        $param['lang'] = $lang->lang;
        $param['multilang'] = $lang->multilang;
        parent::__construct($this->_error($param));
    }

    private function _error($param)
    {
        $this->error = false;
        $module = str_replace('\\', '/', $this->path) . '/' . $this->class;
        $file = dirname(__DIR__, 2) . '/model/panel/module/' . $module . '.php';
        if ($param['error'] ? $param['error'] : !file_exists($file)) {
            $this->error = true;
            $param['error'] = '404';
        }
        return $param;
    }

}
