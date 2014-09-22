<?php
require __DIR__ . '/../../vendor/autoload.php';

//prod token
$token = '%YOUR_TOKEN%';

//set this to false to use in production
$sandbox = true;

$client = new \Evernote\Client($token, $sandbox);

$note         = new \Evernote\Model\Note();
$note->title  = 'Test note';
$note->content = new \Evernote\Model\PlainTextNoteContent('Some plain text content.');

/**
 * The second parameter $notebook is optionnal.
 * If left blank or set as null, the note will be created in the default notebook
 * Or in the App Notebook if applicable.
 *
 * Otherwise, you need to pass a \Evernote\Model\Notebook object
 * There are 2 options :
 *
 * If you already have a Notebook object (from the listNotebooks method for example)
 * just pass it as is to the method.
 *
 * If you only have a notebookGuid, instantiate an empty notebook and set the guid :
 *
 * $notebook = new \Evernote\Model\Notebook();
 * $notebook->guid = $notebook_guid;
 *
 * The notebook will be automatically retrieved if necessary
 */

$notebook = null;
$client->uploadNote($note, $notebook);