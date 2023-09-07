<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');     // loads WP functions and session variables

if ($_GET['gridNum']) {
	$gridNum = $_GET['gridNum'];
	if (!is_numeric($gridNum)) {
		$gridNum = 1;
	} else {
		$gridNum = intval( $gridNum );
		if ( $gridNum <= 0 ) {
			$gridNum = 1;
		}
	}
} else {
	$gridNum = 1;
}
if ($_GET['start']) {
	$startNum = $_GET['start'];
	if (!is_numeric($startNum)) {
		$startNum = 1;
	} else {
		$startNum = intval( $startNum );
		if ( $startNum <= 0 ) {
			$startNum = 1;
		}
	}
} else {
	$startNum = 1;
}
if ($_GET['list']) {
	$postList = $_GET['list'];
} else {
	$postList = null;
}
if ($postList) {
	ob_start();
	$postArray = json_decode($postList);
	$maxNum = sizeof($postArray) > $startNum + 5 ? $startNum + 5 : sizeof($postArray);
	for ($count=$startNum; $count<$maxNum; $count++) {
		$post = get_post($postArray[$count]);
		if ($post) {
			echo display_grid_article($post);
		}
	}
	if (sizeof($postArray) > $maxNum) {
		echo display_grid_load_more_button($gridNum, $startNum + 5);
	}
	echo ob_get_clean();
}
