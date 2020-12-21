<?php require "../db.php"; // подключаем файл для соединения с БД
session_start();?>

<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="https://use.fontawesome.com/af06815fdc.js"></script>


	</style>

    <title>Exchange currency</title>
  </head>


  <body>

  <header>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
		<a class="navbar-brand" href="intro.php" data-ajax="1">
			<img src="logo.png" style="width:54px;">
			ExchCurrency
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
		aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="intro.php" data-ajax="1">Главная</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="kursval.php" data-ajax="1">Курсы валют</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="otdel.php" data-ajax="1">Отделения</a>
				</li>
				<li class="nav-item mr-3">
					<!-- Если авторизован выведет логин -->
					<?php if(isset($_SESSION['auth'])) : ?>
					<?php include_once '../www/oneFromDB.php';
					$login = getDB($_SESSION['auth'], $link);?>
					<a href="lichkab.php" data-ajax="1"><?php echo $login['login']; ?></a></br>

					<!-- Пользователь может нажать выйти для выхода из системы -->
					<a href="/www/logout.php"><center>Выйти</center></a>
					<?php else : ?>

					<!-- Если пользователь не авторизован выведем кнопку на авторизацию -->
					<a href="../login.php" data-ajax="1" class="btn btn-outline-secondary mr-3">Войти в аккаунт</a>
					<?php endif; ?>
				</li>
			</ul>
			<form class="form-inline">
				<input class="form-control" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-primary" type="submit">Search</button>
			</form>
		</div>
	</nav>
  </header>

  <main>
	<div class="container">
		<?php if(isset($_SESSION['auth'])) : ?>
			<center><H1>Личный кабинет<H1></center>
			<H6>Добро пожаловать,
			<?php include_once '../www/oneFromDB.php';
			$login = getDB($_SESSION['auth'], $link);
			echo $login['name'];?>
			!</H6>
			<center><H3>Ваша история операций:<H3></center>
			<?php
			$result = mysqli_query($link, "SELECT * FROM lich WHERE login = '$login[login]'");
			if ($result)
			{?>
				<div class="row text-center">
					<div class="col">ID</div>
					<div class="col text-center">DATE</div>
					<div class="col">SUMMA</div>
					<div class="col">VALUTA</div>
					<div class="col">KURS</div>
					<div class="col">OPERACIA</div>
				</div>
				<hr align="center" width="100%" color="Grey"/>
			<?php
					while($res = mysqli_fetch_array($result))
					{
			?>
						<div class="row text-center">
							<div class="col"><?php echo $res['id']?></div>
							<div class="col"><?php echo $res['date']?></div>
							<div class="col"><?php echo $res['summa']?></div>
							<div class="col"><?php echo $res['valuta']?></div>
							<div class="col"><?php echo $res['kursval']?></div>
							<div class="col"><?php echo $res['operac']?></div>
						</div>
						<hr align="center" width="100%" color="Grey"/>
			<?php
					}
			}
			else
			{
				echo ' История операций пуста!';
			}
			?>
		<?php else : ?>
			<H1>Вы не авторизованы!</H1>
			<H6>Войдите в аккаунт и повторите попытку снова.</H6>
		<?php endif; ?>
	</div>
  </main>
  <?php require_once "footer.php"; ?>
  <script src="/jsscripts/ajax.js"></script><link rel="stylesheet" href="/css/animate.css"></link>
  </body>
</html>
