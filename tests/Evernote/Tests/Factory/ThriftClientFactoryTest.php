<?php

namespace Evernote\Tests\Factory;

use Evernote\Factory\ThriftClientFactory;

class ThriftClientFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ThriftClientFactory */
    protected $factory;

    protected function setUp()
    {
        $this->factory = new ThriftClientFactory();
    }

    public function test_createThriftClient_noteType_shouldReturnANoteStoreClient()
    {
        $thriftClient = $this->factory->createThriftClient('note', 'https://notestore.url/foo/bar');
        $this->assertInstanceOf('EDAM\NoteStore\NoteStoreClient', $thriftClient);
    }

    public function test_createThriftClient_userType_shouldReturnAUserStoreClient()
    {
        $thriftClient = $this->factory->createThriftClient('user', 'https://userstore.url/foo/bar');
        $this->assertInstanceOf('EDAM\UserStore\UserStoreClient', $thriftClient);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBadType()
    {
        $this->factory->createThriftClient('foo', 'https://store.url/foo/bar');
    }
} 