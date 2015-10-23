<?php

namespace Evernote\Model;

use EDAM\Limits\Constant;
use EDAM\NoteStore\NoteStoreClient;
use EDAM\Types\NoteAttributes;
use Evernote\Helper\EnmlConverterInterface;

class Note
{
    /** @var \EDAM\Types\Note  */
    protected $edamNote;

    /** @var string */
    protected $guid;

    /** @var string  */
    protected $title = '';

    /** @var string  */
    protected $tagNames = array();

    /** @var string  */
    protected $notebookGuid = '';

    /** @var \Evernote\Model\NoteContentInterface */
    protected $content = '';

    /** @var array */
    protected $resources = array();

    /** @var  \EDAM\Types\NoteAttributes */
    protected $attributes;

    /** @var  \EDAM\Types\NoteCreated */
    protected $created;

    /** @var  boolean */
    protected $saved;

    /** @var  string */
    protected $authToken;

    /** @var  \EDAM\NoteStore\NoteStoreClient */
    protected $noteStore;

    public function __construct(\EDAM\Types\Note $edamNote = null)
    {
        if (null !== $edamNote) {
            $this->edamNote     = $edamNote;
            $this->guid         = $edamNote->guid;
            $this->notebookGuid = $edamNote->notebookGuid;
            $this->title        = $edamNote->title;
            $this->content      = new EnmlNoteContent($edamNote->content);
            $this->resources    = $edamNote->resources;
            $this->attributes   = $edamNote->attributes;
            $this->created      = $edamNote->created;
            $this->tagNames     = $edamNote->tagNames;
        } else {
            $this->attributes = new NoteAttributes();
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . ucfirst($name);

        if (method_exists($this, $method)) {

            return $this->$method($value);
        }
    }

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);

        if (method_exists($this, $method)) {

            return $this->$method();
        }
    }

    public function setContent($content)
    {
        if (false === $content instanceof NoteContentInterface) {
            $content = new PlainTextNoteContent($content);
        }

        $this->content = $content->toEnml();

        return $this;
    }

    public function validateForLimits()
    {
        $contentLength = strlen($this->getContent());
        if ($contentLength > Constant::get('EDAM_NOTE_CONTENT_LEN_MAX')
            || $contentLength < Constant::get('EDAM_NOTE_CONTENT_LEN_MIN')) {
            return false;
        }

        return true;
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

    /**
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }

    public function setGuid($guid)
    {
        $this->guid = $guid;
    }

    public function getAttribute($attribute)
    {
        if (property_exists($this->attributes, $attribute)) {
            return $this->attributes->$attribute;
        }

        return null;
    }

    public function setAttribute($attribute, $value)
    {
        $this->attributes->$attribute = $value;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($value)
    {
        $this->created = $value;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function isReminder()
    {
        return $this->getAttribute('reminderOrder') !== null;
    }

    public function setReminder($timestamp = null)
    {
        $this->setAttribute('reminderOrder', time());
        $this->setAttribute('reminderTime', $timestamp * 1000);
    }

    public function clearReminder()
    {
        $this->setAttribute('reminderOrder', null);
        $this->setAttribute('reminderTime', null);
        $this->setAttribute('reminderDoneTime', null);
    }

    public function setAsDone()
    {
        $this->setAttribute('reminderDoneTime', time() * 1000);
    }

    public function isDone()
    {
        return $this->getAttribute('reminderDoneTime') !== null;
    }

    public function getReminderTime()
    {
        $reminder_time = $this->getAttribute('reminderTime');

        if (null !== $reminder_time) {
            $reminder_time = $reminder_time / 1000;
        }

        return $reminder_time;
    }

    public function getReminderDoneTime()
    {
        $reminder_done_time = $this->getAttribute('reminderDoneTime');

        if (null !== $reminder_done_time) {
            $reminder_done_time = $reminder_done_time / 1000;
        }

        return $reminder_done_time;
    }

    public function addResource(Resource $resource)
    {
        $this->resources[] = $resource->edamResource;
    }

    public function getResources()
    {
        return $this->resources;
    }

    public function getSaved()
    {
        return $this->saved;
    }

    public function setSaved($value)
    {
        $this->saved = $value;
    }

    public function getNotebookGuid()
    {
        return $this->notebookGuid;
    }

    public function getAuthToken()
    {
        return $this->authToken;
    }

    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;
    }

    public function setTagNames(array $tagNames)
    {
        $this->tagNames = $tagNames;
    }

    public function getTagNames()
    {
        return $this->tagNames;
    }

    /**
     * @param \EDAM\NoteStore\NoteStoreClient $noteStore
     */
    public function setNoteStore($noteStore)
    {
        $this->noteStore = $noteStore;
    }

    /**
     * @return \EDAM\NoteStore\NoteStoreClient
     */
    public function getNoteStore()
    {
        return $this->noteStore;
    }


}