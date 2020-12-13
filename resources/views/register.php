<!DOCTYPE html>
<html>
<head>
	<title>register page</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="csrf_token" content="<?= csrf::_token() ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?= url('css/login-register.css') ?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?= url('js/main.js') ?>"></script>
	<script type="text/javascript" src="<?= url('js/auth.js') ?>"></script>
</head>
<body>
	<h4 class="js-success" style="text-align: center;color: red"></h4>
	<div class="register">
		<div class="register-form default-shadow">
			<div class="logo">
				<img src="<?= url('images/logo.svg') ?>" class="logo-img">
			</div>
			<br>
			<p style="text-align: center;color: red"><b>Administration </b> register</p>
			<br>
			<p style="text-align: center;color: red;display: none;" class="js-message"></p>
			<form action="<?= url('register-new-admin')?>" method="post">
				<?= csrf::input() ?>
				<input type="text" name="name" class="form-control form-input" placeholder=" name">
				<br>
				<input type="text" name="username" class="form-control form-input" placeholder="Email">
				<br>
				<input type="password" name="password" class="form-control form-input" placeholder="password">
				<br>
				<input type="password" name="confirm_password" class="form-control form-input" placeholder="Confirm password">
				<br>
				<input type="text" name="phone" class="form-control form-input" placeholder="(+91) phone">
				<br>
				add captcha here

				<button type="submit" class="btn ui-btn primary-btn ui-round-btn js-submit" style="width: 100%">Create Account</button>
				<div class="d-flex justify-content-between m-2">
					<a href="#">log in</a>
					<a href="#">forgot password</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>