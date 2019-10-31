<?php

namespace Run\model\panel\module\personal\data;

class Data extends Save {

    public function __construct($param)
    {
        parent::__construct($param);
        $this->_view();
        parent::view([
            'content' => require 'view.php'
        ]);
    }

    private function _view()
    {
        $user = filter_input(2, 'panel:user');
        $data = dirname(__DIR__, 4) . '/data/panel/user/' . $user . '/data.sz';
        $this->mail = unserialize(file_get_contents($data))['mail'];
        $this->mail_wg = '';
        $this->user = str_replace('.', ' ', $user);
        $this->user_wg = '';
        !filter_has_var(0, 'post') ?: $this->_post();
    }

    private function _post()
    {
        parent::post();
        if ($this->mail !== $this->data->input['mail'] or $this->user !== $this->data->input['user']) {
            (empty($this->mail) and empty($this->user)) ?: $this->_mail();
        }
    }

    private function _mail()
    {
        $wg = '';
        if ($this->mail !== $this->data->input['mail']) {
            if (empty($this->data->input['mail'])) {
                $wg = $this->data->lw['mail_enter'];
            } elseif (strpos($this->data->input['mail'], ' ') !== false) {
                $wg = $this->data->lw['mail_emptyh'];
            } elseif (!preg_match("'.+@.+\..+'i", $this->data->input['mail'])) {
                $wg = $this->data->lw['mail_format'];
            } elseif (strlen($this->data->input['mail']) > 255) {
                $wg = $this->data->lw['mail_length'];
            } elseif (file_exists($this->data->dir['mail'] . $this->data->input['mail'])) {
                $wg = $this->data->lw['mail_exists'];
            }
        }
        empty($wg) ?: $this->mail_wg = str_replace('[W]', $wg, $this->data->wg);
        $this->_user();
    }

    private function _user()
    {
        $wg = '';
        if ($this->user !== $this->data->input['user']) {
            if (empty($this->user)) {
                $wg = $this->data->lw['user_enter'];
            } elseif (!preg_match("'^[a-z0-9\-_ ]{2,32}$'i", $this->data->input['user'])) {
                $wg = $this->data->lw['user_format'];
            } elseif (file_exists($this->data->dir['user'] . $this->data->input['user'])) {
                $wg = $this->data->lw['user_exists'];
            }
        }
        empty($wg) ?: $this->user_wg = str_replace('[W]', $wg, $this->data->wg);
        $this->_save();
    }

    private function _save()
    {
        $mail = (!empty($this->mail) and empty($this->mail_wg));
        $user = (!empty($this->user) and empty($this->user_wg));
        if ($mail and $user) {
            $this->save();
        } else {
            $this->mail = $this->data->input['mail'];
            $this->user = $this->data->input['user'];
        }
    }

}
