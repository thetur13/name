<?php

// Строка для имитации потери соединения с сервером
//header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500); exit;


session_start();
include 'functions.php';
include 'mysql.php';

// Автоматическое удаление задание, если прошло более часа с момента выполнения
mysqli_query($conn, 'DELETE FROM `todo_tasks` WHERE `completed` = 1 AND `date_completed` <= "' . date('Y-m-d H:i:s', time() - 3600) . '";') or die(mysqli_error($conn));


if (isset($_GET['add_task']))
{
	mysqli_query($conn, 'INSERT INTO `todo_tasks` (`sess_id`, `name`, `time_add`) VALUES ("' . mysqli_real_escape_string($conn, $_SESSION['todo_sess']) . '", "' . mysqli_real_escape_string($conn, htmlspecialchars($_POST['taskname'])) . '", "' . date('Y-m-d H:i:s') . '");');
} elseif (isset($_GET['get_tasks']))
{
	$query = mysqli_query($conn, 'SELECT * FROM `todo_tasks` WHERE `sess_id` = "' . mysqli_real_escape_string($conn, $_SESSION['todo_sess']) . '" ORDER BY `time_add` ASC;');
	$tasks = array();
	if ($query && mysqli_num_rows($query) > 0)
	{
		while ($res = mysqli_fetch_array($query))
		{
			$tasks[] = $res;
		}
	}
	echo json_encode($tasks);
} elseif (isset($_GET['del_task']))
{
	mysqli_query($conn, 'DELETE FROM `todo_tasks` WHERE `sess_id` = "' . mysqli_real_escape_string($conn, $_SESSION['todo_sess']) . '" AND `id` = "' . intval($_GET['id']) . '";');
} elseif (isset($_GET['edit_task']))
{
	mysqli_query($conn, 'UPDATE `todo_tasks` SET `name` = "' . mysqli_real_escape_string($conn, $_POST['taskname']) . '" WHERE `sess_id` = "' . mysqli_real_escape_string($conn, $_SESSION['todo_sess']) . '" AND `id` = "' . intval($_GET['id']) . '";');
} elseif (isset($_GET['change_complete']))
{
	if ($_GET['completed'] == 1) $date_completed = date('Y-m-d H:i:s');
	mysqli_query($conn, 'UPDATE `todo_tasks` SET `completed` = "' . intval($_GET['completed']) . '" ' . ($_GET['completed'] == 1 ? ', `date_completed` = "' . mysqli_real_escape_string($conn, $date_completed) . '"':'') . ' WHERE `sess_id` = "' . mysqli_real_escape_string($conn, $_SESSION['todo_sess']) . '" AND `id` = "' . intval($_GET['id']) . '";') or die(mysqli_error($conn)); 	
} elseif (isset($_GET['restore_local_data']))
{
	$tasks = json_decode($_POST['data'], true);
	foreach ($tasks as $task)
	{
		if (isset($task['sess_id']))
		{
			if (!$task['date_completed']) $task['date_completed'] = date('Y-m-d H:i:s');
			mysqli_query($conn, 'UPDATE `todo_tasks` SET `name` = "' . mysqli_real_escape_string($conn, $task['name']) . '", `time_add` = "' . mysqli_real_escape_string($conn, $task['time_add']) . '", `completed` = "' . mysqli_real_escape_string($conn, $task['completed']) . '", `date_completed` = "' . mysqli_real_escape_string($conn, $task['date_completed']) . '" WHERE `id` = "' . mysqli_real_escape_string($conn, $task['id']) . '";') or die(mysqli_error($conn));
		} else {
			mysqli_query($conn, 'INSERT INTO `todo_tasks` (`name`, `sess_id`, `time_add`, `completed`, `date_completed`) VALUES ("' . mysqli_real_escape_string($conn, $task['name']) . '", "' . mysqli_real_escape_string($conn, $_SESSION['todo_sess']) . '", "' . mysqli_real_escape_string($conn, $task['time_add']) . '", "' . mysqli_real_escape_string($conn, $task['completed']) . '", "' . mysqli_real_escape_string($conn, $task['date_completed']) . '");') or die(mysqli_error($conn));
		}
	}
}