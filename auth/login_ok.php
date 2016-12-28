<?php
/**
 * Created by PhpStorm.
 * User: 최진욱
 * Date: 2016-12-26
 * Time: 오후 7:07
 */

    require_once "../Database.php";

    $db = new Database();

    $info = [
        "email"     => $_REQUEST['member_email'],
        "pwd"       => $_REQUEST['member_pwd'],
    ];

    $member = $db->getMemberInfo($info);


    if ($member === null) {
        $msg = "회원정보가 없습니다.";
        redirectSiteURL(SITE_URL.SITE_PORT, $msg);
    }

    $_SESSION['m_id'] = $member['id'];
    $_SESSION['m_nm'] = $member['name'];
    $_SESSION['m_email'] = $member['email'];

    redirectSiteURL(SITE_URL.SITE_PORT);
