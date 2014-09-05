<?php

namespace Evernote\Model;

use Evernote\Enml\Converter\HtmlToEnmlConverter;

class HtmlNoteContent extends NoteContent implements NoteContentInterface
{
    public function getEnmlConverter()
    {
        if (null === $this->enmlConverter) {
            $this->enmlConverter = new HtmlToEnmlConverter();
        }

        return $this->enmlConverter;
    }

    public function toEnml()
    {
        return $this->getEnmlConverter()->convertToEnml($this->content);
    }
}