<?php

/**
 * Class QueryBuilder for build \CloudsearchSearch object query with dedecms search field
 */
class QueryBuilder
{
    private $search;

    /**
     * Init QueryBuilder
     * @param \CloudsearchSearch $search
     */
    public function __construct($searchObject)
    {
        $this->search = $searchObject;
    }

    /**
     * Add sort field
     * @param string $oderBy
     * @return $this|void
     */
    public function orderBy($oderBy)
    {
        if (!isset($oderBy)) {
            return;
        }

        if ($oderBy === "senddate") {
            $this->search->addSort("senddate", "-");
        } else if ($oderBy === "pubdate") {
            $this->search->addSort("pubdate", "-");
        } else if ($oderBy === "id") {
            $this->search->addSort("id", "-");
        }

        return $this;
    }

    /**
     * Add typeid filter
     * @param int $typeId
     */
    public function typeId($typeId)
    {
        if ($typeId > 0) {
            $typeIdFilter = "typeid=" . $typeId;
            $this->search->addFilter($typeIdFilter, "AND");
        }
    }

    public function starttime($startime)
    {
        if ($startime > 0) {
            $today = date("Y-m-d");
            $now = strtotime(date("Y-m-d"));
            $filter = "pubdate <= " . $now . " AND ";

            switch ($startime) {
                case 7:
                    $filter = $filter . "pubdate >=" . strtotime(($today . "-7 days"));
                    break;
                case 30:
                    $filter = $filter . "pubdate >=" . strtotime(($today . "-1 month"));
                    break;
                case 90:
                    $filter = $filter . "pubdate >=" . strtotime(($today . "-3 months"));
                    break;
                case 180:
                    $filter = $filter . "pubdate >=" . strtotime(($today . "-6 months"));
                    break;
                default:
                    break;
            }

            $this->search->addFilter($filter, "AND");
        }
    }

    public function channelType($channelType)
    {
        if ($channelType > 0) {
            $chnelFilter = "channelid=" . $channelType;
            $this->search->addFilter($chnelFilter, "AND");
        }
    }

    public function setSearch($searchType, $kwtype, $keywords)
    {
        if ($kwtype === "1") {
            $op = " OR ";
        } else {
            $op = " AND ";
        }

        if ($searchType === "title") {
            $index = "title:";

        } else {
            $index = "default:";
        }

        $keyArr = explode(" ", $keywords);

        foreach ($keyArr as $k) {
            if (trim($k) != "") {
                if (isset($q)) {
                    $q = $q . $op . $index . $k;
                } else {
                    $q = $index . $k;
                }
            }
        }
        $this->search->setQueryString($q);
    }

    public function hits($pageNumber, $cntPerPage)
    {
        if ($cntPerPage > 0) {
            $this->search->setStartHit($pageNumber * $cntPerPage);
            $this->search->setHits($cntPerPage);
        }
    }
}