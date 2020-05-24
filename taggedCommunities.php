<?php
    include_once('classes/Community.php');
    include_once('classes/Nudge.php');
    include_once('classes/User.php');

    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
    }
    $user = new User();
    $user->setId($_SESSION['id']);
    $token = $user->tokenFromSession();

    $community = new Community();
    $community->setId($_SESSION['id']);
    $nearbyCommunities = $community->getNearbyCommunities();

    if (empty($_GET['tag'])) {
        header("Location: index.php");
    }

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

    $nudges = new Nudge();
        
        $nudges->setUserId2($_SESSION['id']);
        $nudgeCount = $nudges->unreadNudges();

        include_once('classes/User.php');
        $user = new User();
        $user->setId($_SESSION['id']);
        $token = $user->tokenFromSession();

    $taggedCommunities = $community->getTaggedCommunities($_GET['tag']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tagged Communities</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
</head>

<body>
    <?php include_once('nav.inc.php'); ?>

    <div class="community__container community__container--all">
        <div class="community__title__container">
            <h2>Communities with <?php echo $_GET['tag'] ?>
            </h2>
        </div>
        <?php foreach ($taggedCommunities as $community): ?>
        <div class="community__data__container community__data__container--all">
            <a href="community.php?com=<?php echo $community['id'] ?>"
                class="community__data__container__a"></a>
            <div class="label">
                <p>Member</p>
            </div>
            <div class="community__img">
                <img src="images/<?php echo $community['img']; ?>"
                    alt="farming resource picture">
            </div>
            <div class="community__info">
                <h3><?php echo $community['name']?>
                </h3>
                <?php if (!empty($community['crop1'])): ?>
                <a class="anchortag"
                    href="taggedCommunities.php?tag=<?php echo $community['crop1']; ?>">
                    <div class=" farming">
                        <p><?php echo $community['crop1'] ?>
                        </p>
                    </div>
                </a>
                <?php endif; ?>
                <?php if (!empty($community['crop2'])): ?>
                <a class="anchortag"
                    href="taggedCommunities.php?tag=<?php echo $community['crop2']; ?>">
                    <div class="farming">
                        <p><?php echo $community['crop2'] ?>
                        </p>
                    </div>
                </a>
                <?php endif; ?>
            </div>
            <p class=community__adress><?php echo $community['address'] ?>
            </p>
        </div>
        </a>
        <?php endforeach; ?>
    </div>

    <?php if (isset($nudgeCollection)): ?>
    <div class="blur blur--active"></div>
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

    <footer>
        <div class="middle">
            <a href="map.php"><img src="images/map.svg" alt="map button" class="mapbtn"></a>
            <div class="line"></div>
        </div>
        <nav>
            <a href="index.php"><img src="images/home.svg" alt="home icon"></a>
            <a href="allMyCommunities.php"><img src="images/list.svg" alt="list icon"></a>
            <div>
                <?php  if ($nudgeCount['COUNT(*)'] > 0):?>
                <div class="test"></div>
                <?php endif; ?>
                <a
                    href="?tag=<?php echo $_GET['tag']; ?>&nudge=true"><img
                        src="images/notification.svg" alt="notification icon"></a>
            </div>
            <a
                href="profile.php?u=<?php echo $token['activationToken']; ?>"><img
                    src="images/profile.svg" alt="profile icon"></a>
        </nav>
    </footer>

    <script src="js/nudgeBlur.js"></script>
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