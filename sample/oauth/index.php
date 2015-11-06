<?php
require __DIR__ . '/../../vendor/autoload.php';

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

$oauth_handler = new \Evernote\Auth\OauthHandler($sandbox, false, $china);

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
