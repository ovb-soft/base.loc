<?php

namespace Run\route;

class Branch extends \Run\model\param\Request {

    private $run;

    public function __construct()
    {
        parent::__construct();
        $this->run = $this->run();
        $this->run['user'] ? $this->_branch() : $this->_install();
    }

    private function _branch()
    {
        $this->request['ext'] === $this->run['ext'] ? $this->_panel() : $this->_website();
    }

    private function _panel()
    {
        new Panel($this->request);
    }

    private function _website()
    {
        new Website($this->request + [
            'run:ext' => $this->run['ext']
        ]);
    }

    private function _install()
    {
        new \Run\model\data\install\User($this->request['request']);
    }

}
