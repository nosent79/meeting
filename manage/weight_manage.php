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
    <div>
        <form id="frmSearch" name="frmSearch" method="post">
            항목 :

            <select id="items" name="items" title="항목">
                <option value="">선택</option>
                <?php
                $items = $db->getCodeList();
                foreach($items as $v) {
                    var_dump($v['code']);
                    ?>
                    <option value="<?=$v['code']?>"><?=$v['code']?></option>
                    <?php
                }
                ?>
            </select>
            <button id="btnSearch">검색</button>
        </form>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>&nbsp;</th>
                <th>항목</th>
                <th>조건</th>
                <th>가중치</th>
                <th>비고</th>
            </tr>
            </thead>
            <tbody id="weight_list"></tbody>
        </table>
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
        $("._weightSave").click(function(e) {
            e.preventDefault();

           var frm = document.frmWeight;
           if (!validWeightItems(frm)) {
                return;
           }

           frm.action = "weight_save.php";
           frm.submit();

        });

        $("#btnSearch").click(function(e) {
            e.preventDefault();

            var params = $("#frmSearch").serialize();
            var url = "<?=SITE_URL.SITE_PORT?>/ajax/searchWeight.php";

            if(!checkItems(params)) {
                alert("조건은 하나 이상이어야합니다");
                return;
            }

            $.ajax({
                type: "post",
                url: url,
                data: params,
                dataType: 'json',
                success: function(res){
                    if(res.status === 'success') {
                        var html = "";

                        for (var i in res.data) {
                            html += "<tr id='seq_"+res.data[i].seq+"'>";
                            html += "    <td><input type='checkbox' name='seq[]' value='"+res.data[i].seq+"' /></td>";
                            html += "    <td>" + res.data[i].w_item + "</td>";
                            html += "    <td><input type='text' name='ranges[]' value='" + res.data[i].ranges + "' /></td>";
                            html += "    <td><input type='text' name='point[]' value='" + res.data[i].point + "' /></td>";
                            html += "    <td>";
                            html += "    <button class='_modWeight button' seq='"+res.data[i].seq+"'>수정</button>";
                            html += "    <button class='_delWeight button' seq='"+res.data[i].seq+"'>삭제</button>";
                            html += "    </td>";
                            html += "</tr>";
                        }

                        $("#weight_list").html(html);
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
    }).on("click", '._modWeight', function(e) {
        var seq = $(this).attr('seq');
        var ranges = $("#seq_"+seq).children().find("input[name='ranges[]']").val();
        var point = $("#seq_"+seq).children().find("input[name='point[]']").val();

        var url = "<?=SITE_URL.SITE_PORT?>/ajax/updateWeightItem.php";

        $.ajax({
            type: "post",
            url: url,
            data: {'seq': seq, 'ranges':ranges, 'point':point},
            dataType: 'json',
            success: function(res){
                if(res.status == 'success') {
                    alert("수정되었습니다.");
                } else {
                    alert("실패했습니다.");
                }
            }
        });
    }).on("click", '._delWeight', function(e) {
        var seq = $(this).attr('seq');
        var url = "<?=SITE_URL.SITE_PORT?>/ajax/deleteWeightItem.php";

        $.ajax({
            type: "post",
            url: url,
            data: {'seq': seq},
            dataType: 'json',
            success: function(res){
                if(res.status == 'success') {
                    $("#seq_"+seq).remove();
                    alert("삭제되었습니다.");
                } else {
                    alert("실패했습니다.");
                }
            }
        });
    });
</script>
</body>
</html>



