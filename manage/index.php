<?php
require_once "../Database.php";
$db = new Database();

if(!isAdmin()) {
    redirectSiteURL(SITE_URL. SITE_PORT."/manage/auth/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>1:1 meeting</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?=SITE_URL.SITE_PORT?>/common/css/common.css">
    <link rel="stylesheet" href="<?=SITE_URL.SITE_PORT?>/common/css/style.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="<?=SITE_URL.SITE_PORT?>/common/js/common.js"></script>

</head>
<body>
<div class="container">
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
            <li><a href="<?=SITE_URL.SITE_PORT?>/auth/logout.php"><span class="glyphicon glyphicon-log-in"></span> 로그아웃</a></li>
        </ul>
    </div>
    <div>
        <button id="btnWeightManage">항목별 가중치 관리</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#btnWeightManage").click(function() {
            var url = "weight_manage.php";
            var opt = "width=768, height=600, resizable=no, scrollbars=no, status=no;";

            popupOpen(url, opt);
        });
        
        
    }).on("click", '._addItems', function(e) {
            e.preventDefault();

            var html = "";
            html += "<tr>";
            html += "<td><input type='text' name='item[]' /></td>";
            html += "<td><input type='text' name='range[]' /></td>";
            html += "<td><input type='text' name='point[]' /></td>";
            html += "<td><button class='_delItems'>삭제</button></td>";
            html += "</tr>";

            $('#weight > tbody:last').append(html);
    }).on("click", '._delItems', function(e) {
        e.preventDefault();

        $('#weight > tbody:last > tr:last').remove();
    });


</script>
</body>
</html>



