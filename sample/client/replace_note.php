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

$uploaded_note = $client->uploadNote($note);

$new_note         = new \Evernote\Model\Note();
$new_note->title  = 'New note';
$new_note->content = new \Evernote\Model\PlainTextNoteContent('Some new plain text content.');

$client->replaceNote($uploaded_note, $new_note);

