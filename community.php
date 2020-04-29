<?php
    include_once('classes/User.php');
    include_once('classes/Community.php');

    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
    }

    $isTop = false;

    $user = new User();
    $community = new Community();

    $community->setId($_GET['com']);
    $cData = $community->getcommunityData();
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
                    <div class="member--nudge"><img src="images/notification.svg" alt="nudge button"></div>
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
                    <div class="member--nudge"><img src="images/notification.svg" alt="nudge button"></div>
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
                    <div class="member--nudge"><img src="images/notification.svg" alt="nudge button"></div>
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
                    <div class="member--nudge"><img src="images/notification.svg" alt="nudge button"></div>
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

    <?php include_once("footer.inc.php"); ?>
    <script src="js/nudge.js"></script>
</body>

</html>