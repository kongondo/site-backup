<?php

/*

shebang for use as cron job:
#!/usr/local/bin/php

 * PHP: Recursively Backup Files & Folders to ZIP-File
 * MIT-License - Copyright (c) 2012-2017 Marvin Menzerath
*/


$d = date("Y.m.d-H.i.s");
$sitename = 'my-site-name-db';
$from = '/home/myserver/www/mydir/mysite/site'; // absolute path to source directory, without trailing slash
$to = "/home/myserver/www/mydir/mysite/backups/files-backup-$sitename-$d.zip"; // destination path


// Make sure the script can handle large folders/files
ini_set('max_execution_time', 6000);
ini_set('memory_limit','2048M');
set_time_limit(0);


// Start the backup
zipData($from, $to);

header("Content-Type: text/html; charset=utf-8");


// Here the magic happens :)
function zipData($source, $destination) {
	if (extension_loaded('zip')) {
		if (file_exists($source)) {
			$zip = new ZipArchive();
			if ($zip->open($destination, ZIPARCHIVE::CREATE)) {
				$source = realpath($source);
				if (is_dir($source)) {
					$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
					foreach ($files as $file) {
						$file = realpath($file);
						if (is_dir($file)) {
							$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
						} else if (is_file($file)) {
							$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
						}
					}
				} else if (is_file($source)) {
					$zip->addFromString(basename($source), file_get_contents($source));
				}
			}
			return $zip->close();
		}
	}
	return false;
}

