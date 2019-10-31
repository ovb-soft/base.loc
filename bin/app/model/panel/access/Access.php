<?php

namespace Run\model\panel\access;

class Access extends \DateTime {

    private $array;
    protected
            $param,
            $error,
            $access;

    public function __construct(array $param)
    {
        parent::__construct();
        $this->_param($param);
    }

    private function _param($param)
    {
        $this->access = false;
        $this->param = $param;
    }

    protected function error()
    {
        if (!$this->error) {
            $file = dirname(__DIR__, 2) . '/data/param/panel.access.sz';
            $this->array = unserialize(file_get_contents($file));
            $this->_access();
            if ($this->access) {
                $this->param['error'] = '403';
            } else {
                unset($this->param['error']);
            }
        }
    }

    private function _access()
    {
        for ($i = 0, $c = count($this->param['exp']); $i < $c; $i++) {
            $exp = $this->param['exp'][$i];
            if (isset($this->array[$exp])) {
                $this->_access_array($this->array[$exp]);
            }
            if ($this->access) {
                break;
            }
            if (isset($this->param['exp'][$i + 1])) {
                $this->array = $this->array[$exp] ?? [];
            } else {
                break;
            }
        }
    }

    private function _access_array($array)
    {
        if (isset($array['access:array'])) {
            $access = $this->param['user']['access'] ?? null;
            if (!in_array($access, $array['access:array'])) {
                $this->access = true;
            }
        }
    }

}
