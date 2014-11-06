<?php

namespace Evernote\Model;

class Search 
{
    protected $searchString;

    public function __construct($searchString)
    {
        $this->searchString = $searchString;
    }

    /**
     * @return mixed
     */
    public function getSearchString()
    {
        return $this->searchString;
    }


} 