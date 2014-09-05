<?php

namespace Evernote\Auth;

class OauthHandler
{
    public function authorize($key, $secret, $callback)
    {
        $auth_data = Auth1::legs(3)
            # configuration
            ->set(array(
                'consumer_key'    => $key,
                'consumer_secret' => $secret,
                'callback'        => $callback
            ))
            # oauth flow
            ->request('https://www.evernote.com/oauth')
            ->authorize('https://www.evernote.com/OAuth.action')
            ->access('https://www.evernote.com/oauth')
            ->finally(function($data) {
                return $data->value;
            });

        return $auth_data;
    }
} 