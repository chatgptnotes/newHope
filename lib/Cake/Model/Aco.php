<?php
/**
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

/**
 * Load Model and AppModel
 */
App::uses('AppModel', 'Model');

/**
 * Access Control Object
 *
 * @package       Cake.Model
 */
class Aco extends AclNode {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Aco';

/**
 * Binds to ARO nodes through permissions settings
 *
 * @var array
 */
	public $hasAndBelongsToMany = array('Aro' => array('with' => 'Permission'));
	public function __construct($id = false, $table = null, $ds = null) { 
		App::uses('CakeSession', 'Model/Datasource');
		$sessionObj = new CakeSession();
		if($sessionObj->read('db_name')==""){
			$config = Configure::read('Acl.database');
			if (isset($config)) {
				$this->useDbConfig = $config;
			}
		}else{
		
				$this->specific = true;
				$this->db_name =  $sessionObj->read('db_name');
		}
		
		parent::__construct($id = false, $table = null, $ds = null);
	}
}