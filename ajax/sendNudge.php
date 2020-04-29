
<?php
    include_once(__DIR__ . "../../classes/Nudge.php");

    if (!empty($_POST)) {

        //new class object
        $nudge = new Nudge();
        $nudge->setUserId1($_POST['userId1']);
        $nudge->setUserId2($_POST['userId2']);
        $nudge->setText($_POST['text']);
        $nudge->setTime(date("H:i"));
       
        //save()
        $nudge->saveNudge();

        //return success
        $response = [
            'status' => 'success',
            'request' => 'nudge send!'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
