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