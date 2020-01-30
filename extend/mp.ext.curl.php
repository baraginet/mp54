<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!function_exists('curl_get_contents')) {
	function curl_get_contents($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		//curl_setopt($ch, CURLOPT_TIMEOUT, 120);
		$result = curl_exec($ch);
		$curl_errno = curl_errno($ch);
		$curl_error = curl_error($ch);
		curl_close($ch);
		if ($curl_error) {
			return 'curl error : ' . $curl_errno . ' ' . $curl_error;
		} else {
			return $result;
		}
	}
}
?>