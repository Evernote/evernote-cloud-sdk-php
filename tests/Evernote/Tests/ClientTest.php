<?php
namespace Evernote\Tests;

use Evernote\AdvancedClient;
use Evernote\Client;
use Evernote\Tests\Factory\ThriftClientFactoryMock;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    const REGULAR_USER_TOKEN   = 'REGULAR_USER_TOKEN';
    const BUSINESS_USER_TOKEN  = 'BUSINESS_USER_TOKEN';
    const BUSINESS_ADMIN_TOKEN = 'BUSINESS_ADMIN_TOKEN';

    /** @var  \Evernote\Client */
    protected $client;

    protected function requires($var)
    {
        if (!array_key_exists($var, $_SERVER) || $_SERVER[$var] === '') {
            $this->markTestSkipped();
        }

        return $_SERVER[$var];
    }

    public function getClient($token, $token_type, $sandbox = true)
    {
        $advancedClient = new AdvancedClient($token, $sandbox, new ThriftClientFactoryMock($token, $token_type, true));
        return new Client($token, $sandbox, $advancedClient);
    }

    public function test_listNotebooks_regularUser_shouldReturnAllKindsOfNotebooks()
    {
        $notebooks = $this->getClient($this->requires(self::REGULAR_USER_TOKEN), self::REGULAR_USER_TOKEN)->listNotebooks();

        $this->assertInternalType('array', $notebooks);
        $this->assertContainsOnlyInstancesOf('\Evernote\Model\Notebook', $notebooks);
        $expected = <<<EOF

User created not shared not published
INBOX
User created and shared
User created and published
User created, shared and published
Shared with user (All permissions)
EOF;

        $actual = "";
        array_walk($notebooks, function($value) use (&$actual) {$actual .= "\n" . $value->name;});

        $this->assertEquals($expected, $actual);
    }

    public function test_listNotebooks_businessUser_shouldReturnAllKindsOfNotebooks()
    {
        $notebooks = $this->getClient($this->requires(self::BUSINESS_USER_TOKEN), self::BUSINESS_USER_TOKEN)->listNotebooks();

        $this->assertInternalType('array', $notebooks);
        $this->assertContainsOnlyInstancesOf('\Evernote\Model\Notebook', $notebooks);
        $expected = <<<EOF

INBOX
Personal shared but not published
Personal published but not shared
Personal shared and published
Business private
Business shared with user
Business shared but not published
Business published but not shared
Business shared and published
User created and shared
EOF;

        $actual = "";
        array_walk($notebooks, function($value) use (&$actual) {$actual .= "\n" . $value->name;});

        $this->assertEquals($expected, $actual);
    }
}
