<?php
    require_once "../Database.php";
    $db = new Database();

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
    <button id="btnRecommandMatching">추천매칭보기</button>
    <button id="btnSearchMatching">서칭매칭보기</button>
    <h2>나의 인기도</h2>
    <span><?=$db->getMyPopularPoint($_SESSION['m_id'])?> point</span>

    <h2>매칭 리스트</h2>
    <form id="frmAssess" name="frmAssess" method="post">
        <input type="hidden" name="g_id"  />
        <input type="hidden" name="g_name" />
    </form>
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
            <th>호감도</th>
            <th>평가하기</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $match_list = $db->getMatchingList('S');

        foreach($match_list as $list) {
            ?>
            <tr>
                <td><?= $list['name'] ?></td>
                <td><?= getAges($list['birth_year']) ?></td>
                <td><?= convertPhoneFormat($list['cellphone']) ?></td>
                <td><?= $list['location'] ?></td>
                <td><?= $list['education'] ?></td>
                <td><?= $list['job'] ?></td>
                <td><?= $list['hobby'] ?></td>
                <td><?= $list['salary'] ?></td>
                <td><?= $list['p_point'] ?></td>
                <td><button class="_assess button" g_id="<?=$list['id']?>" g_name="<?=$list['name']?>">평가</button></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

    <h2>내가 받은 호감</h2>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>이름</th>
            <th>나이</th>
            <th>거주지역</th>
            <th>호감도</th>
            <th>비고</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $receive_list = $db->receiveGoodFeelList('P');

        foreach($receive_list as $list) {
            ?>
            <tr>
                <td><?= $list['name'] ?></td>
                <td><?= getAges($list['birth_year']) ?></td>
                <td><?= $list['location'] ?></td>
                <td><?= $list['p_point'] ?></td>
                <td>
                    <button class="_accept button red" g_id="<?=$list['id']?>" >수락</button>
                    <button class="_deny button black" g_id="<?=$list['id']?>" >거절</button>
                </td>
            </tr>
            <?php
        }
        ?>

        </tbody>
    </table>

    <h2>내가 보낸 호감</h2>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>이름</th>
            <th>나이</th>
            <th>거주지역</th>
            <th>호감도</th>
            <th>비고</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sender_list = $db->sendGoodFeelList('P');

        foreach($sender_list as $list) {
            ?>
            <tr>
                <td><?= $list['name'] ?></td>
                <td><?= getAges($list['birth_year']) ?></td>
                <td><?= $list['location'] ?></td>
                <td><?= $list['p_point'] ?></td>
                <td><button class="_good button red" g_id="<?=$list['id']?>">썸타는중</button></td>
            </tr>
            <?php
        }
        ?>

        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        // 호감 보내기
        $("._good").click(function() {
            var g_id = $(this).attr('g_id');

            var url = $(this).text() === "썸타는중" ? "<?=SITE_URL.SITE_PORT?>/ajax/cancelGoodFeel.php" : "<?=SITE_URL.SITE_PORT?>/ajax/sendGoodFeel.php";

            $.ajax({
                type: "post",
                url: url,
                data: {'g_id': g_id},
                dataType: 'json',
                success: function(res){
                    if(res.status == 'success') {
                        if (res.code === "09") {
                            $("[g_id="+g_id+"]").removeClass('red').addClass('green').text("호감발송");
                        } else {
                            $("[g_id="+g_id+"]").removeClass('green').addClass('red').text("썸타는중");
                        }
                    } else {
                        alert("실패했습니다.");
                    }
                }
            });
        });

        $("._accept").click(function() {
            var g_id = $(this).attr('g_id');
            var url = "<?=SITE_URL.SITE_PORT?>/ajax/acceptGoodFeel.php";

            $.ajax({
                type: "post",
                url: url,
                data: {'g_id': g_id},
                dataType: 'json',
                success: function(res){
                    if(res.status == 'success') {
                        $("[g_id="+g_id+"]").parent().html("매칭되었습니다.");
                    } else {
                        alert("실패했습니다.");
                    }
                }
            });
        });

        $("._deny").click(function() {
            var g_id = $(this).attr('g_id');
            var url = "<?=SITE_URL.SITE_PORT?>/ajax/denyGoodFeel.php";

            $.ajax({
                type: "post",
                url: url,
                data: {'g_id': g_id},
                dataType: 'json',
                success: function(res){
                    if(res.status == 'success') {
                        $("[g_id="+g_id+"]").parent().html("거절하였습니다.");
                    } else {
                        alert("실패했습니다.");
                    }
                }
            });
        });

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

        $("._assess").click(function(e) {
            e.preventDefault();

            var url = "assess.php";
            var f = document.frmAssess;
            f.g_id.value = $(this).attr("g_id");
            f.g_name.value = $(this).attr("g_name");

            var pop_title = "popupOpener" ;
            window.open("", pop_title) ;

            f.target = pop_title ;
            f.action = url ;

            f.submit() ;
        })
    });

</script>
</body>
</html>