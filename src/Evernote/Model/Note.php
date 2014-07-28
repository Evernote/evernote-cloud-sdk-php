<?php

namespace Evernote\Model;

class Note
{
    /** @var \EDAM\Types\Note  */
    protected $edamNote;

    /** @var string */
    protected $guid;

    /** @var string  */
    protected $title = '';

    /** @var string */
    protected $content = '';

    /** @var array */
    protected $resources = array();

    public function __construct(\EDAM\Types\Note $edamNote = null)
    {
        if (null != $edamNote) {
            $this->edamNote  = $edamNote;
            $this->guid      = $edamNote->guid;
            $this->title     = $edamNote->title;
            $this->content   = $edamNote->content;
            $this->resources = $edamNote->resources;
        }
    }

}