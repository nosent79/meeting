<?php
/**
 * Created by PhpStorm.
 * User: 최진욱
 * Date: 2016-12-16
 * Time: 오전 11:03
 */
    require_once "../../Database.php";

    $db = new Database();

    $info = [
        "id"    => $_REQUEST['admin_id'],
        "pwd"   => $_REQUEST['admin_pwd'],
    ];

    $admin = $db->getAdminInfo($info);

    if ($admin === null) {
        redirectSiteURL(SITE_URL.SITE_PORT."/manage/auth/login.php");
    }

    $_SESSION['admin_id'] = $admin['admin_id'];
    $_SESSION['admin_nm'] = $admin['admin_nm'];

    redirectSiteURL(SITE_URL.SITE_PORT."/manage/index.php");

