<?php
defined('s@>J$qw$i8_5rvY=6d{Z@!,V%J[J4Z^8C3q*bO$%/_db~iy6Fz=eTL/^O-@VKJU{E=U^x,JfooR19xKpgQ*,A/Dbg+9@>J1%.T[sL9#-4!-A8]t') or die('Доступ запрещён!');

set_time_limit(30);
date_default_timezone_set('Europe/Moscow');
//php.ini
//date.timezone = Europe/Moscow
session_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
//ini_set('display_errors', 'Off');
//error_reporting(0);

//mysqli_report(MYSQLI_REPORT_ALL);
//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // MYSQLI_REPORT_ALL


// -------------localhost-------------
// define('ROOT_PATH','http://localhost/portal3/dasha/'); //http://localhost/project/
// define('BD_HOST','127.0.0.1'); //localhost
// define('BD_USER','admin'); //root
// define('BD_PASS','123456789'); //''
// define('BD_NAME','portal'); //project

// -------------server-------------
define('ROOT_PATH','http://localhost/projects/mt_group/');
define('BD_HOST','localhost');
define('BD_USER','root');
define('BD_PASS','');
define('BD_NAME','project');


// define('ROOT_PATH','http://otremontik.ru/test/monitor/');
// define('BD_HOST','localhost');
// define('BD_USER','dasha');
// define('BD_PASS','iH2aP2vC6s');
// define('BD_NAME','monitor');


// define('ROOT_PATH','http://stillchick-39959.smrtp.ru/test/user_page/');
// define('BD_HOST','localhost');
// define('BD_USER','dasha_up');
// define('BD_PASS','zI5fE1kY8x');
// define('BD_NAME','user_page');