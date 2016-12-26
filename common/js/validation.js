/**
 * Created by 최진욱 on 2016-12-26.
 */

function isValidType( oInput, oType, oMsg ) {
    switch( oType.toLowerCase() ) {
        case 'select':		// 참고:직업종류/학력/거주지는 첫번째 value 값이 99로 되어 있음...
            if(oInput.selectedIndex == 0){
                alert(oMsg);
                oInput.selectedIndex = 0;
                return false;
            }
            return true;

        case 'number':
            if( !oInput.value ) {
                //alert ("공란입니다.");
                alert(oMsg);
                oInput.focus();
                return false;
            }

            oInput.value = $.trim(oInput.value); //아나 빈칸넣고도 모르는 분들을 위해 trim

            for( var mXi = 0; mXi < oInput.value.length; mXi++ ) {
                if( oInput.value.charAt( mXi ) != '' + parseInt( oInput.value.charAt( mXi ) ) + '' ) {
                    alert ("숫자로만 입력하여 주세요.");
                    oInput.select();
                    oInput.focus();
                    return false;
                }
            }
            return true;

        case 'number_en':
            if( !oInput.value ) {
                //alert ("공란입니다.");
                alert(oMsg);
                oInput.focus();
                return false;
            }
            for( var mXi = 0; mXi < oInput.value.length; mXi++ ) {
                if( oInput.value.charAt( mXi ) != '' + parseInt( oInput.value.charAt( mXi ) ) + '' ) {
                    alert ("Please enter numbers only.");
                    oInput.select();
                    oInput.focus();
                    return false;
                }
            }
            return true;

        case 'email':

            if(oInput.value == ""){
                alert(oMsg);
                oInput.focus();
                return false;
            }
            var mail_num = oInput.value.length;
            for (var l = 0; l <= (mail_num - 1); l++)
            {
                if (oInput.value.indexOf(" ") >= 0 )
                {
                    alert ("E-Mail 주소에서 공란을 빼주십시오");
                    oInput.focus();
                    return false;
                }
            }

            var str_mail = oInput.value;

            for (i=0; i < str_mail.length; i++) {
                if (str_mail.charCodeAt(i) > 127) {
                    alert("이메일은 한글을 사용할 수 없습니다.");
                    oInput.focus();
                    return false;
                }
            }

            if ((str_mail.indexOf("/")) == -1){
            }else {
                alert("E-Mail형식이 잘못되었습니다.\n  다시한번 확인바랍니다.");
                oInput.focus();
                return false;
            }
            if ((str_mail.indexOf(";")) == -1){
            }else {
                alert("E-Mail형식이 잘못되었습니다.\n  다시한번 확인바랍니다.");
                oInput.focus();
                return false;
            }

            if ((oInput.value.length != 0) && (str_mail.search(/(\S+)@(\S+)\.(\S+)/) == -1)) {
                alert("E-Mail형식이 잘못되었습니다.\n  다시한번 확인바랍니다.");
                oInput.focus();
                return false;
            }
            s_str1 = oInput.value;

            if ( s_str1.match(/\S/)==null ) {
                alert("공백만 입력하면 안됩니다. E-Mail을 입력해 주십시요.");
                oInput.focus();
                return false;
            }


            return true;

        case 'text':
            if(oInput.value == "" || $.trim(oInput.value) == ""){
                alert(oMsg);
                oInput.focus();
                return false;
            }

            return true;

        case 'password':
            if(oInput.value == ""){
                alert(oMsg);
                oInput.focus();
                return false;
            }

            var pwval = oInput.value;

            if (pwval.length < 4 || pwval.length > 8) {
                alert("비밀번호는 4자이상 8자이하만 가능합니다.");
                oInput.focus();
                return false;
            }

            return true;

        case 'check':
            var count = 0;
            //alert(oInput.length);
            for(i = 0; i < oInput.length; i++){
                if(oInput[i].checked == true){
                    count += 1;
                }
            }
            if(count == 0){
                alert(oMsg);
                oInput[0].focus();
                return false;
            }

            return true;

        case 'check_nofocus': // 포커스 없는 버전
            var count = 0;
            //alert(oInput.length);
            for(i = 0; i < oInput.length; i++){
                if(oInput[i].checked == true){
                    count += 1;
                }
            }
            if(count == 0){
                alert(oMsg);
                return false;
            }

            return true;

    }
}

function checkEmail(oInput1,oInput2,oInput3) {

    if (oInput1.value == "") {
        alert("이메일 아이디를 입력하십시오 ..");
        oInput1.focus();
        return false;
    }
    if (oInput1.value.indexOf("@") != -1 ){		// "@" 문자열이 포함됐을경우
        var s_email = oInput1.value.split("@");
        oInput1.value = s_email[0];				//이메일 아이디만 강제 입력
    }

    if(oInput3.selectedIndex == 0){
        alert("이메일 주소의 도메인이 선택되지 않았습니다.");
        oInput3.selectedIndex = 0;
        return false;
    }

    if (oInput3.value == "input") {
        var txt = oInput1.value+"@"+oInput2.value;	// 아이디 + 도메인직접입력
    } else {
        var txt = oInput1.value+"@"+oInput3.value;	// 아이디 + 도메인선택
    }

    for (i = 0; i < txt.length; i++) {
        if (txt.charCodeAt(i) > 127) {
            alert("이메일은 한글을 사용할 수 없습니다.");
            return false;
        }
    }

    if (txt.indexOf("@") < 2){
        alert("이메일 형식이 잘못 되었거나 도메인 입력이 안되었습니다.");
        oInput1.focus();
        return false;
    }

    for (var l = 0; l <= (txt.length - 1); l++)
    {
        if (txt.indexOf(" ") >= 0 )
        {
            alert ("E-Mail 주소에서 공백을 빼주십시오");
            return false;
        }
    }

    if ((txt.indexOf("/")) == -1){
    }else {
        alert("E-Mail 형식이 잘못 되었거나 도메인 입력이 안되었습니다.");
        return false;
    }
    if ((txt.indexOf(";")) == -1){
    }else {
        alert("E-Mail 형식이 잘못 되었거나 도메인 입력이 안되었습니다.");
        return false;
    }

    if ((txt.length != 0) && (txt.search(/(\S+)@(\S+)\.(\S+)/) == -1)) {
        alert("E-Mail 형식이 잘못 되었거나 도메인 입력이 안되었습니다.");
        return false;
    }

    if ( txt.match(/\S/)==null ) {
        alert("공백만 입력하면 안됩니다. E-Mail을 입력해 주십시요.");
        return false;
    }


    //오르지오, 네띠앙 메일 사용금지-시작 2006-09-28
    /*
     var netian_count = txt.indexOf("netian");
     var orgio_count = txt.indexOf("orgio");

     if (netian_count >-1 || orgio_count >-1) {

     var back_netian_count = txt.indexOf(".com");
     var back_orgio_count = txt.indexOf(".net");

     //alert(txt.substring(netian_count,back_netian_count));

     if (txt.substring(netian_count,back_netian_count)=="netian" || txt.substring(orgio_count,back_orgio_count)=="orgio"){
     alert("네티앙과 오르지오 메일은 서비스가 중지되었으므로 사용하실 수 없습니다. 다른 메일로 등록해 주세요.");
     document.form1.u_email.focus();
     return false;
     }
     }
     */

    return true;
}

function agree_check(obj_all,obj_a1,obj_a2)
{
    if (!$("input[name='" + obj_all + "']").is(":checked"))
    {
        if (!$("input[name='" + obj_a1 + "']").is(":checked"))
        {
            alert('개인정보 수집에 동의하여 주세요.\n개인정보에 동의하지 않으면 해당 서비스를 이용하실 수 없습니다.');
            return false;
        }

        if (!$("input[name='" + obj_a2 + "']").is(":checked"))
        {
            alert('마케팅 활용에 동의하여 주세요.\n마케팅 활용에 동의하지 않으면 해당 서비스를 이용하실 수 없습니다.');
            return false;
        }
    }

    return true;
}

//특수문자 체크
function checkstring(strvalue)
{
    var exvalue = "_{}[]()<>?|`~'!@#$%^&*-+=,.;:\"'\\/";
    var findword = false;

    for(var i=0;i< strvalue.length;i++)
    {
        if(exvalue.indexOf(strvalue.charAt(i)) != -1)
        {
            findword = true;
        }
    }

    return findword;
}

//개선된 입력글자 byte 계산
function check_input_byte(strInput,maxlength)
{
    var stringByteLength = (function(s,b,i,c){
        //ansi 한글 2바이트, utf-8 한글3바이트
        //for(b=i=0;c=s.charCodeAt(i++);b+=c>>11?3:c>>7?2:1);
        for(b=i=0;c=s.charCodeAt(i++);b+=c>>11?2:c>>7?2:1);

        return b;
    })(strInput);

    if (stringByteLength > maxlength)
    {
        //alert(stringByteLength);
        return false
    }
    else
    {
        //alert(stringByteLength);
        return true;
    }
}

//입력 글자수 리턴
function get_input_byte(strInput)
{
    var stringByteLength = (function(s,b,i,c){
        //ansi 한글 2바이트, utf-8 한글3바이트
        //for(b=i=0;c=s.charCodeAt(i++);b+=c>>11?3:c>>7?2:1);
        for(b=i=0;c=s.charCodeAt(i++);b+=c>>11?2:c>>7?2:1);

        return b;
    })(strInput);

    return stringByteLength;
}

//2014-01-20 | 비번체크 - submit 체크 | 2016-01-07 현재사용중
function CheckPassWord(ObjUserID, ObjUserPassWord, ObjUserPassWord_verify)
{
    if(ObjUserPassWord.value != ObjUserPassWord_verify.value) {
        alert("비밀번호와 비밀번호 확인이 다릅니다.");
        return false;
    }

    if(ObjUserPassWord.value.length < 8 || ObjUserPassWord.value.length > 15 ) {
        alert("비밀번호는 영문, 숫자, 특수문자의 조합으로 8자리이상 15자리 이하로 입력해주세요.");
        return false;
    }

    if(!ObjUserPassWord.value.match(/([a-zA-Z].*[0-9])|([0-9].*[a-zA-Z0-9])/))  {
        alert("비밀번호는 영문, 숫자, 특수문자의 조합으로 8자리이상 15자리이하로 입력해주세요.-숫자 또는 영문 미포함-");
        return false;
    }

    if (!checkstring(ObjUserPassWord.value))
    {
        alert("비밀번호는 영문, 숫자, 특수문자의 조합으로 8자리이상 15자리이하로 입력해주세요.- 특수문자 미포함-");
        return false;
    }


    if (ObjUserID)
    {
        if(ObjUserPassWord.value.indexOf(ObjUserID.value) > -1) {
            alert("비밀번호에 아이디를 사용할 수 없습니다.");
            return false;
        }
    }


    var password = ObjUserPassWord.value;

    var numberConut = 0;
    var textConut = 0;
    var specialConut = 0;

    var textRegular = /[a-zA-Z]+/;
    var numberRegular = /[1-9]+/;
    var specialRegular = /[!,@,#,$,%,^,&,*,?,_,~]/;

    if (textRegular.test(password)) textConut = 1;
    if (numberRegular.test(password)) numberConut = 1;
    if (specialRegular.test(password)) specialConut = 1;

    var samCount = 0;
    var continuCount = 0;
    for(var i=0; i < password.length; i++) {
        var forSamCount = 0;
        var forContinuCount = 0;
        var char1 = password.charAt(i);
        var char2 = password.charAt(i+1);
        var char3 = password.charAt(i+2);
        var char4 = password.charAt(i+3);

        if(!char4) {
            break;
        }
        //동일문자 카운트
        if(char1 == char2) {
            forSamCount = 2;
            if(char2 == char3) {
                forSamCount = 3;
                if(char2 == char4){
                    forSamCount = 4;
                }
            }
        }

        if(forSamCount > samCount) {
            samCount = forSamCount;
        }

        //4개이상
        if(char1.charCodeAt(0) - char2.charCodeAt(0) == 1 && char2.charCodeAt(0) - char3.charCodeAt(0) == 1 && char3.charCodeAt(0) - char4.charCodeAt(0) == 1) {
            forContinuCount = 4;
        }
        else if(char1.charCodeAt(0) - char2.charCodeAt(0) == -1 && char2.charCodeAt(0) - char3.charCodeAt(0) == -1 && char3.charCodeAt(0) - char4.charCodeAt(0) == -1) {
            forContinuCount = 3;
        }
        else if(char1.charCodeAt(0) - char2.charCodeAt(0) == 1 && char2.charCodeAt(0) - char3.charCodeAt(0) == 1) {
            forContinuCount = 3;
        }
        else if(char1.charCodeAt(0) - char2.charCodeAt(0) == -1 && char2.charCodeAt(0) - char3.charCodeAt(0) == -1) {
            forContinuCount = 3;
        }
        else if(char1.charCodeAt(0) - char2.charCodeAt(0) == 1) {
            forContinuCount = 2;
        }
        else if(char1.charCodeAt(0) - char2.charCodeAt(0) == -1) {
            forContinuCount = 2;
        }

        if(forContinuCount > continuCount) {
            continuCount = forContinuCount;
        }
    }

    if (samCount >= 3)
    {
        alert("연속으로 같은문자를 3번 이상 사용할 수 없습니다.");
        return false;
    }

    if (continuCount >= 3)
    {
        alert("연속된 문자열(123 또는 321, abc, cba 등)을\n 3자 이상 사용 할 수 없습니다.");
        return false;
    }

    return true;
}

// ajax input 한글처리
function ajax_setFormData(form_name,u_name)
{
    var formdata;
    var name_tr;

    formdata = "";
    name_tr = "";

    $("form[name='" + form_name + "'] input:text").each(function(index){
        if (formdata == "")
        {
            if (u_name.indexOf($(this).attr("name")) > -1)
            {
                name_tr = name_tr + "&" + $(this).attr("name") + "=" + escape($(this).val());
            }
            else
            {
                if (getValue(this) != "")
                {
                    formdata = formdata + $(this).attr("name") + "=" + getValue(this);
                }

            }
        }
        else
        {
            if (u_name.indexOf($(this).attr("name")) > -1)
            {
                name_tr = name_tr + "&" + $(this).attr("name") + "=" + escape($(this).val());
            }
            else
            {
                if (getValue(this) != "")
                {
                    formdata = formdata + "&" + $(this).attr("name") + "=" + getValue(this);
                }

            }
        }
    });

    $("form[name=" + form_name + "] textarea").each(function(index){
        if (formdata == "")
        {
            if (u_name.indexOf($(this).attr("name")) > -1)
            {
                name_tr = name_tr + "&" + $(this).attr("name") + "=" + escape($(this).val());
            }
            else
            {
                if (getValue(this) != "")
                {
                    formdata = formdata + $(this).attr("name") + "=" + getValue(this);
                }

            }
        }
        else
        {
            if (u_name.indexOf($(this).attr("name")) > -1)
            {
                name_tr = name_tr + "&" + $(this).attr("name") + "=" + escape($(this).val());
            }
            else
            {
                if (getValue(this) != "")
                {
                    formdata = formdata + "&" + $(this).attr("name") + "=" + getValue(this);
                }

            }
        }
    });


    $("form[name=" + form_name + "] select").each(function(index){
        formdata = formdata + "&" + $(this).attr("name") + "=" + $(this).val();
    });


    $("form[name=" + form_name + "] input:radio").each(function(index){
        if ($(this).is(":checked"))
        {
            formdata = formdata + "&" + $(this).attr("name") + "=" + $(this).val();
        }

    });


    $("form[name=" + form_name + "] input:checkbox").each(function(index){
        if ($(this).is(":checked"))
        {
            formdata = formdata + "&" + $(this).attr("name") + "=" + $(this).val();
        }

    });


    $("form[name=" + form_name + "] input:password").each(function(index){
        formdata = formdata + "&" + $(this).attr("name") + "=" + $(this).val();
    });


    //alert($("form[name=" + form_name + "] input[type=hidden]").length);

    $("form[name=" + form_name + "] input[type=hidden]").each(function(index){
        if (formdata == "")
        {
            if (u_name.indexOf($(this).attr("name")) > -1)
            {
                name_tr = name_tr + "&" + $(this).attr("name") + "=" + escape($(this).val());
            }
            else
            {
                if (getValue(this) != "")
                {
                    formdata = formdata + $(this).attr("name") + "=" + getValue(this);
                }

            }
        }
        else
        {
            if (u_name.indexOf($(this).attr("name")) > -1)
            {
                name_tr = name_tr + "&" + $(this).attr("name") + "=" + escape($(this).val());
            }
            else
            {
                if (getValue(this) != "")
                {
                    formdata = formdata + "&" + $(this).attr("name") + "=" + getValue(this);
                }

            }
        }
    });

    //alert(formdata);

    if (name_tr !="")
    {
        formdata = formdata + name_tr
    }

    //alert(formdata);

    return formdata;
}

function getValue(obj)
{
    var getType;

    getType = $(obj).attr("type");

    if (getType == "text" || getType == "hidden")
    {
        return $(obj).val();
    }

    if (getType == "radio" || getType == "checkbox")
    {
        if ($(obj).is(":checked") == true)
        {
            return $(obj).val();
        }
    }

    return "";
}

function checkpassword_memberinfo(u_pwd,u_mtel2,u_mtel3,u_tel2,u_tel3,u_email)
{
    if (u_pwd.indexOf(u_mtel2) > -1 || u_pwd.indexOf(u_mtel3) > -1)
    {
        alert('비밀번호에 휴대폰번호를 포함할 수 없습니다.');
        return false;
    }

    if (u_tel2 !='' && u_tel3 !='')
    {
        if (u_pwd.indexOf(u_tel2) > -1 || u_pwd.indexOf(u_tel3) > -1)
        {
            alert('비밀번호에 전화번호를 포함할 수 없습니다.');
            return false;
        }
    }

    if (u_pwd.indexOf(u_email) > -1)
    {
        alert('비밀번호에 이메일 아이디를 포함할 수 없습니다.');
        return false;
    }

    return true;
}

//해외지사 선택 시 연락처 입력 숫자체크
function mtel_check_value(newValue) {
    var newLength = newValue.length ;

    for (var i=0; i < newLength; i++) {
        aChar = newValue.substring(i, i + 1);
        bChar = newValue.charAt(0);

        if (aChar < "0" || aChar > "9") {
            if (aChar !="-")
            {
                return false;
            }

        }
    }
    return true ;
}

// 2014-11-27 | 개인정보 수집동의 체크박스 체크
function agree_check(obj_all,obj_a1,obj_a2)
{
    if (!$("input[name='" + obj_all + "']").is(":checked"))
    {
        if (!$("input[name='" + obj_a1 + "']").is(":checked"))
        {
            alert('개인정보 수집에 동의하여 주세요.\n개인정보에 동의하지 않으면 해당 서비스를 이용하실 수 없습니다.');
            return false;
        }

        if (!$("input[name='" + obj_a2 + "']").is(":checked"))
        {
            alert('마케팅 활용에 동의하여 주세요.\n마케팅 활용에 동의하지 않으면 해당 서비스를 이용하실 수 없습니다.');
            return false;
        }
    }

    return true;
}

// 2014-11-27 | 개인정보 수집동의 체크박스 체크, 마케팅동의X
function agree_check2(obj_all,obj_a1,obj_a2)
{
    if (!$("input[name='" + obj_all + "']").is(":checked"))
    {
        if (!$("input[name='" + obj_a1 + "']").is(":checked"))
        {
            alert('개인정보 수집에 동의하여 주세요.\n개인정보에 동의하지 않으면 해당 서비스를 이용하실 수 없습니다.');
            return false;
        }

    }

    return true;
}

// 2014-11-27 | 개인정보 수집동의 체크박스 체크, 마케팅 동의 선택형
function agree_check_test(obj_all,obj_a1,obj_a2)
{
    if (!$("input[name='" + obj_all + "']").is(":checked"))
    {
        if (!$("input[name='" + obj_a1 + "']").is(":checked"))
        {
            alert('개인정보 수집에 동의하여 주세요.\n개인정보에 동의하지 않으면 해당 서비스를 이용하실 수 없습니다.');
            return false;
        }
    }

    return true;
}

// 2014-11-27 | 개인정보 수집동의 체크박스 클릭 시 - prop,attr 혼합 설정 try 처리
function agree_click(obj_all,obj_a1,obj_a2,click_position)
{
    switch(click_position)
    {
        case 0:
            if (!$("input:checkbox[name='" + obj_all + "']").is(":checked"))
            {
                try{
                    $("input:checkbox[name='" + obj_a1 + "']").prop("checked",false);
                    $("input:checkbox[name='" + obj_a2 + "']").prop("checked",false);
                }
                catch(e){
                    $("input:checkbox[name='" + obj_a1 + "']").attr("checked",false);
                    $("input:checkbox[name='" + obj_a2 + "']").attr("checked",false);
                }
            }

            if ($("input:checkbox[name='" + obj_all + "']").is(":checked"))
            {
                try{
                    $("input:checkbox[name='" + obj_a2 + "']").prop("checked",true);
                    $("input:checkbox[name='" + obj_a1 + "']").prop("checked",true);
                }
                catch(e){
                    $("input:checkbox[name='" + obj_a2 + "']").attr("checked",true);
                    $("input:checkbox[name='" + obj_a1 + "']").attr("checked",true);
                }


            }
            break;

        case 1:
            if (!$("input:checkbox[name='" + obj_a1 + "']").is(":checked"))
            {
                try{
                    $("input:checkbox[name='" + obj_all + "']").prop("checked",false);
                }
                catch(e){
                    $("input:checkbox[name='" + obj_all + "']").attr("checked",false);
                }
            }
            else
            {
                try{
                    if (!$("input:checkbox[name='" + obj_a2 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").prop("checked",false);
                    }
                    else
                    {
                        $("input:checkbox[name='" + obj_all + "']").prop("checked",true);
                    }
                }
                catch(e){
                    if (!$("input:checkbox[name='" + obj_a2 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").attr("checked",false);
                    }
                    else
                    {
                        $("input:checkbox[name='" + obj_all + "']").attr("checked",true);
                    }
                }
            }
            break;

        case 2:
            if (!$("input:checkbox[name='" + obj_a2 + "']").is(":checked"))
            {
                try{
                    $("input:checkbox[name='" + obj_all + "']").prop("checked",false);
                }
                catch(e)
                {
                    $("input:checkbox[name='" + obj_all + "']").attr("checked",false);
                }
            }
            else
            {
                try{
                    if (!$("input:checkbox[name='" + obj_a1 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").prop("checked",false);
                    }
                    else
                    {
                        $("input:checkbox[name='" + obj_all + "']").prop("checked",true);
                    }
                }
                catch(e){
                    if (!$("input:checkbox[name='" + obj_a1 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").attr("checked",false);
                    }
                    else
                    {
                        $("input:checkbox[name='" + obj_all + "']").attr("checked",true);
                    }
                }
            }
            break;
    }
}

//2014-12-01 | 회원가입 약관 및 개인정보 수집 및 마케팅 사용동의 체크
function agree_member_check(obj_all,obj_a1,obj_a2,obj_a3,click_position)
{
    if (!$("input[name='" + obj_all + "']").is(":checked"))
    {
        if (!$("input[name='" + obj_a1 + "']").is(":checked"))
        {
            alert('회원 이용약관에 동의해 주세요.');
            return false;
        }

        if (!$("input[name='" + obj_a2 + "']").is(":checked"))
        {
            alert('개인정보 수집에 동의하여 주세요.\n개인정보에 동의하지 않으면 해당 서비스를 이용하실 수 없습니다.');
            return false;
        }

        if (!$("input[name='" + obj_a3 + "']").is(":checked"))
        {
            alert('마케팅 활용에 동의하여 주세요.\n마케팅 활용에 동의하지 않으면 해당 서비스를 이용하실 수 없습니다.');
            return false;
        }
    }

    return true;
}

//2014-12-01 | 회원가입 약관 및 개인정보 수집 및 마케팅 사용동의 체크X 버전
function agree_member_check2(obj_all,obj_a1,obj_a2,obj_a3,click_position)
{
    if (!$("input[name='" + obj_all + "']").is(":checked"))
    {
        if (!$("input[name='" + obj_a1 + "']").is(":checked"))
        {
            alert('회원 이용약관에 동의해 주세요.');
            return false;
        }

        if (!$("input[name='" + obj_a2 + "']").is(":checked"))
        {
            alert('개인정보 수집에 동의하여 주세요.\n개인정보에 동의하지 않으면 해당 서비스를 이용하실 수 없습니다.');
            return false;
        }

        /*
         if (!$("input[name='" + obj_a3 + "']").is(":checked"))
         {
         alert('마케팅 활용에 동의하여 주세요.\n마케팅 활용에 동의하지 않으면 해당 서비스를 이용하실 수 없습니다.');
         return false;
         }
         */
    }

    return true;
}


// 2014-12-01 | 회원가입 약관동의, 개인정보 수집동의 체크박스 클릭 시 - prop,attr 혼합 설정 try 처리
function agree_member_click(obj_all,obj_a1,obj_a2,obj_a3,click_position)
{
    switch(click_position)
    {
        case 0:
            if (!$("input:checkbox[name='" + obj_all + "']").is(":checked"))
            {
                try{
                    $("input:checkbox[name='" + obj_a1 + "']").prop("checked",false);
                    $("input:checkbox[name='" + obj_a2 + "']").prop("checked",false);
                    $("input:checkbox[name='" + obj_a3 + "']").prop("checked",false);
                }
                catch(e){
                    $("input:checkbox[name='" + obj_a1 + "']").attr("checked",false);
                    $("input:checkbox[name='" + obj_a2 + "']").attr("checked",false);
                    $("input:checkbox[name='" + obj_a3 + "']").attr("checked",false);
                }
            }

            if ($("input:checkbox[name='" + obj_all + "']").is(":checked"))
            {
                try{
                    $("input:checkbox[name='" + obj_a2 + "']").prop("checked",true);
                    $("input:checkbox[name='" + obj_a1 + "']").prop("checked",true);
                    $("input:checkbox[name='" + obj_a3 + "']").prop("checked",true);
                }
                catch(e){
                    $("input:checkbox[name='" + obj_a2 + "']").attr("checked",true);
                    $("input:checkbox[name='" + obj_a1 + "']").attr("checked",true);
                    $("input:checkbox[name='" + obj_a3 + "']").attr("checked",true);
                }


            }
            break;

        case 1:
            if (!$("input:checkbox[name='" + obj_a1 + "']").is(":checked"))
            {
                try{
                    $("input:checkbox[name='" + obj_all + "']").prop("checked",false);
                }
                catch(e){
                    $("input:checkbox[name='" + obj_all + "']").attr("checked",false);
                }
            }
            else
            {
                try{
                    if (!$("input:checkbox[name='" + obj_a2 + "']").is(":checked") || !$("input:checkbox[name='" + obj_a3 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").prop("checked",false);
                    }
                    else if ($("input:checkbox[name='" + obj_a2 + "']").is(":checked") && $("input:checkbox[name='" + obj_a3 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").prop("checked",true);
                    }
                }
                catch(e){
                    if (!$("input:checkbox[name='" + obj_a2 + "']").is(":checked") || !$("input:checkbox[name='" + obj_a3 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").attr("checked",false);
                    }
                    else if ($("input:checkbox[name='" + obj_a2 + "']").is(":checked") && $("input:checkbox[name='" + obj_a3 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").attr("checked",true);
                    }
                }
            }
            break;

        case 2:
            if (!$("input:checkbox[name='" + obj_a2 + "']").is(":checked"))
            {
                try{
                    $("input:checkbox[name='" + obj_all + "']").prop("checked",false);
                }
                catch(e)
                {
                    $("input:checkbox[name='" + obj_all + "']").attr("checked",false);
                }
            }
            else
            {
                try{
                    if (!$("input:checkbox[name='" + obj_a1 + "']").is(":checked") || !$("input:checkbox[name='" + obj_a3 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").prop("checked",false);
                    }
                    else if ($("input:checkbox[name='" + obj_a1 + "']").is(":checked") && $("input:checkbox[name='" + obj_a3 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").prop("checked",true);
                    }
                }
                catch(e){
                    if (!$("input:checkbox[name='" + obj_a1 + "']").is(":checked") || !$("input:checkbox[name='" + obj_a3 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").attr("checked",false);
                    }
                    else if ($("input:checkbox[name='" + obj_a1 + "']").is(":checked") && $("input:checkbox[name='" + obj_a3 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").attr("checked",true);
                    }
                }
            }
            break;

        case 3:
            if (!$("input:checkbox[name='" + obj_a3 + "']").is(":checked"))
            {
                try{
                    $("input:checkbox[name='" + obj_all + "']").prop("checked",false);
                }
                catch(e)
                {
                    $("input:checkbox[name='" + obj_all + "']").attr("checked",false);
                }
            }
            else
            {
                try{
                    if (!$("input:checkbox[name='" + obj_a1 + "']").is(":checked") || !$("input:checkbox[name='" + obj_a2 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").prop("checked",false);
                    }
                    else if ($("input:checkbox[name='" + obj_a1 + "']").is(":checked") && $("input:checkbox[name='" + obj_a2 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").prop("checked",true);
                    }
                }
                catch(e){
                    if (!$("input:checkbox[name='" + obj_a1 + "']").is(":checked") || !$("input:checkbox[name='" + obj_a2 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").attr("checked",false);
                    }
                    else if ($("input:checkbox[name='" + obj_a1 + "']").is(":checked") && $("input:checkbox[name='" + obj_a2 + "']").is(":checked"))
                    {
                        $("input:checkbox[name='" + obj_all + "']").attr("checked",true);
                    }
                }
            }
            break;
    }
}

// 2015-02-06 | 휴대폰 연속문자 체크추가
function hp_chck_array(strnum)
{
    var str_length = strnum.length;
    var match_cnt = 0;
    var str_cursor;

    if (str_length < 3)
    {
        return false;
    }

    for (i=0;i<str_length;i++)
    {
        str_cursor = strnum.substring(i,i+1);

        for (j=0;j<str_length ;j++)
        {
            if (i!=j)
            {
                if (str_cursor == strnum.substring(j,j+1))
                {
                    match_cnt = match_cnt + 1;
                }
            }
        }
    }

    if (match_cnt >= (str_length * (str_length - 1)))
    {
        return false;
    }
    else
    {
        var str_array = "1234,5678,12345678"

        if (str_array.indexOf(strnum) > -1)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}

//label 처리된 radio 버튼 on/off 처리 펑션(on,off class로 정의된 케이스)
function check_label_base_radio(c_name,obj,rd_class,on_class,off_class)
{
    var rd_index = $("." + c_name).index(obj);

    $("." + rd_class).removeClass(off_class);
    $("." + rd_class).removeClass(on_class);
    $("." + rd_class).addClass(off_class);

    $("." + rd_class).eq(rd_index).removeClass(off_class);
    $("." + rd_class).eq(rd_index).addClass(on_class);
}