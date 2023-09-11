<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');     // loads WP functions and session variables

$numPostsToDisplayOnPageLoad = 20;
$numPostsToAddOnLoadMore = 10;

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
if ($_GET['tA']) {
	$toggleList = $_GET['tA'];
	$toggleArray = explode(',', $toggleList);
} else {
	$toggleList = null;
	$toggleArray = null;
}
if ($_GET['sO']) {
	if ($_GET['sO'] == 'alpha') {
		$orderArray = array('title' => 'ASC');
	} else {
		$orderArray = array('post_date' => 'DESC');
	}
} else {
	$orderArray = array('post_date' => 'DESC');
}
if ($_GET['sT']) {
	$searchTerm = $_GET['sT'];
} else {
	$searchTerm = '';
}

$categoryList = '';
$tagArray = [];
if ($toggleArray) {
	foreach ($toggleArray as $toggle) {
		if (substr($toggle, 0, 2) == '1-') {
			$tagArray[] = intval(substr($toggle, 2));	// adds any tag that's passed in to list of tag ids

		} elseif (substr($toggle, 0, 2) == '2-') {
			if (substr($toggle, 2, 1) == '1') {
				if ($categoryList != '') $categoryList .= ',';
				$categoryList .= '132';	// category for "Books"
			} elseif (substr($toggle, 2, 1) == '2') {
				if ($categoryList != '') $categoryList .= ',';
				$categoryList .= '84';	// category for "Column"
			} elseif (substr($toggle, 2, 1) == '3') {
				if ($categoryList != '') $categoryList .= ',';
				$categoryList .= '80';	// category for "Folio"
			} elseif (substr($toggle, 2, 1) == '4') {
				if ($categoryList != '') $categoryList .= ',';
				$categoryList .= '35';	// category for "Ayin One"
				$categoryList .= ',';
				$categoryList .= '90';	// category for "Ayin Two"
			} elseif (substr($toggle, 2, 1) == '5') {
				if ($categoryList != '') $categoryList .= ',';
				$categoryList .= '98';	// category for "Zines"
			}
		}
	}

	if ($categoryList != '' && sizeof($tagArray) > 0) {
		$posts = get_posts( array(
			'numberposts'		=> -1,
			'post_type'			=> 'post',
			'orderby'  			=> $orderArray,
			'tag__in'			=> $tagArray,
			'cat'				=> $categoryList,
			's'					=> $searchTerm,
			'category__not_in'	=> array(71),	// don't pull any from "News" category
		) );

	} elseif ($categoryList != '') {
		$posts = get_posts( array(
			'numberposts'		=> -1,
			'post_type'			=> 'post',
			'orderby'  			=> $orderArray,
			'cat'				=> $categoryList,
			's'					=> $searchTerm,
			'category__not_in'	=> array(71),	// don't pull any from "News" category
		) );

	} elseif (sizeof($tagArray) > 0) {
		$posts = get_posts( array(
			'numberposts'		=> -1,
			'post_type'			=> 'post',
			'orderby'  			=> $orderArray,
			'tag__in'			=> $tagArray,
			's'					=> $searchTerm,
			'category__not_in'	=> array(71),	// don't pull any from "News" category
		) );
	} else {
		$posts = get_posts( array(
			'numberposts'		=> -1,
			'post_type'			=> 'post',
			'orderby'  			=> $orderArray,
			's'					=> $searchTerm,
			'category__not_in'	=> array(71),	// don't pull any from "News" category
		) );
	}

} else {
	// get all posts as there are no filters
	$posts = get_posts( array(
		'numberposts'		=> -1,
		'post_type'			=> 'post',
		'orderby'  			=> $orderArray,
		's'					=> $searchTerm,
		'category__not_in'	=> array(71),	// don't pull any from "News" category
	) );
}

if (sizeof($posts) > 0) {
	ob_start();
	$count = 0;
	$endNum = ($startNum == 1) ? $numPostsToDisplayOnPageLoad : $startNum + $numPostsToAddOnLoadMore - 1;
	if ($endNum > sizeof($posts)) $endNum = sizeof($posts);
	foreach ($posts as $post) {
		$count++;
		if ($count >= $startNum && $count <= $endNum) {
			echo display_grid_article($post);
		}
	}
	if (sizeof($posts) > $endNum) {
		echo display_grid_load_more_button(1, $endNum + 1);
	} else {
		echo ('<div id="AyinGrid1Loading' . ($endNum + 1) . '" class="AyinGridLoading"></div>');
	}
} else {
	echo('<p class="BlogGridPost">There are no archives that match your search criteria.  Please update your criteria and try again.</p>');
	echo ('<div id="AyinGrid1Loading1" class="AyinGridLoading"></div>');
}
echo ob_get_clean();
