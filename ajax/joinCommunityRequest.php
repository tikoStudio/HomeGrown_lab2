<?php
    include_once(__DIR__ . "../../classes/CommunityRequest.php");

    if (!empty($_POST)) {

        //new class object
        $communityreq = new CommunityRequest();
        $communityreq->setUserId($_POST['userId']);
        $communityreq->setCommunityId($_POST['communityId']);
      
        //send communityreq to db
        $communityreq->makeRequest();

        //return success
        $response = [
            'status' => 'success',
            'request' => 'request send!'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
