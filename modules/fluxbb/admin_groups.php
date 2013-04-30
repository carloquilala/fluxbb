<?php if (!defined('FLUX_ROOT')) exit;

if ( file_exists('fluxbb/config.php') ) {
	$pun_user = $_COOKIE['punuser'];
	$db = $_COOKIE['db'];
	$pun_config = $_COOKIE['punconfig'];
	$lang_common = $_COOKIE['langcommon'];
	$lang_misc = $_COOKIE['langmisc'];
	$admin_language = $_COOKIE['adminlanguage'];
	$lang_admin_common = $_COOKIE['langadmincommon'];
}

?>