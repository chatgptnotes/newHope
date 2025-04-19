<?php
/** GalleryPackageDetail model
 *
* PHP 5
*
* @copyright     Copyright 2016 DrMHope Pvt Ltd  (http://www.drmhope.com/)
* @link          http://www.drmhope.com/
* @since         CakePHP(tm) v 2.0
* @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
* @author        Atul Chandankhede
*/

class GalleryPackageDetail extends AppModel {
	
	public $name = 'GalleryPackageDetail';
	public $specific = true;
	var $useTable = 'gallery_package_details';


	function __construct($id = false, $table = null, $ds = null) {
		$session = new cakeSession();
		$this->db_name =  $session->read('db_name');
		parent::__construct($id, $table, $ds);
	}
	 
	/**
	 * save package category n their subcategories details from billing
	 * @param int $patientId
	 * @param requestData $detailsArray
	 * @author Atul Chandandankhede - 30.03.2016
	 */
	
	public function insertPackageDetails($patientId,$detailsArray=array()){
		$session = new cakeSession();
		
		if(!empty($detailsArray)){
			if(empty($detailsArray['GalleryPackageDetail']['gallery_package_id'])){
				$this->id='';
				$packageArray['GalleryPackageDetail']['create_time'] = date('Y-m-d H:i:s');
				$packageArray['GalleryPackageDetail']['created_by'] = $session->read('userid');
			}else{
				$this->id = $detailsArray['GalleryPackageDetail']['gallery_package_id'];
				$packageArray['GalleryPackageDetail']['modify_time'] = date('Y-m-d H:i:s');
				$packageArray['GalleryPackageDetail']['modified_by'] = $session->read('userid');
			}
			$packageArray['GalleryPackageDetail']['package_category_id'] =  $detailsArray['GalleryPackageDetail']['package_category_id'] ;
			$packageArray['GalleryPackageDetail']['package_sub_category_id'] =  $detailsArray['GalleryPackageDetail']['package_sub_category_id'] ;
			$packageArray['GalleryPackageDetail']['package_subsub_category_id'] =  $detailsArray['GalleryPackageDetail']['package_subsub_category_id'] ;
			$packageArray['GalleryPackageDetail']['patient_id'] =  $patientId ;
			$this->save($packageArray);
		}
		 
	}
	
	public function getPackageDetailsById($patientId){
	 $result = $this->find('first',array('fields'=>array('GalleryPackageDetail.id','GalleryPackageDetail.package_category_id',
	 		'GalleryPackageDetail.patient_id','GalleryPackageDetail.package_sub_category_id','GalleryPackageDetail.package_subsub_category_id'),
	 		'conditions'=>array('GalleryPackageDetail.patient_id'=>$patientId,'GalleryPackageDetail.is_deleted'=>'0')));
	 return $result;
	}
	
}
?>