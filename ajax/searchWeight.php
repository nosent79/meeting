<?php
    /**
     * Created by PhpStorm.
     * User: 최진욱
     * Date: 2016-12-29
     * Time: 오전 10:18
     */
    require_once "../Database.php";
    $db = new Database();

    $data = $db->searchWeight($_POST['items']);

    if (count($data) > 0) {

        $code   = "00";
        $status = "success";
        $msg    = "success";
    } elseif (count($data) === 0) {
        $code   = "90";
        $status = "not data";
        $msg    = "검색 결과가 없습니다.";
    } else {
        $code   = "91";
        $status = "error";
        $msg    = "error";
    }

    $result = [
        "code"      => $code,
        "status"    => $status,
        "msg"       => $msg,
        "data"      => $data,
    ];

    header('Content-Type: application/json');
    echo json_encode($result);