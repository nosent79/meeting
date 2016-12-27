<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="common/css/common.css">
    <link rel="stylesheet" href="common/css/style.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="common/js/common.js"></script>
    <script src="common/js/validation.js"></script>
    <script src="common/js/jquery.checkbox.min.js"></script>
    <script type="text/javascript">
        function check_submit(){
            var frm = document.transform;

            if(frm.u_name.value == $('.inputLongUrlBox').data('defaultValue')) return false;
            if(!isValidType(frm.u_name, 'text', '이름을 입력하여 주세요.' )){ return; }
            if(checkstring(frm.u_name.value) == true){alert("이름입력에 특수문자는 입력할수 없습니다."); return;}
            if(!check_input_byte(frm.u_name.value,10)){alert("입력 할 수 있는 문자길이를 초과하였습니다."); return;}
            if(!isValidType(frm.u_ident1, 'select', '출생년을 선택해 주세요.' )){ return; }
            if(!isValidType(frm.u_ident2, 'check', '성별을 선택하여 선택하여 주세요.' )){ return; }
            if(!isValidType(frm.u_edu, 'select', '학력을 선택하여 주세요.')){ return; }
            if(!isValidType(frm.u_work, 'select', '직업종류를 선택하여 주세요.' )){ return; }
            if(!isValidType(frm.u_location, 'select', '거주지역을 선택하여 주세요.' )){ return; }
            if(!isValidType(frm.u_asset, 'select', '자산을 선택하여 주세요.' )){ return; }
            if(!isValidType(frm.u_hp1, 'select', '핸드폰번호 앞자리를 선택하여 주세요.' )){ return; }
            if(!isValidType(frm.u_hp2, 'number', '핸드폰번호 중간자리를 입력하여 주세요.' )){ return; }
            if(!isValidType(frm.u_hp3, 'number', '핸드폰번호 끝자리를 입력하여 주세요.' )){ return; }

            if(!hp_chck_array(frm.u_hp2.value) && !hp_chck_array(frm.u_hp3.value)){
                alert("핸드폰 번호가 올바르지 않습니다.");
                frm.u_hp3.focus();
                return;
            }


            //if(!isValidType(frm.u_addr1, 'text', '거주지역을 선택하여 주세요.' )){ return; }
            if(!isValidType(frm.u_dwell, 'select', '거주지역을 선택하여 주세요.' )){ return; }

            if(!agree_check('agree_all','agree','agree2')){return;}

            frm.action = "auth/login_ok.php";

            frm.submit();
        }

        $(document).ready(function(){

            $('select.select').each(function(){
                var title = $(this).attr('title');
                if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
                $(this)
                    .css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
                    .after('<span class="select">' + title + '</span>')
                    .change(function(){
                        val = $('option:selected',this).text();
                        $(this).next().text(val);
                    })
            });

            $('select.select-etc').each(function() {
                var title = $(this).attr('title');
                if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
                $(this)
                    .css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
                    .after('<span class="select-etc">' + title + '</span>')
                    .change(function(){
                        val = $('option:selected',this).text();
                        $(this).next().text(val);
                    })
            });

            $('input#u_sex1:radio').checkbox({cls:'chk1'});
            $('input#u_sex2:radio').checkbox({cls:'chk2'});

            var u_name = $("#u_name");
            u_name.data('defaultValue', '이름');
            u_name.attr('value', u_name.data('defaultValue'));
            u_name
                .bind('focus click keydown', function() {
                    if (u_name.attr('value') == u_name.data('defaultValue')) {
                        u_name.attr('value','');
                    }
                    u_name.addClass('focusIn');
                })
                .focusout(function() {
                    if (u_name.attr('value') == '') {
                        u_name.attr('value',u_name.data('defaultValue'));
                    }
                    u_name.removeClass('focusIn');
                })


            var u_hobby = $("#u_hobby");
            u_hobby.data('defaultValue', '취미');
            u_hobby.attr('value', u_hobby.data('defaultValue'));
            u_hobby
                .bind('focus click keydown', function() {
                    if (u_hobby.attr('value') == u_hobby.data('defaultValue')) {
                        u_hobby.attr('value','');
                    }
                    u_hobby.addClass('focusIn');
                })
                .focusout(function() {
                    if (u_hobby.attr('value') == '') {
                        u_hobby.attr('value',u_hobby.data('defaultValue'));
                    }
                    u_hobby.removeClass('focusIn');
                })
        });

        function footer_agree_view(vmode)
        {
            if (vmode == 0)
            {
                $("#footer_agree").show();
            }
            else
            {
                $("#footer_agree").hide();
            }
        }

        function footer_select_jisa(obj)
        {
            if ($(obj).val() == "14" || $(obj).val() == "11" || $(obj).val() == "12")
            {
                $("#bottom_speed #f_hp1").hide();
                $("#bottom_speed #f_hp_text").hide();
                $("#bottom_speed #f_hp").show();
            }
            else
            {
                $("#bottom_speed #f_hp1").show();
                $("#bottom_speed #f_hp_text").show();
                $("#bottom_speed #f_hp").hide();
            }

        }

        //체크박스,라디오버튼 체크표시 label class 변경/ 실제 체크박스 checked 별도 처리
        function check_class_togle(obj,addclass,removeclass,index)
        {
            var now_class;
            var this_obj;

            this_obj = $(obj);

            if (index >= 0)
            {
                now_class = this_obj.eq(index).attr("class");
            }
            else
            {
                now_class = this_obj.attr("class");
            }

            if (addclass.length > 0 && now_class.indexOf(addclass) < 0 )
            {
                if (index >= 0)
                {
                    this_obj.eq(index).addClass(addclass);
                }
                else
                {
                    this_obj.addClass(addclass);
                }
            }

            if (removeclass.length > 0 && now_class.indexOf(removeclass) > 0 )
            {
                if (index >= 0)
                {
                    this_obj.eq(index).removeClass(removeclass);
                }
                else
                {
                    this_obj.removeClass(removeclass);
                }
            }
        }


    </script>
</head>
<body>
<div style="width:100%;">
    <form class="match_Form" name="transform" method="post">
        <input type="hidden" name="chk_birth" value=",Y,,,,,,,">
        <input type="hidden" name="chk_height" value=",,Y,,,,,">
        <input type="hidden" name="chk_edu" value=",,Y,,">
        <input type="hidden" name="chk_work" value="Y,,,,,,,,">
        <input type="hidden" name="chk_work_all" value="">

        <input type="hidden" name="u_div" value="">
        <input type="hidden" name="evt_value" value="">
        <div id="endingwrap">
            <div id="con">
                <div class="ending_1">
                    <ul>
                        <li class="in1"><input type="text" id="u_name" name="u_name" maxlength="10" value=""></li>
                        <li class="in2">
                            <!--
                            <input type="text" id="u_ident1" name="u_ident1" maxlength="6" value="" />
                            -->
                            <div class="select">
                                <select id="u_ident1" name="u_ident1" class="select" title="출생년도" style="z-index: 10; opacity: 0;">
                                    <option value="">선택</option>
                                    <option value="1997">1997년</option>
                                    <option value="1996">1996년</option>
                                    <option value="1995">1995년</option>
                                    <option value="1994">1994년</option>
                                    <option value="1993">1993년</option>
                                    <option value="1992">1992년</option>
                                    <option value="1991">1991년</option>
                                    <option value="1990">1990년</option>
                                    <option value="1989">1989년</option>
                                    <option value="1988">1988년</option>
                                    <option value="1987">1987년</option>
                                    <option value="1986">1986년</option>
                                    <option value="1985">1985년</option>
                                    <option value="1984">1984년</option>
                                    <option value="1983">1983년</option>
                                    <option value="1982">1982년</option>
                                    <option value="1981">1981년</option>
                                    <option value="1980">1980년</option>
                                    <option value="1979">1979년</option>
                                    <option value="1978">1978년</option>
                                    <option value="1977">1977년</option>
                                    <option value="1976">1976년</option>
                                    <option value="1975">1975년</option>
                                    <option value="1974">1974년</option>
                                    <option value="1973">1973년</option>
                                    <option value="1972">1972년</option>
                                    <option value="1971">1971년</option>
                                    <option value="1970">1970년</option>
                                    <option value="1969">1969년</option>
                                    <option value="1968">1968년</option>
                                    <option value="1967">1967년</option>
                                    <option value="1966">1966년</option>
                                    <option value="1965">1965년</option>
                                    <option value="1964">1964년</option>
                                    <option value="1963">1963년</option>
                                    <option value="1962">1962년</option>
                                    <option value="1961">1961년</option>
                                    <option value="1960">1960년</option>
                                    <option value="1959">1959년</option>
                                    <option value="1958">1958년</option>
                                    <option value="1957">1957년</option>
                                    <option value="1956">1956년</option>
                                    <option value="1955">1955년</option>
                                    <option value="1954">1954년</option>
                                    <option value="1953">1953년</option>
                                    <option value="1952">1952년</option>
                                    <option value="1951">1951년</option>
                                    <option value="1950">1950년</option>
                                    <option value="1949">1949년</option>
                                    <option value="1948">1948년</option>
                                    <option value="1947">1947년</option>
                                    <option value="1946">1946년</option>
                                    <option value="1945">1945년</option>
                                    <option value="1944">1944년</option>
                                    <option value="1943">1943년</option>
                                    <option value="1942">1942년</option>
                                    <option value="1941">1941년</option>
                                    <option value="1940">1940년</option>
                                    <option value="1939">1939년</option>
                                    <option value="1938">1938년</option>
                                    <option value="1937">1937년</option>
                                    <option value="1936">1936년</option>
                                </select>
                            </div>
                        </li>
                        <li class="in3">
                            <input type="radio" id="u_sex1" name="u_ident2" value="M" title="남" />
                            <input type="radio" id="u_sex2" name="u_ident2" value="F" title="여" />
                        </li>
                        <li class="in4">
                            <div class="select">
                                <select id="u_edu" name="u_edu" class="select" title="학력" style="z-index: 10; opacity: 0;">
                                    <option value="">선택</option>
                                    <option value="02">고등학교 졸업</option>
                                    <option value="05">전문대졸업</option>
                                    <option value="09">대학교졸업</option>
                                    <option value="11">대학원재학</option>
                                    <option value="13">대학원졸업</option>
                                    <option value="14">박사이상</option>
                                    <option value="15">기타</option>

                                </select>
                            </div>
                        </li>
                        <li class="in5">
                            <div class="select">
                                <select id="u_job" name="u_work" class="select" title="직업" style="z-index: 10; opacity: 0;">
                                    <option value="">선택</option>
                                    <option value="40">사무/금융직</option>
                                    <option value="47">연구원, 엔지니어</option>
                                    <option value="41">건축,설계</option>
                                    <option value="51">간호 및 기타 의료사</option>
                                    <option value="20">디자이너</option>
                                    <option value="28">언론인</option>
                                    <option value="43">교사 및 강사</option>
                                    <option value="42">공무원,공사</option>
                                    <option value="44">자영업, 사업</option>
                                    <option value="45">예술가,프리랜서</option>
                                    <option value="11">승무원/항공관련</option>
                                    <option value="10">서비스/영업</option>
                                    <option value="46">유학생,석/박사 과정</option>
                                    <option value="52">의사, 한의사, 약사</option>
                                    <option value="48">변호사,법조인</option>
                                    <option value="50">회계사 등 전문직</option>
                                    <option value="49">교수</option>
                                    <option value="34">기타</option>
                                </select>
                            </div>
                        </li>
                        <li class="in6">
                            <div class="select">
                                <select id="u_location" name="u_location" class="select" title="거주지역" style="z-index: 10; opacity: 0;">
                                    <option value="">선택</option>
                                    <option value="01">서울</option>
                                    <option value="15">수원</option>
                                    <option value="02">인천</option>
                                    <option value="16">천안</option>
                                    <option value="08">대전</option>
                                    <option value="12">전주</option>
                                    <option value="09">광주</option>
                                    <option value="07">대구</option>
                                    <option value="04">부산</option>
                                    <option value="05">울산</option>
                                    <option value="06">창원</option>
                                    <option value="22">경기</option>
                                    <option value="25">세종</option>
                                    <option value="30">충북</option>
                                    <option value="29">충남</option>
                                    <option value="27">전북</option>
                                    <option value="26">전남</option>
                                    <option value="24">경북</option>
                                    <option value="23">경남</option>
                                    <option value="21">강원</option>
                                    <option value="28">제주</option>
                                </select>
                            </div>
                        </li>
                        <li class="in7">
                            <div class="select-etc">
                                <select name="u_hp1" class="select-etc" title="핸드폰" style="z-index: 10; opacity: 0;">
                                    <option value="">선택</option>
                                    <option value="010">010</option>
                                    <option value="011">011</option>
                                    <option value="016">016</option>
                                    <option value="017">017</option>
                                    <option value="018">018</option>
                                    <option value="019">019</option>
                                </select>
                            </div><input type="text" name="u_hp2" maxlength="4" style="width:90px; margin-left:15px;"><input type="text" name="u_hp3" maxlength="4" class="last" style="width:90px;">
                        </li>
                        <li class="in8">
                            <div class="select">
                                <select id="u_asset" name="u_asset" class="select" title="자산" style="z-index: 10; opacity: 0;">
                                    <option value="">선택</option>
                                    <option value="4000">4000이하</option>
                                    <option value="5000">5000</option>
                                    <option value="5000">5000</option>
                                    <option value="6000">6000</option>
                                    <option value="7000">7000</option>
                                    <option value="8000">7000</option>
                                    <option value="9000">7000</option>
                                    <option value="10000">10000</option>
                                    <option value="15000">15000</option>
                                    <option value="20000">20000이상</option>
                                </select>
                            </div>
                        </li>
                        <li class="in9">
                            <input type="text" id="u_hobby" name="u_hobby" maxlength="20" value="">
                        </li>
                    </ul>
<!--                    <p class="agree1"><input type="checkbox" class="agree1" name="agree_all" value="Y" onclick="agree_click('agree_all','agree','agree2',0);" style="position: absolute; z-index: -1; visibility: hidden;"><span class="ag1"><span class="mark"><img src="common/images/empty.png"></span></span></p>-->
<!--                    <div class="agtxt">-->
<!--                        <div>-->
<!--                            &lt;개인정보 수집 및 이용동의 &gt;<br><br>-->
<!---->
<!--                            당사는 '개인정보보호법'에 따라 귀하의 개인정보를 다음과 같이 수집.이용하고자 합니다.<br><br>-->
<!---->
<!--                            개인정보의 수집.이용 목적<br>-->
<!--                            - 회원관리 및 결혼서비스에 관한 상담 및 자료요청 의사 확인<br>-->
<!--                            - 결혼관련 서비스 상담 및 이용 권유, 각종 서비스 및 이벤트 안내<br>-->
<!--                            - 테스트 결과안내를 위한 정보수집<br>-->
<!--                            - 이벤트 참가신청, 참가가능여부, 당첨자발표, 진행사항에 대한 정보 전달<br><br>-->
<!---->
<!--                            수집하는 개인정보의 항목<br>-->
<!--                            - 성명, 주민번호앞자리(또는 출생년월일) 성별, 연락처 및 휴대폰번호, 결혼경력, 이메일, 학력(또는 최종출신학교), 주거주지(또는 주소), 직업종류(또는 직장명)<br><br>-->
<!---->
<!--                            개인정보의 보유 및 이용기간<br>-->
<!--                            - 결혼중개업법 기준 5년 또는 개인정보 삭제 및 탈회를 요청할 때까지 보유.이용합니다.<br>-->
<!--                            - 결혼회원 가입의 경우 개인정보에 관한 회사 내부 방침에 따라 개인정보를 보유합니다.<br>-->
<!--                            - 단, 다음의 정보에 대해서는 아래의 이유로 명시한 기간 동안 보존합니다.<br><br>-->
<!--                            가. 회사 내부 방침에 의한 정보보유 사유<br><br>-->
<!---->
<!--                            -개인정보 삭제 및 회원탈퇴 신청기록 <br>-->
<!--                            　보존 이유 : 부정 이용 방지 <br>-->
<!--                            　보존 기간 : 회원탈퇴일부터 2년 <br>-->
<!--                            　보존 항목 : 아이디, 이름, 주민번호 앞자리, 이메일 <br><br>-->
<!---->
<!--                            -채용에 관한 입사지원 기록 <br>-->
<!--                            　보존 이유 : 상시채용을 위한 보관 <br>-->
<!--                            　보존기간 : 개인정보 삭제를 요청하기 전까지<br><br>-->
<!---->
<!--                            나. 관련법령에 의한 정보보유 사유 <br><br>-->
<!---->
<!--                            상법, 전자상거래 등에서의 소비자보호에 관한 법률 등 관계법령의 규정에 의하여 보존할 필요가 있는 경우 회사는 관계법령에서 정한 일정한 기간 동안 회원정보를 보관합니다. 이 경우 회사는 보관하는 정보를 그 보관의 목적으로만 이용하며 보존기간은 아래와 같습니다.<br><br>-->
<!---->
<!--                            - 계약 또는 청약철회 등에 관한 기록 <br>-->
<!--                            　보존 이유 : 전자상거래 등에서의 소비자보호에 관한 법률 <br>-->
<!--                            　보존 기간 : 5년 <br><br>-->
<!---->
<!--                            - 대금결제 및 재화 등의 공급에 관한 기록<br>-->
<!--                            　보존 이유 : 전자상거래 등에서의 소비자보호에 관한 법률 <br>-->
<!--                            　보존 기간 : 5년 <br><br>-->
<!---->
<!--                            - 전자금융 거래에 관한 기록 <br>-->
<!--                            　보존 이유 : 전자금융거래법 <br>-->
<!--                            　보존 기간 : 5년 <br><br>-->
<!---->
<!--                            - 소비자의 불만 또는 분쟁처리에 관한 기록 <br>-->
<!--                            　보존 이유 : 전자상거래 등에서의 소비자보호에 관한 법률 <br>-->
<!--                            　보존 기간 : 3년 <br><br>-->
<!---->
<!--                            - 본인 확인에 관한 기록 <br>-->
<!--                            　보존 이유 : 정보통신 이용촉진 및 정보보호 등에 관한 법률 <br>-->
<!--                            　보존 기간 : 6개월 <br><br>-->
<!---->
<!--                            - 웹사이트 방문기록 <br>-->
<!--                            　보존 이유 : 통신비밀보호법 <br>-->
<!--                            　보존 기간 : 3개월<br><br>-->
<!---->
<!--                            ※ 정보동의시 가입상담을 위해 최소한의 정보만 수집.이용하게 되며, 본 동의를 거부하시는 경우에는 해당 서비스이용 및 가입상담 등 정상적인 서비스 제공이 불가능 할 수 있습니다.<br><br>-->
<!---->
<!---->
<!--                        </div>-->
<!--                        <p class="agree"><input type="checkbox" class="agree" name="agree" value="Y" onclick="agree_click('agree_all','agree','agree2',1);" style="position: absolute; z-index: -1; visibility: hidden;"><span class="ag"><span class="mark"><img src="common/images/empty.png"></span></span></p>-->
<!--                    </div>-->
<!--                    <div class="agtxt">-->
<!--                        <div>-->
<!--                            &lt;개인정보의 제공에 관한 안내&gt;<br><br>-->
<!---->
<!--                            [소비자 권익 보호에 관한 사항]<br><br>-->
<!--                            최소한의 정보처리 및 동의거부에 대한 안내 : 정보동의시 가입상담 및 고객관리 등을 위해 최소한의 정보만 수집.이용하게 되며, 본 동의를 거부하시는 경우에는 해당 서비스의 이용 및 가입상담 등 정상적인 서비스 제공이 불가능할 수 있음을 알려 드립니다.<br><br>-->
<!--                            개인정보 제공동의 철회 : 개인정보 수집ㆍ이용에 동의한 이후에도 전화[대표번호], 서면, 메일 등을 통해 고객정보 관리 등에 대한 개인정보 처리 중지를 요청할 수 있습니다.<br><br>-->
<!--                            상품권유 중지청구(Do-Not Call) : 개인정보 제공 및 이용에 동의한 이후에도 전화[대표번호], 서면 등을 통해 마케팅활동에 대한 중지를 요청할 수 있습니다.-->
<!--                            <br><br>-->
<!---->
<!--                            개인정보 제공에 관한 사항<br><br>-->
<!--                            1. 개인정보를 제공받는 자 : 듀오 커플매니저 및 이벤트/마케팅 담담<br><br>-->
<!--                            2. 개인정보를 제공받는 자의 이용 목적<br>-->
<!--                            - 회원관리 및 결혼서비스에 관한 상담 및 자료요청 의사 확인<br>-->
<!--                            - 결혼관련 서비스 상담 및 이용 권유, 각종 서비스 및 이벤트 안내<br>-->
<!--                            - 테스트 결과안내를 위한 정보수집<br>-->
<!--                            - 이벤트 참가신청, 참가가능여부, 당첨자발표, 진행사항에 대한 정보 전달<br><br>-->
<!---->
<!--                            3. 제공할 개인정보의 내용<br><br>-->
<!--                            - 개인식별정보 (성명, 주민번호앞자리(또는 출생년월일) 성별, 연락처 및 휴대폰번호, 결혼경력, 이메일, 학력(또는 최종출신학교), 주거주지(또는 주소), 직업종류(또는 직장명))<br><br>-->
<!---->
<!--                            4. 제공받는 자의 개인정보 보유 및 이용기간<br><br>-->
<!--                            - 결혼중개업법 기준 5년 또는 개인정보 삭제 및 탈회를 요청할 때까지 보유.이용합니다.<br>-->
<!--                            - 결혼회원 가입의 경우 개인정보에 관한 회사 내부 방침에 따라 개인정보를 보유합니다.<br>-->
<!--                            - 단, 다음의 정보에 대해서는 아래의 이유로 명시한 기간 동안 보존합니다.<br><br>-->
<!--                            가. 회사 내부 방침에 의한 정보보유 사유<br><br>-->
<!---->
<!--                            -개인정보 삭제 및 회원탈퇴 신청기록 <br>-->
<!--                            　보존 이유 : 부정 이용 방지 <br>-->
<!--                            　보존 기간 : 회원탈퇴일부터 2년 <br>-->
<!--                            　보존 항목 : 아이디, 이름, 주민번호 앞자리, 이메일 <br><br>-->
<!---->
<!--                            -채용에 관한 입사지원 기록 <br>-->
<!--                            　보존 이유 : 상시채용을 위한 보관 <br>-->
<!--                            　보존기간 : 개인정보 삭제를 요청하기 전까지<br><br>-->
<!---->
<!--                            나. 관련법령에 의한 정보보유 사유 <br><br>-->
<!---->
<!--                            상법, 전자상거래 등에서의 소비자보호에 관한 법률 등 관계법령의 규정에 의하여 보존할 필요가 있는 경우 회사는 관계법령에서 정한 일정한 기간 동안 회원정보를 보관합니다. 이 경우 회사는 보관하는 정보를 그 보관의 목적으로만 이용하며 보존기간은 아래와 같습니다.<br><br>-->
<!---->
<!--                            - 계약 또는 청약철회 등에 관한 기록 <br>-->
<!--                            　보존 이유 : 전자상거래 등에서의 소비자보호에 관한 법률 <br>-->
<!--                            　보존 기간 : 5년 <br><br>-->
<!---->
<!--                            - 대금결제 및 재화 등의 공급에 관한 기록<br>-->
<!--                            　보존 이유 : 전자상거래 등에서의 소비자보호에 관한 법률 <br>-->
<!--                            　보존 기간 : 5년 <br><br>-->
<!---->
<!--                            - 전자금융 거래에 관한 기록 <br>-->
<!--                            　보존 이유 : 전자금융거래법 <br>-->
<!--                            　보존 기간 : 5년 <br><br>-->
<!---->
<!--                            - 소비자의 불만 또는 분쟁처리에 관한 기록 <br>-->
<!--                            　보존 이유 : 전자상거래 등에서의 소비자보호에 관한 법률 <br>-->
<!--                            　보존 기간 : 3년 <br><br>-->
<!---->
<!--                            - 본인 확인에 관한 기록 <br>-->
<!--                            　보존 이유 : 정보통신 이용촉진 및 정보보호 등에 관한 법률 <br>-->
<!--                            　보존 기간 : 6개월 <br><br>-->
<!---->
<!--                            - 웹사이트 방문기록 <br>-->
<!--                            　보존 이유 : 통신비밀보호법 <br>-->
<!--                            　보존 기간 : 3개월<br><br>-->
<!---->
<!--                            5. 서비스 안내방법 : SMS, Email, 전화 <br><br>-->
<!--                        </div>-->
<!--                        <p class="agree"><input type="checkbox" class="agree" name="agree2" value="Y" onclick="agree_click('agree_all','agree','agree2',2);" style="position: absolute; z-index: -1; visibility: hidden;"><span class="ag"><span class="mark"><img src="common/images/empty.png"></span></span></p>-->
<!--                    </div>div-->
                    <p class="btn"><a href="javascript:check_submit();"><img src="common/images/btn_ending.png" alt="완료"></a></p>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>