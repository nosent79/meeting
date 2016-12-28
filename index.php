<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>1:1 meeting</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<body>
<button id="btnMyPage">Go to MyPage</button>
<button id="btnLogin">Go to Login Page</button>
<button id="btnJoin">Go to Join Page</button>
</body>
<script>
    $(document).ready(function() {
        $("#btnMyPage").click(function() {
           location.href = "./mypage/index.php";
        });
        $("#btnLogin").click(function() {
           location.href = "./auth/login.php";
        });
        $("#btnJoin").click(function() {
           location.href = "./auth/join.php";
        });
    });
</script>
</html>