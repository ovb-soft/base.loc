<?php

namespace Run\model\panel\corporate;

class Lang {

    private $langs,
            $html;
    public
            $lang,
            $multilang;

    public function __construct()
    {
        $root = dirname(__DIR__, 3);
        $this->lang = $this->_lang($root . '/model/data/param/panel.langs.sz');
        $this->multilang = $this->_multilang($root . '/view/panel/html/lang.php');
    }

    private function _lang($file)
    {
        $this->langs = unserialize(file_get_contents($file));
        $lang = $this->langs['lang'];
        if ($this->langs['multilang']) {
            return $lang;
        }
        if (filter_has_var(0, 'panel:lang')) {
            $post = filter_input(0, 'panel:lang');
            if (isset($this->langs['langs'][$post])) {
                setcookie('panel:lang', $post, strtotime('+ 1 year'), '/');
                $lang = $post;
            }
        } elseif (filter_has_var(2, 'panel:lang')) {
            $cookie = filter_input(2, 'panel:lang');
            !isset($this->langs['langs'][$cookie]) ?: $lang = $cookie;
        }
        return $lang;
    }

    private function _multilang($html)
    {
        if ($this->langs['multilang']) {
            return '';
        }
        $this->html = require $html;
        $button = '';
        foreach ($this->langs['langs'] as $k => $v) {
            if ($k !== $this->lang) {
                $button .= str_replace(
                        ['[V]', '[L]', '[B]'], [$k, $k, $v], $this->html['button']
                );
            }
        }
        return str_replace(
                ['[L]', '[B]'],
                [$this->langs['langs'][$this->lang], $this->_multilang_hidden() . $button],
                $this->html['div']
        );
    }

    private function _multilang_hidden()
    {
        $hidden = '';
        $post = filter_input_array(0);
        if ($post !== null) {
            foreach ($post as $k => $v) {
                if ($k === 'panel:lang') {
                    continue;
                }
                $hidden .= ($k === 'login' or $k === 'post') ?
                        str_replace('[N]', $k, $this->html['hidden']) :
                        str_replace(['[N]', '[V]'], [$k, $v], $this->html['hidden-value']);
            }
        }
        return $hidden;
    }

}
