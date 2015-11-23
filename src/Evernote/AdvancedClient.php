<?php

namespace Evernote;

use Psr\Log\NullLogger;
use Psr\Log\LoggerInterface;
use Evernote\Factory\ThriftClientFactory;
use Evernote\Store\Store;

class AdvancedClient
{
    /** @var  string */
    protected $token;

    /** @var bool */
    protected $sandbox;

    /** @var bool */
    protected $china;

    /** @var \Evernote\Factory\ThriftClientFactory  */
    protected $thriftClientFactory;

    /** @var  \EDAM\UserStore\UserStoreClient */
    protected $userStore;

    /** @var \Psr\Log\LoggerInterface */
    protected $logger;

    const SANDBOX_BASE_URL = 'https://sandbox.evernote.com';
    const PROD_BASE_URL    = 'https://www.evernote.com';
    const CHINA_BASE_URL   = 'https://app.yinxiang.com';

    /**
     * @param string $token
     * @param bool $sandbox
     * @param Evernote\Factory\ThriftClientFactory|null $thriftClientFactory
     * @param \Psr\Log\LoggerInterface|null $logger
     * @param bool $china
     */
    public function __construct($token, $sandbox = true, $thriftClientFactory = null, LoggerInterface $logger = null, $china = false)
    {
        $this->token               = $token;
        $this->sandbox             = $sandbox;
        $this->thriftClientFactory = $thriftClientFactory;
        $this->logger              = $logger ?: new NullLogger;
        $this->china               = $china;
    }

    /**
     * @return \EDAM\UserStore\UserStoreClient
     */
    public function getUserStore()
    {
        if (null === $this->userStore) {
            $this->userStore = $this->getStoreInstance($this->token, 'user', $this->getEndpoint('/edam/user'));
        }

        return $this->userStore;
    }

    /**
     * @param $noteStoreUrl
     * @return mixed
     */
    public function getNoteStore($noteStoreUrl = null, $token = null)
    {
        if (null === $noteStoreUrl) {
            $noteStoreUrl = $this->getUserStore()->getNoteStoreUrl($this->token);
        }

        if (null == $token) {
            $token = $this->token;
        }

        return $this->getStoreInstance($token, 'note', $noteStoreUrl);
    }


    public function getSharedNoteStore($linkedNotebook)
    {
        $noteStoreUrl = $linkedNotebook->noteStoreUrl;
        $noteStore = $this->getNoteStore($noteStoreUrl);
        $sharedAuth = $noteStore->authenticateToSharedNotebook($linkedNotebook->shareKey);
        $sharedToken = $sharedAuth->authenticationToken;

        return $this->getStoreInstance($sharedToken, 'note', $noteStoreUrl);
    }

    public function getBusinessNoteStore()
    {
        $businessAuth = $this->getUserStore()->authenticateToBusiness($this->token);

        return $this->getNoteStore($businessAuth->noteStoreUrl, $businessAuth->authenticationToken);
    }

    /**
     * @param null $path
     * @return string
     */
    public function getEndpoint($path = null)
    {
        if (true === $this->sandbox) {
            $url = self::SANDBOX_BASE_URL;
        } elseif (true === $this->china) {
            $url = self::CHINA_BASE_URL;
        } else {
            $url = self::PROD_BASE_URL;
        }    

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
        return $this->thriftClientFactory;
    }



    public function getStoreInstance($token, $type, $url)
    {
        return new Store($this->getThriftClientFactory(), $token, $type, $url);
    }
}

