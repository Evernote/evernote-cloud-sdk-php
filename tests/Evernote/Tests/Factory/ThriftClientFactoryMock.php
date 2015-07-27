<?php

namespace Evernote\Tests\Factory;

use Evernote\Factory\ThriftClientFactory;

class ThriftClientFactoryMock
{
    protected $token;
    protected $tokenType;
    protected $useFixtures;

    public function __construct($token, $token_type, $useFixtures = true)
    {
        $this->token       = $token;
        $this->tokenType   = $token_type;
        $this->useFixtures = $useFixtures;
    }

    public function createThriftClient($type, $url)
    {
        return new ThriftClient($type, $url, $this->token, $this->tokenType, $this->useFixtures);
    }
}

class ThriftClient
{
    protected $type;
    protected $url;
    protected $token;
    protected $tokenType;
    protected $useFixtures;

    public function __construct($type, $url, $token, $token_type, $useFixtures)
    {
        $this->type        = $type;
        $this->url         = $url;
        $this->token       = $token;
        $this->tokenType   = $token_type;
        $this->useFixtures = $useFixtures;
    }

    public function __call($name, $args)
    {
        $file = $this->generateFixtureFilename($name, $args);

        if ($this->useFixtures && is_file($file) && is_readable($file)) {
            $response = unserialize(file_get_contents($file));

            if (!empty($response)) {
                if ($response instanceof \Exception) {
                    throw $response;
                }

                return $response;
            }
        }

        $realThriftClientFactory = new ThriftClientFactory();
        $client = $realThriftClientFactory->createThriftClient($this->type, $this->url);

        try {
            $response = call_user_func_array(array($client, $name), $args);
            file_put_contents($file, serialize($response));
        } catch (\Exception $e) {
            file_put_contents($file, serialize($e));
            throw $e;
        }

        return $response;
    }

    private function generateFixtureFilename($name, $args)
    {
        $store = ucfirst($this->type) . 'Store';

        $clientClass = '\EDAM\\' . $store . '\\' . $store . 'Client';

        $method = new \ReflectionMethod($clientClass, $name);
        foreach ($method->getParameters() as $param) {
            if ('authenticationToken' === $param->getName()) {
                $idx = $param->getPosition();
                $args[$idx] = $this->tokenType;
                break;
            }
        }

        return __DIR__ . '/../../../fixtures/' . $this->type . '/'
            . $name . '_' . $this->tokenType . '_'
            . sha1(str_replace($this->token, $this->tokenType, implode('', $args)));
    }
}