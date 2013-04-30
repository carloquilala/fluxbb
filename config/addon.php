<?php

/*
#======================================================
|    FluxCP Snippets : FluxBB
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
|    | Addon Main Configurations and Options
#======================================================
*/

return array(

	#======================================
	# OPTIONS / CONFIGURATIONS
	#======================================
	# * Array of configurations for this
	# * FluxCP addon.
	#======================================
	
	''					=> array(),

	#======================================
	# SUB MENU ITEMS
	#======================================
	# * Add a submenu under account page
	# * with a title 'Create A Character'
	#======================================

	'MenuItems'		=> array(
		'Community'		=> array(
			'FluxBB Forum' => array(
				'module' => 'fluxbb'
			)
		)
	),
	
	'SubMenuItems' => array(
		'fluxbb' => array(
			// 'index'      => 'Index',
		),
    ),

	#======================================
	# ADDON RELATED TABLES
	#======================================
	# * Do not edit below as these are the
	# * tables associated upon creation of
	# * characters. Unless you know what
	# * youare doing.
	#======================================

    'FluxTables' => array(
        // 'Ai_Char' => 'char',				// Character's information
        // 'Ai_CharLog' => 'charlog',			// Character's log
        // 'Ai_Inventory' => 'inventory',		// Character's inventory database
    ),

)
?>