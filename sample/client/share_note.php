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

$client->shareNote($uploaded_note);