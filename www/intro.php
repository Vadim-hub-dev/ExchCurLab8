<?php
	require "../db.php"; // подключаем файл для соединения с БД
	session_start();
	// Создаем переменную для сбора данных от пользователя по методу POST

	/*
		Если пользователь не авторизован (проверяем по сессии) -
		тогда проверим его куки, если в куках есть логин и ключ,
		то пробьем их по базе данных.
		Если пара логин-ключ подходит - пишем авторизуем пользователя.

		Если пользователь авторизован - ничего не делаем.

		Если пустая переменная auth из сессии ИЛИ она равна false (для авторизованного она true).
	*/
	if (empty($_SESSION['auth']) or $_SESSION['auth'] == false)
	{
		//Проверяем, не пустые ли нужные нам куки...
		if ( !empty($_COOKIE['login']) and !empty($_COOKIE['key']) )
		{
			//Пишем логин и ключ из КУК в переменные (для удобства работы):
			$login = $_COOKIE['login'];
			$key = $_COOKIE['key']; //ключ из кук (аналог пароля, в базе поле cookie)

			//Выбираем из таблицы БД строку с нашим логином
			$result = mysqli_query($link, "SELECT * FROM users WHERE login='$login' AND cookie='$key' LIMIT 1");
			$res = mysqli_fetch_array($result);

			//Если база данных вернула не пустой ответ - значит пара логин-ключ к кукам подошла...
			if (!empty($res))
			{
				//Пишем в сессию информацию о том, что мы авторизовались:
				$_SESSION['auth'] = $res['id'];

			}
		}
	}
?>

<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	   <link rel="stylesheet" href="/css/animate.css"></link>
     <script src="https://use.fontawesome.com/af06815fdc.js"></script>

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
				<li class="nav-item active">
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
					<a href="login.php" class="btn btn-outline-secondary mr-3" data-ajax="1">Войти в аккаунт</a>
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
	<?php include_once '../www/headings.php'; ?>
	<div class ="container text-center">
		<a class = "text-center"><h2>Список книг, после прочтения которых вы будете разбираться в бирже валют</h2></a>
		<?php echo $text; ?>
	</div>


	<div class="container-fluid pt-5">
		<div class="row">
			<div class="col-3"></div>
			<div class="col-6 text-center"><H1>Почему выбирают нас?</H1></div>
			<div class="col-3"></div>
		</div>
	</div>
	<div class="container">
		<div class="row" style="height: 450px;">
			<div class="col text-center align-self-start" style="outline-style : solid; outline-width : 3px; outline-color : rgb(0, 173, 255);">
			<br></br>
			<img src="act.png" style="width:100px;">
			<br><h3>Актуально</h3></br>
			<p>Мы ежедневно собираем и обновляем информацию банков по всей России.</p>
			</div>
			<div class="col-1">
			</div>
			<div class="col text-center align-self-center" style="outline-style : solid; outline-width : 3px; outline-color : rgb(0, 173, 255);">
			<br></br>
			<img src="econom.png" style="width:100px;">
			<br><h3>Выгодно</h3></br>
			<p>Вы сможете найти выгодные предложения, что сэкономит не только ваши деньги, но и время.</p>
			</div>
			<div class="col-1">
			</div>
			<div class="col text-center align-self-end" style="outline-style : solid; outline-width : 3px; outline-color : rgb(0, 173, 255);">
			<br></br>
			<img src="nadezh.png" style="width:100px;">
			<br><h3>Безопасно</h3></br>
			<p>Все данные, которые вы оставляете на сайте, надежно защищены протоколом SSL.</p>
			</div>
		</div>
	</div>
	</main>
	<?php require_once "footer.php"; ?>

  <script src="/jsscripts/ajax.js"></script><link rel="stylesheet" href="/css/animate.css"></link>
  </body>
</html>
