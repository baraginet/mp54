<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// ============================================================================================
// masterpack extend - 검색봇 체크
// ============================================================================================

//
// 광고를 보일것인가 말것인가
//
$is_ad_view = true;
//if ($is_admin) echo 'is_ad_view = ' . print_r($is_ad_view,true);

if(strpos($_SERVER['HTTP_USER_AGENT'],'bingbot') !== false) $is_ad_view = false;
if(strpos($_SERVER['HTTP_USER_AGENT'],'Googlebot') !== false) $is_ad_view = false;
if(strpos($_SERVER['HTTP_USER_AGENT'],'ZumBot') !== false) $is_ad_view = false;
?>
