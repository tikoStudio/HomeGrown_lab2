<?php  
    session_start();
    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
    }

    include_once(__DIR__ . "/classes/User.php");
    $user = new User();
    
    $user->setId($_SESSION['id']);
    $username = $user->getNameFromDatabase();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,500,700&display=swap" rel="stylesheet">
    <title>Gps location</title>
</head>
<body class="gps">
    <div class="gps__container">
        <h1 class="h1__xl">Hi <?php echo $username['name'] ?>,<br>Welcome to <br>Home<span class="green">Grown</span> </h1>
        <p>Please allow GPS Functions for Homegrown to find community and farms suggestions near you.</p>

        <div class="form__field">
          <a href="index.php"> <input type="submit" value="Turn on" class="btn btn--primary"></a> 
        </div>
    </div>

</body>
</html>