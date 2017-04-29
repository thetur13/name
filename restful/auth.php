<?php

$result = array('status' => 'fail');

if (isset($_POST['data']))
{
	$data = json_decode($_POST['data'], true);

} else {
	exit(json_encode(array('status' => 'fail', 'mess' => 'Empty query, user POST arguments')));
}

$query = mysqli_query($conn, 'SELECT * FROM `users` WHERE `user_id` = "' . mysqli_real_escape_string($conn, $data['user_id']) . '" AND `auth_key` = "' . mysqli_real_escape_string($conn, $data['auth_key']) . '" LIMIT 1;');
if (mysqli_num_rows($query) == 0)
{
	$result['mess'] = 'Wrong user_id OR auth_key';
	exit(json_encode($result));
} else {
	$user_info = mysqli_fetch_array($query);
	
	
	// Следующий год реализует 3-ю дополнительную задачу о лимитировании запросов, но так как на сервере не удается поставить memcache, то и протестировать его не получается.
	// Поэтому оставляю закомментированным
	/*
	$memcache = new Memcached();
	$memcache->addServer('localhost', 11211);

	if (!($limit = $memcache->get('limit_' . $user_info['user_id']))) 
	{
		if ($memcache->getResultCode() == Memcached::RES_NOTFOUND) 
		{
			$memcache->add('limit_' . $user_info['user_id'], 1, false, $user_info['num_seconds_limit']);
			file_put_contents('tmp/limit_' . $user_info['user_id'], 1);
		}
	} else {
		$limit = intval(file_get_contents('tmp/limit_' . $user_info['user_id']));
		if ($limit > $user_info['num_seconds_limit'])
		{
			$result['mess'] = 'Too many requests per ' . $user_info['num_seconds_limit'] . ' seconds';
			exit(json_encode($result));
		} else {
			$limit++;
			file_put_contents('tmp/limit_' . $user_info['user_id'], $limit);
		}
	}
	*/
	
}
