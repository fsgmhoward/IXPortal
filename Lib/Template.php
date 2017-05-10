<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

namespace Lib;

class Template
{
    public static function load($template, $arguments = array(), $renderOnly = false)
    {
        $version = require __DIR__.'/../Include/Version.php';
        $arguments['version'] = 'V'.$version['main'].'.'.$version['sub'];
        ob_start();
        if (file_exists(__DIR__.'/../Templates/'.$template.'.php')) {
            include __DIR__.'/../Templates/'.$template.'.php';
        } else {
            throwException('ERR_TEMPLATE_NOT_FOUND');
        }
        $view = ob_get_clean();
        foreach ($arguments as $name => $value) {
            $view = str_ireplace("{{ $$name }}", $value, $view);
        }
        if ($renderOnly) {
            return $view;
        } else {
            echo $view;
        }
    }

    public static function isActive($action, $activeOnly = false) {
        if (strpos(Route::$currentAction, $action) === 0) {
            echo $activeOnly ? 'active' : 'class="active"';
        }
    }

    public static function rewrite($url, $extraParameter = '', $domain = '', $noEcho = false) {
        $domain = $domain ? $domain.'/' : Config::get('domain').'/';
        $return = Config::get('rewrite') ?
            $domain.$url.($extraParameter ? '?'.$extraParameter : '') :
            $domain.'?action='.str_replace('?', '&', $url).($extraParameter ? '&'.$extraParameter : '');
        if ($noEcho) {
            return $return;
        } else {
            echo $return;
        }
    }

    public static function printMsg($addClass = '', $levels = ['info', 'success', 'warning', 'danger']) {
        foreach ($levels as $level) {
            if (isset($_REQUEST[$level])) {
                echo '<div class="callout callout-'.$level.' '.$addClass.'"><p>'.$_REQUEST[$level].'</p></div>';
            }
        }
    }
}
