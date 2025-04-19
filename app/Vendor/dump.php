#!/usr/bin/php
<?php
 class Dump {

	 private $hostname = "50.57.95.139";
	 private $login = "dbuser";
	 private $password ="Xoli17245";
 	 private static $dbh_master = null;
	 function __construct() {
			if( self::$dbh_master == null){
				self::$dbh_master = new PDO("mysql:host=".$this->hostname.";dbname=hope_master", $this->login, $this->password); 				// make connection with master database
			}
 		}
 /* this method create the tables in the newly created database table and seeds the datum*/

	function database_seeding(){
		set_time_limit ( 0 );
	    $sql_get_hospital_list = "SELECT * FROM facility_database_mappings where is_active=:is_active";
	    $sth_master = self::$dbh_master->prepare($sql_get_hospital_list, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
	    $sth_master->execute(array(':is_active' =>'0'));
	    $facilities = $sth_master->fetchAll();
	    foreach( $facilities as $key=>$value)
			 {
			 		 $loggerDir =  dir("../tmp/logs/dbcreate");
					 $logfile = fopen($loggerDir->path."/".$value['db_name'].".log","w");
			 		 try {
					    $dbh = new PDO("mysql:host=".$this->hostname.";dbname=".$value['db_name']."", $this->login, $this->password);
					 }catch (PDOException $e) {
					   //echo 'Connection failed: ' . $e->getMessage();
					    fwrite($logfile, 'Connection failed: ' . $e->getMessage().PHP_EOL);
					 }

					 //$sqlscript = 'C:\wamp\www\code\app\Vendor\hope_data.sql'; // absolute location for sql for data
 
					 $sqlscript = '/home/webftp/website/app/Vendor/hope_data.sql'; // absolute location for sql for data	linux
					 $sql_schema = file($sqlscript);
					 $query = "";
					 foreach($sql_schema as $sql_line){
						  if(trim($sql_line) != "" && strpos($sql_line, "--") === false){
						    	$query .= $sql_line;
							    if (substr(rtrim($query), -1) == ';'){
							        if($dbh->exec($query)){
										fwrite($logfile, "Success -- ".$query."--".PHP_EOL);
									}else{
										fwrite($logfile, "Failed -- ".$query."--".PHP_EOL);
									}
							        $query = "";
							    }
					      }
					  }

						self::$dbh_master->exec("UPDATE facility_database_mappings SET is_active=1 where id='".$value['id']."'");

					 	fclose($logfile);
					}



		    }
}

	/* if (!file_exists("status.txt")) { //check that status file exist or not if no than it will create file*/
 	  /*$handle = fopen("status.txt", "a");
 	  chmod("status.txt",0777);*/


	  $seed = new Dump();
	  $seed->database_seeding();
	 /* fclose($handle);*/

	/*}*/

?>
