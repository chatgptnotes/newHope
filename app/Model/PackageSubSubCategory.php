<?php
/** PackageSubSubCategory model
 *
* PHP 5
*
* @copyright     Copyright 2016 DrMHope Pvt Ltd  (http://www.drmhope.com/)
* @link          http://www.drmhope.com/
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Atul Chandankhede
*/

class PackageSubSubCategory extends AppModel {

	public $name = 'PackageSubSubCategory';
	public $specific = true;
	var $useTable = 'package_sub_sub_categories';


	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	 
	public function getSubSubPackageCategoryName($packageCategoryId,$packageSubCategoryId,$searchKey = null){
		$condition['PackageSubSubCategory.name LIKE'] = $searchKey."%";
		$packageSubSubCategory = $this->find('list',array('fields'=>array('PackageSubSubCategory.id','PackageSubSubCategory.name'),'conditions'=>array($condition,'PackageSubSubCategory.package_category_id'=>$packageCategoryId,'PackageSubSubCategory.package_sub_category_id'=>$packageSubCategoryId,'PackageSubSubCategory.is_deleted'=>'0')));
		return $packageSubSubCategory;
	}
	
	public function getSubSubPackageCategory(){
		$packageSubSubCategoryNames = $this->find('list',array('fields'=>array('PackageSubSubCategory.id','PackageSubSubCategory.name'),'conditions'=>array('PackageSubSubCategory.is_deleted'=>'0')));
		return $packageSubSubCategoryNames;
	}
}
?>