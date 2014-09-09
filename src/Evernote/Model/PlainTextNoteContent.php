<?php

namespace Evernote\Model;

use Evernote\Enml\Converter\PlainTextToEnmlConverter;

class PlainTextNoteContent extends NoteContent implements NoteContentInterface
{
    public function getEnmlConverter()
    {
        if (null === $this->enmlConverter) {
            $this->enmlConverter = new PlainTextToEnmlConverter();
        }

        return $this->enmlConverter;
    }

    public function toEnml()
    {
        return $this->getEnmlConverter()->convertToEnml($this->content);
    }
}