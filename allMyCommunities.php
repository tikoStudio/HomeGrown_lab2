<?php
    include_once('classes/Community.php');

    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
    }

    $community = new Community();
    $community->setId($_SESSION['id']);
    $myCommunities = $community->getMyCommunities();
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
</head>

<body>
    <?php include_once('nav.inc.php'); ?>

    <div class="community__container community__container--all">
        <div class="community__title__container">
            <h2>Current Communities</h2>
        </div>
        <?php foreach ($myCommunities as $community): ?>
        <a href="community.php?com=<?php echo $community['id'] ?>"
            class="community__data__container__a">
            <div class="community__data__container community__data__container--all">
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
                    <div class=" farming">
                        <p><?php echo $community['crop1'] ?>
                        </p>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($community['crop2'])): ?>
                    <div class="farming">
                        <p><?php echo $community['crop2'] ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                <p class=community__adress><?php echo $community['address'] ?>
                </p>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php include_once("footer.inc.php"); ?>
</body>

</html>