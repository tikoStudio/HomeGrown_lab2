<?php
    include_once(__DIR__ . "../../classes/CommunityRequest.php");
    include_once(__DIR__ . "../../classes/Community.php");

    if (!empty($_POST)) {

        //new class object
        $communityreq = new CommunityRequest();
        $communityreq->setId($_POST['requestId']);
      
        //accept communityreq in database
        $communityreq->acceptRequest();

        //add user to community
        $com = new Community();
        $com->setId($_POST['communityId']);
        $com->acceptMember($_POST['userId']);

        //return success
        $response = [
            'status' => 'success',
            'request' => 'request accepted!'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
