<?php

namespace CommunityCRM\Search;

abstract class BaseSearchResultProvider
{
    /* @var string */
    protected $pluralNoun;
    /* @var CommunityCRM\Search\SearchResult[] */
    protected $searchResults = [];

    abstract public function getSearchResults(string $SearchQuery);

    protected function formatSearchGroup()
    {
        if (!empty($this->searchResults)) {
            return new SearchResultGroup(gettext($this->pluralNoun) . ' (' . count($this->searchResults) . ')', $this->searchResults);
        }

        return [];
    }

    protected function addSearchResults(array $results)
    {
        $this->searchResults = array_merge($this->searchResults, $results);
    }

    protected function __construct()
    {
    }
}
