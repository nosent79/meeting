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
<!--        <form name="frmWeight" method="post" action="weight_save.php">-->
        <form name="frmWeight" method="post">
<!--            <button type="submit">저장</button>-->
            <button class="_weightSave">저장</button>
            <table id="weight">
                <thead>
                <tr>
                    <th>항목</th>
                    <th>조건</th>
                    <th>가중치</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tobdy>
                    <tr>
                        <td><input type='text' name='item[]' /></td>
                        <td><input type='text' name='range[]' /></td>
                        <td><input type='text' name='point[]' /></td>
                        <td><button class='_addItems'>추가</button></td>
                    </tr>
                </tobdy>
                <tbody>
                </tbody>
            </table>
        </form>
    </div>
</div>
<script>
    function validWeightItems(f)
    {
        if (f["item[]"].length > 1) {
            var size = f["item[]"].length;

            for (var i=0; i<size; i++) {
                if (!f["item[]"][i].value || !f["range[]"][i].value || !f["point[]"][i].value) {
                    alert("입력값을 확인하세요");

                    return false;
                }
            }
        } else {
            if (!f["item[]"].value || !f["range[]"].value || !f["point[]"].value) {
                alert("입력값을 확인하세요");

                return false;

            }
        }

        return true;
    }


    $(document).ready(function(){
        $("._weightSave").click(function(e) {
            e.preventDefault();

           var frm = document.frmWeight;
           if (!validWeightItems(frm)) {
                return;
           }

           frm.action = "weight_save.php";
           frm.submit();

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



