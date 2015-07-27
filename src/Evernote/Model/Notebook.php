<?php

namespace Evernote\Model;

class Notebook
{
    /** @var string  */
    protected $name = '';

    /** @var string  */
    protected $guid;

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

    /** @var  string */
    protected $authToken;

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

    public function __set($name, $value)
    {
        $method = 'set' . ucfirst($name);

        if (method_exists($this, $method)) {

            return $this->$method($value);
        }
    }

    public function getEdamNotebook()
    {
        return $this->notebook;
    }
    
    public function getName()
    {
        if (null !== $this->linkedNotebook) {
            return $this->linkedNotebook->shareName;
        }

        if (null !== $this->notebook) {
            return $this->notebook->name;
        }

        return $this->name;
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

        return $this->guid;
    }

    public function setGuid($guid)
    {
        $this->guid = $guid;
    }

    public function getLinkedNotebook()
    {
        return $this->linkedNotebook;
    }

    public function getAuthToken()
    {
        return $this->authToken;
    }

    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;
    }
}
