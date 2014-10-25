<?php
namespace Evernote\Tests;

use Evernote\AdvancedClient;
use Evernote\Client;
use Evernote\Tests\Factory\ThriftClientFactoryMock;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var  \Evernote\Client */
    protected $client;

    protected function requires($var)
    {
        if (!array_key_exists($var, $_SERVER) || $_SERVER[$var] === '') {
            $this->markTestSkipped();
        }
    }

    public function getClient($token, $sandbox = true, $advancedClient = null)
    {
        if (null === $advancedClient) {
            $thriftClientFactory  = new ThriftClientFactoryMock($token);
            $advancedClient = new AdvancedClient($sandbox, $thriftClientFactory);
        }

        return new Client($token, $sandbox, $advancedClient);
    }

    public function test_getUser_shouldReturnAUserInstance()
    {
        $this->requires('FREE_TOKEN');
        $this->assertInstanceOf('EDAM\Types\User', $this->getClient($_SERVER['FREE_TOKEN'])->getUser());
    }

    public function test_getUser_malformedToken_shouldThrowAnException()
    {
        $this->setExpectedException('Evernote\Exception\BadDataFormatException');

        $this->getClient('foobar')->getUser();
    }

    public function test_getUser_invalidToken_shouldThrowAnException()
    {
        $this->requires('FREE_TOKEN');

        $this->setExpectedException('Evernote\Exception\InvalidAuthException');

        $this->getClient(substr($_SERVER['FREE_TOKEN'], 0, -1) . '0')->getUser();
    }

    public function test_isBusinessUser_notBusiness_shouldReturnFalse()
    {
        $this->requires('FREE_TOKEN');
        $this->assertFalse($this->getClient($_SERVER['FREE_TOKEN'])->isBusinessUser());
    }

    public function test_isBusinessUser_isBusiness_shouldReturnTrue()
    {
        $this->requires('BUSINESS_TOKEN');

        $this->assertTrue($this->getClient($_SERVER['BUSINESS_TOKEN'])->isBusinessUser());
    }

    public function test_getBusinessToken_notBusiness_shouldThrowAnException()
    {
        $this->requires('FREE_TOKEN');

        $this->setExpectedException('Evernote\Exception\PermissionDeniedException', 'Business');

        $this->getClient($_SERVER['FREE_TOKEN'])->getBusinessToken();
    }

    public function test_getBusinessToken_isBusiness_shouldReturnAString()
    {
        $this->requires('BUSINESS_TOKEN');

        $this->assertInternalType('string', $this->getClient($_SERVER['BUSINESS_TOKEN'])->getBusinessToken());
    }


}
