<?php

namespace Run\model\panel\module\personal\password;

class Password extends \Run\model\panel\Main {

    private $ext,
            $pass = '',
            $pass_wg = '',
            $confirm = '',
            $confirm_wg = '',
            $hl = [
                'pass' => '',
                'pass_wg' => '',
                'confirm' => '',
                'confirm_wg' => ''
                    ],
            $lw,
            $wg,
            $mail,
            $file,
            $data;

    public function __construct($param)
    {
        parent::__construct($param);
        $this->ext = $param['ext'];
        !filter_has_var(0, 'post') ?: $this->_post($param['lang']);
        parent::view([
            'content' => require 'view.php'
        ]);
    }

    private function _post($lang)
    {
        $users = new \Run\model\panel\corporate\user\User($lang);
        $this->pass = $users->input['pass'];
        $this->confirm = $users->input['confirm'];
        $this->dir['mail'] = $users->dir['mail'];
        $this->dir['user'] = $users->dir['user'];
        $this->lw = $users->lw;
        $this->wg = $users->wg;
        $this->_empty();
    }

    private function _empty()
    {
        $user = filter_input(2, 'panel:user');
        $this->mail = unserialize(file_get_contents($this->dir['user'] . $user . '/data.sz'))['mail'];
        $this->file = $this->dir['mail'] . $this->mail . '/pass.sz';
        $this->data = unserialize(file_get_contents($this->file));
        $wg = '';
        if (password_verify($this->pass, $this->data['pass'])) {
            $wg = $this->lw['pass_old'];
            $this->_empty_hl();
        } elseif (!empty($this->pass) and ! preg_match("'^[a-z0-9]{4,32}$'i", $this->pass)) {
            $wg = $this->lw['pass_format'];
            $this->_empty_hl();
        } elseif (!empty($this->pass) and ! empty($this->confirm)) {
            $this->_match();
        } elseif (!empty($this->pass) and empty($this->confirm)) {
            $this->confirm_wg = str_replace('[W]', $this->lw['pass_confirm_enter'], $this->wg);
        } elseif (empty($this->pass) and ! empty($this->confirm)) {
            $wg = $this->lw['pass_new_enter'];
        }
        empty($wg) ?: $this->pass_wg = str_replace('[W]', $wg, $this->wg);
    }

    private function _match()
    {
        if ($this->pass === $this->confirm) {
            $this->_save();
        } else {
            $this->confirm = '';
            $this->confirm_wg = str_replace('[W]', $this->lw['pass_not_match'], $this->wg);
        }
    }

    private function _empty_hl()
    {
        $this->pass = '';
        $this->confirm = '';
    }

    private function _save()
    {
        $this->data['pass'] = password_hash($this->pass, PASSWORD_DEFAULT);
        if (file_put_contents($this->file, serialize($this->data)) === false) {
            exit('Failed to write data to file: ~/mail/' . $this->mail . '/pass.sz');
        }
        $this->_header();
    }

    private function _header()
    {
        header('Location: /personal' . $this->ext);
        exit;
    }

}
