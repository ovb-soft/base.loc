<?php

namespace Run\model\panel\access;

class User extends Access {

    use \Run\model\traits\Hash;

    private $dir,
            $mail,
            $pass,
            $user,
            $hash,
            $block,
            $timer,
            $agent,
            $timestamp;

    public function __construct($param)
    {
        parent::__construct($this->_param($param));
        $this->timestamp = parent::getTimestamp();
        if (filter_has_var(0, 'login')) {
            $this->param['user'] = $this->_post();
            if (!isset($this->param['user']['wg'])) {
                header('Location: ' . $this->param['request']);
                exit;
            }
        } elseif (filter_has_var(2, 'panel:user') or filter_has_var(2, 'panel:hash')) {
            $this->param['user'] = $this->_cookie();
        }
        $this->error();
    }

    private function _param($param)
    {
        $data = unserialize(file_get_contents(dirname(__DIR__, 2) . '/data/param/panel.user.sz'));
        $this->dir['mail'] = $data['mail'];
        $this->dir['user'] = $data['user'];
        $this->block = $data['block'];
        $this->timer = $data['timer'];
        $this->agent = filter_input(5, 'HTTP_USER_AGENT');
        $param['user'] = [
            'wg' => false
        ];
        return $param;
    }

    private function _post()
    {
        $this->mail = trim(filter_input(0, 'mail'));
        $this->pass = trim(filter_input(0, 'pass'));
        if ($this->mail and $this->pass) {
            $this->dir['mail'] .= $this->mail . '/';
            return $this->_exists();
        }
        return[
            'wg' => false
        ];
    }

    private function _exists()
    {
        if (file_exists($this->dir['mail'] . 'pass.sz')) {
            return $this->_block();
        }
        return[
            'wg' => 1
        ];
    }

    private function _block()
    {
        $pass = unserialize(file_get_contents($this->dir['mail'] . 'pass.sz'));
        $time = $pass['time'];
        $pass['time'] = $this->timestamp;
        file_put_contents($this->dir['mail'] . 'pass.sz', serialize($pass));
        if ($this->timestamp - $this->block > $time) {
            return $this->_password($pass['pass']);
        }
        return[
            'wg' => 2
        ];
    }

    private function _password($pass)
    {
        if (password_verify($this->pass, $pass)) {
            $user = unserialize(file_get_contents($this->dir['mail'] . 'user.sz'));
            setcookie('panel:user', $user['user'], 0, '/');
            $this->dir['user'] = $user['path'];
            return $this->_hash();
        }
        return[
            'wg' => 1
        ];
    }

    private function _cookie()
    {
        $this->hash = filter_input(2, 'panel:hash');
        $this->user = filter_input(2, 'panel:user');
        if ($this->hash and $this->user) {
            $this->dir['user'] .= $this->user . '/';
            return $this->_timer();
        }
        return[
            'wg' => 5
        ];
    }

    private function _timer()
    {
        if (file_exists($this->dir['user'] . 'hash.sz')) {
            $hash = unserialize(file_get_contents($this->dir['user'] . 'hash.sz'));
            if (
                    $this->hash === $hash['hash'] and
                    $this->timestamp - $this->timer < $hash['time'] and
                    $this->agent === $hash['agent']) {
                return $this->_hash();
            }
            return[
                'wg' => 3
            ];
        }
        return[
            'wg' => 4
        ];
    }

    private function _hash()
    {
        $hash = $this->hash(32);
        setcookie('panel:hash', $hash, 0, '/');
        if (file_put_contents($this->dir['user'] . 'hash.sz', serialize([
                    'hash' => $hash,
                    'time' => $this->timestamp,
                    'agent' => $this->agent
                ]))) {
            $data = unserialize(file_get_contents($this->dir['user'] . 'data.sz'));
            return[
                'access' => $data['access']
            ];
        }
        return[
            'wg' => 4
        ];
    }

}
