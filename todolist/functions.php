<?php

function get_session()
{
	if (isset($_GET['sess'])) $_SESSION['todo_sess'] = preg_replace('#[^a-z0-9]+#', '', $_GET['sess']);
	if (!isset($_SESSION['todo_sess']))
	{
		$_SESSION['todo_sess'] = md5(time() . rand(0, 10000000));
	}
}

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

function iconv_deep ($fromCodepage, $toCodepage, $data) 
{
	if(is_array($data)) {
		foreach($data as $key => $value) {
			if(is_array($value)) {
				$data[$key] = iconv_deep($fromCodepage, $toCodepage, $value);
			} else {
				$data[$key] = iconv($fromCodepage, $toCodepage . '//TRANSLIT', $value);
			}
		}
	} else {
		$data = iconv($fromCodepage, $toCodepage,$data);
	}
	return $data;
}

if (!function_exists('transliterate'))
{
	function transliterate($st) {

	  $st = strtr ($st, "абвгдезийклмнопрстуфхцыэ", "abvgdeziyklmnoprstufhcye");
		$st = strtr ($st, "АБВГДЕЗИЙКЛМНОПРСТУФХЦЫЭ", "ABVGDEZIYKLMNOPRSTUFHCYE");
    // Затем - "многосимвольные".

		$st = trim($st);
	
   	$st=strtr($st, 

                    array(
                    
                    

                        "ж"=>"zh", "ё"=>"yo", "ч"=>"ch", "ш"=>"sh", 

                        "щ"=>"sch","ь"=>"", "ю"=>"yu", "я"=>"ya", "ъ" => "",

                        "Ж"=>"ZH", "Ё"=>"YO", "Ч"=>"CH", "Ш"=>"SH", 

                        "Щ"=>"SCH","Ь"=>"", "Ю"=>"YU", "Я"=>"YA", "Ъ" => "",
                        
                        "ї"=>"i", "Ї"=>"Yi", "є"=>"ie", "Є"=>"Ye", " "=>"-"

                        )

             );

	  return $st;

	}
}

function to_latin($str, $s = true)
{
	if ($s)
	{
		$str = preg_replace ('#[\s-]#', '_', $str);
		$str = preg_replace ('#_#', '-', $str);
	}
	$str = transliterate ($str);
	if ($s) $str = preg_replace ('#[^a-zA-Z0-9_-]#', '', $str);
	return strtolower($str);
}