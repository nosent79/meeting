<form id="frmSearch" name="frmSearch" method="post">
    연령대 :

    <select id="ages" name="ages" title="연령대">
        <option value="">선택</option>
        <option value="18|20">18~20세</option>
        <option value="21|24">21~24세</option>
        <option value="25|28">25~28세</option>
        <option value="29|32">29~32세</option>
        <option value="33">33세 이상</option>
    </select>

    학력 :
    <select id="education" name="education" title="학력">
        <option value="">선택</option>
        <?php
        $education = $db->getCodes('education');
        foreach($education as $v) {
            ?>
            <option value="<?=$v['id']?>"><?=$v['name']?></option>
            <?php
        }
        ?>
    </select>

    지역 :
    <select id="location" name="location" title="지역">
        <option value="">선택</option>
        <?php
        $location = $db->getCodes('location');
        foreach($location as $v) {
            ?>
            <option value="<?=$v['id']?>"><?=$v['name']?></option>
            <?php
        }
        ?>
    </select>

    직업 :
    <select id="job" name="job" title="직업">
        <option value="">선택</option>
        <?php
        $job = $db->getCodes('job');
        foreach($job as $v) {
            ?>
            <option value="<?=$v['id']?>"><?=$v['name']?></option>
            <?php
        }
        ?>
    </select>

    연봉 :
    <select id="salary" name="salary" title="연봉">
        <option value="">선택</option>
        <?php
        $salary = $db->getCodes('salary');
        $prefix_first = "이하";
        $suffix_last = "이상";

        foreach($salary as $v) {
        ?>
            <option value="<?=$v['id']?>"><?=$v['name']?></option>
        <?php
        }
        ?>
    </select>
    
    <button id="btnSearch">검색</button>
</form>