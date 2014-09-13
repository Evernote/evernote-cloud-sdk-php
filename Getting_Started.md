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

require_once 'src/autoload.php';
```
