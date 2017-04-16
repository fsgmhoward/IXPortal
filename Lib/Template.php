<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Template
{
    public static function load($template, $arguments = array())
    {
        $version = require __DIR__.'/../Include/Version.php';
        $arguments['version'] = 'V'.$version['main'].'.'.$version['sub'];
        ob_start();
        require __DIR__.'/../Templates/'.$template.'.php';
        $view = ob_get_clean();
        foreach ($arguments as $name => $value) {
            $view = str_ireplace("{{ $$name }}", $value, $view);
        }
        echo $view;
    }
}
