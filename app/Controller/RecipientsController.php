<?php
/**
 * Fax Controller
 *
 * PHP 5
 *
 * @copyright     Copyright 2011 KloudData Inc.  (http://www.klouddata.com/)
 * @link          http://www.klouddata.com/
 * @package       Instrument Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 
 */
class RecipientsController   extends AppController {
	public $name = 'Recipients';
	public $uses = array('Recipient');
	public $helpers = array('Html','Form', 'Js','General');
	public $components = array('RequestHandler','Email');	
	

/**
 * index method
 *
 * @return void
 */
	public function index($patient_id) {
		 
		$this->patient_info($patient_id);
		$this->uses = array('SendReferral','Recipient');

		 $this->paginate = array(
			        'limit' => Configure::read('number_of_rows'),
			        'order' => array(
			            'Recipient.name' => 'asc'
			        ),
                                'conditions' => array('Recipient.is_deleted' => 0)
			    );
		  $this->SendReferral->bindModel(array(
		 		'belongsTo' => array(
		 				'Recipient' =>array('foreignKey' => false),
		 				
		 		),'conditions' => array('Recipient.id=SendReferral.recipient_id','Recipient.patient_id'=>$patient_id)),false); 
		
		 $fax=$this->SendReferral->find('all',array('fields'=>array('SendReferral.recipient_id','SendReferral.is_generated')
		 		,'conditions'=>array('SendReferral.is_generated'=>1),'group'=>array('SendReferral.recipient_id')));
		 $this->set('fax',$fax);
		 $this->set('patient_id', $patient_id);
		$this->set('recipients', $this->paginate('Recipient')); 
		
	}


/**
 * add method
 *
 * @return void*/
 
	public function add($patient_id) {
		
		$this->layout = false ;
		$this->loadModel('Department');
		$this->uses = array('Department','Recipient','DoctorTemplate');
		if ($this->request->is('post')) {
			$this->Recipient->create();
                        $this->request->data['Recipient']['location_id'] = $this->Session->read('locationid');
                        $this->request->data['Recipient']['create_time'] = date('Y-m-d H:i:s');
                        $this->request->data['Recipient']['created_by'] = $this->Auth->user('id');
			if ($this->Recipient->save($this->request->data)) {
				$this->Session->setFlash(__('The Recipient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				if($this->Recipient->validationErrors){
					$this->set('errors', $this->Recipient->validationErrors);
				}else{
					$this->Session->setFlash(__('The Recipient could not be saved. Please, try again.'));
				}
			}
		}
		
		$departments=$this->Department->find('list',array('fields'=>array('id','name'),'order' => array('Department.name'),
				'group'=>'Department.name'));
		
		$this->set('departments',$departments);
		$this->set('patient_id',$patient_id);
		
	}

/**
 * edit method
 *
 * @param string $id
 * @return void*/
 
	public function edit($id) {
		
		$this->layout = false ;
		$this->loadModel('Department');
                $this->Recipient->id = $id;
		if ($this->request->is('post') || $this->request->is('put')) {
						$this->request->data['Recipient']['id'] = $this->request->data['Recipient']['id'];
			            $this->request->data['Recipient']['name'] = $this->request->data['Recipient']['name'];
                        $this->request->data['Recipient']['modify_time'] = date('Y-m-d H:i:s');
                        $this->request->data['Recipient']['modified_by'] = $this->Auth->user('id');
			if ($this->Recipient->save($this->request->data)) {
				$this->Session->setFlash(__('The Recipient has been updated.'));
				$this->redirect(array('action' => 'index'));
			} else {
			$this->set('errors', $this->Recipient->validationErrors);

				$this->Session->setFlash(__('The Recipient could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Recipient->read(null, $id);
		}
		$departments=$this->Recipient->find('all',array('fields'=>array('id','name')));
		$departments=$this->Department->find('list',array('fields'=>array('id','name'),'order' => array('Department.name'),
				'group'=>'Department.name'));
		
		$this->set('departments',$departments);
		
	}
	public function referral_preview_action($id=null,$patient_id=null,$emailsId=null){
		/* debug($id);
		debug($patient_id);
		debug($emailsId);
		exit; */
		$this->layout='advance_ajax';
		$userid = $this->Session->read('userid') ;
		$this->uses = array('Note','NewCropPrescription','NoteDiagnosis','Recipient','Patient','User','NoteTemplate','BmiResult');
		$expRecipient=explode('|',$emailsId);
		$this->set('emailsId',$emailsId);
		$getDoctorName=$this->User->find('all',array('fields'=>array('User.first_name','User.last_name'),'conditions'=>array('User.id'=>$expRecipient)));
		$this->set('getDoctorName',$getDoctorName);
		$this->BmiResult->bindModel(array('belongsTo'=>array(
									'BmiBpResult'=>array('foreignKey'=>false,'conditions'=>array('BmiResult.id=BmiBpResult.bmi_result_id')))));
		$vitals=$this->BmiResult->find('first',array('fields'=>array('BmiResult.id','BmiResult.height_result','BmiResult.weight_result',
				'BmiResult.bmi','BmiResult.temperature','BmiResult.myoption','BmiResult.temp_source','BmiBpResult.systolic','BmiBpResult.diastolic'),
				'conditions'=>array('BmiResult.patient_id'=>$patient_id),'group'=>'BmiResult.patient_id desc'));
		$this->set('vitals',$vitals);
		$medication=$this->NewCropPrescription->find('all',array('fields'=>array('description','date_of_prescription','end_date'),'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$patient_id)));
		
		$this->set('medication',$medication);
		$diagnosis=$this->NoteDiagnosis->find('all',array('fields'=>array('diagnoses_name','start_dt','end_dt'),'conditions'=>array('NoteDiagnosis.patient_id'=>$patient_id)));
	
		$this->set('diagnosis',$diagnosis);
		
		$this->set('id',$id);
		$this->set('patient_id',$patient_id);
		$this->set('userid',$userid);
		
		$recipients=$this->Recipient->find('first',array('fields'=>array('id','name'),'conditions'=>array('Recipient.id'=>$id)));
		$this->set('recipients',$recipients);
		$name=$this->Patient->find('first',array('fields'=>array('id','lookup_name'),'conditions'=>array('Patient.id'=>$patient_id)));
		$this->set('name',$name);
		$getTemplate=$this->NoteTemplate->find('all',array('fields'=>array('id','template_name'),'conditions'=>array('template_type'=>'implants')));
		$this->set('data',$getTemplate);
		
		$this->User->bindModel(array(
				'belongsTo' => array(
						'Patient' =>array('foreignKey' => false,'conditions'=>array('User.id=Patient.doctor_id' )),
				)));
		$provider = $this->User->find('first',array('conditions'=>array('Patient.id'=>$patient_id),'fields'=>array('User.first_name','User.last_name')));
		$this->set('provider',$provider);
	}
	
	
	public function referral_pdf($id,$patient_id){
		
		$userid = $this->Session->read('userid') ;
		 
		$this->uses = array('Note','NewCropPrescription','NoteDiagnosis','Output','SendReferral','Recipient','Patient');
		
		$faxReferral = array('report_name'=>'Fax_referral'.$id.''._.''.$userid.'.pdf','recipient_id'=>$id,'is_generated'=>'1') ;
		
		if(!empty($isExist['SendReferral']['id'])){
			$this->SendReferral->id = $isExist['SendReferral']['id'] ;
			$result = $this->SendReferral->save($faxReferral);
		}else{
			$result = $this->SendReferral->save($faxReferral);
		}
		
		
		$faxRecipient = array('id'=>$id,'report_name'=>'Fax_referral'.$id.''._.''.$userid.'.pdf','is_generated'=>'1') ;
		
		if(!empty($isExist['Recipient']['id'])){
			$this->Recipient->id = $isExist['Recipient']['id'] ;
			$this->Recipient->updateAll($faxRecipient);
				
		}else{
			 $this->Recipient->save($faxRecipient);
		}
		if($result){
			$this->Session->setFlash(__('The Fax has been saved'));
		}else{
			$this->Session->setFlash(__('Please try again'),'default',array('class'=>'error'));
		}
		
		$vitals=$this->Note->find('first',array('fields'=>array('id','ht','wt','bmi','bp','temp'),'conditions'=>array('Note.patient_id'=>$id),'group'=>'Note.patient_id desc'));
		$this->set('vitals',$vitals);
		$medication=$this->NewCropPrescription->find('all',array('fields'=>array('description','date_of_prescription','end_date'),'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$patient_id)));
	
		$this->set('medication',$medication);
	
		$diagnosis=$this->NoteDiagnosis->find('all',array('fields'=>array('diagnoses_name','start_dt','end_dt'),'conditions'=>array('NoteDiagnosis.patient_id'=>$patient_id)));
	
		$this->set('diagnosis',$diagnosis);
		$recipients=$this->Recipient->find('all',array('fields'=>array('id','name'),'conditions'=>array('Recipient.id'=>$patient_id)));
		$this->set('recipients',$recipients);
		$name=$this->Patient->find('all',array('fields'=>array('id','lookup_name'),'conditions'=>array('Patient.id'=>$patient_id)));
		
		$this->set('name',$name);
		$this->set('id',$id);
		$this->set('patient_id',$patient_id);
		$this->set('userid',$userid);
		
		$this->render('referral_pdf','pdf');
		$this->redirect(array("controller" => "recipients", "action" => "referral_preview_action",$id,$patient_id));
		
		
	}
	
	
	public function download_fax($id,$patient_id){
		
		
		$userid = $this->Session->read('userid') ;
		
		$this->layout = false ;
		$this->uses = array('Note','NewCropPrescription','NoteDiagnosis','Recipient');
		$vitals=$this->Note->find('first',array('fields'=>array('id','ht','wt','bmi','bp','temp'),'conditions'=>array('Note.patient_id'=>$patient_id),'group'=>'Note.patient_id desc'));
		
		$this->set('vitals',$vitals);
		$medication=$this->NewCropPrescription->find('all',array('fields'=>array('description','date_of_prescription','end_date'),'conditions'=>array('NewCropPrescription.patient_uniqueid'=>$patient_id)));
		
		$this->set('medication',$medication);
		$diagnosis=$this->NoteDiagnosis->find('all',array('fields'=>array('diagnoses_name','start_dt','end_dt'),'conditions'=>array('NoteDiagnosis.patient_id'=>$patient_id)));
	
		$this->set('diagnosis',$diagnosis);
		
		$this->set('patient_id',$patient_id);
		$this->set('id',$id);
		$this->set('userid',$userid);
		
		$recipients=$this->Recipient->find('first',array('fields'=>array('id','name'),'conditions'=>array('Recipient.id'=>$id)));
		$this->set('recipients',$recipients);
		
		
	}
	
	public function send_fax($id){
		
		$this->uses = array('Recipient');
		$result = $this->Recipient->find('first',array('conditions'=>array('Recipient.id'=>$id),'order'=>array('id desc')));
		$fax = $result['Recipient']['report_name'] ;
		//$fax= "Fax.pdf";
		// echo FULL_BASE_URL.Router::url("/")."/files/fax_referral/"	;
		
		/**************** Settings begin **************/
		
		
		$faxnumber = '+917122549850'; // Enter your designated fax number here in the format +[country code][area code][fax number], for example: +12125554874
		
		
		
		$filename  = Configure::read('generated_fax_path').$fax; //'test.pdf'; //
		$filetype  = 'PDF';// If $texttofax is regular text, enter TXT here. If $texttofax is HTML enter HTML here
		//echo $filename;
		/**************** Settings end ****************/
		
		if( !($fp = fopen($filename, "r"))){
			// Error opening file
			echo "Error opening file";
			exit;
		}
		
		// Read data from the file into $data
		$data = "";
		while (!feof($fp)) $data .= fread($fp,1024);
		fclose($fp);
		
		
		
		$client = new SoapClient("http://ws.interfax.net/dfs.asmx?WSDL");
		
		$params->Username  = Configure::read('fax_username') ;
		$params->Password  = Configure::read('fax_password') ;;
		$params->FaxNumber = $faxnumber;
		$params->FileData  = $data;
		$params->FileType  = $filetype;
		
		
		
		$result = $client->Sendfax($params);
		
		echo $result->SendfaxResult;
		
		$this->Session->setFlash(__('Fax has been send successfully'),'default',array('class'=>'message'));
			$this->redirect(array("controller" => "recipients", "action" => "referral_preview_action",$id));
		
		
		
		
	}
	
function search($patient_id) {
	
	$this->patient_info($patient_id);
	$this->uses = array('Recipient');
	
    $keyword = $this->request->data;
    $keyword = $keyword["Recipient"]["keyword"];
    $cond = array("OR" => array(
        "Recipient.name LIKE '%$keyword%'",
        "Recipient.last_name LIKE '%$keyword%'"
    ));
    $posts = $this->Recipient->find("all", array("conditions" => $cond));
   
    $this->set('posts',$posts);
    $posts = $this->paginate();
    
}
public function getdeviceused(){
	$this->uses = array('Recipient');
	$data = $this->Recipient->find('list',array('fields'=> array("name","name")));

	$output ="";
	foreach ($data as $key=>$value) {
		$output .=$value."|".$key."\n";
	}
	echo $output;

	exit;
}
public function printLetter($patient_id=null){
	$this->layout=false;

	if(!empty($this->request->data) && isset($this->request->data)){
		$id=$this->request->data['Recipient']['patient_id'];

		$totalDataToSend=$this->request->data['Recipient']['head'].'<p>'.$this->request->data['Recipient']['body'].$this->request->data['Recipient']['tail'].$this->request->data['Recipient']['Sincerely'].'<style>
.classTr{
background-color:#CCCCCC;
}
.classTd{
color:red;
}
</style>';
		$myFileName = "files/referal_letter/".referal."_".myfile."_".$id.".html";
		
		$myFileHandle = fopen($myFileName, 'w') or die("can't open file");
		fwrite($myFileHandle, $totalDataToSend);
		fclose($myFileHandle);
		
		
	}
	else{
	
		$this->set('patient_id',$patient_id);
	}
	
	
}
	
	
	}


