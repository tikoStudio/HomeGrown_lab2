<?php
    include_once(__DIR__ . "/classes/Message.php");
    include_once(__DIR__ . "/classes/Community.php");
    include_once('classes/Nudge.php');
    include_once('classes/User.php');

    session_start();
    $community = new Community();
    $user = new Message();
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

    $loggedIn = new User();
    $loggedIn->setId($_SESSION['id']);
    $token = $loggedIn->tokenFromSession();

    $user->setId($_SESSION['id']);
    $user->setCommunityId($_GET['com']);

    $messages = $user->getMessagesFromDatabase();

    if (!empty($_POST) && !empty($_POST['message'])) {
        $user->setMessage($_POST['message']);
        $user->setTime(date("H:i"));
        $user->saveMessage();
        $messages = $user->getMessagesFromDatabase(); //recheck all messages in db
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
    <title>Chat</title>
</head>

<body>

    <div class="community__container community__container--top">
        <h1 class="h1--members"><?php echo $cData['name'] ?>
        </h1>
    </div>
    <div class="chatbox">

        <?php foreach ($messages as $message): ?>
        <?php if ($_SESSION['id'] == $message['userId']) {
    echo '<div class="send">';
} ?>
        <div class="chatbox__messages <?php if ($_SESSION['id'] == $message['userId']) {
    echo 'chatbox__messages--me';
} ?> ">
            <div class="chatbox__header">
                <h4 class="chatbox__user"> <?php if ($_SESSION['id'] != $message['userId']) {
    echo $message['name'];
} ?>
                </h4>
                <h4 class="chatbox__user"><?php echo $message['time'] ?>
                </h4>
            </div>
            <p><?php echo $message['message'] ?>
            </p>
        </div>
        <?php if ($_SESSION['id'] == $message['userId']) {
    echo '</div>';
} ?>
        <?php endforeach; ?>

    </div>
    <form action="" method="POST" class="form__messages">
        <input type="text" placeholder="Type a message ..." name="message" class="input__message">
        <input type="submit" value="" class="input__send__message">
        <img src="images/plus.svg" alt="send text" class="send__message__img">
    </form>

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
                <a href="?com=<?php echo $_GET['com'] ?>&nudge=true&nid=<?php echo $nudgeItem['id'] ?>"
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
                    href="?com=<?php echo $_GET['com']; ?>&nudge=true"><img
                        src="images/notification.svg" alt="notification icon"></a>
            </div>
            <a
                href="profile.php?u=<?php echo $token['activationToken']; ?>"><img
                    src="images/profile.svg" alt="profile icon"></a>
        </nav>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/chat.js"></script>
    <script src="js/nudgeBlur.js"></script>
    <?php if (isset($nudgeCollection)): ?>
    <script>
        const queryString = window.location.search;
        if (queryString.includes("nid")) {} else {
            let animation = setInterval(myMethod, 2);
            topcss = 100
            opacitycss = 0

            function myMethod() {
                if (topcss <= 45) {
                    clearInterval(animation)
                }
                document.querySelector('.blur--active').style.opacity = opacitycss
                document.querySelector('.nudgeList').style.top = topcss + "vh"
                topcss -= 3
                opacitycss += 0.1
            }
        }
    </script>
    <?php endif; ?>
</body>

</html>