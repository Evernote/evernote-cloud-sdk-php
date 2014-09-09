<?php

namespace Evernote\Auth;

use ohmy\Auth1;

class OauthHandler
{
    protected $sandbox;

    public function __construct($sandbox = true)
    {
        $this->sandbox = $sandbox;
    }
    
    public function authorize($key, $secret, $callback)
    {
        $subdomain = (true === $this->sandbox) ? 'sandbox':'www';

        $oauth_data = Auth1::legs(3)
            ->set(array(
                'consumer_key'    => $key,
                'consumer_secret' => $secret,
                'callback'        => $callback
            ))
            ->request('https://' . $subdomain . '.evernote.com/oauth')
            ->authorize('https://' . $subdomain . '.evernote.com/OAuth.action')
            ->access('https://' . $subdomain . '.evernote.com/oauth')
            ->finally(function($data) {
                return $data;
            });

        return $oauth_data->value;
    }
} 