<?php
if (!defined('_GNUBOARD_')) exit;

// 전체 url 구하기
$fullurl = "http" . (($_SERVER['HTTPS'] == "on") ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

// 도메인 변경하기 : g5.baragi.net -> www.baragi.net
if (stripos($fullurl,'//g5.baragi.net') !== false) {
	goto_url(str_replace("//g5.baragi.net", "//www.baragi.net", $fullurl));
	//exit();	// goto_url 함수 안에 exit 가 있다.
}
// page 폴더 경로로 이동시키기
if (stripos($_SERVER['REQUEST_URI'], "/bbs/board.php?bo_table=festival") !== false) {
	goto_url(str_replace("/bbs/board.php?bo_table=festival", "/page/tour/board.php?bo_table=festival", $_SERVER['REQUEST_URI']));
}
if (stripos($_SERVER['REQUEST_URI'], "/bbs/board.php?bo_table=course") !== false) {
	goto_url(str_replace("/bbs/board.php?bo_table=course", "/page/tour/board.php?bo_table=course", $_SERVER['REQUEST_URI']));
}
if (stripos($_SERVER['REQUEST_URI'], "/bbs/board.php?bo_table=stay") !== false) {
	goto_url(str_replace("/bbs/board.php?bo_table=stay", "/page/tour/board.php?bo_table=stay", $_SERVER['REQUEST_URI']));
}
if (stripos($_SERVER['REQUEST_URI'], "/bbs/board.php?bo_table=area") !== false) {
	goto_url(str_replace("/bbs/board.php?bo_table=area", "/page/tour/board.php?bo_table=area", $_SERVER['REQUEST_URI']));
}
if (stripos($_SERVER['REQUEST_URI'], "/bbs/board.php?bo_table=movieinfo") !== false) {
	goto_url(str_replace("/bbs/board.php?bo_table=movieinfo", "/page/movie/board.php?bo_table=movieinfo", $_SERVER['REQUEST_URI']));
}
if (stripos($_SERVER['REQUEST_URI'], "/bbs/board.php?bo_table=moviecompany") !== false) {
	goto_url(str_replace("/bbs/board.php?bo_table=moviecompany", "/page/movie/board.php?bo_table=moviecompany", $_SERVER['REQUEST_URI']));
}

/*
	// stripos 함수로 변경하고, 옛것은 참고로 남겨 둔다.
	// 참고 : haystack 안에 needle이 있는지만 확인하려면, 빠르고 메모리도 적게 사용하는 strpos(), stripos()를 사용하십시오.
	// http://php.net/manual/kr/function.stripos.php

// 도메인 변경하기 : g5.baragi.net -> www.baragi.net
if(strlen(stristr($fullurl, "//g5.baragi.net")) > 0) {
	header('Location: ' . str_replace("//g5.baragi.net", "//www.baragi.net", $fullurl));
	exit();
}
// page 폴더 경로로 이동시키기
if(strlen(stristr($_SERVER['REQUEST_URI'], "/bbs/board.php?bo_table=festival")) > 0) {
	header('Location: ' . str_replace("/bbs/board.php?bo_table=festival", "/page/tour/board.php?bo_table=festival", $_SERVER['REQUEST_URI']));
	exit();
}
if(strlen(stristr($_SERVER['REQUEST_URI'], "/bbs/board.php?bo_table=course")) > 0) {
	header('Location: ' . str_replace("/bbs/board.php?bo_table=course", "/page/tour/board.php?bo_table=course", $_SERVER['REQUEST_URI']));
	exit();
}
if(strlen(stristr($_SERVER['REQUEST_URI'], "/bbs/board.php?bo_table=stay")) > 0) {
	header('Location: ' . str_replace("/bbs/board.php?bo_table=stay", "/page/tour/board.php?bo_table=stay", $_SERVER['REQUEST_URI']));
	exit();
}
if(strlen(stristr($_SERVER['REQUEST_URI'], "/bbs/board.php?bo_table=area")) > 0) {
	header('Location: ' . str_replace("/bbs/board.php?bo_table=area", "/page/tour/board.php?bo_table=area", $_SERVER['REQUEST_URI']));
	exit();
}
if(strlen(stristr($_SERVER['REQUEST_URI'], "/bbs/board.php?bo_table=movieinfo")) > 0) {
	header('Location: ' . str_replace("/bbs/board.php?bo_table=movieinfo", "/page/movie/board.php?bo_table=movieinfo", $_SERVER['REQUEST_URI']));
	exit();
}
if(strlen(stristr($_SERVER['REQUEST_URI'], "/bbs/board.php?bo_table=moviecompany")) > 0) {
	header('Location: ' . str_replace("/bbs/board.php?bo_table=moviecompany", "/page/movie/board.php?bo_table=moviecompany", $_SERVER['REQUEST_URI']));
	exit();
}
*/
?>
