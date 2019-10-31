<?php

namespace Run\route;

class Panel extends \Run\model\param\Panel {

    public function __construct($param)
    {
        parent::__construct($param);
        $this->path === 'logout' ? $this->_logout() : $this->_login();
    }

    private function _logout()
    {
        setcookie('panel:hash', '', 0, '/');
        setcookie('panel:user', '', 0, '/');
        header('Location: /');
    }

    private function _login()
    {
        isset($this->param['user']['wg']) ? new \Run\view\panel\login\View($this->param) : $this->_404();
    }

    private function _404()
    {
        $this->error ? new \Run\model\panel\Main($this->param) : $this->_403();
    }

    private function _403()
    {
        $this->access ? new \Run\model\panel\Main($this->param) : $this->_module();
    }

    private function _module()
    {
        $module = '\\Run\\model\\panel\\module\\' . $this->path . '\\' . $this->class;
        new $module($this->param);
    }

}
