<?php
/**
 * CurrencyController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Locations.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        pankaj wanjari
 */
class CurrencyController extends AppController {
	public $name = "Currency";
	public $uses = array('Currency');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler');

	
	function superadmin_index(){ 
        $this->set('title_for_layout', __('Superadmin - Currency Listing'));        
		$this->index();
	}
	
	function admin_index(){   
		 
		$this->set('title_for_layout', __('Admin - Currency Listing')); 
		$this->index();
		$this->render('index'); 
	}
	
	function superadmin_edit($id){
		$this->set('title_for_layout', __('Superadmin - Edit Currency'));        
		$this->edit();
	}
	
	function admin_edit($id){
		$this->set('title_for_layout', __('Admin - Edit Currency'));        
		$this->edit($id);
		$this->render('edit'); 
	}
	
	function superadmin_view($id){
		$this->set('title_for_layout', __('Superadmin - View Currency'));        
		$this->view();
	}
	
	
	function admin_view($id){
		$this->set('title_for_layout', __('Admin - View Currency'));        
		$this->view($id);
		$this->render('view'); 
	}
	
	function index(){
		 
		if(isset($this->request->data) && isset($this->request->data) && $this->request->data['name']!=''){
    		$conditionsSearch["Currency"] = array("name LIKE" => "%".$this->request->data['name']."%");
    	}
		$conditionsSearch = $this->postConditions($conditionsSearch);
		$this->paginate = array(
	        'limit' => Configure::read('number_of_rows'),
			'conditions'=>$conditionsSearch,
	        'order' => array(
	            'Currency.name' => 'asc'
	        ), 
   		);
		$currencyList = $this->paginate('Currency'); 
		$this->set('list',$currencyList);  
	}
	
	function edit($id=null){
		if(!$id) return ;
		if(!empty($this->request->data['Currency'])){
			if($this->Currency->save($this->request->data['Currency'])){  
				$this->Session->setFlash(__('Record added successfully'),array('class'=>'success'));
				$this->redirect('index');
			}else{
				$errors = $this->Location->invalidFields();
                if(!empty($errors)) {
                	$this->set("errors", $errors);
                }
			}
		}
		$this->data = $this->Currency->getCurrencyByID($id);
	}
	
	function view($id=null){
		if(!$id) return ;
		$data = $this->Currency->getCurrencyByID($id);
		$this->set('data',$data);
	}
	
	function currency_format(){
		$this->layout = false ;
	}
}