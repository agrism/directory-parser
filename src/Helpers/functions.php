<?php

// function dump($var){
// 	echo '<pre style="background-color: yellow">'.print_r($var, 1).'</pre>';
// }
//
// function dd($var){
// 	dump($var);die;
// }

function getDirContents($dir, &$results = array())
{
	$files = scandir($dir);

	foreach ($files as $key => $value) {
		$path = realpath($dir . DIRECTORY_SEPARATOR . $value);
		if (!is_dir($path)) {
			$results[] = $path;
		} else if ($value != "." && $value != "..") {
			getDirContents($path, $results);
			$results[] = $path;
		}
	}

	return $results;
}
