<?php

namespace Evernote\Enml\CSSInliner;

class CssToInlineStyles implements CssInlinerInterface
{
    protected $cssInliner;

    public function __construct()
    {
        $this->cssInliner = new \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles();
    }

    public function convert($html, $css)
    {
        $this->cssInliner->setHTML($html);
        $this->cssInliner->setCSS($css);

        return $this->cssInliner->convert();
    }
} 