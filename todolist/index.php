<?php
session_start();
include 'functions.php';
include 'mysql.php';

?>
<html>
<head>
<title> Список дел </title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/sweetalert.css" />
<script src="js/sweetalert.min.js"></script>
<script src='js/jquery.js'></script>
<script src='js/functions.js'></script>
<script src='js/script.js'></script>
</head>
<body>

  <body>
<div class="container">
<br />
	Вы можете открыть <a target=_blank href="index.php?sess=<?=$_SESSION['todo_sess']?>">ссылку</a> на другом устройстве и возобновить сеанс.
<div class="row">

    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		
			<h2></h2>
			<hr class="colorgraph">
			<div class="row">
				<textarea cols=50 rows=5 id="taskname" id="border-width_table" placeholder = "Описания задания" ></textarea><br /><br />
				<button class="btn btn-primary" onClick="add_task()">Добавить задание</button>
			</div>
		
	</div>
</div>

<table id="tasks" class="table table-bordered">
<thead>
<tr><th>ID</th><th>Задание</th><th>Выполнено</th><th>Дата добавления</th><th>Действие</th></tr>
</thead>
<tbody>
</tbody>
</table>

<br /><div class="highlight" id="offline"></div>

</div>


</body>
</htmL>