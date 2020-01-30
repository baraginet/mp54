<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// ============================================================================================
// 마스타팩 extend 스팸 방지
// ============================================================================================

$g5['config_etc_table'] = G5_TABLE_PREFIX . 'config_etc';		// 게시판 설정 기타 테이블

if (!function_exists('masterpack_check_etc_filter')) {
	function masterpack_check_etc_filter($opt='') {
		global $g5, $wr_subject, $wr_content;

		$config_etc = sql_fetch(" select * from {$g5['config_etc_table']} ");
		$filter = explode(",", trim($config_etc['cf_etc_filter']));
		for ($i=0; $i<count($filter); $i++) {
			$str = trim($filter[$i]);	// 필터단어의 앞뒤 공백을 없앰
			if (stripos($wr_subject, addslashes($str)) !== false) {
				//alert("제목에 금지단어(\'{$str}\')가 포함되어 있습니다.");
				alert("금지단어가 포함되어 있습니다.");
				exit;
			}
			if (stripos($wr_content, addslashes($str)) !== false) {
				//alert("내용에 금지단어(\'{$str}\')가 포함되어 있습니다.");
				alert("금지단어가 포함되어 있습니다.");
				exit;
			}
		}
	}
}

if (!function_exists('masterpack_view_spam_tag_remove')) {
	function masterpack_view_spam_tag_remove($opt='') {
		global $g5, $view;

		// 이게 안먹는다. view.head.skin.php 은 $view 를 생성하기 전에 있기 때문에..
		$view['wr_content'] = str_replace('display-none','',$view['wr_content']);
		$view['wr_content'] = str_replace('left: -9999px','',$view['wr_content']);
		$view['wr_content'] = str_replace('top: -9999px','',$view['wr_content']);
	}
}
?>
