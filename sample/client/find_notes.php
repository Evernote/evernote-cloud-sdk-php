<?php
require __DIR__ . '/../../vendor/autoload.php';

/**
 * Authorization Tokens are created by either:
 * [1] OAuth workflow: https://dev.evernote.com/doc/articles/authentication.php
 * or by creating a 
 * [2] Developer Token: https://dev.evernote.com/doc/articles/authentication.php#devtoken
 */
$token = '%TOKEN%';

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

/**
 * The search string
 */
$search = new \Evernote\Model\Search('test');

/**
 * The notebook to search in
 */
$notebook = null;

/**
 * The scope of the search
 */
$scope = \Evernote\Client::SEARCH_SCOPE_BUSINESS;

/**
 * The order of the sort
 */
$order = \Evernote\Client::SORT_ORDER_REVERSE | \Evernote\Client::SORT_ORDER_RECENTLY_CREATED;

/**
 * The number of results
 */
$maxResult = 5;

$results = $client->findNotesWithSearch($search, $notebook, $scope, $order, $maxResult);

foreach ($results as $result) {
    $noteGuid    = $result->guid;
    $noteType    = $result->type;
    $noteTitle   = $result->title;
    $noteCreated = $result->created;
    $noteUpdated = $result->updated;
}