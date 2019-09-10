<?php

// if used as cron job, the following line must be used as the very first line, uncommented:
// #!/usr/local/bin/php


// falls als Cron Job gestartet, müssen hier evtl. absolute Pfade rein:
include_once(dirname(__FILE__) . '/vendor/ifsnop/mysqldump-php/src/Ifsnop/Mysqldump/Mysqldump.php');
$dump = new Ifsnop\Mysqldump\Mysqldump('mysql:host=mysite.mysql.db.myhost.com;dbname=dbname', 'dbuser', 'dbpassword');
$now = microtime();
$d = date("Y-m-d-h-i-s");
$dump->start("db-backup-sitename-$d.sql");

