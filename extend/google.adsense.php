<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 구글 애드센스 보이기 설정 - 애드센스는 너무 제한사항이 많아서 그것들을 컨트롤 하기 위함이다.

// 기본값은 애드센스를 사용한다.
$google_adsense_view = true;

// 애드센스를 보이지 않을 페이지들
$google_adsense_pages_exclude = array("write.php","write_update.php","write_comment_update.php","current_connect.php","login.php","index.php");

// 애드센스를 보이지 않을 문자열
$google_adsense_string_exclude = array("섹스","sex","성인물(에로)","포르노","모넬라 3","발정난 가정부");


if (in_array(basename($_SERVER['SCRIPT_NAME']),$google_adsense_pages_exclude)) {
	$google_adsense_view = false;
}
//echo var_dump($google_adsense_view);
?>