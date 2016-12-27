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

//    var_dump($infos);

    $weight_info = $db->calculateWeightItems($infos);

    $db->insertMemberInfo($_REQUEST);
    $db->insertMemberWeight($weight_info);

