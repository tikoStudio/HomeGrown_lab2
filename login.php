<?php
    include_once(__DIR__ . "/classes/User.php");
    $user = new User();

    if (!empty($_POST)) {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        
        if (!empty($email) && !empty($password)) {
            if ($user->checkLogin($email, $password)) {
                session_start();
                $user->setEmail($email);
                $idArray = $user->idFromSession($email);
                $id = $idArray['id'];
                $user->setId($id);

                // later aanpassen -> if checkbox is ticked use cookie
                $_SESSION["user"] = $email;
                $_SESSION["id"] = $id;
                
                //redirect to index.php
                header("Location: gpsLocation.php");
            } else {
                $error = "Password and email are not correct";
            }
        } else {
            $error = "email and password are required";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>HomeGrown-Login</title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,500,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
</head>

<body class="gradient">
	<div class="login">
		<div class="form form--login">
			<form action="" method="post">
				<img class="form__image" src="images/logo.svg" alt="HomeGrown logo">
				<h1 form__title>HomeGrown</h1>

				<?php if (isset($error)) : ?>
				<div class="form__error">
					<p>
						<?php echo $error; ?>
					</p>
				</div>
				<?php endif; ?>

				<div class="form__field__container">

					<div class="form__field form__field__input">
						<img src="images/mail.svg" alt="mail icon" class="form__icon">
						<input type="text" id="email" name="email" placeholder="Email" class="white">
					</div>

					<div class="form__field form__field__input">
						<img src="images/password.svg" alt="mail icon" class="form__icon">
						<input type="password" id="password" name="password" placeholder="Password" class="white">
					</div>

					<div class="form__field form__link">
						<a href="#" class="form__biglink">Forgot password?</a>
					</div>

					<div class="form__field">
						<input type="submit" value="Log in" class="btn btn--primary">
					</div>

				</div>

				<div class="form__field form__change">
					<a href="register.php">Create new account</a>
				</div>
			</form>
		</div>
	</div>
</body>

</html>