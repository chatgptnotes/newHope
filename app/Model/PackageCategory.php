<?php
/** PackageCategory model
*
* PHP 5
*
* @copyright     Copyright 2016 DrMHope Pvt Ltd  (http://www.drmhope.com/)
* @link          http://www.drmhope.com/
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Atul Chandankhede
*/
 
class PackageCategory extends AppModel {

	public $name = 'PackageCategory';
    public $specific = true;    		
	public $useTable = 'package_categories';
    
	
	function __construct($id = false, $table = null, $ds = null) {
	        $session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	        parent::__construct($id, $table, $ds);
    } 
    
    public function getPackageCategoryName($searchKey = null){  
    	if(!empty($searchKey)){
    		$condition['PackageCategory.name LIKE'] = $searchKey."%";
    	}
    	$packageCategory = $this->find('list',array('fields'=>array('PackageCategory.id','PackageCategory.name'),'conditions'=>array($condition,'PackageCategory.is_deleted'=>'0')));
    	return $packageCategory;
    }
}

?>