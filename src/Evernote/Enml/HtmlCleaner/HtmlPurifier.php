<?php

namespace Evernote\Enml\HtmlCleaner;

class HtmlPurifier implements HtmlCleanerInterface
{
    protected $htmlPurifier;

    protected $config;

    public function __construct(\HTMLPurifier_Config $config = null)
    {
        $this->htmlPurifier = new \HTMLPurifier();
        if (null === $config) {
            $config = \HTMLPurifier_Config::createDefault();
        }
        $this->config = $config;
    }

    public function clean($html)
    {
        return $this->htmlPurifier->purify($html, $this->config);
    }
}