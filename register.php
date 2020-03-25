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
</head>
<body>
    <div class="login">
        <div class="form form--login">
                <form action="" method="POST" enctype="multipart/form-data">
                
                    <?php if(isset($error)): ?>
                        <div class="form__error"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <div class="form__field">
                        <input type="file" class="form-control" name="avatar" id="avatar">
                    </div>

                    <div class="form__field">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                    </div>

                    <div class="form__field">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                    </div>

                    <div class="form__field">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    </div>

                    <div class="form__field">
                        <input type="password" class="form-control" name="passwordconfirmation" id="passwordconfirmation" placeholder="Password Confirmation">
                    </div>

                    <div class="form__field">
                        <input type="submit" value="Registreren" class="btn btn--primary">	
                    </div>

                    <div class="form__field">
                        <p>Already have an account?<a href="login.php">Login</a></p>
                    </div>
                </form>
        </div>
    </div>
</body>
</html>