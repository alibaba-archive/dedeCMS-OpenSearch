<?php

/**
 * Class OpensearchOptionValues help to get the opensearch options
 */
class OpensearchOptionValues
{
    private $alloptions;

    /**
     * Indicates vailidate status
     * @var bool
     */
    public $isValid;

    /**
     * Search index
     * @var string
     */
    public $index;

    /**
     * Construct
     */
    public function __construct()
    {
        global $dsql;
        $row = $dsql->GetOne('SELECT * FROM `opensearch_for_dedecms`');

        if (empty($row)) {
            $this->isValid = false;
            return;
        }

        $this->isValid = true;
        $this->alloptions = json_decode($row["options"]);

        $this->debug = (defined("DebugMode") && constant("DebugMode") === true);
    }

    /**
     * Get current access key id
     * @return string
     */
    public function getAccessKey()
    {
        return $this->getFromOption("accesskey");
    }

    /**
     * Get current access key secret
     * @return string
     */
    public function getSecret()
    {
        return $this->getFromOption("secret");
    }

    /**
     * Get current app name
     * @return string
     */
    public function getAppName()
    {
        return $this->getFromOption("appname");
    }

    /**
     * Get current service host
     * @return string
     */
    public function getHost()
    {
        return $this->getFromOption("host");
    }

    /**
     * Get current index names
     * @return string
     */
    public function getIndexes()
    {
        return !isset($this->index) || $this->index === "" ? "default" : $this->index;
    }

    /**
     * Get current index name array
     * @return array|null
     */
    public function getIndexeArr()
    {
        $vals = $this->getIndexes();
        return $vals === "" ? null : explode("|", $vals);
    }

    /**
     * Get searchable post type names
     * @return string
     */
    public function getSearchablePostTypes()
    {
        return $this->getFromOption("ali_opensearch_posttypes");
    }

    /**
     * Get searchable post type name array
     * @return array|null
     */
    public function getSearchablePostTypeArr()
    {
        if (!isset($this->alloptions["ali_opensearch_posttypes"])) {
            return array("post", "page");
        }

        $vals = $this->getFromOption("ali_opensearch_posttypes");
        return $vals === "" ? null : explode("|", $vals);
    }

    /**
     * Get value from stored option object
     * @param string $key
     * @return string
     */
    private function getFromOption($key)
    {
        if ($this->alloptions !== false && isset($this->alloptions->$key)) {
            return $this->alloptions->$key;
        }

        return "";
    }
}