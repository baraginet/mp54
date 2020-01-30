<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">', 1);
add_javascript('<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>', 1);

add_javascript('<script src="https://cdn.jsdelivr.net/jquery.autogrow/1.2.2/jquery.autogrow.js"></script>', 1);
add_javascript('<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>', 1);
add_stylesheet('<link rel="stylesheet" href="' . G5_URL . '/mp/lazyYT/lazyYT.css">', 1);
add_javascript('<script src="' . G5_URL . '/mp/lazyYT/lazyYT.js"></script>', 1);
//add_javascript('<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyloadxt/1.1.0/jquery.lazyloadxt.min.js"></script>', 1);
add_javascript('<script src="' . G5_URL . '/mp/tail.sub.extend.js"></script>', 1);


// 관리자 페이지에도 common.css 추가하기
if (stripos($_SERVER['REQUEST_URI'], "/adm/") !== false) {
	add_stylesheet('<link rel="stylesheet" href="' . G5_URL . '/css/common.css">', 1);
}

//@include_once(G5_PATH.'/inc/adsense.pagelevel.php');

//if ($is_admin) {
//	echo "cookie_theme=" . get_cookie('theme') . "<br>\n";
//	echo "G5_URL=" . G5_URL . "<br>\n";
//	echo "G5_IS_MOBILE=" . G5_IS_MOBILE . "<br>\n";
//	echo "board_skin_path=" . $board_skin_path . "<br>\n";
//	//echo $config['cf_include_index'] . "<br>\n";
//	//echo $config['cf_include_head'] . "<br>\n";
//	//echo $config['cf_include_tail'] . "<br>\n";
//	echo '$_SERVER[\'HTTP_HOST\']=' . $_SERVER['HTTP_HOST'] . "<br>\n";
//	echo '$_SERVER[\'SERVER_NAME\']=' . $_SERVER['SERVER_NAME'] . "<br>\n";
//	echo '$_SERVER[\'PHP_SELF\']=' . $_SERVER['PHP_SELF'] . "<br>\n";
//	echo '$_SERVER[\'SCRIPT_NAME\']=' . $_SERVER['SCRIPT_NAME'] . "<br>\n";
//	echo '$_SERVER[\'REQUEST_URI\']=' . $_SERVER['REQUEST_URI'] . "<br>\n";
//	echo '$_SERVER[\'REMOTE_ADDR\']=' . $_SERVER['REMOTE_ADDR'] . "<br>\n";
//	echo '$_SERVER[\'HTTP_REFERER\']=' . $_SERVER['HTTP_REFERER'] . "<br>\n";
//	echo '$_SERVER[\'HTTP_USER_AGENT\']=' . $_SERVER['HTTP_USER_AGENT'] . "<br>\n";
//	echo '$_SERVER[\'HTTPS\']=' . $_SERVER['HTTPS'] . "<br>\n";
//	//echo "COOKIE=\n" . print_r($_COOKIE,true) . "<br>\n";
//	//echo "SESSION=\n" . print_r($_SESSION,true) . "<br>\n";
//}

if ($is_admin) {
//	$시작일 = new DateTime('2012-01-01'); // 20120101 같은 포맷도 잘됨
//	$종료일 = new DateTime('2012-10-11');
//
//	// $차이 는 DateInterval 객체. var_dump() 찍어보면 대충 감이 옴.
//	$차이    = date_diff($시작일, $종료일);
//
//	echo var_export($차이);
//
//	echo $차이->days; // 284

//	$included_files = get_included_files();
//	foreach ($included_files as $filename) {
//		echo $filename."<br>" . PHP_EOL;
//	}
}
?>
