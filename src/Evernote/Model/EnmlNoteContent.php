<?php

namespace Evernote\Model;

class EnmlNoteContent extends NoteContent implements NoteContentInterface
{
    public function getEnmlConverter()
    {
        return null;
    }

    public function toEnml()
    {
        return $this->content;
    }
}