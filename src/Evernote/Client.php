<?php

namespace Evernote;

use EDAM\Types\LinkedNotebook;
use Evernote\Model\Note;
use Evernote\Model\Notebook;
use ohmy\Auth1;
class Client
{
    /** @var  \Evernote\AdvancedClient */
    protected $advancedClient;

    /** @var  string */
    protected $token;

    /** @var  boolean */
    protected $sandbox;

    /** @var  \EDAM\NoteStore\NoteStoreClient */
    protected $userNoteStore;

    /** @var  \EDAM\NoteStore\NoteStoreClient */
    protected $businessNoteStore;

    /** @var  string */
    protected $businessToken;

    /** @var   \EDAM\Types\User */
    protected $user;

    /** @var  \EDAM\UserStore\AuthenticationResult */
    protected $businessAuth;

    public function __construct($token = null, $sandbox = true, $advancedClient = null)
    {
        $this->token   = $token;
        $this->sandbox = $sandbox;

        if (null === $advancedClient) {
            $advancedClient = new AdvancedClient($this->sandbox);
        }

        $this->advancedClient = $advancedClient;
    }

    public function getUser()
    {
        if (null === $this->user) {
            $this->user = $this->getAdvancedClient()
                ->getUserStore()->getUser($this->token);
        }

        return $this->user;
    }

    public function isBusinessUser()
    {
        return $this->getUser()->accounting->businessId !== null;
    }

    public function getBusinessAuth()
    {
        if (null === $this->businessAuth) {
            $this->businessAuth =
                $this->getAdvancedClient()->getUserStore()->authenticateToBusiness($this->token);
        }

        return $this->businessAuth;
    }

    public function getBusinessToken()
    {
        if (null === $this->businessToken) {
            $this->businessToken = $this->getBusinessAuth()->authenticationToken;
        }

        return $this->businessToken;
    }
    
    public function getBusinessNoteStore()
    {
        if (null === $this->businessNoteStore && $this->isBusinessUser()) {
            $this->businessNoteStore =
                $this->getNoteStore($this->getBusinessAuth()->noteStoreUrl);
        }

        return $this->businessNoteStore;
    }

    public function getBusinessSharedNotebooks()
    {
        return $this->getBusinessNoteStore()->listSharedNotebooks($this->getBusinessToken());
    }

    public function getBusinessLinkedNotebooks()
    {
        return $this->getBusinessNoteStore()->listNotebooks($this->getBusinessToken());
    }

    public function listNotebooks()
    {
        /**
         * 1. Get all of the user's personal notebooks.
         */
        $personalNotebooks = $this->listPersonalNotebooks();

        $resultNotebooks  = array();
        $guidsToNotebooks = array();
        foreach($personalNotebooks as $personalNotebook) {
            $resultNotebook = new Notebook($personalNotebook);
            $resultNotebooks[] = $resultNotebook;
            $guidsToNotebooks[$personalNotebook->guid] = $resultNotebook;
        }

        /**
         * Get shared notebooks and flag the matching notebook as shared
         */
        $sharedNotebooks = $this->listSharedNotebooks();

        foreach ($sharedNotebooks as $sharedNotebook) {
            $guidsToNotebooks[$sharedNotebook->notebookGuid]->isShared = true;
        }

        /**
         * 2. Get all of the user's linked notebooks. These will include business and/or shared notebooks.
         */
        $linkedNotebooks = $this->listLinkedNotebooks();
        if (count($linkedNotebooks) > 0) {
            /**
             * 3. Business user
             */
            if (null !== $this->getBusinessNoteStore()) {

                /**
                 * a. Get the business's shared notebooks. Some of these may match to personal linked notebooks.
                 *
                 */
                $businessSharedNotebooks     = $this->getBusinessSharedNotebooks();
                $sharedBusinessNotebookGuids = array();
                $sharedBusinessNotebooks     = array();
                foreach ($businessSharedNotebooks as $businessSharedNotebook) {
                    $sharedBusinessNotebooks[$businessSharedNotebook->shareKey] = $businessSharedNotebook;
                    $sharedBusinessNotebookGuids[] = $businessSharedNotebook->notebookGuid;
                }

                $guidsCount = array_count_values($sharedBusinessNotebookGuids);

                $businessNotebooksGuids = array();

                /**
                 * b. Get the business's linked notebooks. Some of these will match to shared notebooks in (a), providing a
                //      complete authorization story for the notebook.
                 */
                $businessNotebooks = $this->getBusinessLinkedNotebooks();

                foreach ($businessNotebooks as $businessNotebook) {
                    $businessNotebooksGuids[$businessNotebook->guid] = $businessNotebook;
                }

                foreach ($linkedNotebooks as $linkedNotebook) {
                    if (array_key_exists($linkedNotebook->shareKey, $sharedBusinessNotebooks)) {
                        $sharedNotebook = $sharedBusinessNotebooks[$linkedNotebook->shareKey];
                        $businessNotebook = $businessNotebooksGuids[$sharedNotebook->notebookGuid];

                        $result = new Notebook($businessNotebook, $linkedNotebook, $sharedNotebook, $businessNotebook);
                        if ((array_key_exists($sharedNotebook->notebookGuid, $guidsCount) && $guidsCount[$sharedNotebook->notebookGuid] > 1)
                            || $businessNotebook->businessNotebook !== null) {
                            $result->isShared = true;
                        }
                        $resultNotebooks[] = $result;
                    } else {
                        if (null === $linkedNotebook->shareKey) {
                            continue;
                        }
                        $resultNotebooks[] = $this->getNoteBookByLinkedNotebook($linkedNotebook);
                    }
                }

            } else {
                foreach ($linkedNotebooks as $linkedNotebook) {
                    try {
                        $resultNotebooks[] = $this->getNoteBookByLinkedNotebook($linkedNotebook);
                    } catch (\Exception $e) {
                        echo "\nNope";
                    }
                };
            }
        }

        return $resultNotebooks;
    }

    protected function getNoteBookByLinkedNotebook(LinkedNotebook $linkedNotebook)
    {
        $sharedNoteStore = $this->getNotestore($linkedNotebook->noteStoreUrl);
        $authResult = $sharedNoteStore->authenticateToSharedNotebook($linkedNotebook->shareKey, $this->token);
        $sharedNotebook = $sharedNoteStore->getSharedNotebookByAuth($authResult->authenticationToken);

        return new Notebook(null, $linkedNotebook, $sharedNotebook);
    }
    
    
    public function listPersonalNotebooks()
    {
        $notebooks = $this->getUserNotestore()->listNotebooks($this->token);

        return $notebooks;
    }

    public function listSharedNotebooks()
    {
        return $this->getUserNotestore()->listSharedNotebooks($this->token);
    }

    public function listLinkedNotebooks()
    {

        return $this->getUserNotestore()->listLinkedNotebooks($this->token);
    }

    protected function getUserNotestore()
    {
        if (null === $this->userNoteStore) {
            $noteStoreUrl =
                $this->getAdvancedClient()
                    ->getUserStore()
                    ->getNoteStoreUrl($this->token);

            $this->userNoteStore = $this->getNoteStore($noteStoreUrl);
        }

        return $this->userNoteStore;
    }

    protected function getNoteStore($noteStoreUrl)
    {
        return $this->getAdvancedClient()->getNoteStore($noteStoreUrl);
    }

    /**
     * @param \Evernote\AdvancedClient $advancedClient
     */
    public function setAdvancedClient($advancedClient)
    {
        $this->advancedClient = $advancedClient;
    }

    /**
     * @return \Evernote\AdvancedClient
     */
    public function getAdvancedClient()
    {
        return $this->advancedClient;
    }

    /**
     * @param boolean $sandbox
     */
    public function setSandbox($sandbox)
    {
        $this->sandbox = $sandbox;
    }

    /**
     * @return boolean
     */
    public function getSandbox()
    {
        return $this->sandbox;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    public function replaceNote(Note $noteToReplace, Note $note)
    {
        $edamNote = $noteToReplace->getEdamNote();

        $edamNote->title      = $note->title;
        $edamNote->content    = $note->content;
        $edamNote->attributes = $note->attributes;
        $edamNote->resources  = $note->resources;

        $uploaded_note = $this->getUserNotestore()->updateNote($this->token, $edamNote);

        $uploaded_note->content = $note->content;

        $en_note = new Note($uploaded_note);

        $en_note->setSaved(true);

        return $en_note;
    }

    public function uploadNote(Note $note, Notebook $notebook = null)
    {
        if (true === $note->getSaved()) {
            return $this->replaceNote($note, $note);
        }

        $edamNote = new \EDAM\Types\Note();

        if (null !== $notebook) {
            $edamNote->notebookGuid = $notebook->getGuid();
        }

        $edamNote->title      = $note->title;
        $edamNote->content    = $note->content;
        $edamNote->attributes = $note->attributes;
        $edamNote->resources  = $note->resources;

        $uploaded_note = $this->getUserNotestore()->createNote($this->token, $edamNote);

        $uploaded_note->content = $note->content;

        $en_note = new Note($uploaded_note);

        $en_note->setSaved(true);

        return $en_note;

    }

    public function deleteNote(Note $note)
    {
        return $this->getUserNotestore()->deleteNote($this->token, $note->guid);
    }

    public function shareNote(Note $note)
    {
        $shareKey = $this->getUserNotestore()->shareNote($this->token, $note->getGuid());

        $shardId = $this->getUser()->shardId;

        return $this->getShareUrl($note->getGuid(), $shardId, $shareKey, $this->getAdvancedClient()->getEndpoint());
    }

    protected function getShareUrl($guid, $shardId, $shareKey, $serviceHost)
    {
        return $serviceHost . "/shard/" . $shardId . "/sh/" . $guid . "/" . $shareKey;
    }

} 