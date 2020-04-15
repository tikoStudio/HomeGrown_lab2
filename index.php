<?php  
    session_start();
    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
    }
?><!DOCTYPE html>
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

    <a href="community.php">
        <div class="community__container">
            <div class="community__title__container">
                <h2>Current Communities</h2>
                <p>See All (2)</p>
            </div>
            <div class="community__data__container">
            <div class="label"><p>Member</p></div>
                <div class="community__img">
                    <img src="images/cucumber.png" alt="farming resource picture">
                </div>
                <div class="community__info">
                <h3>Luis Coosmans, Vi...</h3>
                    <div class="farming"><p>tomatoes</p></div>
                    <div class="farming"><p>cucumbers</p></div>
                </div>
                <p class=community__adress>28 verbleekstraat, Rijmenam 2820</p>
            </div>
        </div>
    </a>

    <div class="community__container community__nearby">
        <div class="community__title__container">
            <h2>Communities around you</h2>
            <p>See All (7)</p>
        </div>
        <div class="community__data__container">
        <div class="label--green label"><p>Looking for members</p></div>
            <div class="community__img">
                <img src="images/tomatoes.jpg" alt="farming resource picture">
            </div>
            <div class="community__info">
            <h3>Veeman, Dré en Co.</h3>
                <div class="farming"><p>tomatoes</p></div>
                <div class="farming"><p>tangerine</p></div>
            </div>
            <p class=community__adress>17 Ravendreef, Bonheiden 2820</p>
        </div>
    </div>
    <?php include_once("footer.inc.php"); ?>
</body>
</html>