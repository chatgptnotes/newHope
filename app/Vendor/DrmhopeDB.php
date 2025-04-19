<?php
/**
 * DrmhopeDB vendor file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hospitals.vendor
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mayank Jain
 */
App::Import('Vendor','SeedData');  
App::Import('ConnectionManager');      
class DrmhopeDB {
	 private $db_name,$db_connection;
	 public $db_error;
	 function __construct($db) {
		 $this->db_connection = &ConnectionManager::getDataSource('default');
		 $this->db_name = preg_replace( '/\s+/', '', $db);
	   }
	   
	/* this method create the database*/
	function create_facility_db(){
		//die($this->db_name);
		try {			
			$result =  $this->db_connection->query('CREATE database db_'.$this->db_name.'');
			$sql_schema = "SET NAMES utf8;
			SET SQL_MODE='';
			create database if not exists `db_".$this->db_name."`;
			USE `db_".$this->db_name."`;";
			$sql_schema .= file_get_contents(APP.'Config/Schema/database_structure.sql');
			file_put_contents(APP.'Config/Schema/db_'.$this->db_name.'.sql', $sql_schema);
			return 'db_'.$this->db_name.'';
		} catch (Exception $e) {
				$this->db_error = $e->getMessage();
				// mail("mayankj@klouddata.com","Error in database creation",$e->getMessage());
				 return false;
		}
	}

  /* this method for seed the initial data in to the newly created database*/
	function seed_data(){
	   $seed = new SeedData('db_'.$this->db_name.'');
	   $seed->database_seeding();
	   //$sqlscript = 'C:\wamp\www\code_new\app\Vendor\hope_data.sql'; // absolute location for sql for data	
	 	
	  // shell_exec("sudo -u stagging /usr/bin/php -q /home/stagging/drmhope/hope_new/code/app/Vendor/dump.php");
	
	  
	}
	function makeConnection($model){
	 		$dbconfig = ConnectionManager::getDataSource('defaultHospital')->config;
            // Set correct database name
	
            $dbconfig['database'] = $this->db_name;
            // Add new config to registry
            ConnectionManager::create($this->db_name, $dbconfig);
            // Point model to new config
            $this->useDbConfig = $this->db_name;
			$model->useDbConfig = $this->db_name;
	
	
	}
}

?>