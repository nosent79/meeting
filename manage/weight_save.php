<?php
/**
 * Created by PhpStorm.
 * User: 최진욱
 * Date: 2017-01-02
 * Time: 오후 3:05
 */
    require_once "../Database.php";
    $db = new Database();

    $db->beginTransaction();

    try {
        $db->insertWeightItems($_REQUEST);

        $db->endTransaction();

        closePopupAndAlert("저장되었습니다.");

    } catch (Exception $e) {
        $db->cancelTransaction();

        var_dump($e) or die();
    }

