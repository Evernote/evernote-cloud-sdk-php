<?php
namespace Evernote\Tests;

use Evernote\AdvancedClient;

class AdvancedClientTest extends \PHPUnit_Framework_TestCase
{
    public function getAdvancedClient($sandbox = true)
    {
        return new AdvancedClient($sandbox);
    }

    public function test_getEndpoint_sandboxEnv_shouldReturnTheSandboxEndpoint()
    {
        $sandbox = true;

        $advancedClient = $this->getAdvancedClient($sandbox);

        $this->assertEquals(AdvancedClient::SANDBOX_BASE_URL, $advancedClient->getEndpoint());
    }

    public function test_getEndpoint_prodEnv_shouldReturnTheSandboxEndpoint()
    {
        $sandbox = false;

        $advancedClient = $this->getAdvancedClient($sandbox);

        $this->assertEquals(AdvancedClient::PROD_BASE_URL, $advancedClient->getEndpoint());
    }

    public function test_getEndpoint_pathIsSet_shouldReturnTheEndpointWithAPath()
    {
        $sandbox = true;

        $advancedClient = $this->getAdvancedClient($sandbox);

        $path = 'foobar';

        $this->assertEquals(
            AdvancedClient::SANDBOX_BASE_URL . '/' . $path,
            $advancedClient->getEndpoint($path)
        );
    }

    public function test_getNoteStore_shouldReturnANoteStoreClientInstance()
    {
        $advancedClient = $this->getAdvancedClient();

        $noteStoreUrl = 'http://foo.com/bar';

        $noteStore = $advancedClient->getNoteStore($noteStoreUrl);

        $this->assertInstanceOf('EDAM\NoteStore\NoteStoreClient', $noteStore);
    }

    public function test_getNoteStore_noParams_shouldReturnANoteStoreClientInstance()
    {
        $advancedClient = $this->getAdvancedClient();

        $noteStore = $advancedClient->getNoteStore();

        $this->assertInstanceOf('EDAM\NoteStore\NoteStoreClient', $noteStore);
    }

    public function test_getUserStore_shouldReturnAUserStoreClientInstance()
    {
        $advancedClient = $this->getAdvancedClient();

        $userStore = $advancedClient->getUserStore();

        $this->assertInstanceOf('EDAM\UserStore\UserStoreClient', $userStore);
    }
}
