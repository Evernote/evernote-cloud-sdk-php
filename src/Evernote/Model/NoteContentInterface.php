<?php

namespace Evernote\Model;

interface NoteContentInterface
{
    public function toEnml();

    public function getEnmlConverter();
}