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

		/* this construct set the database according to hospital	*/
    function __construct($id = false, $table = null, $ds = null) {
       if ($this->specific) {
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
        }
        parent::__construct($id, $table, $ds);
		
    } 
    
    /**
     * Overriden Save Function
     * @author Pawan Meshram
     * Added Create_time to autosave while saving
     */
    public function save($data = null, $validate = true, $fieldList = array()) {
    	$defaults = array('validate' => true, 'fieldList' => array(), 'callbacks' => true);
    	$_whitelist = $this->whitelist;
    	$fields = array();
    
    	if (!is_array($validate)) {
    		$options = array_merge($defaults, compact('validate', 'fieldList', 'callbacks'));
    	} else {
    		$options = array_merge($defaults, $validate);
    	}
    
    	if (!empty($options['fieldList'])) {
    		$this->whitelist = $options['fieldList'];
    	} elseif ($options['fieldList'] === null) {
    		$this->whitelist = array();
    	}
    	$this->set($data);
    
    	if (empty($this->data) && !$this->hasField(array('created', 'updated', 'modified'))) {
    		return false;
    	}
    
    	//foreach (array('created', 'updated', 'modified') as $field) {
    	foreach (array('create_time','created', 'updated', 'modified') as $field) {//Pawan Do Not Change
    		$keyPresentAndEmpty = (
    				isset($this->data[$this->alias]) &&
    				array_key_exists($field, $this->data[$this->alias]) &&
    				$this->data[$this->alias][$field] === null
    		);
    		if ($keyPresentAndEmpty) {
    			unset($this->data[$this->alias][$field]);
    		} 
    	} 
    	$exists = $this->exists();

    	
        /*if(empty($this->data[$this->alias][$this->primaryKey])){
            $dateFields = array('modified');
        }else{
            $dateFields = array('create_time','created', 'modified');
        }*/

        //by swapnil to collect on insert only
    	if (!$exists && empty($this->data[$this->alias][$this->primaryKey])) {
    		$dateFields[] = 'create_time';//,'created'
    	}
    	if (isset($this->data[$this->alias])) {
    		$fields = array_keys($this->data[$this->alias]);
    	}
    	if ($options['validate'] && !$this->validates($options)) {
    		$this->whitelist = $_whitelist;
    		return false;
    	}
        
    	$db = $this->getDataSource();
    
    	foreach ($dateFields as $updateCol) {
    		if ($this->hasField($updateCol) && !in_array($updateCol, $fields)) {
    			$default = array('formatter' => 'date');
    			$colType = array_merge($default, $db->columns[$this->getColumnType($updateCol)]);
    			if (!array_key_exists('format', $colType)) {
    				$time = strtotime('now');
    			} else {
    				$time = $colType['formatter']($colType['format']);
    			}
    			if (!empty($this->whitelist)) {
    				$this->whitelist[] = $updateCol;
    			}
    			$this->set($updateCol, $time);
    		}
    	} 
         
    	if ($options['callbacks'] === true || $options['callbacks'] === 'before') {
    		$result = $this->Behaviors->trigger('beforeSave', array(&$this, $options), array(
    				'break' => true, 'breakOn' => array(false, null)
    		));
    		if (!$result || !$this->beforeSave($options)) {
    			$this->whitelist = $_whitelist;
    			return false;
    		}
    	}
    
    	if (empty($this->data[$this->alias][$this->primaryKey])) {
    		unset($this->data[$this->alias][$this->primaryKey]);
    	} 

    	$fields = $values = array(); 
    	foreach ($this->data as $n => $v) {
    		if (isset($this->hasAndBelongsToMany[$n])) {
    			if (isset($v[$n])) {
    				$v = $v[$n];
    			}
    			$joined[$n] = $v;
    		} else {  
    			if ($n === $this->alias) {
    				foreach (array('create_time','created', 'updated', 'modified') as $field) {
    					if (array_key_exists($field, $v) && empty($v[$field])) {
    						unset($v[$field]);
    					}
    				}
    
    				foreach ($v as $x => $y) {
    					if ($this->hasField($x) && (empty($this->whitelist) || in_array($x, $this->whitelist))) {
    						list($fields[], $values[]) = array($x, $y);
    					}
    				}
    			}
    		}
    	}
    	$count = count($fields);
         
    	if (!$exists && $count > 0) {
    		$this->id = false;
    	}
    	$success = true;
    	$created = false;
    
    	if ($count > 0) {
    		$cache = $this->_prepareUpdateFields(array_combine($fields, $values));
    
    		if (!empty($this->id)) {
    			$success = (bool)$db->update($this, $fields, $values);
    		} else {
    			$fInfo = $this->schema($this->primaryKey);
    			$isUUID = ($fInfo['length'] == 36 &&
    					($fInfo['type'] === 'string' || $fInfo['type'] === 'binary')
    			);
    			if (empty($this->data[$this->alias][$this->primaryKey]) && $isUUID) {
    				if (array_key_exists($this->primaryKey, $this->data[$this->alias])) {
    					$j = array_search($this->primaryKey, $fields);
    					$values[$j] = String::uuid();
    				} else {
    					list($fields[], $values[]) = array($this->primaryKey, String::uuid());
    				}
    			}
    
    			if (!$db->create($this, $fields, $values)) {
    				$success = $created = false;
    			} else {
    				$created = true;
    			}
    		}
    
    		if ($success && !empty($this->belongsTo)) {
    			$this->updateCounterCache($cache, $created);
    		}
    	}
    
    	if (!empty($joined) && $success === true) {
    		$this->_saveMulti($joined, $this->id, $db);
    	}
    
    	if ($success && $count > 0) {
    		if (!empty($this->data)) {
    			$success = $this->data;
    			if ($created) {
    				$this->data[$this->alias][$this->primaryKey] = $this->id;
    			}
    		}
    		if ($options['callbacks'] === true || $options['callbacks'] === 'after') {
    			$this->Behaviors->trigger('afterSave', array(&$this, $created, $options));
    			$this->afterSave($created);
    		}			
    		if (!empty($this->data)) {
    			$success = Set::merge($success, $this->data);
    		}
    		$this->data = false;
    		$this->_clearCache();
    		$this->validationErrors = array();
    	}
    	$this->whitelist = $_whitelist;
    	return $success;
    }
}
