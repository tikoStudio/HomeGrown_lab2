<?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
    }

    include_once(__DIR__ . "/classes/Message.php");
    $user = new Message();
    $user->setId($_SESSION['id']);
    $user->setCommunityId($_GET['com']);

    $messages = $user->getMessagesFromDatabase();

    if (!empty($_POST) && !empty($_POST['message'])) {
        $user->setMessage($_POST['message']);
        $user->setTime(date("H:i"));
        $user->saveMessage();
        $messages = $user->getMessagesFromDatabase(); //recheck all messages in db
    }

?>
<!DOCTYPE html>
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

    <?php include_once("footer.inc.php"); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/chat.js"></script>
</body>

</html>