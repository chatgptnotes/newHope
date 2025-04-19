
<?php  

class NavigationHelper extends AppHelper {
	public $helpers = array('Html',"Session");

	//$this->Session->write('facilityu',$facility['Facility']['usertype']);


	public static $icon = array(
			//"OptAppointments"=>array("action"=>array('otevent'=>array("icon"=>"appointment.png",'text'=>'OT Appointments')),"is_master"=>'false'),
			"NewOptAppointments"=>array("action"=>array("otevent"=>array('icon'=>'ot-medical-replacement-slip.png',"text"=>"OT Appointments"),
					"dashboard_index"=>array('icon'=>'operation_theater.png',"text"=>"OR")),"is_master"=>'false'),
			
			"DoctorSchedules"=>array("action"=>array('doctor_event'=>array("icon"=>"appointment.png",'text'=>'Scheduling')),"is_master"=>'false'),
			"Appointments"=>array("action"=>array('getDoctorDetails'=>array('icon'=>'doctorAppointment.png',"text"=>"My Appointments"),
					'appointments_management'=>array('icon'=>'front_desk.png',"text"=>"OPD Dashboard"),
					),"is_master"=>'false'),
			
			"Reports"=>array("action"=>array("all_report"=>array('icon'=>'report.png',"text"=>"Reports",'prefix'=>'admin'),
					                         "kanpur_reports"=>array('icon'=>'template_category.png',"text"=>"Kanpur Reports",'prefix'=>'admin'),
					/*"clinical_quality_measure"=>array('icon'=>'quality_monitor.png',"text"=>"CQM" ,'prefix'=>'admin')*/)
					,"is_master"=>'false'),
					
				// 				"Appointments" => array(
				// 				"action" => array(
				// 					"uniqueqr_list" => array(
				// 						'icon' => 'billing.jpg',
				// 						"text" => "Unique QR List"
				// 					),
				// 					"referal_doctor" => array(
				// 						'icon' => 'lab_manager.png',
				// 						"text" => "Doctor Overview Station"
				// 					)
				// 				),
				// 				"is_master" => 'false'
				// 			),
				// 			"Persons" => array(
				// 				"action" => array(
				// 					"patient_overview" => array(
				// 						'icon' => 'Permission.png',
				// 						"text" => "Patient Overview Station"
				// 					)
				// 				),
				// 				"is_master" => 'false'
				// 			),		
					//Commented out-patient by Gulshan
					//"OutPatients"=>array("action"=>array("index"=>array('icon'=>'out-patient.jpg',"text"=>"Reg.")),"is_master"=>'false'),
					"Inpatients"=>array("action"=>array("frondesk_ipd_patient"=>array('icon'=>'in-patient.png',"text"=>"Inpatient",'param'=>'?type=ipd')),"is_master"=>'false'),
					"Er"=>array("action"=>array( "frondesk_emergency_patient"=>array('icon'=>'emergency.png',"text"=>"ER",'param'=>'?type=emergency')),"is_master"=>'false'),
					"Users"=>array("action"=>array('menu'=>array('icon'=>'master.png',"text"=>"Masters",'prefix'=>'admin','param'=>'?type=master'),
					'staffAuthentication'=>array('icon'=>'Permission.png','text'=>'Staff Authentication','param'=>'?1'),
					'doctor_dashboard'=>array('icon'=>'ipd_dash.png',"text"=>"IPD Dashboard"),
					/*'index'=>array('icon'=>'user.png',"text"=>"Users","prefix"=>"admin"),*/'index'=>array('icon'=>'user.png',"text"=>"New Users","prefix"=>"admin",'param'=>'?newUser=ls')),"is_master"=>'false'),

					"Wards"=>array("action"=>array("ward_occupancy"=>array('icon'=>'room.png',"text"=>"Room Mgmt"),
					'mmis'=>array('icon'=>'radiology-manager.jpg',"text"=>"MMIS Support")),"is_master"=>'false'),

					"Doctors"=>array("action"=>array(/*"clinicalsuport"=>array('icon'=>'CDS.png',"text"=>"CDS"),*/
					/* "index"=>array(/*'icon'=>'doctor.jpg',"text"=>"Providers List")*/),"is_master"=>'false'),
					"StaffPlans"=>array("action"=>array("staffplan"=>array('icon'=>'staff_plan.png',"text"=>"Staff Plan")),"is_master"=>'false'),
					"Surveys"=>array("action"=>array("staff_surveys"=>array('icon'=>'survey.png',"text"=>"Survey")),"is_master"=>'false'),

					"Pharmacy"=>array("action"=>array('index'=>array('icon'=>'pharmcy.png',"text"=>"Pharmacy",'prefix'=>'inventory')),"is_master"=>'false'),
					"Store"=>array("action"=>array('department_store'=>array('icon'=>'store_icon.png',"text"=>"Central Store")),"is_master"=>'false'),
					 
					
					"OtPharmacy"=>array("action"=>array("sales_bill"=>array('icon'=>'telemedicine.jpg',"text"=>"OT Pharmacy")),"is_master"=>'false'),
					
					//"OptAppointments"=>array("action"=>array("dashboard_index"=>array('icon'=>'operation_theater.png',"text"=>"OR")),"is_master"=>'false'),
					"Nursings"=>array("action"=>array("search"=>array('icon'=>'nursing.png',"text"=>"Nursing"),
					"quality_monitor"=>array('icon'=>'quality_monitor.png',"text"=>"Qlty Monitor")),"is_master"=>'false'),

					"Laundries"=>array("action"=>array("manager"=>array('icon'=>'house-keeping.png',"text"=>"House Keeping",'prefix'=>'inventory')),"is_master"=>'false'),

					"Mmis"=>array("action"=>array('Mmis'=>array('icon'=>'mmis.png',"text"=>"MMIS",'prefix'=>'mmis','plugin'=>true)),"is_master"=>'false'),

					//"Laboratories"=>array("action"=>array('labDashBoard'=>array('icon'=>'lab_manager.png',"text"=>"Lab Manager"),),"is_master"=>'false'),
					"NewLaboratories"=>array("action"=>array('index'=>array('icon'=>'lab_manager.png',"text"=>"Lab Manager" ,'param'=>'?type=null'),),"is_master"=>'false'),

					"Radiologies"=>array("action"=>array('radDashBoard'=>array('icon'=>'Rad_manager.png',"text"=>"Rad. Manager")),"is_master"=>'false'),

					"EKG"=>array("action"=>array('index'=>array('icon'=>'cardiologe_manager.png',"text"=>"EKG")),"is_master"=>'false'),

					"Messages"=>array("action"=>array('index'=>array('icon'=>'mailbox.png',"text"=>"Mailbox"),
														"hopeTwoSms"=>array('icon'=>'hope2sms.png',"text"=>"Hope2Sms")),"is_master"=>'false'),
					
					"AuditLogs"=>array("action"=>array('audit_logs'=>array('icon'=>'audit_log.png',"text"=>"Audit Log","prefix"=>"admin")),"is_master"=>'false'),

					"MeaningfulReport"=>array("action"=>array('all_report'=>array('icon'=>'mu.png',"text"=>"MU Report","prefix"=>"admin")),"is_master"=>'false'),

					"Innovations"=>array("action"=>array('web_chat'=>array('icon'=>'radiology-manager.jpg',"text"=>"Patient Support")),"is_master"=>'false'),
					
					"Billings"=>array("action"=>array("patientSearch"=>array('icon'=>'invoice.png',"text"=>"Invoice"),
					"patientEligibilityCheck"=>array('icon'=>'/patient_hub/billingsummary_1.PNG',"text"=>"P E Check")),"is_master"=>'false'),

					"Departments"=>array("action"=>array("dashboard"=>array('icon'=>'dashboard.jpg',"text"=>"Dashboard")),"is_master"=>'false'),
					"Preferences"=>array("action"=>array("index"=>array('icon'=>'preferences.jpg',"text"=>"Preferences",'prefix'=>'admin')),"is_master"=>'false'),
					"InventoryCategories"=>array("action"=>array("store_requisition_list"=>array('icon'=>'Permission.png',"text"=>"Store Requi")),"is_master"=>'false'),

					"Estimates"=>array("action"=>array(/*"index"*/"residentDashboard"=>array('icon'=>'Estimate.png',"text"=>"Estimate")),"is_master"=>'false'),
					"Opts"=>array("action"=>array("medical_requisition_list"=>array('icon'=>'Medical_Item.png',"text"=>"Medi Requi")),"is_master"=>'false'),
					"Permissions"=>array("action"=>array("index"=>array('icon'=>'Permission.png',"text"=>"Permission",'prefix'=>'admin')),"is_master"=>'false'),
					"TimeSlots"=>array("action"=>array("index"=>array('icon'=>'mailbox.png',"text"=>/* "Staff Avail" */"Duty Roster")),"is_master"=>'false'),						
					"Chambers"=>array("action"=>array("chamber_scheduling"=>array('icon'=>'doctor-chamber-allocation.jpg',"text"=>"Blocked Time")),"is_master"=>'false'),
					"Samples"=>array("action"=>array("meaningful_dashboard"=>array('icon'=>'new_patient.png',"text"=>"Meaningful Dashboard")),"is_master"=>'false'),
					//"Ccda"=>array("action"=>array('search'=>array('icon'=>'ccda.jpg',"text"=>"CCDA"),),"is_master"=>'false'),

					//"PatientAccess"=>array("action"=>array("contact_lenses_index"=>array('icon'=>'contact_lenses.png',"text"=>"Contact Lenses"),"order_eyeglasses"=>array('icon'=>'order_eyeglasses.png',"text"=>"Order Eyeglasses"),"medical_records"=>array('icon'=>'medical_records.png',"text"=>"Med Records"),"pay_bills"=>array('icon'=>'pay_bills.png',"text"=>"Pay Bills"),"prescription"=>array('icon'=>'prescription.png',"text"=>"Prescription")),"is_master"=>'false' ),
					"Complaints"=>array("action"=>array("index"=>array('icon'=>'complaints.jpg',"text"=>"Complaints")),"is_master"=>'false'),
					//	"Accounting"=>array("action"=>array("kpiDashboard"=>array('icon'=>'kpi_dashboard.png',"text"=>"KPI Dash"),"index"=>array('icon'=>'kpi_dashboard.png',"text"=>"Accounting")),"is_master"=>'false'),
					"Insurances"=>array("action"=>array("claimSubmissionDashBoard"=>array('icon'=>'medical_insurancejj.png',"text"=>"Claim DashBoard")),"is_master"=>'false'),
					
					"Accounting"=>array("action"=>array("kpiDashboard"=>array('icon'=>'kpi_dashboard.PNG',"text"=>"KPI Dash"),
					  "index"=>array('icon'=>'accounting_class_icon.png',"text"=>"Accounting"),"patient_card_list"=>array('icon'=>'billing.jpg',"text"=>"Billing")),"is_master"=>'false'),
					
					"Consultants"=>array("action"=>array("index"=>array('icon'=>'referral_doctor.png',"text"=>"Referral Doctor",'prefix'=>'admin')),"is_master"=>'false'),
								
					
					"Patients"=>array("action"=>array(
					"new_patient_hub"=>array('icon'=>'new_hub.png',"text"=>"Patient Hub"),
					/*"payment"=>array('icon'=>'billing.jpg',"text"=>"Payment"),*/
					//Registration commented by gulshan
					//"add"=>array('icon'=>'register.jpg',"text"=>"Registration",'param'=>'?type=OPD'),
					//"search"=>array('icon'=>'Patient-Enquiry.jpg',"text"=>"Find Patient",'param'=>'?type=OPD'),
					/*"sendToPatientBdayWish"=>array('icon'=>'bdayRemainder.png',"text"=>"Birth Day Remainder",'class'=>'bday_remainder')*/),"is_master"=>'false'),
					"PatientDocuments"=>array("action"=>array("radiologistDashboard"=>array('icon'=>'radiology_dashboard.png',"text"=>"Radiologist Dashboard")),"is_master"=>'false'),

					"Persons"=>array("action"=>array("searchPerson"=>array('icon'=>'new_patient.png',"text"=>"New Visit"),
					"searchPatient"=>array('icon'=>'search_patient.png',"text"=>"Search Patient")),"is_master"=>'false'),

					"Billings" => array("action"=>array("discount_requests"=>array('icon'=>'billing.jpg',"text"=>"Approve Request"),
					"discount_requests"=>array('icon'=>'billing.jpg',"text"=>"Approve Request"),
					"getAllCashierTransactions"=>array('icon'=>'cashbook.png',"text"=>"Cash Book"),"advanced_billing"=>array('icon'=>'advance_statement.png',"text"=>"Advance Statement")),"is_master"=>'false'),
					
					"Corporates" => array("action"=>array("lifespring_reports"=>array('icon'=>'template_category.png',"text"=>"LifeSpring Reports",'prefix'=>'admin'),
					/* "kanpur_reports"=>array('icon'=>'template_category.png',"text"=>"Kanpur Reports",'prefix'=>'admin')*/
					),"is_master"=>'false'),
					
					"Misc" => array("action"=>array("index"=>array('icon'=>'group_creation.PNG',"text"=>"Miscellaneous")
					),"is_master"=>'false'),
					"Estimates"=>array("action"=>array("couponBatchGeneration"=>array('icon'=>'recipts.png',"text"=>"Coupon Master")),"is_master"=>'false'),
					// echo $this->Html->link($this->Html->image('icons/referral_doctor.png', array('alt' => 'Referral Doctor', 'title'=> 'Referral Doctor')),array("controller" => "consultants", "action" => "index", "admin" => true, "superadmin" => false,'plugin' => false), array('escape' => false,'label'=>'Referral Doctor'));

					"PatientDocuments"=>array("action"=>array("radiologistDashboard"=>array('icon'=>'radiology_dashboard.png',"text"=>"External Radiologist Dashboard"),
					"all_dashboard"=>array('icon'=>'dashboard.jpg',"text"=>"All Dashboards",'param'=>'?type=slideone')),"is_master"=>'false'),
	);

	public static $icon1 = array(

			"Persons"=>array("action"=>array("add_ambi"=>array('icon'=>'new_patient.png',"text"=>"New Patient1")),"is_master"=>'false'),
			//Commented out-patient by Gulshan
			//"Users"=>array("action"=>array("frondesk_patient1"=>array('icon'=>'out-patient.jpg',"text"=>"Ambulatory",'param'=>'?type=opd'),'menu'=>array('icon'=>'master.png',"text"=>"Masters",'prefix'=>'admin','param'=>'?type=master')),"is_master"=>'false'),

			"Messages"=>array("action"=>array('index'=>array('icon'=>'radiology-manager.jpg',"text"=>"Message"),"getAllData"=>array('icon'=>'billing.jpg',"text"=>"Message Data")),"is_master"=>'false'),
			"Nursings"=>array("action"=>array("search"=>array('icon'=>'nursing.png',"text"=>"Nursing")),"is_master"=>'false'),
			"Laboratories"=>array("action"=>array('index'=>array('icon'=>'lab_manager.png',"text"=>"Lab Manager")),"is_master"=>'false'),
			"Radiologies"=>array("action"=>array('index'=>array('icon'=>'rad_manager.png',"text"=>"Radiology Manarge")),"is_master"=>'false'),
			//"Consultants"=>array("action"=>array("index"=>array('icon'=>'consultant.jpg',"text"=>"Ref. Dr")),"is_master"=>'false'),
			"Reports"=>array("action"=>array("patient_list"=>array('icon'=>'report.png',"text"=>"Patient List Creation",'prefix'=>'admin')),"is_master"=>'false'),
			"Preferences"=>array("action"=>array("index"=>array('icon'=>'preferences.jpg',"text"=>"Preferences",'prefix'=>'admin')),"is_master"=>'false'),
			"Chambers"=>array("action"=>array("chamber_scheduling"=>array('icon'=>'doctor-chamber-allocation.jpg',"text"=>"Doctor Chamber")),"is_master"=>'false'),
			"Samples"=>array("action"=>array("meaningful_dashboard"=>array('icon'=>'new_patient.png',"text"=>"Meaningful Dashboard")),"is_master"=>'false'),
			//"Ccda"=>array("action"=>array('search'=>array('icon'=>'ccda.png',"text"=>"CCDA")),"is_master"=>'false'),
		// echo $this->Html->link($this->Html->image('/img/icons/recipts.png', array('alt' => ('Coupon Master'),'title' => __('Coupon Master'))),array("controller"=>"Estimates","action"=>'couponBatchGeneration',"admin" => false,'plugin' => false), array('escape' => false,'label'=>'Coupon Master'));
	    //  "Estimates"=>array("action"=>array("couponBatchGeneration"=>array('icon'=>'recipts.png',"text"=>"Coupon Master")),"is_master"=>'false'),
	

	);

	public static $patient = array(
			"Ccda"=>array("action"=>array('downloadXml'=>array('icon'=>'download_ccda.png',"text"=>"Download CCDA"),
					'view_consolidate'=>array('icon'=>'ccda.png',"text"=>"View CCDA")),"is_master"=>'false'),
			"PatientAccess"=>array("action"=>array("portal_home"=>array('icon'=>'patient_portal.png',"text"=>"ViewMyEHR"),
					"refillRx"=>array('icon'=>'prescription.png',"text"=>"Refill Rx")),"is_master"=>'false'),
	);


	public function  getMenu($displayLoc=null){
			
		$count = 1;
		$flag = false;
		$output='';
		$usertype=$this->Session->read('facilityu',$facility['Facility']['usertype']);
		$role = $this->Session->read('role'); //debug($role);
		//$output .= '<div class="tab_dept"><span style="padding-top:10px;text-align:center;font-size:19px;">'.__('System Centric Department',true).'</span>';
		$modulePermissions = $this->Session->read('module_permissions') ; 
		$linkedModules = unserialize($this->Session->read('linked_modules')); //debug($linkedModules);
		$landing_linked_module = unserialize($this->Session->read('landing_linked_module'));
		$linkedModulesSorting = unserialize($this->Session->read('linked_modules_sorting'));
		// $submenuConfig = array('Messages','Payment');
		if(count($this->Html->menu)>0){

			if($usertype=='hospital' || $usertype==''){
				foreach(NavigationHelper::$icon  as $k => $val){
						
					if(isset($this->Html->menu[$k]) && $val['is_master']=="false"){
						
						//if($val['action'] && in_array($k,$modulePermissions) && in_array($k,$submenuConfig)){
						$keyArray  = array_keys($val['action']) ;
						//by gulshan

						if($displayLoc=='box'){
							if($val['action'] && in_array($k,$landing_linked_module)){
									
								$firstRow = array(/*'Patient Search',*/'Ambulatory','Inpatient','ER','Masters');
									
								foreach( $val['action'] as $key=>$value){
									
									/** Removing kanpur_reports for other instances*/ 
									if($key == 'kanpur_reports' && $this->Session->read('website.instance') != 'kanpur')
										continue;

									/* if($key == 'getDoctorDetails' && strtolower($role)!= strtolower(Configure::read('patientLabel')) || ($this->params->action == $key)){
									 echo $this->params->action ;
									continue ;
									} */
									if($key == 'getDoctorDetails' && strtolower($role)!= strtolower(Configure::read('patientLabel')) ||
											($this->params->action == $key && $this->params->controller==$k)){ //compare current action and current controller
										continue ;
									}
									//foreach( $value as $actionkey=>$actionvalue){
									$key = preg_replace('/[^a-z_]/i', '', $key);
									if(isset($value['prefix'])){
										$checkUrl = $value['prefix']."_".$key;
									}
									else{
										$checkUrl = $key;
									}

									//apply cross check of hospital permissions
									if(in_array($checkUrl,$this->Html->menu[$k])){
											
										$output1= '' ;
										if(isset($value['param']))
											$key = $key.$value['param'];
										$output1 .='<div class="box_row_modules">';
										$path = array("controller" => $k, "action" => $key);
											
										if(isset($value['prefix'])){
											$path[$value['prefix']]=true;
										}
										else{
											$path['admin']=false;
											$path['acl']=false;
											$path['inventory']=false;
										}
										$url =  Router::url($path);
											
										$url = preg_replace('/acl\b\//', '', $url);
											
										$output1 .= '<a href="'.$url.'">';
										if($value['text'] == 'New Department') $value['text'] = $this->Session->read('department').' Store';
										$output1 .=$this->Html->image('/img/icons/'.$value['icon'], array('alt' =>$value['text'],'title'=>$value['text'],'class'=>$value['class']));
										$output1 .= '</a>';
										$output1 .= '<p>'.$value['text'].'</p>';
										$output1 .='</div>';
										$count = $count +1;
											
										//By pankaj
										/* if(in_array($value['text'],$firstRow)){
										 $sorting1[trim($value['text'])] = $output1;
										}else{
										$sorting[trim($value['text'])] = $output1;
										}*/
											
										/* $sortKey = array_search($k, $linkedModulesSorting); //sort array key value pair ('1'=>'User')
										 if($sortKey=='0'){
										$sorting1[trim($value['text'])] = $output1;
										}else{
										$sorting[$sortKey] = $output1;
										} */

										$sorting[] = $output1;
									}
								}
							}
						}else if($displayLoc=='top'){
							if($val['action'] && in_array($k,$linkedModules) ){
								$firstRow = array(/*'Patient Search',*/'Ambulatory','Inpatient','ER','Masters');
									
								foreach( $val['action'] as $key=>$value){
									/** Removing kanpur_reports for other instances*/ 
									if($key == 'kanpur_reports' && $this->Session->read('website.instance') != 'kanpur')
										continue;
									/* if($key == 'getDoctorDetails' && strtolower($role)!= strtolower(Configure::read('patientLabel')) || ($this->params->action == $key)){
									 echo $this->params->action ;
									continue ;
									} */
									if($key == 'getDoctorDetails' && strtolower($role)!= strtolower(Configure::read('patientLabel')) ||
											($this->params->action == $key && $this->params->controller==$k)){ //compare current action and current controller
										continue ;
									}
									//foreach( $value as $actionkey=>$actionvalue){
									$key = preg_replace('/[^a-z_]/i', '', $key);
									if(isset($value['prefix'])){
										$checkUrl = $value['prefix']."_".$key;
									}
									else{
										$checkUrl = $key;
									}

									//apply cross check of hospital permissions
									if(in_array($checkUrl,$this->Html->menu[$k])){
											
										$output1= '' ;
										if(isset($value['param']))
											$key = $key.$value['param'];
										$output1 .='<div class="row_modules">';
										$path = array("controller" => $k, "action" => $key);
											
										if(isset($value['prefix'])){
											$path[$value['prefix']]=true;
										}
										else{
											$path['admin']=false;
											$path['acl']=false;
											$path['inventory']=false;
										}
										$url =  Router::url($path);
											
										$url = preg_replace('/acl\b\//', '', $url);
											
										$output1 .= '<a href="'.$url.'">';
										if($value['text'] == 'New Department') $value['text'] = $this->Session->read('department').' Store';
										$output1 .=$this->Html->image('/img/icons/'.$value['icon'], array('alt' =>$value['text'],'title'=>$value['text'],'class'=>$value['class']));
										$output1 .= '</a>';
										$output1 .= '<p>'.$value['text'].'</p>';
										$output1 .='</div>';
										$count = $count +1;
											
										//By pankaj
										/* if(in_array($value['text'],$firstRow)){
										 $sorting1[trim($value['text'])] = $output1;
										}else{
										$sorting[trim($value['text'])] = $output1;
										}*/
											
										$sortKey = array_search($k, $linkedModulesSorting); //sort array key value pair ('1'=>'User')
										if($sortKey=='0'){
											$sorting1[trim($value['text'])] = $output1;
										}else{
											$sortingTop[][$sortKey] = $output1;
										}
									}
								}
							}
						}
					}
				}
				$patientIcon = array();
				//For patients portal icons
				foreach(NavigationHelper::$patient  as $k => $val){
					if(isset($this->Html->menu[$k]) && $val['is_master']=="false"){
						if($displayLoc=='box'){
							if($val['action']  && in_array($k,$landing_linked_module) ){
								foreach( $val['action'] as $key=>$value){
									if($key == 'getDoctorDetails' || strtolower($role)!= strtolower(Configure::read('patientLabel'))){
										continue ;
									}
									$key = preg_replace('/[^a-z_]/i', '', $key);
									if(isset($value['prefix'])){
										$checkUrl = $value['prefix']."_".$key;
									}
									else{
										$checkUrl = $key;
									}
									//apply cross check of hospital permissions
									if(in_array($checkUrl,$this->Html->menu[$k])){
										$output1= '' ;
										if(isset($value['param']))
											$key = $key.$value['param'];
										$output1 .='<div class="box_row_modules">';
										$path = array("controller" => $k, "action" => $key);
											
										if(isset($value['prefix'])){
											$path[$value['prefix']]=true;
										} else{
											$path['admin']=false;
											$path['acl']=false;
											$path['inventory']=false;
										}
										$url =  Router::url($path);
										$url = preg_replace('/acl\b\//', '', $url);
										$output1 .= '<a href="'.$url.'">';
										$output1 .=$this->Html->image('/img/icons/'.$value['icon'], array('alt' =>$value['text'],'title'=>$value['text']));
										$output1 .= '</a>';
										$output1 .= '<p>'.$value['text'].'</p>';
										$output1 .='</div>';
										$count = $count +1;
										$patientIcon1[trim($value['text'])] = $output1;
									}
								}
							}
						}else if($displayLoc=='top'){
							if($val['action'] && in_array($k,$linkedModules) ){
								foreach( $val['action'] as $key=>$value){
									if($key == 'getDoctorDetails' || strtolower($role)!= strtolower(Configure::read('patientLabel'))){
										continue ;
									}
									$key = preg_replace('/[^a-z_]/i', '', $key);
									if(isset($value['prefix'])){
										$checkUrl = $value['prefix']."_".$key;
									}
									else{
										$checkUrl = $key;
									}
									//apply cross check of hospital permissions
									if(in_array($checkUrl,$this->Html->menu[$k])){
										$output1= '' ;
										if(isset($value['param']))
											$key = $key.$value['param'];
										$output1 .='<div class="row_modules">';
										$path = array("controller" => $k, "action" => $key);
											
										if(isset($value['prefix'])){
											$path[$value['prefix']]=true;
										} else{
											$path['admin']=false;
											$path['acl']=false;
											$path['inventory']=false;
										}
										$url =  Router::url($path);
										$url = preg_replace('/acl\b\//', '', $url);
										$output1 .= '<a href="'.$url.'">';
										$output1 .=$this->Html->image('/img/icons/'.$value['icon'], array('alt' =>$value['text'],'title'=>$value['text']));
										$output1 .= '</a>';
										$output1 .= '<p>'.$value['text'].'</p>';
										$output1 .='</div>';
										$count = $count +1;
										$sortKey = array_search($k, $linkedModulesSorting); //sort array key value pair ('1'=>'User')
										if($sortKey=='0'){
											$patientIcon1[trim($value['text'])] = $output1;
										}else{
											$patientIcon[$sortKey] = $output1;
										}
									}
								}
							}
						}
					}
				}
				//EOF patient portal icons

				//pr($sortingTop);
				$sort = 0 ;
				foreach($sortingTop as $keyTop => $valueTop ){
					foreach($valueTop as $subKey=>$subValue){
						$revisedArray[$subKey][] = $subValue;
					}
				}
				ksort($revisedArray);
				foreach($revisedArray as $revisedKey => $revisedVal){
					$output .= implode("",$revisedVal);
				}

					
				//for top row
				ksort($sorting) ; //please dont remove.
				$output .= implode("",$sorting);
				$output .= implode("",$sorting1);
				//for patient portal
				$output .= implode("",$patientIcon);
				$output .= implode("",$patientIcon1);
				//EOF patient portal
				//	$output .= '</div>';
			}else{
				$output .= '<div style="padding:20px;">Permission not granted for any module for System Centric Department. </div>';
			}
			//	$output .= '</div>';
			if($displayLoc=='box'){
				//home
				$home .=  '<div class="box_row_modules" style="height:45px">';
				$home .=  $this->Html->link(__($this->Html->image('/img/icons/ghar.png',array('alt' => 'Home Screen','title' => 'Home Screen'))),"/",array('escape'=>false));
				$home .= '</div>';
				echo $home ;
			}else{
				//home
				$home .=  '<div class="row_modules" style="height:45px">';
				$home .=  $this->Html->link(__($this->Html->image('/img/icons/ghar.png',array('alt' => 'Home Screen','title' => 'Home Screen'))),"/",array('escape'=>false));
				$home .= '</div>';
				echo $home ;
			}
			//EOF home
			echo ($output);
		}
	}
}
