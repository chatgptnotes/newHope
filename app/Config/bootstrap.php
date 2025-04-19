<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as 
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * PHP 5
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 */

 
// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'Memcache'));

/** PAWAN MESHRAM
 * Custom DRM Application Folder
 */
 if (!defined('DRM_APP_DIR')) {
    define('DRM_APP_DIR', dirname(__FILE__) . DS); // This should be the path to your application
}

App::build(array(
   'Plugin' => array(DRM_APP_DIR . 'Plugin' . DS),
   'Model' => array(DRM_APP_DIR . 'Model' . DS),
   'View' => array(DRM_APP_DIR . 'View' . DS),
   'Controller' => array(DRM_APP_DIR . 'Controller' . DS),
   'Model/Datasource' => array(DRM_APP_DIR . 'Model/Datasource' . DS),
   'Model/Behavior' => array(DRM_APP_DIR . 'Model/Behavior' . DS),
   'Controller/Component' => array(DRM_APP_DIR . 'Controller/Component' . DS),
   'View/Helper' => array(DRM_APP_DIR . 'View/Helper' . DS),
   'Vendor' => array(DRM_APP_DIR . 'Vendor'),
   'Console/Command' => array(DRM_APP_DIR . 'Console/Command' . DS),
   'locales' => array(DRM_APP_DIR . 'Locales' . DS)
));
/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

Configure::load('config');
//pawan to add separate hl7 configuration file (DO NOT DELETE)
Configure::load('hl7config');
Configure::load('drmconfig');
CakePlugin::load('Acl', array('bootstrap' => true));
//CakePlugin::load('Mmis');

CakePlugin::load('DebugKit');
Configure::load('sms_config');
/* -------------------------------------------------------------------
 * The settings below have to be loaded to make the acl plugin work.
 * -------------------------------------------------------------------
 *
 * See how to include these settings in the README fileHL7
 */

/*
 * The model name used for the user role (typically 'Role' or 'Group')
 */
Configure :: write('acl.aro.role.model', 'Role');

/*
 * The primary key of the role model
 *
 * (can be left empty if your primary key's name follows CakePHP conventions)('id')
 */
Configure :: write('acl.aro.role.primary_key', '');

/*
 * The foreign key's name for the roles
 *
 * (can be left empty if your foreign key's name follows CakePHP conventions)(e.g. 'role_id')
 */
Configure :: write('acl.aro.role.foreign_key', '');

/*
 * The model name used for the user (typically 'User')
 */
Configure :: write('acl.aro.user.model', 'User');

/*
 * The primary key of the user model
 *
 * (can be left empty if your primary key's name follows CakePHP conventions)('id')
 */
Configure :: write('acl.aro.user.primary_key', '');

/*
 * The name of the database field that can be used to display the role name
 */
Configure :: write('acl.aro.role.display_field', 'name');

/*
 * You can add here role id(s) that are always allowed to access the ACL plugin (by bypassing the ACL check)
 * (This may prevent a user from being rejected from the ACL plugin after a ACL permission update)
 */
Configure :: write('acl.role.access_plugin_role_ids', array());

/*
 * You can add here users id(s) that are always allowed to access the ACL plugin (by bypassing the ACL check)
 * (This may prevent a user from being rejected from the ACL plugin after a ACL permission update)
 */
Configure :: write('acl.role.access_plugin_user_ids', array(1));

/*
 * The users table field used as username in the views
 * It may be a table field or a SQL expression such as "CONCAT(User.lastname, ' ', User.firstname)" for MySQL or "User.lastname||' '||User.firstname" for PostgreSQL
 */
Configure :: write('acl.user.display_name', "User.username");

/*
 * Indicates whether the presence of the Acl behavior in the user and role models must be verified when the ACL plugin is accessed
 */
Configure :: write('acl.check_act_as_requester', true);

/*
 * Add the ACL plugin 'locale' folder to your application locales' folders
 */
App :: build(array('locales' => App :: pluginPath('Acl') . DS . 'locale'));

/*
 * Indicates whether the roles permissions page must load through Ajax
 */
Configure :: write('acl.gui.roles_permissions.ajax', true);

/*
 * Indicates whether the users permissions page must load through Ajax
 */
Configure :: write('acl.gui.users_permissions.ajax', true);

/**
 * Pawan Meshram (DO NOT DELETE)
 */
require APPLIBS.'basics.php';
/*
 * refferal doctor having id 4 for registrar 
 */
 //encrption
ini_set('max_execution_time',0);
Configure :: write('referralforregistrar', 4);
ini_set('memory_limit',-1); 
function do_crypt($url)
{
	return 'url-'.base64_encode($url);
}

function do_decrypt($url)
{
	if (substr($url , 0 , 4) == 'url-')
	{
		$url = substr($url , 4);
		return base64_decode($url);
	}
}
//EOF