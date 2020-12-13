<!DOCTYPE html>
<html>
<head>
	<title>login <?= $_GET['role']; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,700,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?= url('css/login-register.css') ?>">
</head>
<body>
	<h3 class="p-5 text-center js-message " style="display: none;"></h3>
	<div class="login">
		<div class="login-form default-shadow">
			<div class="logo">
				<img src="<?= url('images/logo.svg') ?>" class="logo-img">
			</div>
			<br>
			<p style="text-align: center;color: red"><span class="js-login"><b><?= $_GET['role']; ?> </b></span> login</p>
			<p style="text-align: center;color: red"><?= $message; ?></p>
			<form action="<?= url('login') ?>" method="post">
				<?= csrf::input() ?>
				<input type="text" name="username" class="form-control form-input" placeholder="your Email">
				<br>
				<input type="password" name="password" class="form-control form-input" placeholder="password">
				<br>
				add captcha here
				<button type="submit" class="btn ui-btn primary-btn ui-round-btn" style="width: 100%" class="g-recaptcha" data-sitekey="reCAPTCHA_site_key" data-callback='onSubmit' data-action='submit'>Log in</button>
				<div class="d-flex justify-content-between m-2">
					<a href="#" class="js-signUp">sign up</a>
					<a href="#">forgot password</a>
				</div>
			</form>
		</div>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript" src="<?= url('js/main.js') ?>"></script>

	<?php if ($_GET['role'] == 'Admin'): ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.js-signUp').click(function () {
					window.location.href = appUrl("register-new-administrator");
				});
			});
		</script>
	<?php endif; ?>
	<?php if ($_GET['role'] == 'Agent'): ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.js-signUp').click(function (ev) {
					$('.js-message').text('agent can register only through admin dashboard!!');
					$('.js-message').css({"display":"block"});
				});
			});
		</script>
	<?php endif ?>
</body>
</html>