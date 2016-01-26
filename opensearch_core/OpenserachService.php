<?php

/**
 * The fields which sync to opensearch from dedecms post
 */
$IndexColumns = array(
    "arcID" => array("label" => "id", "type" => "integer"),
    "id" => array("type" => "integer"),
    "typeid" => array("type" => "integer"),
    "channelid" => array("" => "channel", "type" => "integer"),
    "title" => array(),

    "shorttitle" => array(),
    "writer" => array(),
    "source" => array(),
    "keywords" => array(),
    "description" => array(),
    "body" => array(),

    "pubdate" => array(),
    "senddate" => array(),
    "arcrank" => array("type" => "integer"),

);

/**
 * Index dedecms post
 * @param Array $var_array
 */
function doIndex($var_array)
{
    $options = new OpensearchOptionValues();

    global $IndexColumns;

    if ($options->isValid) {
        $doc = new \stdClass();
        foreach ($IndexColumns as $k => $v) {

            if (isset($var_array[$k])) {
                $colName = isset($v["label"]) ? $v["label"] : $k;
                $doc->$colName = isset($v["type"]) ? cast($var_array[$k], $v["type"]) : $var_array[$k];
            }
        }

        $openSearchService = new \OpenserachService($options);
        $openSearchService->submitDoc($doc);
    }
}

/**
 * Remove index from opensearch if removed a post from dedecms
 * @param int $artId
 */
function removeIndex($artId)
{
    $options = new OpensearchOptionValues();

    if ($options->isValid) {
        $openSearchService = new \OpenserachService($options);
        $openSearchService->deleteDoc($artId);
    }
}

/**
 * Simple/Advance search in dedesms, retrieve the result form opensearch
 * @param $vars
 * @param $kwtype
 * @param $searchtype
 * @param $keywors
 * @return array|mixed
 */
function doOpensearch($vars, $kwtype, $searchtype, $keywors)
{
    $options = new OpensearchOptionValues();

    if ($options->isValid) {
        $openSearchService = new \OpenserachService($options);
        $searchResult = $openSearchService->search($vars, $keywors, $kwtype, $searchtype);

        return $searchResult;
    }

}

/**
 * Replace the local post with the searched result
 * @param $localResult
 * @param $remoteResult
 */
function replaceLocalResult(&$localResult, $remoteResult)
{
    global $IndexColumns;
    foreach ($remoteResult['result']['items'] as $item) {
        if ($item['id'] == $localResult["id"]) {
            foreach ($IndexColumns as $k => $v) {
                if (!isset($v["type"])) {
                    $label = isset($v["label"]) ? $v["label"] : $k;
                    $localResult[$label] = $item[$label];
                }
            }
        }
    }
}

/**
 * Cast string to expected type
 * @param string $value
 * @param string $type
 * @return float|int
 */
function cast($value, $type)
{
    if ($type == 'integer')
        return intval($value);
    if ($type == 'float')
        return floatval($value);
    if ($type == 'datetime')
        return strtotime($value, current_time('timestamp'));

    return $value;
}


/**
 * Class ContentIndexer
 * @package AliOpenSearch\Core
 */
class OpenserachService
{
    private $clien;
    private $options;

    /**
     * @param \OpensearchOptionValues $options
     */
    public function __construct($options)
    {
        $this->options = $options;

        $opt = array(
            "host" => $options->getHost()
        );
        $this->client = new \CloudsearchClient($options->getAccessKey(), $options->getSecret(), $opt, "aliyun");
    }

    /**
     * Delete doc from opensearch
     * @param $post_id
     */
    public function deleteDoc($post_id)
    {
        $doc_obj = new \CloudsearchDoc($this->options->getAppName(), $this->client);
        $item = array();
        //Set operation to 'ADD'
        $item['cmd'] = 'DELETE';
        $item["fields"] = array(id => $post_id);

        $docs_to_upload[] = $item;
        $json = json_encode($docs_to_upload);

        $doc_obj->add($json, "main");
    }

    /**
     * Add/Update a doc to opensearch
     * @param $content
     */
    public function submitDoc($content)
    {
        $this->submitDocs(array($content));
    }

    /**
     * Batch submit contents
     * @param array $contents
     */
    public function submitDocs($contents)
    {
        $doc_obj = new \CloudsearchDoc($this->options->getAppName(), $this->client);
        $docs_to_upload = array();

        foreach ($contents as $content) {
            $item = array();
            //Set operation to 'ADD'
            $item['cmd'] = 'UPDATE';
            $item["fields"] = $content;
            $docs_to_upload[] = $item;
        }

        $json = json_encode($docs_to_upload);

        //Retry service 5 times if failed
        for ($i = 1; $i < 5; $i++) {
            $pushResult = json_decode($doc_obj->add($json, "main"));

            if ($pushResult->status == "OK") {
                break;
            }
        }
    }

    /**
     * Search in alyun opensearch
     * @param string $keyword
     * @param array $indexArr
     * @param array $postTypeArr
     * @param integer $cntPerpage
     * @param integer $pageNumber
     * @return array|mixed
     */
    public function search($vars, $keywors, $kwtype, $searchtype)
    {
        $options = $this->options;
        $search_obj = new \CloudsearchSearch($this->client);
        $search_obj->addIndex($options->getAppName());
        $search_obj->setFormat("json");

        $queryBuilder = new \QueryBuilder($search_obj);
        $queryBuilder->channelType($_REQUEST["channeltype"]);
        $queryBuilder->hits($vars["limitstart"], $vars["row"]);
        $queryBuilder->orderBy($_REQUEST["orderby"]);
        $queryBuilder->starttime($_REQUEST["starttime"]);
        $queryBuilder->typeId($_REQUEST["typeid"]);
        $queryBuilder->setSearch($searchtype, $kwtype, $keywors);

        //execute search
        $json = $search_obj->search();

        //convert result
        return json_decode($json, true);
    }
}