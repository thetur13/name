<?php


include 'mysql.php';
include 'functions.php';

if (get_magic_quotes_gpc() == 1) $_POST = stripslashes_deep ($_POST);

include 'auth.php';


if (gettype($data['act']) == 'string') $data['act'] = array($data['act']);


// Сохранение информации о датах запросов и их количестве
if ($user_info['count_days'] == 0 || $user_info['count_days_all'] == 0)
{
	mysqli_query($conn, 'UPDATE `users` SET `count_days` = 1, `count_days_all` = 1 WHERE `id` = "' . $user_info['id'] . '";');
} else {
	$lastday_query = date('Y-m-d', strtotime($user_info['lasttime_query']));
	$yesterday = date('Y-m-d', strtotime("yesterday"));
	$today = date('Y-m-d');
	if ($lastday_query == $yesterday)
	{
		mysqli_query($conn, 'UPDATE `users` SET `count_days` = `count_days` + 1, `count_days_all` = `count_days_all` + 1 WHERE `id` = "' . $user_info['id'] . '";');
	} elseif ($lastday_query != $today) {
		mysqli_query($conn, 'UPDATE `users` SET `count_days` = 1, `count_days_all` = `count_days_all` + 1 WHERE `id` = "' . $user_info['id'] . '";');
	}
}
mysqli_query($conn, 'UPDATE `users` SET `lasttime_query` = "' . date('Y-m-d H:i:s') . '" WHERE `id` = "' . $user_info['id'] . '";');


// Получение даты последнего запроса
if (in_array('get_lasttime_query', $data['act']))
{
	$result['status'] = 'success';
	$result['lasttime_query'] = $user_info['lasttime_query'] === null ? 'No queries before' : $user_info['lasttime_query'];
}

// Получение непрерывного количества дней запросов
if (in_array('get_count_days', $data['act']))
{
	$result['status'] = 'success';
	$result['count_days'] = $user_info['count_days'];
}

// Получение общего кол-ва дней с запросами
if (in_array('get_count_days_all', $data['act']))
{
	$result['status'] = 'success';
	$result['count_days_all'] = $user_info['count_days_all'];
}

// Получение объектов пользователя
if (in_array('get_data', $data['act']))
{
	if (isset($data['list_objects']))
	{
		$objects = array();
		foreach ($data['list_objects'] as $obj)
		{
			$objects[] = '`name` = "' . mysqli_real_escape_string($conn, $obj) . '"';
		}
		$query = mysqli_query($conn, 'SELECT `name`, `value` FROM `user_data` WHERE `user_id` = "' . $user_info['id'] . '" AND (' . implode(' OR ', $objects). ');');
		if ($query && mysqli_num_rows($query) > 0)
		{
			$result['status'] = 'success';
			while ($res = mysqli_fetch_array($query))
			{
				$result['data'][$res['name']] = $res['value'];
			}
		} else {
			$result['mess'] = 'No data for this objects';
		}
	} else {
		$result['mess'] = 'Pls, send list of objects';
	}
}

// Сохранение объектов пользователя в базу
if (in_array('save_objects', $data['act']))
{
	$inserts = array();
	foreach ($data['list_objects'] as $name=>$val)
	{
		$query = mysqli_query($conn, 'SELECT `id` FROM `user_data` WHERE `user_id` = "' . $user_info['id'] . '" AND `name` = "' . mysqli_real_escape_string($conn, $name) . '";');
		if (mysqli_num_rows($query) == 0)
		{
			$inserts[] = '("' . $user_info['id'] . '", "' . mysqli_real_escape_string($conn, $name) . '", "' . mysqli_real_escape_string($conn, $val) . '")';
		} else {
			$res = mysqli_fetch_array($query);
			mysqli_query($conn, 'UPDATE `user_data` SET `value` = "' . mysqli_real_escape_string($conn, $val) . '" WHERE `id` = "' . $res['id'] . '";');
		}
	}

	if (count($inserts) > 0)
	{
		mysqli_query($conn, 'INSERT INTO `user_data` (`user_id`, `name`, `value`) VALUES ' . implode(',', $inserts) . ';');
	}
	$result['status'] = 'success';
	$result['mess'] = 'Objects saved';
}

// Создание пользователя
if (in_array('create_user', $data['act']))
{	
	if ($data['user_data']['user_id'] == '' || $data['user_data']['auth_key'] == '')
	{
		$result['mess'] = 'Write user_id and auth_key for new user';
	} else {
		$query = mysqli_query($conn, 'SELECT 1 FROM `users` WHERE `user_id` = "' . mysqli_real_escape_string($conn, $data['user_data']['user_id']) . '";');
		if ($query && mysqli_num_rows($query) > 0)
		{
			$result['mess'] = 'User with this user_id already exists';
		} else {
			mysqli_query($conn, 'INSERT INTO `users` (`user_id`, `auth_key`) VALUES ("' . mysqli_real_escape_string($conn, $data['user_data']['user_id']) . '", "' . mysqli_real_escape_string($conn, $data['user_data']['auth_key']) . '");');
			$result['status'] = 'success';
			$result['mess'] = 'User was created';
		}
	}
}

// Удаление пользователя
if (in_array('del_user', $data['act']))
{
	$query = mysqli_query($conn, 'SELECT 1 FROM `users` WHERE `user_id` = "' . mysqli_real_escape_string($conn, $data['user_data']['user_id']) . '";');
	if ($query && mysqli_num_rows($query) > 0)
	{
		mysqli_query($conn, 'DELETE FROM `users` WHERE `user_id` = "' . mysqli_real_escape_string($conn, $data['user_data']['user_id'])		. '";');
		$result['status'] = 'success';
		$result['mess'] = 'User was deleted';
	} else {
		$result['mess'] = 'User with this user_id don\'t exists';
	}
}

echo json_encode($result);
