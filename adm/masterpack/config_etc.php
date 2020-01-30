<?php
$sub_menu = "700100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

if ($is_admin != 'super')
	alert('최고관리자만 접근 가능합니다.');

// 설정 기타 테이블을 없으면 만든다.
$g5['config_etc_table'] = G5_TABLE_PREFIX . 'config_etc';		// 게시판 설정 기타 테이블
//echo $g5['config_etc_table'];

if(!sql_query(" DESC {$g5['config_etc_table']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['config_etc_table']}` (
					`cf_etc_1` varchar(255) NOT NULL DEFAULT '',
					`cf_etc_2` varchar(255) NOT NULL DEFAULT '',
					`cf_etc_3` varchar(255) NOT NULL DEFAULT '',
					`cf_etc_4` varchar(255) NOT NULL DEFAULT '',
					`cf_etc_5` varchar(255) NOT NULL DEFAULT '',
					`cf_etc_filter` text NOT NULL
				) DEFAULT CHARSET=utf8 ", false);

	// config 테이블 설정 - 초기값 입력
	$sql = " insert into {$g5['config_etc_table']} set cf_etc_filter = '' ";
	sql_query($sql, false);

}

if($w == 'u') {

	$tmp_sql = " update {$g5['config_etc_table']} set cf_etc_filter = '" . trim($_POST[cf_etc_filter]) . "' ";
	sql_query($tmp_sql, FALSE);

}

$config_etc = sql_fetch(" select * from {$g5['config_etc_table']} ");


$g5['title'] = '추가설정';
include_once ('../admin.head.php');


$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
	<a href="'.G5_URL.'/">메인으로</a>
</div>';

?>

<form name="fconfigetcform" id="fconfigetcform" method="post" onsubmit="return fconfigetcform_submit(this);">
<input type="hidden" name="token" value="<?php echo $token ?>" id="token">
<input type='hidden' name="w" value="u">

<section id="anc_cf_board">
	<h2 class="h2_frm">단어 필터링2</h2>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption>게시판 기본 설정</caption>
		<colgroup>
			<col class="grid_4">
			<col>
			<col class="grid_4">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row"><label for="cf_etc_filter">단어 필터링2</label></th>
			<td colspan="3">
				<?php echo help('입력된 단어가 포함된 내용은 게시할 수 없습니다. 단어와 단어 사이는 ,로 구분합니다.') ?>
				<textarea name="cf_etc_filter" id="cf_etc_filter" rows="7"><?php echo $config_etc['cf_etc_filter'] ?></textarea>
			 </td>
		</tr>
		</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

</form>

<script>
function fconfigetcform_submit(f)
{
	f.action = "<?php echo $_SERVER['PHP_SELF']; ?>";
	return true;
}
</script>

<?php
include_once ('../admin.tail.php');
?>
