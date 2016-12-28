<?php
/**
 * Created by PhpStorm.
 * User: 최진욱
 * Date: 2016-12-28
 * Time: 오후 5:18
 */
    require_once "../Database.php";

    $db = new Database();

    $info = [
        'sender_id' => $_SESSION['m_id'],
        'receiver_id' => $_POST['r_id'],
        'status' => 'P',
    ];

    // 인기도 1 증가
    $rtn = $db->increasePopular($info['receiver_id']);

    // 호감 테이블에 저장
    if ($db->insertGoodFeel($info)) {
        $code   = "00";
        $status = "success";
        $msg    = "success";
    } else {
        $code   = "91";
        $status = "error";
        $msg    = "error";
    }

    $result = [
        "code"      => $code,
        "status"    => $status,
        "msg"       => $msg,
    ];

    http_response_code(201);
    header('Content-Type: application/json');
    echo json_encode($result);