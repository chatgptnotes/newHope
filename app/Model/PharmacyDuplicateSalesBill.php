<?php
class PharmacyDuplicateSalesBill extends AppModel {
	public $patient ;
	public $name = 'PharmacyDuplicateSalesBill';
	public $hasMany = array(
		'PharmacyDuplicateSalesBillDetail' => array(
		'className' => 'PharmacyDuplicateSalesBillDetail',
		'dependent' => true,
		'foreignKey' => 'pharmacy_duplicate_sales_bill_id',
		),
	 
	); 
   public $belongsTo = array(
		'Patient' => array(
		'className' => 'Patient',
		'foreignKey' => 'patient_id',
		'dependent'=> true
		),
		'Doctor' => array(
		'className' => 'Doctor',
		'foreignKey' => 'doctor_id',
		'dependent'=> true
		),
		'Initial' =>array('foreignKey'=>false,"conditions"=>array("Initial.id = Doctor.initial_id")),
		
		); 
	public function generateRandomBillNo(){
		$characters = array(
		"A","B","C","D","E","F","G","H","J","K","L","M",
		"N","P","Q","R","S","T","U","V","W","X","Y","Z",
		"1","2","3","4","5","6","7","8","9");		
		$keys = array();
		$random_chars ='';		
		while(count($keys) < 7) {			
			$x = mt_rand(0, count($characters)-1);
			if(!in_array($x, $keys)) {
			   $keys[] = $x;
			}
		}		
		foreach($keys as $key){
		   $random_chars .= $characters[$key];
		}
		return $random_chars;	
	}

	public $specific = true;
	function __construct($id = false, $table = null, $ds = null) {
		if(empty($ds)){
			$session = new cakeSession();
			$this->db_name =  $session->read('db_name');
		}else{
			$this->db_name =  $ds;
		}
		parent::__construct($id, $table, $ds);
	}
	
	public function patientDuplicateBillDetail($patientId){
		$patient = Classregistry::init('Patient');
		$pharmacyItem = Classregistry::init('PharmacyItem');
		$patientInitial = Classregistry::init('PatientInitial');
		$salebillDetail = Classregistry::init('PharmacyDuplicateSalesBillDetail');
		$session = new cakeSession();
		
		$saleDetail = $salebillDetail->find('all',array(
											'conditions'=>array("PharmacyDuplicateSalesBill.location_id" =>$session->read('locationid'),
																'PharmacyDuplicateSalesBill.is_deleted' =>'0','PharmacyDuplicateSalesBill.patient_id'=>$patientId),
											'fields'=>array('PharmacyDuplicateSalesBill.*','PharmacyDuplicateSalesBillDetail.*','PharmacyItem.id','PharmacyItem.name','PharmacyItem.generic'))); 
		
		return $saleDetail;
	}
	
	public function generateSalesBillNo(){		//by swapnil
		$getBillCount = $this->find('count'); 
		return "SB-".str_pad($getBillCount, 4, '0', STR_PAD_LEFT);	
	}
	
        //function to get the total amount of only is_bill rows
	public function getTotalAmount($patientId){ 
            $total = 0;		
            $this->belongsTo = array();
            $this->hasMany = array();
            $total = $this->find('first',array('fields'=>array('SUM(total) as total'),'conditions'=>array('patient_id'=>$patientId,'add_charges_in_invoice'=>'1','is_deleted'=>'0')));
            return $total[0]['total'];
	}
	
        public function getPharmacyTotal($patient_id){
            $pharmacyFinalResult = $this->find('first',array(
                            'fields'=>array('SUM(PharmacyDuplicateSalesBill.total) as total',/*'SUM(PharmacyDuplicateSalesBill.paid_amnt) as paid_amount',*/
                            'SUM(PharmacyDuplicateSalesBill.discount) as discount'),
                            'conditions'=>array('PharmacyDuplicateSalesBill.patient_id'=>$patient_id,
                                            'PharmacyDuplicateSalesBill.is_deleted'=>'0'))); 

            return $pharmacyFinalResult ;
        }
		
}
?>