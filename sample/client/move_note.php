<?php
require __DIR__ . '/../../vendor/autoload.php';

/**
 * Authorization Tokens are created by either:
 * [1] OAuth workflow: https://dev.evernote.com/doc/articles/authentication.php
 * or by creating a 
 * [2] Developer Token: https://dev.evernote.com/doc/articles/authentication.php#devtoken
 */
$token = '%YOUR_TOKEN%';

/** Understanding SANDBOX vs PRODUCTION vs CHINA Environments
 *
 * The Evernote API 'Sandbox' environment -> SANDBOX.EVERNOTE.COM 
 *    - Create a sample Evernote account at https://sandbox.evernote.com
 * 
 * The Evernote API 'Production' Environment -> WWW.EVERNOTE.COM
 *    - Activate your Sandboxed API key for production access at https://dev.evernote.com/support/
 * 
 * The Evernote API 'CHINA' Environment -> APP.YINXIANG.COM
 *    - Activate your Sandboxed API key for Evernote China service access at https://dev.evernote.com/support/ 
 *      or https://dev.yinxiang.com/support/. For more information about Evernote China service, please refer 
 *      to https://dev.evernote.com/doc/articles/bootstrap.php
 *
 * For testing, set $sandbox to true; for production, set $sandbox to false and $china to false; 
 * for china service, set $sandbox to false and $china to true.
 * 
 */
$sandbox = true;
$china   = false;

$client = new \Evernote\Client($token, $sandbox, null, null, $china);

$note         = new \Evernote\Model\Note();
$note->title  = 'Move a note';
$note->content = new \Evernote\Model\PlainTextNoteContent('Some plain text content.');

$notebook = null;

$uploaded_note = $client->uploadNote($note, $notebook);

echo "\nFirst guid : " . $uploaded_note->guid;

/**
 * The second parameter $notebook is - of course - mandatory.
 *
 * You need to pass a \Evernote\Model\Notebook object
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
$notebook       = new \Evernote\Model\Notebook();
$notebook->guid = '%notebook_guid%';


/**
 * Be aware that calling this method can change the guid of the note
 * if you're moving the note from one notestore to another.
 * There is no way to update a note between different notestores, so the process
 * is to create a copy of the note is the destination notebook and delete the original note.
 * This will put the note in the trash.
 */
$moved_note = $client->moveNote($uploaded_note, $notebook);

/**
 * Get the guid of the moved note as it could have changed if the destination notebook is not in the same notestore
 */
echo "\nNew guid : " . $new_guid = $moved_note->guid;