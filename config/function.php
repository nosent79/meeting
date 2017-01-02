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
        echo "
            <script>
                alert($msg);
                location.replace($url);
            </script>
        ";
    }

    function closePopupAndAlert($msg)
    {
        echo "
            <script>
                alert('$msg');
                self.close();
            </script>
        ";
    }

    function getAges($year) {
        return date("Y") - $year + 1;
    }

    function getAge($age, $flag = '|') {
        $ages = explode($flag, $age);
        $rtn = [];

        // 2016년도 기준으로 21 => 1996

        foreach($ages as $age) {
            array_push($rtn, date("Y") - $age + 1);
        }

        return $rtn;
    }

    function convertPhoneFormat($hp)
    {
        if(!preg_match("/^01[0-9]{8,9}$/", $hp)) {
            throw new Exception('휴대폰 번호가 아닙니다.');
        }

        return preg_replace("/(^01.{1})([0-9]+)([0-9]{4})/", "$1-$2-$3", $hp);
    }