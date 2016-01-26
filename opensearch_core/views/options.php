<?php
// echo "enter opensearch   111";exit();
include_once dirname(__FILE__) . '/../../include/common.inc.php';
session_start();
require_once(dirname(__FILE__) . "/../../include/arc.partview.class.php");
$pv = new PartView();

if ($_POST) {
    if ($_POST['host'] == "") {
        ShowMsg('host不能为空', '-1');
        exit();
    } else {
        $host = $_POST['host'];
    }

    if ($_POST['accesskey'] == "") {
        ShowMsg('Access Key不能为空', '-1');
        exit();
    } else {
        $accesskey = $_POST['accesskey'];
    }

    if ($_POST['secret'] == "") {
        ShowMsg('secret 不能为空', '-1');
        exit();
    } else {
        $secret = $_POST['secret'];
    }
    if ($_POST['appname'] == "") {
        ShowMsg('应用名称不能为空', '-1');
        exit();
    } else {
        $appname = $_POST['appname'];
    }

    $host = urlencode($host);

    $options = json_encode($_POST);

    $sql = "delete from opensearch_for_dedecms";
    $dsql->ExecuteNoneQuery($sql);

    $sql = "insert into opensearch_for_dedecms(options) values('$options')";
    $affected = $dsql->ExecuteNoneQuery($sql);
    if (!$affected) {
        var_dump($dsql->GetError());
    }
}

if ($_GET['action'] == 'delete') {
    $sql = "delete from opensearch_for_dedecms";
    $affected = $dsql->ExecuteNoneQuery($sql);
    if (!$affected) {
        var_dump($dsql->GetError());
    }
}


$row = $dsql->GetOne('SELECT * FROM `opensearch_for_dedecms`');
global $options;
if (!empty($row)) {
//	$pv->SetTemplet();
    $options = json_decode($row["options"]);
    $options->host = $options->host;

    if ($_GET['action'] == 'edit') {
        include dirname(__FILE__) . '/templets/adopensearch_edit.php';
    } else {
        include dirname(__FILE__) . '/templets/adopensearch_show.php';
    }

} else {
    include dirname(__FILE__) . '/templets/adopensearch_edit.php';
}

?>