<?php
    include_once(__DIR__ . "../../classes/CommunityRequest.php");

    if (!empty($_POST)) {

        //new class object
        $communityreq = new CommunityRequest();
        $communityreq->setId($_POST['requestId']);
      
        //deny communityreq in database
        $communityreq->denyRequest();

        //return success
        $response = [
            'status' => 'success',
            'request' => 'request accepted!'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
