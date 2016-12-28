<?php
    require_once "../Database.php";

    if(!isMember()) {
        redirectSiteURL(SITE_URL. SITE_PORT);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>1:1 meeting</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <button id="btnRecommandMatching">추천매칭보기</button>
    <button id="btnSearchMatching">서칭매칭보기</button>
    <h2>매칭 리스트</h2>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>이름</th>
            <th>나이</th>
            <th>연락처</th>
            <th>거주지역</th>
            <th>학력</th>
            <th>직업</th>
            <th>취미</th>
            <th>연봉</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <h2>내가 받은 호감</h2>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>이름</th>
            <th>나이</th>
            <th>거주지역</th>
            <th>인기도</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <h2>내가 보낸 호감</h2>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>이름</th>
            <th>나이</th>
            <th>거주지역</th>
            <th>인기도</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {

        // 추천매칭
        $("#btnRecommandMatching").click(function() {
            var url = "recommandMatching.php";
            var opt = "width=600, height=600, resizable=no, scrollbars=no, status=no;";

            popupOpen(url, opt);
        });

        // 서칭매칭
        $("#btnSearchMatching").click(function() {
            var url = "searchMatching.php";
            var opt = "width=600, height=600, resizable=no, scrollbars=no, status=no;";

            popupOpen(url, opt);
        });
    });

</script>
</body>
</html>