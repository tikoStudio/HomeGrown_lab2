<?php  
	include_once(__DIR__ . "/classes/User.php");
	$user = new User();

    if(!empty($_POST)) {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        
        if(!empty($email) && !empty($password)){
            if($user->checkLogin($email, $password)){
                session_start();
                $_SESSION["user"] = $email;
                
                //redirect to index.php
                header("Location: index.php");
            }else{
                $error = "Password and email are not correct";
            }
        }else {
            $error = "email and password are required";
        }
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>HomeGrown-Login</title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body class="gradient">
    <div class="login">
		<div class="form form--login">
			<form action="" method="post">
				<img class="form__image" src="https://via.placeholder.com/200x250" alt="HomeGrown logo">
				<h1 form__title>HomeGrown</h1>

				<?php if(isset($error)) : ?>
				<div class="form__error">
					<p>
						<?php echo $error; ?>
					</p>
				</div>
				<?php endif; ?>

				<div class="form__field__container">

					<div class="form__field">
						<input type="text" id="email" name="email" placeholder="Email">
					</div>

					<div class="form__field">
						<input type="password" id="password" name="password" placeholder="Password">
					</div>

					<div class="form__field form__link">
						<a href="#">Forgot password?</a>
					</div>

					<div class="form__field">
						<input type="submit" value="Login" class="btn btn--primary">	
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