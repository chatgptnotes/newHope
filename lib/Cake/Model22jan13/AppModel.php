<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       Cake.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * This is a placeholder class.
 * Create the same file in app/Model/AppModel.php
 * Add your application-wide methods to the class, your models will inherit them.
 *
 * @package       Cake.Model
 */
class AppModel extends Model {

 public $specific = false;
 public $db_name = false;

    function __construct($id = false, $table = null, $ds = null) {
   /*     if ($this->specific) {
			$defaultconfig = ConnectionManager::getDataSource('default')->config;
            // Get saved company/database name
			if(!empty($this->db_name))
	            $dbName = $this->db_name;
			else
				 $dbName = $defaultconfig['database'];
				 
            // Get common company-specific config (default settings in database.php)
            $config = ConnectionManager::getDataSource('defaultHospital')->config;

            // Set correct database name
            $config['database'] = $dbName;
            // Add new config to registry
            ConnectionManager::create($dbName, $config);
            // Point model to new config
            $this->useDbConfig = $dbName;
        }*/
        parent::__construct($id, $table, $ds);
    } 
}
