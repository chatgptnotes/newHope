<?php
class ScreeningsController extends AppController {
	public $name = 'Screenings';
	public $uses = 'Screening';
	
public function phq($patient_id=null)
	{
		$patient_id = 72; //static patient_id
		$form_name = "phq";
		if(!empty($patient_id))
		{
			$Screenings = $this->Screening->find(first,array('conditions'=>array('Screening.patient_id'=>$patient_id,'Screening.form_name'=>$form_name)));
			//debug($Screenings);
			$this->set('Screenings',$Screenings);
			if(!empty($this->request->data))
			{	
				$this->request->data['Screening']['patient_id'] = $patient_id;
				$this->request->data['Screening']['ser_data'] = serialize($this->request->data['Screening']['questions']); //serializing the data's
				$success = $this->Screening->insertdata($this->request->data);
				
				if(!$success){
					$this->Session->setFlash(__('Record added successfully', true)); 	
				}else{
					$this->Session->setFlash(__('Please try again'),'default',array('class'=>"error"));
				} 
				$this->redirect($this->referer());
			}
		}
		else
		{
			$this->Session->setFlash(__('Could not Save try again'),'default',array('class'=>"error"));
		}
	} 
/*EOF Atul*/
	
	//reference from http://library.umassmed.edu/ementalhealth/clinical/zung_depression.pdf
	//by swapnil
	public function depression($patient_id=null)
	{
		$patient_id = 1234; //static patient_id
		$form_name = "depression";
		if(!empty($patient_id))
		{
			$Screenings = $this->Screening->find(first,array('conditions'=>array('Screening.patient_id'=>$patient_id,'Screening.form_name'=>$form_name)));
			$this->set('Screenings',$Screenings);
			if(!empty($this->request->data))
			{	
				$this->request->data['Screening']['patient_id'] = $patient_id;
				$this->request->data['Screening']['ser_data'] = serialize($this->request->data['Screening']['questions']); //serializing the data's
				$success = $this->Screening->insertdata($this->request->data);
				if(!$success){
					$this->Session->setFlash(__('Record added successfully', true)); 	
				}else{
					$this->Session->setFlash(__('Please try again'),'default',array('class'=>"error"));
				} 
				$this->redirect($this->referer());
			}
		}
		else
		{
			$this->Session->setFlash(__('Could not Save try again'),'default',array('class'=>"error"));
		}
	}

	/**
	 * http://www.integration.samhsa.gov/clinical-practice/GAD708.19.08Cartwright.pdf
	 */ //by swatin
	public function gad()
	{	
		$patient_id = 782; //static patient_id
		$form_name = "gad";
		if(!empty($patient_id))
		{
			$Screenings = $this->Screening->find(first,array('conditions'=>array('Screening.patient_id'=>$patient_id,'Screening.form_name'=>$form_name)));
			//debug($Screenings);
			$this->set('Screenings',$Screenings);
			if(!empty($this->request->data))
			{	
				$this->request->data['Screening']['patient_id'] = $patient_id;
				$this->request->data['Screening']['ser_data'] = serialize($this->request->data['Screening']['questions']); //serializing the data's
				$success = $this->Screening->insertdata($this->request->data);
				
				if(!$success){
					$this->Session->setFlash(__('Record added successfully', true)); 	
				}else{
					$this->Session->setFlash(__('Please try again'),'default',array('class'=>"error"));
				} 
				$this->redirect($this->referer());
			}
		}
		else
		{
			$this->Session->setFlash(__('Could not Save try again'),'default',array('class'=>"error"));
		}
	}
	
	//http://counsellingresource.com/lib/quizzes/drug-Screeninging/drug-abuse/
	//by Amit
	public function drug_abuse($patient_id=null)
	{
		$patient_id = 1; //static patient_id
		$form_name = "drug_abuse";
		if(!empty($patient_id))
		{
			$Screenings = $this->Screening->find(first,array('conditions'=>array('Screening.patient_id'=>$patient_id,'Screening.form_name'=>$form_name)));
			$this->set('Screenings',$Screenings);
			if(!empty($this->request->data))
			{
				$this->request->data['Screening']['patient_id'] = $patient_id;
				$this->request->data['Screening']['ser_data'] = serialize($this->request->data['Screening']['questions']); //serializing the data's
				$success = $this->Screening->insertdata($this->request->data);
					
				if(!$success){
					$this->Session->setFlash(__('Record added successfully', true));
				}else{
					$this->Session->setFlash(__('Please try again'),'default',array('class'=>"error"));
				}
				$this->redirect($this->referer());
			}
		}
		else
		{
			$this->Session->setFlash(__('Could not Save try again'),'default',array('class'=>"error"));
		}
	}

	
		/**
	 * Audit for -http://pubs.niaaa.nih.gov/publications/aa65/AA65.htm
	 */
	public function audit($patient_id=null)
	{
		$patient_id = 10; //static patient_id
		$form_name = "audit";
		if(!empty($patient_id))
		{
			$Screenings = $this->Screening->find(first,array('conditions'=>array('Screening.patient_id'=>$patient_id,'Screening.form_name'=>$form_name)));
			$this->set('Screenings',$Screenings);
			if(!empty($this->request->data))
			{
				$this->request->data['Screening']['patient_id'] = $patient_id;
				$this->request->data['Screening']['ser_data'] = serialize($this->request->data['Screening']['questions']); //serializing the data's
				$success = $this->Screening->insertdata($this->request->data);
		
				if(!$success){
					$this->Session->setFlash(__('Record added successfully', true));
				}else{
					$this->Session->setFlash(__('Please try again'),'default',array('class'=>"error"));
				}
				$this->redirect($this->referer());
			}
		}
		else
		{
			$this->Session->setFlash(__('Could not Save try again'),'default',array('class'=>"error"));
		}
		
	}
	
	
	//http://www.integration.samhsa.gov/images/res/MDQ.pdf
	public function mdq() {
	
		if(!empty($this->request->data))
		{
				
			$this->request->data[Screening][ser_data] = serialize($this->request->data[Screening][questions]);
			$this->Screening->insertdata($this->request->data);
			//debug($this->request->data);
			//$data = $this->request->data;
			//$ser = serialize($data);
			// debug($ser);
	
			//$unser = unserialize($ser);
			// debug($unser);
		}
	
	}
	
	public function hamilton($patient_id=null)
	{
		$patient_id = 1234; //static patient_id
		$form_name = "hamilton";
		if(!empty($patient_id))
		{
			$Screenings = $this->Screening->find(first,array('conditions'=>array('Screening.patient_id'=>$patient_id,'Screening.form_name'=>$form_name)));
			$this->set('Screenings',$Screenings);
			if(!empty($this->request->data))
			{	
				$this->request->data['Screening']['patient_id'] = $patient_id;
				$this->request->data['Screening']['ser_data'] = serialize($this->request->data['Screening']['questions']); //serializing the data's
				$success = $this->Screening->insertdata($this->request->data);
				if(!$success){
					$this->Session->setFlash(__('Record added successfully', true)); 	
				}else{
					$this->Session->setFlash(__('Please try again'),'default',array('class'=>"error"));
				} 
				$this->redirect($this->referer());
			}
		}
		else
		{
			$this->Session->setFlash(__('Could not Save try again'),'default',array('class'=>"error"));
		}
	}
	
	
}
?>