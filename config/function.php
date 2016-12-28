<?php
/**
 * Created by PhpStorm.
 * User: 최진욱
 * Date: 2016-12-15
 * Time: 오전 10:34
 */
    function addURLScheme($url)
    {
        if (!preg_match("/^(" . URL_PROTOCOLS . ")\:\/\//i", $url)) {
            $prefix = explode(":", $url);

            if (!($prefix[0] == 'mailto')) {
                $url = "//{$url}";
            }
        }

        return $url;
    }

    function isAdmin()
    {
        if (isset($_SESSION['admin_id'])) {
            return true;
        }

        return false;
    }

    function isMember()
    {
        if (isset($_SESSION['m_id'])) {
            return true;
        }

        return false;
    }

    function redirectSiteURL($url)
    {
        header("Location: ". $url, true, 301);
        exit;
    }

    function redirectSiteURLwithAlert($url, $msg)
    {
        echo "<script>alert($msg)</script>";
        header("Location: ". $url, true, 301);
        exit;
    }

    function getAges($ages) {
        return date("Y") - $ages + 1;
    }