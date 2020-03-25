<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeGrown-Login</title>
</head>
<body>
    <div class="login">
		<div class="form form--login">
			<form action="" method="post">
				<h2 form__title>HomeGrown</h2>

				<?php if(isset($error)) : ?>
				<div class="form__error">
					<p>
						<?php echo $error; ?>
					</p>
				</div>
				<?php endif; ?>

                <div class="form__field">
                    <input type="text" id="email" name="email" placeholder="Email">
				</div>

                <div class="form__field">
                    <input type="password" id="password" name="password" placeholder="Password">
				</div>

				<div class="form__field">
                    <a href="#">Forgot password?</a>
				</div>

				<div class="form__field">
					<input type="submit" value="Login" class="btn btn--primary">	
				</div>

				<div class="form__field">
					<a href="register.php">Create new account</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>