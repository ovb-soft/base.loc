<?php

namespace Run\model\data\install;

class User extends \Run\view\panel\install\View {

    private $dir,
            $lw,
            $wg,
            $check = [
                'input' => [
                    'mail',
                    'user',
                    'pass',
                    'confirm'
                ],
                'warning' => [
                    'mail_wg',
                    'user_wg',
                    'pass_wg',
                    'confirm_wg'
                ]
    ];

    public function __construct(string $request)
    {
        if ($request === '/') {
            parent::__construct($this->_param(['request' => $request]));
            (
                    $this->mail or
                    $this->user or
                    $this->pass or
                    $this->confirm
                    ) ? $this->_mail() : $this->_check();
        } else {
            header('Location: /');
            exit;
        }
    }

    private function _param($param)
    {
        $lang = new \Run\model\panel\corporate\Lang;
        $param['lang'] = $lang->lang;
        $param['multilang'] = $lang->multilang;
        $users = new \Run\model\panel\corporate\user\User($param['lang']);
        $this->mail = $users->input['mail'];
        $this->user = $users->input['user'];
        $this->pass = $users->input['pass'];
        $this->confirm = $users->input['confirm'];
        $panel = dirname(__DIR__) . '/panel/';
        $this->dir['mail'] = $panel . 'mail/';
        $this->dir['user'] = $panel . 'user/';
        $this->lw = $users->lw;
        $this->wg = $users->wg;
        return $param;
    }

    private function _mail()
    {
        $wg = '';
        if (empty($this->mail)) {
            $wg = $this->lw['mail_enter'];
        } elseif (strpos($this->mail, ' ') !== false) {
            $wg = $this->lw['mail_emptyh'];
        } elseif (!preg_match("'.+@.+\..+'i", $this->mail)) {
            $wg = $this->lw['mail_format'];
        } elseif (strlen($this->mail) > 255) {
            $wg = $this->lw['mail_length'];
        } elseif (file_exists($this->dir['mail'] . $this->mail)) {
            $wg = $this->lw['mail_exists'];
        }
        empty($wg) ?: $this->mail_wg = str_replace('[W]', $wg, $this->wg);
        $this->_user();
    }

    private function _user()
    {
        $wg = '';
        if (empty($this->user)) {
            $wg = $this->lw['user_enter'];
        } elseif (!preg_match("'^[a-z0-9\-_ ]{2,32}$'i", $this->user)) {
            $wg = $this->lw['user_format'];
        } elseif (file_exists($this->dir['user'] . $this->user)) {
            $wg = $this->lw['user_exists'];
        }
        empty($wg) ?: $this->user_wg = str_replace('[W]', $wg, $this->wg);
        $this->_pass();
    }

    private function _pass()
    {
        $wg = '';
        if (empty($this->pass)) {
            $wg = $this->lw['pass_enter'];
        } elseif (!preg_match("'^[a-z0-9]{4,32}$'i", $this->pass)) {
            $wg = $this->lw['pass_format'];
        }
        empty($wg) ?: $this->pass_wg = str_replace('[W]', $wg, $this->wg);
        $this->_confirm();
    }

    private function _confirm()
    {
        $wg = '';
        if (empty($this->confirm)) {
            $wg = $this->lw['pass_confirm_enter'];
        } elseif ($this->pass !== $this->confirm) {
            $this->confirm = '';
            $wg = $this->lw['pass_not_match'];
        }
        empty($wg) ?: $this->confirm_wg = str_replace('[W]', $wg, $this->wg);
        $this->_check();
    }

    private function _check()
    {
        $hl = true;
        foreach ($this->check['input'] as $v) {
            !empty($this->$v) ?: $hl = false;
        }
        $wg = true;
        foreach ($this->check['warning'] as $v) {
            empty($this->$v) ?: $wg = false;
        }
        if ($hl and $wg) {
            new Save([
                'mail' => $this->mail,
                'user' => $this->user,
                'pass' => $this->pass
            ]);
            exit;
        } else {
            $this->view();
        }
    }

}
