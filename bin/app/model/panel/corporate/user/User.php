<?php

namespace Run\model\panel\corporate\user;

class User {

    public
            $input,
            $dir = [],
            $lw,
            $wg;

    public function __construct($lang)
    {
        $this->_input();
        $file = dirname(__DIR__, 3) . '/data/param/panel.user.sz';
        if (file_exists($file)) {
            $user = unserialize(file_get_contents(dirname(__DIR__, 3) . '/data/param/panel.user.sz'));
            $this->dir['mail'] = $user['mail'];
            $this->dir['user'] = $user['user'];
        }
        $this->lw = require 'lang/' . $lang . '.php';
        $this->wg = require dirname(__DIR__, 4) . '/view/panel/html/wg.php';
    }

    private function _input()
    {
        if (filter_has_var(0, 'mail')) {
            $this->input['mail'] = trim(filter_input(0, 'mail'));
        } elseif (filter_has_var(1, 'mail')) {
            $this->input['mail'] = filter_input(1, 'mail');
        }
        if (filter_has_var(0, 'user')) {
            $this->input['user'] = $this->_cut_double_space();
        } elseif (filter_has_var(1, 'user')) {
            $this->input['user'] = filter_input(1, 'user');
        }
        if (filter_has_var(0, 'pass')) {
            $this->input['pass'] = trim(filter_input(0, 'pass'));
        } elseif (filter_has_var(1, 'pass')) {
            $this->input['pass'] = filter_input(1, 'pass');
        }
        if (filter_has_var(0, 'confirm')) {
            $this->input['confirm'] = trim(filter_input(0, 'confirm'));
        } elseif (filter_has_var(1, 'confirm')) {
            $this->input['confirm'] = filter_input(1, 'confirm');
        }
    }

    private function _cut_double_space()
    {
        return preg_replace('/ +/', ' ', trim(filter_input(0, 'user')));
    }

}
