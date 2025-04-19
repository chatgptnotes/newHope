<?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));      
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js','slides.min.jquery.js','inline_msg.js',
		'jquery.isotope.min.js','jquery.custom.js','ibox.js','jquery.selection.js','jquery.autocomplete','ui.datetimepicker.3.js'));
?>
<style>
a.blueBtn {
	padding: 4px 3px;
}

.interIconLink .iconLink {
	min-height: 40px;
	line-height: 1;
}

.interIconLink {
	height: 82px;
}

.patient-info-btn {
	height: 23px;
}

.newqr-btn {
	background: #FF0000;
}


#msg {
    background-color: #000000;
    background-image: none;
    background-position: 2px 40%;
    background-repeat: no-repeat;
    border: 0px;
    border-radius: 0px;
    box-shadow: 0px;
    color: #000000;
    display: none;
    font-weight: bold;
    margin: 0.5em 0 1.3em;
    padding: 0px;
    position: absolute; 
    z-index: 200;
    width:25px;
}

.txtMsg{
	background-color: #EBF8A4;    
    background-position: 2px 40%;
    background-repeat: no-repeat;
    border: 1px solid #A2D246;
    border-radius: 5px;
    box-shadow: 0 1px 1px #FFFFFF inset;
    color: #000000; 
    font-weight: bold;
    margin: 0.5em 0 1.3em;
    padding: 5px 0 5px 18px;
    position: absolute;
    width: 150px;
    z-index: 200;
    
}
#rxframeid {
    text-align: center !important;
}

</style>

<?php
//BOF print OPD patient sheet
if(isset($this->params->query['registration']) && $this->params->query['registration']=='done'){
		echo "<script>var win = window.open('".$this->Html->url(array('action'=>'opd_patient_detail_print',$patient['Patient']['id']))."', '_blank',
				'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  </script>"  ;
		?>
<script>
	if (!win)
		alert("Please enabled popups to continue.");
	else {
		win.onload = function() {
			setTimeout(function() {
				if (win.screenX === 0) {
					alert("Please enabled popups to continue.");
				} else {
					// close the test window if popups are allowed.
					//window.location='<?php echo $this->Html->url(array('action'=>'patient_information',$patient['Patient']['id']));?>' ;  
				}
			}, 0);
		};
	}
</script>
<script>
$(window).scroll(function() {
    $('#closeimg').css('top', $(this).scrollTop() + "px");
});
</script>
<?php }
//EOF print OPD patinet sheet
?>
<div class="inner_title">
	<?php 
	$complete_name  = $patient[0]['lookup_name'] ;
	//echo __('Set Appoinment For-')." ".$complete_name;
	?>
	<h3>
		&nbsp;
		<?php echo __('Patient Information-')." ".$complete_name ?>
	</h3>
	<!-- <span> <?php /*

	if(isset($patient['Patient']['is_emergency']) AND $patient['Patient']['is_emergency'] == 1){
			echo $this->Html->link(__('Search Patient'),array('controller'=>'patients','action' => 'search','searchFor'=>'emergency','?'=>array('type'=>'emergency')), array('escape' => false,'class'=>'blueBtn'));
		} else {
			if(!empty($this->params->query) && (!isset($this->params->query['registration']))){
				echo $this->Html->link(__('Search Patient'),array('controller'=>'patients','action' => 'search','?'=>$this->params->query), array('escape' => false,'class'=>'blueBtn'));
			}else{
				echo $this->Html->link(__('Search Patient'),array('controller'=>'patients','action' => 'search','?'=>array('type'=>$patient['Patient']['admission_type'])), array('escape' => false,'class'=>'blueBtn'));
			}
		}*/
		?>
	</span> -->
</div>

<?php

if(!empty($errors)) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php 
		foreach($errors as $errorsval){
	         echo $errorsval[0];
	         echo "<br />";
	     }
	     ?>
		</td>
	</tr>
</table>
<?php } ?>

<div class="inner_left">
	<?php echo $this->element('patient_information');//&& $patient['Patient']['is_discharge']==0  ?>
	<div id='rxframeid'
		style='position: relative; display: none; align: center; top: 0px; overflow: hidden;'>
		<!--<div style="overflow: hidden;">
			<a class="closeimg" href="javascript:void(0)" onclick="javascript:closeRx();"
				title="Close"><img
				style="position: absolute; top:5px; right:176px;"
				src="<?php //echo $this->webroot?>img/fancy/fancy_close.png"
				alt="Close" title="Close" /> </a>
		</div>-->
		<iframe name="aframe" id="aframe" frameborder="0" onload="load();"></iframe>
        <div style="float:right;"><div style="overflow: hidden;">
			<a class="closeimg" href="javascript:void(0)" onclick="javascript:closeRx();"
				title="Close"><img
				style="position: absolute; top:-2px; right:176px;"
				src="<?php echo $this->webroot?>img/fancy/fancy_close.png"
				alt="Close" title="Close" /> </a>
		</div></div>
	</div>

	<table style="width: 100%">
		<tr>

			<td><?php    if($this->Session->read('role') !='doctor'){ ?>
				<div id="fun_btns" style="margin-top: 5px;">
					<table width="100%" border="0">
						<tr>
							<td valign="top" width="7%"><div class="patient-info-btn">

									<?php $usertype=$this->Session->read('facilityu',$facility['Facility']['usertype']);

												echo $this->Html->link(__('Edit MRN'),
												    array('action'=>'edit',$id,'?type='.$patient['Patient']['admission_type']),
												    array('escape' => false,'title'=>'Edit Patient','class'=>'blueBtn'));
													
														?>
								</div></td>

							<td valign="top" width="10%"><div class="patient-info-btn">

									<?php
			
									echo $this->Html->link(__('Edit EMPI Info.'),array("controller"=>"persons","action"=>"edit",$patient['Patient']['person_id'],$id),

								    array('escape' => false,'class'=>'blueBtn'));
							?>
								</div></td>


							<td valign="top" width="8%"><div class="patient-info-btn">
									<?php

									echo $this->Html->link(__('Past Visits'),
												    "/persons/patient_information/".$patient['Patient']['person_id'],
												    array('escape' => false,'title'=>'Past Visits','class'=>'blueBtn'));
											?>
								</div></td>
								
								<td valign="top" width="8%"><div class="patient-info-btn">
									<?php

									echo $this->Html->link(__('BMI Chart'),
												    "/persons/growth_chart/".$patient['Patient']['person_id'],
												    array('escape' => false,'title'=>'Past Visits','class'=>'blueBtn'));
											?>
								</div></td>
								<?php if($patient['Patient']['admission_type'] == 'IPD'){?>
							<td valign="top" width="8%"><div class="patient-info-btn">
									
									<?php echo $this->Html->link(__('Wrist Band'),
												     '#',
												     array('escape' => false,'class'=>'blueBtn','title'=>'Wrist Band','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'wrist_band',$id))."', '_blank',
												           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=100,left=400,top=400');  return false;"));
	    ?>
								</div></td><?php }?>
							<?php if($patient['Patient']['admission_type'] == 'OPD' && $isToken){ ?>
							<td valign="top" width="9%"><div class="patient-info-btn">
									<?php 
									echo $this->Html->link(__('View Token'),
												     '#',
												     array('escape' => false,'title'=>'View Token','class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_token',$id))."', '_blank',
												           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');  return false;"));
				   							?>
								</div></td>
							<?php } ?>
							<td valign="top" width="7%"><div class="patient-info-btn">
									<?php

									echo $this->Html->link(__('QR Card') ,
												     '#',
												     array('escape' => false,'title'=>'QR Card','class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'qr_card',$id))."', '_blank',
												           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');  return false;"));
				   							?>
								</div></td>
							<td id='medication-Qr' valign="top" width="10%"><div
									class="patient-info-btn">
									<?php
									//$style = $this->Session->read('newQRMedication') == true ? "blueBtn newqr-btn" : "blueBtn";

									echo $this->Html->link(__('QR Medication') ,
												     '#',
												     array('escape' => false,'title'=>'QR Medication','class'=>'blueBtn','id'=>'qrmedication','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'qr_medication',$id))."', '_blank',
												           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,left=400,top=300,height=300');  return false;"));
				   							?>
								</div></td>
							<td valign="top" width="8%"><div class="patient-info-btn">
									<?php
									echo $this->Html->link(__('QR Sticker') ,
												     '#',
												     array('escape' => false,'class'=>'blueBtn','title'=>'QR Sticker','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'qr_sticker_print',$id))."', '_blank',
												           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=800');  return false;"));
				   							?>
								</div></td>
							<td valign="top" width="8%"><div class="patient-info-btn">
									<?php
									echo $this->Html->link(__('Print Sheet'),
												     '#',
												     array('escape' => false,'class'=>'blueBtn','title'=>'Print Sheet','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'opd_patient_detail_print',$id))."', '_blank',
												           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,left=200,top=200,height=800');  return false;"));
				   							?>
								</div></td>
							<td valign="top" width="10%"><div class="patient-info-btn">
									<?php
									echo $this->Html->link(__('Send Referral'),'javascript:void(0)',array('onclick'=>'referalList("'.$id.'")','class'=>'blueBtn','div'=>false,'label'=>false));
									?>

								</div></td>
					
							<?php $fileName='files'.DS.'note_xml'.DS.'person_editcontent_'.$patient['Patient']['person_id'].'.txt';
							if(file_exists($fileName)){
			
									?>
							<td valign="top" width="10%"><div class="patient-info-btn">
									<?php 
									echo $this->Html->link(__('AuthorizeEMPI'),'javascript:void(0)',array('onclick'=>'authorize("'.$patient['Patient']['person_id'].'")','class'=>'blueBtn','div'=>false,'label'=>false));
									?>
								</div></td>
								
							<?php }?>
							<?php $fileName_patient='files'.DS.'note_xml'.DS.'patient_editcontent_'.$patient['Patient']['id'].'.txt';
							if(file_exists($fileName_patient)){
			
									?>
							<td valign="top" width="12%"><div class="">
									<?php 
									echo $this->Html->link(__('Authorize MRN'),'javascript:void(0)',array('onclick'=>'authorizeMRI("'.$patient['Patient']['id'].'")','class'=>'blueBtn','div'=>false,'label'=>false));
									?>
								</div></td>
								<?php }?>
							<?php echo $this->Form->create('User', array('type' => 'post','url' => 'https://preproduction.newcropaccounts.com/InterfaceV7/RxEntry.aspx','target'=>'aframe'));?>
						  	<td valign="top">
								<div class="patient-info-btn">
									<?php echo $this->Form->submit('Rx', array('class'=> 'blueBtn','style'=>'pading:0px;margin:0px;margin-top:-4px;','title'=>'Rx','id'=>'Rx', 'label'=> false,'div' => false)); ?>
								</div>
							</td> 
						</tr>
					</table>
					<table width="100%" border="0">
						<?php 	if($medication==0 ){?>
						<tr>

							<!-- medication & allergi checkbox added by vikas -->
							<td><?php echo $this->Form->checkbox('NewCropPrescription.uncheck',array('id'=>'uncheck','style'=>'float:left','onclick'=>"javascript:save_checkinfo();"));?>
								<label style="width: auto; padding-top: 3px; text-align: left;">No
									Active Med</label>
							</td>
						</tr>
						<?php }?>
						<?php 	if($allergy==0 ){?>
						<tr>
							<td><?php echo $this->Form->checkbox('NewCropAllergies.allergycheck',array('id'=>'allergycheck','style'=>'float:left ','onclick'=>"javascript:save_checkallergy();"));?>
								<label style="width: auto; padding-top: 3px; text-align: left;">No
									Active Allergies</label></td>
						</tr>
						<?php }?>
						<!-- <tr>
							<td align="center"><div
									style="text-align: center; margin: 15px 0px 0px 5px; display: none;"
									class="loader">
									<?php echo $this->Html->image('indicator.gif'); ?>
								</div></td>
						</tr> -->
					</table>
					<table width="100%" border="0">

						<tr>
							<td colspan="8" style="display: none"><textarea id="RxInput"
									name="RxInput" rows="33" cols="79">
									<?php echo $patient_xml?>
								</textarea></td>
						</tr>


						<?php echo $this->Form->end();?>


					</table>
				</div> <?php }else{ ?>
				<div id="fun_btns">
					<table>
						<tr>
							<td><?php
							echo $this->Html->link(__('Edit Patient Information'),
												    array('action'=>'edit',$id,'?'=>$this->params->query),
												    array('escape' => false,'class'=>'blueBtn'));
											?>
							</td>
							<td><?php
							echo $this->Html->link(__('Previous Visit Details'),
												    "/persons/patient_information/".$patient['Patient']['person_id'],
												    array('escape' => false,'class'=>'blueBtn'));
											?>
							</td>
						</tr>
					</table>
				</div> <?php } ?>
			</td>
		</tr>
	</table>
	<table style="width: 100%;">
		<tr>
			<td style="width: 65%" valign="top">
				<!-- ------------------------------------------------------- Consolidated Interaction please check Rx. -->
				<?php 
				//echo $CDS_Data_Cosoli; exit;
				if($CDS_Data_Cosoli=='1'){
				if(($age >='2' || $age <='20') && ($pulse >='90') &&($cosoli=='Epilepsy') && ($Status!='0')){?>
				<div class="inner_left" id="list_content">
					<div class="inner_title">
						<h3>Consolidated Interaction please check Rx.</h3>
					</div>
					<?php }
			}?>
					<?php
					//-------------------------Durg Allergies interaction please check Rx.------------------
					//debug($CDS_Data_Drug['0']['ClinicalSupport']['dmc']);
					//debug($CDS_Data_Drug['0']['ClinicalSupport']['com_e']);
					//debug($CDS_Data_Drug['0']['ClinicalSupport']['age_e']);
					//debug($CDS_Data_Drug['0']['ClinicalSupport']['dmc']);
					if($CDS_Data_Drug['dmc']=='1' ){
				if(!empty($interaction_elder) ){  ?>
					<!--  <div class="inner_left" id="list_content">
					<div class="inner_title">
						<h3>'onClick'=>"javascript:infolab('$lab_id')"Durg Allergies interaction please check Rx.</h3>
					</div>  -->
					<script> 
							jQuery(document).ready(function(){ 
								drug_medication_allergies() ;
							}) ;  
					</script>
					<?php }
			}?>
					<!-- ----------------------end--Durg Allergies interaction please check Rx.-- -->
					<!-- Start of Facesheet--Gaurav(Baisc) and aditya(Modified)-->

					<div class="inner_left" id="list_content">
						<div class="inner_title">
							<h3>Facesheet</h3>

						</div>
						<div class="inner_left" id="list_content">
							<div class="inner_title">
								<table>
									<tr>
										<td style="font-size: 12px;"><strong> <?php 
										//echo"<pre>";print_r($patient['Patient']['id']);exit;
										$pat_uid = $patient['Patient']['id'];
										echo $this->Html->link(__('Hemoglobin Chart'),'#',array('escape'=>false,'id'=>'pres_hgb','onClick'=>"pres_hgb('$pat_uid')"));
										//echo $this->Html->link(__('Add UID Patient'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
										?>
										</strong>
										</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td style="font-size: 12px;"><strong> <?php 
										//echo"<pre>";print_r($patient['Patient']['id']);exit;
										$pat_uid = $patient['Patient']['id'];
										echo $this->Html->link(__('CBC Chart'),'#',array('escape'=>false,'id'=>'pres_cbc','onClick'=>"pres_cbc('$pat_uid')"));
										//echo $this->Html->link(__('Add UID Patient'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
										?>
										</strong>
										</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td style="font-size: 12px;"><strong> <?php 
										//echo"<pre>";print_r($patient['Patient']['id']);exit;
										$pat_uid = $patient['Patient']['id'];
										echo $this->Html->link(__('Blood Sugar Chart'),'#',array('escape'=>false,'id'=>'pres_glucose','onClick'=>"pres_glucose('$pat_uid')"));
										//echo $this->Html->link(__('Add UID Patient'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
										?>
										</strong>
										</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<!--  <td style= "font-size: 12px;"><strong>
												<?php 
												//echo"<pre>";print_r($patient['Patient']['id']);exit;
													$pat_uid = $patient['Patient']['id'];
													//echo $this->Html->link(__('LFT Chart'),'#',array('escape'=>false,'id'=>'chart_lft','onClick'=>"chart_lft('$pat_uid')"));
											   		//echo $this->Html->link(__('Add UID Patient'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
												?></strong>
											</td>-->
									</tr>
								</table>
							</div>
						</div>

						<table width="100%" cellpadding="0" cellspacing="0" border="0"
							class="formFull formFullBorder">
							<tr>
								<td width="50%" valign="top">
									<table width="100%" cellpadding="0" cellspacing="0" border="0"
										class="formFull formFullBorder" valign="top">

										<tr>
											<th><strong><?php echo __("Problems");?> </strong></th>
										</tr>
										<tr>
											<td id="getProblemInfo" width="100%"></td>
										</tr>
									</table>
								</td>
								<td width="50%" valign="top">
									<table width="100%" cellpadding="0" cellspacing="0" border="0"
										class="formFull formFullBorder" valign="top">

										<tr valign="top">

											<th><strong> <?php echo __("Medication");?>
											</strong></th>

										</tr>
										<tr>
											<td id="getMedicationInfo" width="100%"></td>
										</tr>
									</table>

								</td>
							</tr>
						</table>

						<table width="100%" cellpadding="0" cellspacing="0" border="0"
							class="formFull formFullBorder">
							<tr>
								<td width="50%" valign="top">
									<table width="100%" cellpadding="0" cellspacing="0" border="0"
										class="formFull formFullBorder" valign="top">

										<tr>
											<th><strong><?php echo __("Allergies");?> </strong></th>
										</tr>
										<tr>
											<td id="getAllergyInfo" width="100%"></td>
										</tr>
									</table>
								</td>
								<td width="50%" valign="top">
									<table width="100%" cellpadding="0" cellspacing="0" border="0"
										class="formFull formFullBorder" valign="top">

										<tr valign="top">

											<th><strong> <?php echo __("Lab");?>
											</strong></th>

										</tr>
										<tr>
											<td id="getLabInfo" width="100%"></td>
										</tr>
									</table>

								</td>
							</tr>
						</table>

						<table width="100%" cellpadding="0" cellspacing="0" border="0"
							class="formFull formFullBorder">
							<tr>
								<td width="100%" valign="top">
									<table width="100%" cellpadding="0" cellspacing="0" border="0"
										class="formFull formFullBorder" valign="top">

										<tr>
											<th><strong><?php echo __("Patient Medical History");?> </strong>
											</th>
										</tr>
										<tr>
											<td id="getSignificantHistoryInfo" width="100%"></td>
										</tr>
									</table>
								</td>

							</tr>
						</table>



					</div>
					<!-- EOF FaceSheet -->
			
			</td>
		</tr>
	</table>
</div>
<div id="loading-indicator" style="display: none">
	<?php echo $this->Html->image('/img/icons/loading-indicator.gif',array('alt'=>'Loading','title'=>'Loading'))?>
</div>
<div id="loading-text" style="display: none">
	<span class="txtMsg"> No Record Found </span>
</div>
<?php echo $this->Js->writeBuffer();?>
<script>

				
var cds_age = "<?php echo $CDS_Data_Drug['age_e'];?>";		
var age = "<?php echo $age;?>";
var dmc = "<?php echo $CDS_Data_Drug['dmc'];?>";
var getLabInfoUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "getLabInfo",$patient['Patient']['id'],"admin" => false)); ?>";
var getProblemInfoUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "getProblemInfo",$patient['Patient']['id'],"admin" => false)); ?>";
var getMedicationInfoUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "getMedicationInfo",$patient['Patient']['id'],$patient['Patient']['patient_id'],"admin" => false)); ?>";
var getAllergyInfoUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "getAllergyInfo",$patient['Patient']['id'],$patient['Patient']['patient_id'],"admin" => false)); ?>";
var getgetElderlyInfoUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "getElderlyInfo",$patient['Patient']['id'],"admin" => false)); ?>";
var getSignificantHistoryUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "getSignificantHistory",$patient['Patient']['id'],$patient['Person']['sex'],"admin" => false)); ?>";

function closeRx(){
	document.getElementById('rxframeid').style.display='none';
	 getProblemInfo();   
     getLabInfo();
     getMedicationInfo();
     getAllergyInfo();
  //   getgetElderlyInfo();
    
	 
}
 	
$(document).ready(function () {

	var sessionValue ="<?php echo $_SESSION['role']; ?>"
	var doctorLabel ="<?php echo Configure :: read('doctorLabel'); ?>"
	var adminLabel ="<?php echo Configure :: read('adminLabel'); ?>"
	if(sessionValue==doctorLabel || sessionValue==adminLabel){
	var chk=confirm('Do you wish to add new note?');
	if(chk==true){
		window.location.href = '<?php echo $this->Html->url(array('controller'=>'patients','action' => 'notesadd', $patient['Patient']['id']));?>';
	}else{
	}
	}
	
//set cookie for dragon	
document.cookie = "NUSA_Guids=dba4119d-29b9-46ff-9c43-6de3154d8017/d4f0ef09-008b-4874-b04a-7e32d3d33bfe";
	  	 
	   
	     getProblemInfo();   
	     getLabInfo();
	     getMedicationInfo();
	     getAllergyInfo();
	     getgetElderlyInfo();
	     getSignificantHistory();
	     
	 });

//-*-gaurav
function getLabInfo(){
			$.ajax({
	    	     type: 'POST',
	    	     url: getLabInfoUrl,
	    	     //data: formData,
	    	     dataType: 'html',
	    	     async: true,
	    	     success: function(data){
	    	    	//alert(data);
		    	    	$("#getLabInfo").html(data);
		    	    	return false ;
	    	     },
	    			error: function(message){
	    	        /// alert(message);
	    	         return false ;
	    	        },
	    	        beforeSend:function(){
	    	        	$("#getLabInfo").html("<table><tr><td>Loading Lab Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
	    	        },
	    	        complete:function(){
	    	        	//$("#getLabInfo").html("Loading Lab Information");
		    	    }        
	    	  });
	     }

	     function getProblemInfo(){ 
				$.ajax({
		    	     type: 'POST',
		    	     url: getProblemInfoUrl,
		    	     //data: formData,
		    	     dataType: 'html',
		    	     async: true,
		    	     success: function(data){
		    	    	//alert(data);
			    	    	$("#getProblemInfo").html(data);
			    	    	return false ;
		    	     },
		    			error: function(message){
		    	         //alert(message);
		    	         return false ;
		    	        },
		    	        beforeSend:function(){
		    	        	$("#getProblemInfo").html("<table><tr><td>Loading Problem Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
		    	        },
		    	        complete:function(){
		    	        	//$("#getLabInfo").html("Loading Lab Information");
			    	    }        
		    	  });
		     }

	     function getMedicationInfo(){
	    		
				$.ajax({
				
		    	     type: 'POST',
		    	     url: getMedicationInfoUrl,
		    	     //data: formData,
		    	     dataType: 'html',
		    	     async: true,
		    	     success: function(data){
		    	    	
			    	    	$("#getMedicationInfo").html(data);
			    	    	return false ;
		    	     },
		    			error: function(message){
		    	         //alert(message);
		    	         return false ;
		    	        },
		    	        beforeSend:function(){
		    	        	$("#getMedicationInfo").html("<table><tr><td>Loading Medication Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
		    	        },
		    	        complete:function(){
		    	        	//$("#getLabInfo").html("Loading Lab Information");
			    	    }        
		    	  });
		     }

	     function getAllergyInfo(){
				$.ajax({
		    	     type: 'POST',
		    	     url: getAllergyInfoUrl,
		    	     //data: formData,
		    	     dataType: 'html',
		    	     async: true,
		    	     success: function(data){
		    	    	//alert(data);
			    	    	$("#getAllergyInfo").html(data);
			    	    	return false ;
		    	     },
		    			error: function(message){
		    	       ///  alert(message);
		    	         return false ;
		    	        },
		    	        beforeSend:function(){
		    	        	$("#getAllergyInfo").html("<table><tr><td>Loading Allergy Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
		    	        },
		    	        complete:function(){
		    	        	//$("#getLabInfo").html("Loading Lab Information");
			    	    }        
		    	  });
		     }

	     function getgetElderlyInfo(){
				$.ajax({
		    	     type: 'POST',
		    	     url: getgetElderlyInfoUrl,
		    	     //data: formData,
		    	     dataType: 'html',
		    	     async: true,
		    	     success: function(data){
		    	    	if(dmc == 1){
		    	    		if((data == true) && (age>=cds_age ) ){ 
		    	    			drug_medication_allergies() ;
		    	    		}
		    	    	}
		    	     },
		    			error: function(message){
		    	       //  alert(message);
		    	         return false ;
		    	        },
		    	        beforeSend:function(){
		    	        	$("#getgetElderlyInfo").html("<table><tr><td>Loading Elderly Medication Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
		    	        },
		    	        complete:function(){
		    	        	//$("#getLabInfo").html("Loading Lab Information");
			    	    }        
		    	  });
		     }

	     function getSignificantHistory(){//alert('<?php echo $patient['Patient']['sex']?>');
	    	 $.ajax({
	    	     type: 'POST',
	    	     url: getSignificantHistoryUrl,
	    	     //data: formData,
	    	     dataType: 'html',
	    	     async: true,
	    	     success: function(data){
	    	    	//alert(data);
		    	    	$("#getSignificantHistoryInfo").html(data);
		    	    	return false ;
	    	     },
	    			error: function(message){
	    	       ///  alert(message);
	    	         return false ;
	    	        },
	    	        beforeSend:function(){
	    	        	$("#getSignificantHistoryInfo").html("<table><tr><td>Loading Medication Information....&nbsp;&nbsp;&nbsp;</td><td>"+$("#loading-indicator").html()+"</td></tr></table>");
	    	        },
	    	        complete:function(){
	    	        	//$("#getLabInfo").html("Loading Lab Information");
		    	    }        
	    	  });
		     }
//--
				
	jQuery(document)
			.ready(

		
					
					function() {
						$('#dischargebyconsultant')
								.click(
										function() {
											$
													.fancybox({
														'width' : '80%',
														'height' : '90%',
														'autoScale' : true,
														'transitionIn' : 'fade',
														'transitionOut' : 'fade',
														'type' : 'iframe',
														'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "child_birth", $patient['Patient']['id'])); ?>"
													});

										});
						$("#prescriptionLink").click(function() {

							window.location.href = "#list_content";

						});

					});
	jQuery(document).click(function() {
		$("a").click(function() {
			$("form").validationEngine('hide');
		});

	});

	//----------GAURAV---- and aditya--------

	function getDxHistory(){
		$.fancybox({
			'width' : '70%',
			'height' : '100%',
			'autoScale' : true,
			'background':'#1B1B1B',
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'onComplete' : function() {
				$("#dxhistory").css({
					'top' : '20px',
					'bottom' : 'auto',
					
				});
			},
			'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "dxhistory",$patient['Patient']['id'])); ?>"
			
		});
	}

	function getAllergies(){
		$.fancybox({
			'width' : '70%',
			'height' : '100%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'onComplete' : function() {
				$("#allergies").css({
					'top' : '20px',

					'bottom' : 'auto',	
					
});
			},
			'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "allallergies",$patient['Patient']['id'],0,0,$patient['Patient']['patient_id'])); ?>"

		});
	}
	
	$('#allergies')
			.click(
					function() {
						//	var patient_id = $('#selectedPatient').val();

						
								

					});
	
	function getRxHistory(){
		$.fancybox({
			'width' : '70%',
			'height' : '100%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'onComplete' : function() {
				$("#allergies").css({
					'top' : '20px',
					'bottom' : 'auto',
					
				});
			},
			'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "rxhistory",$patient['Patient']['id'],$patient['Patient']['patient_id'])); ?>"

		});
	}

	$('#pres_det1')
	.click(
			function() {
				//	var patient_id = $('#selectedPatient').val();

				
						$.fancybox({
							'width' : '70%',
							'height' : '100%',
							'autoScale' : true,
							'transitionIn' : 'fade',
							'transitionOut' : 'fade',
							'type' : 'iframe',
							'onComplete' : function() {
								$("#allergies").css({
									'top' : '20px',
									'bottom' : 'auto',
									
								});
							},
							'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "prescriptionDetails",$patient['Patient']['id'])); ?>"

						});

			});

	function getPresDetails(count){
		$.fancybox({
			'width' : '70%',
			'height' : '100%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'onComplete' : function() {
				$("#allergies").css({
					'top' : '20px',
					'bottom' : 'auto',
					
				});
			},
			'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "prescriptionDetails",$patient['Patient']['id'])); ?>" + '/' + count

		});
	}

	function load() { 

		/*document.getElementById("aframe").style.height="780px";
		document.getElementById("aframe").style.width="980px";
		document.getElementById("rxframeid").style.display="block";*/
		document.getElementById("aframe").style.height = "780px";
		document.getElementById("aframe").style.width = "76%";
		jQuery(".loader").hide();

	}


		jQuery("#Rx").click(function() {
		
			jQuery(".loader").show();
			document.getElementById("aframe").style.height = "0px";
			document.getElementById("aframe").style.width = "0px";
			document.getElementById("rxframeid").style.display = "block";
			
			//$("#aframe").contents().scrollTop( $("#aframe").contents().scrollTop() + 300 );
		});
		

		function icdwin(name,id) {
			
			
			var patient_id = $('#Patientsid').val();
			
			if (patient_id == '') {
				alert("Please select patient");
				return false;
			}
			$
					.fancybox({

						'width' : '50%',
						'height' : '100%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "infobutton")); ?>" + '/' + name + '/'+id
								
					});}
	//	function infomedication(name) {

			$('.infomedication').live('click',function(){ 
				id = $(this).attr('id') ;
				drug_id = $(this).attr('drug_id') ;
				var medication_name=$(this).attr('name');
				var name_med=medication_name.replace("/","~");
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "infomedication")); ?>"; 
	            
			    $.ajax({
				     type: 'POST',
				     url:  ajaxUrl  + '/' + drug_id,
				     dataType: 'html',
				     beforeSend:function(){ 
				    	 inlineMsg(id,$("#loading-indicator").html(),10); 
		    	     },
				     success: function(data){		
				    	  data = data.trim();	
				    	  	 
				    	  if(data != ''){
				    		  inlineMsg(id,'');
				    		  var win=window.open(data, '_blank');
				    		  win.focus();
					      }else{
					    	  inlineMsg(id,$('#loading-text').html(),10); 
					    	 
					      }
				     },
					 error: function(message){
						  inlineMsg(id,$('#loading-text').html(),5); 	     
						   
				     }        
				});
			});
		//}
		 
 
		$('.infolab').live('click',function(){ 
		 	 
		 	id= $(this).attr('id') ;
		 	name = $(this).attr('id') ;
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "infolab")); ?>"; 
			
		    $.ajax({
			     type: 'POST',
			     url:  ajaxUrl  + '/' + name ,
			     dataType: 'html',
			     beforeSend:function(){ 
			    	 inlineMsg(id,$("#loading-indicator").html(),10); 
	    	     },
			     success: function(data){	
			    	  data = data.trim();		    	 
			    	  if(data != ''){
			    		  inlineMsg(id,'');
			    		  var win=window.open(data, '_blank');
			    		  win.focus();
				      }else{ 
				    	  inlineMsg(id,$('#loading-text').html(),10); 	
				      }
			     },
				 error: function(message){
					  inlineMsg(id,$('#loading-text').html(),5); 
			     }        
			});

		});
		
		function drug_medication_allergies() {
			//alert();
					$
					.fancybox({

						'width' : '50%',
						'height' : '100%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "drug_medication_allergies")); ?>"
								
					});}

		
		
//-------checkbox js code--------
function save_checkinfo(){

	if($('#uncheck').attr('checked')) 
		{
   	     var checkrx=1; 
   	
      }
  else
  {
	  var checkrx=0; 
       }

patientid="<?php echo $patient['Patient']['id']?>";
patient_uid="<?php echo $patient['Patient']['patient_id']?>";

var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "save_checkinforx",$patientid,$checkrx,$patient_uid,"admin" => false)); ?>";



    $.ajax({
     type: 'POST',
     url: ajaxUrl+"/"+patientid+"/"+checkrx+"/"+patient_uid,
     //data: formData,
     dataType: 'html',
     success: function(data){
    	 //alert(hello);
     },
		error: function(message){
         alert(message);
         
     }        });

}


function save_checkallergy(){

	if($('#allergycheck').attr('checked')) 
		{
   	     var checkall=1; 
   	
      }
  else
  {
	  var checkall=0; 
       }

patientid="<?php echo $patient['Patient']['id']?>";
patient_uid="<?php echo $patient['Patient']['patient_id']?>";

var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "save_checkinfoallergy",$patientid,$checkall,$patient_uid,"admin" => false)); ?>";



    $.ajax({
     type: 'POST',
     url: ajaxUrl+"/"+patientid+"/"+checkall+"/"+patient_uid,
     //data: formData,
     dataType: 'html',
     success: function(data){
    	 //alert(hello);
     },
		error: function(message){
         alert(message);
     }        });


}

var ajaxcreateCredentialsUrl ="<?php echo $this->Html->url(array("controller" => "messages", "action" => "createCredentials","admin" => false)); ?>"; ;//

function createPatientCredentials(patientid){

	$
	.fancybox({
		'width' : '50%',
		'height' : '50%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller" => "messages", "action" => "openFancyBox", $patient['Patient']['person_id'],$patient['Patient']['id'])); ?>"
	});
	 
}

function pres_hgb(patientid){

	$
	.fancybox({
		'width' : '70%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		css : {
            'border-color' : '#000' 
        },
		'onComplete' : function() {
			$("#allergies").css({
				top : '20px',
				bottom : auto,
				position : absolute
			});
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "hgb_chart")); ?>"
		+ '/' + patientid+'/'+"<?php echo $patient['Patient']['patient_id']?>"
		


	});
		 
	}

function pres_cbc(patientid){

	$
	.fancybox({
		'width' : '70%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		css : {
            'background-color' : '#f00' 
        },
		'onComplete' : function() {
			$("#allergies").css({
				top : '20px',
				bottom : auto,
				position : absolute
			});
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "cbc_chart")); ?>"
		+ '/' + patientid+'/'+"<?php echo $patient['Patient']['patient_id']?>"
		


	});
		 
	}

function pres_glucose(patientid){

	$
	.fancybox({
		'width' : '70%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		css : {
            'background-color' : '#f00' 
        },
		'onComplete' : function() {
			$("#allergies").css({
				top : '20px',
				bottom : auto,
				position : absolute
			});
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "glucose_chart")); ?>"
		+ '/' + patientid+'/'+"<?php echo $patient['Patient']['patient_id']?>"
		


	});
		 
	}

function chart_lft(patientid){

	$
	.fancybox({
		'width' : '70%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'onComplete' : function() {
			$("#allergies").css({
				top : '20px',
				bottom : auto,
				position : absolute
			});
		},
		'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "lft_chart")); ?>"
		+ '/' + patientid+'/'+"<?php echo $patient['Patient']['patient_id']?>"
		


	});
		 
	}

jQuery("#nursing_hub").click(function() {
	 if ( $('#nursingElement').css('display') == 'none'){
		 $('#nursingElement').fadeIn('slow');
		 }else{
			 $('#nursingElement').hide();
		 }

	 return false ;
});
function referalList(id) { 
	$
			.fancybox({

				'width' : '70%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Messages", "action" => "referalList")); ?>"+"/"+id,
				//'onClosed':function (){/
					//window.top.location.href = '<?php echo $this->Html->url("/patients/orders"); ?>'+"/"+id+"/"+1;
				//}		
			});

}
function authorize(fileName) { 
	$
			.fancybox({

				'width' : '40%',
				'height' : '40%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "PatientAccess", "action" => "authorize")); ?>"+"/"+fileName,
						
			});

}
function authorizeMRI(fileName) {
	$
			.fancybox({

				'width' : '40%',
				'height' : '40%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "PatientAccess", "action" => "authorizeMRN")); ?>"+"/"+fileName,
						
			});

}

</script>
