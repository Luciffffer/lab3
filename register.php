<?php 

	session_start();
	if (isset($_SESSION['username'])) {
		header('location: index.php');
	}

	include_once './database/connection.php';

	function userExists ($email, $pdo) {
		$statement = $pdo->prepare("select * from users where email = :email");
		$statement->bindValue(":email", $_POST['email']);
		$statement->execute();
		return $statement->fetch();
	}

	function insertUser ($email, $password, $pdo) {
		$hash = password_hash($password, PASSWORD_DEFAULT, ["cost" => 12]);
		
		$statement = $pdo->prepare("insert into users (email, password) values (:email, :password)");
		$statement->bindValue(":email", $email);
		$statement->bindValue(":password", $hash);
		$statement->execute();

		$name = explode("@", $email);
		$_SESSION['username'] = $name[0];

		header('location: index.php');
	}

	if (!empty($_POST)) {
		$email = $_POST['email'];
		$password = $_POST['password'];

		if (userExists($email, $pdo) === false) {

			if ($password === $_POST['password_conf']) {
				insertUser($email, $password, $pdo);
			} else {
				$err = "Confirmed password doesn't match password";
			}

		} else {
			$err = 'This email is already in use.';
		}
	}

?><!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
	<div id="header">
		<div class="logo"></div>
	</div>
	<div id="main">
		<h1>Register</h1>
		<div class="loginfb"></div>
		<div class="linel"></div>
		<div class="liner"></div>
		<div id="form">
			<form method="post" action>
				<input name="email" placeholder="Email" type="email" required autofocus /><input name="password" placeholder="Password" type="password" required /><input name="password_conf" placeholder="Confirm Password" type="password" required />
				<h5>
					Remember
				</h5>
				<input class="btn-toggle btn-toggle-round" id="btn-toggle-1" name="remember" type="checkbox" /><label for="btn-toggle-1"></label><input name="register" type="submit" value="Register" />
			</form>
		</div>
		
	</div>

	<?php if (isset($err)) : ?>
		<div class="user-messages-area">
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<ul>
					<li><?php echo $err ?></li>
				</ul>
			</div>
		</div>
	<?php endif; ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>