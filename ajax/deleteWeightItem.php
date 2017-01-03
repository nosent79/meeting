<?php
/**
 * Created by PhpStorm.
 * User: 최진욱
 * Date: 2016-12-28
 * Time: 오후 5:18
 */
require_once "../Database.php";

$db = new Database();

// 호감 테이블에 저장
//if ($db->deleteWeightItem($_POST['seq'])) {
//    $code   = "00";
//    $status = "success";
//    $msg    = "success";
//} else {
//    $code   = "91";
//    $status = "error";
//    $msg    = "error";
//}

    $code   = "00";
    $status = "success";
    $msg    = "success";

$result = [
    "code"      => $code,
    "status"    => $status,
    "msg"       => $msg,
];

http_response_code(201);
header('Content-Type: application/json');
echo json_encode($result);