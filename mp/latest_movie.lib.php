<?php
if (!defined('_GNUBOARD_')) exit;

// 최신글 추출
// $cache_time 캐시 갱신시간, 단위는 시간이며, 0 이면 자동으로 갱신하지 않는다.
function latest_movie($skin_dir='', $bo_table, $rows=10, $subject_len=40, $cache_time=0, $options='')
{
	global $g5, $service_key;

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

	$cache_fwrite = false;
	if(G5_USE_CACHE) {
		$cache_file = G5_DATA_PATH."/cache/latest-{$bo_table}-{$skin_dir}-{$rows}-{$subject_len}-{$cache_time}-{$options}.php";

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

		$repNationCd = $options;
		$bo_subject = get_text(NationCd_decode($repNationCd)) . " 영화";

		$params_common = "key=".urlencode("53ccc846c997700512c8c27bab1b2eae");
		$params = "movie/searchMovieList.json?itemPerPage=".$rows."&curPage=".$page."&repNationCd=".urlencode($repNationCd);
		$fetch_url = "http://www.kobis.or.kr/kobisopenapi/webservice/rest/" . $params . "&" . $params_common;
		if ($is_admin) echo "\n<!--<pre>\n" . $fetch_url . "\n</pre>-->\n";

//		$snoopy = new Snoopy;
//		$snoopy->fetch($fetch_url);
//		//print $snoopy->results;
//		$txt = $snoopy->results;
		$txt = curl_get_contents($fetch_url);
		$obj = json_decode($txt,true);
		if ($is_admin) echo "\n<!--<pre>\n" . print_r($obj,true) . "\n</pre>-->\n";

		$i = 0;
		if(!empty($obj['movieListResult']['movieList'])){ foreach($obj['movieListResult']['movieList'] as $arr){
			//echo $arr['title'];
			$list[$i]['wr_id'] = $arr['movieCd'];
			$list[$i]['subject'] = $arr['movieNm'];
			$list[$i]['href'] = del_domain(G5_URL).'/page/movie/board.php?bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].'&amp;sca='.$repNationCd.$qstr;
			$i++;
		}}

//		$sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ";
//		$board = sql_fetch($sql);
//		$bo_subject = get_text($board['bo_subject']);

//		$tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
//		$sql = " select * from {$tmp_write_table} where wr_is_comment = 0 order by wr_num limit 0, {$rows} ";
//		$result = sql_query($sql);
//		for ($i=0; $row = sql_fetch_array($result); $i++) {
//			$list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
//		}

		if($cache_fwrite) {
			$handle = fopen($cache_file, 'w');
			$cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$bo_subject='".sql_escape_string($bo_subject)."';\n\$list=".var_export($list, true)."?>";
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
