<?php

namespace Evernote\Tests\Factory;

use Evernote\Factory\ThriftClientFactory;

class ThriftClientFactoryMock
{
    protected $token;
    protected $useFixtures;

    public function __construct($token, $useFixtures = true)
    {
        $this->token       = $token;
        $this->useFixtures = $useFixtures;
    }

    public function createThriftClient($type, $url)
    {
        return new ThriftClient($type, $url, $this->token, $this->useFixtures);
    }
}

class ThriftClient
{
    protected $type;
    protected $url;
    protected $token;

    public function __construct($type, $url, $token, $useFixtures)
    {
        $this->type        = $type;
        $this->url         = $url;
        $this->token       = $token;
        $this->useFixtures = $useFixtures;
    }

    public function __call($name, $args)
    {
        $file = __DIR__ . '/../../../fixtures/' . $this->type . sha1($this->token . $this->url . $name . implode('', $args));

        echo $file;

        if ($this->useFixtures && is_file($file) && is_readable($file)) {
            $response = unserialize(file_get_contents($file));

            if (!empty($response)) {
                return $response;
            }
        }

        $realThriftClientFactory = new ThriftClientFactory();
        $client = $realThriftClientFactory->createThriftClient($this->type, $this->url);

        $response = call_user_func_array(array($client, $name), $args);

        file_put_contents($file, serialize($response));

        return $response;
    }
}