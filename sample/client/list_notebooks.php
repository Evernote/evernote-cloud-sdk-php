<?php
require __DIR__ . '/../../vendor/autoload.php';

//prod token
$token = '%YOUR_TOKEN%';

//set this to false to use in production
$sandbox = true;

$client = new \Evernote\Client($token, $sandbox);

$notebooks = array();

$notebooks = $client->listNotebooks();

foreach ($notebooks as $notebook) {

    echo "\n\nName : " . $notebook->name;

    echo "\nGuid : " . $notebook->guid;

    echo "\nIs Business : ";
    echo $notebook->isBusinessNotebook()?"Y":"N";

    echo "\nIs Default  : ";
    echo $notebook->isDefaultNotebook()?"Y":"N";

    echo "\nIs Linked   : ";
    echo $notebook->isLinkedNotebook()?"Y":"N";
}