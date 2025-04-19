<?php
/**
 * CorporateSublocationsController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Hope hospital
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author        Santosh R. Yadav
 */
class CorporateSublocationsController extends AppController {

	public $name = 'CorporateSublocations';
	public $uses = array('CorporateSublocation');
	public $helpers = array('Html','Form', 'Js');
	public $components = array('RequestHandler','Email');
	
/**
 * corporate sublocations listing
 *
 */	
	
	public function index() {
		$this->uses=array('TariffStandard','CorporateSublocation');
		

		$this->CorporateSublocation->bindModel(array('belongsTo'=>array(
				'TariffStandard'=>array('foreignKey'=>false,
						'conditions'=>array('CorporateSublocation.tariff_standard_id=TariffStandard.id'),
						'fields'=>array('TariffStandard.name','TariffStandard.id')),	
		)));
				$this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'CorporateSublocation.name' => 'asc'
			        ),
			        'conditions' => array('CorporateSublocation.is_deleted' => 0/*,'CorporateLocation.location_id'=>$this->Session->read('locationid')*/)
   				);
                $this->set('title_for_layout', __('Corporate Sublocation', true));
                $this->CorporateSublocation->recursive = 0;
           
                $data = $this->paginate('CorporateSublocation');
                $this->set('data', $data);
	}

/**
 * corporate sublocation view
 *
 */
	public function view($id = null) {
		$this->uses=array('TariffStandard','CorporateSublocation');
		
		
		$this->CorporateSublocation->bindModel(array('belongsTo'=>array(
				'TariffStandard'=>array('foreignKey'=>false,
						'conditions'=>array('CorporateSublocation.tariff_standard_id=TariffStandard.id'),
						'fields'=>array('TariffStandard.name','TariffStandard.id')),
		)));
                $this->set('title_for_layout', __('Corporate Sublocation Detail', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid Corporate Sublocation', true));
			$this->redirect(array("controller" => "corporate_sublocations", "action" => "index"));
		}
                $this->set('corporatesublocation', $this->CorporateSublocation->read(null, $id));
        }

/**
 * corporate sublocation add
 *
 */
	public function add() {
		$this->layout='advance';
                $this->uses=array('CorporateLocation','TariffStandard');
                $this->set('title_for_layout', __('Add New Corporate Sublocation', true));
                if ($this->request->is('post')) {
                        $this->request->data['CorporateSublocation']['create_time'] = date('Y-m-d H:i:s');
                        $this->request->data['CorporateSublocation']['created_by'] = $this->Auth->user('id');	
						$this->request->data['dr_name']=array_values($this->request->data['dr_name']);
						$this->request->data['mobile']=array_values($this->request->data['mobile']);
						$this->request->data['CorporateSublocation']['dr_name'] = serialize($this->request->data['dr_name']);
						$this->request->data['CorporateSublocation']['mobile'] = serialize($this->request->data['mobile']);
                        $this->CorporateSublocation->create();							
                        $this->CorporateSublocation->save($this->request->data);						
                        $errors = $this->CorporateSublocation->invalidFields();
			if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The corporate sublocation has been saved', true));
			   $this->redirect(array("controller" => "corporate_sublocations", "action" => "index"));
                        }
		} 
             //   $this->set('corporatelocations', $this->CorporateLocation->find('list', array('fields'=> array('id', 'name'),'conditions' => array('CorporateLocation.is_deleted' => 0,'CorporateLocation.location_id'=>$this->Session->read('locationid')))));
            
                $this->set('tariffstandard', $this->TariffStandard->find('list', array('fields'=> array('id', 'name'),'conditions' => array('TariffStandard.is_deleted' => 0,'TariffStandard.location_id'=>$this->Session->read('locationid')))));
                
	}

/**
 * corporate sublocation edit
 *
 */
	public function edit($id = null) {
		$this->layout='advance';
		$this->uses=array('CorporateLocation','TariffStandard','Corporate');
             //   $this->loadModel('CorporateLocation');
               // $this->loadModel('Corporate');
                $this->set('title_for_layout', __('Edit Corporate Sublocation Detail', true));
                if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Corporate Sublocation', true));
                        $this->redirect(array("controller" => "corporate_sublocations", "action" => "index"));
		}
                if ($this->request->is('post') && !empty($this->request->data)) {
                        $this->request->data['CorporateSublocation']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['CorporateSublocation']['modified_by'] = $this->Auth->user('id');
                        $this->CorporateSublocation->id = $this->request->data["CorporateSublocation"]['id'];		
						$this->request->data['dr_name']=array_values($this->request->data['dr_name']);
						$this->request->data['mobile']=array_values($this->request->data['mobile']);
						$this->request->data['CorporateSublocation']['dr_name'] = serialize($this->request->data['dr_name']);
						$this->request->data['CorporateSublocation']['mobile'] = serialize($this->request->data['mobile']); 
						
                        $this->CorporateSublocation->save($this->request->data);
						$errors = $this->CorporateSublocation->invalidFields();
                        if(!empty($errors)) {
                           $this->set("errors", $errors);
                        } else {
                           $this->Session->setFlash(__('The corporate sublocation has been updated', true));
			   $this->redirect(array("controller" => "corporate_sublocations", "action" => "index"));
                        }
		} else {
                        $this->request->data = $this->CorporateSublocation->read(null, $id);
                }
               // $this->set('corporatelocations', $this->CorporateLocation->find('list', array('fields'=> array('id', 'name'),'conditions' => array('CorporateLocation.is_deleted' => 0))));
               // $this->set('corporates', $this->Corporate->find('list', array('fields'=> array('id', 'name'),'conditions' => array('Corporate.is_deleted' => 0, 'Corporate.corporate_location_id'=>$this->request->data['CorporateSublocation']['corporate_location_id']))));
                $this->set('tariffstandard', $this->TariffStandard->find('list', array('fields'=> array('id', 'name'),'conditions' => array('TariffStandard.is_deleted' => 0,'TariffStandard.location_id'=>$this->Session->read('locationid')))));
	}

/**
 * corporate sublocation delete
 *
 */
	public function delete($id = null) {
                $this->set('title_for_layout', __('Delete Corporation Sublocation', true));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for corporate sublocation', true));
			$this->redirect(array("controller" => "corporate_sublocations", "action" => "index"));
		}
		if ($id) {
                        $this->CorporateSublocation->deleteCorporateSublocation($this->request->params);
                        $this->Session->setFlash(__('Corporate Sublocation deleted', true));
			$this->redirect(array("controller" => "corporate_sublocations", "action" => "index"));
		}
	}
        

/**
 * get corporate by xmlhttprequest
 *
 */
	public function getCorporate() {
                $this->loadModel('Corporate');
                if($this->params['isAjax']) {
                   $this->set('corporate', $this->Corporate->find('all', array('fields'=> array('id', 'name'),'conditions' => array('Corporate.is_deleted' => 0, 'Corporate.corporate_location_id' => $this->params->query['corporatelocationid']))));
                   $this->layout = 'ajax';
                   $this->render('/CorporateSublocations/ajaxgetcorporate');
                }  
	}

        
}
?>