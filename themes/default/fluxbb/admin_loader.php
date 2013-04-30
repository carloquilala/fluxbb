<?php if (!defined('FLUX_ROOT')) exit; ?>
<?php
if (!is_dir('fluxbb')) {
	include 'addons/fluxbb/data/fluxbb/nofolder.php';
}
if (!file_exists('fluxbb/config.php')) {
	header('Location: ?module=fluxbb&action=install');
}

define('PUN_ADMIN_CONSOLE', 1);

if (!$pun_user['is_admmod'])
	message($lang_common['No permission'], false, '403 Forbidden');

// The plugin to load should be supplied via GET
$plugin = $params->get('plugin') ? $params->get('plugin') : '';
if (!preg_match('%^AM?P_(\w*?)\.php$%i', $plugin))
	message($lang_common['Bad request']);

// AP_ == Admins only, AMP_ == admins and moderators
$prefix = substr($plugin, 0, strpos($plugin, '_'));
if ($pun_user['g_moderator'] == '1' && $prefix == 'AP')
	message($lang_common['No permission'], false, '403 Forbidden');

// Make sure the file actually exists
if (!file_exists(PUN_ROOT.'plugins/'.$plugin))
	message(sprintf($lang_admin_common['No plugin message'], $plugin));

// Construct REQUEST_URI if it isn't set
if (!isset($_SERVER['REQUEST_URI']))
	$_SERVER['REQUEST_URI'] = (isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '').'?'.(isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '');

$page_title = array(pun_htmlspecialchars($pun_config['o_board_title']), $lang_common['Admin'], str_replace('_', ' ', substr($plugin, strpos($plugin, '_') + 1, -4)));
define('PUN_ACTIVE_PAGE', 'admin');
require 'addons/fluxbb/themes/'.Flux::config('ThemeName').'/fluxbb/header.php';

// Attempt to load the plugin. We don't use @ here to suppress error messages,
// because if we did and a parse error occurred in the plugin, we would only
// get the "blank page of death"
include PUN_ROOT.'plugins/'.$plugin;
if (!defined('PUN_PLUGIN_LOADED'))
	message(sprintf($lang_admin_common['Plugin failed message'], $plugin));

// Output the clearer div
?>
	<div class="clearer"></div>
</div>
<?php

require 'addons/fluxbb/themes/'.Flux::config('ThemeName').'/fluxbb/footer.php';
