<?php
/**
 * OrderCategoriesController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2013 drmhope Inc.  (http://www.drmhope.com/)
 * @link          http://www.drmhope.com/
 * @package       OrderCategoriesController Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Mahalaxmi
 */

class OrderCategoriesController extends AppController {
	public $name = 'OrderCategories';
	public $uses = array('OrderCategory');
	public $helpers = array('Html','Form', 'Js','General','DateFormat');
	public $components = array('RequestHandler','Email','Auth','Session', 'Acl','Cookie','DateFormat');
	

	/////BOF-Mahalaxmi
	public function admin_index(){
		$this->layout= "advance";
		$this->uses = array('OrderCategory');		
		
		$searchId='';
		
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['OrderCategory']['Order_Category_Name']!=''){
			$conditions['OrderCategory']['order_description']=$this->request->data['OrderCategory']['Order_Category_Name'];			
		}
		
		$conditions['OrderCategory']['is_deleted'] = '0';
		//$conditions['OrderCategory']['status'] = '1';
		$conditions['OrderCategory']['location_id'] = $this->Session->read('locationid');
		
		$conditions = $this->postConditions($conditions);
		
		$this->paginate = array(
				'limit' => Configure::read('number_of_rows'),
				'fields'=>array('OrderCategory.order_description'),
				'order' => array(
						'OrderCategory.order_description' => 'DESC'
				),
				'conditions' => $conditions
		);
		$data = $this->paginate('OrderCategory');
		$this->set('data', $data);
		
		
	}
	public function admin_add(){
		$this->layout= "advance";
			$this->uses = array('OrderCategory');
	if(!empty($this->request->data)){
		$old_data = $this->OrderCategory->find('count',array('conditions'=>array('order_description'=>$this->request->data['OrderCategory']['order_description'])));
		 if($old_data && empty($this->request->data['OrderCategory']['id'])){
		$this->Session->setFlash(__('Order Category with this name is already exists.'),'default',array('class'=>'error'));
		$this->redirect(array('action'=>'add','admin'=>true));
		return false;
		}
		if(empty($this->request->data['OrderCategory']['id'])){
			$this->request->data['OrderCategory']['created_by']=$this->Session->read('userid');
			$this->request->data['OrderCategory']['create_time']=date("Y-m-d H:i:s");				
		}else{
			$this->request->data['OrderCategory']['modify_by']=$this->Session->read('userid');
			$this->request->data['OrderCategory']['modified_time']=date("Y-m-d H:i:s");
				
		}
		$this->request->data["OrderCategory"]["location_id"] = $this->Session->read('locationid');
	
		$this->OrderCategory->save($this->request->data);
		if(empty($this->request->data['OrderCategory']['id'])){
			$this->Session->setFlash(__('Order Category saved successfully', true));
		}
		$this->redirect(array("controller" => "OrderCategories", "action" => "index", "admin" => true));
	}
	
	/*$getOrderCategory = $this->OrderCategory->find('first',array('conditions'=>array('OrderCategory.id'=>$id)));
		$this->data=$getOrderCategory;*/
	}
	public function admin_edit($id=null){
		$this->layout= "advance";
		$this->uses = array('OrderCategory');
		if(!empty($this->request->data)){			
			if(empty($this->request->data['OrderCategory']['id'])){
				$this->request->data['OrderCategory']['created_by']=$this->Session->read('userid');
				$this->request->data['OrderCategory']['create_time']=date("Y-m-d H:i:s");
			}else{
				$this->request->data['OrderCategory']['modify_by']=$this->Session->read('userid');
				$this->request->data['OrderCategory']['modified_time']=date("Y-m-d H:i:s");
	
			}
			$this->request->data["OrderCategory"]["location_id"] = $this->Session->read('locationid');
	
			$this->OrderCategory->save($this->request->data);
			if(!empty($this->request->data['OrderCategory']['id'])){
				$this->Session->setFlash(__('Order Category updated successfully', true));
			}
			$this->redirect(array("controller" => "OrderCategories", "action" => "index", "admin" => true));
		}
		$this->data = $this->OrderCategory->read(null,$id);				
	}
	public function admin_delete($id = null) {
		$this->uses = array('OrderCategory');
		$this->request->data['OrderCategory']['is_deleted']=1;
		$this->OrderCategory->id= $id;
		if($this->OrderCategory->save($this->request->data['OrderCategory'])){
			$this->Session->setFlash(__('Order Category deleted successfully'),true);
			$this->redirect(array("controller" => "OrderCategories", "action" => "index",'admin'=>true));
		}
	}
}