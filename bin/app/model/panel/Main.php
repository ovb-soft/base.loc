<?php

namespace Run\model\panel;

class Main extends \Run\view\panel\main\View {

    private $root,
            $path;
    protected
            $le;

    public function __construct($param)
    {
        parent::__construct($this->_param($param));
        !isset($param['error']) ?: $this->_error(
                                $this->root . '/view/panel/main/lang/error/' . $param['lang'] . '.php',
                                $param['error'],
                                $this->root . '/view/panel/html/error.php'
        );
    }

    private function _param($param)
    {
        $this->root = dirname(__DIR__, 2);
        $this->path = implode('/', $param['exp']);
        $html = require $this->root . '/view/panel/html/main.php';
        $param['logo'] = $this->path === 'main' ? $html['logo'] : $html['a-logo'];
        $param['head'] = $this->_head(
                dirname(__DIR__, 4) . '/doc/panel/' . $param['exp'][0] . '.css',
                $param['exp'][0],
                $html['css']
        );
        return $this->_lang($param);
    }

    private function _head($css, $module, $html)
    {
        return ($this->path !== 'main' and file_exists($css)) ? str_replace('[M]', $module, $html) : '';
    }

    private function _lang($param)
    {
        $file = $this->root . '/model/panel/module/' . $this->path . '/lang/' . $param['lang'] . '.php';
        $lang = file_exists($file) ? require $file : [];
        !isset($lang['lp']) ?: $param['lp'] = $lang['lp'];
        !isset($lang['le']) ?: $this->le = $lang['le'];
        !isset($lang['lm']) ?: $param['menu'] = $this->_menu(
                        $lang['lm'],
                        $this->root . '/view/panel/main/html/menu.php'
        );
        return $param;
    }

    private function _menu($lang, $file)
    {
        $blank = [];
        if (isset($lang['blank'])) {
            $blank = $lang['blank'];
            unset($lang['blank']);
        }
        asort($lang);
        reset($lang);
        $li = '';
        $html = require $file;
        foreach ($lang as $k => $v) {
            $li_blank = in_array($k, $blank) ? 'li-blank' : 'li';
            $li .= str_replace(['[H]', '[A]'], [$k, $v], $html[$li_blank]);
        }
        return str_replace('[L]', $li, $html['ul']);
    }

    private function _error($file, $error, $html)
    {
        $lang = require $file;
        $this->view([
            'title' => $lang[$error]['title'],
            'content' => str_replace('[E]', $lang[$error]['content'], require $html)
        ]);
    }

}
