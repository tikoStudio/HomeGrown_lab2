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

        <div class="white__field">
            <img src="uploads/elizabeth.jpg" alt="profile img" class="profile__avatar">
            <h2>Mijn naam</h2>
        </div>

        <h2 class="profile__head">crops</h2>

        <div class="white__field white__field--crops">
            <h2 class="zero">crop 1</h2>
            <div class="profile__crop"></div>
            <h2 class="zero">crop 2</h2>
            <div class="profile__crop"></div>
            <h2 class="zero">crop 3</h2>
            <div class="profile__crop"></div>
        </div>

        <h2 class="profile__head">Nudges</h2>

        <textarea name="nudgeMessage" id="nudgeMessage"></textarea>
        <button class="nudge__popup__send">Send</button>

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
    <?php include_once("footer.inc.php"); ?>
    <script src="js/nudgeBlur.js"></script>
</body>

</html>