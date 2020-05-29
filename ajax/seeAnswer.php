<?php
    include_once(__DIR__ . "../../classes/CommunityRequest.php");

    if (!empty($_POST)) {

        //new class object
        $communityreq = new CommunityRequest();
        $communityreq->setId($_POST['id']);
      
        //send communityreq to db
        $communityreq->setToSeen();

        //return success
        $response = [
            'status' => 'success',
            'request' => 'request send!'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
