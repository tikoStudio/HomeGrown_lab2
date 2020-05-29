<?php
    include_once(__DIR__ . "../../classes/makeCommunity.php");
    include_once(__DIR__ . "../../classes/Community.php");
    include_once("../functions.php");

    if (!empty($_POST)) {

        //new class object
        $makeCom = new MakeCommunity();
        $makeCom->setUserId($_POST["userId"]);
        $makeCom->setPolygon1($_POST["polygon1"]);
        if (!empty($_POST['crop1'])) {
            $makeCom->setCrop1($_POST['crop1']);
        } else {
            $makeCom->setCrop1('');
        }

        if (!empty($_POST['crop2'])) {
            $makeCom->setCrop2($_POST['crop2']);
        } else {
            $makeCom->setCrop2('');
        }
        $makeCom->setImg($_POST['img']);

        $makeCom->setName($_POST['communityName']);

        //save()
        $makeCom->makeCom();


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
