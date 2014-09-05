<?php

namespace Evernote\Model;

use Evernote\Enml\Converter\EnmlToHtmlConverter;

class EnmlNoteContent extends NoteContent implements NoteContentInterface
{
    protected $htmlConverter;

    public function getEnmlConverter()
    {
        return null;
    }

    public function getHtmlConverter()
    {
        if (null === $this->htmlConverter) {
            $this->htmlConverter = new EnmlToHtmlConverter();
        }

        return $this->htmlConverter;
    }

    public function toEnml()
    {
        return $this->content;
    }

    public function toHtml()
    {
        $html = $this->getHtmlConverter()->convertToHtml($this->content);

        return <<<HTLM
<html><body>$html</body></html>
HTLM;

    }
}