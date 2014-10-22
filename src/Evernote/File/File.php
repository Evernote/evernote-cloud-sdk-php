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

    public function __construct($path, $mime_type = null, $width = null, $height = null)
    {
        if (!is_file($path)) {
            throw new \Exception('File not found : ' . $path);
        }

        parent::__construct($path);

        $this->findMimeType($path);
        $this->mimeType = $mime_type ?: $this->findMimeType($path);

        if (in_array($this->mimeType, $this->resizableMimeType)) {
            $this->width  = $width;
            $this->height = $height;
        }
    }

    public function getContent()
    {
        $file_content = '';

        while (!$this->eof()) {
            $file_content .= $this->fgets();
        }

        return $file_content;
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

    /**
     * Find the file's mime type.
     *
     * @return string
     */
    private function findMimeType($path)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $path);
        finfo_close($finfo);

        if (strpos($mime_type, ';') !== false) {
            list($mime_type, $info) = explode(';', $mime_type);
        }
        
        return trim($mime_type);
    }
}