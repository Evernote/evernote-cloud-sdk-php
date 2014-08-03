<?php

namespace Evernote\Model;

use Evernote\Helper\EnmlConverterInterface;

abstract class NoteContent
{
    /** @var  mixed */
    protected $content;

    /** @var \Evernote\Helper\EnmlConverterInterface  */
    protected $enmlConverter;

    public function __construct($content, EnmlConverterInterface $enmlConverter = null)
    {
        $this->content   = $content;
        $this->enmlConverter = $enmlConverter;
    }
}