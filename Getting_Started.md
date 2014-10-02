Installation
------------

The recommended way to install the SDK is through composer.

Just create a `composer.json` file for your project:

``` json
{
    "require": {
        "evernote/evernote-cloud-sdk-php": "@dev-master"
    }
}
```

And run these two commands to install it:

``` bash
$ curl -sS https://getcomposer.org/installer | php
$ composer install
```

Now you can add the autoloader, and you will have access to the library:

``` php
<?php

require 'vendor/autoload.php';
```

If you don't use  **Composer** , just require the provided autoloader:

``` php
<?php

require 'src/autoload.php';
```

Getting an OAuth token
----------------------

The OAuth process does not require the php-oauth extension.
The only requirement is to have sessions enabled to keep data during the oauth process.

``` php
<?php
require 'vendor/autoload.php';

//set this to false to use in production
$sandbox = true;

$oauth_handler = new \Evernote\Auth\OauthHandler($sandbox);

$key      = '%key%';
$secret   = '%secret%';
$callback = 'http://host/pathto/evernote-cloud-sdk-php/sample/oauth/index.php';

$oauth_data  = $oauth_handler->authorize($key, $secret, $callback);

echo "\nOauth Token : " . $oauth_data['oauth_token'];


Getting the client
------------------

All API calls are made with the \Evernote\Client.
Instantiate a new client object with a token and you're done.
The token can be a oauth token or a dev token.

``` php
<?php

require_once 'vendor/autoload.php';

$token = '%oauth_token%';

$client = new \Evernote\Client($token);
```

Going further
-------------

The 'sample' folder contains a few code samples to help you get started with basic features.