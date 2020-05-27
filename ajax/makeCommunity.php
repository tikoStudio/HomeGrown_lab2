<?php
    include_once(__DIR__ . "../../classes/makeCommunity.php");
    include_once("../functions.php");

    if (!empty($_POST)) {

        //new class object
        $makeCom = new MakeCommunity();
        $makeCom->setUserId($_POST["userId"]);
        $makeCom->setPolygon1($_POST["polygon1"]);
        if (!empty($_POST['crop1'])) {
            $makeCom->setCrop1($_POST['crop1']);
        } else {
            $makeCom->setCrop1('null');
        }

        if (!empty($_POST['crop2'])) {
            $makeCom->setCrop2($_POST['crop2']);
        } else {
            $makeCom->setCrop2('null');
        }
        //$image = $_FILES['img']['name'];
        //uploadImage($_POST['img']);
        $makeCom->setImg($_POST['img']);

        $makeCom->setName($_POST['communityName']);

        
       
        //save()
        $makeCom->makeCom();

        //return success
        $response = [
            'status' => 'success',
            'request' => 'crop updated!'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
