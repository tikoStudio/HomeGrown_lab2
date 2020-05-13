<?php
    include_once(__DIR__ . "../../classes/User.php");

    if (!empty($_POST)) {

        //new class object
        $user = new User();
        $user->setId($_POST['userId']);
       
        //save()
        $user->updateCrop2($_POST['cropname']);

        //return success
        $response = [
            'status' => 'success',
            'request' => 'crop updated!'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
