<?php $corporateStatus = Configure::read('corporateStatus');?>
<style>
.textBoxExpnd1 {
	width: 60%;
}

.textBoxExpnd {
	width: 80%;
}

input,select,textarea {
	float: left;
}

.btn_align {
	margin: 0 10px;
	display: none;
}

.txtbx_align {
	width: 23% !important;
}

.txtpad_align {
	padding-left: 0px !important;
}
</style>

<?php
//echo $this->Html->script(array('jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','jquery.ui.slider.js','jquery-ui-timepicker-addon.js'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'/* ,'jquery.autocomplete.css' */ ));
//echo $this->Html->script(array('jquery.autocomplete','jquery.autocomplete.js'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
//BOF pankaj
$queryStr = strtolower($this->params->query['type']) ;//For emergency option only.

if($queryStr == 'emergency'){
	$redStar = '';
	$validateDate =	"" ;
	$validateTreating='';

}else{
	$validateDate =	"validate[required,custom[mandatory-date]]" ;
	$validateTreating =	"validate[required,custom[mandatory-select]]" ;
	$redStar = '<font color="red">*</font>';
}

if($this->params->query['type'] == "IPD"){
	$type =  'Inpatient Registration';
	$buttonLabel = "Submit";
	$extraButton='';
}else if($this->params->query['type'] == "LAB"){
	$type =  'Laboratory Registration';
	$buttonLabel = "Submit";
	$extraButton='';

}else if($this->params->query['type'] == "RAD"){
	$type =  'Radiology Registration';
	$buttonLabel = "Submit";
	$extraButton='';
} else if($queryStr == "emergency"){
	$type =  'Emergency Patient Registration';
	$buttonLabel = "Submit";
	$extraButton ='';
}else{
                       $type =  'Outpatient Registration';
                       $buttonLabel = "Submit";
                       $extraButton = "Submit & Print Sheet";
            }
            //EOF pankaj
            ?>
<div class="inner_title">
	<h3>
		<?php echo $type; ?>
	</h3>
	<!-- 	<span> <?php echo $this->Html->link(__('Search Patient'),array('action' => 'search' ,"?"=>$this->params->query), array('escape' => false,'class'=>'blueBtn'));

	?>

	</span> -->
</div>
<?php  
if($someData){
			$personID=$someData['Person']['id'];
			$lookupName=$someData['Person']['first_name']." ".$someData['Person']['last_name'];
			$age=$someData['Person']['age'];
			$dob=$someData['Person']['dob'];
			$sex=strtolower($someData['Person']['sex']);
		}
		if($this->data){
			$personID=$this->data['Patient']['person_id'];
			$lookupName=$this->data['Patient']['full_name'];
			$patientUid=$this->data['Patient']['patient_id'];
			$age=$this->data['Patient']['age'];
			$sex=strtolower($this->data['Patient']['sex']);
			$doctor_id=$this->data['Patient']['doctor_id'];
			$department_id=$this->data['Patient']['department_id'];
			$tariffID=$this->data['Patient']['tariff_standard_id'];
			$is_staff_register = $this->data['Patient']['is_staff_register'];
	}
	?>
<?php echo $this->Form->create('Patient',array('type' => 'file','id'=>'patientfrm','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
if(!empty($someData['Person']['coupon_name']) and !empty($someData['Person']['coupon_amount']))
{
	echo $this->Form->hidden('coupon_name',array('value'=>$someData['Person']['coupon_name']));
	echo $this->Form->hidden('coupon_amount',array('value'=>$someData['Person']['coupon_amount']));
}
if(!empty($this->data['Patient']['is_staff_register'])){
	echo $this->Form->hidden('is_staff_register',array('id'=>'staffRegistration','value'=>$is_staff_register)); // if patient is staff then maintain is_staff_register field
}
echo $this->Form->hidden('patient_id',array('id'=>'patientID','value'=>$patientUid));
echo $this->Form->hidden('admission_type', array('value'=>$this->params->query['type']));
if(isset($someData)){
				echo $this->Form->hidden('person_id',array('value'=>$personID,'id'=>'personID'));
			}else{
				echo $this->Form->hidden('person_id',array('id'=>'personID'));
			}

			echo $this->Form->hidden('is_discharge',array('value'=>0));
			?>
<?php 
if(!empty($errors)) {
		?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"
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
<div
	class="inner_left">
	<?php //BOF new form design ?>
	<!-- form start here -->
	<div class="" style="margin-right: 0; padding: 17px 0 19px 726px;">
		<?php if($this->params->query['packaged']){?>
		<input class="blueBtn" type="button" value="Cancel"
			onclick="window.location='<?php echo $this->Html->url(array("controller" => "Estimates", "action" => "residentDashboard"));?>'">
		<?php }elseif(($this->params->pass[0]) != ''){?>
		<input class="blueBtn" type="button" value="Cancel"
			onclick="window.location='<?php echo $this->Html->url(array("controller" => "persons", "action" => "searchPatient",'?'=>array('type'=>$this->params->query['type'])));?>'">
		<?php }else{?>
		<input class="blueBtn" type="button" value="Cancel"
			onclick="window.location='<?php echo $this->Html->url(array("controller" => "persons", "action" => "searchPatient",'?'=>array('type'=>$this->params->query['type'])));?>'">
		<?php }?>
		<input class="blueBtn submitandReg" type="submit" value="<?php echo $buttonLabel ;?>" id="submit">
		<input name="data[Person][printSheet]" type="hidden" value="1" id="">
		<?php 
		     if($this->Session->read('website.instance')!="vadodara"){
		              if($extraButton){
                            		echo $this->Form->submit($extraButton,array('style'=>'margin-left:10px;','type'=>'submit','class'=>'blueBtn','div'=>false,'error'=>false,'id'=>'extra1'));
                            		echo $this->Form->hidden('print_sheet',array('id'=>'print_sheet'));
                            	}
}
                            	?>
	</div>
	<div class="clr">&nbsp;</div>
	<!-- Patient Information start here -->
	<table border="0" cellspacing="0" cellpadding="0"
		style="max-width: 1000px" class="formFull">
		<tr>
			<th colspan="5"><?php echo __("Patient Information") ; ?></th>
		</tr>

		<?php if($this->Session->read('website.instance')=='vadodara'){ //by pankaj w for vadodara instance only ?>
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id="boxSpace"><?php //echo __("Patient Location");?>
			</td>
			<td width="30%"><table width="100%" cellpadding="0" cellspacing="0"
					border="0">
					<tr>
						<td><?php  echo $this->Form->hidden('Person.location_id', array('id'=>'location_id','value'=>$this->Session->read('locationid')));
							
					//echo $this->Form->input('Patient.location_id', array('label'=>false ,'options'=>$locations  ,'type'=>'radio','fieldset'=>false,'legend'=>false,'div'=>false,'value'=>key($locations),'style'=>'float:none;')); ?>
						</td>
						<td></td>
					</tr>
				</table></td>
		</tr>
		<?php }else{
		 echo $this->Form->hidden('Person.location_id', array('type'=>'text','value'=>$this->Session->read('locationid')));
	} ?>
		<tr>
			<td width="19%" valign="middle" class="tdLabel" id=""><?php echo __("Look Up Patient Name");?><font
				color="red">*</font></td>
			<td width="30%"><table width="100%" cellpadding="0" cellspacing="0"
					border="0">
					<tr>
						<td><?php echo $this->Form->input('lookup_name', array('class' => 'validate[required,custom[customname]] textBoxExpnd','id' => 'lookup_name', 'value' =>$lookupName  , 'label'=> false,
								'div' => false, 'error' => false,'readonly'=>'readonly'));
						?> <?php // if($this->params->query['from'] != 'UID'){?> <?php
						/* echo $this->Html->link($this->Html->image('icons/patient-name.png',array('alt'=>__('UIDPatient Lookup'),'title'=>__('UIDPatient Lookup'))),'#',
						 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'persons','action'=>'patient_search',$this->request->query['type']))."', '_blank',
								           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,height=500,left=400,top=200');  return false;"));

						   			echo  "&nbsp;".$this->Html->image('icons/eraser.png',array('alt'=>__('Eraser'),'title'=>__('Eraser'),'onclick'=>'clearLookup();')) ; */
								?> <?php //}?>
						</td>
						<td width="40"></td>
					</tr>
				</table></td>
			<td width="">&nbsp;</td>
			<td valign="middle" class="tdLabel txtpad_align" id="" width="19%">Age<font
				color="red">*</font>
			</td>
			<td width="30%"><?php echo $this->Form->input('age', array('type'=>'text','style'=>'width:85px;margin-right: 10px;','maxLength'=>'15','readOnly'=>true,'class' => 'validate[required,custom[customage]] textBoxExpnd','id' => 'age')); 
			  echo $this->Form->input('dob', array('type'=>'hidden','id' => 'dob', 'value' => $dob)); ?>
				<?php echo $this->Form->input('sex', array('readonly'=>'readonly','style'=>'width:105px','options'=>array(""=>__('Please Select'),"male"=>__('Male'),'female'=>__('Female')),'class' => 'validate[required,custom[patient_gender]] textBoxExpnd','id' => 'sex', 'value' =>$sex)); ?>

			</td>
		</tr>
		<?php	if(($this->params->query['type']=='IPD') || (strtolower($this->params->query['type'])=='emergency') ){ ?>
		<tr>

			<!--
                        <td valign="middle" class="tdLabel" id="">Patient Name <font color="red">*</font></td>
                        <td>
                        	<?php echo $this->Form->input('full_name', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'full_name')); ?>
                        </td>
                        -->
			<td class="tdLabel " id="">Treating Consultant<?php  echo $redStar ;?>
			</td>
			<td width="250"><?php  echo $this->Form->input('doctor_id', array('empty'=>__('Please Select'),'options'=>$doctors,'class' => "$validateTreating textBoxExpnd",'id' => 'doctor_id','value'=>Configure::read('default_doctor_selected') ));  ?>
			</td>
			<td>&nbsp;</td>

			<td class="tdLabel txtpad_align" id="">Department</td>
			<td><?php echo $this->Form->input('department_id', array('empty'=>__('Please Select'),'options'=>$departments,'class' => 'textBoxExpnd','id' => 'department_id','value'=>$department_id,'disabled'=>'disabled')); ?>
				<?php echo $this->Form->hidden('',array('name'=>"data[Patient][department_id]",'id'=>'d_id')); ?>
			</td>


		</tr>
		<?php } else { 
			if(($this->Session->read('website.instance')=='vadodara' && $this->params->query['type']!='OPD') || $this->Session->read('website.instance')!='vadodara'){?>
		<tr>
			<td class="tdLabel"><?php echo __('Treating Consultant')?><font
				color="red">* </font></td>
			<td><?php  echo $this->Form->input('doctor_id', array('empty'=>__('Please Select'),'options'=>$opddoc,'class' => "$validateTreating textBoxExpnd",'id' => 'doctor_id','value'=>Configure::read('default_doctor_selected') ));  ?>
			</td>
			<td>&nbsp;</td>
			<td class=""><?php echo __('Department')?><font color="red">* </font>
			</td>

			<td width="250"><?php 
                        	echo $this->Form->input('department_id', array('empty'=>__('Please Select'),'options'=>$departments,'class' => 'textBoxExpnd','id' => 'department_id' ,'value'=>$department_id,'disabled'=>'disabled')); ?>
				<?php echo $this->Form->hidden('',array('name'=>"data[Patient][department_id]",'id'=>'d_id')); ?>

			</td>
		</tr>

		<?php }
		 }?>
		<tr>
			<?php //if($this->params->query['from'] != 'UID'){?>
		<!-- <td valign="middle" class="tdLabel" id="">Balance From Last Visit</td>
			<td><?php 
		//	echo $this->Form->input('previous_receivable', array('class' => 'textBoxExpnd','id' => 'previous_receivable','value'=>$previousReceivable,'readonly'=>true));

			?></td>-->	
			<?php // }else{?>
			<td>&nbsp;</td>
			<td>&nbsp;</td> 
			<?php //}?>
			<td>&nbsp;</td>
			<?php	if(($this->params->query['type']=='IPD') || (strtolower($this->params->query['type'])=='emergency')){ ?>
			<td class="" id="" valign="top">Ward Allotted<font color="red">*</font>
			</td>
			<td><?php 
			$rooms = $wardsAvailable;
			if(strtolower($this->params->query['type'])=='emergency'){
                        		echo $this->Form->hidden('is_emergency',array('value'=>1));
			}
            //echo $this->Form->hidden('admission_type', array('value'=>'IPD'));
            if($this->Session->read('website.instance')!='vadodara') {//condition added by pankaj w as there is no requirement of ward check
	            echo $this->Form->input('ward_id', array('empty'=>__('Please Select'),'options'=>$rooms,'id' => 'ward_id',
							'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','autocomplete'=>'off'));
			}else{
				echo $this->Form->input('ward_id', array('empty'=>__('Please Select'),'options'=>$rooms,'id' => 'ward_id_vadodara',
					'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','autocomplete'=>'off'));
			}

			?>
			<br /> <br /> <?php 
			if($this->Session->read('website.instance')!='vadodara') //condition added by pankaj w as there is no requirement of ward check
				echo $this->Html->link('Check Availabilty','#',array('escape'=>false,'style'=>'text-decoration:underline;','id'=>'ward-overview'));
				
				?>
			</td>
			<?php }?>
			<!--
                       <td class="tdLabel" id=""> Category <font color="red">*</font></td>
                       <td>
                       		<?php
                       			//set array of patient category
                       			$category = array('OPD'=>__('Outpatient'),'IPD'=>__('Inpatient'));
                       			 
                       			echo $this->Form->input('admission_type', array('empty'=>__('Please Select'),'options'=>$category,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'admission_type')); 
                                ?>
                       </td>
                     -->
		</tr>
		<!--
                     <tr>                      
                       <td class="tdLabel" id=""><?php //echo __('Nationality'); ?></td>
                       <td><?php //echo $this->Form->input('nationality', array('class' => 'textBoxExpnd','id' => 'nationality')); ?></td>
                       <td></td>
                       <td colspan="2">
                       		<?php  
                       		if($this->params->query['type']=='IPD' || strtolower($this->params->query['type'])=='emergency'){?>	
	                       <div id="wardSection" >
	                   		<table style="width:100%;">
	                   			<tr>	
			                       <td width="19%" class="tdLabel" id="">Ward alloted<font color="red">*</font></td>
			                        <td width="23%">
			                        	<?php 
			                        		$wards = $wardsAvailable;;
			                        		echo $this->Form->input('ward_id', array('empty'=>__('Please Select'),'options'=>$wards,'id' => 'ward_id','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','autocomplete'=>'off')); ?>
			                        </td>
			                     </tr>
			                 </table>
	                        </div>
	                        <?php }else if($this->params->query['type']=='OPD'){?>
                            <div id="opdSection">
	                   		<table style="width:100%;">
	                   			<tr>	
			                       <td width="19%" class="tdLabel" id=""><?php echo __('Visit Type', true); ?><font color="red">*</font></td>
			                        <td width="23%">
			                        	<?php 
			                        		//$opdoptions = array('Consultation' => 'Consultation', 'Preventive Health Check-up' => 'Preventive Health Check-up', 'Vaccination' => 'Vaccination', 'Pre-Employment Check-up' => 'Pre-Employment Check-up', 'Pre Policy Check up' => 'Pre Policy Check up');
			                        		//echo $this->Form->input('treatment_type', array('empty'=>__('Please Select'),'options'=>$opdoptions,'id' => 'opd_id', 'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd')); 
                                                        ?>
			                        </td>
			                     </tr>
			                 </table>
	                        </div>
	                        <?php } ?>
                        </td>
                     </tr>
                     -->
		<!-- Start -->


		<tr>
			<td class="tdLabel" id="" valign="middle">Tariff<font color="red">*</font>

			</td>

			<td><?php 
			if($this->Session->read('website.instance')=='hope'){
				echo $this->Form->input('tariff_standard_id', array( 'empty'=>__('Please Select'), 'options'=>$tariffStandard,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd',
               'id'=>'tariff','value'=>$tariffID,'onchange'=> $this->Js->request(array('action' => 'getCorporateSublocList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn',
                array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 
                'data' => '{tariffId:$("#tariff").val()}', 'dataExpression' => true, 'div'=>false))));
			}else{
			     echo $this->Form->input('tariff_standard_id', array( 'empty'=>__('Please Select'), 'options'=>$tariffStandard,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'tariff','value'=>$tariffID)); }?>
				<?php if($this->params->query['packaged'] == 1 && $this->Session->read("website.instance") == 'kanpur' ){?>
				<span style="float: left; margin-right: 12px;">packaged patient<?php echo $this->Form->input('is_packaged',array('type'=>'checkbox','disabled'=>true));?>
			</span> <?php echo $this->Form->hidden('is_packaged',array('id'=>'isPackaged'));?>
				<?php echo $this->Form->hidden('package_application_date',array('value'=>date('Y-m-d H:i:s')));?>
				<?php }elseif($this->Session->read("website.instance") == 'hope'){?>
				<span style="float: left; margin-right: 12px;">packaged patient<?php echo $this->Form->input('is_packaged',array('type'=>'checkbox','id'=>'applyPackage'));?>

			</span> <?php echo $this->Form->hidden('package_application_date',array('value'=>date('Y-m-d H:i:s')));?>
				<?php }?>
			</td>
			<td></td>
			<td colspan="2">
				<div id="roomSection" style="display: none">
					<table style="width: 100%;">
						<tr>
							<td width="12%" class="tdLabel" id=""
								style="padding-left: 0px !important">Room Allotted<font
								color="red">*</font>
							</td>
							<td width="19%"><?php 
							$rooms = $wardsAvailable;;
			                        		echo $this->Form->input('room_id', array('empty'=>__('Please Select'),'id' => 'room_id','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','autocomplete'=>'off')); ?>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id=""></td>
			<td></td>
			<td></td>
			<td colspan="2">
				<div id="bedSection" style="display: none">
					<table style="width: 100%;">
						<tr>
							<td width="12%" class="tdLabel" id=""
								style="padding-left: 0px !important">Bed Allotted<font
								color="red">*</font>
							</td>
							<td width="19%"><?php 
			                        		echo $this->Form->input('bed_id', array('empty'=>__('Please Select'),'id' => 'bed_id','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<!-- End -->
		<!-- New Lines Start -->
		<tr>
			<td valign="top" class="tdLabel" id="">Email</td>
			<td valign="top"><?php echo $this->Form->input('email', array('class' => 'textBoxExpnd','id' => 'email',  'value' => $someData['Person']['email'])); ?>
			</td>
			<td></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<!--
                       <td class="tdLabel" id="" valign="top">Sponsor Details<font color="red">*</font></td>
                       <td>
                       		<?php 
                       		//	$paymentCategory = array('cash'=>'cash','card'=>'card');
                       			//echo $this->Form->input('payment_category', array('empty'=>__('Please Select'),'options'=>$paymentCategory,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'paymentCategory')); 
                       		?>
                       		  <?php 
                       			$paymentCategory = array('cash'=>'Self Pay','Corporate'=>'Corporate','Insurance company'=>'Insurance company','TPA'=>'TPA');
                       			echo $this->Form->input('payment_category', array(/* 'empty'=>__('Please Select'), */'options'=>$paymentCategory,'autocomplete'=>'off','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd', 'value' => $someData['Person']['payment_category'], 'id' => 'paymentType','onchange'=> $this->Js->request(array('action' => 'getPaymentType'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{paymentType:$("#paymentType").val()}', 'dataExpression' => true, 'div'=>false)))); 
                       		?>
	                       	 BOF insurance section 
	                         <div id="changeCreditTypeList">
	                         	<?php 
 		 
	                               if($someData['Person']['credit_type_id'] == 1) { 
	                        	?>
		                         <span><font color="red">*</font>&nbsp;
		                           <?php 
		          						echo $this->Form->input('Patient.credit_type_id', array('value'=>$someData['Person']['credit_type_id'],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $credittypes, 'empty' => __('Select Credit Type'), 'id' => 'paymentCategoryId', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateLocationList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorprateLocationList', 'data' => '{paymentCategoryId:$("#paymentCategoryId").val()}', 'dataExpression' => true, 'div'=>false))));
		                          ?>
		                          <br>
		                          <span id="changeCorprateLocationList"><font color="red">*</font>&nbsp;
		                            <?php 
		          						echo $this->Form->input('Patient.corporate_location_id', array('value'=>$someData['Person']['corporate_location_id'],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $corporatelocations, 'empty' => __('Select Corporate Location'), 'id' => 'ajaxcorporatelocationid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateList', 'data' => '{ajaxcorporatelocationid:$("#ajaxcorporatelocationid").val()}', 'dataExpression' => true, 'div'=>false))));
		                          ?>
		                          <br>
		                          <span id="changeCorporateList"><font color="red">*</font>&nbsp;
		                           <?php 
		          						echo $this->Form->input('Patient.corporate_id', array('value'=>$someData['Person']['corporate_id'],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $corporates, 'empty' => __('Select Corporate'), 'id' => 'ajaxcorporateid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateSublocList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateSublocList', 'data' => '{ajaxcorporateid:$("#ajaxcorporateid").val()}', 'dataExpression' => true, 'div'=>false))));
		                          ?>
		                          <br>
		                          <span id="changeCorporateSublocList">
		                            <?php 
		          						echo $this->Form->input('Patient.corporate_sublocation_id', array('value'=>$someData['Person']['corporate_sublocation_id'],'class'=>'textBoxExpnd','options' => $corporatesublocations, 'empty' => __('Select Corporate Sublocation'), 'id' => 'ajaxcorporatesublocationid', 'label'=> false, 'div' => false, 'error' => false));
		                          ?>
		                          <?php 
		                                echo "<br />";
		                                echo __('Other Details :'); 
		                                echo $this->Form->textarea('corporate_otherdetails', array('value'=>$someData['Person']['corporate_otherdetails'],'class' => 'textBoxExpnd','id' => 'otherdetails','row'=>'3')); 
		                          ?>
		                          </span>
		                          </span>
		                          </span>
		                          </span>
		                          
		                       <?php } if($someData['Person']['credit_type_id'] == 2) { ?>
		                           <span><font color="red">*</font>&nbsp;
		                           <?php 
		         						 echo $this->Form->input('Patient.credit_type_id', array('value'=>$someData['Person']['credit_type_id'],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $credittypes, 'empty' => __('Select Credit Type'), 'id' => 'paymentCategoryId', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateLocationList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorprateLocationList', 'data' => '{paymentCategoryId:$("#paymentCategoryId").val()}', 'dataExpression' => true, 'div'=>false))));
		                          ?>
		                           <span id="changeCorprateLocationList"><font color="red">*</font>&nbsp;
		                            <?php 
		          						echo $this->Form->input('Patient.insurance_type_id', array('value'=>$someData['Person']['insurance_type_id'],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancetypes, 'empty' => __('Select Insurance Type'), 'id' => 'insurancetypeid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getInsuranceCompanyList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
		    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeInsuranceCompanyList', 'data' => '{insurancetypeid:$("#insurancetypeid").val()}', 'dataExpression' => true, 'div'=>false))));
		                          ?>
		                          <span id="changeInsuranceCompanyList"><font color="red">*</font>&nbsp;
		                           <?php 
		          						echo $this->Form->input('Patient.insurance_company_id', array('value'=>$someData['Person']['insurance_company_id'],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancecompanies, 'empty' => __('Select Insurance Company'), 'id' => 'ajaxinsurancecompanyid', 'label'=> false, 'div' => false, 'error' => false));
		                          ?>
		                         </span>
		                        </span>
		                        </span>
		                       <?php 
		                             } 
		                            
		                       ?>		                        
	                         </div>
	                          EOF insurance section 
                       	</td>
                     -->
		</tr>

		<!-- New Lines End -->
		<tr>
			<td class="tdLabel " id="" valign="top"><?php echo  __('Referral Doctor'); ?><font color="red">*</font>
			</td>
			<td><?php echo $this->Form->input('known_fam_physician', array('empty'=>__('Please Select'),'autocomplete'=>"off", 'id'=>'familyknowndoctor',
					  'class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]',  'options'=>$reffererdoctors,'div'=>false));
	                          	?>
	            <div style="margin-top: 10%">
					<span id="refferalDocSearch" style="display: none"> 
					<?php echo $this->Form->input('doctor_name',array('class'=>'textBoxExpnd','escape'=>false,
							'label'=>false,'div'=>false,'id'=>'searchDoctor','autocomplete'=>false,'placeHolder'=>'Search Referral Doctor'));
					?>
					</span>
				</div>
				<table width="80%" id=refferalDoctorArea class="tabularForm  top" style="display: none">

				</table>
			</td>
			<td>&nbsp;</td>
			<td valign="top" class="tdLabel txtpad_align" id="">Date of Referral</td>
			<td valign="top"><?php echo $this->Form->input('Patient.date_of_referral', array('type'=>'text','class' => '','id' => 'date_of_referral')); ?>

			</td>
		</tr>
		<!--<tr>
			<td class="tdLabel " id="" valign="top"><?php echo  __('Referral Doctor'); ?><font color="red">*</font>
			</td>
			<td><?php $referalDisplay = $this->Session->read('rolename') == configure::read('admin') ? 'block' : 'none';
			 //echo $this->Form->input('known_fam_physician', array('class' => 'textBoxExpnd','id' => 'knownPhysician'));
							if($someData['Person']['known_fam_physician'] == '' or $referalDisplay == 'block'){
		                       echo $this->Form->input('known_fam_physician', array('empty'=>__('Please Select'),'autocomplete'=>"off", 'id'=>'familyknowndoctor',
											'class'=>'textBoxExpnd validate[required,custom[mandatory-enter]]', 'value' => $someData['Person']['known_fam_physician'],
											 'options'=>$reffererdoctors,'onchange'=> $this->Js->request(array('action' => 'getDoctorsList'),
												array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
	    						 				'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true,
												 'update' => '#changeDoctorsList', 'data' => '{familyknowndoctor:$("#familyknowndoctor").val()}', 'dataExpression' => true, 
													'div'=>false))));
							}else{
									echo $reffererdoctors[$someData['Person']['known_fam_physician']];
							}
	                          	?>
				<div id="changeDoctorsList">
					<?php $consultantData=unserialize($someData['Person']['consultant_id']);
					
					if($someData['Person']['known_fam_physician']){
                    	if($someData['Person']['known_fam_physician'] == Configure :: read('referralforregistrar')) {
                        		echo $this->Form->input('Patient.registrar_id', array('options' => $doctorlist,'value'=>$someData['Person']['registrar_id'],'empty' => 'Select Registrar', 'id' => 'doctorlisting','class'=>'', 'label'=> false, 'div' => false, 'error' => false,'style'=>"display:$referalDisplay;"));
                           		if($referalDisplay == 'none')
                        		echo $doctorlist[$someData['Person']['registrar_id']];
                        } else {													
                        		echo $this->Form->input('Patient.consultant_id', array('options' => $doctorlist,'value'=>$consultantData,'multiple' => true, 'id' => 'doctorlisting','empty'=>'Please Select','label'=> false,'class'=>'validate[required,custom[mandatory-select]]', 'div' => false, 'error' => false,'style'=>"display:$referalDisplay;"));
                                foreach($consultantData as $key =>$value){
											$consultants[] = $doctorlist[$value];
								}
								if($referalDisplay == 'none')
								echo '<span style="float: left;">'.implode('<br>',$consultants).'</span>';
						}
                   	}else{
                    	echo $this->Form->input('Patient.consultant_id', array('options' => $doctorlist,'value'=>$consultantData,'empty' => 'Select Doctor', 'id' => 'doctorlisting', 'label'=> false, 'div' => false, 'error' => false,'style'=>'display:none;'));
                   	}
                          			?>
				</div>
			</td>
			<td>&nbsp;</td>
			<td valign="top" class="tdLabel txtpad_align" id="">Date of Referral</td>
			<td valign="top"><?php echo $this->Form->input('Patient.date_of_referral', array('type'=>'text','class' => '','id' => 'date_of_referral')); ?>

			</td>
		</tr>-->
		<!--<tr>
					<td valign="middle" class="tdLabel" id="">Referral cost
			</td>
			<td><?php echo $this->Form->input('Patient.refferal_cost', array('class' => 'textBoxExpnd','type'=>'text','id' => 'ref_cost','value' => $someData['Patient']['refferal_cost']))."%"; ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel txtpad_align" id=""></td>
			<td>
			</td>
		</tr> -->
		<tr id="refererArea" style="display: none;">
		
			<td valign="middle" class="tdLabel" id="">Referral Doctor Contact No.<!-- <font
				color="red">*</font> -->
			</td>
			<td><?php echo $this->Form->input('family_phy_con_no', array('class' => 'textBoxExpnd','id' => 'phyContactNo','MaxLength'=>'10', 'value' => $someData['Person']['family_phy_con_no'])); ?>
			</td>
			
			<td>&nbsp;</td>
			<td class="tdLabel" id="">&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td class="tdLabel" id="">Relatives Name</td>
			<td><?php echo $this->Form->input('relative_name', array('class' => 'textBoxExpnd','id' => 'relativeName', 'value' => $someData['Person']['relative_name'])); ?>
			</td>
			<td>&nbsp;</td>
			<!--
                        <td class="tdLabel txtpad_align" id="">Authorization From Sponsor</td>
                        <td><?php 
							//echo $this->Form->input('sponsers_auth', array('class' => 'textBoxExpnd','id' => 'sponsersAuth')); 

							$authOption = array('procedure not initiated'=>'Procedure not Initiated','form submitted'=>'Form Submitted','approval in progress'=>'Approval in Progress','approved'=>'Approved','rejected'=>'Rejected','Partial Approval'=>'Partial Approval') ;

							echo $this->Form->input('sponsers_auth', array('empty'=>'Please Select','type'=>'select','options'=>$authOption,'class' => 'textBoxExpnd','id' => 'sponsersAuthOpt'));

							?></td>  -->
			<td class="tdLabel txtpad_align"><?php echo __('Date of Registration', true);echo $redStar;?>
				<?php echo $this->Form->input('doc_ini_assessment', array('style'=>'float:right','type'=>'checkbox','id' => 'docIniAssessment','value'=>1)); ?>
			</td>
			<td width="30%"><?php echo $this->Form->input('form_received_on', array('class'=> $validateTreating."textBoxExpnd",'style'=>'','id' => 'formReceivedOn','type'=>'text')); ?>
			</td>

		</tr>
		<!--   <tr>
                       <td valign="middle" class="tdLabel" id="">&nbsp;</td>
                        <td>
                        	<?php //echo $this->Form->input('landline_phone', array('class'=> 'textBoxExpnd','id' =>'landlinePhone')); ?>
                        </td>
                        <td>&nbsp;</td>
                       <td class="tdLabel" id="">Patient's Photo</td>
                       <td><?php 
                       
                       echo $this->Form->input('upload_image', array('type'=>'file','id'=> 'patient_photo','label'=> false,
					 	'div' => false, 'error' => false)); 
                       
                       ?></td>
                     </tr> -->
		<tr>
			<?php if($this->Session->read('website.instance')=='hope'){?>
			<td valign="middle" class="tdLabel" id="">Relative Phone No.<font
				color="red">*</font>
			</td>
			<td><?php echo $this->Form->input('mobile_phone', array('class' => 'textBoxExpnd  validate[required,custom[mandatory-enter]]','id' => 'mobilePhone','MaxLength'=>'10','value' => $someData['Person']['relative_phone'])); ?>
			</td>
			<?php }else{ ?>
			<td valign="middle" class="tdLabel" id="">Relative Phone No.</td>
			<td><?php echo $this->Form->input('mobile_phone', array('class' => 'textBoxExpnd','id' => 'mobilePhone','MaxLength'=>'10','value' => $someData['Person']['relative_phone'])); ?>
			</td>
			<?php } ?>
			<td>&nbsp;</td>
			<td class="tdLabel txtpad_align" id="">Relationship With Patient</td>
			<td><?php
			$relationship = array('self'=>'Self','mother'=>'Mother','father'=>'Father','brother'=>'Brother','sister'=>'Sister','wife' => 'Wife','husband'=>'Husband','son' => 'Son', 'daughter' => 'Daughter','other'=>'Other');
			echo $this->Form->input('relation', array(/* 'empty'=>__('Please Select'), */
                        								  'options'=>$relationship,'class' => 'textBoxExpnd','id' => 'relation')); ?>
			</td>

		</tr>
		<tr id="showBeneficiaryBlock" style="display: none">
			<td valign="middle" class="tdLabel" id=""></td>
			<td></td>
			<td>&nbsp;</td>
			<td valign="middle" class="tdLabel txtpad_align" >Beneficiary Name</td>
			<td valign="middle" class="tdLabel txtpad_align" ><?php echo $this->Form->input('beneficiary_name', array('class' =>'textBoxExpnd','id' =>'beneficiaryName','autocomplete' => 'off'));?>
            </td> 
		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="">Instructions</td>
			<td><?php
			//$instructions = array('Diabetic'=>'Diabetic','Epileptic'=>'Epileptic','High Blood Pressure'=>'High Blood Pressure','Low Blood Pressure'=>'Low Blood Pressure','Prone to Angina Attacks'=>'Prone to Angina Attacks','Austistic'=>'Austistic');
			$instructions = array('Diabetic'=>'Diabetic- If found Unconscious give sugar/sweet/chocolate.','Epileptic'=>'Epileptic- In case of attack/fit turn patient to one side & refrain from feeding.','High Blood Pressure'=>'High Blood Pressure- If found unconscious or paralyzed, turn patient to one side & refrain from feeding.','Low Blood Pressure'=>'Low Blood Pressure- In case of vertigo keep head in low position & take plenty of fluids.','Cardiac Problem'=>'Cardiac Problem- In case of symtoms like chest pain or sweating administer Tablet Disprin & sublingual Tablet Sorbitrate.','Asthma'=>'Asthma- In case of acute attack administer 2 puffs of Scroflo inhaler & shift to hospital.');
			echo $this->Form->input('instructions', array('empty'=>__('Please select'),
                        								  'options'=>$instructions,'class' => 'textBoxExpnd','id' => 'instructions', 'value' => $someData['Person']['instruction'])); ?>
			</td>
			<td>&nbsp;</td>
			<?php  if(($this->params->query['type']=='OPD')&&($this->params->query['flag']=='fromPtList')){
				if($this->Session->read('website.instance')!='vadodara'){?>
			<td class="tdLabel txtpad_align" id="">Visit Type<font color="red">*</font>
			</td>
			<td><?php  
			echo $this->Form->hidden('admission_type', array('value'=>'OPD'));
			/*  	$opdoptionsNew = array(//'4' => 'First Consultation',
			 //'5' => 'Follow-Up Consultation',
			                        						'6' => 'Preventive Health Check-up',
			                        						'7' => 'Vaccination',
			                        						'8' => 'Pre-Employment Check-up',
			                        						'9' => 'Pre Policy Check up',
			                        						'0'=>'Skip Registration/Consultation');
						$result = array_merge($opdoptionsNew, $opdoptions);*/
			                        	echo $this->Form->input('treatment_type', array('empty'=>__('Please Select'),'options'=>$opdOptions,'id' => 'opd_id', 'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','selected'=>$getOPCheck,'value'=>$app['Appointment']['visit_type']));
			                        	?>
			</td>
			<?php }} else if($this->params->query['type']=='OPD') {
				if($this->Session->read('website.instance')!='vadodara'){?>
			<td class="tdLabel txtpad_align" id="">Visit Type<font color="red">*</font>
			</td>
			<td><?php 
			//echo $this->Form->hidden('admission_type', array('value'=>'OPD'));
			/*  	$opdoptionsNew = array(//'4' => 'First Consultation',
			 //'5' => 'Follow-Up Consultation',
			                        						'6' => 'Preventive Health Check-up',
			                        						'7' => 'Vaccination',
			                        						'8' => 'Pre-Employment Check-up',
			                        						'9' => 'Pre Policy Check up',
			                        						'0'=>'Skip Registration/Consultation');
						$result = array_merge($opdoptionsNew, $opdoptions);*/
			                        	echo $this->Form->input('treatment_type', array('empty'=>__('Please Select'),'options'=>$opdOptions,'id' => 'opd_id', 'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','selected'=>$getOPCheck));
			                        	?>
			</td>
			<?php } }?>


		</tr>
		<tr>
			<td valign="middle" class="tdLabel" id="">Diagnosis</td>
			<td><?php echo $this->Form->input('diagnosis_txt', array('class' => 'textBoxExpnd','id'=>'diagnoses','maxlength'=>'40')); ?>
			</td>
			<td>&nbsp;</td>
			<td class="tdLabel txtpad_align" id="">Other Consultants:</td>
			<td><?php echo  $this->Form->input('Patient.other_consultant',array('options'=>$getOtherConsultant, 'multiple'=>true,'id' => 'other_consultant','style'=>'width:288px;')); ?>
			</td>
		</tr>
		 <?php if(Configure::read('Coupon')){ ?>
		<tr id ="couponSec" style="display:none;">
			<td class="tdLabel" valign="middle">Coupon No</td>
			<td ><?php echo $this->Form->input('coupon_names', array('class' =>'coupon_name textBoxExpnd','id' =>'coupon_name','autocomplete' => 'off'));//validate[ajax[ajaxCouponCall]] ?>
                        <?php echo $this->Form->hidden('Patient.coupon_amountss', array('class' =>'couponAmount','value'=>'0','label'=>false,
                                    'id' =>'couponAmount','autocomplete' => 'off'));//couponAmount?></td> 
                                    <td>&nbsp;</td>
			<td class="tdLabel" id="validcoupon" style='display:none; color:green'><?php echo 'Valid Coupon'; ?></td>
			<td id="validcouponAmount" style='color:green;display:none;'></td>
                        <td>&nbsp;</td>
		</tr>
                <?php } ?>
                 
		<tr>
			<?php $websie=$this->Session->read("website.instance");
		        if($websie=="kanpur"){?>
			<td class="tdLabel"><?php echo __('Weight')?></td>
			<td width="30%"><?php echo $this->Form->input('Patient.patient_weight', array('label'=>false,'type'=>'text','class' => ' validate[optional,custom[onlyNumber]]','style'=>'width:60px','maxlength'=>'3','autocomplete'=>"off",'div'=>false)); echo "&nbsp;"."Kg"?>
			</td>
			<?php }?>
			<td>&nbsp;</td>
			<?php /*if($this->Session->read('website.instance')=='vadodara' && $this->params->query['type']=='OPD'){?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td class="tdLabel" colspan="2"><font size="5px"
				style="font-weight: bold;" color="#F48F5B"> <?php echo $this->Form->input('Person.visit_charge',array('type'=>'hidden','id'=>'visit_input','div'=>false,'label'=>false))?>
					<span id="visit_charge"></span>
			</font><br> <span><?php echo 'Pay Amount From Here'.$this->Form->input('Person.pay_amt',array('type'=>'checkbox','id'=>'pay_charge','div'=>false,'label'=>false))?>
			</span></td>
			<?php }*/?>
		</tr>

		<!-- <tr>                       	
                       	  <td valign="middle" class="tdLabel" id="" >VIP</td>
                          <td><?php echo $this->Form->input('Patient.vip_chk', array('class' => '','type'=>'checkbox','error'=>false,'label'=>false,'id'=>'vip_chk')); ?></td>
                        </tr> -->

		<tr>
			<!--<td class="tdLabel">Family Physician</td>
                        <td><?php //echo $this->Form->input('family_physician', array('class' => 'textBoxExpnd','id' => 'family_physician')); ?></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                       <td class="tdLabel" id="">Relative's Signature</td>
                         <td><?php //echo $this->Form->input('relative_sign', array('class' => 'textBoxExpnd','id' => 'relativeSign')); ?></td>
                        -->
		</tr>
		<?php  //multiple visit  type for  multiple appointmnets for vadodara
					if($this->Session->read("website.instance")=="vadodara" && $this->params->query['type']=='OPD'){ ?>
					<tr>
						<td colspan="5">
							<?php $countApp=0;
							echo multiApp($this->Form,$opddoc,$departments,$opdOptions)?>						
						</td>
											
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><b>Total : <span id="total">0</span></b></td>
						<?php echo $this->Form->hidden('Patient.total',array('id'=>'totAmt'));?>
					</tr>
					<tr>
					<?php if($this->Session->read('website.instance')=='vadodara'){?>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td class="tdLabel"><font size="5px" color="#F48F5B" style="font-weight: bold;">
						<?php echo $this->Form->input('Person.visit_charge',array('type'=>'hidden','id'=>'visit_input','div'=>false,'label'=>false))?>
						<span id="visit_charge"></span></font><br>
						<span><?php echo 'Pay Amount From Here'.$this->Form->input('Person.pay_amt',array('type'=>'checkbox','id'=>'pay_charge','div'=>false,'label'=>false))?></span></td>
						<?php }?></tr>
					<tr class='soapArea' style="display: none">
						<td class="tdLabel"><?php echo __('Treatment Advice :')?></td>
						<td></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="right" colspan="4"
							style="margin-top: 10px; float: right;"><input class="blueBtn" type="button"
							id="addAppButton" value="Add Appointments" onclick="addFields()">
						</td>
					</tr>
                                       
                                        <?php }?>
	</table>
	<!-- Patient Information end here -->
	<!-- BOF Sponsers Details -->
	<p class="ht5"></p>
	<!-- Links to Records start here -->
	<table style="width: 962px" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5"><?php echo __('Sponsor Information'); ?></th>
		</tr>
		<tr>

			<td class="tdLabel" id="" valign="top" width="19%">Sponsor Details<font
				color="red">*</font>
			</td>


			<td width=30% " valign="top"><?php 
			//	$paymentCategory = array('cash'=>'cash','card'=>'card');
			//echo $this->Form->input('payment_category', array('empty'=>__('Please Select'),'options'=>$paymentCategory,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'paymentCategory'));
			?> <?php
			//	$paymentCategory = array('cash'=>'Self Pay','card'=>'Insurance');
			//	$paymentCategory = array('cash'=>'Self Pay','card'=>'Insurance','1'=>'Corporate','2'=>'TPA');
			$paymentCategory = array('cash'=>'Self Pay','Corporate'=>'Corporate','Insurance company'=>'Insurance company','TPA'=>'TPA');
			echo $this->Form->input('payment_category', array('empty'=>__('Please Select'),'options'=>$paymentCategory,'autocomplete'=>'off','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd', 'value' => $someData['Person']['payment_category'], 'id' => 'paymentType','onchange'=> $this->Js->request(array('action' => 'getPaymentType'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
			    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCreditTypeList', 'data' => '{paymentType:$("#paymentType").val(),tariffId:$("#tariff").val()}', 'dataExpression' => true, 'div'=>false))));
			                       		?> <!-- BOF insurance section -->
				<div id="changeCreditTypeList">
					<?php 

					if($someData['Person']['payment_category'] == 'Corporate') {
				                        	?>
					       <!--  <span> <font color="red">*</font>&nbsp;
					                           <?php 
					          						/* echo $this->Form->input('Patient.credit_type_id', array('value'=>$someData['Person']['credit_type_id'],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $credittypes, 'empty' => __('Select Credit Type'), 'id' => 'paymentCategoryId', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateLocationList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
					    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorprateLocationList', 'data' => '{paymentCategoryId:$("#paymentCategoryId").val()}', 'dataExpression' => true, 'div'=>false))));
					                           */?>
					       <br></span>-->
					<!--   <span id="changeCorprateLocationList">
					    <?php echo $this->Form->input('Patient.corporate_location_id', array('value'=>$someData['Person']['corporate_location_id'],
                                'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $corporatelocations, 'empty' => __('Select Corporate Location'), 
					    		'id' => 'ajaxcorporatelocationid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateList'),
                                 array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
					    	    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateList',
                               'data' => '{ajaxcorporatelocationid:$("#ajaxcorporatelocationid").val()}', 'dataExpression' => true, 'div'=>false))));  ?>
                        </span>
                        <br>                       
                        <span id="changeCorporateList">
                        <?php   echo $this->Form->input('Patient.corporate_id', array('value'=>$someData['Person']['corporate_id'],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1',
                              'options' => $corporates, 'empty' => __('Select Corporate'), 'id' => 'ajaxcorporateid', 'label'=> false, 'div' => false, 'error' => false,
                        	  'onchange' => $this->Js->request(array('action' => 'getCorporateSublocList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
					    	  'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorporateSublocList',
                              'data' => '{ajaxcorporateid:$("#ajaxcorporateid").val()}', 'dataExpression' => true, 'div'=>false))));?> 
                         </span>
                           <br>  --> 
                        <span id="changeCorporateSublocList"> 
                        <?php  echo $this->Form->input('Patient.corporate_sublocation_id', array('value'=>$someData['Person']['corporate_sublocation_id'],'class'=>'textBoxExpnd','options' => $corporatesublocations, 'empty' => __('Select Corporate Sublocation')/*, 'id' => 'ajaxcorporatesublocationid'*/, 'label'=> false, 'div' => false, 'error' => false));
								?> 
					     <?php
								/*echo "<br />";
								echo __('Other Details :');
								echo $this->Form->textarea('corporate_otherdetails', array('value'=>$someData['Person']['corporate_otherdetails'],'class' => 'textBoxExpnd','id' => 'otherdetails','row'=>'3'));
						 */ ?>
						</span> 
					 <!-- </span>--> <?php } if($someData['Person']['credit_type_id'] == 2) { ?>
						<span><font color="red">*</font>&nbsp; <?php 
						echo $this->Form->input('Patient.credit_type_id', array('value'=>$someData['Person']['credit_type_id'],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $credittypes, 'empty' => __('Select Credit Type'), 'id' => 'paymentCategoryId', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getCorporateLocationList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
					    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCorprateLocationList', 'data' => '{paymentCategoryId:$("#paymentCategoryId").val()}', 'dataExpression' => true, 'div'=>false))));
					                          ?> <span id="changeCorprateLocationList"><font
								color="red">*</font>&nbsp; <?php 
								echo $this->Form->input('Patient.insurance_type_id', array('value'=>$someData['Person']['insurance_type_id'],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancetypes, 'empty' => __('Select Insurance Type'), 'id' => 'insurancetypeid', 'label'=> false, 'div' => false, 'error' => false, 'onchange' => $this->Js->request(array('action' => 'getInsuranceCompanyList'),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
					    							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeInsuranceCompanyList', 'data' => '{insurancetypeid:$("#insurancetypeid").val()}', 'dataExpression' => true, 'div'=>false))));
					                          ?> <span id="changeInsuranceCompanyList"><font
									color="red">*</font>&nbsp; <?php 
									echo $this->Form->input('Patient.insurance_company_id', array('value'=>$someData['Person']['insurance_company_id'],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancecompanies, 'empty' => __('Select Insurance Company'), 'id' => 'ajaxinsurancecompanyid', 'label'=> false, 'div' => false, 'error' => false));
									?> </span> </span> </span> <?php }
					                       if($someData['Person']['insurance_company_id'] != ""){?>
						<span id="changeInsuranceCompanyList"><font color="red">*</font>&nbsp;
							<?php 
							echo $this->Form->input('Patient.insurance_company_id', array('value'=>$someData['Person']['insurance_company_id'],'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd1','options' => $insurancecompanies, 'empty' => __('Select Insurance Company'), 'id' => 'ajaxinsurancecompanyid', 'label'=> false, 'div' => false, 'error' => false));
							?> </span> <?php }  ?>
				
				</div> <!-- EOF insurance section -->
			</td>
			<td>&nbsp;</td>
			<?php if($this->params->query['type']=='IPD'){?>
			<td valign="top" width="49%" colspan="2" class="" id="corporateStatus"  >
				 <table width="100%">
					<tr>
						<td width="19%" class=""><?php echo __('Status');?>
						</td>
						<td width="30%" align="left" class=" "><?php 
						
						echo $this->Form->input('corporate_status', array('empty'=>__('Please select'),'options'=>$corporateStatus,'class' => 'textBoxExpnd','id' => 'status')); ?>
						</td>
					</tr>
					<!-- <tr>
						<td class="tdLabel txtpad_align" id="">Status of Authorization</td>
						<td><?php 
						//echo $this->Form->input('sponsers_auth', array('class' => 'textBoxExpnd','id' => 'sponsersAuth'));

						$authOption = array('procedure not initiated'=>'Procedure not Initiated','form submitted'=>'Form Submitted','approval in progress'=>'Approval in Progress','approved'=>'Approved','rejected'=>'Rejected','Partial Approval'=>'Partial Approval') ;

						echo $this->Form->input('sponsers_auth', array('empty'=>'Please Select','type'=>'select','options'=>$authOption,'class' => 'textBoxExpnd','id' => 'sponsersAuthOpt'));

						?>
						</td>
					</tr> 
					<tr>
						<td width="19%" class=""><?php echo __('Status');?>
						</td>
						<td width="30%" align="left" class=" "><?php 
						$statusOpt = array( 'Received I card, referral letter'=>'Received I card, referral letter',
																	 'Received MPKAY member verification letter, NOC\'s'=>'Received MPKAY member verification letter, NOC\'s',
																	 '5 page MPKAY bunch form filled by patient'=>'5 page MPKAY bunch form filled by patient',
																	 'Pre-authorization sent'=>'Pre-authorization sent',
																	 'Queries received'=>'Queries received',
																	 'Queries replied'=>'Queries replied',
																	 'Pre-authorization approval received'=>'Pre-authorization approval received',
																	 'Enhancement requested'=>'Enhancement requested',
																	 'Enhancement approved'=>'Enhancement approved',
																	 'MPKAY Units approval for enhanced amount'=>'MPKAY Units approval for enhanced amount'
												 	   );

													   echo $this->Form->input('status', array('empty'=>__('Please select'),'options'=>$statusOpt,'class' => 'textBoxExpnd','id' => 'status')); ?>
						</td>
					</tr>
			 		<tr>
						<td width="19%" class=""><?php echo __('Remark');?>
						</td>
						<td width="30%" align="left" class=" "><?php echo $this->Form->input('remark', array('class' => 'textBoxExpnd','id' => 'remark','disabled'=>'disabled')); ?>
						</td>
					</tr> -->
				</table> 
			</td>
			<?php }?>
		</tr>
		<tr id="showwithcard" style="display: none;">
			<td width="100%" colspan="5" align="left" class="" id=" ">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td width="19%" class="tdLabel" id=""><?php echo __('Name of the I.P.');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('name_of_ip', array('value'=>$someData['Person']['name_of_ip'],'class' => 'textBoxExpnd','id' => 'name_of_ip')); ?>
						</td>
						<td width="">&nbsp;</td>
						<td valign="middle" class="tdLabel txtpad_align" id="" width="19%"><?php echo __('Relationship with Employee');?>
						</td>
						<td align="left" width="30%"><?php
						$relation = array('Self'=>'Self','Father'=>'Father','Mother'=>'Mother','Brother'=>'Brother','Sister'=>'Sister','Wife' => 'Wife','Husband'=>'Husband','Son' => 'Son', 'Daughter' => 'Daughter','Other'=>'other');
														 echo $this->Form->input('relation_to_employee', array('value'=>$someData['Person']['relation_to_employee'],'empty'=>__('Please Select'),'options'=>$relation,'class' => 'textBoxExpnd','id' => 'insurance_relation_to_employee')); ?>
						</td>
					</tr>
					<tr>

						<td width="19%" class="tdLabel" id=""><?php echo __('Executive Employee ID No.');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('executive_emp_id_no', array('value'=>$someData['Person']['executive_emp_id_no'],'class' => 'textBoxExpnd emp_id','id' => 'insurance_executive_emp_id_no')); ?>
						</td>
						<td>&nbsp;</td>
						<td class="tdLabel txtpad_align" id=""><?php echo __('Non Executive Employee ID No.');?>
						</td>
						<td align="left"><?php echo $this->Form->input('non_executive_emp_id_no', array('value'=>$someData['Person']['non_executive_emp_id_no'],'style'=>'width:180px;','class' => 'textBoxExpnd emp_id','id' => 'insurance_non_executive_emp_id_no')); ?>
							<?php echo $this->Form->input('emp_id_suffix', array('value'=>$someData['Person']['relation_to_employee'],'style'=>'width:60px','class' => 'textBoxExpnd emp_id','id' => 'insurance_esi_suffix', 'readonly' => 'readonly')); ?>
						</td>
					</tr>

					<tr>

						<td class="tdLabel" id="" align="left"><?php echo __('Designation');?>
						</td>
						<td align="left"><?php echo $this->Form->input('designation', array('value'=>$someData['Person']['designation'],'class' => 'textBoxExpnd','id' => 'designation')); ?>

						</td>
						<td>&nbsp;</td>
						<td class="tdLabel txtpad_align" id="" align="left"><?php echo __('Company');?>
						</td>
						<td align="left"><?php echo $this->Form->input('sponsor_company', array('value'=>$someData['Person']['sponsor_company'],'class' => 'textBoxExpnd','id' => 'sponsor_company')); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr id="showwithcardInsurance" style="display: none;">
			<td width="100%" colspan="5" align="left" class="" id=" ">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td width="19%" class="tdLabel" id=""><?php echo __('Name of Employee');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('name_of_ip', array('value'=>$someData['Person']['name_of_ip'],'class' => 'textBoxExpnd','id' => 'name_of_ip')); ?>
						</td>
						<td width="">&nbsp;</td>
						<td valign="middle" class="tdLabel txtpad_align" id="" width="19%"><?php echo __('Relationship with Employee');?>
						</td>
						<td align="left" width="30%"><?php
						$relation = array('SELF'=>'Self','FAT'=>'Father','MOT'=>'Mother','BRO'=>'Brother','SIS'=>'Sister','WIFE' => 'Wife','HUSBAND'=>'Husband','SON' => 'Son', 'DAU' => 'Daughter','OTHER'=>'other');
														 echo $this->Form->input('relation_to_employee', array('value'=>$someData['Person']['relation_to_employee'],'empty'=>__('Please Select'),'options'=>$relation,'class' => 'textBoxExpnd','id' => 'corpo_relation_to_employee')); ?>
						</td>
					</tr>
					<tr>

						<td class="tdLabel" id="" align="left"><?php echo __('Designation');?>
						</td>
						<td align="left"><?php echo $this->Form->input('designation', array('value'=>$someData['Person']['designation'],'class' => 'textBoxExpnd','id' => 'designation')); ?>

						</td>
						<td>&nbsp;</td>
						<td class="tdLabel txtpad_align" id=""><?php echo __('Insurance Number');?>
						</td>
						<td align="left"><?php echo $this->Form->input('insurance_number', array('value'=>$someData['Person']['insurance_number'],'class' => 'textBoxExpnd','id' => 'insurance_number')); ?>
						</td>
					</tr>
					<tr>

						<td width="19%" class="tdLabel" id=""><?php echo __('Executive Employee ID No.');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('executive_emp_id_no', array('value'=>$someData['Person']['executive_emp_id_no'],'class' => 'textBoxExpnd emp_id','id' => 'corpo_executive_emp_id_no')); ?>
						</td>
						<td>&nbsp;</td>
						<td class="tdLabel txtpad_align" id=""><?php echo __('Non Executive Employee ID No.');?>
						</td>
						<td align="left"><?php echo $this->Form->input('non_executive_emp_id_no', array('value'=>$someData['Person']['non_executive_emp_id_no'],'style'=>'width:180px;margin-right:10px;','class' => 'textBoxExpnd emp_id','id' => 'corpo_non_executive_emp_id_no')); ?>
							<?php echo $this->Form->input('emp_id_suffix', array('value'=>$someData['Person']['relation_to_employee'],'style'=>'width:60px','class' => 'textBoxExpnd emp_id','id' => 'corpo_esi_suffix', 'readonly' => 'readonly')); ?>
						</td>
					</tr>

					<tr>

						<td width="19%" class="tdLabel" id=""><?php echo __('Name of Police Station');?>
						</td>
						<td width="30%" align="left"><?php echo $this->Form->input('name_police_station', array('value'=>$someData['Person']['name_police_station'],'class' => 'textBoxExpnd name_police_station','id' => 'name_police_station')); ?>
						</td>
						<td>&nbsp;</td>
						<td class="tdLabel txtpad_align" id="">&nbsp;
						</td>
						<td align="left">&nbsp;
						</td>
					</tr>


				</table>
			</td>
		</tr>
	</table>
	<!-- EOF Sponsers Details -->
	<?php  $website=$this->Session->read("website.instance"); 
		if($website=='lifespring'){ ?>
	  <p class="ht5"></p> 
                    <!-- Address info start here -->
	<table style="width: 962px" border="0" cellspacing="0" cellpadding="0"
		class="formFull">
		<tr>
			<th colspan="5"><?php echo __('Other Information');?>
			</th>
		</tr>
		<tr class="pregnant" style='display:none;'>
			<td width="19%" class="tdLabel" id=""><?php echo __('Is Pregnant');?></td>
			<?php $val =  ($someData['Person']['pregnant_week']) ? '' : 'display : none';?> 
			<td width="33%"><?php echo $this->Form->checkbox('is_pregnent', array('legend'=>false,'label'=>false,'class' => 'is_pregnent','id'=>'is_pregnent',
					'checked'=>$someData['Person']['pregnant_week'])); ?>
				<span class="hideRow" style="<?php echo $val;?>"><?php echo $this->Form->input('pregnant_week',array('type'=>'text','legend'=>false,
						'label'=>false,'class' =>'pregnant_week validate[required,custom[onlyNumber]] ','autocomplete'=>'off','id' =>'pregnant_week',
						'value'=>$someData['Person']['pregnant_week']));?>Weeks<font
				color="red">*</font></span>
			</td>
			<td class="hideRow" style="<?php echo $val;?>"><?php echo __('EDD');?> <font
				color="red">*</font></td>
			<td width="30">&nbsp;</td> 
			<td width="30%" class=" hideRow" style="<?php echo $val;?>"> <?php
				$date = $this->DateFormat->formatDate2Local($someData['Person']['expected_date_del'],Configure::read('date_format')); 
			
			 echo $this->Form->input('expected_date_del',array('type'=>'text','autocomplete'=>'off','id' => 'edd',
					'class' =>'validate[required,custom[mandatory-enter]] edd','value'=>$date));?>
			</td>
		</tr>
	<!-- 	<tr>
			<td class="tdLabel"><?php echo __('Coupon No.');?></td>
			<td><?php echo $this->Form->input('coupon_name', array('class' =>'coupon_name ','id' =>'coupon_name')); //validate[ajax[ajaxCouponCall]]?>
			<span id="validcoupon" style='display:none; color:green'><?php echo 'Valid Coupon'; ?></span>
			</td>
		</tr> -->
	              
	</table>
	<?php } ?>
	<p class="ht5"></p> <!-- Links to Records start here -->
	<?php	if(($this->params->query['type']=='IPD') || (strtolower($this->params->query['type'])=='emergency')||($this->params->query['type']=='OPD') ){ ?>
	<!--  
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5">Links to Records</th>
                      </tr>
                      <tr>
                        <td width="19%" class="tdLabel" id="">Case Summary Link</td>
                        <td width="81%"><?php echo $this->Form->input('case_summery_link', array('value'=>$someData['Person']['case_summery_link'],'class' => 'textBoxExpnd txtbx_align','id' => 'caseSummeryLink')); ?></td>
                      </tr>
                      <tr>
                        <td class="tdLabel" id="">Patient File</td>
                        <td><?php echo $this->Form->input('patient_file', array('class' => 'textBoxExpnd txtbx_align','id' => 'patientFile','value'=>$someData['Person']['patient_file'])); ?></td> 
                      </tr> 
                    </table>
                    -->
	<?php }?>
	<!-- BOF Advance -->
	<?php 
	if($this->params->query['type'] != "OPD" && $this->Session->read('website.instance')!='vadodara' ){ // Advance not need for Vadodara instance-- Pooja ?>
	<p class="ht5"></p>

	<!-- Links to Records start here -->
	<table width="962px" border="0" cellspacing="0" cellpadding="0"
					class="formFull">
		<tr>
			<th colspan="5">Advance</th>
		</tr>
		
		<tr>
			<td width="19%" class="tdLabel" id="">Against</td>
			<td width="30%"><?php echo $this->Form->input('Billing.against', array('options'=>$against,'id'=>'against','class' => 'textBoxExpnd','type'=>'select')); ?>
			</td>
			<td width="30">&nbsp;</td>
			<td width="19%" class="" id="">Standard Amount:</td>
			<td width="30%"><?php echo $this->Form->input('', array('id'=>"standardAgainst",'options'=>$standardAgainst,'class' => 'textBoxExpnd','type'=>'select','disabled'=>'disabled')); ?>
			</td>
		</tr>
		<tr>
			<td class="tdLabel" id="">Collected</td>
			<td width="30%"><?php echo $this->Form->input('Billing.amount', array('class' => 'textBoxExpnd validate[optional,custom[onlyNumber]]','type'=>'text','error'=>false,'label'=>false,'id'=>'billAmt')); ?>
			</td>
			<td width="30">&nbsp;</td>
			<td width="19%" class="tdLabel" id="">Remark:</td>
			<td width="30%"><?php echo $this->Form->textarea('Billing.remark', array('class' => 'textBoxExpnd','id' => '','row'=>'3')); ?>
			</td>

			<!-- <td width="19%" class="tdLabel" id="">Against </td>
                        <td width="30%"><?php echo $this->Form->input('Billing.against', array('empty'=>'Please Select','options'=>$against,'class' => 'textBoxExpnd','type'=>'select')); ?></td>
                         -->

		</tr>
		<tr>
			<td class="tdLabel" id="">Mode Of Payment</td>
			<td width="30%"><?php echo $this->Form->input('Billing.mode_of_payment', array("class"=>"textBoxExpnd",'div' => false,'label' => false,/* 'empty'=>__('Please select'), */
					   								'options'=>array('Cash'=>'Cash','Cheque'=>'Cheque','Credit Card'=>'Credit Card'),'id' => 'mode_of_payment','autocomplete'=>'off')); ?>
			</td>
			
		</tr>
		
		<tr>
			<td class="tdLabel" id="" colspan="5">
				<table width="100%" id="paymentInfo" style="display: none">
					<tr>
						<td class="tdLabel" id="">Bank Name</td>
						<td width="30%"><?php echo $this->Form->input('Billing.bank_name',array('class'=>'textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'account_number'));?>
						</td>
						<td width="30">&nbsp;</td>
						<td width="19%">&nbsp;</td>
						<td width="30%">&nbsp;</td>
					</tr>
					<tr>
						<td class="tdLabel" id="">Account No.</td>
						<td width="30%"><?php echo $this->Form->input('Billing.account_number',array('class'=>'textBoxExpnd','type'=>'text','legend'=>false,'label'=>false,'id' => 'account_number'));?>
						</td>
						<td width="30">&nbsp;</td>
						<td width="19%">&nbsp;</td>
						<td width="30%">&nbsp;</td>
					</tr>
					<tr>
						<td class="tdLabel" id="">Cheque/Credit Card No.</td>
						<td width="30%"><?php echo $this->Form->input('Billing.check_credit_card_number',array('class'=>'textBoxExpnd','type'=>'text',
								'legend'=>false,'label'=>false,'id' => 'card_check_number'));?>
						</td>
						<td width="30">&nbsp;</td>
						<td width="19%">&nbsp;</td>
						<td width="30%">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<!-- EOF Advance -->
	<?php } ?>
	<p class="ht5"></p>

	<!-- Patient clinical record start here -->
	<?php	if(($this->params->query['type']=='IPD') || (strtolower($this->params->query['type'])=='emergency')||($this->params->query['type']=='OPD') ){ ?>
	<!--
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5">Performance Indicator</th>
                      </tr>
		                       <!-- <tr>
		                      	 <td width="19%" valign="top" class="tdLabel" id="" style="padding-top:10px;">Allergies</td>
		                         <td width="30%"><?php //echo $this->Form->textarea('allergies', array('class' => 'textBoxExpnd','id' => 'allergies','row'=>'3')); ?></td>
		                         <td width="30">&nbsp;</td>
		                        <td width="19%" valign="top" class="tdLabel" id="" style="padding-top:10px;">On Examination</td>
		                        <td width="" valign="top"><?php //echo $this->Form->textarea('examination', array('class' => 'textBoxExpnd','id' => 'examination','row'=>'3')); ?>
		                        </td>
		                      </tr> 
		                      
		                      <tr>
		                        <td valign="top" class="tdLabel" id=""  style="padding-top:10px;">OT</td>
		                        <td valign="top"><?php //echo $this->Form->input('OT', array('class' => 'textBoxExpnd','id' => 'OT')); ?></td>
		                        <td>&nbsp;</td>
		                        <td valign="top" class="tdLabel" id="" style="padding-top:10px;"> Review on </td>
		                        <td><table width="100%" cellpadding="0" cellspacing="0" border="0">
		                            <tr>
		                              <td><?php //echo $this->Form->input('review_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'reviewOn','readonly'=>'readonly','type'=>'text', 'value' => date("d/m/Y H:i"))); ?></td>
		                            </tr>                  
		                        </table></td>
		                      </tr>-->
	<!--  
                     <tr>                 
                         <td class="tdLabel" id="" width="19%"><?php echo __('Form Received by Patient', true);echo $redStar;?>
                         <?php echo $this->Form->input('doc_ini_assessment', array('style'=>'float:right','type'=>'checkbox','id' => 'docIniAssessment','value'=>1)); ?>
                         </td>
                         <td width="30%">
                         	<?php echo $this->Form->input('form_received_on', array('class' => $validateTreating."textBoxExpnd",'style'=>'','id' => 'formReceivedOn','type'=>'text')); ?></td>
                         <td>&nbsp;</td>
                         <td class="tdLabel" id="" width="19%">
						 <?php echo __('Registration Completed by Patient', true); echo $redStar;?>
                         <?php echo $this->Form->input('nurse_assessment', array('style'=>'float:right','type'=>'checkbox','id' => 'nurseAssessment','value'=>1)); ?>
                         </td>
                         <td valign="top" width="30%">
                         <?php echo $this->Form->input('form_completed_on', array('class' => $validateTreating."textBoxExpnd", 'style'=>'','id' => 'formCompletedOn','type'=>'text')); ?>
                         </td>
                     </tr>
                     <tr>
                       	<td valign="top" class="tdLabel" id="" style="padding-top:10px;">Start of Assessment by Doctor</td>
                  		<td><?php echo $this->Form->input('doc_ini_assess_on', array('class' => '','style'=>'','id' => 'docIniAssessOn','readonly'=>'readonly','type'=>'text')); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="" style="padding-top:10px;">End of Assessment by Doctor</td>                  
                        <td><?php echo $this->Form->input('doc_ini_assess_end_on', array('class' => '','style'=>'','id' => 'docIniAssessEndOn','readonly'=>'readonly','type'=>'text')); ?></td>
                     </tr>
                     <tr>
                     	<td valign="top" class="tdLabel" id="" style="padding-top:10px;">Start of Nursing Assessment</td>
                  		  <td><?php echo $this->Form->input('nurse_assess_on', array('class' => '','style'=>'','id' => 'nurseAssessmentOn','readonly'=>'readonly','type'=>'text')); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="" style="padding-top:10px;">End of Nursing Assessment</td>                  
                          <td><?php echo $this->Form->input('nurse_assess_end_on', array('class' => '','style'=>'','id' => 'nurseAssessmentEndOn','readonly'=>'readonly','type'=>'text')); ?></td>                  
                     </tr>
                     <tr>
                     	<td valign="top" class="tdLabel" id="" style="padding-top:10px;">Start of Nutritional Assessment</td>
                  		<td><?php echo $this->Form->input('nutritional_assess_on', array('class' => '','style'=>'','id' => 'nutritionalAssessOn','readonly'=>'readonly','type'=>'text')); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="" style="padding-top:10px;">End of Nutritional Assessment</td>                  
                        <td><?php echo $this->Form->input('nutritional_assess_end_on', array('class' => '','style'=>'','id' => 'nutritionalAssessEndOn','readonly'=>'readonly','type'=>'text')); ?></td>                  
                     </tr>                     
                    </table>
                      -->
	<?php }?>
	<!-- Patient clinical record end here -->
	<!--  <p class="ht5"></p>                     
                      
                     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5">Discharge Information</th>
                      </tr>
                      <tr>
                        <td width="19%" valign="top" class="tdLabel" id=""  style="padding-top:10px;">Discharge Intimation done</td>
                        <td width="30%" valign="top"  style="padding-top:10px;"><?php echo $this->Form->checkbox('discharge_intimation', array('id' => 'dischargeIntimation','value'=>1)); ?></td>
                        <td>&nbsp;</td>
                        <td width="19%" valign="top" class="tdLabel" id="" style="padding-top:10px;">Discharge Time intimation Date &amp; Time</td>
                        <td width="30%"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td><?php echo $this->Form->input('discharge_intimation_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'dischargeIntimationOn','readonly'=>'readonly','type'=>'text', 'value' => date("d/m/Y H:i"))); ?></td>
                            </tr>                           
                        </table></td>
                      </tr>
                     <tr>
                       <td valign="top" class="tdLabel" id=""> Full and Final intimation done </td>
                        <td valign="top"><?php echo $this->Form->checkbox('final_intimation', array('id' => 'fullIntimation','value'=>1)); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="">Full &amp; Final discharge Date &amp; Time</td>
                        <td width="30%"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td><?php echo $this->Form->input('final_intimation_on', array('class' => 'textBoxExpnd','style'=>'width:85%;','id' => 'fullIntimationOn','readonly'=>'readonly','type'=>'text', 'value' => date("d/m/Y H:i"))); ?></td>
                            </tr>                            
                        </table></td>
					</tr>
                     <tr>
                       <td valign="middle" class="tdLabel" id="">Discharge Description</td>
                        <td valign="top"><?php echo $this->Form->textarea('discharge_desc', array('class' => 'textBoxExpnd','id' => 'dischargeDesc','row'=>'3')); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="">&nbsp;</td>
                       <td valign="top">&nbsp;</td>
                     </tr>
                    </table>
                                
                    <p class="ht5"></p>                    
                    
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
                   	  <tr>
                      	<th colspan="5">InvActivity Information</th>
                      </tr>
                      <tr>
                        <td width="19%" valign="top" class="tdLabel" id="" style="padding-top:10px;">Description</td>
                        <td width="30%"><?php //echo $this->Form->textarea('inv_activity_desc', array('class' => 'textBoxExpnd','id' => 'invActivityDesc','row'=>3)); ?></td>
                        <td width="">&nbsp;</td>
                      </tr>
                      <tr>
                        <td valign="top" class="tdLabel" id="">Invoice settled</td>
                        <td valign="top"><?php //echo $this->Form->checkbox('invoice_settled', array('id' => 'invoiceSettled','value'=>1)); ?></td>
                        <td>&nbsp;</td>
                        <td valign="top" class="tdLabel" id="" style="padding-top:10px;">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                     <tr>
                       <td valign="middle" class="tdLabel" id=""> Advance Paid </td>
                       <td><?php //echo $this->Form->input('advance_paid', array('class' => 'textBoxExpnd','id' => 'advancedPaid')); ?></td>
                       <td>&nbsp;</td>
                       <td class="tdLabel" id="">&nbsp;</td>
                       <td>&nbsp;</td>
                     </tr>
                    </table> -->
	<!-- InvActivity Information end here -->
	<!-- form end here -->


	<div class="" style="margin-right: 0; padding: 17px 0 19px 726px;">
		<?php if($this->params->query['packaged']){?>
		<input class="blueBtn" type="button" value="Cancel"
						onclick="window.location='<?php echo $this->Html->url(array("controller" => "Estimates", "action" => "residentDashboard"));?>'">
		<?php }else if(($this->params->pass[0]) != ''){?>
		<input class="blueBtn" type="button" value="Cancel"
						onclick="window.location='<?php echo $this->Html->url(array("controller" => "persons", "action" => "searchPatient",'?'=>array('type'=>$this->params->query['type'])));?>'">
		<?php }else{?>
		<input class="blueBtn" type="button" value="Cancel"
						onclick="window.location='<?php echo $this->Html->url(array("controller" => "persons", "action" => "searchPatient",'?'=>array('type'=>$this->params->query['type'])));?>'">
		<?php }?>
		<input class="blueBtn submitandReg" type="submit"
						value="<?php echo $buttonLabel ;?>" id="submit">
			<input name="data[Person][printSheet]" type="hidden" value="1" id="">
		<?php 
		if($this->Session->read('website.instance')=="hope"){
		if($extraButton)
		{
			echo $this->Form->submit($extraButton,array('style'=>'margin-left:10px;','type'=>'submit','class'=>'blueBtn','div'=>false,'error'=>false,'id'=>'extra2'));
		}}
		?>
	</div>
	<?php //EOF new form design ?>
			</div>
<?php echo $this->Form->end();?>

<script>
var validatePerson = true ;	var validateCoupon = true;	
var website = '<?php echo $this->Session->read('website.instance')?>';	
		jQuery(document).ready(function(){
			is_opd = '<?php echo $this->params->query['is_opd']?>';
			if(is_opd == 1){
				category = $('#familyknowndoctor').val();
				refferalAutocomplete(category);
				getReferral();	// if patient admit to hospital from OPD dashboard then show already assigned referral doctors
			}
			$("#showBeneficiaryBlock").hide(); // hide beneficiary block if relation is self
			var admissionTypeData = '<?php echo $someData['Person']['admission_type']?>';
			if(admissionTypeData == 'OPD'){			
				serviceCategoryID = "<?php echo $serviceCategoryID;?>"; 
			}else{
				serviceCategoryID = ""; 
		   }
                                  $('#coupon_name').keyup(function(){
                                        $('#couponAmount').val('0');calTotal();    
                                        if($('#coupon_name').val() ==""){
                                            $("#coupon_name").validationEngine("hidePrompt");
                                            $('#validcoupon').hide();
                                            validatePerson = true ;
                                        }else{
                                                $('#validcoupon').hide();
                                                $('#coupon_name').validationEngine('showPrompt', 'Invalid Coupon', 'text', 'topRight', true);
                                                validatePerson = false;
                                        }
                                        name = $('#coupon_name').val();
                                        if(name.length < 6) return false;
                                        $.ajax({   
					type:'POST',
		   			url : "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "couponValidate","admin" => false));?>"+"/"+name,
		   			context: document.body,   
		   			success: function(data){ 
		   				data= jQuery.parseJSON(data);
                                                    if(data[0] == 'Coupon Available'){
                                                        $('#validcoupon').show();
                                                        $('#validcouponAmount').text('Amount : '+data[1]);
                                                        $('#couponAmount').val(data[1]);
                                                        $("#coupon_name").validationEngine("hideAll");
                                                        //calTotal();
                                                        validatePerson = true;
                                                    }else{
                                                        $('#validcoupon').hide();
                                                        $('#couponAmount').val('0');
                                                        $('#coupon_name').validationEngine('showPrompt', data[0], 'text', 'topRight', true);
                                                        
                                                        validatePerson = false;
                                                         calTotal();
                                                    }
			   		}
				}); 
                                    });
			

				$('#is_pregnent').click(function(){			
					if($("#is_pregnent").is(':checked')){	
						$('.hideRow').show();
					}else{
						$('.hideRow').hide();
						$('#pregnant_week , #edd').val("");	
					}
				});		

				$(".edd").datepicker({
					showOn: "both",
					buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: '1950',
					minDate: new Date(),
					dateFormat: '<?php echo $this->General->GeneralDate();?>',		
				});			
		
			if(('<?php echo $someData['Person']['pregnant_week']?>')){
				$(".pregnant").show();
				}else{
					$(".pregnant").hide();
					} 
					
		if('<?php echo $this->params->query['packaged']?>' =='1'){
			$('#ward_id').val('<?php echo $this->request->data['Patient']['ward_id']?>');
			$("#room_id option").remove();
			$.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'rooms', "action" => "getRooms", "admin" => false)); ?>"+"/"+$('#ward_id').val(),
			  context: document.body,	
			  beforeSend:function(){
			    // this is where we append a loading image
			    $('#busy-indicator').show('fast');
				}, 	  		  
			  success: function(data){
				$('#busy-indicator').hide('slow');
			  	data= $.parseJSON(data);
			  	if(data !=''){
			  		if($('#ward_id').val() != ''){
						$('#roomSection').show('slow');
					}else{ 
						$('#roomSection').hide('slow');
						$('#bedSection').hide('slow');
					}
				  	$("#room_id").append( "<option value=''>Please Select</option>" );
					
				  	$.each(data, function(val, text) {
					    $("#room_id").append( "<option value='"+val+"'>"+text+"</option>" );
					});
					$('#room_id').attr('disabled', '');		
			  	}else{ 
			  		$('#roomSection').hide('slow');
					$('#bedSection').hide('slow');
				  	alert("No room available for selected ward");
			  	}				  			
						
			  }
			});
		 }
		     var pid='<?php echo $privateID;?>';
		     var fromUid='<?php echo $this->params->query['from'];?>';
		     var revisit='<?php echo $this->data['Patient']['tariff_standard_id']?>';

			 if(fromUid=='UID'){ 
		     $('#tariff').val(pid);
			 $('#paymentType').val("cash");
		     } else {
			     
			  if(revisit== pid ){
			  $('#tariff').val(pid);
			  $('#paymentType').val("cash");// on load of page by default selected selfpay and private
		      }else{
		    	  $('#tariff').val(revisit);
				 // $('#paymentType').val('TPA');
			       }
			 // $('#tariff').val(pid);
			  //$('#paymentType').val("cash");
		     }
				
			if('<?php echo $someData['Person']['payment_category']?>' =='cash'){
				//	$('#tariff').val(pid);
			}else if('<?php echo $someData['Person']['payment_category']?>' =='Corporate'){
					$('#showwithcard').show('fast');  
		            $('#showwithcardInsurance').hide('slow'); 
		            $('#showwithcardInsurance :input').attr('disabled', true);
		            $('#showwithcard :input').attr('disabled', false);
			}else if('<?php echo $someData['Person']['payment_category']?>' =='Insurance company'){
				 $('#showwithcard').hide('fast');  
		            $('#showwithcardInsurance').show('slow'); 
		            $('#showwithcardInsurance :input').attr('disabled', false);
		            $('#showwithcard :input').attr('disabled', true);
			}
			else if('<?php echo $someData['Person']['payment_category']?>' =='TPA'){
				 $('#showwithcard').hide('fast');  
		            $('#showwithcardInsurance').show('slow'); 
		            $('#showwithcardInsurance :input').attr('disabled', false);
		            $('#showwithcard :input').attr('disabled', true);
			};
			
      		
					
			// binds form submission and fields to the validation engine
			$('#docIniAssessment').trigger('click');
			var currentdate1 = new Date();
            //var showdate1 = currentdate1.getDate()+"/"+(currentdate1.getMonth()+1)+"/"+currentdate1.getFullYear()+" "+currentdate1.getHours()+":"+currentdate1.getMinutes()+":"+currentdate1.getSeconds();
            var showdate1 = '<?php echo $this->DateFormat->formatdate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);?>';
             $( "#formReceivedOn" ).val(showdate1);
         
			//$('#docIniAssessment').prop('checked', true);
			
			
		   	 $("#billAmt").blur(function(){
				if($(this).val()!=''){
					$("#mode_of_payment").addClass("validate[required,custom[mandatory-select]]");
				}else{
					$("#mode_of_payment").removeClass("validate[required,custom[mandatory-select]]");
					$("#mode_of_payment").validationEngine("hidePrompt"); 
				}
			 });
		   	$("#patientfrm").validationEngine();
			 $("#mode_of_payment").change(function(){
					//alert('here');
					if($("#mode_of_payment").val() == 'Credit Card' || $("#mode_of_payment").val() == 'Cheque'){
						 $("#paymentInfo").show();
					}else{
						$("#paymentInfo").hide();
					}
			 });
			 //BOF pankaj - against standard amount
			 $('#against').change(function(){
				 $('#standardAgainst').val($('#against').val());
			 });
			 //EOF panakj - agianst standard amount 	
			 $("#extra2").click(function(){ 
		    	 $('#print_sheet').val('extra');
		     });
			 $("#extra1").click(function(){
			 	$('#print_sheet').val('extra');
			 });
			 
			$('#patientfrm').submit(function(){ 



				
				var validationRes = jQuery("#patientfrm").validationEngine('validate');
				<?php if($this->Session->read("website.instance")=="vadodara" && $this->params->query['type']=='OPD' ){?>
				billAmount=parseInt($('#total').text());
				//if the bill amount is zero avoid form from submitting- Pooja
				if(isNaN(billAmount)|| billAmount==0){
					alert("Please Select Visit Type With Charges.");
					validationRes = false;

				}
				<?php }?>
	           // $("#department_id").attr("disabled","disabled");
				var received			 	= new Date($('#formReceivedOn').val()); 
			 
				var completed 			 	= new Date($('#formCompletedOn').val());

				var docIniAssessOn		 	= new Date($('#docIniAssessOn').val()); 
				var docIniAssessEndOn 	 	= new Date($('#docIniAssessEndOn').val()); 
				
				var nurseAssessmentOn	 	= new Date($('#nurseAssessmentOn').val()); 
				var nurseAssessmentEndOn 	= new Date($('#nurseAssessmentEndOn').val()); 
				
				var nutritionalAssessOn	 	= new Date($('#nutritionalAssessOn').val()); 
				var nutritionalAssessEndOn 	= new Date($('#nutritionalAssessEndOn').val());
				
			
				var error = '';
				if (received.getTime() > completed.getTime())
				{
				  	 error = "*Form Received date can not be greater than Registration Completed by patient";
				}
				
				if(docIniAssessOn.getTime() > docIniAssessEndOn.getTime())
				{
					 error += "\n*Start of Assessment can not be greater than End of Assessment by Doctor";
				}

				if(nurseAssessmentOn.getTime() > nurseAssessmentEndOn.getTime()){
					 error += "\n*Start of Nursing Assessment can not be greater than End of Nursing Assessment"; 
				}

			if(nutritionalAssessOn.getTime() > nutritionalAssessEndOn.getTime()){
					 error += "\n*Start of Nutritional Assessment can not be greater than End of Nutritional Assessment";
				}
				if(error !='' || !validatePerson){
					if(!validatePerson)
						$('#coupon_name').val('');	
					return false ;
				}
				if(validationRes){
					 $(".submitandReg").hide();
					$("#extra2").attr('disabled','disabled');
					$("#extra1").attr('disabled','disabled');
					//$("#submit").attr('disabled','disabled');
					$("#submit-1").attr('disabled','disabled');
				}else{
					return false;
                 	 $(".submitandReg").show();
					}
				   
			});
		

			/** for by default selected doctors department-Atul**/
			   var docDefaultId='<?php echo Configure::read('default_doctor_selected')?>';
			   if(docDefaultId!=''){
			     $.ajax({
			      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsDept", "admin" => false)); ?>"+"/"+docDefaultId,
			      context: document.body,          
			      success: function(data){ 
			    	  $('#department_id').val(parseInt(data)); 
			       $('#d_id').val(parseInt(data));
			       if(docDefaultId!=0)
			       $('#opd_id').attr('disabled',false); 
			      }
			    });
			   }
			   /** **/   
			
			//function to hide/show ward dropdown
			$('#admission_type').change(function (){
				if($(this).val()=='IPD'){
					$('#submit').val('Submit');
					$('#submit-1').val('Submit');
					$('#ward_id').val('');
					$('#wardSection').show('slow');
					$('#opdSection').fadeOut('fast');
				}else{
					$('#submit').val('Set Appointment');
					$('#submit-1').val('Set Appointment');
					$('#wardSection').fadeOut('fast');
					$('#roomSection').fadeOut('fast');
					$('#bedSection').fadeOut('fast');
					$('#opdSection').fadeIn('slow');
				}
			});	
			
			$('#ward_id').change(function (){
				
				$("#room_id option").remove();
				$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'rooms', "action" => "getRooms", "admin" => false)); ?>"+"/"+$('#ward_id').val(),
				  context: document.body,	
				  beforeSend:function(){
				    // this is where we append a loading image
				    $('#busy-indicator').show('fast');
					}, 	  		  
				  success: function(data){
					$('#busy-indicator').hide('slow');
				  	data= $.parseJSON(data);
				  	if(data !=''){
				  		if($('#ward_id').val() != ''){
							$('#roomSection').show('slow');
						}else{ 
							$('#roomSection').hide('slow');
							$('#bedSection').hide('slow');
						}
					  	$("#room_id").append( "<option value=''>Please Select</option>" );
						
					  	$.each(data, function(val, text) {
						    $("#room_id").append( "<option value='"+val+"'>"+text+"</option>" );
						});
						$('#room_id').attr('disabled', false);		
				  	}else{ 
				  		$('#roomSection').hide('slow');
						$('#bedSection').hide('slow');
					  	alert("No room available for selected ward");
				  	}				  			
							
				  }
				});
			});
			
			$(window).scroll(function() { 
			    $('#busy-indicator').css("top", $(window).scrollTop()+"px");
			});
			$('#room_id').change(function (){
				
				$("#bed_id option").remove();
				$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'rooms', "action" => "getBeds", "admin" => false)); ?>"+"/"+$('#room_id').val(),
				  context: document.body,
				  beforeSend:function(){
				    // this is where we append a loading image
				    $('#busy-indicator').show('fast');
					}, 				  		  
				  success: function(data){
					$('#busy-indicator').hide('slow');
				  	data= $.parseJSON(data);
				  	if(data != ''){
				  		$('#bedSection').show('slow');
					  	$("#bed_id").append( "<option value=''>Please Select</option>" );
						$.each(data, 	function(val, text) {
						    $("#bed_id").append( "<option value='"+val+"'>"+text+"</option>" );
						});
						$('#bed_id').attr('disabled', false);	
				  	}else{
				  		 
						$('#bedSection').hide('fast');
						alert('No bed available for selected room'); 
				  	}				  			
				    		
				  }
			});
			});		
			
			
			 $('#familyknowndoctor').change(function(){
				    $("#refferalDoctorArea").html('');
					var category=$(this).val();
					if(category != ''){
						$("#refferalDoctorArea").show();
						$("#refferalDocSearch").show();
						$("#searchDoctor").focus();
						var rowCount = document.getElementById('refferalDoctorArea').rows.length;
						if(rowCount == 0){
	                    	$("#refferalDocSearch").css({ display: "block" });
	                    	$("#searchDoctor").addClass("validate[required,custom[mandatory-select]]");
		                 }
						 refferalAutocomplete(category); //autocomplete function
					}else{
						$("#refferalDoctorArea").hide();
						$("#refferalDocSearch").hide();
					}
						
				});	

		});

		$(document).on('click','.removeRow', function(){
			var rowId = $(this).attr('id').split("_")[1];
			$("#refferalTr_"+rowId).remove(); 

			var trCount = document.getElementById('refferalDoctorArea').rows.length;
			if(trCount == 0){
            	$("#refferalDocSearch").css({ display: "block" });
            	$("#searchDoctor").addClass("validate[required,custom[mandatory-select]]");
             }else{
            	 $("#refferalDocSearch").css({ });
            	 $("#searchDoctor").removeClass("validate[required,custom[mandatory-select]]");
             }
	    });
	    
		/*function deleteRow(rowId){ 
		 	$("#refferalTr_"+rowId).remove(); 
		}*/
	 function clearLookup(){
				$('#lookup_name').val('');
				$('#patientID').val('');
			}	
		//script to include datepicker
		$(function() {
			
			$("#date_of_referral, .edd" ).datepicker({
				showOn: "both",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',	
				minDate: new Date(),		 
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				
			});
			
		$( "#docIniAssessOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat: '<?php echo $this->General->GeneralDate('HH:II:SS');?>'
		});
		$( "#nurseAssessmentOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>'
		});
		$( "#nutritionalAssessOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>'
		});
		$( "#docIniAssessEndOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>'
		});
		$( "#nurseAssessmentEndOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>'
		});
	/*	$( "#nutritionalAssessEndOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'dd/mm/yy HH:II:SS',
			onSelect : function() {
		 		var selDate = $("#nutritionalAssessOn").val();
		 		if(selDate == '') $(this).val('');
		 		minDate: new Date(selDate)
			}
		});*/

		$( "#nutritionalAssessEndOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>'
		});
		$( "#formReceivedOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			//dateFormat:'dd/mm/yy HH:II:SS',
            maxDate: new Date(),
            maxTime : true,
            dateFormat: '<?php echo $this->General->GeneralDate('HH:II:SS');?>',
                        
		});
        $( "#formCompletedOn" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			//dateFormat:'dd/mm/yy HH:II:SS',
                maxDate: new Date(),
                dateFormat: '<?php echo $this->General->GeneralDate('HH:II:SS');?>',  
		});
	});
                // form received by patient date if check true
		$( "#docIniAssessment" ).click(function(){
			if($( "#docIniAssessment" ).is(':checked') == true) {
                          var currentdate = new Date();
                          var showdate = currentdate.getDate()+"/"+(currentdate.getMonth()+1)+"/"+currentdate.getFullYear()+" "+currentdate.getHours()+":"+currentdate.getMinutes()+":"+currentdate.getSeconds();
                           $( "#formReceivedOn" ).val(showdate);
                        } else {
                          $( "#formReceivedOn" ).val('');
                        }
		}); 
                // form completed by patient date if check true
		$( "#nurseAssessment" ).click(function(){
			if($( "#nurseAssessment" ).is(':checked') == true) {
                          var currentdate = new Date();
                          var showdate = currentdate.getDate()+"/"+(currentdate.getMonth()+1)+"/"+currentdate.getFullYear()+" "+currentdate.getHours()+":"+currentdate.getMinutes()+":"+currentdate.getSeconds();
                           $( "#formCompletedOn" ).val(showdate);
                        } else {
                          $( "#formCompletedOn" ).val('');
                        }
		});
                // hide the pop up error message after selecting another fields/
        $("select").change(function(){
                 $("form").validationEngine('hide');
        });
               // end //

        //ward overview
        
		$('#ward-overview').click(function(){ 
				$.fancybox({
		            'width'    : '95%',
				    'height'   : '90%',
				    'autoScale': true,
				    'transitionIn': 'fade',
				    'transitionOut': 'fade',
				    'type': 'iframe',
				    'href': "<?php echo $this->Html->url(array("controller" => "wards", "action" => "ward_overview")); ?>" 
			    });
				
		});

		//BOF card block
			$('#status').change(function(){
				if($(this).val()==''){
					$('#remark').attr('disabled',true);
				}else{ 
					if($(this).val()!='Pre-authorization sent'){
						$('#remark').val('Estimate Amount');
					}
					if($(this).val()=='Pre-authorization approval received'){
						$('#remark').val('Pre-authorization approval received');
					}
					$('#remark').attr('disabled',false);
				}
			});  
			 if($('#insurance_non_executive_emp_id_no').val() != ''){
				  $('#insurance_executive_emp_id_no').attr('disabled',true);
			   }
	      	   if($('#insurance_executive_emp_id_no').val() != ''){
					  $('#insurance_non_executive_emp_id_no').attr('disabled',true);
			   }
	      	   if($('#corpo_executive_emp_id_no').val() != ''){
					  $('#corpo_non_executive_emp_id_no').attr('disabled',true);
			   }
			   if($('#corpo_non_executive_emp_id_no').val() != ''){ 
					  $('#corpo_executive_emp_id_no').attr('disabled',true);
			   }
			$('#paymentType').change(function(){
				var pid='<?php echo $privateID;?>';
				if($(this).val()=='cash'){
					//$('#tariff').val(pid);
					$('#remark').attr('disabled',true);
					$('#sponsersAuthOpt').fadeOut();
					$('#status-remark').fadeOut('slow');
					$('#corporateStatus').hide('slow');
					$('#sponsersAuth').fadeIn(); 	
					$('#sponsersAuth').attr('disabled',true);
					 $('#showwithcard').hide('fast');  
	                 $('#showwithcardInsurance').hide('slow'); 
					}else if($(this).val() == 'Corporate'){
		               	 $('#showwithcard').show('slow');  
		                 $('#showwithcardInsurance').hide('fast'); 
		                 $('#showwithcardInsurance :input').attr('disabled', false);
		                // $('#showwithcard :input').attr('disabled', true);
		            }else if($(this).val() == 'Insurance company'){
		           		 $('#showwithcard').hide('fast');  
		                 $('#showwithcardInsurance').show('slow'); 
		                 $('#showwithcardInsurance :input').attr('disabled', false);
		                 $('#showwithcard :input').attr('disabled', true);
		            }
		            else if($(this).val() == 'TPA'){
		           		 $('#showwithcard').hide('fast');  
		                 $('#showwithcardInsurance').show('slow'); 
		                 $('#showwithcardInsurance :input').attr('disabled', false);
		                 $('#showwithcard :input').attr('disabled', true);
		                // $('#tariff').val(0);
		            }else{
						$('#sponsersAuth').fadeOut();
						$('#sponsersAuthOpt').fadeIn();
						$('#status-remark').fadeIn('slow'); 
					}
			});

			<?php if($this->Session->read('website.instance')=='kanpur' ){?>
			$('#tariff').change(function(){
				resetAllTariff();
				
				var pid='<?php echo $privateID;?>';
				if($(this).val()==pid){
						 $('#paymentType').val("cash");
						 $('#showwithcard').hide('fast');  
		                 $('#showwithcardInsurance').hide('slow'); 
		                 $('#showwithcardInsurance :input').attr('disabled', false);
		                 $('#showwithcard :input').attr('disabled', true);
					}else {
						 $('#paymentType').val("TPA");
		           		 $('#showwithcard').hide('fast');  
		                 $('#showwithcardInsurance').show('slow'); 
		                 $('#showwithcardInsurance :input').attr('disabled', false);
		                 $('#showwithcard :input').attr('disabled', true);
		            }

					
			});
			<?php }?>

			<?php if($this->Session->read('website.instance')=='hope' ){?>
			$('#tariff').change(function(){
				resetAllTariff();
				
				var pid='<?php echo $privateID;?>';
				if($(this).val()==pid){
						 $('#paymentType').val("cash");
						 $('#showwithcard').hide('fast');  
		                 $('#showwithcardInsurance').hide('slow'); 
		                 $('#showwithcardInsurance :input').attr('disabled', false);
		                 $('#showwithcard :input').attr('disabled', true);
		                 $('#corporateStatus').hide('slow');
					}else {
						 $('#paymentType').val("Corporate");
		           		 $('#showwithcard').hide('fast');  
		                 $('#showwithcardInsurance').show('slow'); 
		                 $('#showwithcardInsurance :input').attr('disabled', false);
		                 $('#showwithcard :input').attr('disabled', true);
		                 $('#corporateStatus').show('slow');
		            }
					
			});
			<?php }?>
		    $('#paymentCategoryId').on('change',function(){
						    if($('#paymentCategoryId').val() == 1) {
	                              $('#showwithcardInsurance').hide('fast');
	                              $('#showwithcard').show('slow');
	                              $('#showwithcardInsurance :input').attr('disabled', true);
	                              $('#showwithcard :input').attr('disabled', false);
			                }else if($('#paymentCategoryId').val() == 2) {
	                			  $('#showwithcard').hide('fast');  
	                              $('#showwithcardInsurance').show('slow'); 
	                              $('#showwithcardInsurance :input').attr('disabled', false);
	                              $('#showwithcard :input').attr('disabled', true);
			                }else{  
	                              $('#showwithcard').hide();
	                              $('#showwithcardInsurance').hide();
			                } 
					});
		 

	 $('#paymentType').change(function(){
			var pid='<?php echo $privateID;?>';
		    if($('#paymentType').val() == "cash") {
		    	//$('#tariff').val(pid);
		    	   $('#showwithcard').hide();
                   $('#showwithcardInsurance').hide();
                   $('#status-remark').hide();
           }else if($('#paymentType').val() == ''){
          	 $('#showwithcard').hide();
             $('#showwithcardInsurance').hide();
        }
	 });

	 if($('#paymentType').val() == "card") {
	   		$('#status-remark').show();
	   		if($('#status').val()!='')
			$('#remark').attr('disabled',false);
	   }else{
		   $('#status-remark').hide('fast');
		   $('#remark').attr('disabled',true);
	   }
	   
	 if($('#paymentCategoryId').val() == "1") { 
	      $('#showwithcard').show();
	      $('#showwithcardInsurance :input').attr('disabled', true);
	      $('#showwithcardInsurance :input').val(''); 
     }else if($('#paymentCategoryId').val() == "2") {
         $('#showwithcardInsurance').show(); 
         $('#showwithcard :input').attr('disabled', true);
         $('#showwithcard :input').val('');
     }

     
	//fnction to disable one option
	$('.emp_id').on('keyup change',function(){
		if($(this).val() != ''){
			$('.emp_id').not(this).attr('disabled',true);
			if($(this).attr('id')=='insurance_executive_emp_id_no'){
				$('#insurance_esi_suffix').val('');
			}else if($(this).attr('id')=='insurance_non_executive_emp_id_no'){
				$('#insurance_esi_suffix').val($('#insurance_relation_to_employee').val()); 
			}
			if($(this).attr('id')=='corpo_executive_emp_id_no'){
				$('#corpo_esi_suffix').val('');
			}else if($(this).attr('id')=='corpo_non_executive_emp_id_no'){
				$('#corpo_esi_suffix').val($('#corpo_relation_to_employee').val());
			} 
	   }else{
			$('.emp_id').attr('disabled',false);
	   }
	}); 
	//on realtion select
	$('#insurance_relation_to_employee').change(function(){
		$('#insurance_esi_suffix').val($(this).val());
		$('#corpo_esi_suffix').val('');
		$('#corpo_relation_to_employee').val('');
	});

	$('#corpo_relation_to_employee').change(function(){
		$('#insurance_esi_suffix').val('');
		$('#corpo_esi_suffix').val($(this).val());
		$('#insurance_relation_to_employee').val('');
	});		
	
		//EOF card block
	
		$("#familyknowndoctor").change(function(){
			if($(this).val() != ''){
				$("#refererArea").show();
				
			}else{
				$("#refererArea").hide();
			}
		});


		$('#department_id').change(function(){
			var val='';
			$.ajax({
		      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorByDepartmentWise", "admin" => false)); ?>"+"/"+$(this).val(),
		      context: document.body,          
		      success: function(data){ 
		    	   
				  if(data !== undefined && data !== null){				    
						data1 = $.parseJSON(data);	
						if(data1 !='' && data1 !== undefined && data1 !== null){	
							
							$("#doctor_id option").remove();	
							$('#doctor_id').append( "<option value='"+val+"'>Please Select</option>" );								
							$.each(data1, function(val, text) {
								if(val !='' && val !== undefined && val !== null)
							    $('#doctor_id').append( "<option value='"+val+"'>"+text+"</option>" );
							});
				  		}else{
					  	
				  			$("#doctor_id option").remove();
				  			$('#doctor_id').append( "<option value='"+val+"'>Please Select</option>" );
				  		}
				  }
		      }
		    });
	  });
		
	
		$("#doctor_id, .doctorApp").on('change',function(){
		//$("#doctor_id, .doctorApp").change(function() {
			var selectedDoc=$(this).attr('id').split('_')[2];
			var selectedVal='';
			if(!isNaN(selectedDoc)){
				selectedVal=$('#opd_id_'+selectedDoc+' option:selected').val();
			}else{
				selectedVal=$('#opd_id option:selected').val();
			}
			if(selectedVal && !isNaN(selectedDoc)){
				resetTariff(selectedDoc);
			}else if(selectedVal){
				resetTariff(0);
			}
		    var val = $(this).val();
		    if(val == "shipping" || val == "storage") {
		        $("#company, #dock").attr("disabled", true)
		    } else {
		        $("#company, #dock").attr("disabled", false)
		    }				 
		    $.ajax({
			      url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsDept", "admin" => false)); ?>"+"/"+$(this).val(),
			      context: document.body,          
			      success: function(data){ 
				    var a =parseInt(data);
				    if(!isNaN(selectedDoc)){ 
					       $('#department_id_'+selectedDoc).val(a); 
					       $('#department_id-'+selectedDoc).val(a); 
					       $('#opd_id_'+selectedDoc).attr('disabled',false);
				    }else{
				    		  $('#department_id').val(parseInt(data)); 
						      $('#d_id').val(parseInt(data)); 
						      $('#opd_id').attr('disabled',false);
					}
					/*$('#department_id').val(a);
					$('#d_id').val(a);
					$('#opd_id').attr('disabled',false);*/
		       }
			});
		});

		$('#opd_id ,.visitApp').on('change',function(){
			var selectedDoc=$(this).attr('id').split('_')[2];
			var selectedVal='';var visitType='';var doctor_id='';			
			if(!isNaN(selectedDoc)){
				selectedVal=$('#opd_id_'+selectedDoc+' option:selected').val();
			}else{
				selectedVal=$('#opd_id option:selected').val();
			}
			if(!isNaN(selectedDoc)){
				$('#visit_charge_'+selectedDoc).text('');
				$('#visit_input_'+selectedDoc).val('');
				$('#visit_charge_'+selectedDoc).hide();
				$('#visit_input_'+selectedDoc).hide();				
				calTotal();
			}else{
				$('#visit_charge').text('');
				$('#visit_input').val('');
				$('#visit_charge').hide();
				$('#visit_input').hide();	
				calTotal();			
			}
			if(!isNaN(selectedDoc)){
				visitType=$('#opd_id_'+selectedDoc).val();
				doctor_id=$('#doctor_id_'+selectedDoc).val();
			}else{
				visitType=$('#opd_id').val();
				doctor_id=$('#doctor_id').val();
			}
			var tarifId=$('#tariff').val();
			var privateTarif="<?php echo $privateID?>";
			if(tarifId!=privateTarif)
				$('#pay_charge').attr('checked',false);
			<?php if($this->Session->read('website.instance')=='vadodara' ){?>
			$('#submit').hide();
			if(selectedVal){
			$.ajax({
	        	url: "<?php echo $this->Html->url(array("controller" => 'Persons', "action" => "getTariffAmount")); ?>"+"/"+visitType+"/"+doctor_id+"/"+tarifId,
	        	context: document.body,	        	
				success: function(data){
					if(data !== undefined && data !== null){
						data1 = jQuery.parseJSON(data);
						if(data1.charges!=false){
							if( typeof(data1.charges.TariffCharge)!='undefined' && data1.charges!=false ){
								if(typeof(data1.charges['TariffCharge']['id'])!='undefined'){
									if(data1.charges['TariffCharge']['nabh_charges']){
										if(!isNaN(selectedDoc)){
											$('#visit_charge_'+selectedDoc).show();
											$('#visit_input_'+selectedDoc).show();
											$('#visit_charge_'+selectedDoc).text($('#opd_id_'+selectedDoc+' option:selected').text()+' :'+data1.charges['TariffCharge']['nabh_charges']);
											$('#visit_input_'+selectedDoc).val(data1.charges['TariffCharge']['nabh_charges']);
											calTotal();
										}else{
											$('#visit_charge').show();
											$('#visit_input').show();
											$('#visit_charge').text($('#opd_id option:selected').text()+' :'+data1.charges['TariffCharge']['nabh_charges']);
											$('#visit_input').val(data1.charges['TariffCharge']['nabh_charges']);
											calTotal();

										}
										
									}else if(data1.charges['TariffCharge']['non_nabh_charges']){
										if(!isNaN(selectedDoc)){
											$('#visit_charge_'+selectedDoc).show();
											$('#visit_input_'+selectedDoc).show();
											$('#visit_charge_'+selectedDoc).text($('#opd_id_'+selectedDoc+' option:selected').text()+' :'+data1.charges['TariffCharge']['non_nabh_charges']);
											$('#visit_input_'+selectedDoc).val(data1.charges['TariffCharge']['non_nabh_charges']);
											calTotal();
										}else{
											$('#visit_charge').show();
											$('#visit_input').show();
											$('#visit_charge').text($('#opd_id option:selected').text()+' :'+data1.charges['TariffCharge']['non_nabh_charges']);
										    $('#visit_input').val(data1.charges['TariffCharge']['non_nabh_charges']);
										    calTotal();
										}
									}
									$('#location_id').val(data1.charges['User']['location_id']);
								}						
							}else if( typeof(data1.charges.TariffAmount)!='undefined' && data1.charges!=false ){
									if(data1.charges['TariffAmount']['id']){
									if(data1.charges['TariffAmount']['nabh_charges']){
										if(!isNaN(selectedDoc)){
											$('#visit_charge_'+selectedDoc).show();
											$('#visit_input_'+selectedDoc).show();
											$('#visit_charge_'+selectedDoc).text($('#opd_id_'+selectedDoc+' option:selected').text()+' :'+data1.charges['TariffAmount']['nabh_charges']);
											$('#visit_input_'+selectedDoc).val(data1.charges['TariffAmount']['nabh_charges']);
											calTotal();
										}else{
											$('#visit_charge').show();
											$('#visit_input').show();
											$('#visit_charge').text($('#opd_id option:selected').text()+' :'+data1.charges['TariffAmount']['nabh_charges']);
											$('#visit_input').val(data1.charges['TariffAmount']['nabh_charges']);
											calTotal();

										}
									}else if(data1.charges['TariffAmount']['non_nabh_charges']){
										if(!isNaN(selectedDoc)){
											$('#visit_charge_'+selectedDoc).show();
											$('#visit_input_'+selectedDoc).show();
											$('#visit_charge_'+selectedDoc).text($('#opd_id_'+selectedDoc+' option:selected').text()+' :'+data1.charges['TariffAmount']['non_nabh_charges']);
											$('#visit_input_'+selectedDoc).val(data1.charges['TariffAmount']['non_nabh_charges']);
											calTotal();
										}else{
											$('#visit_charge').show();
											$('#visit_input').show();
											$('#visit_charge').text($('#opd_id option:selected').text()+' :'+data1.charges['TariffAmount']['non_nabh_charges']);
										    $('#visit_input').val(data1.charges['TariffAmount']['non_nabh_charges']);
										    calTotal();
										}
									}
								}
							}
						}else{
							$('#pay_charge').attr('checked',false);
						 }
						
					 }
					$('#submit').show();
				} 
	        });
			}
	        <?php }?>
			
		});

		
		$('#applyPackage').click(function(){
			if($( this ).is(":checked")) 
			$.fancybox({
	            'width'    : '95%',
			    'height'   : '90%',
			    'autoScale': true,
			    'transitionIn': 'fade',
			    'transitionOut': 'fade',
			    'type': 'iframe',
			    'href': "<?php echo $this->Html->url(array("controller" => "Estimates", "action" => "packageEstimate",'null',$personID)); ?>" +'?admittedPatient=1'
		    });
		});
		
	/*	$( "#extra2,#extra1" ).click(function(){
			 var todate = new Date($('#nutritionalAssessOn').val());
				 var fromdate = new Date($('#nutritionalAssessEndOn').val());
				 if(fromdate.getTime() < todate.getTime()) {
			   	 alert("*Start of Nutritional Assessment can not be greater than End of Nutritional Assessment");	 
			     return false; 
			    }	
			});*/

			
			//For resetting the charges on change of doctor or tariff - Vadodara
			function resetTariff(args){
				if(args=='0'){
					$('#opd_id').val('');
					$('#visit_charge').hide();
					$('#visit_input').hide();
					$('#visit_charge').text('');
				    $('#visit_input').val('');
				    calTotal();
				}else{
					$('#opd_id_'+args).val('');
					$('#visit_charge_'+args).hide();
					$('#visit_input_'+args).hide();
					$('#visit_charge_'+args).text('');
				    $('#visit_input_'+args).val('');
				    calTotal();
				}

			}

			$('#tariff').change(function(){
				resetAllTariff();
			});

			//For resetting All the charges on change of doctor or tariff - Vadodara
			function resetAllTariff(){
				for(var i=0;i<=counterApp;i++){
					if(i=='0'){
						$('#opd_id').val('');
						$('#visit_charge').hide();
						$('#visit_input').hide();
						$('#visit_charge').text('');
					    $('#visit_input').val('');
					    calTotal();
					}else{
						$('#opd_id_'+i).val('');
						$('#visit_charge_'+i).hide();
						$('#visit_input_'+i).hide();
						$('#visit_charge_'+i).text('');
					    $('#visit_input_'+i).val('');
					    calTotal();
					}

				}

			}

			var counterApp='<?php echo $countApp+1;?>';
			function addFields(){
				var appendOption= "<option value=''>Please Select</option>";
				$("#multiAppTable")
				.append($('<tr>').attr({'id':'multiRow_'+counterApp})
					.append($('<td>').append($('<select>').attr({'id':'doctor_id_'+counterApp,'class':'textBoxExpnd validate[required,custom[mandatory-select]] doctorApp','type':'select','name':'Appointment[doctor_id][]'}).append(appendOption)))
					.append($('<td>').append($('<select>').attr({'id':'department_id_'+counterApp,'disabled':'disabled','class':'textBoxExpnd department_id','type':'select','name':'Appointment[department_id][]'}).append(appendOption)))
					.append($('<input>').attr({'type':'hidden','id':'department_id-'+counterApp,'class':'textBoxExpnd validate[required,custom[mandatory-enter]]','name':'Appointment[department_id][]'}))
		    		.append($('<td>').append($('<select>').attr({'id':'opd_id_'+counterApp,'disabled':'disabled','class':'textBoxExpnd validate[required,custom[mandatory-select]] visitApp','type':'select','name':'Appointment[treatment_type][]'}).append(appendOption)))
					//.append($('<input>').attr({'type':'hidden','id':'opd_val_'+counterApp,'name':'Appointment[treatment_type][]'}))
					.append($('<td>').append($('<font>').attr({'size':"3px" , 'color':"#F48F5B" , 'style':"font-weight: bold;"}).append($('<span>').attr({'id':'visit_charge_'+counterApp})).append($('<input>').attr({'type':'hidden','id':'visit_input_'+counterApp,'name':'Appointment[visit_charge][]'}))))
					.append($('</span></font></td>'))
					.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
							.attr({'class':'removeButton','id':'removeButton_'+counterApp,'title':'Remove current row'}).css('float','right')))
					.append($('</tr>'))
					);
				
				var doctorList = <?php echo json_encode($opddoc);?>;
				$.each(doctorList, function(val, text) {
				    $('#doctor_id_'+counterApp).append( "<option value='"+val+"'>"+text+"</option>" );
				});

				var departmentList=<?php echo json_encode($departments);?>;
				$.each(departmentList, function(val, text) {
				    $('#department_id_'+counterApp).append( "<option value='"+val+"'>"+text+"</option>" );
				});

				var visitList=<?php echo json_encode($opdOptions);?>;
				$.each(visitList, function(val, text) {
				    $('#opd_id_'+counterApp).append( "<option value='"+val+"'>"+text+"</option>" );
				});  
				counterApp++;
			}
			$('.removeButton').on('click',function(){
				currentId=$(this).attr('id');
				splitedId=currentId.split('_');
				ID=splitedId['1'];
				$("#multiRow_"+ID).remove();	
				counterApp--;
				calTotal();
			});

			function calTotal(){
                var total=0;
for(var i=0;i<=counterApp;i++){
	if(i=='0'){
		vamt=parseInt($('#visit_input').val());
		if(isNaN(vamt))
			vamt=0;
		total=parseInt(total)+parseInt(vamt);
	}else{
		camt=parseInt($('#visit_input_'+i).val());
		if(isNaN(camt))
			camt=0;
		total=parseInt(total)+parseInt(camt);
	}
}
                $('#totAmt').val(total);//bill service amount
                total = total - parseInt($('#couponAmount').val());
                total = total < 0 ? 0 : total;
                $('#total').text(total);//show discounted amount

}

 $("#relation").change(function(){
		var relation = $(this).val();
		if(relation != 'self'){
			 $("#showBeneficiaryBlock").show();
		}else{
			$("#showBeneficiaryBlock").hide();
		}
 });

 function getReferral(){
		var patientID = '<?php echo $this->params->query['patient_id'];?>';	
		var refferalType = '<?php echo $this->data['Patient']['known_fam_physician'];?>';	
	    var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "getAssigenedRefferalDoctor","admin"=>false)); ?>";
	    $.ajax({
	        beforeSend : function() {
	            $('#busy-indicator').show('fast');	
	        },
	        url: ajaxUrl+"/"+patientID+"/"+refferalType,
	        dataType: 'html',
	        success: function(data){
	            obj=$.parseJSON(data);
	            if(obj!='' && obj != null ){
	           	 $("#refferalDoctorArea").show();
	     		 $("#refferalDocSearch").show();
	     		 $("#refferalDocSearch").css({ display: "block" });
	                    $.each(obj, function(key, val) {
	                        var doctorId=key;
	                        var doctorName=val;
	                        //img= '<a href="javascript:void(0);" class="removeRow" id=remove_'+doctorId+'> <img src="<?php echo $this->webroot ?>theme/Black/img/cross.png" alt="Remove Row" title="Remove Row" /></a>'; // only admin can edit referral from edit patient page
			    	    	inputVar  = '<input class="service-box" type="hidden" name="data[Patient][consultant_id][]" value='+doctorId+'>';// to maintain hidden values 
			    	    	li = $('<tr id=refferalTr_'+doctorId+' class=""><td colspan = "2"><span style="float:left">'+ doctorName + '</span><span>'+inputVar+'</span></td></tr>'); 
	                        li.appendTo('.top');
	                    });
	              
	                $('#busy-indicator').hide('fast');	
			   		
	            }else{
	            	$("#refferalDoctorArea").show();
		     		$("#refferalDocSearch").show();
		     		//img= '<a href="javascript:void(0);" class="removeRow" id="remove_None"> <img src="<?php echo $this->webroot ?>theme/Black/img/cross.png" alt="Remove Row" title="Remove Row" /></a>';// only admin can edit referral from edit patient page
	    	    	inputVar  = '<input class="service-box" type="hidden" name="data[Patient][consultant_id][]" value="None">';// to maintain hidden values 
	    	    	li = $('<tr id="refferalTr_None"  class=""><td colspan = "2"><span style="float:left">None</span><span>'+inputVar+'</span></td></tr>'); 
	    	    	li.appendTo('.top');
	                $('#busy-indicator').hide('fast');	
	                return false;
	            }
	        },
	        messages: {
	            noResults: '',
	            results: function() {}
	        }
	    });
}

 function refferalAutocomplete(category){
	  $('#searchDoctor').autocomplete({
		    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "getRefferalDoctor","admin" => false,"plugin"=>false)); ?>"+"/"+category,
		    setPlaceHolder : false,
		    select: function(event,ui){	
		    	    var doctorName=ui.item.value;	    	        	    		
			    	var doctorId=ui.item.id;	 
			    	$('.service-box').each(function() { //check for duplicate 
	                    if(doctorId == this.value){ 
		                    if(category == 7){
		                    	alert('Camp Date already selected!!'); 
			                  }else{
		                  		 alert('This Referral Doctor already added!!'); 
			                  }
		                   $("#refferalTr_"+doctorId).remove();
	                    }
	                });
			    	    				  
		    	    	$("#refferalDoctorArea").find('tbody')
			    	    img= '<a href="javascript:void(0);" class="removeRow" id=remove_'+doctorId+'> <img src="<?php echo $this->webroot ?>theme/Black/img/cross.png" alt="Remove Row" title="Remove Row" /></a>';
		    	    	inputVar  = '<input class="service-box" type="hidden" name="data[Patient][consultant_id][]" value='+doctorId+'>';// to maintain hidden values 
		    	    	li = $('<tr id=refferalTr_'+doctorId+' class=""><td><span style="float:left">'+ doctorName + '</span><span>'+inputVar+'</span></td><td style="width: 5%">'+ img +'</td></tr>'); 
		    	    	li.appendTo('.top');

		    	    	//validation if refferal not selected
		    	    	var rowsCount = document.getElementById('refferalDoctorArea').rows.length;
		                    if(rowsCount == 0){
		                    	$("#refferalDocSearch").css({ display: "block" });
		                    	$("#searchDoctor").addClass("validate[required,custom[mandatory-select]]");
			                 }else{
			                	 $("#refferalDocSearch").css({ });
			                	 $("#searchDoctor").removeClass("validate[required,custom[mandatory-select]]");
				             }

		    	    	this.value = "";
		    	    	return false ;	
		    	        	    	
		    	 },
		    	  messages: {
		    	    noResults: '',
		    	    results: function() {},
		    	 },
		});
	}
</script>
			<?php //$this->Form
		$countApp=0; 
	function multiApp($formData,$doctorlist,$departments,$opdoptions){
		
		$multiAppHtml='<table id=multiAppTable width="100%" style="padding:0px 0px 0px 5px; ">';
		$multiAppHtml.='<tr>';					
		$multiAppHtml.='<td width="20%"><b>Treating Consultant</b></td>';
		$multiAppHtml.='<td width="20%"><b>Speciality</b></td>';
		$multiAppHtml.='<td width="20%"><b>Visit Type</b></td>';
		$multiAppHtml.='<td><b>Visit Charges</b></td>';
		$multiAppHtml.='</tr>';
		$multiAppHtml.='<tr id=multiRow_0>';
		$multiAppHtml.='<td>';
		$multiAppHtml.=$formData->input('Patient.doctor_id', array('empty'=>__('Please Select'),'options'=>$doctorlist,'label'=>false,
 							'class' => "textBoxExpnd validate[required,custom[mandatory-select]] ",'id' => 'doctor_id',
							'value'=>Configure::read('default_doctor_selected') ));
  		$multiAppHtml.='</td>';
  		$multiAppHtml.='<td>';
  		$multiAppHtml.=$formData->input('Patient.department_id', array('empty'=>__('Please Select'),'options'=>$departments,'id'=>'department_id','label'=>false,'class' => 'textBoxExpnd department_id', 'disabled'=>'disabled','value'=>''));
		$multiAppHtml.=$formData->hidden('',array('name'=>"data[Patient][department_id]",'id'=>'d_id'));
  		$multiAppHtml.='</td>';
  		$multiAppHtml.='<td>';
  		$multiAppHtml.=$formData->input('Patient.treatment_type', array('empty'=>__('Please Select'),'options'=>$opdoptions,'label'=>false,
 								'class' => "textBoxExpnd validate[required,custom[mandatory-select]] visitApp",'id' => 'opd_id' ));
  		$multiAppHtml.='</td>';
  		$multiAppHtml.='<td><font size="3px" color="#F48F5B" style="font-weight: bold;">';
		$multiAppHtml.=$formData->input('Person.visit_charge',array('type'=>'hidden','id'=>'visit_input','div'=>false,'label'=>false));
		$multiAppHtml.='<span id="visit_charge"></span></font></td>';
		$multiAppHtml.='</tr>';
		$multiAppHtml.='<tr>';
		$multiAppHtml.='</tr>';
		$multiAppHtml.='</table>';
		return $multiAppHtml;

	}


?>
