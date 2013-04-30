## FluxBB

FluxBB Addon is an open source addon that integrates FluxCP into FluxBB forum engine by http://fluxbb.org

Unlike many forum softwares, FluxBB is designed to be smaller and lighter without many of the less essential features. Often features which aren't included in the core are implemented by the community and released as modifications. The below feature list shows what features are included in a standard install of FluxBB.

For more features and what is supports in detail, you may found it at http://fluxbb.org/about/features.html

## How to install

**Essential Files**
  * FluxCP - https://github.com/missxantara/fluxcp-ra/trunk/
  * FluxBB Addon - https://github.com/jupeto/fluxbb.git or SVN Checkout https://github.com/jupeto/fluxbb/trunk
  * FluxBB version 1.5.3 (zip) - http://fluxbb.org/downloads/

**Minimum Requirement - FluxBB version 1.5.3 (zip)**
  * To install and run FluxBB v1.5.3 you must have access to a webserver. FluxBB v1.5.3 requires PHP 4.4.0 or later. A database is required which may be MySQL 4.1.2 or later, PostgreSQL 7.0 or later or SQLite 2.

**Uploading, Installation, and Configuration**
  - Upload downloaded FluxBB version 1.5.3 (zip) in ``<%FLUXCP_DIR%>/`` folder (Do not install yet)
  - Create a new folder in ``<%FLUXCP_DIR%>/addons/`` directory and upload/extract the downloaded FluxBB Addon files, or if you are using a svn, create a fluxbb folder in your FluxCP addons folder and checkout the latest build in this link https://github.com/jupeto/fluxbb.git
  - Create a database and name it as fluxbb
  - Access the install path of FluxCP Addon via http://domain.com/fluxcp_folder/index.php?module=fluxbb&action=install or http://domain.com/index.php?module=fluxbb&action=install

  - Fill in all required fields and submit the form to install it
  - You must specify a valid admin username to be an administrator
  - During the installation, all FluxCP accounts will be inserted in FluxBB account table
  - If you want to integrate both FluxCP and FluxBB account sessions, see http://artworx.juplo.com/?module=fluxbb&action=howto before logging in
  - After successfull installation, re-login using your admin account. Have fun using FluxBB Forum

If you need further support in installing the addon, please feel free to post your questions in http://artworx.juplo.com/?module=fluxbb
  
## Integrating FluxCP and FluxBB account sessions

You may find the step by step procedure on how to integrate FluxBB with FluxCP at http://artworx.juplo.com/?module=fluxbb&action=howto
