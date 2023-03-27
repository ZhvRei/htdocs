<?php 
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	
	include("rights/right.php");
?>

<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php 
	if($_COOKIE['user'] == '') {
		echo "<title>Форма регистрации</title>";
	} else {
		echo "<title>Образовательные программы</title>";
	}
	?>
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container mt-4">
		<?php
			if($_COOKIE['user'] == ''):
		?>
		<div class="row">
			<div class="col">
				<h1>Форма регистрации</h1>
				<form action="validation-form/check.php" method="post">
					<input type="text" class="form-control" name="login" id="login" placeholder="Введите логин"> <br />
					<input type="text" class="form-control" name="name" id="name" placeholder="Введите имя"> <br />
					<input type="password" class="form-control" name="pass" id="pass" placeholder="Введите пароль"> <br />
					<button class="btn btn-success" type="submit">Зарегистрировать</button>
				</form>
			</div>
			<div class="col">
				<h1>Форма авторизации</h1>
				<form action="validation-form/auth.php" method="post">
					<input type="text" class="form-control" name="login" id="login" placeholder="Введите логин"> <br />
					<input type="password" class="form-control" name="pass" id="pass" placeholder="Введите пароль"> <br />
					<button class="btn btn-success" type="submit">Авторизоваться</button>
				</form>
			</div>
		</div>
		<?php else: ?>
			<div>
				<p>Здравствуйте, <?=$_COOKIE['user']?>! Чтобы выйти из учетной записи нажмите <a href="/exit.php">здесь</a></p> <br />
				
				<?php
				if (has_right("admin") or has_right("educator")) {
					echo "<a href='addition.php' class='btn btn-outline-primary' role='button' aria-pressed='true'>Добавить информацию</a>";
				} 
				?>
				
			</div>
		<?php			
			require "table.php";
		endif ?>

	</div>
</body>
</html>


