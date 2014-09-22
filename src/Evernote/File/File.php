<?php

namespace Evernote\File;

class File extends \SplFileObject implements FileInterface
{
    protected $mimeType;

    protected $width;

    protected $height;

    protected $resizableMimeType = array(
        'image/gif',
        'image/jpeg',
        'image/png',
        'application/pdf'
    );

    public function __construct($path, $mime_type, $width = null, $height = null)
    {
        if (!is_file($path)) {
            throw new \Exception('File not found : ' . $path);
        }

        if (in_array($mime_type, $this->resizableMimeType)) {
            $this->width  = $width;
            $this->height = $height;
        }

        $this->mimeType = $mime_type;

        parent::__construct($path);
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }


}