<?php
    include_once('classes/Nudge.php');
    include_once('classes/User.php');

    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
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

    if (empty($_GET["u"])) {
        header("Location: index.php");
    } else {
        $user = new User();
        $user->setToken($_GET['u']);
        $profile = $user->userFromToken();
        $user->setId($profile['id']);
        $myData = $user->getAllUserData();
        if (!$profile) {
            header("Location: index.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,500,700&display=swap" rel="stylesheet">
</head>

<body>

    <div class="profileList">
        <div class="line nudgeLine"></div>
        <h2 class="profile__head">profile</h2>

        <!-- profile name and page -->
        <div class="white__field">
            <?php if (!empty($myData['avatar'])): ?>
            <img src="uploads/<?php echo $myData['avatar']; ?>"
                alt="profile img" class="profile__avatar">
            <?php else: ?>
            <img src="uploads/photolessUser.jpg" alt="profile img" class="profile__avatar">
            <?php endif; ?>
            <h2><?php echo $myData['name'] ?>
            </h2>
        </div>


        <!-- crops -->
        <h2 class="profile__head">crops</h2>
        <div class="white__field white__field--crops">
            <h2 class="zero">crop 1</h2>
            <div class="profile__crop">
                <?php if (!empty($myData['crop1'])): ?>
                <p class="crop__name"><?php echo $myData['crop1'] ?>
                </p>
                <?php else: ?>
                <p class="crop__name crop1"><img src="images/plus.svg" class="img__plus">
                </p>
                <?php endif; ?>
            </div>
            <h2 class="zero">crop 2</h2>
            <div class="profile__crop">
                <?php if (!empty($myData['crop2'])): ?>
                <p class="crop__name"><?php echo $myData['crop2'] ?>
                </p>
                <?php else: ?>
                <p class="crop__name crop2"><img src="images/plus.svg" class="img__plus">
                </p>
                <?php endif; ?>
            </div>
            <h2 class="zero">crop 3</h2>
            <div class="profile__crop profile__crop--end">
                <?php if (!empty($myData['crop3'])): ?>
                <p class="crop__name"><?php echo $myData['crop3'] ?>
                </p>
                <?php else: ?>
                <p class="crop__name crop3"><img src="images/plus.svg" class="img__plus">
                </p>
                <?php endif; ?>
            </div>
        </div>

        <h2 class="profile__head">Nudges</h2>

        <textarea name="nudgeMessage" id="nudgeMessage"></textarea>
        <button class="nudge__popup__send">Send</button>

        <div class="nudge__popup nudge__complete">
            <img src="images/nudged.svg" alt="nudge alert popup">
            <h2>Nudge has been send</h2>
        </div>
    </div>
    <div class="blur"></div>


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
                <a href="?u=<?php echo $token['activationToken']?>&nudge=true&nid=<?php echo $nudgeItem['id'] ?>"
                    class="nudgeLink">X</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>





    <!-- footer navigation -->
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
                    href="?u=<?php echo $token['activationToken']?>&nudge=true"><img
                        src="images/notification.svg" alt="notification icon"></a>
            </div>
            <a
                href="profile.php?u=<?php echo $token['activationToken']; ?>"><img
                    src="images/profile.svg" alt="profile icon"></a>
        </nav>




        <script src="js/nudgeBlur.js"></script>
        <script src="js/fillCrops.js"></script>
</body>

</html>