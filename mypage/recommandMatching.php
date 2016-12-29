<?php
require_once "../Database.php";
$db = new Database();

if(!isMember()) {
    redirectSiteURL(SITE_URL. SITE_PORT);
}

// 호감 표시 유무 체크
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
    <h2>추천 리스트</h2>
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>이름</th>
            <th>나이</th>
            <th>학력</th>
            <th>거주지</th>
            <th>직업</th>
            <th>비고</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $rec_list = $db->getRecommendMatchingList();

            foreach($rec_list as $member) {
                $btn_text = "호감발송";
                $btn_class = "green";
                $btn_disabled = "";

                if ($member['sender_id']) {
                    $btn_text = "썸타는중";
                    $btn_class = "red";
                    $btn_disabled = "disabled";
                }
        ?>
        <tr>
            <td><?=$member['name']?></td>
            <td><?=getAges($member['birth_year'])?></td>
            <td><?=$member['education']?></td>
            <td><?=$member['location']?></td>
            <td><?=$member['job']?></td>
            <td><button class="_good button <?=$btn_class?>" g_id="<?=$member['w_id']?>" <?=$btn_disabled?>><?=$btn_text?></button></td>
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

            $.ajax({
                type: "post",
                url: "<?=SITE_URL.SITE_PORT?>/ajax/sendGoodFeel.php",
                data: {'g_id': g_id},
                dataType: 'json',
                success: function(res){
                    if(res.status == 'success') {
                        $("[g_id="+g_id+"]").addClass('red').attr("disabled", "disabled").text("썸타는중");
                    } else {
                        alert("실패했습니다.");
                    }
                }
            });
        });
    });

</script>
</body>
</html>