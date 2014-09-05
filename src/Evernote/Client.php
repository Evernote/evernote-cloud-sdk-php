<?php

namespace Evernote;

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

    public function listNotebooks()
    {
        $personalNotebooks = $this->listPersonalNotebooks();

        $resultNotebooks  = array();
        $guidsToNotebooks = array();
        foreach($personalNotebooks as $personalNotebook) {
            $resultNotebook = new Notebook($personalNotebook);
            $resultNotebooks[] = $resultNotebook;
            $guidsToNotebooks[$personalNotebook->guid] = $resultNotebook;
        }

        $sharedNotebooks = $this->listSharedNotebooks();

        foreach ($sharedNotebooks as $sharedNotebook) {
            $guidsToNotebooks[$sharedNotebook->notebookGuid]->isShared = true;
        }

        $linkedPersonalNotebooks = $this->listLinkedNotebooks();

        if (count($linkedPersonalNotebooks) > 0) {
            if (null !== $this->getBusinessNoteStore()) {
                $businessSharedNotebooks     = $this->getBusinessNoteStore()->listSharedNotebooks($this->getBusinessToken());
                $sharedBusinessNotebookGuids = array();
                $sharedBusinessNotebooks     = array();
                foreach ($businessSharedNotebooks as $businessSharedNotebook) {
                    $sharedBusinessNotebooks[$businessSharedNotebook->shareKey] = $businessSharedNotebook;
                    $sharedBusinessNotebookGuids[] = $businessSharedNotebook->notebookGuid;
                }

                $guidsCount = array_count_values($sharedBusinessNotebookGuids);

                $businessNotebooksGuids = array();

                $businessNoteStore = $this->getBusinessNoteStore();

                $businessToken     = $this->getBusinessToken();

                $businessNotebooks = $businessNoteStore->listNotebooks($businessToken);

                foreach ($businessNotebooks as $businessNotebook) {
                    $businessNotebooksGuids[$businessNotebook->guid] = $businessNotebook;
                }

                foreach ($linkedPersonalNotebooks as $linkedPersonalNotebook) {
                    if (array_key_exists($linkedPersonalNotebook->shareKey, $sharedBusinessNotebooks)) {
                        $sharedNotebook = $sharedBusinessNotebooks[$linkedPersonalNotebook->shareKey];
                        $businessNotebook = $businessNotebooksGuids[$sharedNotebook->notebookGuid];

                        $result = new Notebook($businessNotebook, $linkedPersonalNotebook, $sharedNotebook, $businessNotebook);
                        if ((array_key_exists($sharedNotebook->notebookGuid, $guidsCount) && $guidsCount[$sharedNotebook->notebookGuid] > 1)
                            || $businessNotebook->businessNotebook !== null) {
                            $result->isShared = true;
                        }
                        $resultNotebooks[] = $result;
                    } else {
                        $sharedNoteStore = $this->getNotestore($linkedPersonalNotebook->noteStoreUrl);
                        if (null === $linkedPersonalNotebook->shareKey) {
                            continue;
                        }
                        $authResult = $sharedNoteStore->authenticateToSharedNotebook($linkedPersonalNotebook->shareKey, $this->token);
                        $sharedNotebook = $sharedNoteStore->getSharedNotebookByAuth($authResult->authenticationToken);
                        $resultNotebook = new Notebook(null, $linkedPersonalNotebook, $sharedNotebook);
                        $resultNotebooks[] = $resultNotebook;
                    }
                }

            } else {
                foreach ($linkedPersonalNotebooks as $linkedNotebook) {
                    try {
                        $sharedNoteStore = $this->getNotestore($linkedNotebook->noteStoreUrl);
                        $authResult = $sharedNoteStore->authenticateToSharedNotebook($linkedNotebook->shareKey, $this->token);
                        $sharedNotebook = $sharedNoteStore->getSharedNotebookByAuth($authResult->authenticationToken);
                        $resultNotebook = new Notebook(null, $linkedNotebook, $sharedNotebook);
                        $resultNotebooks[] = $resultNotebook;
                    } catch (\Exception $e) {
                        echo "\nNope";
                    }
                };
            }
        }

        return $resultNotebooks;
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


    public function uploadNote(Note $note, Notebook $notebook = null, Note $noteToReplace = null)
    {
        if (null !== $noteToReplace) {
            $edamNote = $noteToReplace->getEdamNote();
        } else {
            $edamNote = new \EDAM\Types\Note();

            if (null !== $notebook) {
                $edamNote->notebookGuid = $notebook->getGuid();
            }
        }

        $edamNote->title      = $note->title;
        $edamNote->content    = $note->content;
        $edamNote->attributes = $note->attributes;
        $edamNote->resources  = $note->resources;

        if (null !== $noteToReplace) {
            $uploaded_note = $this->getUserNotestore()->updateNote($this->token, $edamNote);
        } else {
            $uploaded_note = $this->getUserNotestore()->createNote($this->token, $edamNote);
        }

        $uploaded_note->content = $note->content;

        return new Note($uploaded_note);
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

    protected function getShareUrl($guid, $shardId, $shareKey, $serviceHost, $encodedAdditionalString = '')
    {
        return $serviceHost . "/shard/" . $shardId . "/sh/" . $guid . "/" . $shareKey;
    }

} 