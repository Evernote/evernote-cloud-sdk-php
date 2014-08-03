<?php

namespace Evernote\Helper;

class HtmlToEnmlConverter implements EnmlConverterInterface
{
    public function convertToEnml($content)
    {
        return 'html' . $content . 'html';
    }
} 