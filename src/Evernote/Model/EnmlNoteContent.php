<?php

namespace Evernote\Model;

use Evernote\Enml\Converter\EnmlToHtmlConverter;
use Evernote\Enml\Converter\HtmlConverterInterface;

class EnmlNoteContent extends NoteContent implements NoteContentInterface
{
    protected $htmlConverter;

    public function __construct($content, HtmlConverterInterface $htmlConverter = null)
    {
        if (!$this->hasXmlDeclaration($content)) {
            $content = $this->decorate($content);
        }

        $this->content   = $content;
        $this->htmlConverter = $htmlConverter;
    }

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

    public function __toString()
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

    protected function hasXmlDeclaration($content)
    {
        return substr(trim($content), 0, 5) == '<?xml';
    }

    protected function decorate($content)
    {
        return <<<ENML
<?xml version='1.0' encoding='utf-8'?>
<!DOCTYPE en-note SYSTEM "http://xml.evernote.com/pub/enml2.dtd">
<en-note>$content</en-note>
ENML;

    }
}