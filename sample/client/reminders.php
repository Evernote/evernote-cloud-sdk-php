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

$client->uploadNote($note);

$datetime = new \DateTime('tomorrow');

// Check if the note "is" a reminder
var_dump($uploaded_note->isReminder());

// Set a reminder. The parameter is a timestamp in seconds.
$uploaded_note->setReminder($datetime->getTimestamp());

$client->uploadNote($uploaded_note);

var_dump($uploaded_note->isReminder());
var_dump($uploaded_note->getReminderTime());

// Check if the reminder has been set as done.
var_dump($uploaded_note->isDone());

$uploaded_note->setAsDone();

$client->uploadNote($uploaded_note);

var_dump($uploaded_note->isReminder());
var_dump($uploaded_note->getReminderDoneTime());
var_dump($uploaded_note->isDone());

// Clean the note of any reminder attributes
$uploaded_note->clearReminder();

$client->uploadNote($uploaded_note);

var_dump($uploaded_note->isReminder());
var_dump($uploaded_note->isDone());