<?php
/**
 * SeedData vendor file
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

class SeedData {
	 public  $db;
	 private $hostname = "localhost";
	 private $login = "root";
	 private $password ="";
	 function __construct($db) {
		$this->db = $db;
	  }
	  
	  /* this method create the tables in the newly created database table and seeds the datum*/
	function database_seeding(){
	  $database_details = new DATABASE_CONFIG();
		try {
				$dbh = new PDO("mysql:host=".$database_details->default['host'].";port=".$database_details->default['port'].";dbname=".$this->db."", $database_details->default['login'], $database_details->default['password']);
			} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
			}
			//$sql_schema = file_get_contents(APP.'Config/Schema/slave.sql');
			$sql_schema = file_get_contents(APP.'Config/Schema/'.$this->db.'.sql');
			$dbh->exec($sql_schema);
			$dbh = null;
   			return 1;
	}
}


?>