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
	border: 0.100em solid;
	border-radius: 25px;
	border-color: olive;
	color: #E7EEEF;
	font-size: 13px;
	outline: medium none;
	padding: 0px;
	resize: none;
}
.pateint_age {
    padding: 0 0 0 10px !important;
    text-align: left;
}
.cake_icon_sec {
    padding: 0 0 0 27px !important;
}
#prob_sec {
    padding: 0 0 0 17px !important;
}

#mrn { text-align:center;}
#rad_sec {
    padding: 0 0 0 5px !important;
}
#viatal_lbl {
    padding: 8px 0 0 17px !important;
}
.brown_img img {
    padding: 0 0 0 10px;
    text-align: left;
}
/*#reason_lbl {
    padding: 0 0 0 20px !important;
}*/
</style>
<?php //list of patients
$role = $this->Session->read('role');
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	class="table_format textAlign">
	<tr style="text-align: center;">
		<td colspan="14">
			<!-- Shows the next and previous links --> <?php 

			if(empty($this->request->data['User']['All Doctors'])){
				$queryStr =   array('doctor_id'=>$paginateArg) ;
			}else{
				$queryStr =  array('doctor_id'=>$this->request->data['User']['All Doctors']) ;
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
	<!--	<td width="6%" valign="top" style="min-width: 100px;"
			class="table_cell">RM</td>
	 	<td width="2%" valign="top" class="table_cell">BED</td>
		<td width="5%" valign="top" class="table_cell">LOS</td>
		<td width="3%" valign="top" class="table_cell">LVL</td> -->
		<td width="2%" valign="top" class="table_cell"></td>
		<td width="8%" valign="top" class="table_cell">PATIENT</td>

		<td width="2%" valign="top" class="table_cell" style="text-align:center;">AGE</td>
		<td width="5%" valign="top" class="table_cell" id="mrn">DATE OF BIRTH</td>
		<td width="1%" valign="top" class="table_cell">REASON</td>
		<!-- <td width="2%" valign="top" class="table_cell" style="text-align:center;">DATE OF BIRTH</td> 
		<td width="1%" valign="top" class="table_cell" style="text-align:center;">CONSULT</td>-->
		<?php  if(strtolower($role)==strtolower(Configure::read('adminLabel'))) { ?>
		<td width="5%" valign="top" class="table_cell" style="text-align:center;">PHYSICIAN</td>
		<?php } ?>
		<!-- <td width="3%" valign="top" class="table_cell">EKG</td>
		<td width="3%" valign="top" class="table_cell">MED</td> -->
		<td width="3%" valign="top" class="table_cell">LAB</td>
		<td width="2%" valign="top" class="table_cell">Managed Critical Alerts</td>
		<td width="3%" valign="top" class="table_cell">RAD</td>
		<td width="3%" valign="top" class="table_cell">PROB</td>
		<td width="3%" valign="top" class="table_cell" id="viatal_lbl">VITAL</td>
		<!-- <td width="3%" valign="top" class="table_cell">Insurance Encounter</td> -->

	</tr>
	<?php 
		$i=0;
	$currentWard =0;
	//count no of bed per ward
	$level = array(1=>'I','2'=>'II','3'=>'III','4'=>'IV','5'=>'V');
	$status = array('Triaged'=>'Triaged','Waiting on MD'=>'Wating on MD','Quick Reg'=>'Quick Reg');
	/* foreach($data as $wardKey =>$wardVal){
	 $wardArr[$wardVal['Ward']['name']][] = $wardVal['Ward']['id'];
                     	} */
                     	$totalBed = count($data);
                     	$booked = 0;
                     	$male =0;
                     	$female=0;
                     	$waiting=0;
                     	$maintenance =0;
                     	$i=0;
                     	foreach($data as $wardKey =>$wardVal){

	if(!$wardKey) continue ;


	?>
	<tr <?php if($i%2 == 0) echo "class='row_gray'"; ?>>
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
		<!-- <td align="left" class="td_ht" style="text-align: left;"><?php echo $wardVal['Patient']['Ward']['name']?>
		</td> -->
		<?php /* $i++;
			}else{
                      	  			$i++;
			}
			if($i==count($wardArr[$wardVal['Patient']['Ward']['name']])){
                      	  			$i = 0;
			} */

			?>
		<!--<td align="center" class="td_ht" valign="middle"
			style="text-align: left;"><?php echo $wardVal['Patient']['Room']['bed_prefix'].$wardVal['Patient']['Bed']['bedno'] ;?>
		</td>-->
		<!--<td valign="middle" class="td_ht" style="text-align: left;"><?php 
		$los = $this->DateFormat->dateDiff($wardVal['Patient']['Patient']['form_received_on'],date('Y-m-d H:i:s')) ;
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
		</td>-->
		<!-- <td valign="middle" class="td_ht" style="text-align: left;"><?php //debug($wardVal);
				$levelId= 'dashboard_'.$wardVal['Patient']['Patient']['id'];
				echo $this->Form->input('dashboard_level',array('type'=>'select','options'=>$level,'empty'=>"",'value'=>$wardVal['Patient']['Patient']['dashboard_level'],
				 						'class'=>'lvl','id'=>$levelId));
			?>
		</td> -->
		<?php 
		if(strtolower($wardVal['Patient']['Person']['sex'])=='male'){
			echo '<td class="td_ht maleImage"></td>';
		}
		else if(strtolower($wardVal['Patient']['Person']['sex'])=='female'){
			echo '<td class="td_ht femaleImage"></td>';
		}
		else {
				echo '<td class="td_ht"> &nbsp;</td>';
			}?> 
		
		<td align="left" class="td_ht" valign="middle"
			style="text-align: left;"><?php  
			echo $this->Html->link($wardVal['Patient']['Patient']['lookup_name'],array('controller'=>'PatientsTrackReports','action'=>'sbar',$wardVal['Patient']['Patient']['id']),
									array('style'=>'text-decoration:underline;padding:2px 0px;'));

		?>
		</td>
		<?php if( $wardVal['Patient']['Patient']['age']  > '1'){
			$years='Years';
		}else{
			$years='Year';
		}?>
		<td valign="middle" class="pateint_age" style="text-align:left;"><?php echo $wardVal['Patient']['Patient']['age']?>
		</td>
		<td valign="middle" style="text-align: center;"><?php //echo $wardVal['Patient']['Patient']['admission_id']?>
		<?php $dob=$this->DateFormat->formatDate2Local($wardVal['Patient']['Person']['dob'],Configure::read('date_format'),true);
			echo $dob;?>
		</td>
		<td valign="middle" style="text-align: left;" id="reason_lbl"><?php 
		/* foreach($wardVal['Patient']['NoteDiagnosis'] as $diagnosisKey => $diagnosisValue){
		 $reasons[$diagnosisValue['diagnoses_name']]  = $diagnosisValue['diagnoses_name'];
			} */
		//	echo $wardVal['NoteDiagnosis']['diagnoses_name'];
			echo $wardVal['Patient']['Appointment']['purpose'];
			?>
		</td>
		<!-- <td valign="middle" class="td_ht" style="text-align:center;"><?php 
		//$statusId= 'status_'.$wardVal['Patient']['Patient']['id'];
		//echo $this->Form->input('dashboard_status',array('style'=>'width:auto;','type'=>'select','options'=>$status,'empty'=>"",
			//'value'=>$wardVal['Patient']['Patient']['dashboard_status'],'class'=>'sts','id'=>$statusId));?>
			<?php //$dob=$this->DateFormat->formatDate2Local($wardVal['Patient']['Person']['dob'],Configure::read('date_format'),true);
			//echo $dob;?>
		</td> 
		<td valign="middle" class="td_ht" style="text-align:center;"><?php
		//$nurseId= 'nurse_'.$wardVal['Patient']['Patient']['id'];
		//echo $this->Form->input('nurse_id',array('style'=>'width:auto;','type'=>'select',
		//		'options'=>$nurses,'empty'=>"",'value'=>$wardVal['Patient']['Patient']['nurse_id'],'class'=>'nurse','id'=>$nurseId));?>
		</td>-->
		<?php  if(strtolower($role)==strtolower(Configure::read('adminLabel'))) { ?>
		<td valign="middle" class="td_ht" class="td_ht"
			style="text-align: center;"><?php 
			$doctorId = 'doctor_'.$wardVal['Patient']['Patient']['id'];
			echo $this->Form->input('doctor_id',array('style'=>'width:113px;','type'=>'select','options'=>$doctors,
			'empty'=>"",'value'=>$wardVal['Patient']['Patient']['doctor_id'],'class'=>'doctor','id'=>$doctorId));?>
		</td>
		<?php } ?>
		<!-- <td valign="middle" class="td_ht"><?php 
		$ekgOrder  = (int)$wardVal['EKG']['ekg'] ;
		//$ekgOrder  = $wardVal['EKG'][0]['EKG'][0]['ekg'] ; result screen not yet generated

		if($ekgOrder > 0)
			$ekgResUrl = array('controller'=>'EKG','action'=>'ekg_list',$wardVal['Patient']['Patient']['id']) ;
		else
			$ekgResUrl = "#" ;
			
		echo $this->Html->link("0/$ekgOrder",$ekgResUrl,array('escape' => false,'title' => 'Click to view result','style'=>'curson:pointer;'));
			
		?></td> -->
		<!-- <td valign="middle" class="td_ht"><?php 
		$medOrder  = (int)$wardVal['NewCropPrescription']['med'] ;
		$medGiven  = (int)$wardVal['NewCropPrescription']['med'] ;
		echo "$medGiven/$medOrder" ; ?>
		</td> -->
		<td valign="middle" class="td_ht" id="rad_sec"><?php  
		$labOrder  = (int)$wardVal['LaboratoryTestOrder']['lab'] ;
		 
		$isAbnormal = $wardVal['LaboratoryResult']['abnormal'] ;
		if($isAbnormal=='A' || $isAbnormal=='H' || $isAbnormal=='L' ){
			$labResult  = "<font color='red'>".(int)$wardVal['LaboratoryResult']['labResult']."</font>"  ;
		}else{
			$labResult  = (int)$wardVal['LaboratoryResult']['labResult']  ;
		}
		if($labOrder > 0)
			$labResUrl = array('controller'=>'laboratories','action'=>'labTestHl7List',$wardVal['Patient']['Patient']['id'],'?'=>array('return'=>'laboratories')) ;
		else
			$labResUrl = "#" ;

		echo $this->Html->link("$labResult/$labOrder",$labResUrl,array('escape' => false,'title' => 'Click to view result','style'=>'curson:pointer;'));
		?>
		</td>
		<td class="brown_img">
		
		<?php
		 if($isAbnormal=='A' || $isAbnormal=='H' || $isAbnormal=='L'){
			 if($wardVal['Patient']['Patient']['is_dr_chk']==0){
					echo $this->Html->link($this->Html->image('icons/red.png',array()), array('action'=>'dr_chk',$wardVal['Patient']['Patient']['id']), array('escape' => false));
			 }else{
					echo $this->Html->image('icons/green.png',array('style'=>'cursor:not-allowed;'));
			 }
		}else{
			echo $this->Html->image('icons/grey.png',array('style'=>'cursor:not-allowed;'));
		}?>
		</td>
		
		<td valign="middle" class="td_ht" id="rad_sec"><?php 
		$radOrder  	= (int)$wardVal['RadiologyTestOrder']['rad'] ;
		$radResult  = (int)$wardVal['RadiologyResult']['radResult'] ;
		if($radOrder > 0)
			$radResUrl = array('controller'=>'radiologies','action'=>'radiology_test_list',$wardVal['Patient']['Patient']['id'],'?'=>array('return'=>'radiologies')) ;
		else
			$radResUrl = "#" ;

		echo $this->Html->link("$radResult/$radOrder",$radResUrl,array('escape' => false,'title' => 'Click to view result','style'=>'curson:pointer;'));
		?>
		</td>

		<td valign="middle" class="td_ht" id="prob_sec"><?php echo $this->Html->link($this->Html->image('icons/search_icon.png',array('title'=>'Search Patient problems')),
					  			"javascript:problem(".$wardVal['Patient']['Patient']['id'].")",array('escape'=>false));?></td>
					  			
		<?php 
		if(isset($wardVal['vitalData']['Temperature Oral ']))
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
		if($toolTip == '')$toolTip = 'Not Entered';
		?>
		<td valign="middle" class="td_ht vitalImage tooltip" id="vital_img" title="<?php echo $toolTip ?>"></td>
		<?php $toolTip='';?>
	<!--  	<td valign="middle" class="cake_icon_sec">
		 
		<?php //echo $this->Html->link($this->Html->image('cake.icon.png',array('title'=>'Add insurance encounter')),
				//array('controller'=>'Insurances','action'=>'claimManager',$wardVal['Patient']['Patient']['id']),
				//array('escape' => false,'title' => 'insurance Encounter','style'=>'curson:pointer;'));
		/* echo $this->Html->link("Add insurance encounter",
				array('controller'=>'Insurances','action'=>'addNewEncounter',$wardVal['Patient']['Patient']['id']),
				array('escape' => false,'title' => 'insurance Encounter','style'=>'curson:pointer;')); */?></td>-->
		<?php echo $this->Form->end(); ?>
	</tr>
	<?php  $i++; 
} ?>
	<tr style="text-align: center;">
		<td colspan="14">
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

function problem(patient_id) {  
	if (patient_id == '') {
		alert("Something went wrong");
		return false;
	} 
	$("#Patientsid").val(patient_id);
	$.fancybox({ 
				'width' : '100%',
				'height' : '120%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe', 
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed")); ?>" + '/' + patient_id,
	});

}

</script>
