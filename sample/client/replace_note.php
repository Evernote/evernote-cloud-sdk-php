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

$uploaded_note = $client->uploadNote($note, $notebook);

$new_note         = new \Evernote\Model\Note();
$new_note->title  = 'New note';
$new_note->content = new \Evernote\Model\PlainTextNoteContent('Some new plain text content.');

$client->replaceNote($uploaded_note, $new_note);

