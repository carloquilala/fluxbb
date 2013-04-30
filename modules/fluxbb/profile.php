<?php if (!defined('FLUX_ROOT')) exit;

if ( file_exists('fluxbb/config.php') ) {
	$pun_user = $_COOKIE['punuser'];
	$db = $_COOKIE['db'];
	$pun_config = $_COOKIE['punconfig'];
	$lang_common = $_COOKIE['langcommon'];
	$lang_profile = $_COOKIE['langprofile'];
	$lang_misc = $_COOKIE['langmisc'];
	$forum_time_formats = $_COOKIE['forum_time_formats'];
	$forum_date_formats = $_COOKIE['forum_date_formats'];
}

?>