<?php

namespace Evernote\Store;

class Store
{
    protected $token;
    protected $client;

    public function __construct($token, $thriftClient)
    {
        $this->token  = $token;
        $this->client = $thriftClient;
    }

    public function __call($name, $arguments)
    {
        $method = new \ReflectionMethod($this->client, $name);
        $params = array();
        foreach ($method->getParameters() as $param) {
            $params[] = $param->name;
        }

        if (count($params) == count($arguments)) {
            return $method->invokeArgs($this->client, $arguments);
        } elseif (in_array('authenticationToken', $params)) {
            $newArgs = array();
            foreach ($method->getParameters() as $idx=>$param) {
                if ($param->name == 'authenticationToken') {
                    $newArgs[] = $this->token;
                }
                if ($idx < count($arguments)) {
                    $newArgs[] = $arguments[$idx];
                }
            }

            return $method->invokeArgs($this->client, $newArgs);
        } else {
            return $method->invokeArgs($this->client, $arguments);
        }
    }
}
