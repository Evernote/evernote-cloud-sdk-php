<?php

namespace Evernote\Factory;

use Thrift\Transport\THttpClient;
use Thrift\Protocol\TBinaryProtocol;

class ThriftClientFactory
{
    protected $typeList;

    public function __construct()
    {
        $this->typeList = array('user', 'note');
    }

    public function createThriftClient($type, $url)
    {
        if (!in_array($type, $this->typeList)) {
            throw new \InvalidArgumentException("$type is not a valid client type.");
        }

        $store = ucfirst($type) . 'Store';

        $clientClass = '\EDAM\\' . $store . '\\' . $store . 'Client';

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

        $thriftProtocol = new TBinaryProtocol($httpClient);

        return new $clientClass($thriftProtocol, $thriftProtocol);
    }
}