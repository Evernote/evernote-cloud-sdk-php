<?php

namespace Evernote\Exception;

use EDAM\Error\EDAMNotFoundException;
use EDAM\Error\EDAMSystemException;
use EDAM\Error\EDAMUserException;

class ExceptionFactory
{
    protected static $errorCodeMap = array(
        1  => 'Unknown',
        2  => 'BadDataFormat',
        3  => 'PermissionDenied',
        4  => 'InternalError',
        5  => 'DataRequired',
        6  => 'LimitReached',
        7  => 'QuotaReached',
        8  => 'InvalidAuth',
        9  => 'AuthExpired',
        10 => 'DataConflict',
        11 => 'EnmlValidation',
        12 => 'ShardUnavailable',
        13 => 'LengthTooShort',
        14 => 'LengthTooLong',
        15 => 'TooFew',
        16 => 'TooMany',
        17 => 'UnsupportedOperation',
        18 => 'TakenDown',
        19 => 'RateLimitReached'
    );

    protected static $identifierMap = array(
        'SharedNotebook.id' => 'NotFoundSharedNotebook',
        'Note.guid'         => 'NotFoundNote',
        'Note.notebookGuid' => 'NotFoundNotebook'
    );

    protected static $messageMap = array(
        'shareKey'            => 'InvalidShareKey',
        'authenticationToken' => 'InvalidAuth',
    );

    public static function create(\Exception $e)
    {
        if ($e instanceof EDAMUserException) {
            if (array_key_exists($e->errorCode, self::$errorCodeMap)) {
                $class = __NAMESPACE__ . '\\' . self::$errorCodeMap[$e->errorCode] . 'Exception';

                return new $class($e->parameter);
            }

            return $e;

        } elseif ($e instanceof EDAMNotFoundException) {
            if (array_key_exists($e->identifier, self::$identifierMap)) {
                $class = __NAMESPACE__ . '\\' . self::$identifierMap[$e->identifier] . 'Exception';

                return new $class($e->identifier . ' : ' . $e->key);
            }

            return $e;
        } elseif ($e instanceof EDAMSystemException) {
            if (array_key_exists($e->message, self::$messageMap)) {
                $class = __NAMESPACE__ . '\\' . self::$messageMap[$e->message] . 'Exception';

                return new $class($e->message);
            }

            return $e;
        }

        return $e;
    }
} 