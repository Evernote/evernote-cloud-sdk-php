<?php
require __DIR__ . '/../../vendor/autoload.php';

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

$oauth_handler = new \Evernote\Auth\OauthHandler($sandbox);

$key      = '%key%';
$secret   = '%secret%';
$callback = 'http://host/pathto/evernote-cloud-sdk-php/sample/oauth/index.php';

try {
    $oauth_data  = $oauth_handler->authorize($key, $secret, $callback);

    echo "\nOauth Token : " . $oauth_data['oauth_token'];

    // Now you can use this token to call the api
    $client = new \Evernote\Client($oauth_data['oauth_token']);

} catch (Evernote\Exception\AuthorizationDeniedException $e) {
    //If the user decline the authorization, an exception is thrown.
    echo "Declined";
}
