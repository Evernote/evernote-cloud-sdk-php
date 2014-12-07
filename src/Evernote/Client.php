<?php

namespace Evernote;

use EDAM\Error\EDAMNotFoundException;
use EDAM\Error\EDAMSystemException;
use EDAM\Error\EDAMUserException;
use EDAM\NoteStore\NoteFilter;
use EDAM\NoteStore\NotesMetadataResultSpec;
use EDAM\Types\LinkedNotebook;
use EDAM\Types\NoteSortOrder;
use Evernote\Exception\ExceptionFactory;
use Evernote\Exception\PermissionDeniedException;
use Evernote\Model\Note;
use Evernote\Model\Notebook;
use Evernote\Model\Search;
use Evernote\Model\SearchResult;

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

    const PERSONAL_SCOPE = 1;

    const LINKED_SCOPE   = 2;

    /**
     * @param null $token
     * @param bool $sandbox
     * @param null $advancedClient
     */
    public function __construct($token = null, $sandbox = true, $advancedClient = null)
    {
        $this->token          = $token;
        $this->sandbox        = $sandbox;
        $this->advancedClient = $advancedClient;
    }

    /**
     * @return \EDAM\Types\User
     * @throws \Exception
     */
    public function getUser()
    {
        if (null === $this->user) {
            try {
                $this->user = $this->getAdvancedClient()
                    ->getUserStore()->getUser($this->token);
            } catch (\Exception $e) {
                throw ExceptionFactory::create($e);
            }
        }

        return $this->user;
    }

    /**
     * @return bool
     */
    public function isBusinessUser()
    {
        return $this->getUser()->accounting->businessId !== null;
    }

    /**
     * @return \EDAM\UserStore\AuthenticationResult
     * @throws \Exception
     */
    protected function getBusinessAuth()
    {
        if (null === $this->businessAuth) {
            try {
                $this->businessAuth =
                    $this->getAdvancedClient()
                        ->getUserStore()->authenticateToBusiness($this->token);
            } catch (\Exception $e) {
                throw ExceptionFactory::create($e);
            }
        }

        return $this->businessAuth;
    }

    /**
     * @return string
     */
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
            $this->businessNoteStore = $this->getAdvancedClient()->getBusinessNoteStore();
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
        try {
            $personalNotebooks = $this->listPersonalNotebooks();
        } catch (EDAMUserException $e) {
            echo "\n" . $e->parameter;
            $personalNotebooks = array();
        } catch (EDAMSystemException $e) {
            echo "\n" . $e->parameter;
            $personalNotebooks = array();
        }

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
        try {
            $sharedNotebooks = $this->listSharedNotebooks();
        } catch (EDAMUserException $e) {
            $sharedNotebooks = array();
        } catch (EDAMSystemException $e) {
            $sharedNotebooks = array();
        }

        foreach ($sharedNotebooks as $sharedNotebook) {
            $guidsToNotebooks[$sharedNotebook->notebookGuid]->isShared = true;
        }

        /**
         * 2. Get all of the user's linked notebooks. These will include business and/or shared notebooks.
         */

        try {
            $linkedNotebooks = $this->listLinkedNotebooks();
        } catch (EDAMUserException $e) {
            $linkedNotebooks = array();
        } catch (EDAMSystemException $e) {
            $linkedNotebooks = array();
        }

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

    protected function getSharedNotebookAuthResult(LinkedNotebook $linkedNotebook)
    {
        $sharedNoteStore = $this->getNotestore($linkedNotebook->noteStoreUrl);
        return $sharedNoteStore->authenticateToSharedNotebook($linkedNotebook->shareKey, $this->token);
    }

    protected function getNoteBookByLinkedNotebook(LinkedNotebook $linkedNotebook)
    {
        $sharedNoteStore = $this->getNotestore($linkedNotebook->noteStoreUrl);
        $authToken = $this->getSharedNotebookAuthResult($linkedNotebook)->authenticationToken;
        $sharedNotebook = $sharedNoteStore->getSharedNotebookByAuth($authToken);

        $notebook = new Notebook(null, $linkedNotebook, $sharedNotebook);

        $notebook->authToken = $authToken;

        return $notebook;
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

    public function getUserNotestore()
    {
        if (null === $this->userNoteStore) {
            $this->userNoteStore = $this->getAdvancedClient()->getNoteStore();
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
        if (null === $this->advancedClient) {
            $this->advancedClient = new AdvancedClient($this->getToken(), $this->sandbox);
        }

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

        $uploaded_note = $noteToReplace->noteStore->updateNote($noteToReplace->authToken, $edamNote);

        $uploaded_note->content = $note->content;

        $en_note = new Note($uploaded_note);

        $en_note->setSaved(true);

        return $en_note;
    }

    public function uploadNote(Note $note, Notebook $notebook = null)
    {
        if ($this->isAppNotebookToken($this->token)) {
            $notebook = new Notebook();
        }

        if (true === $note->getSaved() && $note->notebookGuid === $notebook->guid) {
            return $this->replaceNote($note, $note);
        }

        if ($note->getEdamNote()) {
            $edamNote = $note->getEdamNote();
        } else {
            $edamNote = new \EDAM\Types\Note();
        }


        $edamNote->title      = $note->title;
        $edamNote->content    = $note->content;
        $edamNote->attributes = $note->attributes;
        $edamNote->resources  = $note->resources;
        $edamNote->tagNames   = $note->tagNames;


        if (null !== $notebook && null !== $notebook->guid) {
            $edamNote->notebookGuid = $notebook->guid;
        }

        try {
            $uploaded_note = $this->getUserNotestore()->createNote($this->token, $edamNote);
            $noteStore     = $this->getUserNotestore();
            $token         = $this->token;
        } catch (EDAMNotFoundException $e) {
            $notebook = $this->getNotebook($notebook->guid, self::LINKED_SCOPE);
            if (null === $notebook) {
                throw $e;
            }

            if ($notebook->isLinkedNotebook()) {
                $noteStore = $this->getNotestore($notebook->linkedNotebook->noteStoreUrl);
                $token     = $notebook->authToken;

                $edamNote->notebookGuid = $notebook->guid;

                $uploaded_note = $noteStore->createNote($token, $edamNote);
            }
        }

        $uploaded_note->content = $note->content;

        $note = $this->getNoteInstance($uploaded_note, $noteStore, $token);

        $note->setSaved(true);

        return $note;
    }

    public function deleteNote(Note $note)
    {
        if (null === $note->guid) {

            return false;
        }

        // we have the credentials
        if (null !== $note->noteStore && null !== $note->authToken) {
            $note->noteStore->deleteNote($note->authToken, $note->guid);

            return true;
        }

        try {
            // We try to delete it with the personal credentials
            $this->getUserNotestore()->deleteNote($this->token, $note->guid);

            return true;
        } catch (EDAMNotFoundException $e) {
            // The note's not in a personal notebook. We'll need to find it
            $note = $this->getNote($note->guid, self::LINKED_SCOPE);

            if (null !== $note) {
                return $this->deleteNote($note);
            }

            return false;
         } catch (EDAMUserException $e) {
            // You don't have permission to delete this note.
            return false;
        }

    }

    public function shareNote(Note $note)
    {
        if (null === $note->guid) {

            return null;
        }

        // we have the credentials
        if (null !== $note->noteStore && null !== $note->authToken) {
            $shareKey = $note->noteStore->shareNote($note->authToken, $note->guid);
            $shardId  = $this->getShardIdFromToken($note->authToken);

            return $this->getShareUrl($note->guid, $shardId, $shareKey, $this->getAdvancedClient()->getEndpoint());
        }

        try {
            // We don't have credentials so we assume it's a personal note
            return $this->getUserNotestore()->deleteNote($this->token, $note->guid);

        } catch (EDAMNotFoundException $e) {
            // The note's not in a personal notebook. We'll need to find it
            $note = $this->getNote($note->guid, self::LINKED_SCOPE);

            if (null !== $note) {
                $shareKey = $note->noteStore->shareNote($note->authToken, $note->guid);
                $shardId  = $this->getShardIdFromToken($note->authToken);

                return $this->getShareUrl($note->guid, $shardId, $shareKey, $this->getAdvancedClient()->getEndpoint());
            }

            return null;
        }
    }

    public function moveNote(Note $note, Notebook $notebook)
    {
        if ($this->isAppNotebookToken($this->token)) {
            throw new PermissionDeniedException("You can't move a note as you're using an app notebook token");
        }

        $edamNote               = $note->getEdamNote();
        $noteStore              = $note->getNoteStore();
        $token                  = $note->getAuthToken();
        $edamNote->notebookGuid = $notebook->guid;

        try {
            $moved_note    = $noteStore->updateNote($token, $edamNote);

            $note = $this->getNoteInstance($moved_note, $noteStore, $token);
        } catch (EDAMNotFoundException $e) {
            $moved_note = $this->uploadNote($note, $notebook);
            if ($moved_note && $moved_note->notebookGuid === $notebook->guid) {
                $this->deleteNote($note);
            }

            $note = $moved_note;
        } catch (EDAMUserException $e) {
            if ($e->parameter === 'Note.notebookGuid') {
                $moved_note = $this->uploadNote($note, $notebook);
                if ($moved_note && $moved_note->notebookGuid === $notebook->guid) {
                    $this->deleteNote($note);
                }
                $note = $moved_note;
            } else {
                throw $e;
            }
        }

        return $note;
    }

    public function getNote($guid, $scope = null)
    {
        if (null === $scope || self::PERSONAL_SCOPE === $scope) {
            try {
                $edam_note = $this->getUserNotestore()->getNote($this->token, $guid, true, true, false, false);

                return $this->getNoteInstance($edam_note, $this->getUserNotestore(), $this->token);
            } catch (EDAMNotFoundException $e) {
                if (self::PERSONAL_SCOPE === $scope) {
                    return null;
                }
            }
        }

        if (null === $scope || self::LINKED_SCOPE === $scope) {
            $linkedNotebooks = $this->listLinkedNotebooks();

            foreach ($linkedNotebooks as $linkedNotebook) {
                try {
                    $sharedNoteStore = $this->getNotestore($linkedNotebook->noteStoreUrl);
                    $authToken = $this->getSharedNotebookAuthResult($linkedNotebook)->authenticationToken;

                    $edam_note = $sharedNoteStore->getNote($authToken, $guid, true, true, false, false);

                    return $this->getNoteInstance($edam_note, $sharedNoteStore, $authToken);

                } catch (EDAMUserException $e) {
                    // No right on this notebook.
                    continue;
                } catch (EDAMNotFoundException $e) {
                    // Note not found
                    continue;
                }

            }

            return null;
        }

    }

    protected function getShareUrl($guid, $shardId, $shareKey, $serviceHost)
    {
        return $serviceHost . "/shard/" . $shardId . "/sh/" . $guid . "/" . $shareKey;
    }

    public function isAppNotebookToken($token)
    {
        return strpos($token, ':B=') !== false;
    }

    public function getNotebook($notebook_guid, $scope = null)
    {
        if (null === $scope || self::PERSONAL_SCOPE === $scope) {
            try {
                $edamNotebook = $this->getUserNotestore()->getNotebook($this->token, $notebook_guid);

                return new Notebook($edamNotebook);
            } catch (EDAMNotFoundException $e) {
                if (self::PERSONAL_SCOPE === $scope) {
                    return null;
                }
            }
        }

        if (null === $scope || self::LINKED_SCOPE === $scope) {
            $linkedNotebooks = $this->listLinkedNotebooks();
            foreach ($linkedNotebooks as $linkedNotebook) {
                try {
                    $sharedNotebook = $this->getNoteBookByLinkedNotebook($linkedNotebook);

                    if ($this->isAppNotebookToken($this->token)) {
                        return $sharedNotebook;
                    }
                } catch (EDAMUserException $e) {
                    // No right on this notebook.
                    continue;
                }
                if ($sharedNotebook->guid === $notebook_guid) {
                    return $sharedNotebook;
                }
            }

            return null;
        }
    }

    protected function getNoteInstance(\EDAM\Types\Note $edamNote = null, $noteStore = null, $token = null)
    {
        $note = new Note($edamNote);

        $note->authToken = $token;

        $note->noteStore = $noteStore;

        return $note;
    }

    protected function getShardIdFromToken($token)
    {
        $result = preg_match('/:?S=(s[0-9]+):?/', $token, $matches);

        if ($result === 1 && array_key_exists(1, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     *  Only used if specifying an explicit notebook instead.
     */
    const SEARCH_SCOPE_NONE            = 0;
    /**
     *  Search among all personal notebooks.
     */
    const SEARCH_SCOPE_PERSONAL        = 1; // 1 << 0
    /**
     *  Search among all notebooks shared to the user by others.
     */
    const SEARCH_SCOPE_PERSONAL_LINKED = 2; // 1 << 1
    /**
     *  Search among all business notebooks the user has joined.
     */
    const SEARCH_SCOPE_BUSINESS        = 4; // 1 << 2

    /**
     *  Use this if your app uses an "App Notebook". (any other set flags will be ignored.)
     */
    const SEARCH_SCOPE_APP_NOTEBOOK    = 8; // 1 << 3

    // Default search is among personal notebooks only; typical and most performant scope.
    const SEARCH_SCOPE_DEFAULT         = 1; // SEARCH_SCOPE_PERSONAL

    // Search everything this user can see. PERFORMANCE NOTE: This can be very expensive and result in many roundtrips if the
    // user is a member of a business and/or has many linked notebooks.
    const SEARCH_SCOPE_ALL             = 7; // SEARCH_SCOPE_PERSONAL | SEARCH_SCOPE_PERSONAL_LINKED | SEARCH_SCOPE_BUSINESS

    // The following options address the kind of sort that should be used.

    /**
     *  Case-insensitive order by title.
     */
    const SORT_ORDER_TITLE            = 1; // 1 << 0
    /**
     *  Most recently created first.
     */
    const SORT_ORDER_RECENTLY_CREATED = 2; // 1 << 1
    /**
     *  Most recently updated first.
     */
    const SORT_ORDER_RECENTLY_UPDATED = 4; // 1 << 2
    /**
     *  Most relevant first. NB only valid when using a single search scope.
     */
    const SORT_ORDER_RELEVANCE        = 8; // 1 << 3

    // The following options address the ordering of the sort.

    /**
     *  Default order (no flag).
     */
    const SORT_ORDER_NORMAL  = 0; // 0 << 16
    /**
     *  Reverse order.
     */
    const SORT_ORDER_REVERSE = 65536; // 1 << 16

    const BUSINESS_NOTE = 0;

    const PERSONAL_NOTE = 1;

    const SHARED_NOTE   = 2;

    protected function isFlagSet($flags, $flag)
    {
        return !!(($flags) & ($flag));
    }

    protected $findNotesContext;

    public function findNotesWithSearch($noteSearch, Notebook $notebook = null, $scope = 0, $sortOrder = 0, $maxResults = 20)
    {
        if (!$noteSearch instanceof Search) {
            $noteSearch = new Search($noteSearch);
        }

        // App notebook scope is internally just an "all" search, because we don't a priori know where the app
        // notebook is. There's some room for a fast path in this flow if we have a saved linked record to a
        // linked app notebook, but that case is likely rare enough to prevent complexifying this code for.
        if ($this->isFlagSet($scope, self::SEARCH_SCOPE_APP_NOTEBOOK)) {
            $scope = self::SEARCH_SCOPE_ALL;
        }

        // Validate the scope and sort arguments.
        if (null !== $notebook && $scope != self::SEARCH_SCOPE_NONE) {
            $scope = self::SEARCH_SCOPE_NONE;
        } elseif (null === $notebook && $scope == self::SEARCH_SCOPE_NONE) {
            $scope = self::SEARCH_SCOPE_DEFAULT;
        }

        $requiresLocalMerge = false;
        if ($scope != self::SEARCH_SCOPE_NONE) {
            // Check for multiple scopes. Because linked scope can subsume multiple linked notebooks, that *always* triggers
            // the multiple scopes. If not, then both personal and business must be set together.
            if (($this->isFlagSet($scope, self::SEARCH_SCOPE_PERSONAL) && $this->isFlagSet($scope, self::SEARCH_SCOPE_BUSINESS)) ||
                $this->isFlagSet($scope, self::SEARCH_SCOPE_PERSONAL_LINKED)) {
                // If we're asked for multiple scopes, relevance is not longer supportable (since we
                // don't know how to combine relevance on the client), so default to updated date,
                // which is probably the closest proxy to relevance.
                if ($this->isFlagSet($sortOrder, self::SORT_ORDER_RELEVANCE)) {
                    $sortOrder = self::SORT_ORDER_RECENTLY_UPDATED;
                }
                $requiresLocalMerge = true;
            }
        }

        $resultSpec                           = new NotesMetadataResultSpec();
        $resultSpec->includeNotebookGuid      = true;
        $resultSpec->includeTitle             = true;
        $resultSpec->includeCreated           = true;
        $resultSpec->includeUpdated           = true;
        $resultSpec->includeUpdateSequenceNum = true;

        $noteFilter = new NoteFilter();
        $noteFilter->words = $noteSearch->getSearchString();

        if ($this->isFlagSet($sortOrder, self::SORT_ORDER_TITLE)) {
            $noteFilter->order = NoteSortOrder::TITLE;
        } elseif ($this->isFlagSet($sortOrder, self::SORT_ORDER_RECENTLY_CREATED)) {
            $noteFilter->order = NoteSortOrder::CREATED;
        } elseif ($this->isFlagSet($sortOrder, self::SORT_ORDER_RECENTLY_UPDATED)) {
            $noteFilter->order = NoteSortOrder::UPDATED;
        } elseif ($this->isFlagSet($sortOrder, self::SORT_ORDER_RELEVANCE)) {
            $noteFilter->order = NoteSortOrder::RELEVANCE;
        }

        // "Normal" sort is ascending for titles, and descending for dates and relevance.
        $sortAscending = $this->isFlagSet($sortOrder, self::SORT_ORDER_TITLE);

        if ($this->isFlagSet($sortOrder, self::SORT_ORDER_REVERSE)) {
            $sortAscending = !$sortAscending;
        }

        $noteFilter->ascending = $sortAscending;

        if (null !== $notebook) {
            $noteFilter->notebookGuid = $notebook->guid;
        }

        // Set up context.
        $context = new \stdClass();
        $context->scopeNotebook       = $notebook;
        $context->scope               = $scope;
        $context->sortOrder           = $sortOrder;
        $context->noteFilter          = $noteFilter;
        $context->resultSpec          = $resultSpec;
        $context->maxResults          = $maxResults;
        $context->findMetadataResults = array();
        $context->requiresLocalMerge  = $requiresLocalMerge;
        $context->sortAscending       = $sortAscending;

        // If we have a scope notebook, we already know what notebook the results will appear in.
        // If we don't have a scope notebook, then we need to query for all the notebooks to determine
        // where to search.
        if (null === $context->scopeNotebook) {
            return $this->findNotes_listNotebooksWithContext($context);
        }

        // Go directly to the next step.
        return $this->findNotes_findInPersonalScopeWithContext($context);
    }

    protected function findNotes_listNotebooksWithContext($context)
    {
        
        // XXX: We do the full listNotebooks operation here, which is overkill in all situations,
        // and could wind us up doing a bunch of extra work. Optimization is to only look at -listNotebooks
        // if we're personal scope, and -listLinkedNotebooks for linked and business, without ever
        // authenticating to other note stores.
        $notebooks = $this->listNotebooks();

        if ($notebooks) {
            $context->allNotebooks = $notebooks;
            return $this->findNotes_findInPersonalScopeWithContext($context);
        } else {
            // TODO : handle error
        }
    }

    protected function findNotes_findInPersonalScopeWithContext($context)
    {
        $skipPersonalScope = false;

        // Skip the personal scope if the scope notebook isn't personal, or if the scope
        // flag doesn't include personal.
        if ($context->scopeNotebook) {
            // If the scope notebook isn't personal, skip personal.
            if ($context->scopeNotebook->isLinked()) {
                $skipPersonalScope = true;
            }
        } else if (!$this->isFlagSet($context->scope, self::SEARCH_SCOPE_PERSONAL)) {
            // If the caller didn't request personal scope.
            $skipPersonalScope = true;
        }
        // TODO : handle linked app notebook
//        else if ([self appNotebookIsLinked]) {
//        // If we know this is an app notebook scoped app, and we know the app notebook is not personal.
//        $skipPersonalScope = true;
//        }

        // If we're skipping personal scope, proceed directly to busines scope.
        if (true === $skipPersonalScope) {
            return $this->findNotes_findInBusinessScopeWithContext($context);
        }

        $notesMetadataList = $this->getUserNotestore()->findNotesMetadata(
            $this->token,
            $context->noteFilter,
            0,
            $context->maxResults,
            $context->resultSpec
        );

        foreach ($notesMetadataList->notes as $notesMetadata) {
            $context->findMetadataResults[] = $notesMetadata;
        }

        return $this->findNotes_findInBusinessScopeWithContext($context);
    }

    protected function findNotes_findInBusinessScopeWithContext($context)
    {
        
        // Skip the business scope if the user is not a business user, or the scope notebook
        // is not a business notebook, or the business scope is not included.
        if (false === $this->isBusinessUser() ||
            ($context->scopeNotebook && !$context->scopeNotebook->isBusinessNotebook()) ||
            (!$context->scopeNotebook && !$this->isFlagSet($context->scope, self::SEARCH_SCOPE_BUSINESS))
        ) {
            return $this->findNotes_findInLinkedScopeWithContext($context);
        }

        $notesMetadataList = $this->getBusinessNoteStore()->findNotesMetadata(
            $this->getBusinessToken(),
            $context->noteFilter,
            0,
            $context->maxResults,
            $context->resultSpec
        );

        foreach ($notesMetadataList->notes as $notesMetadata) {
            $context->findMetadataResults[] = $notesMetadata;
        }

        // Remember which note guids came from the business. We'll use this later to
        // determine if we're worried about an inability to map back to notebooks.
        $context->resultGuidsFromBusiness = array();
        foreach ($notesMetadataList->notes as $noteMetadata) {
            $context->resultGuidsFromBusiness[] = $noteMetadata->guid;
        }

        return $this->findNotes_findInLinkedScopeWithContext($context);
        //TODO:
        // This is a business user, but apparently has an app notebook restriction that's
        // not in the business. Go look in linked scope.
    }

    protected function findNotes_findInLinkedScopeWithContext($context)
    {
        
        // Skip linked scope if scope notebook is not a personal linked notebook, or if the
        // linked scope is not included.
        if ($context->scopeNotebook) {
            if (!$context->scopeNotebook->isLinked() || !$context->scopeNotebook->isBusinessNotebook()) {
                return $this->findNotes_processResultsWithContext($context);
            }
        } elseif (!$this->isFlagSet($context->scope, self::SEARCH_SCOPE_PERSONAL_LINKED)) {
            return $this->findNotes_processResultsWithContext($context);
        }

        // Build a list of all the linked notebooks that we need to run the search against.
        $context->linkedNotebooksToSearch = array();
        if ($context->scopeNotebook) {
            $context->linkedNotebooksToSearch[] = $context->scopeNotebook;
        } else {
            foreach ($context->allNotebooks as $notebook) {
                if ($notebook->isLinked() && !$notebook->isBusinessNotebook()) {
                    $context->linkedNotebooksToSearch[] = $notebook;
                }
            }
        }

        $this->findNotes_nextFindInLinkedScopeWithContext($context);
    }

    protected function findNotes_nextFindInLinkedScopeWithContext($context)
    {
        
        if (count($context->linkedNotebooksToSearch) == 0) {
            $this->findNotes_processResultsWithContext($context);
            return;
        }

        // Pull the first notebook off the list of pending linked notebooks.
        $linkedNotebook = array_shift($context->linkedNotebooksToSearch);


        $noteStore = $this->getNotestore($linkedNotebook->noteStoreUrl);
        $authToken = $this->getSharedNotebookAuthResult($linkedNotebook)->authenticationToken;

        $notesMetadataList = $noteStore->findNotesMetadata(
            $authToken,
            $context->noteFilter,
            0,
            $context->maxResults,
            $context->resultSpec
        );

        foreach ($notesMetadataList->notes as $notesMetadata) {
            $context->findMetadataResults[] = $notesMetadata;
        }

        $this->findNotes_nextFindInLinkedScopeWithContext($context);

        $this->findNotes_processResultsWithContext($context);
    }

    protected function compareByTitle($obj1, $obj2)
    {
        return strcmp($obj1->title, $obj2->title);
    }

    protected function compareByCreated($obj1, $obj2)
    {
        return strcmp($obj1->created, $obj2->created);
    }

    protected function compareByUpdated($obj1, $obj2)
    {
        return strcmp($obj1->updated, $obj2->updated);
    }

    protected function findNotes_processResultsWithContext($context)
    {
        // OK, now we have a complete list of note refs objects. If we need to do a local sort, then do so.
        if ($context->requiresLocalMerge) {
            if ($this->isFlagSet($context->sortOrder, self::SORT_ORDER_RECENTLY_CREATED)) {
                return usort($context->findMetadataResults, array($this, 'compareByCreated'));
            } elseif ($this->isFlagSet($context->sortOrder, self::SORT_ORDER_RECENTLY_UPDATED)) {
                return usort($context->findMetadataResults, array($this, 'compareByUpdated'));
            } else {
                return usort($context->findMetadataResults, array($this, 'compareByTitle'));
            }
        }

        // Prepare a dictionary of all notebooks by GUID so lookup below is fast.
        $notebooksByGuid = array();
        if (!$context->scopeNotebook) {
            foreach ($context->allNotebooks as $notebook) {
                $notebooksByGuid[$notebook->guid] = $notebook;
            }
        }

        $findNotesResults = array();

        // Turn the metadata list into a list of note refs.
        foreach ($context->findMetadataResults as $metadata) {
            $result       = new SearchResult();
            $result->guid = $metadata->guid;

            // Figure out which notebook this note belongs to. (If there's a scope notebook, it always belongs to that one.)
            $notebook = $context->scopeNotebook ?: $notebooksByGuid[$metadata->notebookGuid];

            if (!$notebook) {
                // This is probably a business notebook that we haven't explicitly joined, so we don't have it in our list.
                if (!array_key_exists($metadata->guid, $context->resultGuidsFromBusiness)) {
                    //TODO
                    // Oh, it's not from the business. We really can't find it. This is an error.
                    //ENSDKLogError(@"Found note metadata but can't determine owning notebook by guid. Metadata = %@", metadata);
                }
                continue;
            }

            if ($notebook->isBusinessNotebook()) {
                $result->type = self::BUSINESS_NOTE;
            } elseif ($notebook->isLinkedNotebook()) {
                $result->type = self::SHARED_NOTE;
            } else {
                $result->type = self::PERSONAL_NOTE;
            }

            //$result->notebook          = $notebook;
            $result->title             = $metadata->title;
            $result->created           = $metadata->created;
            $result->updated           = $metadata->updated;
            $result->updateSequenceNum = $metadata->updateSequenceNum;

            $findNotesResults[] = $result;

            // If the caller specified a max result count, and we've reached it, then stop fixing up
            // results here.
            if ($context->maxResults > 0 && count($findNotesResults) >= $context->maxResults) {
                break;
            }
        }

        return $findNotesResults;
    }
}