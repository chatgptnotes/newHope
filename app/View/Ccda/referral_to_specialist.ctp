
 <style>
.tddate img{float:inherit;}
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
</style>
<?php 
  echo $this->Html->script('jquery.autocomplete');
  echo $this->Html->css('jquery.autocomplete.css');  
?>
<style>
	.tabularForm td td{
	padding:0px;
	font-size:13px;
	
	}
	.tabularForm th td{
	padding:0px;
	font-size:13px;
	color:#e7eeef;
	background:none;
	}

</style>
<script>
	$(document).ready(function(){
		 $("#referral_initiated_date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),	
			//maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
			onSelect:function(){$(this).focus();}
		});
	});
	$(document).ready(function(){
		 $("#date_summary").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),	
			//maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
			onSelect:function(){$(this).focus();}
		});
	});
	$(document).ready(function(){
		 $("#appointment_date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),	
			//maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
			onSelect:function(){$(this).focus();}
		});
	});
	$(document).ready(function(){
		 $("#expected_date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),	
			//maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
			onSelect:function(){$(this).focus();}
		});
	});
	$(document).ready(function(){
		 $("#report_date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),	
			//maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
			onSelect:function(){$(this).focus();}
		});
	});
	 
</script>

<div class="inner_title">
  <h3><?php echo __('Referral to Specialist'); ?></h3>
  <span><?php 
	echo $this->Html->link(__('Back', true),array('controller'=>'PatientsTrackReports','action' => 'sbar',$patientID,'Summary'), array('escape' => false,'class'=>'blueBtn'));
  ?></span>  
 </div>
 <?php echo $this->element('patient_information');?>
   <p class="ht5"></p>  
   
    
   <?php echo $this->Form->create('ReferralToSpecialist',array('id'=>'ReferralToSpecialistss','url'=>array("controller" => 'Ccda', "action" => "referralToSpecialist",$patientID))); 
        echo $this->Form->input('ReferralToSpecialist.id', array('type'=>'hidden', 'value'=> $this->data['ReferralToSpecialist']['id'], 'id'=>'patient_id','label'=> false, 'div' => false));
   ?>
   
	
	<div class="clr ht5"></div>
	<table width="70%" border="0" cellspacing="0" cellpadding="0" class="tabularForm" align='center'>
                      <tr>
                      	 <th colspan="2"><?php echo __('Referral to Specialist')?></th>
                      </tr>
                      <tr>
                        <td width="50%" align="left" valign="top" style="padding-top:7px;">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                            <!--   <tr>
	                                <td width="40%" class="tdLabel"><?php echo __('Patient name')?> </td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToSpecialist.patient_name', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'patient_name','label'=>false)); ?>
	                                </td>
                               </tr>
                              <tr>
	                                <td class="tdLabel"><?php echo __('Gender')?></td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToSpecialist.gender', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'gender','label'=>false)); ?>
	                                </td>
                              </tr>
                              <tr>
	                                <td class="tdLabel"><?php echo __('Date of Birth (Age)')?></td>
	                                <td>
	                                  <?php echo $this->Form->input('ReferralToSpecialist.dob', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'dob','label'=>false)); ?>
	                                </td>
                              </tr> -->
                               <tr>
	                                <td width="40%" class="tdLabel"><?php echo __('Ordering Provider')?></td>
	                                 <td>
	                                 <?php echo $this->Form->input('ReferralToSpecialist.provider', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'provider','label'=>false,'autocomplete'=>'off')); ?>
	                                </td>
                               </tr>
                               <tr>
	                                <td class="tdLabel"><?php echo __('Test or appointment Ordered')?></td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToSpecialist.appt_order', array('empty'=>__('Please Select'),'options'=>array("Surgeryconsult"=>"Surgeryconsult","Ortho consult"=>"Ortho consult","OBG/GYN consult"=>"OBG/GYN consult"),'class' => 'textBoxExpnd','id' => 'appt_order','label'=> false));?>
	                                </td>
                               </tr>
                               <tr>
	                                <td class="tdLabel"><?php echo __('Referred to')?></td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToSpecialist.referred_to', array('empty'=>__('Please Select'),'options'=>array("Specialist"=>"Specialist","caregivers"=>"caregivers","Others"=>"Others"),'class' => 'textBoxExpnd','id' => 'referred_to','label'=> false));?>
	                                </td>
                               </tr>
                               <tr>
	                                <td width="40%" class="tdLabel"><?php echo __('Name of Specialist')?> </td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToSpecialist.specialist_name', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'specialist_name','label'=>false)); ?>
	                                </td>
                               </tr>
                               <tr>
	                                <td width="40%" class="tdLabel"><?php echo __('Location of Specialist')?> </td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToSpecialist.location_specialist', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'location_specialist','label'=>false)); ?>
	                                </td>
                               </tr>
                               <tr>
	                                <td width="40%" class="tdLabel"><?php echo __('Speciality of Specialist')?> </td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToSpecialist.speciality_specialist', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'speciality_specialist','label'=>false)); ?>
	                                </td>
                               </tr>
                               <tr>
	                                <td class="tdLabel"><?php echo __('Referral initiated date')?></td>
	                                <td>
	                                 <?php 
										echo $this->Form->input('ReferralToSpecialist.referral_initiated_date', array('class'=>'textBoxExpnd','type'=>'text','id'=>'referral_initiated_date','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly', 'value' => $this->DateFormat->formatDate2Local($this->data['ReferralToSpecialist']['referral_initiated_date'],Configure::read('date_format'), true)));
									?>
	                                </td>
                               </tr>
                               <tr>
	                                <td class="tdLabel"><?php echo __('Date summary of care provided')?></td>
	                                <td>
	                                 <?php 
										echo $this->Form->input('ReferralToSpecialist.date_summary', array('class'=>'textBoxExpnd','type'=>'text','id'=>'date_summary','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly', 'value' => $this->DateFormat->formatDate2Local($this->data['ReferralToSpecialist']['date_summary'],Configure::read('date_format'), true)));
									?>
	                                </td>
                               </tr>
                                <tr>
	                                <td width="40%" class="tdLabel"><?php echo __('If summary of care not provided, Reason')?> </td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToSpecialist.reason', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'reason','label'=>false)); ?>
	                                </td>
                               </tr>
                               <tr>
	                                <td class="tdLabel"><?php echo __('Appointment date and time with specialist')?></td>
	                                <td>
	                                 <?php 
										echo $this->Form->input('ReferralToSpecialist.appointment_date', array('class'=>'textBoxExpnd','type'=>'text','id'=>'appointment_date','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly', 'value' => $this->DateFormat->formatDate2Local($this->data['ReferralToSpecialist']['appointment_date'],Configure::read('date_format'), true)));
									?>
	                                </td>
                               </tr>
                               <tr>
	                                <td class="tdLabel"><?php echo __('Expected date of receiving report')?></td>
	                                <td>
	                                 <?php 
										echo $this->Form->input('ReferralToSpecialist.expected_date', array('class'=>'textBoxExpnd','type'=>'text','id'=>'expected_date','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly', 'value' => $this->DateFormat->formatDate2Local($this->data['ReferralToSpecialist']['expected_date'],Configure::read('date_format'), true)));
									?>
	                                </td>
                               </tr>
                                <tr>
	                                <td width="40%" class="tdLabel"><?php echo __('Log of effort to retrieve the report')?> </td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToSpecialist.log', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'log','label'=>false)); ?>
	                                </td>
                               </tr>
                               <tr>
	                                <td class="tdLabel"><?php echo __('Date report obtained')?></td>
	                                <td>
	                            <?php 
										echo $this->Form->input('ReferralToSpecialist.report_date', array('class'=>'textBoxExpnd','type'=>'text','id'=>'report_date','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly', 'value' => $this->DateFormat->formatDate2Local($this->data['ReferralToSpecialist']['report_date'],Configure::read('date_format'), true)));
									?>
	                                </td>
                               </tr>
                               <tr>
	                                <td class="tdLabel"><?php echo __('Status')?></td>
	                                <td>
	                              <?php  $option = array('Initiated referral'=>'Initiated referral','contacted specialist for appointment'=>'contacted specialist for appointment','contacted specialist for overdue'=>'contacted specialist for overdue','Received report- Normal'=>'Received report- Normal','Overdue reply'=>'Overdue reply','Received report-Abnormal'=>'Received report-Abnormal' , 'Received report- Critical alert'=>'Received report- Critical alert', 'Patient did not report to specialist'=>'Patient did not report to specialist');
	                                  echo $this->Form->input('ReferralToSpecialist.status', array('empty'=>__('Please Select'),'options'=>$option,'class' => 'textBoxExpnd','id' => 'status','label'=> false));?>
	                                </td>
                               </tr>
                               
                       	  </table>
                        </td>
                      </tr>
                      <tr>
                      <td align="right"> <?php echo $this->Form->submit(__('Submit'),array('id'=>'submit','value'=>"Submit",'class'=>'blueBtn','div'=>false,'style'=>'margin-right: 23px;'));?></td>
                      </tr>
                    </table> 
                    
                    

<div class="clr ht5"></div>
<?php echo $this->Form->end(); ?> 
<script>

$("#doctor_id_txt").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","DoctorProfile",'user_id',"doctor_name",'null','null','yes',"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	valueSelected:true,
	showNoId:true,
	loadId : 'doctor_id_txt,doctorID',
	onItemSelect:function () { 
		getDoctorSpecialty();
	}
});
getDoctorSpecialty();
function getDoctorSpecialty(){
	var doctorId = $("#doctorID").val();
	 
	if(doctorId)
	$.ajax({
    	url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "getDoctorsDept", "admin" => false)); ?>"+"/"+doctorId,
    	context: document.body,          
		success: function(data){ 
    		$('.department_id').val(parseInt(data)); 
		}
    });
}
$(document).ready(function(){ 
	 jQuery("#ReferralToSpecialistss").validationEngine();
});
</script>
