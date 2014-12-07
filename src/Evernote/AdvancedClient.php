<?php

namespace Evernote;

use Evernote\Factory\ThriftClientFactory;
use Evernote\Store\Store;

class AdvancedClient
{
    /** @var  string */
    protected $token;

    /** @var bool */
    protected $sandbox;

    /** @var \Evernote\Factory\ThriftClientFactory  */
    protected $thriftClientFactory;

    /** @var  \EDAM\UserStore\UserStoreClient */
    protected $userStore;

    const SANDBOX_BASE_URL = 'https://sandbox.evernote.com';
    const PROD_BASE_URL    = 'https://www.evernote.com';

    /**
     * @param bool $sandbox
     * @param null $thriftClientFactory
     */
    public function __construct($token, $sandbox = true, $thriftClientFactory = null)
    {
        $this->token               = $token;
        $this->sandbox             = $sandbox;
        $this->thriftClientFactory = $thriftClientFactory;
    }

    /**
     * @return \EDAM\UserStore\UserStoreClient
     */
    public function getUserStore()
    {
        if (null === $this->userStore) {
            $this->userStore =
                new Store(
                    $this->token,
                    $this->getThriftClient('user', $this->getEndpoint('/edam/user'))
                );
        }

        return $this->userStore;
    }

    /**
     * @param $noteStoreUrl
     * @return mixed
     */
    public function getNoteStore($noteStoreUrl = null)
    {
        if (null === $noteStoreUrl) {
            $noteStoreUrl = $this->getUserStore()->getNoteStoreUrl($this->token);
        }

        return new Store(
            $this->token,
            $this->getThriftClient('note', $noteStoreUrl)
        );
    }


    public function getSharedNoteStore($linkedNotebook)
    {
        $noteStoreUrl = $linkedNotebook->noteStoreUrl;
        $noteStore = $this->getNoteStore($noteStoreUrl);
        $sharedAuth = $noteStore->authenticateToSharedNotebook($linkedNotebook->shareKey);
        $sharedToken = $sharedAuth->authenticationToken;

        return new Store(
            $sharedToken,
            $this->getThriftClient('note', $noteStoreUrl)
        );
    }

    public function getBusinessNoteStore()
    {
        $businessAuth = $this->getUserStore()->authenticateToBusiness($this->token);

        return $this->getNoteStore($businessAuth->noteStoreUrl);


    }

    /**
     * @param null $path
     * @return string
     */
    public function getEndpoint($path = null)
    {
        $url = $this->sandbox ? self::SANDBOX_BASE_URL : self::PROD_BASE_URL;

        if (null != $path) {
            $url .= '/' . $path;
        }

        return $url;
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

    /**
     * @param $type
     * @param $url
     * @return mixed
     */
    protected function getThriftClient($type, $url)
    {
        return $this->getThriftClientFactory()->createThriftClient($type, $url);
    }
}

