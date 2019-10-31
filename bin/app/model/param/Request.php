<?php

namespace Run\model\param;

class Request {

    private $path,
            $param;
    protected
            $request;

    public function __construct()
    {
        $this->request['request'] = urldecode(filter_input(5, 'REQUEST_URI'));
        $this->path = $this->_path();
        $this->request['error'] = $this->_error();
        $this->request['exp'] = explode('/', $this->path);
        $this->param = dirname(__DIR__) . '/data/param/';
        file_exists($this->param) ?: new \Run\model\data\install\Param;
    }

    private function _path()
    {
        $query = strrchr($this->request['request'], '?');
        $urn = $query ? substr($this->request['request'], 0, - strlen($query)) : $this->request['request'];
        $this->request['ext'] = strrchr($urn, '.');
        $path = $this->request['ext'] ? substr($urn, 1, - strlen($this->request['ext'])) : substr($urn, 1);
        return empty($path) ? false : $path;
    }

    private function _error()
    {
        return (
                preg_match('/^[\w\-\.\/\?\&\=\:\~]+$/iu', $this->request['request']) === 0 or
                preg_match('/\/\//', $this->request['request']) === 1 or
                preg_match('/[\/]$/', $this->path) === 1 or
                $this->request['ext'] and empty($this->path)
                ) ? true : false;
    }

    protected function run()
    {
        return unserialize(file_get_contents($this->param . 'branch.run.sz'));
    }

}
