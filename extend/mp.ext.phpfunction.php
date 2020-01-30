<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//
// PHP 버전에 따라서 없는 함수들과 있어야 될 것 같은데 없는 함수들 모음
//

// str_split 함수의 multibyte 적용 함수
if (!function_exists('mb_str_split')) {
	function mb_str_split($str) {
		return preg_split('/(?<!^)(?!$)/u',$str);
	}
}

// simplexml_load_string 에서 오류나는 것 방지
if (!function_exists('simplexml_escape')) {
	function simplexml_escape($str='') {
		$arr_sch = array('&nbsp;', '&middot;');
		$arr_rep = array('&#160;', '&#183;');
		return str_replace($arr_sch, $arr_rep, $str);;
	}
}

// URL 에서 path 와 query 부분만 가져오기
if (!function_exists('get_pathquery')) {
	function get_pathquery($url='') {
		$arr = parse_url($url);
		return $arr['path'] . ($arr['query'] ? '?' . $arr['query'] : '');
	}
}

// URL 에서 protocol 과 domain 부분 제거하기. 결과값은 위 함수와 같음
if (!function_exists('del_domain')) {
	function del_domain($url='') {
		$arr = parse_url($url);
		return $arr['path'] . ($arr['query'] ? '?' . $arr['query'] : '');
	}
}
?>
