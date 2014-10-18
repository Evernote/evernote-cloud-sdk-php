<?php
require __DIR__ . '/../../vendor/autoload.php';

/**
 * Authorization Tokens are created by either:
 * [1] OAuth workflow: https://dev.evernote.com/doc/articles/authentication.php
 * or by creating a 
 * [2] Developer Token: https://dev.evernote.com/doc/articles/authentication.php#devtoken
 */
$token = '%YOUR_TOKEN%';

/** Understanding SANDBOX vs PRODUCTION Environments
 *
 * The Evernote API 'Sandbox' environment -> SANDBOX.EVERNOTE.COM 
 *    - Create a sample Evernote account at https://sandbox.evernote.com
 * 
 * The Evernote API 'Production' Environment -> WWW.EVERNOTE.COM
 *    - Activate your Sandboxed API key for production access at https://dev.evernote.com/support/
 * 
 * For testing, set $sandbox to true, for production, set $sandbox to false
 * 
 */
$sandbox = true;

$client = new \Evernote\Client($token, $sandbox);

/**
 * You need to pass a \Evernote\Model\Note object
 * There are 2 options :
 *
 * If you already have a Note object (from the getNote method for example)
 * just pass it as is to the method.
 *
 * If you only have a note guid, instantiate an empty note and set the guid :
 *
 * $note = new \Evernote\Model\Note();
 * $note->guid = 'GUID';
 *
 */

$note = new \Evernote\Model\Note();
$note->guid = 'GUID';

$client->deleteNote($note);
