<?php
/*
 * IX Framework - A Simple MVC Framework
 * Developed by Howard Liu <howard@ixnet.work>, License under MIT
 */

$exception = array(
    0 => 'ERR_UNDEFINED',
    // Database Exception
    1 => 'ERR_DB_CONN',
    2 => 'ERR_DB_QUERY',
    3 => 'ERR_DB_SELECT',
    // Input Exception
    11 => 'ERR_INVALID_INPUT',
    // Authentication Exception
    21 => 'ERR_MISSING_TOKEN',
    22 => 'ERR_INVALID_TOKEN',
    // Internal Exception
    31 => 'ERR_INVALID_PASSCODE',
    32 => 'ERR_INVALID_REFERRER',
    33 => 'ERR_INVALID_ROUTE',
    34 => 'ERR_CLASS_NOT_FOUND',
    35 => 'ERR_INVALID_CONFIG_INDEX'
    // Add your exception reference code below

);

function throwException($name, $additionalString = '')
{
    global $exception;
    if ($errorNo = array_search($name, $exception)) {
        // TODO: A translated string can be thrown instead of the error name
        throw new Exception($name.($additionalString ? (': '.$additionalString) : ''), $errorNo);
    } else {
        throwException('ERR_UNDEFINED');
    }
}
