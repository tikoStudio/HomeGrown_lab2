<?php
     include_once('classes/Community.php');
     include_once('classes/Nudge.php');
     include_once('classes/User.php');
     include_once('classes/CommunityRequest.php');

    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
    }

    $community = new Community();
    $community->setId($_SESSION['id']);
    $myCommunities = $community->getMyCommunities();
    $myCommunitiesCount = $community->countMyCommunities();
    $nearbyCommunities = $community->getNearbyCommunities();
    $nearbyCommunitiesCount = $community->countNearbyCommunities();

    if (!empty($_GET['nudge'])) {
        $nudge = new Nudge();
        $nudge->setMyid($_SESSION['id']);
        $nudgeCollection = $nudge->showNudges();
        if (!empty($_GET['nid'])) {
            $nudge->setPostId($_GET['nid']);
            $nudge->markAsRead();
            $nudgeCollection = $nudge->showNudges();
        }
    }

    $uncheckedRequestFilled;
    $showRequest = false;
    $myLeadingCommunities = $community->getMyLeadingCommunities();
    $CommunityRequest = new CommunityRequest();
    foreach ($myLeadingCommunities as $community) {
        $CommunityRequest->setCommunityId($community['id']);
        $uncheckedRequests = $CommunityRequest->showRequests();
        if ($uncheckedRequests && $uncheckedRequests['accepted'] == null) {
            $uncheckedRequestFilled = $uncheckedRequests;
            $showRequest = true;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>requests</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
</head>

<body>
    <?php include_once('nav.inc.php'); ?>

    <?php if ($showRequest):?>
    <?php
        $requester = new User();
        $requester->setId($uncheckedRequestFilled['userId']);
        $userName = $requester->getAllUserData();

        $requestedCom = new Community();
        $requestedCom->setId($uncheckedRequestFilled['communityId']);
        $communityName = $requestedCom->getcommunityData();
    ?>
    <div class="blur blur--active"></div>

    <div class="nudge__popup__request">
        <img src="images/nudged.svg" alt="nudge alert popup">
        <p>
        <h2><?php echo $userName['name']; ?>
        </h2> Requested to join <h2><?php echo $communityName['name']; ?>
        </h2>
        </p>
        <button class="nudge__popup__send" id="acceptRequest" data-communityId=<?php echo $uncheckedRequestFilled['communityId'];?>
            data-requestId= <?php echo $uncheckedRequestFilled['id'] ?>
            data-userId= <?php echo $uncheckedRequestFilled['userId']; ?>
            >accept</button>
        <button class="nudge__popup__send" id="denyRequest" data-requestId=<?php echo $uncheckedRequestFilled['id'] ?>
            data-userId= <?php echo $uncheckedRequestFilled['userId']; ?>
            >deny</button>
    </div>
    <?php endif ?>

    <div class="community__container">
        <div class="community__title__container">
            <h2>Current Communities</h2>
            <a href="allMyCommunities.php">
                <p>See All (<?php echo $myCommunitiesCount["COUNT(*)"] ?>)
                </p>
            </a>
        </div>
        <?php if (isset($myCommunities[0])): ?>

        <div class="community__data__container">
            <a href="community.php?com=<?php echo $myCommunities[0]['id'] ?>"
                class="community__data__container__a"></a>
            <div class="label">
                <p>Member</p>
            </div>
            <div class="community__img">
                <img src="images/<?php echo $myCommunities[0]['img']; ?>"
                    alt="farming resource picture">
            </div>
            <div class="community__info">
                <h3><?php echo $myCommunities[0]['name']?>
                </h3>
                <?php if (!empty($myCommunities[0]['crop1'])): ?>
                <a class="anchortag"
                    href="taggedCommunities.php?tag=<?php echo $myCommunities[0]['crop1']; ?>">
                    <div class=" farming">
                        <p><?php echo $myCommunities[0]['crop1'] ?>
                        </p>
                    </div>
                </a>
                <?php endif; ?>
                <?php if (!empty($myCommunities[0]['crop2'])): ?>
                <a class="anchortag"
                    href="taggedCommunities.php?tag=<?php echo $myCommunities[0]['crop2']; ?>">
                    <div class="farming">
                        <p><?php echo $myCommunities[0]['crop2'] ?>
                        </p>
                    </div>
                </a>
                <?php endif; ?>
            </div>
            <p class=community__adress><?php echo $myCommunities[0]['address'] ?>
            </p>
        </div>
        <?php else: ?>
        <div class="community__data__container">
            <div class="community__data--empty">
                <h2>Join a community, take a look at <a href="allNearbyCommunities.php">nearby communities</a>, or go to
                    the map!</h2>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="community__container community__nearby">
        <div class="community__title__container">
            <h2>Communities around you</h2>
            <a href="allNearbyCommunities.php">
                <p>See All (<?php echo $nearbyCommunitiesCount["COUNT(*)"] ?>)
                </p>
            </a>
        </div>

        <div class="community__data__container">
            <a href="community.php?com=<?php echo $nearbyCommunities[0]['id'] ?>"
                class="community__data__container__a"></a>
            <div class="<?php if (empty($nearbyCommunities[0]['userId1']) || empty($nearbyCommunities[0]['userId2']) || empty($nearbyCommunities[0]['userId3']) || empty($nearbyCommunities[0]['userId4'])) {
        echo "label--green";
    } ?> label">
                <p><?php if (empty($nearbyCommunities[0]['userId1']) || empty($nearbyCommunities[0]['userId2']) || empty($nearbyCommunities[0]['userId3']) || empty($nearbyCommunities[0]['userId4'])) {
        echo "Looking for members";
    } else {
        echo "currently full";
    } ?>
                </p>
            </div>
            <div class="community__img">
                <img src="images/<?php echo $nearbyCommunities[0]['img'] ?>"
                    alt="farming resource picture">
            </div>
            <div class="community__info">
                <h3><?php echo $nearbyCommunities[0]['name'] ?>
                </h3>
                <?php if (!empty($nearbyCommunities[0]['crop1'])): ?>
                <a class="anchortag"
                    href="taggedCommunities.php?tag=<?php echo $nearbyCommunities[0]['crop1']; ?>">
                    <div class=" farming">
                        <p><?php echo $nearbyCommunities[0]['crop1'] ?>
                        </p>
                    </div>
                </a>
                <?php endif; ?>
                <?php if (!empty($nearbyCommunities[0]['crop2'])): ?>
                <a class="anchortag"
                    href="taggedCommunities.php?tag=<?php echo $nearbyCommunities[0]['crop1']; ?>">
                    <div class="farming">
                        <p><?php echo $nearbyCommunities[0]['crop2'] ?>
                        </p>
                    </div>
                </a>
                <?php endif; ?>
            </div>
            <p class=community__adress><?php echo $nearbyCommunities[0]['address'] ?>
            </p>
        </div>
    </div>

    <?php if (isset($nudgeCollection)): ?>
    <div class="nudgeList">
        <div class="line nudgeLine"></div>
        <div class="nudgeFolder">
            <?php foreach ($nudgeCollection as $nudgeItem): ?>
            <?php
            $nudger = new User();
            $nudger->setId($nudgeItem["userId1"]);
            $nudgeData = $nudger->getAllUserData();
        ?>
            <div class="nudgeItem">
                <a class="avatarlink"
                    href="profile.php?u=<?php echo $nudgeData['activationToken'] ?>">
                    <div class="member--avatar nudge--avatar"><?php if (!empty($nudgeData["avatar"])): ?>
                        <img src="<?php echo "uploads/" . $nudgeData["avatar"]; ?>"
                            alt="profile picture"><?php endif; ?>
                    </div>
                </a>
                <div class="nudge--name">
                    <p class="p__member--name"><?php echo $nudgeData['name']; ?>
                        <span>nudged you</span>
                    </p>
                </div>
                <div class="nudge--text">
                    <p><?php echo $nudgeItem['text']; ?>
                    </p>
                </div>
                <a href="?nudge=true&nid=<?php echo $nudgeItem['id'] ?>"
                    class="nudgeLink">X</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php include_once("footer.inc.php"); ?>
    <script src="js/nudgeBlur.js"></script>
    <script src="js/requests.js"></script>
    <?php if (isset($nudgeCollection)): ?>
    <script>
        const queryString = window.location.search;
        console.log(queryString);
        if (queryString.includes("nid")) {} else {
            let animation = setInterval(myMethod, 2);
            topcss = 100

            function myMethod() {
                if (topcss <= 45) {
                    clearInterval(animation)
                }
                document.querySelector('.nudgeList').style.top = topcss + "vh"
                console.log(topcss)
                topcss -= 3
            }
        }
    </script>
    <?php endif; ?>
</body>

</html>