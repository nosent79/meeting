<?php
/**
 * Created by PhpStorm.
 * User: 최진욱
 * Date: 2016-12-29
 * Time: 오후 6:36
 */
    require_once "../Database.php";

    if(!isMember()) {
        redirectSiteURL(SITE_URL. SITE_PORT);
    }
?>

<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        /* Bordered form */
        form {
            border: 3px solid #f1f1f1;
        }

        /* Full-width inputs */
        input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        select, textarea{
            width: 100%;
        }



        /* Set a style for all buttons */
        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        /* Add padding to containers */
        .container {
            padding: 16px;
        }

        /* The "Forgot password" text */
        span.psw {
            float: right;
            padding-top: 16px;
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }
        }

    </style>
</head>
<body>

<form name="frmAssessOK" action="assess_ok.php">
    <input type="hidden" name="target_id" value="<?=$_POST['g_id']?>" />
    <div class="container">
        <label><b><?=$_POST['g_name']?> 님을 평가해 주세요.</b></label>
        <select name="assess_point" id="assess_point">
            <option value="5">5</option>
            <option value="4">4</option>
            <option value="3">3</option>
            <option value="2">2</option>
            <option value="1">1</option>
        </select>

        <textarea name="assess_comment" id="assess_comment" cols="30" rows="10"></textarea>
        <button type="submit">평가하기</button>
    </div>
</form>
</body>
</html>
