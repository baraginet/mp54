<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// ============================================================================================
// masterpack extend - 회원가입 차단
// ============================================================================================

if(strlen(stristr($_SERVER['REQUEST_URI'], "/bbs/register.php")) > 0) {
	alert('죄송합니다. 회원가입은 받지 않습니다.',G5_URL);
	exit();
}
?>
