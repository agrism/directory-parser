<?php

include 'vendor/autoload.php';


$env = require './env.php';

$dir = $env['directory'];


foreach ($env['cycles'] as $item) {

	$found = 0;
	foreach (getDirContents($dir) as $index => $path) {

		if ($index === 9) {
			dump($item['pattern']);
		}

		if (in_array($path, $item['exclude'] ?? [])) {
			continue;
		}

		if (in_array(substr($path, -3), ['.js', 'pdf', 'png', 'jpg', 'ttf', 'css', '.md',
			'tml', 'psd', 'mp4', 'peg', 'ico', 'txt', 'sdl'])) {
			continue;
		}

		if (strpos($path, 'node_modules') != false) {
			continue;
		}

		if (strpos($path, 'vendor') != false) {
			continue;
		}

		if (strpos($path, 'lib/remote') != false) {
			continue;
		}

		if (strpos($path, 'system/temporary') != false) {
			continue;
		}

		$exploded = explode('/', $path);

		$segmentStartWithDot = false;

		foreach ($exploded as $segment) {
			if (strpos($segment, '.') === 0) {

				$segmentStartWithDot = true;
				continue;
			}
		}

		if ($segmentStartWithDot) {
			continue;
		}

		$cmd = 'cat "' . $path . '" ' . $item['pattern'];

		$output = '';

		exec($cmd, $output);

		if ($output) {
			dump([
				'order' => ++$found,
				'path' => $path,
				'content' => $output,
			]);

		}

		if ($found > 100) {
			dd('more than 100');
		}

	}
}
