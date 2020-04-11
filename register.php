<?php
    include_once(__DIR__ . "/classes/User.php");

    if(!empty($_POST)) {

        try {
            $user = new User();
            $user->setName(htmlspecialchars($_POST['name']));
            $user->setEmail(htmlspecialchars($_POST['email']));
            $user->setPassword($_POST['password']);

            if($_POST['password'] != $_POST['passwordconfirmation']) {
                $error = "Password and confirmation do not match!";
            }

            if ( $user->availableEmail($user->getEmail()) ) {
                // Email ready to use
                if ( $user->validEmail($_POST['email']) === true ){
                    // valid email
                } else {
                    $error = "Ongeldig email!";
                }
            } 
            else {
                $error = "Email is al in gebruik!";
            }

        } catch (\Throwable $th) {
            $error = $th->getMessage();
        }


        if(!isset($error)) {
            // methode
            $user->save();

            //$succes = "user saved";
            header('Location: login.php');
        }

    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeGrown-Register</title>
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,500,700&display=swap" rel="stylesheet">
</head>
<body class="gradient">
    <div class="login">
        <div class="form form--login">
                <form action="" method="POST" enctype="multipart/form-data">
                
                    <?php if(isset($error)): ?>
                        <div class="form__error"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <div class="form__field__container">

                        <div class="form__field">
                            <input type="file" class="form-control white" name="avatar" id="avatar">
                        </div>

                        <div class="form__field form__field__input">
                            <img src="images/name.svg" alt="mail icon" class="form__icon">
                            <input type="text" class="form-control white" name="name" id="name" placeholder="Name">
                        </div>

                        <div class="form__field form__field__input">
                            <img src="images/mail.svg" alt="mail icon" class="form__icon">
                            <input type="text" class="form-control white" name="email" id="email" placeholder="Email">
                        </div>

                        <div class="form__field form__field__input">
                            <img src="images/password.svg" alt="mail icon" class="form__icon">
                            <input type="password" class="form-control white" name="password" id="password" placeholder="Password">
                        </div>

                        <div class="form__field form__field__input">
                            <img src="images/password.svg" alt="mail icon" class="form__icon">
                            <input type="password" class="form-control white" name="passwordconfirmation" id="passwordconfirmation" placeholder="Confirm password">
                        </div>

                        <div class="form__field">
                            <input type="submit" value="Login" class="btn btn--primary">    	
                        </div>

                        <div class="form__field">
                            <p>Already have an account?<a href="login.php" class="blue">Login</a></p>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</body>
</html>