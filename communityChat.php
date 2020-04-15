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
    <title>Chat</title>
</head>
<body>
    
    <div class="community__container community__container--top">
        <h1 class="h1--members">Luis Coosmans, Victoria Dasman and Gary Leekman </h1>
    </div>
    <div class="chatbox">
        <div class="chatbox__messages">
            <div class="chatbox__header"><h4 class="chatbox__user">Luis Coosmans</h4><h4 class="chatbox__user">11:50</h4></div>
            <p>Lorem ipsum dolor sit amet.</p>
        </div>

        <div class="send">
            <div class="chatbox__messages chatbox__messages--me">
            <div class="chatbox__header"><h4 class="chatbox__user"></h4><h4 class="chatbox__user">11:50</h4></div>
                <p>delete and loop the other one.</p>
            </div>
        </div>
        
    </div>
    <form action="" method="POST" class="form__messages">
        <input type="text" placeholder="Type a message ..." name="message" class="input__message">
        <input type="submit" value="" class="input__send__message">
        <img src="images/plus.svg" alt="send text" class="send__message__img">
    </form>
    
    <?php include_once("footer.inc.php"); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/chat.js"></script>
</body>
</html>