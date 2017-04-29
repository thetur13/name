<?php

function stripslashes_deep ($data)
{
	if(is_array($data)) {
		foreach($data as $key => $value) {
			if(is_array($value)) {
				$data[$key] = stripslashes_deep ($value);
			} else {
				$data[$key] = stripslashes ($value);
			}
		}
	} else {
		$data = stripslashes($data);
	}
	return $data;
}