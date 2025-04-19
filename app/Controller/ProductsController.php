<?php
/**
 * Products controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       MMIS Model
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class ProductsController extends AppController {

	public $name = 'Products';
	//public $uses = array('Product');
	public $helpers = array('Html','Form', 'Js','Fck');
	public $components = array('RequestHandler','Email','ImageUpload');	
	
	
	
	

	public function admin_index(){
		
	}
	
	
	public function admin_add_product(){
		
	}
	
	public function admin_edit_product(){
	
	}
	
	// Import product sheet from goyal software
	//BY mrunal
	public function import_data(){
		Configure::write('debug',2) ;
		App::import('Vendor', 'reader');
		$this->set('title_for_layout', __('Laboratory- Export Data', true));
		if ($this->request->is('post')) { //pr($this->request->data);
			if($this->request->data['importData']['import_file']['error'] !="0"){
				$this->Session->setFlash(__('Please Upload the file'), 'default', array('class' => 'error'));
				$this->redirect(array("controller" => "Laboratories", "action" => "import_data","admin"=>false));
			}
	
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('CP1251');
			ini_set('memory_limit',-1);
			set_time_limit(0);
			$path = WWW_ROOT.'uploads/import/'. $this->request->data['importData']['import_file']['name'];
			move_uploaded_file($this->request->data['importData']['import_file']['tmp_name'],$path );
			chmod($data->path,777);
			$data = new Spreadsheet_Excel_Reader($path);
			$is_uploaded = $this->Product->importData($data);
			if($is_uploaded == true){
				unlink( $path );
				$this->Session->setFlash(__('Data imported sucessfully'), 'default', array('class' => 'message'));
				//$this->redirect($this->referer());
			}else{
				unlink( $path );
				$this->Session->setFlash(__('Error Occured Please check your Excel sheet.'), 'default', array('class' => 'error'));
				//$this->redirect($this->referer());
			}
	
		}
	
	}
	
	
	
}
