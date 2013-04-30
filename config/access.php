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
            'index' 		=> AccountLevel::ANYONE,
            'install' 		=> AccountLevel::ADMIN,
            // 'viewtopic' 	=> AccountLevel::NORMAL,
		),
	),
)
?>