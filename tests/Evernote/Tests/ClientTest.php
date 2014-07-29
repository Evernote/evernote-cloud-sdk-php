<?php
namespace Evernote\Tests;

use Evernote\AdvancedClient;
use Evernote\Client;

use Evernote\Factory\ThriftClientFactory;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    protected $client;

    public function setUp()
    {
        $token = 'S=s1:U=8f168:E=14ed02ef6b4:C=147787dc858:P=1cd:A=en-devtoken:V=2:H=704b4637b3788d9ae53f8ad94f2b43db';
        $thriftClientFactory  = new ThriftClientFactoryMock($token);
        $advancedClient = new AdvancedClient(true, $thriftClientFactory);


        $this->client = new Client($token, true, $advancedClient);
    }

    public function test_listNotebooks()
    {

        $notebooks = $this->client->listNotebooks();

        $this->assertInternalType('array', $notebooks);

        $this->assertCount(11, $notebooks);

        /**
         * 'guid' => array(isShared, isLinked, isBusiness, isPublic, isDefault)
         */
        $expected = array(
            '3b2cd01f-6e87-42b1-a86c-fffc5f291bb0' => array(false, false, false, false),
            '0ffd1dae-ecdb-442b-9ef9-3da7271f35d5' => array(false, false, false, false),
            '2192fc7a-eabd-413f-818e-bc08361114d3' => array(false, false, false, false),
            '87fef3d9-a5c2-4454-9c92-8c049e865d6f' => array(false, false, false, true),
            'bc1e4149-6550-417f-a3d1-b62c31c9bf77' => array(false, false, false, true),
            'd6db5430-62cb-4b50-8d5d-49ba531f87b5' => array(true, false, false, false),
            '04641fdd-b978-4654-bbaf-c9ed84b0b2a5' => array(true, false, false, false),
            'c457f328-d7fe-4017-9149-cd905aedc75d' => array(false, true, false, false),
            '31213ba9-dbc5-476d-b777-e478e4f3fcd9' => array(false, true, false, false),
            '5c978a9c-9c96-4989-8029-a55ac0bbe212' => array(false, true, true, false),
            'd8a20636-5d17-4615-b2f2-5f868dabe6fa' => array(true, true, true, false),
        );

        foreach ($notebooks as $notebook) {
            $this->assertInstanceOf('\Evernote\Model\Notebook', $notebook);
            $guid = $notebook->getGuid();
            $this->assertEquals($expected[$guid][0], $notebook->isShared);
            $this->assertEquals($expected[$guid][1], $notebook->isLinkedNotebook());
            $this->assertEquals($expected[$guid][2], $notebook->isBusinessNotebook());
        }
    }
/*
    public function test_listPersonnalNotebooks_()
    {
        $notebooks = $this->client->listPersonalNotebooks();

        $this->assertInternalType('array', $notebooks);

        foreach ($notebooks as $notebook) {
            $this->assertInstanceOf('\EDAM\Types\Notebook', $notebook);
        }

    }

    public function test_listSharedNotebooks_()
    {
        $notebooks = $this->client->listSharedNotebooks();

        $this->assertInternalType('array', $notebooks);

        foreach ($notebooks as $notebook) {
            $this->assertInstanceOf('\EDAM\Types\SharedNotebook', $notebook);
        }

    }

    public function test_listLinkedNotebooks_()
    {
        $notebooks = $this->client->listLinkedNotebooks();

        $this->assertInternalType('array', $notebooks);

        foreach ($notebooks as $notebook) {
            $this->assertInstanceOf('\EDAM\Types\LinkedNotebook', $notebook);
        }

    }
*/
}

class ThriftClientFactoryMock
{
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function createThriftClient($type, $url)
    {
        return new ThriftClient($type, $url, $this->token);
    }
}

class ThriftClient
{
    protected $type;
    protected $url;
    protected $token;

    public function __construct($type, $url, $token)
    {
        $this->type  = $type;
        $this->url   = $url;
        $this->token = $token;
    }

    public function __call($name, $args)
    {
        $file = __DIR__ . '/' . $this->type . sha1($this->token . $this->url . $name . implode('', $args));

//        $file = sprintf('%s/%s/%s', realpath(__DIR__ . '/../../'), $this->cacheDir, sha1($url));

        if (is_file($file) && is_readable($file)) {
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
