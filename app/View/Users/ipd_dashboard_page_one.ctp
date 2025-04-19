<?php echo $this->Html->script('jquery.fancybox-1.3.4','jquery.tooltipster.min.js');
	echo $this->Html->css('jquery.fancybox-1.3.4.css','tooltipster.css');
    $website = $this->Session->read('website.instance');
?>
<?php if(!empty($this->params->query['print'])){?>
<html moznomarginboxes mozdisallowselectionprint>
<?php }?>
<style>

.td_ht {
	line-height: 30px;
	
}
.table_format1 th {
	 background: #d2ebf2 none repeat scroll 0 0 !important;
	padding-right: 10px;
	font-size: 37px; 
	font-weight: bold;
	color:#31859c;
	
}

.table_format1 td {
	padding-bottom:3px;
	padding-right: 10px;
	font-size: 37px; 
	font-weight: bold;
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
<?php 
$role = $this->Session->read('role');
?>
<body>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="table_format1">
	
	<tr class="row_title">
		<th width="30%" valign="top" align="left" class="table_cell" style="padding-left: 10px;">ROOM / BED</th>
	  	<th  valign="top" align="center" class="table_cell"><?php  echo __('REGISTRATION DATE', true);?></th>
	  	<!--  <th width="5%" valign="top" class="table_cell">LOS</th>-->
		<th width="2%" valign="top" class="table_cell"></th>
		<th width="30%" valign="top" class="table_cell" align="left"><?php  echo __('PATIENT', true);?></th>
		<!--  <th valign="top" class="table_cell">TARIFF</th>-->
		<th valign="top" class="table_cell"><?php  if(strtolower($role)==strtolower(Configure::read('adminLabel'))) { ?>
		<span>PHYSICIAN<br></span><?php } ?></th>
	</tr>
	<?php 
	$i=0;
	$currentWard =0;
	//count no of bed per ward
	$level = array(1=>'I','2'=>'II','3'=>'III','4'=>'IV','5'=>'V');
	$status = array('Admitted'=>'Admitted','Posted For Surgery'=>'Posted For Surgery','Operated'=>'Operated','Discharged'=>'Discharged');
	
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
		<td class="td_ht" style="padding-left: 10px;">
		<?php echo $wardVal['Patient']['Ward']['name']." / ". $wardVal['Patient']['Room']['bed_prefix'].$wardVal['Patient']['Bed']['bedno'];?>
		</td>
		<td class="td_ht" align="center" ><?php echo $this->DateFormat->formatDate2Local(trim($wardVal['Patient']['Patient']['form_received_on']),Configure::read('date_format'),false); ?> </td> 	
		
		<!--  <td align="center" class="td_ht"><?php 
		
		$form_received_on_date= $this->DateFormat->formatDate2Local($wardVal['Patient']['Patient']['form_received_on'],Configure::read('date_format'),true);
		$date_new=$this->DateFormat->formatDate2STDForReport($form_received_on_date,Configure::read('date_format'));
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
		</td>-->
						
		<?php 
		if(strtolower($wardVal['Patient']['Person']['sex'])=='male'){
			echo '<td align="center" class="td_ht maleImage"></td>';
		}
		if(strtolower($wardVal['Patient']['Person']['sex'])=='female'){
			echo '<td align="center" class="td_ht femaleImage"></td>';
		}
		if($wardVal['Patient']['Person']['sex']==''){
			echo '<td align="center" class="td_ht">&nbsp;</td>';
			}?>
			
		
		<td valign="middle" align="left">
			<?php
			echo ucwords(strtolower($wardVal['Patient']['Patient']['lookup_name']));
			?>
		</td>
		<!--  <td valign="middle" ><?php echo $this->General->getCurrentAge($wardVal['Patient']['Person']['dob'])?></td>
		<td align="center" class="td_ht"><?php echo $wardVal['Patient']['Patient']['admission_id'];?></td>
		<td align="center" class="td_ht" ><?php echo $wardVal['Patient']['TariffStandard']['name'];?></td>-->
		<!--  <td align="center" class="td_ht"> <?php echo $wardVal['Patient']['CorporateSublocation']['name']==''?'-':$wardVal['Patient']['CorporateSublocation']['name'];?></td>
		<td align="center" class="td_ht" >
		<?php 
		if($wardVal['Patient']['Patient']['is_discharge']=='1'){
			  $patientStatus = 'Discharged';
		}elseif(!empty($wardVal['Patient']['OptAppointment']['patient_id']) && $wardVal['Patient']['OptAppointment']['procedure_complete']!="1"){
              $patientStatus = 'Posted For Surgery';
        }elseif($wardVal['Patient']['OptAppointment']['procedure_complete']=="1"){
              $patientStatus = 'Operated';
		}else{
			  $patientStatus = $wardVal['Patient']['Patient']['dashboard_status'];
		}
        if($patientStatus==''){
			  $patientStatus = '-';
		}
		 echo $patientStatus;
         ?>

		</td>-->
		<td align="center" class="td_ht" style="padding-left: 10px;"><?php // if(strtolower($role)==strtolower(Configure::read('adminLabel'))) { ?>
			
			<?php 
				if($wardVal['Patient']['Patient']['is_discharge']=='1'){
					$disbled="disabled"; 	//if Discharge
				 }else { //for non-discharge , else part for vadodara if patient haven't alloted any bed then make task dropdown blank-Atul
					 $disbled="";
	             	if($website == 'vadodara' && $wardVal['Patient']['Bed']['bedno'] == '') {
						$taskOptions = '';
	                 } 
				}
				
				$doctorId = 'doctor_'.$wardVal['Patient']['Patient']['id'];
				echo $this->Form->input('doctor_id',array('style'=>'width:310px;height:45px;font-size:30px','type'=>'select','options'=>$doctors,
				'empty'=>"Select Physician",'value'=>$wardVal['Patient']['Patient']['doctor_id'],'class'=>'doctor hover common','id'=>$doctorId,'disabled'=>$disbled));?>
			
		</td>
		<?php echo $this->Form->end(); ?>
	</tr>
	<?php  $i++; 
} ?>
	
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
	}else if(value=='Death'){
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
		getViewSticker($(this).attr('patient_id'));
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
		'href' : "<?php echo $this->Html->url(array("controller"=>"Patients", "action" => "patient_sticker_id")); ?>"+"/"+patientId,
	});
}
</script>
