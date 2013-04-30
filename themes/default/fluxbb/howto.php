<?php if (!defined('FLUX_ROOT')) exit; ?>
<?php
if (!is_dir('fluxbb')) {
	include 'addons/fluxbb/data/fluxbb/nofolder.php';
}
if (!file_exists('fluxbb/config.php')) {
	header('Location: ?module=fluxbb&action=install');
}
define('PUN_ADMIN_CONSOLE', 1);

if ($pun_user['g_read_board'] == '0')
	message($lang_common['No view'], false, '403 Forbidden');

// Load the howto.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/howto.php';

$action = $params->get('action') ? $params->get('action') : null;

$page_title = array(pun_htmlspecialchars($pun_config['o_board_title']), 'How To', 'Integration of FluxBB and FluxCP');
define('PUN_ACTIVE_PAGE', 'admin');
require 'addons/fluxbb/themes/'.Flux::config('ThemeName').'/fluxbb/header.php';

?>
	<div id="install" class="block">
		<h2><span><?php echo $lang_howto['How to install'] ?></span></h2>
		<div id="adstats" class="box">
			<div class="inbox">
				<h2>Essential files</h2>
				<ol class="default">
					<li>FluxCPRA - https://github.com/missxantara/fluxcp-ra/trunk/</li>
					<li>FluxBB version 1.5.3 (zip) - http://fluxbb.org/downloads/</li>
					<li>Download latest FluxBB FluxCP addon build if you don't have yet.</li>
				</ol>
				<h2>Minimum requirements</h2>
				<ol>
					<li>Download and Install latest FluxCP of Xantara if you don't have one yet</li>
					<li>Download latest FluxBB source files if you don't have yet.</li>
					<li>Download latest FluxBB FluxCP addon build if you don't have yet.</li>
				</ol>
			</div>
		</div>
	</div>
	<div id="integrate_home"  class="block">
		<h2><span><?php echo $lang_howto['Integrate'] ?></span></h2>
		<div id="adstats" class="box">
			<div class="inbox">
				<p>The following procedure is for those who want to integrate FluxBB and FluxCP account sessions. Apply this procedure at your own risk. Artwor'X will never be liable on any loss in your server's data.</p>
				<p>If somehow I forgot to integrate some functions, please feel free to post in this forum <a href="?module=fluxbb&action=viewforum&">?module=fluxbb&action=viewforum&</a>.</p>
				<p>Found bugs, errors, warnings and other problems upon using this addon, feel free to post in this forum <a href="?module=fluxbb&action=viewforum&">?module=fluxbb&action=viewforum&</a>.</p>
				<p><span style="color: red;font-weight:bold;">Important Note</span> : FluxBB must be installed before applying these modifications.</p>
				<p><span style="color: red;font-weight:bold;">Files affected</span> :</p>
				<div class="codebox_flux">
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Find']; ?></h3>
						<pre><code><%FLUXCP_DIR%>/modules/account/create.php
<%FLUXCP_DIR%>/modules/account/login.php
<%FLUXCP_DIR%>/modules/account/logout.php
<%FLUXCP_DIR%>/modules/account/edit.php
<%FLUXCP_DIR%>/modules/account/changepass.php
<%FLUXCP_DIR%>/modules/account/changemail.php
<%FLUXCP_DIR%>/modules/account/resetpw.php
<%FLUXCP_DIR%>/themes/<%FLUXCP_THEME%>/account/create.php<code></pre>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="integrate_modification"  class="block">
		<h2><span><?php echo $lang_howto['Modification'] ?></span></h2>
		<div id="adstats" class="box">
			<div class="inbox">
				<div class="codebox_flux">
					<ol>
					<li><h3><span>Open <%FLUXCP_DIR%>/modules/account/create.php</span></h3>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Find']; ?></h3>
						<pre><code>$serverNames = $this->getServerNames();</code></pre>
					</div>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Insert below']; ?></h3>
						<pre><code>/* START FLUXBB INTEGRATION :: INITIAL VARIABLES - JTQ */

$pun_user = $_COOKIE['punuser'];
$db = $_COOKIE['db'];
$pun_config = $_COOKIE['punconfig'];
$lang_common = $_COOKIE['langcommon'];
$lang_misc = $_COOKIE['langmisc'];

// Load the register.php/profile.php language file
require PUN_ROOT.'lang/'.$pun_user['language'].'/prof_reg.php';

/* END FLUXBB INTEGRATION :: INITIAL VARIABLES - JTQ */</code></pre>
					</div>
					<br />
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Find']; ?></h3>
						<pre><code>$code      = $params->get('security_code');</code></pre>
					</div>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Insert below']; ?></h3>
						<pre><code>/* START FLUXBB INTEGRATION :: FORM VARIABLES - JTQ */
					
$emailset  = $params->get('emailsetting');
$timezone  = $params->get('timezone');
$dst       = $params->get('dst');
$language  = $params->get('language');

/* END FLUXBB INTEGRATION :: FORM VARIABLES - JTQ */</code></pre>
					</div>
					<br />
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Find']; ?></h3>
						<pre><code>if ($result) {</code></pre>
					</div>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Insert below']; ?></h3>
						<pre><code>/* START FLUXBB INTEGRATION :: FIX INFORMATIONS - JTQ */

// Group ID
$intial_group_id = $pun_config['o_default_user_group'];

// Password Hash
$password_hash = pun_hash($params->get('password'));

// Email Settings
$email_setting = intval($emailset);
if ($email_setting < 0 || $email_setting > 2)
$email_setting = $pun_config['o_default_email_setting'];

// Timezone and DST
$timezone = isset($timezone) ? round($timezone, 1) : 0;
$dst = isset($dst) ? '1' : '0';

// Make sure we got a valid language string
if (isset($langauge))
{
$language = preg_replace('%[\.\\\/]%', '', langauge);
if (!file_exists(PUN_ROOT.'lang/'.$language.'/common.php'))
	message($lang_common['Bad request']);
}
else
$language = $pun_config['o_default_lang'];

// Current Time
$now = time();

/* END FLUXBB INTEGRATION :: FIX INFORMATIONS */

/* START FLUXBB INTEGRATION :: INSERT FORUM USER ACCOUNT */

// Add the user

$sql  = "INSERT INTO ".$db_name.".".$db->prefix."users (id, username, group_id, password, email, email_setting, timezone, dst, language, style, registered, registration_ip, last_visit) ";
$sql .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$sth  = $server->connection->getStatement($sql);

$sth->execute(array(
			$result,
			$username,
			$intial_group_id,
			$password_hash,
			$email,
			$email_setting,
			$timezone,
			$dst,
			$language,
			$pun_config['o_default_style'],
			$now,
			get_remote_address(),
			$now
		)
);

// Regenerate the users info cache
if (!defined('FORUM_CACHE_FUNCTIONS_LOADED'))
require PUN_ROOT.'include/cache.php';

generate_users_info_cache();

pun_setcookie($result, $password_hash, time() + $pun_config['o_timeout_visit']);

/* END FLUXBB INTEGRATION :: INSERT FORUM USER ACCOUNT  - JTQ*/</code></pre>
					</div>
					<h3><span><?php echo sprintf($lang_howto['Save and exit'], 'create.php'); ?></span></h3>
					<hr /></li>
					<li><h3><span>Open <%FLUXCP_DIR%>/modules/account/login.php</span></h3>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Find']; ?></h3>
						<pre><code>if ($session->loginAthenaGroup->loginServer->config->getUseMD5()) {
	$password = Flux::hashPassword($password);
}</code></pre>
					</div>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Insert below']; ?></h3>
						<pre><code>/* START FLUXBB INTEGRATION :: LOGIN - JTQ */
		
if ( file_exists('fluxbb/config.php') ) {
	$pun_user = $_COOKIE['punuser'];
	$db = $_COOKIE['db'];
	$pun_config = $_COOKIE['punconfig'];
	$lang_common = $_COOKIE['langcommon'];
	$lang_misc = $_COOKIE['langmisc'];
	
	$username_sql = ($db_type == 'mysql' || $db_type == 'mysqli' || $db_type == 'mysql_innodb' || $db_type == 'mysqli_innodb') ? 'username=\''.$db->escape($username).'\'' : 'LOWER(username)=LOWER(\''.$db->escape($username).'\')';

	$result = $db->query('SELECT * FROM '.$db->prefix.'users WHERE '.$username_sql) or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
	$cur_user = $db->fetch_assoc($result);

	$authorized = false;

	if (!empty($cur_user['password']))
	{
		$form_password_hash = pun_hash($password_forum); // Will result in a SHA-1 hash

		// If there is a salt in the database we have upgraded from 1.3-legacy though haven't yet logged in
		if (!empty($cur_user['salt']))
		{
			if (sha1($cur_user['salt'].sha1($password_forum)) == $cur_user['password']) // 1.3 used sha1(salt.sha1(pass))
			{
				$authorized = true;

				$db->query('UPDATE '.$db->prefix.'users SET password=\''.$form_password_hash.'\', salt=NULL WHERE id='.$cur_user['id']) or error('Unable to update user password', __FILE__, __LINE__, $db->error());
			}
		}
		// If the length isn't 40 then the password isn't using sha1, so it must be md5 from 1.2
		else if (strlen($cur_user['password']) != 40)
		{
			if (md5($password_forum) == $cur_user['password'])
			{
				$authorized = true;

				$db->query('UPDATE '.$db->prefix.'users SET password=\''.$form_password_hash.'\' WHERE id='.$cur_user['id']) or error('Unable to update user password', __FILE__, __LINE__, $db->error());
			}
		}
		// Otherwise we should have a normal sha1 password
		else
			$authorized = ($cur_user['password'] == $form_password_hash);
	}

	// Update the status if this is the first time the user logged in
	if ($cur_user['group_id'] == PUN_UNVERIFIED)
	{
		$db->query('UPDATE '.$db->prefix.'users SET group_id='.$pun_config['o_default_user_group'].' WHERE id='.$cur_user['id']) or error('Unable to update user status', __FILE__, __LINE__, $db->error());

		// Regenerate the users info cache
		if (!defined('FORUM_CACHE_FUNCTIONS_LOADED'))
			require PUN_ROOT.'include/cache.php';

		generate_users_info_cache();
	}

	// Remove this user's guest entry from the online list
	$db->query('DELETE FROM '.$db->prefix.'online WHERE ident=\''.$db->escape(get_remote_address()).'\'') or error('Unable to delete from online list', __FILE__, __LINE__, $db->error());

	$expire = time() + 1209600;
	pun_setcookie($cur_user['id'], $form_password_hash, $expire);

	// Reset tracked topics
	set_tracked_topics(null);
}

/* END FLUXBB INTEGRATION :: LOGIN - JTQ */</code></pre>
					</div>
					<h3><span><?php echo sprintf($lang_howto['Save and exit'], 'login.php'); ?></span></h3>
					<hr /></li>
					<li><h3><span>Open <%FLUXCP_DIR%>/modules/account/logout.php</span></h3>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Find']; ?></h3>
						<pre><code>$session->logout();</code></pre>
					</div>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Insert below']; ?></h3>
						<pre><code>/* END FLUXBB INTEGRATION :: LOGOUT - JTQ */

if ( file_exists('fluxbb/config.php') ) {
	$pun_user = $_COOKIE['punuser'];
	$db = $_COOKIE['db'];

	// Remove user from "users online" list
	$db->query('DELETE FROM '.$db->prefix.'online WHERE user_id='.$pun_user['id']) or error('Unable to delete from online list', __FILE__, __LINE__, $db->error());

	// Update last_visit (make sure there's something to update it with)
	if (isset($pun_user['logged']))
		$db->query('UPDATE '.$db->prefix.'users SET last_visit='.$pun_user['logged'].' WHERE id='.$pun_user['id']) or error('Unable to update user visit data', __FILE__, __LINE__, $db->error());

	pun_setcookie(1, pun_hash(uniqid(rand(), true)), time() + 31536000);
}
		
/* END FLUXBB INTEGRATION :: LOGOUT - JTQ */</code></pre>
					</div>
					<h3><span><?php echo sprintf($lang_howto['Save and exit'], 'logout.php'); ?></span></h3>
					<hr /></li>
					<li><h3><span>Open <%FLUXCP_DIR%>/modules/account/edit.php</span></h3>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Find']; ?></h3>
						<pre><code>$sql .= " WHERE account_id = :account_id";
$sth  = $server->connection->getStatement($sql);
$sth->execute($bind);</code></pre>
					</div>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Insert below']; ?></h3>
						<pre><code>/* START FLUXBB INTEGRATION :: EDIT ACCOUNT - JTQ */
$db = $_COOKIE['db'];
$db->query('UPDATE '.$db->prefix.'.users SET email = \''.$db->escape($email).'\' WHERE id='.$account->account_id) or error('Unable to update user email', __FILE__, __LINE__, $db->error());
/* END FLUXBB INTEGRATION :: EDIT ACCOUNT - JTQ */</code></pre>
					</div>
					<h3><span><?php echo sprintf($lang_howto['Save and exit'], 'edit.php'); ?></span></h3>
					<hr /></li>
					<li><h3><span>Open <%FLUXCP_DIR%>/modules/account/changepass.php</span></h3>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Find']; ?></h3>
						<pre><code>else {
	$errorMessage = Flux::message('FailedToChangePassword');
}</code></pre>
					</div>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Insert below']; ?></h3>
						<pre><code>/* START FLUXBB INTEGRATION :: UPDATE PASSWORD - JTQ */
$db = $_COOKIE['db'];
$db->query('UPDATE '.$db->prefix.'.users SET password = \''.pun_hash($params->get('newpass')).'\' WHERE id='.$session->account->account_id) or error('FluxBB :: Unable to update user password', __FILE__, __LINE__, $db->error());
/* END FLUXBB INTEGRATION :: UPDATE PASSWORD - JTQ */</code></pre>
					</div>
					<h3><span><?php echo sprintf($lang_howto['Save and exit'], 'changepass.php'); ?></span></h3>
					<hr /></li>
					<li><h3><span>Open <%FLUXCP_DIR%>/modules/account/changemail.php</span></h3>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Find']; ?></h3>
						<pre><code>$session->setMessageData(Flux::message('EmailAddressChanged'));</code></pre>
					</div>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Insert above']; ?></h3>
						<pre><code>/* START FLUXBB INTEGRATION :: UPDATE EMAIL - JTQ */
$db = $_COOKIE['db'];
$db->query('UPDATE '.$db->prefix.'.users SET email = \''.$db->escape($email).'\' WHERE id='.$session->account->account_id) or error('FluxBB :: Unable to update user email', __FILE__, __LINE__, $db->error());
/* END FLUXBB INTEGRATION :: UPDATE EMAIL - JTQ */</code></pre>
					</div>
					<h3><span><?php echo sprintf($lang_howto['Save and exit'], 'changepass.php'); ?></span></h3>
					<hr /></li>
					<li><h3><span>Open <%FLUXCP_DIR%>/modules/account/resetpw.php</span></h3>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Find']; ?></h3>
						<pre><code>$session->setMessageData($message);</code></pre>
					</div>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Insert above']; ?></h3>
						<pre><code>/* START FLUXBB INTEGRATION :: UPDATE PASSWORD - JTQ */
$db = $_COOKIE['db'];
$db->query('UPDATE '.$db->prefix.'.users SET password = \''.pun_hash($unhashedNewPassword).'\' WHERE id='.$account) or error('FluxBB :: Unable to update user password', __FILE__, __LINE__, $db->error());
/* END FLUXBB INTEGRATION :: UPDATE PASSWORD - JTQ */</code></pre>
					</div>
					<h3><span><?php echo sprintf($lang_howto['Save and exit'], 'changepass.php'); ?></span></h3>
					<hr /></li>
					<li><h3><span>Open <%FLUXCP_DIR%>/themes/<%FLUXCP_THEME%>/account/create.php</span></h3>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Find']; ?></h3>
						<pre><code>&lt;tr&gt;
	&lt;th&gt;&lt;label&gt;&lt;?php echo htmlspecialchars(Flux::message('AccountBirthdateLabel')) ?&gt;&lt;/label&gt;&lt;/th&gt;
	&lt;td&gt;&lt;?php echo $this-&gt;dateField('birthdate',null,0) ?&gt;&lt;/td&gt;
&lt;/tr&gt;</code></pre>
					</div>
					<div class="codebox_content">
						<h3 class='code'><?php echo $lang_howto['Insert below']; ?></h3>
						<pre><code>&lt;!-- START FLUXBB INTEGRATION :: CREATE - JTQ --&gt;
&lt;?php
	$timezone = isset($timezone) ? $timezone : $pun_config['o_default_timezone'];
	$dst = isset($dst) ? $dst : $pun_config['o_default_dst'];
	$email_setting = isset($email_setting) ? $email_setting : $pun_config['o_default_email_setting'];
?&gt;
&lt;tr&gt;
	&lt;th&gt;&lt;label&gt;Time Zone&lt;/label&gt;&lt;/th&gt;
	&lt;td&gt;
		&lt;select id="time_zone" name="timezone"&gt;
			&lt;option value="-12"&lt;?php if ($timezone == -12) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-12:00'] ?&gt;&lt;/option&gt;
			&lt;option value="-11"&lt;?php if ($timezone == -11) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-11:00'] ?&gt;&lt;/option&gt;
			&lt;option value="-10"&lt;?php if ($timezone == -10) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-10:00'] ?&gt;&lt;/option&gt;
			&lt;option value="-9.5"&lt;?php if ($timezone == -9.5) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-09:30'] ?&gt;&lt;/option&gt;
			&lt;option value="-9"&lt;?php if ($timezone == -9) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-09:00'] ?&gt;&lt;/option&gt;
			&lt;option value="-8.5"&lt;?php if ($timezone == -8.5) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-08:30'] ?&gt;&lt;/option&gt;
			&lt;option value="-8"&lt;?php if ($timezone == -8) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-08:00'] ?&gt;&lt;/option&gt;
			&lt;option value="-7"&lt;?php if ($timezone == -7) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-07:00'] ?&gt;&lt;/option&gt;
			&lt;option value="-6"&lt;?php if ($timezone == -6) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-06:00'] ?&gt;&lt;/option&gt;
			&lt;option value="-5"&lt;?php if ($timezone == -5) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-05:00'] ?&gt;&lt;/option&gt;
			&lt;option value="-4"&lt;?php if ($timezone == -4) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-04:00'] ?&gt;&lt;/option&gt;
			&lt;option value="-3.5"&lt;?php if ($timezone == -3.5) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-03:30'] ?&gt;&lt;/option&gt;
			&lt;option value="-3"&lt;?php if ($timezone == -3) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-03:00'] ?&gt;&lt;/option&gt;
			&lt;option value="-2"&lt;?php if ($timezone == -2) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-02:00'] ?&gt;&lt;/option&gt;
			&lt;option value="-1"&lt;?php if ($timezone == -1) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC-01:00'] ?&gt;&lt;/option&gt;
			&lt;option value="0"&lt;?php if ($timezone == 0) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC'] ?&gt;&lt;/option&gt;
			&lt;option value="1"&lt;?php if ($timezone == 1) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+01:00'] ?&gt;&lt;/option&gt;
			&lt;option value="2"&lt;?php if ($timezone == 2) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+02:00'] ?&gt;&lt;/option&gt;
			&lt;option value="3"&lt;?php if ($timezone == 3) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+03:00'] ?&gt;&lt;/option&gt;
			&lt;option value="3.5"&lt;?php if ($timezone == 3.5) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+03:30'] ?&gt;&lt;/option&gt;
			&lt;option value="4"&lt;?php if ($timezone == 4) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+04:00'] ?&gt;&lt;/option&gt;
			&lt;option value="4.5"&lt;?php if ($timezone == 4.5) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+04:30'] ?&gt;&lt;/option&gt;
			&lt;option value="5"&lt;?php if ($timezone == 5) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+05:00'] ?&gt;&lt;/option&gt;
			&lt;option value="5.5"&lt;?php if ($timezone == 5.5) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+05:30'] ?&gt;&lt;/option&gt;
			&lt;option value="5.75"&lt;?php if ($timezone == 5.75) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+05:45'] ?&gt;&lt;/option&gt;
			&lt;option value="6"&lt;?php if ($timezone == 6) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+06:00'] ?&gt;&lt;/option&gt;
			&lt;option value="6.5"&lt;?php if ($timezone == 6.5) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+06:30'] ?&gt;&lt;/option&gt;
			&lt;option value="7"&lt;?php if ($timezone == 7) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+07:00'] ?&gt;&lt;/option&gt;
			&lt;option value="8"&lt;?php if ($timezone == 8) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+08:00'] ?&gt;&lt;/option&gt;
			&lt;option value="8.75"&lt;?php if ($timezone == 8.75) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+08:45'] ?&gt;&lt;/option&gt;
			&lt;option value="9"&lt;?php if ($timezone == 9) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+09:00'] ?&gt;&lt;/option&gt;
			&lt;option value="9.5"&lt;?php if ($timezone == 9.5) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+09:30'] ?&gt;&lt;/option&gt;
			&lt;option value="10"&lt;?php if ($timezone == 10) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+10:00'] ?&gt;&lt;/option&gt;
			&lt;option value="10.5"&lt;?php if ($timezone == 10.5) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+10:30'] ?&gt;&lt;/option&gt;
			&lt;option value="11"&lt;?php if ($timezone == 11) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+11:00'] ?&gt;&lt;/option&gt;
			&lt;option value="11.5"&lt;?php if ($timezone == 11.5) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+11:30'] ?&gt;&lt;/option&gt;
			&lt;option value="12"&lt;?php if ($timezone == 12) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+12:00'] ?&gt;&lt;/option&gt;
			&lt;option value="12.75"&lt;?php if ($timezone == 12.75) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+12:45'] ?&gt;&lt;/option&gt;
			&lt;option value="13"&lt;?php if ($timezone == 13) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+13:00'] ?&gt;&lt;/option&gt;
			&lt;option value="14"&lt;?php if ($timezone == 14) echo ' selected="selected"' ?&gt;&gt;&lt;?php echo $lang_prof_reg['UTC+14:00'] ?&gt;&lt;/option&gt;
		&lt;/select&gt;
		&lt;br&gt;
		&lt;label&gt;&lt;input type="checkbox" name="dst" value="1"&lt;?php if ($dst == '1') echo ' checked="checked"' ?&gt; /&gt;&lt;?php echo $lang_prof_reg['DST'] ?&gt;&lt;/label&gt;
	&lt;/td&gt;
&lt;/tr&gt;
&lt;tr&gt;
	&lt;th&gt;&lt;label&gt;&lt;?php echo $lang_prof_reg['Privacy options legend'] ?&gt;&lt;/label&gt;&lt;/th&gt;
	&lt;td&gt;
		&lt;p&gt;&lt;?php echo $lang_prof_reg['Email setting info'] ?&gt;&lt;/p&gt;
		&lt;label&gt;&lt;input type="radio" name="emailsetting" value="0"&lt;?php if ($email_setting == '0') echo ' checked="checked"' ?&gt; /&gt;&lt;?php echo $lang_prof_reg['Email setting 1'] ?&gt;&lt;br /&gt;&lt;/label&gt;
		&lt;label&gt;&lt;input type="radio" name="emailsetting" value="1"&lt;?php if ($email_setting == '1') echo ' checked="checked"' ?&gt; /&gt;&lt;?php echo $lang_prof_reg['Email setting 2'] ?&gt;&lt;br /&gt;&lt;/label&gt;
		&lt;label&gt;&lt;input type="radio" name="emailsetting" value="2"&lt;?php if ($email_setting == '2') echo ' checked="checked"' ?&gt; /&gt;&lt;?php echo $lang_prof_reg['Email setting 3'] ?&gt;&lt;br /&gt;&lt;/label&gt;
	&lt;/td&gt;
&lt;/tr&gt;
&lt;!-- END FLUXBB INTEGRATION :: CREATE - JTQ --&gt;</code></pre>
					</div>
					<h2><span>Save and exit create.php</span></h2></li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="clearer"></div>
</div>
<?php

require 'addons/fluxbb/themes/'.Flux::config('ThemeName').'/fluxbb/footer.php';
