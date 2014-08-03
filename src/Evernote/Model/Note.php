<?php

namespace Evernote\Model;

use Evernote\Helper\EnmlConverterInterface;

class Note
{
    /** @var \EDAM\Types\Note  */
    protected $edamNote;

    /** @var string */
    protected $guid;

    /** @var string  */
    protected $title = '';

    /** @var \Evernote\Model\NoteContentInterface */
    protected $content = '';

    /** @var array */
    protected $resources = array();

    public function __construct(\EDAM\Types\Note $edamNote = null)
    {
        if (null !== $edamNote) {
            $this->edamNote  = $edamNote;
            $this->guid      = $edamNote->guid;
            $this->title     = $edamNote->title;
            $this->content   = $edamNote->content;
            $this->resources = $edamNote->resources;
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . ucfirst($name);

        if (property_exists($this, $name) && method_exists($this, $method)) {

            return $this->$method($value);
        }
    }

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);

        if (property_exists($this, $name) && method_exists($this, $method)) {

            return $this->$method();
        }
    }

    public function setContent(NoteContentInterface $content)
    {
        $this->content = $content->toEnml();

        return $this;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return \Evernote\Model\NoteContentInterface
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return \EDAM\Types\Note
     */
    public function getEdamNote()
    {
        return $this->edamNote;
    }



}