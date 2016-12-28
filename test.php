<?php
    require_once "Database.php";

    $db = new Database();

//    echo $db->testInsertMemberInfo();

$db->beginTransaction();

try {
    $db->test1();
    $db->test2();
    $db->test3();

    $db->endTransaction();
} catch (Exception $e) {
    var_dump($e);
    $db->cancelTransaction();
}


