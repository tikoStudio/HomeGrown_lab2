<?php
    include_once('classes/Nudge.php');
    include_once('classes/User.php');
    include_once('functions.php');

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
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.3.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.3.1/mapbox-gl.css' rel='stylesheet' />

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />


    <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v3.0.11/turf.min.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.css"
        type="text/css" />

    <title>Homegrown Map</title>
</head>

<body>

    <div class="blur"></div>
    <div class="community__popup">
        <p class="exit__community__popup">X</p>
        <h2>You created a community!</h2>
        <h5 class="white noMarge">Please fill in some basic information about this community.</h5>
        <div class="form__field">
            <label for="avatar"><img class="form__avatar" src="images/communityUpload.svg" alt="upload avatar"></label>
            <input type="file" class="form-control white" name="avatar" id="avatar" accept="image/*">
        </div>
        <div class="form__field form__field__input form__field__small">
            <input type="text" class="form-control white form-control-place" name="name" id="name"
                placeholder="Community name">
        </div>

        <div class="form__field form__field__input form__field__small">
            <input type="text" class="form-control white form-control-place" name="crop1" id="crops1"
                placeholder="Crops">
        </div>
        <div class="form__field form__field__input form__field__small">
            <input type="text" class="form-control white form-control-place" name="crop1" id="crops2"
                placeholder="Crops">
        </div>
        <button name="button" class="nudge__popup__send" data-userId=<?php echo $_SESSION['id']?>>Send</button>
    </div>

    <div class="community__popup community__popup__confirm">
        <p class="exit__community__popup">X</p>
        <h2>Your community has been created</h2>
        <h5 class="white noMarge">Please wait 14-24 hours before your community becomes visible.</h5>
    </div>

    <div id="mapContainer" class="mapContainer"></div>
    <div class="calculation-box">
        <div id="calculated-area"></div>
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
    <?php include_once("nav.inc.php") ?>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="js/map.js"></script>
    <script src="js/nudgeBlur.js"></script>
    <?php if (isset($nudgeCollection)): ?>
    <script>
        const queryString = window.location.search;
        if (queryString.includes("nid")) {} else {
            let animation = setInterval(myMethod, 2);
            topcss = 100

            function myMethod() {
                if (topcss <= 45) {
                    clearInterval(animation)
                }
                document.querySelector('.nudgeList').style.top = topcss + "vh"
                topcss -= 3
            }
        }
    </script>
    <?php endif; ?>
</body>

</html>