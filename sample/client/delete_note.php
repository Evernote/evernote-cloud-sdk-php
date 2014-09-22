<?php
require __DIR__ . '/../../vendor/autoload.php';

//prod token
$token = '%YOUR_TOKEN%';

//set this to false to use in production
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
