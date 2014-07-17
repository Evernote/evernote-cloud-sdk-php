<?php


namespace EDAM\NoteStore;


interface NoteStoreIf {
    public function getSyncState($authenticationToken);
    public function getSyncStateWithMetrics($authenticationToken, \EDAM\NoteStore\ClientUsageMetrics $clientMetrics);
    public function getSyncChunk($authenticationToken, $afterUSN, $maxEntries, $fullSyncOnly);
    public function getFilteredSyncChunk($authenticationToken, $afterUSN, $maxEntries, \EDAM\NoteStore\SyncChunkFilter $filter);
    public function getLinkedNotebookSyncState($authenticationToken, \EDAM\Types\LinkedNotebook $linkedNotebook);
    public function getLinkedNotebookSyncChunk($authenticationToken, \EDAM\Types\LinkedNotebook $linkedNotebook, $afterUSN, $maxEntries, $fullSyncOnly);
    public function listNotebooks($authenticationToken);
    public function getNotebook($authenticationToken, $guid);
    public function getDefaultNotebook($authenticationToken);
    public function createNotebook($authenticationToken, \EDAM\Types\Notebook $notebook);
    public function updateNotebook($authenticationToken, \EDAM\Types\Notebook $notebook);
    public function expungeNotebook($authenticationToken, $guid);
    public function listTags($authenticationToken);
    public function listTagsByNotebook($authenticationToken, $notebookGuid);
    public function getTag($authenticationToken, $guid);
    public function createTag($authenticationToken, \EDAM\Types\Tag $tag);
    public function updateTag($authenticationToken, \EDAM\Types\Tag $tag);
    public function untagAll($authenticationToken, $guid);
    public function expungeTag($authenticationToken, $guid);
    public function listSearches($authenticationToken);
    public function getSearch($authenticationToken, $guid);
    public function createSearch($authenticationToken, \EDAM\Types\SavedSearch $search);
    public function updateSearch($authenticationToken, \EDAM\Types\SavedSearch $search);
    public function expungeSearch($authenticationToken, $guid);
    public function findNotes($authenticationToken, \EDAM\NoteStore\NoteFilter $filter, $offset, $maxNotes);
    public function findNoteOffset($authenticationToken, \EDAM\NoteStore\NoteFilter $filter, $guid);
    public function findNotesMetadata($authenticationToken, \EDAM\NoteStore\NoteFilter $filter, $offset, $maxNotes, \EDAM\NoteStore\NotesMetadataResultSpec $resultSpec);
    public function findNoteCounts($authenticationToken, \EDAM\NoteStore\NoteFilter $filter, $withTrash);
    public function getNote($authenticationToken, $guid, $withContent, $withResourcesData, $withResourcesRecognition, $withResourcesAlternateData);
    public function getNoteApplicationData($authenticationToken, $guid);
    public function getNoteApplicationDataEntry($authenticationToken, $guid, $key);
    public function setNoteApplicationDataEntry($authenticationToken, $guid, $key, $value);
    public function unsetNoteApplicationDataEntry($authenticationToken, $guid, $key);
    public function getNoteContent($authenticationToken, $guid);
    public function getNoteSearchText($authenticationToken, $guid, $noteOnly, $tokenizeForIndexing);
    public function getResourceSearchText($authenticationToken, $guid);
    public function getNoteTagNames($authenticationToken, $guid);
    public function createNote($authenticationToken, \EDAM\Types\Note $note);
    public function updateNote($authenticationToken, \EDAM\Types\Note $note);
    public function deleteNote($authenticationToken, $guid);
    public function expungeNote($authenticationToken, $guid);
    public function expungeNotes($authenticationToken, $noteGuids);
    public function expungeInactiveNotes($authenticationToken);
    public function copyNote($authenticationToken, $noteGuid, $toNotebookGuid);
    public function listNoteVersions($authenticationToken, $noteGuid);
    public function getNoteVersion($authenticationToken, $noteGuid, $updateSequenceNum, $withResourcesData, $withResourcesRecognition, $withResourcesAlternateData);
    public function getResource($authenticationToken, $guid, $withData, $withRecognition, $withAttributes, $withAlternateData);
    public function getResourceApplicationData($authenticationToken, $guid);
    public function getResourceApplicationDataEntry($authenticationToken, $guid, $key);
    public function setResourceApplicationDataEntry($authenticationToken, $guid, $key, $value);
    public function unsetResourceApplicationDataEntry($authenticationToken, $guid, $key);
    public function updateResource($authenticationToken, \EDAM\Types\Resource $resource);
    public function getResourceData($authenticationToken, $guid);
    public function getResourceByHash($authenticationToken, $noteGuid, $contentHash, $withData, $withRecognition, $withAlternateData);
    public function getResourceRecognition($authenticationToken, $guid);
    public function getResourceAlternateData($authenticationToken, $guid);
    public function getResourceAttributes($authenticationToken, $guid);
    public function getPublicNotebook($userId, $publicUri);
    public function createSharedNotebook($authenticationToken, \EDAM\Types\SharedNotebook $sharedNotebook);
    public function updateSharedNotebook($authenticationToken, \EDAM\Types\SharedNotebook $sharedNotebook);
    public function setSharedNotebookRecipientSettings($authenticationToken, $sharedNotebookId, \EDAM\Types\SharedNotebookRecipientSettings $recipientSettings);
    public function sendMessageToSharedNotebookMembers($authenticationToken, $notebookGuid, $messageText, $recipients);
    public function listSharedNotebooks($authenticationToken);
    public function expungeSharedNotebooks($authenticationToken, $sharedNotebookIds);
    public function createLinkedNotebook($authenticationToken, \EDAM\Types\LinkedNotebook $linkedNotebook);
    public function updateLinkedNotebook($authenticationToken, \EDAM\Types\LinkedNotebook $linkedNotebook);
    public function listLinkedNotebooks($authenticationToken);
    public function expungeLinkedNotebook($authenticationToken, $guid);
    public function authenticateToSharedNotebook($shareKey, $authenticationToken);
    public function getSharedNotebookByAuth($authenticationToken);
    public function emailNote($authenticationToken, \EDAM\NoteStore\NoteEmailParameters $parameters);
    public function shareNote($authenticationToken, $guid);
    public function stopSharingNote($authenticationToken, $guid);
    public function authenticateToSharedNote($guid, $noteKey, $authenticationToken);
    public function findRelated($authenticationToken, \EDAM\NoteStore\RelatedQuery $query, \EDAM\NoteStore\RelatedResultSpec $resultSpec);
}

