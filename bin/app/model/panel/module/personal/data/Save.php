<?php

namespace Run\model\panel\module\personal\data;

class Save extends \Run\model\panel\Main {

    private $ext,
            $lang;
    protected
            $mail,
            $mail_wg,
            $user,
            $user_wg,
            $data;

    public function __construct($param)
    {
        parent::__construct($this->_param($param));
    }

    private function _param($param)
    {
        $this->ext = $param['ext'];
        $this->lang = $param['lang'];
        return $param;
    }

    protected function post()
    {
        $this->data = new \Run\model\panel\corporate\user\User($this->lang);
    }

    protected function save()
    {
        $this->user = str_replace(' ', '.', $this->user);
        $this->data->input['user'] = str_replace(' ', '.', $this->data->input['user']);
        $this->mail === $this->data->input['mail'] ?: $this->_save_mail();
        $this->user === $this->data->input['user'] ?: $this->_save_user();
        $this->_cookie();
    }

    private function _save_mail()
    {
        $file = $this->data->dir['user'] . $this->user . '/data.sz';
        $data = unserialize(file_get_contents($file));
        $data['mail'] = $this->data->input['mail'];
        if (file_put_contents($file, serialize($data)) === false) {
            exit('Failed to write data to file: ~/user/' . $this->user . '/data.sz.');
        }
        if (rename($this->data->dir['mail'] . $this->mail, $this->data->dir['mail'] . $this->data->input['mail']) === false) {
            exit('Failed to rename file: ~/mail/' . $this->mail);
        }
    }

    private function _save_user()
    {
        $file = $this->data->dir['mail'] . $this->data->input['mail'] . '/user.sz';
        $data = [
            'user' => $this->data->input['user'],
            'path' => $this->data->dir['user'] . $this->data->input['user'] . '/'
        ];
        if (file_put_contents($file, serialize($data)) === false) {
            exit('Failed to write data to file: ~/mail/' . $this->data->input['mail'] . '/user.sz.');
        }
        if (rename($this->data->dir['user'] . $this->user, $this->data->dir['user'] . $this->data->input['user']) === false) {
            exit('Failed to rename file:' . $this->data->dir['user'] . $user);
        }
    }

    private function _cookie()
    {
        setcookie('panel:user', $this->data->input['user'], 0, '/');
        $this->_header();
    }

    private function _header()
    {
        header('Location: /personal' . $this->ext);
    }

}
