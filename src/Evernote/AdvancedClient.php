<?php

namespace Evernote;

use Evernote\Store;

class AdvancedClient
{
    private $consumerKey;
    private $consumerSecret;
    private $sandbox;
    private $serviceHost;
    private $additionalHeaders;
    private $token;
    private $secret;

    public function __construct($options)
    {
        $this->consumerKey = isset($options['consumerKey']) ? $options['consumerKey'] : null;
        $this->consumerSecret = isset($options['consumerSecret']) ? $options['consumerSecret'] : null;

        $options += array('sandbox' => true);
        $this->sandbox = $options['sandbox'];

        $defaultServiceHost = $this->sandbox ? 'sandbox.evernote.com' : 'www.evernote.com';

        $options += array('serviceHost' => $defaultServiceHost);
        $this->serviceHost = $options['serviceHost'];

        $options += array('additionalHeaders' => array());
        $this->additionalHeaders = $options['additionalHeaders'];

        $this->token = isset($options['token']) ? $options['token'] : null;
        $this->secret = isset($options['secret']) ? $options['secret'] : null;
    }

    public function getRequestToken($callbackUrl)
    {
        $oauth = new \OAuth($this->consumerKey, $this->consumerSecret);

        return $oauth->getRequestToken($this->getEndpoint('oauth'), $callbackUrl);
    }

    public function getAccessToken($oauthToken, $oauthTokenSecret, $oauthVerifier)
    {
        $oauth = new \OAuth($this->consumerKey, $this->consumerSecret);
        $oauth->setToken($oauthToken, $oauthTokenSecret);
        $accessToken= $oauth->getAccessToken($this->getEndpoint('oauth'), null, $oauthVerifier);

        $this->token = $accessToken['oauth_token'];

        return $accessToken;
    }

    public function getAuthorizeUrl($requestToken)
    {
        $url = $this->getEndpoint('OAuth.action');
        $url .= '?oauth_token=';
        $url .= urlencode($requestToken);

        return $url;
    }

    public function getUserStore()
    {
        $userStoreUrl = $this->getEndpoint('/edam/user');

        return new Store($this->token, '\EDAM\UserStore\UserStoreClient', $userStoreUrl);
    }

    public function getNoteStore()
    {
        $userStore = $this->getUserStore();
        $noteStoreUrl = $userStore->getNoteStoreUrl();

        return new Store($this->token, '\EDAM\NoteStore\NoteStoreClient', $noteStoreUrl);
    }

    public function getSharedNoteStore($linkedNotebook)
    {
        $noteStoreUrl = $linkedNotebook->noteStoreUrl;
        $noteStore = new Store($this->token, '\EDAM\NoteStore\NoteStoreClient', $noteStoreUrl);
        $sharedAuth = $noteStore->authenticateToSharedNotebook($linkedNotebook->shareKey);
        $sharedToken = $sharedAuth->authenticationToken;

        return new Store($sharedToken, '\EDAM\NoteStore\NoteStoreClient', $noteStoreUrl);
    }

    public function getBusinessNoteStore()
    {
        $userStore = $this->getUserStore();
        $bizAuth = $userStore->authenticateToBusiness();
        $bizToken = $bizAuth->authenticationToken;
        $noteStoreUrl = $bizAuth->noteStoreUrl;

        return new Store($bizToken, '\EDAM\NoteStore\NoteStoreClient', $noteStoreUrl);
    }

    protected function getEndpoint($path = null)
    {
        $url = "https://".$this->serviceHost;
        if ($path != null) {
            $url .= "/".$path;
        }

        return $url;
    }

}
