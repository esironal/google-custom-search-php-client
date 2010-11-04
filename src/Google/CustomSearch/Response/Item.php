<?php

require_once(dirname(__FILE__).'/Data/DataAbstract.php');
require_once(dirname(__FILE__).'/Item/PageMap.php');

/**
 * Google_CustomSearch_Response_Item parses and defines a "item" in the API response
 *
 * @author Stephen Melrose <me@stephenmelrose.co.uk>
 */
class Google_CustomSearch_Response_Item extends Google_CustomSearch_Response_DataAbstract
{
    // ------------------------------------------------------
    // Constants
    // ------------------------------------------------------

    const KIND = 'customsearch#result';

    // ------------------------------------------------------
    // Properties
    // ------------------------------------------------------

    /**
     * @var string
     */
    protected $displayLink;

    /**
     * @var string
     */
    protected $htmlSnippet;

    /**
     * @var string
     */
    protected $htmlTitle;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var Google_CustomSearch_Response_Item_PageMap
     */
    protected $pagemap;

    /**
     * @var string
     */
    protected $snippet;

    /**
     * @var string
     */
    protected $title;

    // ------------------------------------------------------
    // Methods
    // ------------------------------------------------------

    /**
     * Parses the raw result data for validity and then into formatted data
     *
     * @param stdClass $resultData
     */
    protected function parse(stdClass $resultData)
    {
        if (!isset($resultData->kind) || $resultData->kind != self::KIND)
        {
            throw new RuntimeException(sprintf('Invalid or missing response item kind, expected "%s".', self::KIND));
        }

        $this->parseStandardProperties($resultData, array(
            'displayLink',
            'htmlSnippet',
            'htmlTitle',
            'link',
            'pagemap',
            'snippet',
            'title'
        ));
        
        $pagemap = self::getPropertyFromResponseData('pagemap', $resultData);
        if ($pagemap instanceof stdClass)
        {
            $pagemap = new Google_CustomSearch_Response_Item_PageMap($pagemap);
            if ($pagemap->hasDataObjects())
            {
                $this->pagemap = $pagemap;
            }
        }
    }

    // ------------------------------------------------------
    // Getters
    // ------------------------------------------------------

    /**
     * Gets an abridged version of this search result's URL, e.g. www.example.com.
     *
     * @return string
     */
    public function getDisplayLink()
    {
        return $this->displayLink;
    }

    /**
     * Gets the snippet of the search result, in HTML.
     *
     * @return string
     */
    public function getHtmlSnippet()
    {
        return $this->htmlSnippet;
    }

    /**
     * Gets the title of the search result, in HTML.
     *
     * @return string
     */
    public function getHtmlTitle()
    {
        return $this->htmlTitle;
    }

    /**
     * Gets the full URL to which the search result is
     * pointing, e.g. http://www.example.com/foo/bar.
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Gets the pagemap for this search result.
     *
     * @return Google_CustomSearch_Response_Item_PageMap
     * @see https://code.google.com/apis/customsearch/docs/snippets.html#pagemaps
     */
    public function getPagemap()
    {
        return $this->pagemap;
    }

    /**
     * Gets the snippet of the search result, in plain text.
     *
     * @return string
     */
    public function getSnippet()
    {
        return $this->snippet;
    }

    /**
     * Gets the title of the search result, in plain text.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}