<?php
    include_once('classes/Community.php');
    include_once('classes/Nudge.php');
    include_once('classes/User.php');

    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
    }

    $community = new Community();
    $community->setId($_SESSION['id']);
    $myCommunities = $community->getMyCommunities();

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All my communities</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
</head>

<body>
    <?php include_once('nav.inc.php'); ?>

    <div class="community__container community__container--all">
        <div class="community__title__container">
            <h2>Current Communities</h2>
        </div>
        <?php foreach ($myCommunities as $community): ?>
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
    <?php include_once("footer.inc.php"); ?>
    <script src="js/nudgeBlur.js"></script>
</body>

</html>