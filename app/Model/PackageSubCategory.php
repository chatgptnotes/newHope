<?php
/** PackageSubCategory model
*
* PHP 5
*
* @copyright     Copyright 2016 DrMHope Pvt Ltd  (http://www.drmhope.com/)
* @link          http://www.drmhope.com/
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Atul Chandankhede
*/
 
class PackageSubCategory extends AppModel {

	public $name = 'PackageSubCategory';
    public $specific = true;    		
	var $useTable = 'package_sub_categories';
    
	
	function __construct($id = false, $table = null, $ds = null) {
	        $session = new cakeSession();
			$this->db_name =  $session->read('db_name');
	        parent::__construct($id, $table, $ds);
    } 
    
    public function getSubPackageCategoryName($packageCategoryId,$searchKey=null){
    	$condition['PackageSubCategory.name LIKE'] = $searchKey."%";
    	$packageSubCategory = $this->find('list',array('fields'=>array('PackageSubCategory.id','PackageSubCategory.name'),'conditions'=>array($condition,'PackageSubCategory.package_category_id'=>$packageCategoryId,'PackageSubCategory.is_deleted'=>'0')));
    	return $packageSubCategory;
    }
    
    public function getSubPackageCategory($packageCategoryId,$searchKey=null){
    	$packageSubCategoryNames = $this->find('list',array('fields'=>array('PackageSubCategory.id','PackageSubCategory.name'),'conditions'=>array('PackageSubCategory.is_deleted'=>'0')));
    	return $packageSubCategoryNames;
    }

    public function getSubPackageByID($id){
        $condition['PackageSubCategory.package_category_id'] = $id;
        $packageSubCategory = $this->find('all',array('fields'=>array('PackageSubCategory.id','PackageSubCategory.name','PackageSubCategory.template_name'),'conditions'=>array($condition,'PackageSubCategory.is_deleted'=>'0')));
        return $packageSubCategory;
    }
   
}
?>