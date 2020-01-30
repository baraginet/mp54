<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// tail.sub.php
add_event('tail_sub', 'masterpack_hook_tail_sub');
function masterpack_hook_tail_sub() {
	@include_once(G5_PATH."/mp/tail.sub.extend.php");
}

// bbs/logout.php
add_event('member_logout', 'masterpack_hook_member_logout');
function masterpack_hook_member_logout() {
	global $url, $link;
	if (!$link) $link = G5_URL . '/';
}
?>
