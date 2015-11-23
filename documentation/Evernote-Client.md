Evernote\Client
===============






* Class name: Client
* Namespace: Evernote



Constants
----------


### PERSONAL_SCOPE

    const PERSONAL_SCOPE = 1





### LINKED_SCOPE

    const LINKED_SCOPE = 2





### SEARCH_SCOPE_NONE

    const SEARCH_SCOPE_NONE = 0





### SEARCH_SCOPE_PERSONAL

    const SEARCH_SCOPE_PERSONAL = 1





### SEARCH_SCOPE_PERSONAL_LINKED

    const SEARCH_SCOPE_PERSONAL_LINKED = 2





### SEARCH_SCOPE_BUSINESS

    const SEARCH_SCOPE_BUSINESS = 4





### SEARCH_SCOPE_APP_NOTEBOOK

    const SEARCH_SCOPE_APP_NOTEBOOK = 8





### SEARCH_SCOPE_DEFAULT

    const SEARCH_SCOPE_DEFAULT = 1





### SEARCH_SCOPE_ALL

    const SEARCH_SCOPE_ALL = 7





### SORT_ORDER_TITLE

    const SORT_ORDER_TITLE = 1





### SORT_ORDER_RECENTLY_CREATED

    const SORT_ORDER_RECENTLY_CREATED = 2





### SORT_ORDER_RECENTLY_UPDATED

    const SORT_ORDER_RECENTLY_UPDATED = 4





### SORT_ORDER_RELEVANCE

    const SORT_ORDER_RELEVANCE = 8





### SORT_ORDER_NORMAL

    const SORT_ORDER_NORMAL = 0





### SORT_ORDER_REVERSE

    const SORT_ORDER_REVERSE = 65536





### BUSINESS_NOTE

    const BUSINESS_NOTE = 0





### PERSONAL_NOTE

    const PERSONAL_NOTE = 1





### SHARED_NOTE

    const SHARED_NOTE = 2





Properties
----------


### $advancedClient

    protected \Evernote\AdvancedClient $advancedClient





* Visibility: **protected**


### $token

    protected string $token





* Visibility: **protected**


### $sandbox

    protected boolean $sandbox





* Visibility: **protected**



### $china

    protected boolean $china





* Visibility: **protected**



### $userNoteStore

    protected \EDAM\NoteStore\NoteStoreClient $userNoteStore





* Visibility: **protected**


### $businessNoteStore

    protected \EDAM\NoteStore\NoteStoreClient $businessNoteStore





* Visibility: **protected**


### $businessToken

    protected string $businessToken





* Visibility: **protected**


### $user

    protected \EDAM\Types\User $user





* Visibility: **protected**


### $businessAuth

    protected \EDAM\UserStore\AuthenticationResult $businessAuth





* Visibility: **protected**


Methods
-------


### __construct

    mixed Evernote\Client::__construct(string|null $token, boolean $sandbox, \Evernote\AdvancedClient|null $advancedClient, \Psr\Log\LoggerInterface|null $logger, boolean $china)





* Visibility: **public**


#### Arguments
* $token **string|null**
* $sandbox **boolean**
* $advancedClient **Evernote\AdvancedClient|null**
* $logger **Psr\Log\LoggerInterface|null**
* $china **boolean**



### getUser

    \EDAM\Types\User Evernote\Client::getUser()

Returns the User corresponding to the provided authentication token



* Visibility: **public**




### isBusinessUser

    boolean Evernote\Client::isBusinessUser()

Returns a boolean indicating if the user has a business account



* Visibility: **public**




### getBusinessToken

    string Evernote\Client::getBusinessToken()

Returns the token used to access the business notestore



* Visibility: **public**




### getBusinessNoteStore

    \EDAM\NoteStore\NoteStoreClient|mixed Evernote\Client::getBusinessNoteStore()

Returns the business notestore



* Visibility: **public**




### getBusinessSharedNotebooks

    null Evernote\Client::getBusinessSharedNotebooks()

Returns the list of notebooks shared by the user with her business account



* Visibility: **public**




### getBusinessLinkedNotebooks

    array Evernote\Client::getBusinessLinkedNotebooks()

Returns the list of notebooks shared to the user through the business account



* Visibility: **public**




### listNotebooks

    array Evernote\Client::listNotebooks()

Returns the list of notebooks



* Visibility: **public**




### listPersonalNotebooks

    array Evernote\Client::listPersonalNotebooks()

Returns the list of personal notebooks



* Visibility: **public**




### listSharedNotebooks

    array Evernote\Client::listSharedNotebooks()

Returns the list of notebooks shared by the user



* Visibility: **public**




### listLinkedNotebooks

    array Evernote\Client::listLinkedNotebooks()

Returns the list of notebooks shared to the user



* Visibility: **public**




### getUserNotestore

    \EDAM\NoteStore\NoteStoreClient|mixed Evernote\Client::getUserNotestore()

Returns the personal notestore of the user



* Visibility: **public**




### replaceNote

    \Evernote\Model\Note Evernote\Client::replaceNote(\Evernote\Model\Note $noteToReplace, \Evernote\Model\Note $note)

Replaces an existing note by another one (new or existing)



* Visibility: **public**


#### Arguments
* $noteToReplace **Evernote\Model\Note**
* $note **Evernote\Model\Note**



### uploadNote

    \Evernote\Model\Note Evernote\Client::uploadNote(\Evernote\Model\Note $note, \Evernote\Model\Notebook $notebook)

Sends a new Note to the API



* Visibility: **public**


#### Arguments
* $note **Evernote\Model\Note**
* $notebook **Evernote\Model\Notebook**



### deleteNote

    boolean Evernote\Client::deleteNote(\Evernote\Model\Note $note)

Deletes a note



* Visibility: **public**


#### Arguments
* $note **Evernote\Model\Note**



### shareNote

    null|string Evernote\Client::shareNote(\Evernote\Model\Note $note)

Shares a note and returns the share url



* Visibility: **public**


#### Arguments
* $note **Evernote\Model\Note**



### moveNote

    \Evernote\Model\Note Evernote\Client::moveNote(\Evernote\Model\Note $note, \Evernote\Model\Notebook $notebook)

Moves a note to another notebook



* Visibility: **public**


#### Arguments
* $note **Evernote\Model\Note**
* $notebook **Evernote\Model\Notebook**



### getNote

    \Evernote\Model\Note|null Evernote\Client::getNote($guid, null $scope)

Retrieves an existing note



* Visibility: **public**


#### Arguments
* $guid **mixed**
* $scope **null**



### isAppNotebookToken

    boolean Evernote\Client::isAppNotebookToken($token)

Checks if the token is an "app notebook" one



* Visibility: **public**


#### Arguments
* $token **mixed**



### getNotebook

    \Evernote\Model\Notebook|null Evernote\Client::getNotebook($notebook_guid, null $scope)

Retrieves a notebook



* Visibility: **public**


#### Arguments
* $notebook_guid **mixed**
* $scope **null**



### findNotesWithSearch

    array|boolean Evernote\Client::findNotesWithSearch($noteSearch, \Evernote\Model\Notebook $notebook, integer $scope, integer $sortOrder, integer $maxResults)

Searches for notes



* Visibility: **public**


#### Arguments
* $noteSearch **mixed**
* $notebook **Evernote\Model\Notebook**
* $scope **integer**
* $sortOrder **integer**
* $maxResults **integer**



### setAdvancedClient

    mixed Evernote\Client::setAdvancedClient(\Evernote\AdvancedClient $advancedClient)

Sets the advancedClient



* Visibility: **public**


#### Arguments
* $advancedClient **Evernote\AdvancedClient**



### getAdvancedClient

    \Evernote\AdvancedClient Evernote\Client::getAdvancedClient()

Returns the advancedClient



* Visibility: **public**




### setSandbox

    mixed Evernote\Client::setSandbox(boolean $sandbox)

Sets the sandbox flag to true or false



* Visibility: **public**


#### Arguments
* $sandbox **boolean**



### getSandbox

    boolean Evernote\Client::getSandbox()

Gets the current sandbox flag



* Visibility: **public**




### setChina

    mixed Evernote\Client::setChina(boolean $china)

Sets the china flag to true or false



* Visibility: **public**


#### Arguments
* $china **boolean**



### getChina

    boolean Evernote\Client::getChina()

Gets the current china flag



* Visibility: **public**





### setToken

    mixed Evernote\Client::setToken(string $token)

Sets the authentication token



* Visibility: **public**


#### Arguments
* $token **string**



### getToken

    string Evernote\Client::getToken()

Returns the current authentication token



* Visibility: **public**




### getNoteStore

    mixed Evernote\Client::getNoteStore($noteStoreUrl)





* Visibility: **protected**


#### Arguments
* $noteStoreUrl **mixed**



### getShareUrl

    mixed Evernote\Client::getShareUrl($guid, $shardId, $shareKey, $serviceHost)





* Visibility: **protected**


#### Arguments
* $guid **mixed**
* $shardId **mixed**
* $shareKey **mixed**
* $serviceHost **mixed**



### getSharedNotebookAuthResult

    mixed Evernote\Client::getSharedNotebookAuthResult(\EDAM\Types\LinkedNotebook $linkedNotebook)





* Visibility: **protected**


#### Arguments
* $linkedNotebook **EDAM\Types\LinkedNotebook**



### getNoteBookByLinkedNotebook

    mixed Evernote\Client::getNoteBookByLinkedNotebook(\EDAM\Types\LinkedNotebook $linkedNotebook)





* Visibility: **protected**


#### Arguments
* $linkedNotebook **EDAM\Types\LinkedNotebook**



### getBusinessAuth

    \EDAM\UserStore\AuthenticationResult Evernote\Client::getBusinessAuth()





* Visibility: **protected**




### getNoteInstance

    mixed Evernote\Client::getNoteInstance(\EDAM\Types\Note $edamNote, $noteStore, $token)





* Visibility: **protected**


#### Arguments
* $edamNote **EDAM\Types\Note**
* $noteStore **mixed**
* $token **mixed**



### getShardIdFromToken

    mixed Evernote\Client::getShardIdFromToken($token)





* Visibility: **protected**


#### Arguments
* $token **mixed**



### isFlagSet

    mixed Evernote\Client::isFlagSet($flags, $flag)





* Visibility: **protected**


#### Arguments
* $flags **mixed**
* $flag **mixed**



### findNotes_listNotebooksWithContext

    mixed Evernote\Client::findNotes_listNotebooksWithContext($context)





* Visibility: **protected**


#### Arguments
* $context **mixed**



### findNotes_findInPersonalScopeWithContext

    mixed Evernote\Client::findNotes_findInPersonalScopeWithContext($context)





* Visibility: **protected**


#### Arguments
* $context **mixed**



### findNotes_findInBusinessScopeWithContext

    mixed Evernote\Client::findNotes_findInBusinessScopeWithContext($context)





* Visibility: **protected**


#### Arguments
* $context **mixed**



### findNotes_findInLinkedScopeWithContext

    mixed Evernote\Client::findNotes_findInLinkedScopeWithContext($context)





* Visibility: **protected**


#### Arguments
* $context **mixed**



### findNotes_nextFindInLinkedScopeWithContext

    mixed Evernote\Client::findNotes_nextFindInLinkedScopeWithContext($context)





* Visibility: **protected**


#### Arguments
* $context **mixed**



### compareByTitle

    mixed Evernote\Client::compareByTitle($obj1, $obj2)





* Visibility: **protected**


#### Arguments
* $obj1 **mixed**
* $obj2 **mixed**



### compareByCreated

    mixed Evernote\Client::compareByCreated($obj1, $obj2)





* Visibility: **protected**


#### Arguments
* $obj1 **mixed**
* $obj2 **mixed**



### compareByUpdated

    mixed Evernote\Client::compareByUpdated($obj1, $obj2)





* Visibility: **protected**


#### Arguments
* $obj1 **mixed**
* $obj2 **mixed**



### findNotes_processResultsWithContext

    mixed Evernote\Client::findNotes_processResultsWithContext($context)





* Visibility: **protected**


#### Arguments
* $context **mixed**


