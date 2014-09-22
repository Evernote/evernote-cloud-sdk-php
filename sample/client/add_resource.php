<?php
require __DIR__ . '/../../vendor/autoload.php';

//prod token
$token = '%YOUR_TOKEN%';

//set this to false to use in production
$sandbox = true;

// Instantiate a new client
$client = new \Evernote\Client($token, $sandbox);

// Create the resource
$resource = new \Evernote\Model\Resource('enlogo.png', 'image/png', 100, 100);

// Get a preformatted enml media tag (something like '<en-media type="%mime%" hash="%hash%" />')
$enml_media_tag = $resource->getEnmlMediaTag();

// Create the note
$note = new \Evernote\Model\Note();
$note->addResource($resource);
$note->title  = 'Test note';
$note->content = new \Evernote\Model\EnmlNoteContent(
    <<<ENML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE en-note SYSTEM "http://xml.evernote.com/pub/enml2.dtd">
<en-note>$enml_media_tag</en-note>
ENML
);

// Upload the note
$client->uploadNote($note);