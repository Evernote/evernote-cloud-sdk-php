<?php

namespace Evernote\Store;

use Evernote\Factory\ThriftClientFactory;

class Store
{
    /** @var \Evernote\Factory\ThriftClientFactory  */
    protected $thriftClientFactory;
    protected $token;
    protected $type;
    protected $url;

    public function __construct($thriftClientFactory, $token, $type, $url)
    {
        $this->thriftClientFactory = $thriftClientFactory;
        $this->token               = $token;
        $this->type                = $type;
        $this->url                 = $url;
    }

    public function __call($name, $arguments)
    {
        $store = ucfirst($this->type) . 'Store';

        $clientClass = '\EDAM\\' . $store . '\\' . $store . 'Client';

        $method = new \ReflectionMethod($clientClass, $name);
        $params = array();
        foreach ($method->getParameters() as $param) {
            $params[] = $param->name;
        }

        $client = $this->getThriftClient();

        if (count($params) == count($arguments)) {
            return call_user_func_array(array($client, $name), $arguments);
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

            return call_user_func_array(array($client, $name), $newArgs);
        } else {
            return call_user_func_array(array($client, $name), $arguments);
        }
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @param $type
     * @param $url
     * @return mixed
     */
    protected function getThriftClient()
    {
        return $this->getThriftClientFactory()->createThriftClient($this->type, $this->url);
    }

    /**
     * @return ThriftClientFactory
     */
    public function getThriftClientFactory()
    {
        if (null === $this->thriftClientFactory) {
            $this->thriftClientFactory = new ThriftClientFactory();
        }

        return $this->thriftClientFactory;
    }

}
