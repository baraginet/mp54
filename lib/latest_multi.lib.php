<?php
if (!defined('_GNUBOARD_')) exit;

// 다기능 최신글 추출
// ver.2017-08-27  $bo_mobile_subject 추가
// ver.2017-05-16  ca_name_* 추가
// ver.2015-12-23  subject_* 추가
// ver.2015-12-19  file_exist 추가

// $cache_time 캐시 갱신시간, 단위는 시간이며, 0 이면 갱신하지 않는다.
function latest_multi($skin_dir='', $bo_table, $rows=10, $subject_len=40, $cache_time=0, $options='')
{
	global $g5;

	if (!$skin_dir) $skin_dir = 'basic';

	if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
		if (G5_IS_MOBILE) {
			$latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
			if(!is_dir($latest_skin_path))
				$latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
			$latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
		} else {
			$latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
			$latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
		}
		$skin_dir = $match[1];
	} else {
		if(G5_IS_MOBILE) {
			$latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
			$latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
		} else {
			$latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
			$latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
		}
	}
	$latest_skin_url = parse_url($latest_skin_url, PHP_URL_PATH);	// url 에서 프로토콜과 도메인 포트 등 앞부분을 제거한다.
	//echo $latest_skin_url;

	$cache_fwrite = false;
	if(G5_USE_CACHE) {
		$cache_file = G5_DATA_PATH."/cache/latest-{$bo_table}-{$skin_dir}-{$rows}-{$subject_len}.php";

		if(!file_exists($cache_file)) {
			$cache_fwrite = true;
		} else {
			if($cache_time > 0) {
				$filetime = filemtime($cache_file);
				if($filetime && $filetime < (G5_SERVER_TIME - 3600 * $cache_time)) {
					@unlink($cache_file);
					$cache_fwrite = true;
				}
			}

			if(!$cache_fwrite)
				include($cache_file);
		}
	}

	if(!G5_USE_CACHE || $cache_fwrite) {
		$list = array();

		$sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ";
		$board = sql_fetch($sql);
		$bo_subject = get_text($board['bo_subject']);
		$bo_mobile_subject = get_text($board['bo_mobile_subject']);

		$tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름

		$sql_where = " where wr_is_comment = 0 ";
		if (stristr($options, "notice_only"))		$sql_where .= " and INSTR(concat(',','$board[bo_notice]',','),concat(',',wr_id,',')) > 0 ";
		if (stristr($options, "notice_exclude"))	$sql_where .= " and INSTR(concat(',','$board[bo_notice]',','),concat(',',wr_id,',')) = 0 ";
		if (stristr($options, "reply_exclude"))		$sql_where .= " and wr_reply = '' ";
		if (stristr($options, "file_exist"))		$sql_where .= " and wr_file > 0 ";
		//if (stristr($options, "mine_only"))			$sql_where .= " and mb_id = '{$member[mb_id]}' ";	// 이 기능을 사용하려면 global 에 $member 를 추가해야 한다. 하지만, 사용하려 해도 최신글 캐시 기능 때문에 활용이 어렵다.
		//echo $sql_where;

		$sql_order = " order by ";
		if (stristr($options, "notice_up"))			$sql_order .= " case when INSTR(concat(',','$board[bo_notice]',','),concat(',',wr_id,',')) > 0 then 0 else 1 end, ";
		if (stristr($options, "reply_list"))		$sql_order .= " wr_num, wr_reply, ";
		if (stristr($options, "datetime_asc"))		$sql_order .= " wr_datetime asc, ";
		if (stristr($options, "datetime_desc"))		$sql_order .= " wr_datetime desc, ";
		if (stristr($options, "hit_asc"))			$sql_order .= " wr_hit asc, ";
		if (stristr($options, "hit_desc"))			$sql_order .= " wr_hit desc, ";
		if (stristr($options, "last_asc"))			$sql_order .= " wr_last asc, ";
		if (stristr($options, "last_desc"))			$sql_order .= " wr_last desc, ";
		if (stristr($options, "comment_asc"))		$sql_order .= " wr_comment asc, ";
		if (stristr($options, "comment_desc"))		$sql_order .= " wr_comment desc, ";
		if (stristr($options, "comment_cnt_desc"))	$sql_order .= " wr_comment desc, ";
		if (stristr($options, "good_asc"))			$sql_order .= " wr_good asc, ";
		if (stristr($options, "good_desc"))			$sql_order .= " wr_good desc, ";
		if (stristr($options, "subject_asc"))		$sql_order .= " wr_subject asc, ";
		if (stristr($options, "subject_desc"))		$sql_order .= " wr_subject desc, ";
		if (stristr($options, "ca_name_asc"))		$sql_order .= " ca_name asc, ";
		if (stristr($options, "ca_name_desc"))		$sql_order .= " ca_name desc, ";
		if (stristr($options, "wr_1_asc"))			$sql_order .= " wr_1 asc, ";
		if (stristr($options, "wr_1_desc"))			$sql_order .= " wr_1 desc, ";
		if (stristr($options, "random"))			$sql_order .= " rand(), ";
		$sql_order .= " wr_num limit 0, {$rows} ";
		//echo $sql_order;

		$sql = " select * from {$tmp_write_table} " . $sql_where . $sql_order;
		$result = sql_query($sql);
		for ($i=0; $row = sql_fetch_array($result); $i++) {
			$list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
		}

		if($cache_fwrite) {
			$handle = fopen($cache_file, 'w');
			$cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$bo_subject='".sql_escape_string($bo_subject)."';\n\$bo_mobile_subject='".sql_escape_string($bo_mobile_subject)."';\n\$list=".var_export($list, true)."?>";
			fwrite($handle, $cache_content);
			fclose($handle);
		}
	}

	ob_start();
	include $latest_skin_path.'/latest.skin.php';
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}
?>
