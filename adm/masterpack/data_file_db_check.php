<?php
$sub_menu = '700300';
include_once('./_common.php');

if ($is_admin != 'super')
	alert('최고관리자만 접근 가능합니다.', G5_URL);

$g5['title'] = '첨부파일 디비확인';
include_once('../admin.head.php');
?>

<div class="local_desc02 local_desc">
	<p>
		완료 메세지가 나오기 전에 프로그램의 실행을 중지하지 마십시오.
	</p>
</div>

<?php
$directory = array();
$dl = array('file');

$cnt = 0; $cnt2 = 0;
echo '<ul>'.PHP_EOL;

foreach($dl as $val) {
	if($handle = opendir(G5_DATA_PATH.'/'.$val)) {
		while(false !== ($entry = readdir($handle))) {
			if($entry == '.' || $entry == '..' || $entry == 'index.php')
				continue;

			$path = G5_DATA_PATH.'/'.$val.'/'.$entry;

			if(is_dir($path)) {
				$directory[] = array( $val, $entry, $path );
			}

			if($handle2 = opendir($path)) {
				while(false !== ($entry2 = readdir($handle2))) {
					if($entry2 == '.' || $entry2 == '..' || $entry2 == 'index.php' || $entry2 == 'thumb')
						continue;

					$cnt++;
					$row = sql_fetch(" select bf_source from {$g5['board_file_table']} where bo_table = '{$entry}' and bf_file = '{$entry2}' ");

					if (!$row['bf_source']) {
						$cnt2++;
						echo "<li>파일이 디비에 없습니다. - " . $path . "/" . $entry2 . "</li>\n";
					}
					flush();

				}
			}

		}
	}
}

//flush();

//echo var_export($directory) . "<br>\n";

if (empty($directory)) {
	echo '<p>file 디렉토리를 열지못했습니다.</p>';
}

//$cnt=0;
//echo '<ul>'.PHP_EOL;

/*
foreach($directory as $dir) {
	//$files = glob($dir.'/thumb-*');
	$files = glob($dir[2].'/*');
	if (is_array($files)) {
		foreach($files as $file) {
			$cnt++;
			//@unlink($file);
$row = sql_fetch(" select * from {$g5['board_file_table']} where bo_table = '{$dir[1]}' ");

			echo '<li>'.$file."-".$dir[1].'</li>'.PHP_EOL;

			//flush();

			if ($cnt%10==0)
				echo PHP_EOL;
		}
	}
}
*/

echo '<li>완료됨</li></ul>'.PHP_EOL;
echo '<div class="local_desc01 local_desc"><p><strong>첨부파일 '.$cnt.' 건 중 '.$cnt2.' 개가 검색되었습니다.</strong><br>프로그램의 실행을 끝마치셔도 좋습니다.</p></div>'.PHP_EOL;
?>

<?php
include_once('../admin.tail.php');
?>