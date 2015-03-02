Migrating from Evernote SDK for PHP 1.x
=======================================

Oauth
-----

The OAuth process has been entirely rewritten in order to remove the dependency on the php-oauth extension.

However you'll still need the curl extension and sessions enabled in order to make it work.

Both are installed and configured by default on most server hosts.

The code to get an oauth token is pretty straightforward :

```php
<?php
require 'vendor/autoload.php';

//set this to false to use in production
$sandbox = true;

$oauth_handler = new \Evernote\Auth\OauthHandler($sandbox);

$key      = '%key%';
$secret   = '%secret%';
$callback = 'http://host/pathto/evernote-cloud-sdk-php/sample/oauth/index.php';

$oauth_data  = $oauth_handler->authorize($key, $secret, $callback);

$oauth_token = $oauth_data['oauth_token'];
```

Client
------

The "advanced" client is mostly the same as the client of the old SDK.

The only difference is the constructor which now takes 2 params : the token and a boolean that indicates the environment you want to work on.

``` php
<?php

require_once 'vendor/autoload.php';

$token = '%oauth_token%';

$sandbox = true;

$advancedClient = new \Evernote\AdvancedClient($token, $sandbox);
```

You can now use the "advanced" client as the old client :

``` php
<?php

require_once 'vendor/autoload.php';

$token = '%oauth_token%';

$sandbox = true;

$advancedClient = new \Evernote\AdvancedClient($token, $sandbox);
```