<?php if (!defined('FLUX_ROOT')) exit;
	$result = $db->query('SELECT a.id, a.username, a.ip, a.email, a.message, a.expire, b.username as bancreator FROM '.$db->prefix.'bans a INNER JOIN '.$db->prefix.'users b ON a.ban_creator = b.id WHERE a.username=\''.$db->escape($pun_user['username']).'\'') or error('Unable to fetch user info', __FILE__, __LINE__, $db->error());
	if ($db->num_rows($result))
	{
		list($ban_id, $ban_username, $ban_ip, $ban_email, $ban_message, $ban_expire, $ban_creator) = $db->fetch_row($result);
?>
<link rel="stylesheet" type="text/css" href="fluxbb/style/<?php echo $pun_user['style']; ?>.css">
<link rel="stylesheet" type="text/css" href="addons/fluxbb/data/artworx.css" />
<div id="punredirect" class="pun">
	<div class="top-box"><div><!-- Top Corners --></div></div>
	<div class="punwrap">

	<div id="brdmain">
	<div class="block">
		<h2>Account Banned</h2>
		<div class="box">
			<div class="inbox">
				<?php if ($ban_expire): ?>
				<p>You have been temporarily banned from this forum. You may use again this service after <?php echo date('M d Y', $ban_expire) ?>.Please contact the Board Administrator for more information.</p>
				<?php else: ?>
				<p>You have been permanently banned from this forum. Please contact the Forum Administrator for more information.</p>
				<?php endif; ?>
				<p>Reason given for ban: <?php echo $ban_message ?></p>
				<p>Issued by: <?php echo $ban_creator ?></p>
			</div>
		</div>
	</div>
	</div>
	</div>
	<div class="end-box"><div><!-- Bottom Corners --></div></div>
</div>
<?php die(); } ?>