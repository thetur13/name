$(document).ready(function()
{
	load_tasks();
})

function send_local_tasks()
{
	$.ajax(
	{
		url: 'act.php?restore_local_data',
		type: 'POST',
		data: 'data=' + encodeURIComponent(localStorage['tasks']),
		success: function(res)
		{
			swal('Локальные данные залиты на сервер', '', 'success');
			$('#offline').html('Соединение с сервером восстановлено');
			localStorage['offline'] = 0;
			load_tasks();
		}
	});
}

function load_tasks()
{
    $.ajax({
        url: 'act.php?get_tasks',
        success: function(res)
        {
			if (localStorage['offline'] == 1)
			{
				$('#offline').html('Соединение с сервером восстановлено');
				send_local_tasks();
				return;
			}
			var data = json_decode(res);
			localStorage['tasks'] = res;
			view_tasks(data);
        },
		error: function(res)
		{
			var data = json_decode(localStorage['tasks']);
			view_tasks(data);
			$('#offline').html('<h2>Соединение с сервером потеряно, данные сохраняются локально</h2>');
			localStorage['offline'] = 1;
		}
    })
}

function view_tasks(data)
{
	if (data.length == 0)
	{
		$('#tasks').find('tbody:first').html('<tr><td colspan=5><center>Не добавлено</center></td></tr>');
	} else {
		$('#tasks').find('tbody:first').html('');
	}
    for (var k in data)
    {
		if (data[k]['completed'] == 1) var checked = ' checked ';
			else var checked = '';
        tr ='<tr><td>' + data[k]['id'] + '</td><td><div class="taskname" contenteditable>' + data[k]['name'] + '</div> <span onClick="edit_task(this, ' + data[k]['id'] + ')" style="cursor:pointer" title="Редактировать" class="glyphicon glyphicon-edit"></span></td><td><input type="checkbox" ' + checked + ' onChange="change_complete(this, ' + data[k]['id'] + ')"></td><td>' +  data[k]['time_add'] + '</td><td><span style="cursor:pointer" onClick="del_task(' + data[k]['id'] + ')" title="Удалить" class="glyphicon glyphicon-remove"></span></td></tr>';
        $('#tasks').append(tr);
    }
	apply_striked();
}
function apply_striked()
{
	$('#tasks').find('tbody:first').find('tr').each(function()
	{
		if ($(this).find('input[type="checkbox"]').is(':checked'))
		{
			$(this).find('div.taskname').addClass('striked');
		} else {
			$(this).find('div.taskname').removeClass('striked');
		}
	});
}

function get_date()
{
	var timestamp = Math.floor(Date.now() / 1000);
	var date = new Date(timestamp*1000);

	var year = date.getFullYear();
	var month = date.getMonth() + 1;
	var day = date.getDate();
	var hours = date.getHours();
	var minutes = date.getMinutes();
	var seconds = date.getSeconds();
	if (month < 10) month = '0' + month;
	if (day < 10) day = '0' + day;	
	return year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
}

function change_complete(el, id)
{
	if ($(el).is(':checked')) var completed = 1;
		else var completed = 0;
	$.ajax({
                url: 'act.php?change_complete&id=' + id + '&completed=' + completed,
                success: function()
                {
					if (localStorage['offline'] == 1)
					{
						$('#offline').html('Соединение с сервером восстановлено');
						send_local_tasks();
						return;
					}
					//swal('Сохранено', '', 'success');
					apply_striked();
                }, error: function()
				{
					localStorage['offline'] = 1;
					$('#offline').html('<h2>Соединение с сервером потеряно, данные сохраняются локально</h2>');
					var data = json_decode(localStorage['tasks']);
					for (k in data)
					{
						if (data[k]['id'] == id)
						{
							data[k]['completed'] = completed;
							if (completed == 1) data[k]['date_completed'] = get_date();
						}
					}
					localStorage['tasks'] = JSON.stringify(data);
					apply_striked();
					//swal('Сохранено', '', 'success');
				}
            })
}

function edit_task(el, id)
{
    swal({
        title: "Вы уверены?",
        text: "Изменить текст задания?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Да',
        cancelButtonText: "Отмена",
        closeOnConfirm: false,
        closeOnCancel: false
    },
        function(isConfirm)
        {
        if (isConfirm)
        {
            $.ajax({
                url: 'act.php?edit_task&id=' + id,
				type: 'POST',
				data: 'taskname=' + encodeURIComponent($(el).prev('div').html()),
                success: function()
                {
					if (localStorage['offline'] == 1)
					{
						$('#offline').html('Соединение с сервером восстановлено');
						send_local_tasks();
						return;
					}
					swal('Сохранено', '', 'success');
                }, error: function()
				{
					localStorage['offline'] = 1;
					$('#offline').html('<h2>Соединение с сервером потеряно, данные сохраняются локально</h2>');
					var data = json_decode(localStorage['tasks']);
					for (k in data)
					{
						if (data[k]['id'] == id) data[k]['name'] = $(el).prev('div').html();
					}
					localStorage['tasks'] = JSON.stringify(data);
					swal('Сохранено', '', 'success');
				}
            })
        } else {
            swal.close();
        }
    });
}

function del_task(id)
{
    swal({
        title: "Вы уверены?",
        text: "Удалить задание?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Удалить',
        cancelButtonText: "Отмена",
        closeOnConfirm: false,
        closeOnCancel: false
    },
        function(isConfirm)
        {
        if (isConfirm)
        {
            $.ajax({
                url: 'act.php?del_task&id=' + id,
                success: function()
                {
					if (localStorage['offline'] == 1)
					{
						$('#offline').html('Соединение с сервером восстановлено');
						send_local_tasks();
						return;
					}
                    load_tasks();
                    swal.close();
                }, error: function()
				{
					localStorage['offline'] = 1;
					$('#offline').html('<h2>Соединение с сервером потеряно, данные сохраняются локально</h2>');
					var data = json_decode(localStorage['tasks']);
					for (k in data)
					{
						if (data[k]['id'] == id)
						{
							data.splice(k, 1);
						}
					}
					localStorage['tasks'] = JSON.stringify(data);
					swal('Сохранено', '', 'success');
				}
            })
        } else {
            swal.close();
        }
    });
}
 
function add_task()
{
	var taskname = $('#taskname').val();
	if (taskname == '')
	{
		swal('Введите имя задания', '', 'error');
		return;
	}
	$.ajax(
	{
		type: 'POST',
		url: 'act.php?add_task',
		data: 'taskname=' + encodeURIComponent(taskname),
		success: function(res)
		{
			swal('Задание добавлено', '', 'success');
			load_tasks();
		}, error: function()
		{
			swal('Добавление заданий оффлайн не работает :(', 'stringify не хотела корректно работать(', 'error');
			return;
			localStorage['offline'] = 1;
			$('#offline').html('<h2>Соединение с сервером потеряно, данные сохраняются локально</h2>');
			var data = json_decode(localStorage['tasks']);
			var newdata = new Array();
			
			var task = {};
			
			task['id'] = get_increment(data);
			task['name'] = taskname;
			task['completed'] = 0;
			task['date_completed'] = get_date();
			task['time_add'] = get_date();
			data.push(task);
			
			task = {};
			
			for (k in data)
			{
				newdata.push(data[k]);
				
			}
//			newdata.push(task);
			alert(print_r(newdata));
			alert(JSON.stringify(newdata));
				return;
			alert(print_r(data));
			
			//localStorage['tasks'] = JSON.stringify(data);
			alert(print_r(data));
			alert(JSON.stringify(data));
			// !@#$%^&
		}
	});
}

function get_increment(tasks)
{
	var m = 0;
	for (k in tasks)
	{
		if (tasks[k]['id'] > m) m = tasks[k]['id'];
	}
	m = parseInt(m) + 1;
	return m;
}