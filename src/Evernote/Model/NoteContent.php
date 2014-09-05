<?php

namespace Evernote\Model;

use Evernote\Enml\Converter\EnmlConverterInterface;

abstract class NoteContent
{
    /** @var  mixed */
    protected $content;

    /** @var \Evernote\Enml\Converter\EnmlConverterInterface  */
    protected $enmlConverter;

    public function __construct($content, EnmlConverterInterface $enmlConverter = null)
    {
        $this->content   = $content;
        $this->enmlConverter = $enmlConverter;
    }
}