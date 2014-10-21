<?php

namespace Evernote\File;

interface FileInterface
{
    public function getMimeType();
    public function getFilename();
    public function getContent();
} 