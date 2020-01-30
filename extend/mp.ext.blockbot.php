<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// ============================================================================================
// masterpack extend - 쓰잘데기 없는 검색봇 차단
// ============================================================================================

// PIRS 차단
if(strpos($_SERVER['HTTP_USER_AGENT'],'KISA Privacy Incident Response System Contact Us') !== false) exit();
if($_SERVER['HTTP_USER_AGENT'] == 'pirst') exit();
if($_SERVER['HTTP_USER_AGENT'] == 'first') exit();

if(strpos($_SERVER['HTTP_USER_AGENT'],'AhrefsBot') !== false) exit();
if(strpos($_SERVER['HTTP_USER_AGENT'],'SemrushBot') !== false) exit();
if(strpos($_SERVER['HTTP_USER_AGENT'],'netEstate NE Crawler') !== false) exit();

//if(strpos($_SERVER['HTTP_USER_AGENT'],'DeuSu') !== false) exit();
if(strpos($_SERVER['HTTP_USER_AGENT'],'MJ12bot') !== false) exit();
if(strpos($_SERVER['HTTP_USER_AGENT'],'serpstatbot') !== false) exit();
if(strpos($_SERVER['HTTP_USER_AGENT'],'SeznamBot') !== false) exit();
if(strpos($_SERVER['HTTP_USER_AGENT'],'YandexBot') !== false) exit();

// 아래는 strpos 로 바꾸기 전의 코드, 속도가 더 빠른 strpos 로 바꿈.
//if(preg_match('/SemrushBot/i',$_SERVER['HTTP_USER_AGENT'])) { exit(); }
//if(preg_match('/netEstate NE Crawler/i',$_SERVER['HTTP_USER_AGENT'])) { exit(); }
//if(preg_match('/law\.di\.unimi\.it\/BUbiNG\.html/i',$_SERVER['HTTP_USER_AGENT'])) { exit(); }
////if(preg_match('/DeuSu/i',$_SERVER['HTTP_USER_AGENT'])) { exit(); }
//if(preg_match('/MauiBot/i',$_SERVER['HTTP_USER_AGENT'])) { exit(); }
//if(preg_match('/YandexBot/i',$_SERVER['HTTP_USER_AGENT'])) { exit(); }
?>
