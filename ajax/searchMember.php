<?php
/**
 * Created by PhpStorm.
 * User: 최진욱
 * Date: 2016-12-29
 * Time: 오전 10:18
 */
    require_once "../Database.php";

    $db = new Database();

    $info = [
        'ages'     => $_POST['ages'],
        'education'   => $_POST['education'],
        'location'      => $_POST['location'],
        'job'           => $_POST['job'],
        'salary'        => $_POST['salary'],
    ];

    $data = $db->searchMember($info);

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

    http_response_code(201);
    header('Content-Type: application/json');
    echo json_encode($result);