## FluxBB

FluxBB is an open source addon that integrates FluxCP into FluxBB forum engine by http://fluxbb.org

Unlike many forum softwares, FluxBB is designed to be smaller and lighter without many of the less essential features. Often features which aren't included in the core are implemented by the community and released as modifications. The below feature list shows what features are included in a standard install of FluxBB.

For more features and what is supports in detail, you may found it at http://fluxbb.org/about/features.html

## Integrating FluxCP and FluxBB account sessions

The following procedure is for those who want to integrate FluxBB and FluxCP account sessions. Apply this procedure at your own risk. Artwor'X will never be liable on any loss in your server's data.
If somehow I forgot to integrate some functions, please feel free to post in this forum ?module=fluxbb&action=viewforum&.
Found bugs, errors, warnings and other problems upon using this addon, feel free to post in this forum ?module=fluxbb&action=viewforum&.

Important Note : FluxBB must be installed before applying these modifications.

Files affected :

    <%FLUXCP_DIR%>/modules/account/create.php
    <%FLUXCP_DIR%>/modules/account/login.php
    <%FLUXCP_DIR%>/modules/account/logout.php
    <%FLUXCP_DIR%>/modules/account/edit.php
    <%FLUXCP_DIR%>/modules/account/changepass.php
    <%FLUXCP_DIR%>/modules/account/changemail.php
    <%FLUXCP_DIR%>/modules/account/resetpw.php
    <%FLUXCP_DIR%>/themes/<%FLUXCP_THEME%>/account/create.php

## Start Modification

-   Open `` <%FLUXCP_DIR%>/modules/account/create.php ``

    Find :

        $serverNames = $this->getServerNames();

    Add below :

        /* START FLUXBB INTEGRATION :: INITIAL VARIABLES - JTQ */
        $pun_user = $_COOKIE['punuser'];
        $db = $_COOKIE['db'];
        $pun_config = $_COOKIE['punconfig'];
        $lang_common = $_COOKIE['langcommon'];
        $lang_misc = $_COOKIE['langmisc'];
        
        // Load the register.php/profile.php language file
        require PUN_ROOT.'lang/'.$pun_user['language'].'/prof_reg.php';
        /* END FLUXBB INTEGRATION :: INITIAL VARIABLES - JTQ */
        
    Find :
    
        $code      = $params->get('security_code');
        
    Add below :
    
        /* START FLUXBB INTEGRATION :: FORM VARIABLES - JTQ */
        $emailset  = $params->get('emailsetting');
        $timezone  = $params->get('timezone');
        $dst       = $params->get('dst');
        $language  = $params->get('language');
        /* END FLUXBB INTEGRATION :: FORM VARIABLES - JTQ */
        
    Find :

        if ($result) {
        
    Add below :
    
        /* START FLUXBB INTEGRATION :: FIX INFORMATIONS - JTQ */

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
        
        /* END FLUXBB INTEGRATION :: INSERT FORUM USER ACCOUNT  - JTQ*/
-   Open <%FLUXCP_DIR%>/modules/account/login.php

    Find :
-   Open <%FLUXCP_DIR%>/modules/account/logout.php
-   Open <%FLUXCP_DIR%>/modules/account/edit.php
-   Open <%FLUXCP_DIR%>/modules/account/changepass.php
-   Open <%FLUXCP_DIR%>/modules/account/changemail.php
-   Open <%FLUXCP_DIR%>/modules/account/resetpw.php
-   Open <%FLUXCP_DIR%>/themes/<%FLUXCP_THEME%>/account/create.php
