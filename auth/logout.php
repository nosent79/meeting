<?php
/**
 * Created by PhpStorm.
 * User: 최진욱
 * Date: 2016-12-28
 * Time: 오전 10:15
 */
    require_once "../config/config.php";

    session_destroy();

    header("Location: ". SITE_URL.SITE_PORT, true, 301);