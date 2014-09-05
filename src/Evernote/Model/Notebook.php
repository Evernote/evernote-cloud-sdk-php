<?php

namespace Evernote\Model;

class Notebook
{
    /** @var string  */
    protected $name = '';

    /** @var bool  */
    protected $allowsWriting = false;

    /** @var bool  */
    public $isShared = false;

    /** @var bool  */
    protected $isBusinessNotebook = false;

    /** @var bool  */
    protected $isOwnedByUser = false;

    /** @var bool  */
    protected $isDefaultNotebook = false;

    /***********************************/

    /** @var  \EDAM\Types\Notebook */
    protected $notebook;

    /** @var  \EDAM\Types\LinkedNotebook */
    protected $linkedNotebook;

    /** @var  \EDAM\Types\SharedNotebook */
    protected $sharedNotebook;

    /** @var  bool  */
    protected $isDefaultNotebookOverride = false;

    /************************************/

    public function __construct($notebook = null, $linkedNotebook = null, $sharedNotebook = null, $businessNotebook = null)
    {
        $this->notebook         = $notebook;
        $this->linkedNotebook   = $linkedNotebook;
        $this->sharedNotebook   = $sharedNotebook;
        $this->businessNotebook = $businessNotebook;
    }

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);

        if (method_exists($this, $method)) {

            return $this->$method();
        }
    }

    public function getName()
    {
        if (null !== $this->notebook) {
            return $this->notebook->name;
        } else {
            return $this->linkedNotebook->shareName;
        }
    }

    public function isBusinessNotebook()
    {
       return $this->linkedNotebook !== null && $this->notebook !== null;
    }

    public function isLinkedNotebook()
    {
        return $this->linkedNotebook !== null;
    }

    public function isPublic()
    {
        return $this->isLinkedNotebook() && $this->linkedNotebook->shareKey === null;
    }

    public function isDefaultNotebook()
    {
        return $this->notebook !== null && $this->notebook->defaultNotebook;
    }

    public function getGuid()
    {
        if ($this->notebook !== null) {
            return $this->notebook->guid;
        }

        if ($this->sharedNotebook !== null) {
            return $this->sharedNotebook->notebookGuid;
        }
    }
}