<?php

spl_autoload_register(function($class) {
    require __DIR__ . '/' .
            str_replace(
                    '\\', '/', (explode('\\', $class)[0] === 'Run' ? 'app/' . substr($class, 4) : 'Libs/' . $class)
            ) . '.php';
}, true);
