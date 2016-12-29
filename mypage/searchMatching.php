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
    <h2>서칭 리스트</h2>
    <?php
        include_once "../common/template/form.php"
    ?>
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
        <tbody id="member_list"></tbody>
    </table>


</div>
<script>
    function getAge(year)
    {
        return parseInt((new Date).getFullYear() - year + 1);
    }

    function checkItems(params)
    {
        var items = params.split("&");
        var flag = false;
        for ( var i in items ) {
            var item = items[i].split("=");
            if (item[1]) {
                flag = true;
            }
        }

        return flag;
    }

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

        // 대상자 검색 - ajax 연동하여 json으로 처리
        $("#btnSearch").click(function(e) {
            e.preventDefault();

            var params = $("#frmSearch").serialize();

            if(!checkItems(params)) {
                alert("조건은 하나 이상이어야합니다");
                return;
            }

            $.ajax({
                type: "post",
                url: "<?=SITE_URL.SITE_PORT?>/ajax/searchMember.php",
                data: params,
                dataType: 'json',
                success: function(res){
                    if(res.status === 'success') {
                        var html = "";
                        var btn_text = "호감발송";
                        var btn_class = "green";
                        var btn_disabled = "";

                        for (var i in res.data) {
                            btn_text = "호감발송";
                            btn_class = "green";
                            btn_disabled = "";

                            if (res.data[i].sender_id) {
                                btn_text = "썸타는중";
                                btn_class = "red";
                                btn_disabled = "disabled";
                            }

                            html += "<tr>";
                            html += "    <td>" + res.data[i].name + "</td>";
                            html += "    <td>" + getAge(res.data[i].birth_year) + "</td>";
                            html += "    <td>" + res.data[i].education + "</td>";
                            html += "    <td>" + res.data[i].location + "</td>";
                            html += "    <td>" + res.data[i].job + "</td>";
                            html += "    <td><button class='_good button "+btn_class+"' g_id='"+res.data[i].id+"' "+btn_disabled+">"+btn_text+"</button></td>";
                            html += "</tr>";
                        }

                        $("#member_list").html(html);
                    } else if (res.status === 'not data') {
                        html += "<tr>";
                        html += "<td colspan='6'>"+res.msg+"</td>";
                        html += "<tr>";

                        $("#member_list").html(html);
                    } else {
                        alert(res.status);
                    }
                }
            });
        });
    });

</script>
</body>
</html>