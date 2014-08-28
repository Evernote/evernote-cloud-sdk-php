<?php

namespace Evernote\File;

class File extends \SplFileObject implements FileInterface
{
    protected $mimeType;

    public function __construct($path, $mime_type)
    {
        if (!is_file($path)) {
            throw new \Exception('File not found : ' . $path);
        }

        $this->mimeType = $mime_type;

        parent::__construct($path);
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }
}