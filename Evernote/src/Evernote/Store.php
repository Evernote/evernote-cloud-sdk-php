<?php

namespace Evernote;

use EDAM\UserStore\Constant;
use Thrift\Transport\THttpClient;
use Thrift\Protocol\TBinaryProtocol;
use EDAM\NoteStore\NoteStoreClient;
use EDAM\UserStore\UserStoreClient;

class Store
{
    private $token;
    private $userAgentId = '';
    private $client;

    public function __construct($token, $clientClass, $storeUrl)
    {
        $this->token = $token;
        if (preg_match(':A=(.+):', $token, $matches)) {
            $this->userAgentId = $matches[1];
        }
        $this->client = $this->getThriftClient($clientClass, $storeUrl);
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

    protected function getThriftClient($clientClass, $url)
    {
        $parts = parse_url($url);
        if (!isset($parts['port'])) {
            if ($parts['scheme'] === 'https') {
                $parts['port'] = 443;
            } else {
                $parts['port'] = 80;
            }
        }

        $httpClient = new THttpClient(
            $parts['host'], $parts['port'], $parts['path'], $parts['scheme']);
        $httpClient->addHeaders(
            array('User-Agent' => $this->userAgentId.' / '.$this->getSdkVersion().'; PHP / '.phpversion()));
        $thriftProtocol = new TBinaryProtocol($httpClient);

        return new $clientClass($thriftProtocol, $thriftProtocol);
    }

    protected function getSdkVersion()
    {
        $version = Constant::get('EDAM_VERSION_MAJOR')
            . '.' . Constant::get('EDAM_VERSION_MINOR');

        return $version;
    }

}
