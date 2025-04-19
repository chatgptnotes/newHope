<?php echo $this->Html->script('jquery.fancybox-1.3.4','jquery.tooltipster.min.js');
	echo $this->Html->css('jquery.fancybox-1.3.4.css','tooltipster.css');
    $website = $this->Session->read('website.instance');
?>
<?php if(!empty($this->params->query['print'])){?>
<html moznomarginboxes mozdisallowselectionprint>
<?php }?>
<style>
.textAlign {
	text-align: left;
	font-size: 12px;
	padding-right: 0px;
	padding-left: 0px;
}

.td_ht {
	line-height: 18px;
	
}
.table_format1 td {
padding-bottom: 3px;
padding-right: 10px;
/* font-size: 13px; */
}

.vitalImage {
  background:url("<?php echo $this->webroot ?>img/icons/vital_icon.png") no-repeat center 2px;  
  cursor: pointer;
}
.maleImage {
  background:url("<?php echo $this->webroot ?>img/icons/male.png") no-repeat center 2px;  
  cursor: pointer;
}
.femaleImage {
  background:url("<?php echo $this->webroot ?>img/icons/female.png") no-repeat center 2px;  
  cursor: pointer;
}
select {
	/* background: none repeat scroll 0 0 #121212; */
	border: 0.100em solid;
	border-radius: 25px;
	border-color: olive;
	color: #E7EEEF;
	font-size: 13px;
	outline: medium none;
	padding: 5px 7px;
	resize: none;
}
.light:hover {
background-color: #F7F6D9;
/* text-decoration:none;
color: #000000; */
}

.discharge_red{
		background-color: pink ;
}



</style>

<script>
<?php if($this->params->pass['0']=='print'){?>
window.print();
<?php }?>
	</script>
<?php if($this->Session->read('website.instance')=='hope'){?>
<span style="float: right"><?php 
echo $this->Html->link('Print','#',
					array('style'=>'','class'=>'blueBtn','id'=>'print','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'dashboard_patient_list',
					'print','?'=>$qtStr))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?>
		</span>
<?php }//list of patients
$role = $this->Session->read('role');
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	class="table_format1 textAlign">
	<tr style="text-align: center;">
		<td colspan="14">
			<!-- Shows the next and previous links --> <?php 

			if(empty($this->request->data['User']['All Doctors'])){
				$queryStr =   array('doctor_id'=>$paginateArg) ;
			}else{
				$queryStr =  array('doctor_id'=>$this->request->data['User']['All Doctors']) ;
			}
			
			if($data){
				$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
			}

			echo	$this->Paginator->options(array(
					'update' => '#content-list',
					'evalScripts' => true,
					'before' => "loading();",'complete' => "onCompleteRequest();",
					'url' =>array("?"=>$queryStr)
					//'convertKeys'=>array($this->request->data['User']['All Doctors'])
			));

	        /* $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
			$this->Paginator->options(array('url' =>array("?"=>$queryStr))); */?>
			<!-- Shows the next and previous links --> <?php 
			echo $this->Paginator->first(__('« First', true),array('class' => 'paginator_links'));
			echo $this->Paginator->prev(__('« Previous', true),array('class' => 'paginator_links'));
			echo $this->Paginator->numbers(array('update'=>'#content-list'  ));
			echo $this->Paginator->next(__('Next »', true),array('class' => 'paginator_links'));
			echo $this->Paginator->last(__('Last »', true),array('class' => 'paginator_links'));
		
			/* echo $this->Paginator->prev(__('« Previous', true),array('class' => 'paginator_links'));
			echo $this->Paginator->next(__('Next »', true),array('class' => 'paginator_links')); */
			?> <!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		</span>
		</td>
	</tr>
	<tr class="row_title" style="">
		<td width="6%" valign="top" style="min-width: 100px;"
			class="table_cell">RM / BED</td>
	  	<td width="5%" valign="top" class="table_cell">
	  	<?php  
				echo $this->Paginator->sort('Patient.form_received_on', __('Date of Registration', true),array(
		    'update' => '#content-list',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));
				?>
	  	</td>
	  	<?php if(!empty($this->params->query['data']['User']['Discharged']) && $this->params->query['data']['User']['Discharged']==1 ){?>
	  	<td width="5%" valign="top" class="table_cell">Date of Discharge</td>
	  	<?php }?>
		<td width="5%" valign="top" class="table_cell">LOS</td>
		<td width="2%" valign="top" class="table_cell"></td>
		<td width="8%" valign="top" class="table_cell"><?php  
				echo $this->Paginator->sort('Patient.lookup_name', __('PATIENT', true),array(
		    'update' => '#content-list',
		    'evalScripts' => true,
		    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		));
				?></td>
		<td width="2%" valign="top" class="table_cell">AGE</td>
		<td width="2%" valign="top" class="table_cell">ADMISSION ID</td>
		<td width="8%" valign="top" class="table_cell">TARIFF</td>
		<?php if($this->Session->read('website.instance')=='hope'){?>
		<td width="8%" valign="top" class="table_cell">CORPORATE LOCATION</td>
		<?php }?>
		<td width="1%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __(strtoupper("Payment"));?></td>
		<td width="1%" valign="top" class="table_cell">Type</td>
		
		<!--  <td width="5%" valign="top" class="table_cell">MRN.ID.</td>
		<td width="10%" valign="top" class="table_cell">REASON</td>-->
		<td width="2%" valign="top" class="table_cell">STATUS</td>
		<!-- <td width="5%" valign="top" class="table_cell">NURSE</td> -->
		
		<td width="5%" valign="top" class="table_cell"><?php  if(strtolower($role)==strtolower(Configure::read('adminLabel'))) { ?>
		<span>PHYSICIAN<br></span><?php } ?>NURSE</td>
		
		<td width="5%" valign="top" class="table_cell">Task</td>
		<?php /*
		 	if((strtolower($role)==strtolower(Configure::read('doctorLabel')))||(strtolower($role)==strtolower(Configure::read('adminLabel')))){ ?>
		 <td width="5%" valign="top" class="table_cell">CLEARANCE</td>
		 <?php }*/?>
		
		<?php	if($this->Session->read("website.instance") != 'lifespring'){ 
			//if(($role==Configure::read('doctorLabel')||$role==Configure::read('nurseLabel')|| $role==Configure::read('medicalAssistantLabel')) && $future!='future'){?>
				<td width="3%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __(strtoupper("Initial Assesment"));?></td>
				<?php //}  if(($role==Configure::read('doctorLabel')||$role==Configure::read('nurseLabel') || $role==Configure::read('medicalAssistantLabel') || $role==Configure::read('residentLabel')) && $future!='future'){ ?>
			<td width="1%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __(strtoupper("Document Signed"));?></td>
			<!-- <td width="1%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __(strtoupper("Payment"));?></td> -->
			<?php //}?>
			<?php }?>
<!-- 		<td width="3%" valign="top" class="table_cell">EKG.<br>MED</td> -->
		<!-- <td width="3%" valign="top" class="table_cell">MED</td> -->
		<td width="3%" valign="top" class="table_cell">LAB.<br>RAD</td>
		<!-- <td width="3%" valign="top" class="table_cell">RAD</td> -->
		<td width="3%" valign="top" class="table_cell">DIAGNOSIS</td>
		<td width="3%" valign="top" class="table_cell">VITAL</td>
     <!--   <td width="3%" valign="top" class="table_cell">LVL</td> -->
     <?php if(($this->Session->read('role') == Configure::read("doctorLabel") || $this->Session->read('role') == Configure::read("nurseLabel")|| $this->Session->read('role') == Configure::read("adminLabel"))){?>
        <td width="2%" valign="top" class="table_cell">ORDER SET</td>	
		<td width="2%" valign="top" class="table_cell">EMAR</td>
		<td width="2%" valign="top" class="table_cell">I-View</td>
		<td width="2%" valign="top" class="table_cell" title="Critical Care Dashboard">DASH BOARD</td>
	 <?php }?>
	</tr>
	<?php 
	$i=0;
	$currentWard =0;
	//count no of bed per ward
	$level = array(1=>'I','2'=>'II','3'=>'III','4'=>'IV','5'=>'V');
	$status = array('Admitted'=>'Admitted','Posted For Surgery'=>'Posted For Surgery','Operated'=>'Operated','Discharged'=>'Discharged');
	/* foreach($data as $wardKey =>$wardVal){
	 $wardArr[$wardVal['Ward']['name']][] = $wardVal['Ward']['id'];
                     	} */
if($data){
$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
}
                     	$totalBed = count($data);
                     	$booked = 0;
                     	$male =0;
                     	$female=0;
                     	$waiting=0;
                     	$maintenance =0;
                     	$i=0;
                     	foreach($data as $wardKey =>$wardVal){//debug($wardVal);

	//if(!$wardKey) continue ;
	
	?>
	<tr  <?php 
	if($i%2 == 0) {
		if($wardVal['Patient']['Patient']['is_discharge']=='1'){
				echo "class='discharge_red light'";
		}else{
				echo "class='row_gray light'";
		}
					
	}else {
		if($wardVal['Patient']['Patient']['is_discharge']=='1'){
			echo "class='discharge_red light'";
		}else{
			echo "class='light'";
		}
	} ?>>
		<?php  

		echo $this->Form->create('User',array('url'=>array('controller'=>'User','action'=>'update_patient'),'default'=>false,'inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )) );
			?>
		<!-- <td rowspan="<?php //echo count($wardArr[$wardVal['Ward']['name']]);?>" -->
		<td align="left" class="td_ht" style="text-align: left;"><?php echo $wardVal['Patient']['Ward']['name']." / ". $wardVal['Patient']['Room']['bed_prefix'].$wardVal['Patient']['Bed']['bedno'];?>
		</td>
		<?php /* $i++;
			}else{
                      	  			 $i++;
			}
			if($i==count($wardArr[$wardVal['Patient']['Ward']['name']])){
                      	  			$i = 0;
			} */

			?>

		<td align="center" class="td_ht" valign="middle"
			style="text-align: left;"><?php echo $this->DateFormat->formatDate2Local(trim($wardVal['Patient']['Patient']['form_received_on']),Configure::read('date_format'),false); ?> </td> 	
		<?php if(!empty($this->params->query['data']['User']['Discharged']) && $this->params->query['data']['User']['Discharged']==1 ){?>
	  	<td width="5%" valign="top" class="table_cell"><?php echo $this->DateFormat->formatDate2Local(trim($wardVal['Patient']['Patient']['discharge_date']),Configure::read('date_format'),false); ?></td>
	  	<?php }?>	
			
		<td valign="middle" class="td_ht" style="text-align: left;"><?php 
		
		$form_received_on_date= $this->DateFormat->formatDate2Local($wardVal['Patient']['Patient']['form_received_on'],Configure::read('date_format'),true);
		$date_new=$this->DateFormat->formatDate2STDForReport($form_received_on_date,Configure::read('date_format'));
		//$los = $this->DateFormat->dateDiff($wardVal['Patient']['Patient']['form_received_on'],date('Y-m-d H:i:s')) ;
		$los = $this->DateFormat->dateDiff($date_new,date('Y-m-d H:i:s')) ;
		$losStr = "";
		if($los->y >0){
					$losStr = $los->y."Year(s)" ;
				}else if($los->m > 0){
					$losStr .= " ".$los->m."Month(s)" ;
				}else if($los->d > 0){
					$losStr .= " ".$los->d."Day(s)" ;
				}

				if($los->h > 0 && empty($losStr)){
					echo $losStrHr = "<b>".$los->h.":".$los->i."</b>"  ;
				}else{
					echo $losStr ;
				}
				?>
		</td>
						
		<?php 
		if(strtolower($wardVal['Patient']['Person']['sex'])=='male'){
			echo '<td class="td_ht maleImage"></td>';
		}
		if(strtolower($wardVal['Patient']['Person']['sex'])=='female'){
			echo '<td class="td_ht femaleImage"></td>';
		}
		if($wardVal['Patient']['Person']['sex']==''){
			echo '<td class="td_ht">&nbsp;</td>';
			}?>
			
		
		<td align="left" class="td_ht" valign="middle"
			style="text-align: left;">
			<?php 
			$infoDetails = "Name :".$wardVal['Patient']['Patient']['lookup_name']."\nMobile No :".$wardVal['Patient']['Person']['mobile'];
			echo $this->Html->link(ucwords(strtolower($wardVal['Patient']['Patient']['lookup_name'])),array('controller'=>'Patients','action'=>'new_patient_hub',$wardVal['Patient']['Patient']['id'],'?'=>"flag=1"),
					array('style'=>'text-decoration:underline;padding:2px 0px;','title'=>$infoDetails));
			

			
			/*if(empty($wardVal['Patient']['Note']['id'])) { // frist tym
					echo $this->Html->link($wardVal['Patient']['Patient']['lookup_name'],array('controller'=>'Persons','action'=>'patient_information',$wardVal['Patient']['Patient']['person_id'],'?'=>"flag=1"),
					array('style'=>'text-decoration:underline;padding:2px 0px;'));
			}
			else if((!empty($wardVal['Patient']['Note']['id'])) && ($wardVal['Patient']['Note']['sign_note']=='1')){ //power note
					echo $this->Html->link($wardVal['Patient']['Patient']['lookup_name'],array('controller'=>'PatientForms','action'=>'power_note',
					$wardVal['Patient']['Note']['id'],$wardVal['Patient']['Patient']['id']),
					array('style'=>'text-decoration:underline;padding:2px 0px;'));
			}
			else{ // edit mote
					echo $this->Html->link($wardVal['Patient']['Patient']['lookup_name'],array('controller'=>'Notes','action'=>'soapNoteIpd',
					$wardVal['Patient']['Patient']['id'],$wardVal['Patient']['Note']['id']),
					array('style'=>'text-decoration:underline;padding:2px 0px;'));
			}*/
			

		?>
		</td>
		<td valign="middle" style="text-align: center;"><?php echo $wardVal['Patient']['Patient']['patient_age'];?>
		</td>
		<td><?php 
		         echo $wardVal['Patient']['Patient']['admission_id']."<br><br>".$wardVal['Patient']['Person']['mobile'];?>
		</td>
		
		<td><?php 
		         echo $wardVal['Patient']['TariffStandard']['name'];?>
		</td>
		<?php
		if($this->Session->read('website.instance')=='hope'){?>
		<td><?php echo $wardVal['Patient']['CorporateSublocation']['name'];?>
		</td>
		<?php }?>
		<td>
		<?php //paid
				if(!empty($wardVal['Patient']['Billing']['patient_id'])){
					$paid=$wardVal['Patient']['Billing']['total_amount']-$wardVal['Patient']['amount_paid'];					
					if($paid<=0 && $wardVal['Patient']['Billing']['amount_pending']<=0){	
			    		echo $this->Html->link($this->Html->image('icons/green.png',array()), array('controller'=>'Billings','action' => 'multiplePaymentModeIpd', $wardVal['Patient']['Patient']['id'] ), array('escape' => false,'title'=>'View Payment Info'));
			    	}else{
						echo $this->Html->link($this->Html->image('icons/orange_new.png',array()), array('controller'=>'Billings','action' => 'multiplePaymentModeIpd', $wardVal['Patient']['Patient']['id'] ), array('escape' => false,'title'=>'View Payment Info'));
					}
				}else{
					echo $this->Html->link($this->Html->image('icons/red.png',array()), array('controller'=>'Billings','action' => 'multiplePaymentModeIpd', $wardVal['Patient']['Patient']['id'] ), array('escape' => false,'title'=>'View Payment Info'));
						
				
			}
			?>
		
		<?php  
		/*$paid=$wardVal['Patient']['Billing']['total_amount']-$wardVal['Patient']['Billing']['amount_paid'];
			if($paid==0 && $wardVal['Patient']['Billing']['amount_pending']==0){		
	    		echo $this->Html->link($this->Html->image('icons/green.png',array()), array('controller'=>'Billings','action' => 'multiplePaymentModeIpd',$wardVal['Patient']['Patient']['id']  ), array('escape' => false,'title'=>'View Payment Info'));
	    	}else{
				echo $this->Html->link($this->Html->image('icons/orange_new.png',array()), array('controller'=>'Billings','action' => 'multiplePaymentModeIpd',$wardVal['Patient']['Patient']['id'] ), array('escape' => false,'title'=>'View Payment Info'));
			}*/
		?>
		</td>
		
		<td valign="middle" style="text-align: center;"><?php if($wardVal['Patient']['Person']['vip_chk']=='1'){
							echo $this->Html->image("vip.png", array("alt" => "VIP Covid", "title" => "VIP Covid"));
						}else if($wardVal['Patient']['Person']['vip_chk']=='2'){
							echo $this->Html->image("foreigner.png", array("alt" => "Regular Covid", "title" => "Regular Covid"));
						}?>
		</td>
		
		<!--  <td valign="middle" style="text-align: left;"><?php echo $wardVal['Patient']['Patient']['admission_id']?>
		</td>
		<td valign="middle" style="text-align: left;"><?php
		
		
		 foreach($wardVal['Patient']['NoteDiagnosis'] as $diagnosisKey => $diagnosisValue){
		 $reasons[$diagnosisValue['diagnoses_name']]  = $diagnosisValue['diagnoses_name'];
			} 
		    echo $wardVal['NoteDiagnosis']['diagnoses_name'];
			echo $wardVal['Patient']['Appointment']['purpose'];
			?>
		</td>-->
		<td valign="middle" class="td_ht" style="text-align: left;">
		<?php
		$statusId= 'status_'.$wardVal['Patient']['Patient']['id'].'_'.$wardVal['Patient']['OptAppointment']['id'];
		echo $this->Form->input('dashboard_status',array('style'=>'','type'=>'select','options'=>$status, 'empty'=>"" ,
				'value'=>$wardVal['Patient']['Patient']['dashboard_status'],'class'=>'sts hover common','id'=>$statusId));
		
            ?>

		</td>
		<!-- <td valign="middle" class="td_ht" style="text-align: left;">
		</td> -->
		
		<td valign="middle" class="td_ht" class="td_ht"
			style="text-align: left;"><?php // if(strtolower($role)==strtolower(Configure::read('adminLabel'))) { ?>
			
			<?php 
				if($wardVal['Patient']['Patient']['is_discharge']=='1'){
					$taskOptions=array('Discharge Summary'=>'Discharge Summary','DAMA'=>'DAMA','Death Summary'=>'Death Summary','Death Certificate'=>'Death Certificate','listNotes'=>'View Previous SOAP','Patient Document'=>'Patient Document','Patient Survey'=>'Patient Survey'/*,'Ipd Sheet'=>'Ipd Sheet'*/,'Birth Documentation Form'=>'Birth Documentation Form','Print Sheet'=>'Print Sheet','BarCode Sticker'=>'BarCode Sticker','Treatment Sheet'=>'Treatment Sheet','Add Covid Package'=>'Add Covid Package','Claim Submission Checklist'=>'Claim Submission Checklist','NIV Treatment Sheet'=>'NIV Treatment Sheet','Hospital Stay Certificate'=>'Hospital Stay Certificate','Annexure B Certificate'=>'Annexure B Certificate','Annexure CD Certificate'=>'Annexure CD Certificate','Print Sticker'=>'Print Sticker');
				    $disbled="disabled"; 	//if Discharge
				 }else { //for non-discharge , else part for vadodara if patient haven't alloted any bed then make task dropdown blank-Atul
					$taskOptions=array('Discharge Summary'=>'Discharge Summary','DAMA'=>'DAMA','Death Summary'=>'Death Summary','Death Certificate'=>'Death Certificate','AddPrescription'=>'Add Prescription','AddService'=>'Add Service','listNotes'=>'View Previous SOAP','Patient Document'=>'Patient Document','Patient Survey'=>'Patient Survey','Birth Documentation Form'=>'Birth Documentation Form','Print Sheet'=>'Print Sheet','BarCode Sticker'=>'BarCode Sticker','Treatment Sheet'=>'Treatment Sheet','Add Covid Package'=>'Add Covid Package','Claim Submission Checklist'=>'Claim Submission Checklist','NIV Treatment Sheet'=>'NIV Treatment Sheet','Hospital Stay Certificate'=>'Hospital Stay Certificate','Annexure B Certificate'=>'Annexure B Certificate','Annexure CD Certificate'=>'Annexure CD Certificate','Print Sticker'=>'Print Sticker');
	                $disbled="";
	             	if($website == 'vadodara' && $wardVal['Patient']['Bed']['bedno'] == '') {
						$taskOptions = '';
	                 } 
				}
				
			$doctorId = 'doctor_'.$wardVal['Patient']['Patient']['id'];
			echo $this->Form->input('doctor_id',array('style'=>'width:155px;','type'=>'select','options'=>$doctors,
			'empty'=>"Select Physician",'value'=>$wardVal['Patient']['Patient']['doctor_id'],'class'=>'doctor hover common','id'=>$doctorId,'disabled'=>$disbled));?>
			<?php //}
		
		$nurseId= 'nurse_'.$wardVal['Patient']['Patient']['id'];
		echo $this->Form->input('nurse_id',array('style'=>'width:155px;','type'=>'select',
				'options'=>$nurses,'empty'=>"Select Nurse",'value'=>$wardVal['Patient']['Patient']['nurse_id'],'class'=>'nurse hover common','id'=>$nurseId,'disabled'=>$disbled));?>
		</td>
		
			<td> <?php 	if($wardVal['Patient']['Person']['vip_chk']=='1'){
							unset($taskOptions['Add Covid Package']);
						}

				echo $this->Form->input('task',array('style'=>'width:100px;','type'=>'select','label'=>false,'options'=>$taskOptions,'empty'=>"Select Task",'value'=>'','class'=>'currentDropdown task','patient_id'=>$wardVal['Patient']['Patient']['id'],'person_id'=>$wardVal['Patient']['Patient']['person_id'],'id'=>'task_'.$wardVal['Patient']['Patient']['id']));
		 		?>
							 
			<?php 
			if($role==Configure::read('nurseAssistantLabel')){
				 echo $this->Html->link($this->Html->image('icons/pp.png',array()), array('controller'=>'Notes','action' => 'addNurseMedication', $wardVal['Patient']['Patient']['id'],'?'=>array('from'=>'Nurse')), array('escape' => false,'title'=>'Add Prescription'))."&nbsp;&nbsp";			 
				 echo $this->Html->link($this->Html->image('icons/ss.png',array()), array('controller'=>'Billings','action' => 'addNurseServices', $wardVal['Patient']['Patient']['id'] ), array('escape' => false,'title'=>'Add Services'));
			}
			 ?>				 			 
		</td>
		
        <?php 
		 /*	if((strtolower($role)==strtolower(Configure::read('doctorLabel')))||(strtolower($role)==strtolower(Configure::read('adminLabel')))){
		
		 ?>
		<td style="image-align: center;" id="boxSpace" class="tdLabel"  title="Click For Clearance"><?php 
	    $var=unserialize($wardVal[Patient][Patient][clearance]); 
	    $patientChkArray=$var[$wardVal['Patient']['Patient']['id']];
	    
		 echo $this->Form->input("",array('name'=>"data[Patient][clearance][".$wardVal[Patient][Patient][id]."][doctor]",'type'=>'checkbox','legend'=>false,'label'=>false,
          'id'=>'clear-'.$wardVal['Patient']['Patient']['id'],'class'=>'clr','disabled'=>$patientChkArray['doctor'],'checked'=>$patientChkArray['doctor'],'patientName'=>$wardVal['Patient']['Patient']['lookup_name']));
		
		 ?>  
		</td>
		 <?php }*/?>	
		
		<?php if($this->Session->read("website.instance")!='lifespring'){ ?>
		<?php //}// Role conditions if end ?>
					<td style="image-align: center;" class="tdLabel" id="boxSpace"><?php //debug($appointment['Diagnosis']);//initial
					if(!empty($wardVal['Patient']['Diagnosis']['id'])){
						echo $this->Html->link($this->Html->image('icons/green.png',array()),array("controller" => "Diagnoses", "action" => "initialAssessment",$wardVal['Patient']['Patient']['id'],$wardVal['Patient']['Diagnosis']['id'],"admin" => false),array('escape'=>false,'class'=>'initialGreen','id'=>'initial_'.$wardVal['Patient']['Diagnosis']['id'].'_'.$wardVal['Patient']['Patient']['id']));
					}else{
						echo $this->Html->link($this->Html->image('icons/red.png',array()),array("controller" => "Diagnoses", "action" => "initialAssessment", $wardVal['Patient']['Patient']['id'],"admin" => false),array('escape'=>false,'class'=>'initial','id'=>'initial_'.$appointment['Appointment']['id'].'_'.$appointment['Appointment']['patient_id']));
					}
									//}?>
							</td>
							<?php 	//if(($role==Configure::read('doctorLabel') || $role==Configure::read('nurseLabel') || $role==Configure::read('residentLabel') || $role==Configure::read('medicalAssistantLabel'))&& $future!='future'){
							?>
							<td style="text-align: center;" class="tdLabel" id="boxSpace"><?php  //Doc			
										//if($appointment[0]['noteCount']==0){ this conditions is replace by below conditions
							//	if(empty($wardVal['Patient']['Note']['id']) ||empty($wardVal['Patient']['Note']['sign_note']) ||($wardVal['Patient']['Note']['sign_note']==0) ){
										if(!empty($wardVal['Patient']['Note']['id'])){
												echo $this->Html->link($this->Html->image('icons/green.png',array()),array('controller'=>'Notes','action'=>'soapNote',$wardVal['Patient']['Patient']['id'],'null',$wardVal['Patient']['Note']['id']/*,'?'=>array('arrived_time'=>$wardVal['Patient']['Appointment']['arrived_time'])*/),array('id'=>$wardVal['Patient']['Patient']['id'],'escape'=>false,'title'=>'Documentation Complete'/*,'class'=>'context-menu-one'*/));
											
													/*echo $this->Html->link($this->Html->image('icons/green.png',array()),
													array('controller'=>'Notes','action'=>'sendTo',$wardVal['Patient']['Patient']['id']),
													array('id'=>$wardVal['Patient']['Patient']['id'],'escape'=>false,'title'=>'Documentation Complete'));*/
												
										}else{
												echo $this->Html->link($this->Html->image('icons/red.png',array()),array('controller'=>'Notes','action'=>'soapNote',$wardVal['Patient']['Patient']['id'],'null',$wardVal['Patient']['Note']['id']/*,'?'=>array('arrived_time'=>$wardVal['Patient']['Appointment']['arrived_time'])*/),array('id'=>$wardVal['Patient']['Patient']['id'],'escape'=>false,'title'=>'Documentation Not Completed'/*,'class'=>'context-menu-one'*/));
					
													/*echo $this->Html->link($this->Html->image('icons/red.png',array('class'=>'doc_clicked')),
													array('controller'=>'Notes','action'=>'soapNoteIpd',$wardVal['Patient']['Patient']['id']),
													array('id'=>$wardVal['Patient']['Patient']['id'],'escape'=>false,'title'=>'Documentation Not Completed'));*/
													//echo $this->Html->link($this->Html->image('icons/red.png',array('class'=>'doc_clicked')),array('controller'=>'Notes','action'=>'soapNote',$appointment['Appointment']['patient_id'],$appointment['Note']['id']),array('id'=>$appointment['Appointment']['patient_id'],'escape'=>false,'title'=>'Documentation Complete','class'=>'context-menu-one'));
												
											}
										
								//}else{
					        			//	echo $this->Html->link($this->Html->image('icons/green.png',array()),array('controller'=>'Notes','action'=>'clinicalNote',$wardVal['Patient']['Patient']['id'],'null',$wardVal['Patient']['Note']['id']/*,'?'=>array('arrived_time'=>$wardVal['Patient']['Appointment']['arrived_time'])*/),array('id'=>$wardVal['Patient']['Patient']['id'],'escape'=>false,'title'=>'Documentation Complete'/*,'class'=>'context-menu-one'*/));
					
					
										//	echo $this->Html->link($this->Html->image('icons/green.png',array()),array('controller'=>'Notes','action'=>'sendTo',$wardVal['Patient']['Patient']['id'],$wardVal['Patient']['Patient']['id']),
										//		 array('id'=>$wardVal['Patient']['Patient']['patient_id'],'escape'=>false/* ,'title'=>'Documentation Complete/Right Click To view Rx ','class'=>'context-menu-one' */));
										
									//	}
									//}	?>
									
							</td>
							<?php //}	
					
					}?>
		
		
		<!-- <td valign="middle" class="td_ht"><?php

		//Commented temporarily as not needed right now.
		//Used for MRI and Medications- Leena
		
/*		$ekgOrder  = (int)$wardVal['EKG']['ekg'] ;
 		//$ekgOrder  = $wardVal['EKG'][0]['EKG'][0]['ekg'] ; result screen not yet generated

 		if($ekgOrder > 0)
 			$ekgResUrl = array('controller'=>'EKG','action'=>'ekg_list',$wardVal['Patient']['Patient']['id']) ;
 		else
 			$ekgResUrl = "#" ;
			
 		echo $this->Html->link("0/$ekgOrder</br>",$ekgResUrl,array('escape' => false,'title' => 'Click to view result','style'=>'curson:pointer;'));
		
		$medOrder  = (int)$wardVal['NewCropPrescription']['med'] ;
 		$medGiven  = (int)$wardVal['NewCropPrescription']['med'] ;
 		echo "$medGiven/$medOrder" ; */
			
		?></td> -->
		<!-- <td valign="middle" class="td_ht"><?php 
		$medOrder  = (int)$wardVal['NewCropPrescription']['med'] ;
		$medGiven  = (int)$wardVal['NewCropPrescription']['med'] ;
		echo "$medGiven/$medOrder" ; ?>
		</td> -->
		<td valign="middle" class="td_ht"><?php  
		$labOrder  = (int)$wardVal['LaboratoryTestOrder']['lab'] ;
		$labResult  = (int)$wardVal['LaboratoryResult']['labResult'] ;
		if($labOrder > 0)
			$labResUrl = array('controller'=>'laboratories','action'=>'labTestHl7List',$wardVal['Patient']['Patient']['id'],'?'=>array('return'=>'laboratories')) ;
		else
			$labResUrl = "#" ;

		echo $this->Html->link("$labResult/$labOrder</br>",$labResUrl,array('escape' => false,'title' => 'Click to view result','style'=>'curson:pointer;'));
		
		$radOrder  	= (int)$wardVal['RadiologyTestOrder']['rad'] ;
		$radResult  = (int)$wardVal['RadiologyResult']['radResult'] ;
		if($radOrder > 0)
			$radResUrl = array('controller'=>'radiologies','action'=>'radiology_test_list',$wardVal['Patient']['Patient']['id'],'?'=>array('return'=>'radiologies')) ;
		else
			$radResUrl = "#" ;

		echo $this->Html->link("$radResult/$radOrder",$radResUrl,array('escape' => false,'title' => 'Click to view result','style'=>'curson:pointer;'));
		?>
		</td>
		<!-- <td valign="middle" class="td_ht"><?php 
		$radOrder  	= (int)$wardVal['RadiologyTestOrder']['rad'] ;
		$radResult  = (int)$wardVal['RadiologyResult']['radResult'] ;
		if($radOrder > 0)
			$radResUrl = array('controller'=>'radiologies','action'=>'radiology_test_list',$wardVal['Patient']['Patient']['id'],'?'=>array('return'=>'radiologies')) ;
		else
			$radResUrl = "#" ;

		echo $this->Html->link("$radResult/$radOrder",$radResUrl,array('escape' => false,'title' => 'Click to view result','style'=>'curson:pointer;'));
		?>
		</td> -->

		<td valign="middle" class="td_ht"><a
			href="javascript:icdwin(<?php echo $wardVal['Patient']['Patient']['id']; ?>)">
				<?php echo $this->Html->image('icons/search_icon.png',array('title'=>'Search ICD Code')) ?>
		</a></td>
		<?php 
		/*if(isset($wardVal['vitalData']['Temperature Oral ']))
			unset($wardVal['vitalData']['Temperature Axillary '],$wardVal['vitalData']['Temperature Rectal ']);
		elseif(isset($wardVal['vitalData']['Temperature Axillary ']))
			unset($wardVal['vitalData']['Temperature Rectal ']);
		if(isset($wardVal['vitalData']['Apical Heart Rate ']))
			unset($wardVal['vitalData']['Heart Rate Monitoring ']);
		if(isset($wardVal['vitalData']['SBP/DBP Cuff ']))
			unset($wardVal['vitalData']['SBP/DBP Line ']);
		foreach($wardVal['vitalData'] as $key => $vital){
			$toolTip .=  "<b>$key</b> - $vital</br>";
		}
		if($toolTip == '')$toolTip = 'Not Entered';*/
		?>
		 
		<td valign="middle" class="td_ht" title="<?php //echo $toolTip ?>">
		<?php    
		echo $this->Html->link($this->Html->image('icons/vital_icon.png',array()), array("controller" => "Diagnoses", "action" => "addVital",$wardVal['Patient']['Patient']['id'],$wardVal['Patient']['Note']['id'],null,'?'=>array('form'=>'IpdDashboard'), 'admin' => false), array('escape' => false,'title'=>'Add Vitals'));
		//echo $this->Html->link('Detail Vitals',array("controller" => "Diagnoses", "action" => "addVital",$wardVal['Patient']['Patient']['id'],$wardVal['Patient']['Note']['id'],null, 'admin' => false),array('class'=>'blueBtn','style'=>'text-decoration:underline;','target'=>'_blank'));?>
		</td>
		<?php //$toolTip='';?>
		<!--<td valign="middle" class="td_ht" style="text-align: left;"><?php //debug($wardVal);
				$levelId= 'dashboard_'.$wardVal['Patient']['Patient']['id'];
				echo $this->Form->input('dashboard_level',array('style'=>'width:50px;','type'=>'select','options'=>$level,'empty'=>"",'value'=>$wardVal['Patient']['Patient']['dashboard_level'],
				 						'class'=>'lvl hover common','id'=>$levelId));
			?>
		</td>
		<td><?php echo $this->Html->link($this->Html->image('icons/blue.png',array('title'=>'OrderSet View')),
				array("controller" => "MultipleOrderSets", "action" => "sendTo",$wardVal['Patient']['Patient']['id'],"admin" => false),
				array('escape'=>false,'class'=>'initialGreen','id'=>'initial_'.$wardVal['Patient']['Diagnosis']['id'].'_'.$wardVal['Patient']['Patient']['id']));?></td>
		<td><?php echo $this->Html->link($this->Html->image('icons/blue.png',array('title'=>'EMAR View')),array("controller" => "PatientsTrackReports", "action" => "emarDashboard",$wardVal['Patient']['Patient']['id'],"admin" => false),array('escape'=>false,'class'=>'emar'));?></td>
		<td><?php echo $this->Html->link($this->Html->image('icons/blue.png',array('title'=>'Interactive View')),array("controller" => "Nursings", "action" => "interactive_view",$wardVal['Patient']['Patient']['id'],"admin" => false),array('escape'=>false,'class'=>'i_view'));?></td>
		
		
		<td><?php echo $this->Html->link($this->Html->image('icons/blue.png',array('title'=>'Critical Care View')),array("controller" => "PatientsTrackReports", "action" => "index",$wardVal['Patient']['Patient']['id'],"admin" => false),array('escape'=>false,'class'=>'d_board'));?></td>
		
		-->
		<?php 
			if(($this->Session->read('role') == Configure::read("doctorLabel") || $this->Session->read('role') == Configure::read("nurseLabel")|| $this->Session->read('role') == Configure::read("adminLabel"))){ ?>
				<td>
					<?php 
						echo $this->Html->link($this->Html->image('icons/blue.png',array('title'=>'OrderSet View')),array("controller" => "MultipleOrderSets", "action" => "sendTo",$wardVal['Patient']['Patient']['id'],"?"=>"type=IPD","admin" => false),array('escape'=>false,'class'=>'initialGreen','id'=>'initial_'.$wardVal['Patient']['Diagnosis']['id'].'_'.$wardVal['Patient']['Patient']['id']));
					?>
				</td>
				
				<td>
					<?php 
						echo $this->Html->link($this->Html->image('icons/blue.png',array('title'=>'EMAR View')),array("controller" => "PatientsTrackReports", "action" => "emarDashboard",$wardVal['Patient']['Patient']['id'],"admin" => false),array('escape'=>false,'class'=>'emar'));
					?>
				</td>
				
				<td>
					<?php 
						echo $this->Html->link($this->Html->image('icons/blue.png',array('title'=>'Interactive View')),array("controller" => "Nursings", "action" => "interactive_view",$wardVal['Patient']['Patient']['id'],"admin" => false),array('escape'=>false,'class'=>'i_view'));
					?>
				</td>


				<td>
					<?php 
						echo $this->Html->link($this->Html->image('icons/blue.png',array('title'=>'Critical Care View')),array("controller" => "PatientsTrackReports", "action" => "index",$wardVal['Patient']['Patient']['id'],"admin" => false),array('escape'=>false,'class'=>'d_board'));
					?>
				</td>
		<?php }?>
		
		
		
		
		<?php echo $this->Form->end(); ?>
	</tr>
	<?php  $i++; 
} ?>
	<tr style="text-align: center;">
		<td colspan="14">
		<?php $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
			$this->Paginator->options(array('url' =>array("?"=>$queryStr)));?>
			<!-- Shows the next and previous links --> <?php 
			echo $this->Paginator->first(__('« First', true),array('class' => 'paginator_links'));
			echo $this->Paginator->prev(__('« Previous', true),array('class' => 'paginator_links'));
			echo $this->Paginator->numbers(array('update'=>'#content-list'  ));
			echo $this->Paginator->next(__('Next »', true),array('class' => 'paginator_links'));
			echo $this->Paginator->last(__('Last »', true),array('class' => 'paginator_links'));
			?> <!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		</span>
		</td>
	</tr>
	<?php  
	echo $this->Js->writeBuffer();
	/*$paggingArray = $this->Paginator->params() ;
		
	echo $this->Form->input('patient_count',array('id'=>'patient-count' , "value"=>$paggingArray['count'] ,'url'=>$this->Paginator->url()));*/
	

	echo $this->Form->hidden('Patientsid',array('id'=>'Patientsid')) ;
	?>

</table>


<div id="no_app">
	<?php
	if(empty($data)){
			echo "<span class='error'>";
			echo __('No record found.');
			echo "</span>";
		}
		?>
</div>

<script>
	$( document ).ready(function () {
		$('.tooltip').tooltipster({
	 		interactive:true,
	 		position:"right", 
	 	});

		$('select').hover(function() {
			var value=$(this).val();
			this.title = this.options[this.selectedIndex].text; 
		})
	 	});
var diagnosisSelectedArray = new Array();

function addDiagnosisDetails(){
	var selectedPatientId = parent.$('#Patientsid').val();
	
	if(selectedPatientId != ''){
		
		var currEle = diagnosisSelectedArray.pop();
		if((currEle !='') && (currEle !== undefined)){
			parent.openbox(currEle,selectedPatientId,parent.global_note_id);
		}
	}
	
}

function openbox(icd,note_id,linkId) { 
	var sample;
	 
	icd = icd.split("::");
	var patient_id = $('#Patientsid').val();
	if (patient_id == '') {
		alert("Please select patient");
		return false;
	}
	
	$.fancybox({
				'width' : '40%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'hideOnOverlayClick':false,
				'showCloseButton':false,
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "make_diagnosis")); ?>"
						 + '/' + patient_id + '/' + icd , 
				
			}); 

}

function icdwin(patient_id) {  
	 
	 
	if (patient_id == '') {
		alert("Something went wrong");
		return false;
	} 
	$("#Patientsid").val(patient_id);
	$.fancybox({ 
				'width' : '70%',
				'height' : '120%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe', 
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>" + '/' + patient_id,
	});

}
$('.task').change(function(){
	var id=$(this).attr('patient_id');
	var value=$(this).val();
	
	if(value=='Discharge Summary'){
		/*var openWin = window.open('<?php //echo $this->Html->url(array('controller'=>'Patients','action'=>'qr_card'))?>/'+id, '_blank',
        'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');*/
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'discharge_summary'));?>'+'/'+$(this).attr('patient_id'); //'+'/null/'+$(this).attr('person_id')+'/?patientId='+$(this).attr('patient_id');
        
	}else if(value=='DAMA'){
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'dama_form'));?>'+'/'+$(this).attr('patient_id'); 
	}else if(value=='Death Summary'){
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'death_summary'));?>'+'/'+$(this).attr('patient_id'); 
	}
	else if(value=='Death Certificate'){
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'death_certificate'));?>'+'/'+$(this).attr('patient_id'); 
	}else if(value=='AddPrescription'){
	 	//window.location.href = '<?php //echo $this->Html->url(array('controller'=>'Notes','action'=>'addMedication'));?>'+'/'+$(this).attr('patient_id')+"? from=Nurse";
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Notes','action'=>'addNurseMedication'));?>'+'/'+$(this).attr('patient_id')+"? from=Nurse";
	}else if(value=='Patient Document'){
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'PatientDocuments','action'=>'add'));?>'+'/'+$(this).attr('patient_id')
		+'/'+'null'+'/'+'ipdDashboard';
	}else if(value=='listNotes'){
	 	//window.location.href = '<?php //echo $this->Html->url(array('controller'=>'Notes','action'=>'addMedication'));?>'+'/'+$(this).attr('patient_id')+"? from=Nurse";
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Notes','action'=>'noteList'));?>'+'/'+$(this).attr('person_id');
	}else if(value=='Patient Survey'){
        window.location.href = '<?php echo $this->Html->url(array('controller'=>'surveys','action'=>'patient_surveys'));?>'+'/'+$(this).attr('patient_id');
	}else if(value=='Birth Documentation Form'){
        window.location.href = '<?php echo $this->Html->url(array('controller'=>'HR','action'=>'birthDocForm'));?>'+'/'+$(this).attr('patient_id');
	}else if(value=='AddService'){
	 	//window.location.href = '<?php //echo $this->Html->url(array('controller'=>'Notes','action'=>'addMedication'));?>'+'/'+$(this).attr('patient_id')+"? from=Nurse";
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'addNurseServices'));?>'+'/'+$(this).attr('patient_id');
	}else if(value=='Print Sheet'){ 
		var printUrl = '<?php echo $this->Html->url(array("controller" => "patients", "action" => "opd_patient_detail_print")); ?>'+'/'+$(this).attr('patient_id');
		var openWin =window.open(printUrl, '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
	}else if(value == 'BarCode Sticker'){
		getViewSticker($(this).attr('person_id'));
	}else if(value == 'Treatment Sheet'){
            window.location.href = '<?php echo $this->Html->url(array('controller'=>'Pharmacy','action'=>'treatmentSheet','inventory'=>false));?>'+'/'+$(this).attr('patient_id');
            //getViewSticker($(this).attr('patient_id'));
	}else if(value == 'Add Covid Package'){
            window.location.href = '<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'addCovidPackages','admin'=>false));?>'+'/'+$(this).attr('patient_id');
            //getViewSticker($(this).attr('patient_id'));
    }else if(value == 'Claim Submission Checklist'){
            window.location.href = '<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'claim_submission_checklist','admin'=>false));?>'+'/'+$(this).attr('patient_id');
           
	}else if(value == 'NIV Treatment Sheet'){
            window.location.href = '<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'niv_treatment_sheet','admin'=>false));?>'+'/'+$(this).attr('patient_id');
           
	}else if(value == 'Hospital Stay Certificate'){
            window.location.href = '<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'hospital_stay_certificate','admin'=>false));?>'+'/'+$(this).attr('patient_id');
           
	}
	else if(value == 'Annexure B Certificate'){
            window.location.href = '<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'annexure_b','admin'=>false));?>'+'/'+$(this).attr('patient_id');
           
	}
	else if(value == 'Annexure CD Certificate'){
            window.location.href = '<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'annexure_cd_form','admin'=>false));?>'+'/'+$(this).attr('patient_id');
           
	}
	else if(value == 'Print Sticker'){
           var openWin = window.open('<?php echo $this->Html->url(array('controller'=>'persons','action'=>'printSticker'))?>/'+id, '_blank',
                'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=100,top=200,height=800');
           
	}
        
});

$('.clr').click(function (){
	var thisinputsClass = $(this).attr('id');	
	var pname = $(this).attr('patientName');
	var splittedId = thisinputsClass.split('-');
 	var	patient_Id = splittedId[1];
	//var nurse_Id=$('#nurse_'+patient_Id).val();
	//if(nurse_Id){
		 formData = $('#'+thisinputsClass).serialize();
		 $.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "users", "action" => "clear", "admin" => false)); ?>",
			  context: document.body,
			//  data:'id='+apptId+'&patient_id='+patId,
			  data: formData+"&patientId="+patient_Id+"&patientname="+pname,
			  beforeSend:function(){
				  $('#busy-indicator').show('slow');
				  }, 	  		  
			  success: function(data){
				  if($("#"+thisinputsClass).is(":checked"))$("#"+thisinputsClass).prop("disabled",true);
				  //$(this).attr('disabled',true);
	           	  $('#busy-indicator').hide('slow');
	         
				  }
			  
		});
});
// following case will generate only for vadodara if patient haven't alloted any bed then alert will show-Atul
$('.task').click(function(){
	var id = $(this).attr('id');
	var length = $("#"+id).children('option').length;
	if(length==1){
		alert("Sorry, No Bed Alloted to this Patient");
	}	
});

//open barcode Sticker window
function getViewSticker(patientId){
	$.fancybox({
		'width' : '40%',
		'height' : '40%',
		'autoScale' : true,
		'transitionIn' :'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller"=>"Persons", "action" => "qr_card")); ?>"+"/"+patientId,
	});
}
</script>
