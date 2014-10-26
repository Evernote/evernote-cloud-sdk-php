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

$note         = new \Evernote\Model\Note();
$note->title  = 'Test note';
$note->content = new \Evernote\Model\PlainTextNoteContent('Some plain text content.');
$note->tagNames = array('tag1', 'tag2');

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