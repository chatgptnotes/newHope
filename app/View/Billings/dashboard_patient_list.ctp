<?php //debug($wardVal); exit;?>
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
		background-color: pink;
}



</style>
<?php //list of patients
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


			echo $this->Paginator->prev(__('« Previous', true),array('class' => 'paginator_links'));
			echo $this->Paginator->next(__('Next »', true),array('class' => 'paginator_links'));
			?> <!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		</span>
		</td>
	</tr>
	<tr class="row_title" style="">
		<td width="6%" valign="top" style="min-width: 100px;"
			class="table_cell">RM / BED</td>
	  	<td width="5%" valign="top" class="table_cell">Date of Registration</td>
	  	<td width="5%" valign="top" class="table_cell">LOS</td>
		<td width="2%" valign="top" class="table_cell"></td>
		<td width="8%" valign="top" class="table_cell">PATIENT</td>
		<td width="2%" valign="top" class="table_cell">AGE</td>
		<td width="2%" valign="top" class="table_cell">ADMISSION ID</td>
		<td width="3%" valign="top" class="table_cell">TARIFF</td>
		<?php if($this->Session->read('website.instance')=='hope'){?>
		<td width="8%" valign="top" class="table_cell">CORPORATE LOCATION</td>
		<?php }?>
		<td width="1%" style="text-align: center;" valign="top"
				class="table_cell"><?php echo __(strtoupper("Payment"));?></td>
		<td width="1%" valign="top" class="table_cell">Type</td>
		
		<td width="2%" valign="top" class="table_cell">STATUS</td>
		<!-- <td width="5%" valign="top" class="table_cell">NURSE</td> -->
		
		<td width="5%" valign="top" class="table_cell"><?php  if(strtolower($role)==strtolower(Configure::read('adminLabel'))) { ?>
		<span>PHYSICIAN<br></span><?php } ?>NURSE</td>
		
		<td width="5%" valign="top" class="table_cell">Task</td>		
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
                     	foreach($data as $wardKey =>$wardVal){// debug($wardVal);

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
				
			echo $this->Html->link($wardVal['Patient']['Patient']['lookup_name'],array('controller'=>'Persons','action'=>'patient_information',$wardVal['Patient']['Patient']['person_id'],'?'=>"flag=1"),
					array('style'=>'text-decoration:underline;padding:2px 0px;'));

			
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
			}
			*/

		?>
		</td>
		<td valign="middle" style="text-align: center;"><?php echo $wardVal['Patient']['Patient']['age']?>
		</td>
		<td><?php 
		         echo $wardVal['Patient']['Patient']['admission_id'];?>
		</td>
		<td><?php 
		         echo $wardVal['Patient']['TariffStandard']['name'];?>
		</td>
		<?php if($this->Session->read('website.instance')=='hope'){?>
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
	
		 if($wardVal['Patient']['Patient']['is_discharge']=='1'){
			$statusId= 'status_'.$wardVal['Patient']['Patient']['id'];
			echo $this->Form->input('dashboard_status',array('style'=>';','type'=>'select','options'=>$status,'disabled'=>'disabled', 'empty'=>"" ,
					'value'=>'Discharged','class'=>'sts hover common','id'=>$statusId));

		}elseif(!empty($wardVal['Patient']['OptAppointment']['patient_id'])){
                     $statusId= 'status_'.$wardVal['Patient']['Patient']['id'];
                     echo $this->Form->input('dashboard_status',array('style'=>';','type'=>'select','options'=>$status ,
		             'value'=>'Posted For Surgery','class'=>'sts hover common','id'=>$statusId));

         } else{
		      $statusId= 'status_'.$wardVal['Patient']['Patient']['id'];
		      echo $this->Form->input('dashboard_status',array('style'=>';','type'=>'select','options'=>$status, 'empty'=>"" ,
			'value'=>$wardVal['Patient']['Patient']['dashboard_status'],'class'=>'sts hover common','id'=>$statusId));
            }
            ?>

		</td>
		<!-- <td valign="middle" class="td_ht" style="text-align: left;">
		</td> -->
		
		<td valign="middle" class="td_ht" class="td_ht"
			style="text-align: left;"><?php // if(strtolower($role)==strtolower(Configure::read('adminLabel'))) { ?>
			<?php 
			$doctorId = 'doctor_'.$wardVal['Patient']['Patient']['id'];
			echo $this->Form->input('doctor_id',array('style'=>'width:155px;','type'=>'select','options'=>$doctors,
			'empty'=>"Select Physician",'value'=>$wardVal['Patient']['Patient']['doctor_id'],'class'=>'doctor hover common','id'=>$doctorId));?>
			<?php //}
		$nurseId= 'nurse_'.$wardVal['Patient']['Patient']['id'];
		echo $this->Form->input('nurse_id',array('style'=>'width:155px;','type'=>'select',
				'options'=>$nurses,'empty'=>"Select Nurse",'value'=>$wardVal['Patient']['Patient']['nurse_id'],'class'=>'nurse hover common','id'=>$nurseId));?>
		</td>
		
		 <?php //for vadodara if patient haven't alloted any bed then make task dropdown blank-Atul
				$taskOptions=array('Discharge Summary'=>'Discharge Summary','DAMA'=>'DAMA','Death Summary'=>'Death Summary','AddPrescription'=>'AddPrescription','Print Sheet'=>'Print Sheet','Add Covid Package'=>'Add Covid Package','Claim Submission Checklist'=>'Claim Submission Checklist','NIV Treatment Sheet'=>'NIV Treatment Sheet','Hospital Stay Certificate'=>'Hospital Stay Certificate','Annexure B Certificate'=>'Annexure B Certificate','Annexure CD Certificate'=>'Annexure CD Certificate');
	                 if($this->Session->read('website.instance') == 'vadodara' && $wardVal['Patient']['Bed']['bedno'] == '') {
						$taskOptions = '';
	                 } 
				?>
		
			<td> <?php 	
						if($wardVal['Patient']['Person']['vip_chk']=='1'){
							unset($taskOptions['Add Covid Package']);
						}

		 				echo $this->Form->input('task',array('style'=>'width:100px;','type'=>'select','label'=>false,
						     'options'=>$taskOptions,'empty'=>"Select Task",'value'=>'','class'=>'currentDropdown task','patient_id'=>$wardVal['Patient']['Patient']['id'],'person_id'=>$appointment['Appointment']['person_id'],
							 'id'=>'task_'.$wardVal['Patient']['Patient']['id']));?>
		  </td>		
		
		
	
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
		/*var openWin = window.open('<?php echo $this->Html->url(array('controller'=>'Patients','action'=>'qr_card'))?>/'+id, '_blank',
        'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');*/
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'discharge_summary'));?>'+'/'+$(this).attr('patient_id'); //'+'/null/'+$(this).attr('person_id')+'/?patientId='+$(this).attr('patient_id');
        
	}else if(value=='DAMA'){
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'dama_form'));?>'+'/'+$(this).attr('patient_id'); 
	}else if(value=='Death Summary'){
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Billings','action'=>'death_summary'));?>'+'/'+$(this).attr('patient_id'); 
	}else if(value=='AddPrescription'){
	 	//window.location.href = '<?php //echo $this->Html->url(array('controller'=>'Notes','action'=>'addMedication'));?>'+'/'+$(this).attr('patient_id')+"? from=Nurse";
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'Notes','action'=>'addNurseMedication'));?>'+'/'+$(this).attr('patient_id')+"? from=Nurse";
	}else if(value=='Print Sheet'){ 
		var printUrl = '<?php echo $this->Html->url(array("controller" => "patients", "action" => "opd_patient_detail_print")); ?>'+'/'+$(this).attr('patient_id');
		var openWin =window.open(printUrl, '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
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
});

//following case will generate only for vadodara if patient haven't alloted any bed then alert will show-Atul
$('.task').click(function(){
	var id = $(this).attr('id');
	var length = $("#"+id).children('option').length;
	if(length==1){
		alert("Sorry, No Bed Alloted to this Patient");
	}	
});
</script>
