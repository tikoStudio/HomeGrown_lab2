<?php
    include_once('classes/Community.php');

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeGrown</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,500,700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <form action="" method="POST">
            <div class="form__field form__field__search">
                <img src="images/search.svg" alt="mail icon" class="form__icon">
                <input type="text" id="search" name="search" placeholder="Look for specific farms">
            </div>
        </form>
    </header>
    <div class="community__container">
        <div class="community__title__container">
            <h2>Current Communities</h2>
            <p>See All (<?php echo $myCommunitiesCount["COUNT(*)"] ?>)
            </p>
        </div>
        <a href="community.php?com=<?php echo $myCommunities[0]['id'] ?>"
            class="community__data__container__a">
            <div class="community__data__container">
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
                    <div class=" farming">
                        <p><?php echo $myCommunities[0]['crop1'] ?>
                        </p>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($myCommunities[0]['crop2'])): ?>
                    <div class="farming">
                        <p><?php echo $myCommunities[0]['crop2'] ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                <p class=community__adress><?php echo $myCommunities[0]['address'] ?>
                </p>
            </div>
        </a>
    </div>

    <div class="community__container community__nearby">
        <div class="community__title__container">
            <h2>Communities around you</h2>
            <p>See All (<?php echo $nearbyCommunitiesCount["COUNT(*)"] ?>)
            </p>
        </div>
        <a href="community.php?com=<?php echo $nearbyCommunities[0]['id'] ?>"
            class="community__data__container__a">
            <div class="community__data__container">
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
                    <div class=" farming">
                        <p><?php echo $nearbyCommunities[0]['crop1'] ?>
                        </p>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($nearbyCommunities[0]['crop2'])): ?>
                    <div class="farming">
                        <p><?php echo $nearbyCommunities[0]['crop2'] ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                <p class=community__adress><?php echo $nearbyCommunities[0]['address'] ?>
                </p>
            </div>
        </a>
    </div>
    <?php include_once("footer.inc.php"); ?>
</body>

</html>