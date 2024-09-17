<?php

define('s@>J$qw$i8_5rvY=6d{Z@!,V%J[J4Z^8C3q*bO$%/_db~iy6Fz=eTL/^O-@VKJU{E=U^x,JfooR19xKpgQ*,A/Dbg+9@>J1%.T[sL9#-4!-A8]t', true);
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/db_action.php';


$link_page = 'none';

	//------------------mikro router start-----------------------
	$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	//portal
	//$url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$url = str_replace(ROOT_PATH, '', $url);
	$url = preg_replace('/[^a-z0-9\_\-\/]/', '', substr($url, 0, 255));
	
	$arr_param = explode('/',$url);
	if( $arr_param[0] == '' ){
		$include_page = __DIR__ . '/pages/index.php';
	}elseif(file_exists(__DIR__ . '/pages/'.$arr_param[0].'.php')){
		$include_page = __DIR__ . '/pages/'.$arr_param[0].'.php';
		$link_page = $arr_param[0];
		if(!empty($arr_param[1])){
			$get_param_1 = $arr_param[1];
		}
	}else{
		$include_page = __DIR__ . '/pages/404.php';
	}
	//------------------mikro router end-----------------------
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?=ROOT_PATH?>css/index.css">
	<link rel="stylesheet" href="<?=ROOT_PATH?>css/setka.css">
	<link rel="stylesheet" href="<?=ROOT_PATH?>css/style_menu.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
	
	<script src="<?=ROOT_PATH?>js/jquery-3.7.1.js?banner=off"></script>
	
   

</head>
<body>

    <?php include $include_page?>
</body>
</html>