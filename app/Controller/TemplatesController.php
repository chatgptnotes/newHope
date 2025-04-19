 <?php
/**
 * TemplatesController file
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Templates.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author
 */
class TemplatesController extends AppController {

	public $name = 'Templates';
	public $helpers = array('Html','Form', 'Js','DateFormat','RupeesToWords','Number','General');
	public $components = array('RequestHandler','Email','ImageUpload','DateFormat');

	public function index(){
		$this->loadModel('TemplateCategories');
		if(!empty($this->request->data['TemplateCategories']['name'])) {
			if(!empty($this->request->data['TemplateCategories']['name'])){

			$this->request->data['TemplateCategories']['modify_time'] = date("Y-m-d H:i:s");
			$this->request->data['TemplateCategories']['create_time'] =date('Y-m-d H:i:s');
			$this->request->data['TemplateCategories']['modified_by'] = $this->Session->read('userid');
			$this->request->data['TemplateCategories']['created_by'] = $this->Session->read('userid');
			$this->request->data['TemplateCategories']['location_id'] = $this->Session->read('locationid');
			
			$data= $this->TemplateCategories->save($this->request->data);
			$this->Session->setFlash(__('Category template have been saved', true, array('class'=>'message')));
			$this->redirect($this->referer());
			}
			else{
				$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			}
				$this->redirect($this->referer());
		}
	}
	
	public function template_delete($id=null){
		if(!empty($id)){
			$this->Template->id= $id ;
			$this->Template->save(array('is_deleted'=>1));
			$this->Template->updateAll(array('is_deleted'=>1),array('id'=>$id));
	
			$this->Session->setFlash(__('Template have been deleted', true, array('class'=>'message')));
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
		}
		$this->redirect($this->referer());
	}
	public function template_category(){
		$this->set('patientId',$this->params->query['patientId']);
		$this->set('noteId',$this->params->query['noteId']);
		$this->set('action',$this->params->query['action']);
		$this->set('controller',$this->params->query['controller']);
		$this->loadModel('Template');
		$this->loadModel('TemplateCategories');
		if(!empty($this->request->data)) {
			$this->request->data['Template']['modify_time'] = date("Y-m-d H:i:s");
			$this->request->data['Template']['create_time'] =date('Y-m-d H:i:s');
			$this->request->data['Template']['modified_by'] = $this->Session->read('userid');
			$this->request->data['Template']['created_by'] = $this->Session->read('userid');
			$this->request->data['Template']['location_id'] = $this->Session->read('locationid');
			$data= $this->Template->save($this->request->data);
			$this->Session->setFlash(__('Category template have been saved', true, array('class'=>'message')));
			$this->redirect($this->referer());
		}
		$conditions['Template.is_deleted'] = 0;
		if($this->request->query['template_category_id'])
			$conditions['Template.template_category_id'] = $this->request->query['template_category_id'];
		if($this->request->query['category_name'])
			$conditions['Template.category_name LIKE'] = $this->request->query['category_name'].'%';
		
		$this->paginate = array(
				'evalScripts' => true,
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Template.id'=>'DESC'),
				'conditions' =>$conditions
		);
		$this->set('dataTemplate',$this->paginate('Template'));
		$this->set('option',$this->TemplateCategories->find('list',array('fields'=>array('name'))));
	}
	public function sub_template_delete($id=null){
		$this->loadModel('TemplateSubCategories');
		if(!empty($id)){
			$this->TemplateSubCategories->id= $id ;
			$this->TemplateSubCategories->save(array('is_deleted'=>1));
			$this->TemplateSubCategories->updateAll(array('is_deleted'=>1),array('id'=>$id));
	
			$this->Session->setFlash(__('Sub Template have been deleted', true, array('class'=>'message')));
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
		}
		$this->redirect($this->referer());
	}
	public function template_sub_category(){
		$this->set('patientId',$this->params->query['patientId']);
		$this->set('noteId',$this->params->query['noteId']);
		$this->set('action',$this->params->query['action']);
		$this->set('controller',$this->params->query['controller']);
		
		$this->loadModel('Template');
		$this->loadModel('TemplateCategories');
		$this->loadModel('TemplateSubCategories');
		$this->loadModel('NoteTemplate') ;
		
		$parentOption  = $this->Template->find('list',array('fields'=>array('category_name'),'conditions'=>array('Template.template_category_id'=>$this->request->query['template_category_id'],'is_deleted'=>'0')));
		$this->set('subCategory',$parentOption);
		
		if(isset($this->request->data['TemplateSubCategories']['sub_category'])) {
			if(!empty($this->request->data['TemplateSubCategories']['sub_category'])){

				$this->request->data['TemplateSubCategories']['modify_time'] = date("Y-m-d H:i:s");
				$this->request->data['TemplateSubCategories']['create_time'] =date('Y-m-d H:i:s');
				$this->request->data['TemplateSubCategories']['modified_by'] = $this->Session->read('userid');
				$this->request->data['TemplateSubCategories']['created_by'] = $this->Session->read('userid');
				$this->request->data['TemplateSubCategories']['location_id'] = $this->Session->read('locationid');
					
				$data= $this->TemplateSubCategories->save($this->request->data);
				$this->Session->setFlash(__('Sub Category have been saved', true, array('class'=>'message')));
				$this->redirect('template_sub_category');
			}

			else{
				$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			}
				$this->redirect($this->referer());
		}
		$conditions['TemplateSubCategories.template_category_id'] = $this->request->query['template_category_id'];
		$conditions['TemplateSubCategories.is_deleted'] = 0;
		if($this->request->query['note_template_id']){	 
				$conditions['TemplateSubCategories.note_template_id'] = $this->request->query['note_template_id'];
		}
		if($this->request->query['template_id'])
			$conditions['TemplateSubCategories.template_id'] = $this->request->query['template_id'];
		
		if($this->request->query['sub_category'])
			$conditions['TemplateSubCategories.sub_category like'] = "%".$this->request->query['sub_category']."%";
		
		
		$this->Template->bindModel(array(
				'belongsTo' => array(
						'TemplateSubCategories' =>array('foreignKey'=>false,
								'conditions'=>array('TemplateSubCategories.template_id = Template.id')),
				)));
		$this->TemplateSubCategories->bindModel(array(
				'belongsTo' => array( 
						'NoteTemplate' =>array('foreignKey'=>false,
								'conditions'=>array('NoteTemplate.id = TemplateSubCategories.note_template_id')),
						'Template' =>array('foreignKey'=>false,
								'conditions'=>array('Template.id = TemplateSubCategories.template_id','Template.template_category_id')),
				)));
		$this->paginate = array(
				'evalScripts' => true,
				'limit' => Configure::read('number_of_rows'),
				'order' => array('TemplateSubCategories.id'=>'DESC'),
				'conditions' =>$conditions
		);
		
		$dataTemplateSub = $this->paginate('TemplateSubCategories');
		 
		$this->set('dataTemplateSub',$dataTemplateSub);
		
		
		$category_option  = $this->TemplateCategories->find('list',array('fields'=>array('name')));
		$this->set('category_option', $category_option);
		$option  = $this->Template->find('list',array('fields'=>array('category_name')));
		$parentOption  = $this->TemplateCategories->find('list',array('fields'=>array('name')));
		$this->set('option', $option);
		$this->set('parentOption', $parentOption);
		$this->set('categoryName',$this->Template->find('list',array('fields'=>array('category_name'),
				'conditions'=>array('is_deleted'=>'0','Template.template_category_id'=>$this->request->query['template_category_id']),
				'order'=>Array('Template.category_name'))));
		$this->set('notesTemplate',$this->NoteTemplate->find('list',array('fields'=>array('template_name'),'conditions'=>array('is_deleted'=>'0'),'order'=>Array('NoteTemplate.template_name'))));
		$this->set('optionValues',$this->TemplateCategories->find('list',array('fields'=>array('name'),'order'=>Array('TemplateCategories.name'))));

	}
	public function category_onchange($id){


		$this->loadModel('Template');
		$parentOption  = $this->Template->find('list',array('fields'=>array('category_name'),'conditions'=>array('Template.template_category_id'=>$id,'is_deleted'=>'0')));
		echo json_encode($parentOption);
		exit;

	}
	
	public function edit_template($id=null){
		$this->loadModel('Template');
		$this->loadModel('TemplateCategories');

		
		if (!empty($this->request->data['Template'])) {
				
				$this->request->data['Template']['modify_time'] = date("Y-m-d H:i:s");
				$this->request->data['Template']['create_time'] =date('Y-m-d H:i:s');
				$this->request->data['Template']['modified_by'] = $this->Session->read('userid');
				$this->request->data['Template']['created_by'] = $this->Session->read('userid');
				$data= $this->Template->save($this->request->data);
				if($data){
					$this->Session->setFlash(__('Templated Updated Sucessfully'),'default',array('class'=>'message'));
					$this->redirect('template_category');
				}else{
					$this->Session->setFlash(__('The Record could not be saved. Please, try again'),'default',array('class'=>'error'));
				} 
		} 
		
		$this->Template->bindModel(array(
				'belongsTo' => array(
						'TemplateCategories' =>array('foreignKey'=>false,
								'conditions'=>array('TemplateCategories.id = Template.template_category_id')),
				)));
		$temp_detail=$this->Template->find('first',array('fields'=>array('Template.id','Template.template_category_id','Template.category_name','TemplateCategories.name'),'conditions'=>array('Template.id'=>$id,'Template.is_deleted'=>0)));
		
		$this->data=$temp_detail;
		
		$option  = $this->TemplateCategories->find('list',array('fields'=>array('name')));
		$this->set('option', $option);
		
		 
	}
	public function edit_sub_temp($id=null){
		
		$this->loadModel('Template');
		$this->loadModel('TemplateCategories');
		$this->loadModel('TemplateSubCategories');
		
		if (!empty($this->request->data['TemplateSubCategoriesSubCategories'])) {
		
			$this->request->data['TemplateSubCategories']['modify_time'] = date("Y-m-d H:i:s");
			$this->request->data['TemplateSubCategories']['create_time'] =date('Y-m-d H:i:s');
			$this->request->data['TemplateSubCategories']['modified_by'] = $this->Session->read('userid');
			$this->request->data['TemplateSubCategories']['created_by'] = $this->Session->read('userid');
			$data= $this->TemplateSubCategories->save($this->request->data);
			if($data){
				$this->Session->setFlash(__('Template Sub Category Updated Sucessfully'),'default',array('class'=>'message'));
				$this->redirect('template_sub_category');
			}else{
				$this->Session->setFlash(__('The Record could not be saved. Please, try again'),'default',array('class'=>'error'));
			}
		}
		
		$this->TemplateSubCategories->bindModel(array(
				'belongsTo' => array(
						'Template' =>array('foreignKey'=>false,
								'conditions'=>array('Template.id = TemplateSubCategories.template_id')),
						'TemplateCategories' =>array('foreignKey'=>false,
								'conditions'=>array('TemplateCategories.id = TemplateSubCategories.template_category_id')),
				)));
		$temp_detail=$this->TemplateSubCategories->find('first',array('fields'=>array('TemplateSubCategories.id','TemplateSubCategories.template_id','TemplateSubCategories.template_category_id','TemplateSubCategories.sub_category','Template.category_name','TemplateCategories.name'),'conditions'=>array('TemplateSubCategories.id'=>$id,'TemplateSubCategories.is_deleted'=>0)));
		$option  = $this->TemplateCategories->find('list',array('fields'=>array('name')));
		$this->set('option', $option);
		$categoryOption  = $this->Template->find('list',array('fields'=>array('category_name')));
		$this->set('categoryOption', $categoryOption);
		
		$this->data=$temp_detail;
	}

	
	//BOF function to add template content with parent categor
	function addTemplateContent($template_category_id=null,$template_sub_category_id=null){//debug($this->request->data);exit;	
		if(empty($template_category_id)){
			$template_category_id=$this->request->query['template_category_id'];
		}
		
		if(!$template_category_id || empty($this->request->query['template_category_id'])) {
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}
		$this->layout = 'advance' ; 
		$this->uses = array('Template','TemplateCategories','NoteTemplate','TemplateSubCategories');
		//insert  
		if(!empty($this->request->data['TemplateSubCategories'])){ 
			   
			if(!empty($this->request->data['TemplateSubCategories']['template'])){ //insert only parent category i.e. template 
				if(is_array($this->request->data['TemplateSubCategories']['note_template_id']) && !empty($this->request->data['TemplateSubCategories']['note_template_id'])){
					foreach($this->request->data['TemplateSubCategories']['note_template_id'] as $notes){
						$saveTemplateArray =  array(
								'category_name'=>$this->request->data['TemplateSubCategories']['template'],
								'note_template_id'=>$notes,
								'template_category_id'=>$this->request->data['TemplateSubCategories']['template_category_id'],
								'template_speciality_id'=>$this->request->data['TemplateSubCategories']['template_speciality_id'],
								'organ_system'=>$this->request->data['TemplateSubCategories']['organ_system'],
								'is_negative'=>$this->request->data['TemplateSubCategories']['is_negative'],
								'is_textbox'=>$this->request->data['TemplateSubCategories']['is_textbox'],
								'modify_time'=>date("Y-m-d H:i:s"),
								'create_time'=>date('Y-m-d H:i:s'),
								'modified_by'=> $this->Session->read('userid'),
								'created_by'=> $this->Session->read('userid'),
								'location_id'=> $this->Session->read('locationid')
						);
						$data= $this->Template->save($saveTemplateArray);
						$this->Template->id = '' ;
					}
					
					$this->Session->setFlash(__('Template added successfully'), 'default', array('class'=>'message'));
				}else{
					$this->Session->setFlash(__('Please select template name'),'default',array('class'=>'error'));
					$this->redirect($this->referer()) ;
				}
				
				//$this->redirect('template_sub_category?template_category_id='.$template_category_id);
				$this->redirect(array('controller'=>'Templates','action'=>'template_sub_category','?'=>$this->request->query));
			}else{ //same template content
				$subCatArray = $this->request->data['TemplateSubCategories']['sub_category'] ; 
				if(is_array($subCatArray)){
					if(is_array($this->request->data['TemplateSubCategories']['note_template_id']) && !empty($this->request->data['TemplateSubCategories']['note_template_id'])){
						foreach($this->request->data['TemplateSubCategories']['note_template_id'] as $notes){
							foreach($subCatArray as $key=>$value){
								
								$saveContentArray =  array( 'sub_category'=> $value, //sub category 
									'is_default'=> $this->request->data['TemplateSubCategories']['is_default'][$key]!=''?$this->request->data['TemplateSubCategories']['is_default'][$key]:0,  
									'template_category_id'=>$this->request->data['TemplateSubCategories']['template_category_id'],
									'template_speciality_id'=>$this->request->data['TemplateSubCategories']['template_speciality_id'],
									'template_id'=>$this->request->data['TemplateSubCategories']['template_id'],
									'note_template_id'=>$notes,
										
									'organ_system'=>$this->request->data['TemplateSubCategories']['organ_system'],
									'is_negative'=>$this->request->data['TemplateSubCategories']['is_negative'],
									'is_textbox'=>$this->request->data['TemplateSubCategories']['is_textbox'],
									'modify_time'=>date("Y-m-d H:i:s"),
									'create_time'=>date('Y-m-d H:i:s'),
									'modified_by'=> $this->Session->read('userid'),
									'created_by'=> $this->Session->read('userid'),
									'location_id'=> $this->Session->read('locationid'),
										 
									'has_dropdown'=> $this->request->data['TemplateSubCategories']['has_dropdown'][$key]!=''?$this->request->data['TemplateSubCategories']['has_dropdown'][$key]:0,
									'extraSubcategory'=>serialize($this->request->data['TemplateSubCategories']['extraSubcategory'][$key]),
									'extraSubcategoryDesc'=>serialize($this->request->data['TemplateSubCategories']['extraSubcategoryDesc'][$key]),
									'extraSubcategoryDescNeg'=>serialize($this->request->data['TemplateSubCategories']['extraSubcategoryDescNeg'][$key]),
									'redNotAllowed'=>serialize($this->request->data['TemplateSubCategories']['redNotAllowed'][$key]),
								); 

								$data= $this->TemplateSubCategories->save($saveContentArray);
								$this->TemplateSubCategories->id = '';
							}
						}
						$this->Session->setFlash(__('Template content added successfully'),'default', array('class'=>'message'));
						//$this->redirect('template_sub_category?template_category_id='.$template_category_id);
						$this->redirect(array('controller'=>'Templates','action'=>'template_sub_category','?'=>$this->request->query));
					}else{
						$this->Session->setFlash(__('Please select template name'),'default', array('class'=>'error'));
						//$this->redirect('template_sub_category?template_category_id='.$template_category_id);
						$this->redirect($this->referer());
					}
						
				} 
			}
			//$this->redirect('template_sub_category'); //redirect to list page
		} 
		//EOF insert  
		$category_option  = $this->TemplateCategories->find('first',array('fields'=>array('name'),'conditions'=>array('id'=>$template_category_id))); 
		$this->set('category_option', $category_option);
		
		$parentOption  = $this->Template->find('list',array('fields'=>array('category_name'),
				'conditions'=>array('Template.template_category_id'=>$template_category_id,'is_deleted'=>'0'),'order'=>array('Template.category_name')));
		$this->set(array('subCategory'=>$parentOption,'template_category_id'=>$template_category_id));
		
		$notesTemplate = $this->NoteTemplate->find('list',array('fields'=>array('template_name'),'conditions' => array('NoteTemplate.is_deleted' => 0),'order'=>array('NoteTemplate.template_name')));
		$this->set('notesTemplate',$notesTemplate);

		 
	} 
	
	//edit sub category 
	function editTemplateContent($template_category_id=null,$template_sub_category_id=null){//debug($this->request->data);exit;
		$this->layout = 'advance' ;
		$this->uses = array('Template','TemplateCategories','NoteTemplate','TemplateSubCategories');
		if(!$template_category_id) {
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}
		
		if(!empty($this->request->data['TemplateSubCategories'])){
			  
				//foreach($this->request->data['TemplateSubCategories']['note_template_id'] as $notesTemplateID){
					
						/* $this->TemplateSubCategories->deleteAll(array('note_template_id'=>$notesTemplateID,
								'template_category_id'=>$this->request->data['TemplateSubCategories']['template_category_id'],
								'template_id'=>$this->request->data['TemplateSubCategories']['template_id'],
								'sub_category'=>$this->request->data['TemplateSubCategories']['old_sub_category'])); */
						
						$saveContentArray =  array( 
								'id'=>$this->request->data['TemplateSubCategories']['id'],
								'sub_category'=> $this->request->data['TemplateSubCategories']['sub_category'], //sub category
								'is_default'=> $this->request->data['TemplateSubCategories']['is_default'],
								'template_category_id'=>$this->request->data['TemplateSubCategories']['template_category_id'],
								'template_speciality_id'=>$this->request->data['TemplateSubCategories']['template_speciality_id'],
								'template_id'=>$this->request->data['TemplateSubCategories']['template_id'],
								'note_template_id'=>$this->request->data['TemplateSubCategories']['note_template_id'],
								'organ_system'=>$this->request->data['TemplateSubCategories']['organ_system'],
								'modify_time'=>date("Y-m-d H:i:s"),
								'create_time'=>date('Y-m-d H:i:s'),
								'modified_by'=> $this->Session->read('userid'),
								'created_by'=> $this->Session->read('userid'),
								'location_id'=> $this->Session->read('locationid'),
								'has_dropdown'=> $this->request->data['TemplateSubCategories']['has_dropdown'],
								'extraSubcategory'=>serialize($this->request->data['TemplateSubCategories']['extraSubcategory']),
								'extraSubcategoryDesc'=>serialize($this->request->data['TemplateSubCategories']['extraSubcategoryDesc']),
								'extraSubcategoryDescNeg'=>serialize($this->request->data['TemplateSubCategories']['extraSubcategoryDescNeg']),
								'redNotAllowed'=>serialize($this->request->data['TemplateSubCategories']['redNotAllowed']),
								
						);
						
						$this->Session->setFlash(__('Record added successfully.'),'default', array('class'=>'message'));
						$data= $this->TemplateSubCategories->save($saveContentArray);
						$this->redirect(array('controller'=>'Templates','action'=>'template_sub_category','?'=>$this->request->query));
						//$this->TemplateSubCategories->id = '';
				//} 
			 
		} 
		
		//EOF insert
		$category_option  = $this->TemplateCategories->find('first',array('fields'=>array('name'),'conditions'=>array('id'=>$template_category_id)));
		$this->set('category_option', $category_option);
		
		$parentOption  = $this->Template->find('list',array('fields'=>array('category_name'),'conditions'=>array('Template.template_category_id'=>$template_category_id,'is_deleted'=>'0')));
		$this->set(array('subCategory'=>$parentOption,'template_category_id'=>$template_category_id));
		
		$notesTemplate = $this->NoteTemplate->find('list',array('fields'=>array('template_name'),'conditions' => array('NoteTemplate.is_deleted' => 0)));
		$this->set('notesTemplate',$notesTemplate);
		
		//EDIT sub template
		if(!empty($template_sub_category_id)){
			$subCatData = $this->TemplateSubCategories->find('first',array('conditions'=>array('id'=>$template_sub_category_id)));
			$this->set('subCatData',$subCatData) ;
			$this->data = $subCatData ;
		}
	}
	
	function addNotesTemplateContent($template_category_id=null,$template_sub_category_id=null){
		$this->layout = 'advance' ;
		$this->uses = array('Template','TemplateCategories','NoteTemplate','TemplateSubCategories');
		if(!$template_category_id) {
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		} 
		if(!empty($this->request->data['TemplateSubCategories'])){ 
			foreach($this->request->data['TemplateSubCategories']['note_template_id'] as $notesTemplateID){
				
			/* $this->TemplateSubCategories->deleteAll(array('note_template_id'=>$notesTemplateID,
			 'template_category_id'=>$this->request->data['TemplateSubCategories']['template_category_id'],
					'template_id'=>$this->request->data['TemplateSubCategories']['template_id'],
					'sub_category'=>$this->request->data['TemplateSubCategories']['old_sub_category'])); */
		
			$saveContentArray =  array( 
					'sub_category'=> $this->request->data['TemplateSubCategories']['sub_category'], //sub category
					'is_default'=> $this->request->data['TemplateSubCategories']['is_default'],
					'template_category_id'=>$this->request->data['TemplateSubCategories']['template_category_id'],
					'template_speciality_id'=>$this->request->data['TemplateSubCategories']['template_speciality_id'],
					'template_id'=>$this->request->data['TemplateSubCategories']['template_id'],
					'note_template_id'=>$notesTemplateID,
					'modify_time'=>date("Y-m-d H:i:s"),
					'create_time'=>date('Y-m-d H:i:s'),
					'modified_by'=> $this->Session->read('userid'),
					'created_by'=> $this->Session->read('userid'),
					'location_id'=> $this->Session->read('locationid')
			); 
			$data= $this->TemplateSubCategories->save($saveContentArray); 
			$this->TemplateSubCategories->id = '';
		}
			$this->Session->setFlash(__('Record added successfully.'),'default', array('class'=>'message'));
			$this->redirect('template_sub_category?template_category_id='.$template_category_id); 
		}
		
		//EOF insert
		$category_option  = $this->TemplateCategories->find('first',array('fields'=>array('name'),'conditions'=>array('id'=>$template_category_id)));
		$this->set('category_option', $category_option);
		
		$parentOption  = $this->Template->find('list',array('fields'=>array('category_name'),'conditions'=>array('Template.template_category_id'=>$template_category_id,'is_deleted'=>'0')));
		$this->set(array('subCategory'=>$parentOption,'template_category_id'=>$template_category_id));
		
		$notesTemplate = $this->NoteTemplate->find('list',array('fields'=>array('template_name'),'conditions' => array('NoteTemplate.is_deleted' => 0)));
		$this->set('notesTemplate',$notesTemplate);
		
		//EDIT sub template
		if(!empty($template_sub_category_id)){
			$subCatData = $this->TemplateSubCategories->find('first',array('conditions'=>array('id'=>$template_sub_category_id)));
			$this->set('subCatData',$subCatData) ;
			$this->data = $subCatData ;
		}
	}
	
	public function sort($id){
		$this->layout = 'ajax';
		$this->autoRender = false ;
		$this->uses =  array('TemplateSubCategories') ; 
		if(!empty($id)){ 
			$data = array();
			$data['TemplateSubCategories']['id'] = $id;
			$data['TemplateSubCategories']['sort_order'] = $this->request->data['sort_order']; 
			$this->TemplateSubCategories->save($data); 
		}
	}
	public function sortParentCategory(){
		$this->uses = array('Template');
		
		$this->paginate = array(
				'evalScripts' => true,
				'limit' => Configure::read('number_of_rows'),
				'order' => array('Template.category_name'=>'Asc'),
				'conditions'=>array('Template.is_deleted'=>'0','Template.template_category_id'=>$this->params->query['template_category_id'])
		);
		
		$this->set('dataTemplet',$this->paginate('Template'));
		
		
	}
	public function sortParent($id){
		$this->layout = 'ajax';
		$this->autoRender = false ;
		$this->uses =  array('TemplateSubCategories') ;
		if(!empty($id)){
			//search if already exit
			//$isExist= $this->Template->find('first',array('conditions'=>array('id'=>$id))) ;
			$data = array(); 
			$data['Template']['id'] = $id;
			$data['Template']['sort_order']		   = $this->request->data['sort_order']; 
			$this->Template->save($data);
			echo $data['Template']['sort_no'] ; 
		}
	}
	public function editParentTemplate($id=null,$template_category_id=null){
		$this->uses =  array('Template','TemplateCategories','NoteTemplate','TemplateSubCategories') ;
		if(!$id) {
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}
		if(!empty($this->request->data['Template'])){ 
			$saveContentArray =  array(
					'id'=>$this->request->data['Template']['id'],
					'template_category_id'=>$this->request->data['Template']['template_category_id'],
					'category_name'=>$this->request->data['Template']['category_name'],
					'sentence'=>$this->request->data['Template']['sentence'],
					'template_speciality_id'=>$this->request->data['Template']['template_speciality_id'],
					'note_template_id'=>$this->request->data['Template']['note_template_id'],
					'is_deleted'=>$this->request->data['Template']['is_deleted'],
					'organ_system'=>$this->request->data['Template']['organ_system'],
					'modify_time'=>date("Y-m-d H:i:s"),
					'create_time'=>date('Y-m-d H:i:s'),
					'modified_by'=> $this->Session->read('userid'),
					'created_by'=> $this->Session->read('userid'),
					'sort_no'=> $this->request->data['Template']['sort_no']
			); 
			$data= $this->Template->save($saveContentArray);
			$this->redirect(array('controller'=>'Templates','action'=>'sortParentCategory','?'=>array('template_category_id'=>$template_category_id)));
		
		}
		$category_option  = $this->TemplateCategories->find('first',array('fields'=>array('name'),'conditions'=>array('id'=>$template_category_id)));
		$this->set('category_option', $category_option);
		
		$parentOption  = $this->Template->find('first',array('conditions'=>array('Template.id'=>$id,'is_deleted'=>'0')));
		$this->set(array('id'=>$id,'template_category_id'=>$template_category_id));
		
		$notesTemplate = $this->NoteTemplate->find('list',array('fields'=>array('template_name'),'conditions' => array('NoteTemplate.is_deleted' => 0)));
		$this->set('notesTemplate',$notesTemplate);
		
		$this->data = $parentOption ;
	}
	public function templateDelete($id=null){
		$this->uses =  array('Template') ;
		if(!empty($id)){
			$this->Template->id= $id ;
			$this->Template->save(array('is_deleted'=>1));
			$this->Template->updateAll(array('is_deleted'=>1),array('id'=>$id));
	
			$this->Session->setFlash(__('Sub Template have been deleted', true, array('class'=>'message')));
		}else{
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
		}
		$this->redirect($this->referer());
	}
	
	 
	//function to save text button template
	function addNewBtnTemplateText($id){
		$this->layout = 'ajax' ;
		$this->autoRender =false; 
		if(empty($id)) return false ;
		
		$this->uses=array('TemplateSubCategories') ; 
		$result =  $this->TemplateSubCategories->find('first',array('conditions'=>array('id'=>$id))) ;
		 
		if(!empty($result['TemplateSubCategories']['extra_options_by_user'])){
			$btnTemplateText = unserialize($result['TemplateSubCategories']['extra_options_by_user']);//unserialize saved items and then append current template text
			$btnTemplateText = serialize(array_merge($btnTemplateText,array($this->request->data['extra_options_by_user']))) ;
		}else{
			$btnTemplateText = serialize(array($this->request->data['extra_options_by_user'])); //serialize array with zero indexing
		}
		$this->TemplateSubCategories->id = $id;
		$this->TemplateSubCategories->save(array('extra_options_by_user'=>$btnTemplateText)) ; //save serilaize options  
			
	}
	
	//view button temaplte text 
	function viewBtnTemplateText($id){
		$this->layout = false  ; 
		if(empty($id)) return false ; 
		$this->uses=array('TemplateSubCategories') ;
		$result =  $this->TemplateSubCategories->find('first',array('conditions'=>array('id'=>$id))) ;
		$this->set('btnTemplate',unserialize($result['TemplateSubCategories']['extra_options_by_user'])) ;
		$this->set('id',$id);
		//echo json_encode(serilaize($result['TemplateSubCategories']['extra_options_by_user'])) ;
	}
	
	
	public function addParentCategory(){
		$this->uses =  array('Template','TemplateCategories','NoteTemplate','TemplateSubCategories') ;
		if(!$this->params->query['template_category_id']) {
			$this->Session->setFlash(__('Please try again', true, array('class'=>'error')));
			$this->redirect($this->referer());
		}
		if(!empty($this->request->data['Template'])){ 
	
			$saveContentArray =  array( 
					'template_category_id'=>$this->request->data['Template']['template_category_id'],
					'category_name'=>$this->request->data['Template']['category_name'],
					'sentence'=>$this->request->data['Template']['sentence'],
					'template_speciality_id'=>$this->request->data['Template']['template_speciality_id'], 
					'is_deleted'=>$this->request->data['Template']['is_deleted'],
					'organ_system'=>$this->request->data['Template']['organ_system'],
					'modify_time'=>date("Y-m-d H:i:s"),
					'create_time'=>date('Y-m-d H:i:s'),
					'modified_by'=> $this->Session->read('userid'),
					'created_by'=> $this->Session->read('userid'),
					'sort_no'=> $this->request->data['Template']['sort_no']
			);
			//	debug($saveContentArray);exit;
			$data= $this->Template->save($saveContentArray);
			//$this->redirect(array('controller'=>'Templates','action'=>'template_sub_category','?'=>$this->request->query));
				
			$this->redirect(array('controller'=>'Templates','action'=>'sortParentCategory','?'=>$this->request->query));
	
		}
		$category_option  = $this->TemplateCategories->find('first',array('fields'=>array('name'),'conditions'=>array('id'=>$this->params->query['template_category_id'])));
		$this->set('category_option', $category_option);
	
		$parentOption  = $this->Template->find('first',array('conditions'=>array('Template.id'=>$id,'is_deleted'=>'0')));
		$this->set(array('id'=>$id,'template_category_id'=>$template_category_id));
	
		$this->data = $parentOption ;
	}
	
	function deleteBtnTemplateText($id=null){
		$this->layout='ajax' ;
		$this->autoRender = false ;
		if(!id) return false ;		
		$this->uses = array('TemplateSubCategories') ;
		$splittedID = explode("-",$id);
		$result =  $this->TemplateSubCategories->find('first',array('conditions'=>array('id'=>$splittedID[0]))) ;
		$data = unserialize($result['TemplateSubCategories']['extra_options_by_user']) ;
		unset($data[$splittedID[1]]);
		
		$this->TemplateSubCategories->id = $splittedID[0];
		$this->TemplateSubCategories->save(array('extra_options_by_user'=>serialize($data))) ; 
	}
}
