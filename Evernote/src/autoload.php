<?php

function autoload($className)
{
    $className  = ltrim($className, '\\');
    $vendor     = substr($className, 0, strpos($className, '\\'));
    $namespaces = array(
        'EDAM',
        'Thrift',
        'Evernote'
    );
    if (!in_array($vendor, $namespaces)) {
        return false;
    }

    $fileName  = '';
    $namespace = '';

    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $fileName  =  __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        $function  = strtolower($vendor) . 'Autoload';
        $fileName .= $function($className, $lastNsPos);
    }

    if (is_file($fileName)) {
        require $fileName;

        return true;
    }

    return false;
}

function edamAutoload($className, $lastNsPos)
{
    $penultimateNsPos = strrpos($className, '\\', $lastNsPos - strlen($className) - 1);
    $penultimateNs    = substr($className, $penultimateNsPos + 1, $lastNsPos - $penultimateNsPos - 1);

    if (0 === strpos(substr($className, $lastNsPos + 1), $penultimateNs)) {
        $fileName = $penultimateNs . '.php';
    } else {
        $fileName = 'Types.php';
    }

    return $fileName;
}

function evernoteAutoload($className, $lastNsPos)
{
    return genericAutoload($className, $lastNsPos);
}

function thriftAutoload($className, $lastNsPos)
{
    return genericAutoload($className, $lastNsPos);
}

function genericAutoload($className, $lastNsPos)
{
    return substr($className, $lastNsPos + 1) . '.php';;
}

spl_autoload_register('autoload');
