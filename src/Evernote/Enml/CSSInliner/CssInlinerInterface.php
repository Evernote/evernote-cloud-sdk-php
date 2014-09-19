<?php

namespace Evernote\Enml\CSSInliner;

interface CssInlinerInterface
{
    public function convert($html, $css);
} 