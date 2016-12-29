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
        'sender_id' => $_POST['g_id'],
        'receiver_id' => $_SESSION['m_id'],
        'status' => 'S',
    ];

    if ($db->updateGoodFeel($info)) {
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