<form id="frmSearch" name="frmSearch" method="post">
    연령대 :

    <select id="" name="" title="연령대">
        <option value="">선택</option>
        <?php

            for ($i = 1997; $i > 1970; $i--) {
        ?>
        <option value="<?=$i?>"><?=$i."년"?></option>
        <?php
            }
            ?>
    </select>

    학력 :
    <select id="" name="" title="학력">
        <option value="">선택</option>
        <?php

            for ($i = 1997; $i > 1970; $i--) {
        ?>
        <option value="<?=$i?>"><?=$i."년"?></option>
        <?php
            }
            ?>
    </select>

    지역 :
    <select id="" name="" title="지역">
        <option value="">선택</option>
        <?php

            for ($i = 1997; $i > 1970; $i--) {
        ?>
        <option value="<?=$i?>"><?=$i."년"?></option>
        <?php
            }
            ?>
    </select>

    직업 :
    <select id="" name="" title="직업">
        <option value="">선택</option>
        <?php

            for ($i = 1997; $i > 1970; $i--) {
        ?>
        <option value="<?=$i?>"><?=$i."년"?></option>
        <?php
            }
            ?>
    </select>

    연봉 :
    <select id="" name="" title="연봉">
        <option value="">선택</option>
        <?php

            for ($i = 1997; $i > 1970; $i--) {
        ?>
        <option value="<?=$i?>"><?=$i."년"?></option>
        <?php
            }
            ?>
    </select>
    
    <button id="btnSearch">검색</button>
</form>