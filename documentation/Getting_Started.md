Installation
------------

The recommended way to install the SDK is through composer.

Just run these two commands to install it:

``` bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar require evernote/evernote-cloud-sdk-php dev-master
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
```

You can then instantiate the client and call the api with this token.

Getting the "simple" client
---------------------------

The "simple" client is a high-level wrapper on top of the "advanced" client (see below).
It provides helper methods that hide complex stuff such as dealing with business accounts, app notebooks, etc.

All API calls are made with the \Evernote\Client.
Instantiate a new client object with a token and you're done.
The token can be an oauth token or a dev token.

``` php
<?php

require_once 'vendor/autoload.php';

$token = '%oauth_token%';

$sandbox = true;

$client = new \Evernote\Client($token, $sandbox);
```

Getting the "advanced" client
-----------------------------

The advanced client gives you a low level access to the API. That means you can call the thrift methods directly.  See the [API Reference](https://dev.evernote.com/doc/reference/) for the list of methods available.
You can use this client for optimization reasons or to achieve more complex tasks than the ones handled by the simple client.

There are two ways to get the advanced client.

From scratch :

```php
<?php

require_once 'vendor/autoload.php';

$token = '%oauth_token%';

$sandbox = true;

$advancedClient = new \Evernote\AdvancedClient($token, $sandbox);
```

or, if you already have an instance of the simple client :

```php
<?php

require_once 'vendor/autoload.php';

$token = '%oauth_token%';

$sandbox = true;

$client = new \Evernote\Client($token, $sandbox);

$client->getNote('the-note-guid');

$advancedClient = $client->getAdvancedClient();
```

Once you have a instance of the advanced client you can, for example, call the getUser() method:

``` php
// First, get the right Store
$userStore = $advancedClient->getUserStore();

// Then do the call
$user = $userStore->getUser();
```
You may notice that we don't pass the token to the getUser() method.  It's the same with all the methods that require a token. Just omit it as it is already set on the client object.

Using the "simple" client
-------------
[Create a note](../sample/client/create_note.php)

[Delete a note](../sample/client/delete_note.php)

[Move a note](../sample/client/move_note.php)

[Share a note](../sample/client/share_note.php)

[Replace a note](../sample/client/replace_note.php)

[Add resources to a note](../sample/client/add_resource.php)

[Find notes](../sample/client/find_notes.php)

[Manage reminders](../sample/client/reminders.php)

Going further
-------------

The 'sample' folder contains a few code samples to help you get started with basic features.