<?php

// В этом файле находятся примеры запросов на API

$url = 'http://localhost/restful/api.php';
//$user_id = 'qwerty_user'; $auth_key = 'qwerty12345';

$user_id = 'asdf_user'; $auth_key = 'asdf54321';

// 1.       Запрос на вывод параметров: последня дата запроса, количество дней с запросами подряд, кол-во дней с запросами всего
//        Можно запрашивать как один из параметров, так и несколько сразу, перечислив их в массиве
/*$data = array('user_id' => $user_id, 'auth_key' => $auth_key, 'act' => array(
	'get_lasttime_query',
	'get_count_days',
	'get_count_days_all'
));
echo "Submitted request\n" . print_r($data, true) . "\n\n";
echo "Answer:\n" . get_page_curl($url, $data) . "\n\n";
exit;*/




//  2.     Занесение в базу данных пользователя
/*$data = array('user_id' => $user_id, 'auth_key' => $auth_key, 'act' => 'save_objects', 
'list_objects' => array(
		'asd' => 'привет',
		'qwe' => 'qwe data for qwerty_user',
		'zxc' => 'hello'
	)

);
echo "Submitted request\n" . print_r($data, true) . "\n\n";
echo "Answer:\n" . get_page_curl($url, $data) . "\n\n";
exit; 
*/






//  3.        Запрос данных пользователя: asd, qwe и zxc
/*$data = array('user_id' => $user_id, 'auth_key' => $auth_key, 'act' => 'get_data', 
'list_objects' => array(
		'asd',
		'qwe',
		'zxc'
	)

);
echo "Submitted request\n" . print_r($data, true) . "\n\n";
echo "Answer:\n" . get_page_curl($url, $data) . "\n\n";
exit;*/




/*//  4.        Создание нового пользователя
$data = array('user_id' => $user_id, 'auth_key' => $auth_key, 'act' => 'create_user', 
'user_data' => array(
		'user_id' => 'new user_id',
		'auth_key' => 'new auth key'
	)

);
echo "Submitted request\n" . print_r($data, true) . "\n\n";
echo "Answer:\n" . get_page_curl($url, $data) . "\n\n";
exit;*/




//  5.        Удаления существующего пользователя
$data = array('user_id' => $user_id, 'auth_key' => $auth_key, 'act' => 'del_user', 
'user_data' => array(
		'user_id' => 'new user_id',
	)
);
echo "Submitted request\n" . print_r($data, true) . "\n\n";
echo "Answer:\n" . get_page_curl($url, $data) . "\n\n";
exit;




function get_page_curl($url, $postdata)
{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,'data=' . urlencode(json_encode($postdata)));
	return curl_exec($ch);
}