<?php
    include_once('classes/User.php');
    include_once('classes/Community.php');
    include_once('classes/Nudge.php');

    session_start();
    $user = new User();
    $community = new Community();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
    } elseif (!isset($_GET['com']) || empty($_GET['com'])) {
        header("Location: index.php");
    } elseif (!empty($_GET['com'])) {
        $community->setId($_GET['com']);
        $cData = $community->getcommunityData();
        if (!$cData) {
            header("Location: index.php");
        }
    }

    $isTop = false;

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
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,500,700&display=swap" rel="stylesheet">
    <title>Community</title>
</head>

<body>

    <div class="community__container community__container--top">
        <div class="community__data__container community__data__container--xl">
            <div class="label">
                <p><?php if ($_SESSION['id'] != $cData['userId1'] && $_SESSION['id'] != $cData['userId2'] && $_SESSION['id'] != $cData['userId3'] && $_SESSION['id'] != $cData['userId4']): ?>
                    <?php if (!empty($cData['userId1']) || !empty($cData['userId2']) || !empty($cData['userId3']) || !empty($cData['userId1'])): ?>
                    <?php echo "Looking for members"; ?>
                    <?php endif; ?>
                    <?php else: echo "Members"; endif; ?>
                </p>
            </div>
            <div class="community__img">
                <img src="images/<?php echo $cData['img'] ?>"
                    alt="farming resource picture">
            </div>
            <div class="community__info community__info__col">
                <h3><?php echo $cData['name'] ?>
                </h3>

                <div class="farm__container">
                    <?php if ($cData['crop1']): ?>
                    <div class="farming farming--xl">
                        <p><?php echo $cData['crop1'] ?>
                        </p>
                    </div>
                    <?php endif; ?>
                    <?php if ($cData['crop2']): ?>
                    <div class="farming farming--xl">
                        <p><?php echo $cData['crop2'] ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <p class="community__adress center"><?php echo $cData['address'] ?>
            </p>
            <?php if ($_SESSION['id'] != $cData['userId1'] && $_SESSION['id'] != $cData['userId2'] && $_SESSION['id'] != $cData['userId3'] && $_SESSION['id'] != $cData['userId4']): ?>
            <?php if (!empty($cData['userId1']) || !empty($cData['userId2']) || !empty($cData['userId3']) || !empty($cData['userId1'])): ?>
            <div class="form__field top__container">
                <a href="#"> <input type="submit" value="Join community"
                        class="btn btn--primary btn--reverse btn--round"></a>
            </div>
            <?php endif; ?>
            <?php else: $isTop = true; endif; ?>
            <div class="form__field <?php if ($isTop) {
    echo "top__container";
} ?>">
                <a
                    href="communityChat.php?com=<?php echo $_GET['com'] ?>">
                    <input type="submit" value="community chat" class="btn btn--primary btn--reverse btn--round"></a>
            </div>

            <div class="memberlist">
                <?php if (!empty($cData['userId1'])): ?>
                <?php
                $user->setId($cData['userId1']);
                $userData = $user->getAllUserData(); ?>
                <div class="member">
                    <div class="member--avatar"><?php if (!empty($userData['avatar'])): ?>
                        <img src="<?php echo "uploads/" . $userData['avatar']; ?>"
                            alt="profile picture"><?php endif; ?>
                    </div>
                    <div class="member--name">
                        <p class="p__member--name"><?php echo $userData['name']; ?>
                        </p>
                    </div>
                    <div class="farming member--farming">
                        <p><?php echo $userData['crop1'] ?>
                        </p>
                    </div>
                    <div class="member--nudge" data-userId2=<?php echo $userData['id']; ?>
                        data-userId1 = <?php echo $_SESSION['id'] ?>><img
                            src="images/notification.svg" alt="nudge button"></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($cData['userId2'])): ?>
                <?php
                $user->setId($cData['userId2']);
                $userData = $user->getAllUserData(); ?>
                <div class="member">
                    <div class="member--avatar"><?php if (!empty($userData['avatar'])): ?>
                        <img src="<?php echo "uploads/" . $userData['avatar']; ?>"
                            alt="profile picture"><?php endif; ?>
                    </div>
                    <div class="member--name">
                        <p class="p__member--name"><?php echo $userData['name']; ?>
                        </p>
                    </div>
                    <div class="farming member--farming">
                        <p><?php echo $userData['crop1'] ?>
                        </p>
                    </div>
                    <div class="member--nudge" data-userId2=<?php echo $userData['id']; ?>
                        data-userId1 = <?php echo $_SESSION['id'] ?>><img
                            src="images/notification.svg" alt="nudge button"></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($cData['userId3'])): ?>
                <?php
                $user->setId($cData['userId3']);
                $userData = $user->getAllUserData(); ?>
                <div class="member">
                    <div class="member--avatar"><?php if (!empty($userData['avatar'])): ?>
                        <img src="<?php echo "uploads/" . $userData['avatar']; ?>"
                            alt="profile picture"><?php endif; ?>
                    </div>
                    <div class="member--name">
                        <p class="p__member--name"><?php echo $userData['name']; ?>
                        </p>
                    </div>
                    <div class="farming member--farming">
                        <p><?php echo $userData['crop1'] ?>
                        </p>
                    </div>
                    <div class="member--nudge" data-userId2=<?php echo $userData['id']; ?>
                        data-userId1 = <?php echo $_SESSION['id'] ?>><img
                            src="images/notification.svg" alt="nudge button"></div>
                </div>
                <?php endif; ?>
                <?php if (!empty($cData['userId4'])): ?>
                <?php
                $user->setId($cData['userId4']);
                $userData = $user->getAllUserData(); ?>
                <div class="member">
                    <div class="member--avatar"><?php if (!empty($userData['avatar'])): ?>
                        <img src="<?php echo "uploads/" . $userData['avatar']; ?>"
                            alt="profile picture"><?php endif; ?>
                    </div>
                    <div class="member--name">
                        <p class="p__member--name"><?php echo $userData['name']; ?>
                        </p>
                    </div>
                    <div class="farming member--farming">
                        <p><?php echo $userData['crop1'] ?>
                        </p>
                    </div>
                    <div class="member--nudge" data-userId2=<?php echo $userData['id']; ?>
                        data-userId1 = <?php echo $_SESSION['id'] ?>><img
                            src="images/notification.svg" alt="nudge button"></div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="blur"></div>
        <div class="nudge__popup">
            <img src="images/nudged.svg" alt="nudge alert popup">
            <p>You nudged a community member. Would you like to add a message to the nudge?</p>
            <textarea name="nudgeMessage" id="nudgeMessage"></textarea>
            <button class="nudge__popup__send">Send</button>
        </div>
        <div class="nudge__popup nudge__complete">
            <img src="images/nudged.svg" alt="nudge alert popup">
            <h2>Nudge has been send</h2>
        </div>
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
                <div class="member--avatar nudge--avatar"><?php if (!empty($nudgeData["avatar"])): ?>
                    <img src="<?php echo "uploads/" . $nudgeData["avatar"]; ?>"
                        alt="profile picture"><?php endif; ?>
                </div>
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
            <a
                href="?com=<?php echo $_GET['com']; ?>&nudge=true"><img
                    src="images/notification.svg" alt="notification icon"></a>
            <a href="#"><img src="images/profile.svg" alt="profile icon"></a>
        </nav>
    </footer>
    <script src="js/nudge.js"></script>
    <script src="js/nudgeBlur.js"></script>
</body>

</html>