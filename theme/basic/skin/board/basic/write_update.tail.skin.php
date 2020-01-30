<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 관리자가 아닐 경우에만 보낸다.
if (!$is_admin) {

	// 메시지 보내는 것을 write_update.tail.skin.php 에 두는 이유는, $wr_id 가 정해져야 하기 때문이다.
	// Telegram Message 보내기
	// 쓰기와 답변에서만 보낸다. 수정은 안보낸다.
	if ($w == '' || $w == 'r') {
		@include_once(G5_PATH.'/plugin/telegram/telegram.api.php');
		if (function_exists('telegram_sendmessage')) {
			telegram_sendmessage('[게시글] ' . $wr_subject . PHP_EOL . G5_BBS_URL . '/board.php?bo_table=' . $bo_table . '&wr_id=' . $wr_id);
		}
	}

}
?>