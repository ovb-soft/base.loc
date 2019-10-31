<?php

namespace Run\model\data\install;

class Save extends \DateTime {

    use \Run\model\traits\Hash;

    private $dir,
            $mail,
            $user,
            $pass,
            $timestamp;

    public function __construct(array $param)
    {
        parent::__construct();
        $this->mail = $param['mail'];
        $this->user = $param['user'];
        $this->pass = $param['pass'];
        $this->timestamp = (int) parent::getTimestamp();
        $this->_panel();
    }

    private function _panel()
    {
        $panel = dirname(str_replace('\\', '/', __DIR__)) . '/panel/';
        file_exists($panel) ?: mkdir($panel);
        $this->dir['mail'] = $panel . 'mail/';
        file_exists($this->dir['mail']) ?: mkdir($this->dir['mail']);
        file_exists($this->dir['mail'] . $this->mail . '/') ?: mkdir($this->dir['mail'] . $this->mail . '/');
        $this->dir['user'] = $panel . 'user/';
        file_exists($this->dir['user']) ?: mkdir($this->dir['user']);
        file_exists($this->dir['user'] . $this->user . '/') ?: mkdir($this->dir['user'] . $this->user . '/');
        $this->_save_mail();
    }

    private function _save_mail()
    {
        file_put_contents($this->dir['mail'] . $this->mail . '/pass.sz', serialize([
            'pass' => password_hash($this->pass, PASSWORD_DEFAULT),
            'time' => $this->timestamp
        ]));
        file_put_contents($this->dir['mail'] . $this->mail . '/user.sz', serialize([
            'user' => $this->user,
            'path' => $this->dir['user'] . $this->user . '/'
        ]));
        $this->_save_user();
    }

    private function _save_user()
    {
        $hash = $this->hash(32);
        file_put_contents($this->dir['user'] . $this->user . '/data.sz', serialize([
            'created' => $this->timestamp,
            'mail' => $this->mail,
            'access' => 'root'
        ]));
        file_put_contents($this->dir['user'] . $this->user . '/hash.sz', serialize([
            'hash' => $hash,
            'time' => $this->timestamp,
            'agent' => filter_input(5, 'HTTP_USER_AGENT')
        ]));
        setcookie('panel:user', $this->user, 0, '/');
        setcookie('panel:hash', $hash, 0, '/');
        $this->_save_param();
    }

    private function _save_param()
    {
        $param = dirname(__DIR__) . '/param/';
        file_put_contents($param . 'panel.user.sz', serialize([
            'mail' => $this->dir['mail'],
            'user' => $this->dir['user'],
            'block' => 2,
            'timer' => 1800
        ]));
        $user = unserialize(file_get_contents($param . 'branch.run.sz'));
        $user['user'] = $this->user;
        file_put_contents($param . 'branch.run.sz', serialize($user));
        $this->_header($user['ext']);
    }

    private function _header($ext)
    {
        header('Location: /personal' . $ext);
    }

}
