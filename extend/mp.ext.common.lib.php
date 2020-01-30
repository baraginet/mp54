<?php
if (!defined('_GNUBOARD_')) exit;

// 그누보드에서만 사용될 수 있는 함수들 확장
// 그누보드의 고유 변수나 상수를 사용하는 추가 함수들

// 메인메뉴 링크에 G5_URL 변수를 추가할 수 있게 하는 함수
if (!function_exists('me_link')) {
	function me_link($str=''){
		if (strpos($str,"{G5_URL}") !== false) $str = del_domain(str_replace("{G5_URL}",G5_URL,$str));
		return $str;
	}
}

// 분류 옵션을 얻음
function get_category_option2($bo_table='', $ca_name='') {
	global $g5, $board, $is_admin;

	$categories = explode("|", $board['bo_category_list']); // 구분자가 , 로 되어 있음
	$str = "";
	for ($i=0; $i<count($categories); $i++) {
		$category = trim($categories[$i]);
		if (!$category) continue;

		$str .= "<option value=\"$categories[$i]\"";
		if ($category == $ca_name) {
			$str .= ' selected="selected"';
		}
		$str .= ">$categories[$i]</option>\n";
	}

	return $str;
}

// 그누보드 권한이 admin 일때에만 echo 하기
function admin_echo($str) {
	global $is_admin;
	if ($is_admin) echo "\n<!--<pre>\n" . $str . "\n</pre>-->\n";
}
function admin_print($str) {
	global $is_admin;
	if ($is_admin) echo "\n<!--<pre>\n" . print_r($str,true) . "\n</pre>-->\n";
}
function echo_time($opt='') {
	global $is_admin, $begin_time;
	if ($is_admin) echo PHP_EOL . '<!--<pre> microtime = ' . (get_microtime()-$begin_time) . ' </pre>-->' . PHP_EOL;
}

// nl2br 의 변형 함수
function nl2br2($str) {
	if (stripos($str,'<br>') === false && stripos($str,'<br/>') === false && stripos($str,'<br />') === false && stripos($str,'</br>') === false) {
		$ret = nl2br($str);
	} else {
		$ret = $str;
	}
	return $ret;
}

// trim 처럼 문자열 양쪽끝의 특정문자 잘라내버리기
function trim_del($haystack='',$needle='',$opt='') {
	$str = $haystack;
	$str = trim($str);
	if (substr($str,0,1) == $needle) { $str = substr($str,1); }
	if (substr($str,-1) == $needle) { $str = substr($str,0,-1); }
	$str = trim($str);
	return $str;
}

// strpos 함수의 확장 - 배열로 문자열 검색하기, http://stackoverflow.com/questions/6284553/using-an-array-as-needles-in-strpos
function strposa($haystack, $needle, $offset=0) {
	if(!is_array($needle)) $needle = array($needle);
	foreach($needle as $query) {
		if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
	}
	return false;
}

function get_datetime() {
	$microtime = floatval(substr((string)microtime(), 1, 8));
	$rounded = round($microtime, 3);
	return date("Y-m-d H:i:s") . substr((string)$rounded, 1, strlen($rounded)) . PHP_EOL;
}

// 날짜에 '-' 넣기
function conv_date($str, $options='') {
	if (!$str) { return false; }
	switch(strlen($str)) {
		case 8 :
			switch($options) {
				case '-' :	return substr($str,0,4) . "-" . substr($str,4,2) . "-" . substr($str,6,2);			break;
				case '/' :	return substr($str,0,4) . "/" . substr($str,4,2) . "/" . substr($str,6,2);			break;
				case '.' :	return substr($str,0,4) . "." . substr($str,4,2) . "." . substr($str,6,2) . ".";	break;
				default :	return substr($str,0,4) . "-" . substr($str,4,2) . "-" . substr($str,6,2);			break;
			}
			break;
		default :
			return $str;
			break;
	}
}

// 요일 구하는 함수
function yoil($str,$opt=''){
	$yoil = array("일","월","화","수","목","금","토");
	return $yoil[date('w', strtotime($str))];
}

function left($str, $len){
	return substr($str, 0, $len);
}

function right($str, $len) {
	return substr($str, (strlen($str) - $len), strlen($str));
}

// url 을 링크 html 코드로 변환
function url_link($url='') {
	if ($url == '') { return false; }
	if (strpos($url, 'href') !== false) { return $url; }
	$link = $url;
	if (substr($url,0,4) != "http") { $link = 'http://' . $url; }
	$str = '<a href="' . $link . '" target="_blank">' . $url . '</a>';
	return $str;
}

// img url 을 html 코드로 변환
function img_html($img='') {
	if ($img == '') { return false; }
	$str = '<img data-original="' . $img . '" class="lazy img_err">';
	return $str;
}

// html symbol Number Entity 를 특수문자로 변환
function html_symbol_decode($str) {
	$source[] = "&quot;";
	$target[] = "\"";
	$source[] = "&#34;";
	$target[] = "\"";
	$source[] = "&#39;";
	$target[] = "'";

	return str_replace($source, $target, $str);
}

// 날짜 차이 구하기
function days_diff($d1,$d2='') {
	if (!$d1) return false;
	if (!$d2) $d2 = date('Y-m-d H:i:s');
	$dt1 = new DateTime($d1);
	$dt2 = new DateTime($d2);
	$diff = date_diff($dt1, $dt2);
	//return print_r($diff,true);
	//return $diff->days;	// 이 값은 항상 양수가 나와서 아래로 대체한다.
	return (int)$diff->format("%r%a");
}


function write_table_insert4($write_table,$wr_id='',$ca_name='',$wr_option='',$wr_subject,$wr_content,$wr_link1='',$wr_link2='',$wr_name='',$wr_dt='',$wr_1='',$wr_2='',$wr_3='',$wr_4='',$wr_5='',$wr_6='',$wr_7='',$wr_8='',$wr_9='',$wr_10='') {
	global $g5, $is_admin, $member;
	$bo_table = str_replace($g5['write_prefix'],'',$write_table);
	//if ($wr_id) { $wr_num = $wr_id * (-1); } else { $wr_num = get_next_num($write_table); }
	$wr_num = ($wr_id) ? $wr_id * (-1) : get_next_num($write_table);
	$wr_seo_title = exist_seo_title_recursive('bbs', generate_seo_title($wr_subject), $write_table, $wr_id);

	$sql = " insert into {$write_table}
				set wr_id = '$wr_id',
					wr_num = '$wr_num',
					wr_reply = '$wr_reply',
					wr_comment = 0,
					ca_name = '$ca_name',
					wr_option = '$wr_option',
					wr_subject = '$wr_subject',
					wr_content = '$wr_content',
					wr_seo_title = '$wr_seo_title',
					wr_link1 = '$wr_link1',
					wr_link2 = '$wr_link2',
					mb_id = '{$member['mb_id']}',
					wr_password = '$wr_password',
					wr_name = '$wr_name',
					wr_email = '$wr_email',
					wr_homepage = '$wr_homepage',
					wr_datetime = '" . ($wr_dt ? $wr_dt : G5_TIME_YMDHIS) . "',
					wr_last = '" . ($wr_dt ? $wr_dt : G5_TIME_YMDHIS) . "',
					wr_ip = '{$_SERVER['REMOTE_ADDR']}',
					wr_1 = '$wr_1',
					wr_2 = '$wr_2',
					wr_3 = '$wr_3',
					wr_4 = '$wr_4',
					wr_5 = '$wr_5',
					wr_6 = '$wr_6',
					wr_7 = '$wr_7',
					wr_8 = '$wr_8',
					wr_9 = '$wr_9',
					wr_10 = '$wr_10' ";
	if ($is_admin) echo "\n<!--<pre>\n" . $sql . "\n</pre>-->\n";
	sql_query($sql,true);
	$wr_id = sql_insert_id();

	// 부모 아이디에 UPDATE
	sql_query(" update {$write_table} set wr_parent = '$wr_id' where wr_id = '$wr_id' ");

	// 새글 INSERT
	//sql_query(" insert into {$g5['board_new_table']} ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '{$bo_table}', '{$wr_id}', '{$wr_id}', '".G5_TIME_YMDHIS."', '{$member['mb_id']}' ) ");

	// 게시글 1 증가
	sql_query("update {$g5['board_table']} set bo_count_write = bo_count_write + 1 where bo_table = '" . str_replace($g5['write_prefix'],'',$write_table) . "'");

	// 최신글 캐시 삭제
	delete_cache_latest($bo_table);

	return $wr_id;
}

function write_table_insert3($write_table,$wr_id='',$ca_name='',$wr_option='',$wr_subject,$wr_content,$wr_link1='',$wr_link2='',$wr_name='',$wr_dt='',$wr_1='',$wr_2='',$wr_3='',$wr_4='',$wr_5='',$wr_6='',$wr_7='',$wr_8='',$wr_9='',$wr_10='') {
	global $g5, $is_admin, $member;
	$bo_table = str_replace($g5['write_prefix'],'',$write_table);
	//if ($wr_id) { $wr_num = $wr_id * (-1); } else { $wr_num = get_next_num($write_table); }
	$wr_num = ($wr_id) ? $wr_id * (-1) : get_next_num($write_table);

	$sql = " insert into {$write_table}
				set wr_id = '$wr_id',
					wr_num = '$wr_num',
					wr_reply = '$wr_reply',
					wr_comment = 0,
					ca_name = '$ca_name',
					wr_option = '$wr_option',
					wr_subject = '$wr_subject',
					wr_content = '$wr_content',
					wr_link1 = '$wr_link1',
					wr_link2 = '$wr_link2',
					mb_id = '{$member['mb_id']}',
					wr_password = '$wr_password',
					wr_name = '$wr_name',
					wr_email = '$wr_email',
					wr_homepage = '$wr_homepage',
					wr_datetime = '" . ($wr_dt ? $wr_dt : G5_TIME_YMDHIS) . "',
					wr_last = '" . ($wr_dt ? $wr_dt : G5_TIME_YMDHIS) . "',
					wr_ip = '{$_SERVER['REMOTE_ADDR']}',
					wr_1 = '$wr_1',
					wr_2 = '$wr_2',
					wr_3 = '$wr_3',
					wr_4 = '$wr_4',
					wr_5 = '$wr_5',
					wr_6 = '$wr_6',
					wr_7 = '$wr_7',
					wr_8 = '$wr_8',
					wr_9 = '$wr_9',
					wr_10 = '$wr_10' ";
	if ($is_admin) echo "\n<!--<pre>\n" . $sql . "\n</pre>-->\n";
	sql_query($sql,true);
	$wr_id = sql_insert_id();

	// 부모 아이디에 UPDATE
	sql_query(" update {$write_table} set wr_parent = '$wr_id' where wr_id = '$wr_id' ");

	// 새글 INSERT
	//sql_query(" insert into {$g5['board_new_table']} ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '{$bo_table}', '{$wr_id}', '{$wr_id}', '".G5_TIME_YMDHIS."', '{$member['mb_id']}' ) ");

	// 게시글수 1 증가
	sql_query("update {$g5['board_table']} set bo_count_write = bo_count_write + 1 where bo_table = '" . str_replace($g5['write_prefix'],'',$write_table) . "'");

	// 최신글 캐시 삭제
	delete_cache_latest($bo_table);

	return $wr_id;
}

function write_table_insert($write_table,$wr_id='',$ca_name='',$wr_subject,$wr_content,$wr_link1='',$wr_link2='',$wr_1='',$wr_2='',$wr_3='',$wr_4='',$wr_5='',$wr_6='',$wr_7='',$wr_8='',$wr_9='',$wr_10='') {
	global $g5, $is_admin, $member;
	//$wr_num = get_next_num($write_table);
	$wr_num = ($wr_id) ? $wr_id * (-1) : get_next_num($write_table);
	$sql = " insert into {$write_table}
				set wr_id = '$wr_id',
					wr_num = '$wr_num',
					wr_reply = '$wr_reply',
					wr_comment = 0,
					ca_name = '$ca_name',
					wr_option = '$html,$secret,$mail',
					wr_subject = '$wr_subject',
					wr_content = '$wr_content',
					wr_link1 = '$wr_link1',
					wr_link2 = '$wr_link2',
					mb_id = '{$member['mb_id']}',
					wr_password = '$wr_password',
					wr_name = '$wr_name',
					wr_email = '$wr_email',
					wr_homepage = '$wr_homepage',
					wr_datetime = '".G5_TIME_YMDHIS."',
					wr_last = '".G5_TIME_YMDHIS."',
					wr_ip = '{$_SERVER['REMOTE_ADDR']}',
					wr_1 = '$wr_1',
					wr_2 = '$wr_2',
					wr_3 = '$wr_3',
					wr_4 = '$wr_4',
					wr_5 = '$wr_5',
					wr_6 = '$wr_6',
					wr_7 = '$wr_7',
					wr_8 = '$wr_8',
					wr_9 = '$wr_9',
					wr_10 = '$wr_10' ";
	if ($is_admin) echo "\n<!--<pre>\n" . $sql . "\n</pre>-->\n";
	sql_query($sql);
	$wr_id = sql_insert_id();

	// 부모 아이디에 UPDATE
	sql_query(" update {$write_table} set wr_parent = '$wr_id' where wr_id = '$wr_id' ");

	// 새글 INSERT
	//sql_query(" insert into {$g5['board_new_table']} ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '{$bo_table}', '{$wr_id}', '{$wr_id}', '".G5_TIME_YMDHIS."', '{$member['mb_id']}' ) ");

	// 게시글수 1 증가
	sql_query("update {$g5['board_table']} set bo_count_write = bo_count_write + 1 where bo_table = '" . str_replace($g5['write_prefix'],'',$write_table) . "'");

	return $wr_id;
}

function write_table_update($write_table,$wr_id,$fld1,$val1,$fld2='',$val2='',$fld3='',$val3='',$fld4='',$val4='',$fld5='',$val5='') {
	global $g5, $is_admin;
	if (!$fld1) return false;

	$sql = " update {$write_table} set {$fld1} = '{$val1}' ";
	if ($fld2) $sql .= " , {$fld2} = '{$val2}' ";
	if ($fld3) $sql .= " , {$fld3} = '{$val3}' ";
	if ($fld4) $sql .= " , {$fld4} = '{$val4}' ";
	if ($fld5) $sql .= " , {$fld5} = '{$val5}' ";
	$sql .= "	where wr_id = '{$wr_id}' ";
	if ($is_admin) echo "\n<!--<pre>\n" . $sql . "\n</pre>-->\n";
	$result = sql_query($sql);
	return $result;
}

function write_table_delete($write_table,$wr_id) {
	global $g5, $is_admin;

	// 게시물 삭제
	sql_query(" delete from {$write_table} where wr_id = '{$wr_id}' ");

	// 게시글수 1 감소
	sql_query("update {$g5['board_table']} set bo_count_write = bo_count_write - 1 where bo_table = '" . str_replace($g5['write_prefix'],'',$write_table) . "'");
}
?>