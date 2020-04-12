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
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,500,700&display=swap" rel="stylesheet">
    <title>Community</title>
</head>
<body>
    
<div class="community__container community__container--top">
        <div class="community__data__container community__data__container--xl">
        <div class="label"><p>Member</p></div>
            <div class="community__img">
                <img src="images/cucumber.png" alt="farming resource picture">
            </div>
            <div class="community__info community__info__col">
            <h3>Luis Coosmans, Vi...</h3>
            <div class="farm__container">
                <div class="farming farming--xl"><p>tomatoes</p></div>
                <div class="farming farming--xl"><p>cucumbers</p></div>
            </div>
            </div>
            <p class="community__adress center">28 verbleekstraat, Rijmenam 2820</p>
            <div class="form__field top__container">
                <a href="index.php"> <input type="submit" value="Turn on" class="btn btn--primary btn--reverse"></a> 
            </div>
            <div class="form__field">
                <a href="index.php"> <input type="submit" value="Turn on" class="btn btn--primary btn--reverse"></a> 
            </div>
        </div>
    </div>

    <?php include_once("footer.inc.php"); ?>
</body>
</html>