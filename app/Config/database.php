<?php
/**
 * This is core configuration file.
 *
 * Use it to configure core behaviour of Cake.
 *
 * PHP 5
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
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * In this file you set up your database connection details.
 *
 *
 *
 * @package       cake.config
 */
/**
 * Database configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * datasource => The name of a supported datasource; valid options are as follows:
 *		Database/Mysql 		- MySQL 4 & 5,
 *		Database/Sqlite		- SQLite (PHP5 only),
 *		Database/Postgres	- PostgreSQL 7 and higher,
 *		Database/Sqlserver	- Microsoft SQL Server 2005 and higher
 *
 * You can add custom database datasources (or override existing datasources) by adding the
 * appropriate file to app/Model/Datasource/Database.  Datasources should be named 'MyDatasource.php',
 *
 *
 * persistent => true / false
 * Determines whether or not the database should use a persistent connection
 *
 * host =>
 * the host you connect to the database. To add a socket or port number, use 'port' => #
 *
 * prefix =>
 * Uses the given prefix for all the tables in this database.  This setting can be overridden
 * on a per-table basis with the Model::$tablePrefix property.
 *
 * schema =>
 * For Postgres specifies which schema you would like to use the tables in. Postgres defaults to 'public'.
 *
 * encoding =>
 * For MySQL, Postgres specifies the character encoding to use when connecting to the
 * database. Uses database default not specified.
 *
 * unix_socket =>
 * For MySQL to connect via socket specify the `unix_socket` parameter instead of `host` and `port`
 */
class DATABASE_CONFIG {

		public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'hopesoftwares.com',
		'login' => 'olh9vcykd20h',
		'password' => 'q3M1L!c8Bt4q',
		'database' => 'hope_master',
		'port' =>'3306',
		'prefix' => '',
		//'encoding' => 'utf8',
		 'log' => true
	);

	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'hopesoftwares.com',
		'login' => 'olh9vcykd20h',
		'password' => 'q3M1L!c8Bt4q',
		'database' => 'db_hope',
		'port' =>'3306',
		'prefix' => '',
		//'encoding' => 'utf8',
		 'log' => true
	);
	
	public $admin_emergency_seva= array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => '107.180.113.70',
		'login' => 'admin-emergencyseva',
		'password' => 'JjOQ++PxHv#?',
		'port' =>'3306',
		'database' => 'admin-emergencyseva',
		'prefix' => '',
		//'encoding' => 'utf8',
		 'log' => true
	);
	
	/* this setting for separate hospital*/
	
		public $defaultHospital = array(
						'datasource' => 'Database/Mysql',
						'persistent' => false,
						'host' => 'hopesoftwares.com',
						'login' => 'olh9vcykd20h',
						'password' => 'q3M1L!c8Bt4q',
						'port' =>'3306',
						'database' => "db_hope"  
	);
		
		public $connect43 = array(
				'datasource' => 'Database/Mysql',
				'persistent' => false,
				'host' => '192.168.1.254',
				'login' => 'yash',
				'password' => 'yash',
				'port' =>'3306',
				'database' => "db_vadodara"
		);
		
		public $connect44 = array(
				'datasource' => 'Database/Mysql',
				'persistent' => false,
				'host' => '192.168.1.44',
				'login' => 'drmuser',
				'password' => 'drm1969',
				'port' =>'3306',
				'database' => "db_vadodara"
		);
		
		/* this setting for online registration */
		/* public $online_reg = array(
				'datasource' => 'Database/Mysql',
				'persistent' => false,
				'host' => '127.0.0.1',
				'login' => 'root',
				'password' => '',
				'database' => 'inpatient',
		); */
}
