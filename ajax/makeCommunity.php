<?php
    include_once(__DIR__ . "../../classes/Community.php");
    include_once("../functions.php");

    if (!empty($_POST)) {
        $coms = new Community();
        $coms->setUserId($_POST["userId"]);
        $coms->setPolygon1($_POST["polygon1"]);
        if (!empty($_POST['crop1'])) {
            $coms->setCrop1($_POST['crop1']);
        } else {
            $coms->setCrop1('');
        }

        if (!empty($_POST['crop2'])) {
            $coms->setCrop2($_POST['crop2']);
        } else {
            $coms->setCrop2('');
        }
        $coms->setName($_POST['communityName']);

        $coms->makeNewCommunity();

        //return success
        $response = [
            'status' => 'success',
            'request' => 'crop updated!'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
