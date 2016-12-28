<?php
/**
 * Created by PhpStorm.
 * User: 최진욱
 * Date: 2016-12-27
 * Time: 오후 4:07
 */

    require_once "../Database.php";

    $db = new Database();

    $ages = getAges($_POST['u_ident1']);
    $location = $_POST['u_location'];
    $salary = $_POST['u_salary'];
    $education = $_POST['u_edu'];
    $job = $_POST['u_work'];

    $infos = [
        'age' => $ages,
        'location' => $location,
        'education' => $education,
        'job' => $job,
        'salary' => $salary,
    ];

    $member_infos = [
        'name' => $_POST['u_ident1'],
        'email' => $_POST['u_email']."@".$_POST['u_email_domain_select'],
        'password' => password_hash($_POST['u_pwd1'], PASSWORD_DEFAULT),
        'birth_year' => $_POST['u_ident1'],
        'sex' => $_POST['u_ident2'],
        'location' => $_POST['u_location'],
        'education' => $_POST['u_edu'],
        'job' => $_POST['u_work'],
        'salary' => $_POST['u_salary'],
        'hobby' => $_POST['u_hobby'],
        'cellphone' => $_POST['u_hp1'].$_POST['u_hp2'].$_POST['u_hp3'],
        'admin_flag' => 'N',
    ];

    $weight_info = $db->calculateWeightItems($infos);

    // 우선 구현완료 후 트랜잭션 처리
    $member_id = $db->insertMemberInfo($member_infos);
    $db->insertMemberWeight($member_id, $weight_info);
    $db->insertMemberPopular($member_id);

    $_SESSION['m_id'] = $member_id;
    $_SESSION['m_nm'] = $member_infos['name'];
    $_SESSION['m_email'] = $member_infos['email'];

    $msg = "가입이 완료되었습니다.";
    redirectSiteURLwithAlert(SITE_URL.SITE_PORT, $msg);
