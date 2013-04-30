<?php

/*
#======================================================
|    FluxCP Snippets : FluxBB Integration
|    ==================================================
|    By Jose Carlo Quilala (atong_24@yahoo.com)
|    (c) 2012 Artwor'X(R) Interactive.
|    http://www.artworx-enhance.com/
|    ==================================================
|    Email: support@artworx-enhance.com
#======================================================
|    @ Version: v1.0.0 Build 10000001
|    @ Version Int: 100.0.0.001
|    @ Version Num: 10000001
|    @ Build: 0001
#======================================================
|    | Addon User Access
#======================================================
*/

return array(

	#======================================
	# ADDON USER ACCESS
	#======================================
	# * Users with this level or above can
	# * only access this addon.
	# * 
	# * see config/levels.php
	#======================================
	
	'modules' => array(
		'fluxbb' => array(
            'admin_bans' 			=> AccountLevel::ADMIN,
            'admin_categories'		=> AccountLevel::ADMIN,
            'admin_censoring'		=> AccountLevel::ADMIN,
            'admin_forums'			=> AccountLevel::ADMIN,
            'admin_groups'			=> AccountLevel::ADMIN,
            'admin_index'			=> AccountLevel::ADMIN,
            'admin_loader'			=> AccountLevel::ADMIN,
            'admin_maintenance'		=> AccountLevel::ADMIN,
            'admin_options'			=> AccountLevel::ADMIN,
            'admin_permissions'		=> AccountLevel::ADMIN,
            'admin_reports'			=> AccountLevel::ADMIN,
            'admin_statistics'		=> AccountLevel::ADMIN,
            'admin_users'			=> AccountLevel::ADMIN,
            'index' 				=> AccountLevel::ANYONE,
            'install' 				=> AccountLevel::ADMIN,
		),
	),
)
?>