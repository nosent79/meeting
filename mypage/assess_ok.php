<?php
/**
 * Created by PhpStorm.
 * User: 최진욱
 * Date: 2016-12-29
 * Time: 오후 7:11
 */
    require_once "../Database.php";
    $db = new Database();

    if(!isMember()) {
        redirectSiteURL(SITE_URL. SITE_PORT);
    }

    if ($db->insertAssess($_REQUEST)) {
        redirectSiteURL("/mypage");
    }
