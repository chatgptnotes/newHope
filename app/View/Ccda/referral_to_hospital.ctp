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
		 $("#transitioned_date").datepicker({
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
		 $("#summary_of_care_provided_date").datepicker({
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
		 $("#follow_up_date").datepicker({
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
		 $("#discharge_date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '-100:' + new Date().getFullYear(),	
			////maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
			onSelect:function(){$(this).focus();}
		});

	});
	 
	 
</script>

<div class="inner_title">
  <h3><?php echo __('Referral to hospital'); ?></h3>
  <span><?php 
	echo $this->Html->link(__('Back', true),array('controller'=>'PatientsTrackReports','action' => 'sbar',$patientID,'Summary'), array('escape' => false,'class'=>'blueBtn'));
  ?></span>  
 </div>
 <?php echo $this->element('patient_information');?>
   <p class="ht5"></p>  
   
    
   <?php echo $this->Form->create('ReferralToHospital',array('id'=>'ReferralToHospital','url'=>array("controller" => 'Ccda', "action" => "referralToHospital",$patientID)));?>	
   <?php 
        echo $this->Form->input('ReferralToHospital.id', array('type'=>'hidden', 'value'=> $this->data['ReferralToHospital']['id'], 'id'=>'patient_id','label'=> false, 'div' => false));
   ?>
   
	
	<div class="clr ht5"></div>
	<table width="70%" border="0" cellspacing="0" cellpadding="0" class="tabularForm" align='center'>
                      <tr>
                      	 <th colspan="2"><?php echo __('Referral to hospital')?></th>
                      </tr>
                      <tr>
                        <td width="50%" align="left" valign="top" style="padding-top:7px;">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                            <!--   <tr>
	                                <td width="40%" class="tdLabel"><?php echo __('Patient name')?><font color="red">*</font> </td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToHospital.patient_name', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'patient_name','label'=>false)); ?>
	                                </td>
                               </tr>
                              <tr>
	                                <td class="tdLabel"><?php echo __('Gender')?></td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToHospital.gender', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'gender','label'=>false)); ?>
	                                </td>
                              </tr>
                              <tr>
	                                <td class="tdLabel"><?php echo __('Date of Birth (Age)')?></td>
	                                <td>
	                                  <?php echo $this->Form->input('ReferralToHospital.dob', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'dob','label'=>false)); ?>
	                                </td>
                              </tr> -->
                               <tr>
	                                <td width="40%" class="tdLabel"><?php echo __('Ordering Provider')?></td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToHospital.provider', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'provider','label'=>false,'autocomplete'=>'off')); ?>
	                                </td>
                               </tr>
                              
                               <tr>
	                                <td class="tdLabel"><?php echo __('Transitioned to')?></td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToHospital.transitioned_to', array('empty'=>__('Please Select'),'options'=>array("Hospital"=>"Hospital","ER"=>"ER","Other care setting"=>"Other care setting"),'class' => 'textBoxExpnd','id' => 'transitioned_to','label'=> false));?>
	                                </td>
                               </tr>
                              <tr>
	                                <td class="tdLabel"><?php echo __('Name of Hospital/ER')?></td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToHospital.name_of_er', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'name_of_er','label'=>false,'autocomplete'=>'off')); ?>
	                                </td>
                               </tr>
                              <tr>
	                                <td class="tdLabel"><?php echo __('Location of Hospital/ER')?></td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToHospital.location_of_er', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'location_of_er','label'=>false,'autocomplete'=>'off')); ?>
	                               	 </td>
                               </tr>
                                <tr>
	                                <td class="tdLabel"><?php echo __('Department in Hospital/ER')?></td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToHospital.department_of_er', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'department_of_er','label'=>false,'autocomplete'=>'off')); ?>
	                                </td>
                               </tr>
                               <tr>
	                                <td class="tdLabel"><?php echo __('Date transitioned to')?></td>
	                                <td>
	                                <?php 
										echo $this->Form->input('ReferralToHospital.transitioned_date', array('class'=>'textBoxExpnd','type'=>'text','id'=>'transitioned_date','autocomplete'=>'off','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly', 'value' => $this->DateFormat->formatDate2Local($this->data['ReferralToHospital']['transitioned_date'],Configure::read('date_format'), true)));
									?>
	                                </td>
                               </tr>
                               <tr>
	                                <td class="tdLabel"><?php echo __('Date summary of care provided')?></td>
	                                <td>
	                                 <?php 
										echo $this->Form->input('ReferralToHospital.summary_of_care_provided_date', array('class'=>'textBoxExpnd','type'=>'text','id'=>'summary_of_care_provided_date','autocomplete'=>'off','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly', 'value' => $this->DateFormat->formatDate2Local($this->data['ReferralToHospital']['summary_of_care_provided_date'],Configure::read('date_format'), true)));
									?>
	                                </td>
                               </tr>
                               <tr>
	                                <td class="tdLabel"><?php echo __('If summary of care not provided, Reason')?></td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToHospital.reason', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'department_of_er','label'=>false,'autocomplete'=>'off')); ?>
	                                </td>
                               </tr>
                               
                               <tr>
	                                <td class="tdLabel"><?php echo __('Dates of follow up with Hospital')?></td>
	                                <td>
	                                 <?php 
										echo $this->Form->input('ReferralToHospital.follow_up_date', array('class'=>'textBoxExpnd','type'=>'text','id'=>'follow_up_date','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly', 'value' => $this->DateFormat->formatDate2Local($this->data['ReferralToHospital']['follow_up_date'],Configure::read('date_format'), true)));
									?>
	                                </td>
                               </tr>
                                <tr>
	                                <td class="tdLabel"><?php echo __('Log of follow up call')?></td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToHospital.log', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'log','label'=>false,'autocomplete'=>'off')); ?>
	                                </td>
                               </tr>
                               <tr>
	                                <td class="tdLabel"><?php echo __('Date hospital discharge summary obtained')?></td>
	                                <td>
	                                 <?php 
										echo $this->Form->input('ReferralToHospital.discharge_date', array('class'=>'textBoxExpnd','type'=>'text','id'=>'discharge_date','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly', 'value' => $this->DateFormat->formatDate2Local($this->data['ReferralToHospital']['discharge_date'],Configure::read('date_format'), true)));
									?>
	                                </td>
                               </tr>
                               <tr>
	                                <td class="tdLabel"><?php echo __('Follow up appointment')?></td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToHospital.follow_up_appointment', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'follow_up_appointment','label'=>false,'autocomplete'=>'off')); ?>
	                                </td>
                               </tr>
                               <tr>
	                                <td class="tdLabel"><?php echo __('Written transition care plan')?></td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToHospital.care_plan', array('style'=>'width:420px;','class'=>'textBoxExpnd', 'type'=>'text','id' => 'care_plan','label'=>false,'autocomplete'=>'off')); ?>
	                                </td>
                               </tr>
                                <tr>
	                                <td class="tdLabel"><?php echo __('Status')?></td>
	                                <td>
	                                 <?php echo $this->Form->input('ReferralToHospital.status', array('empty'=>__('Please Select'),'options'=>array("In care setting"=>"In care setting","Discharged"=>"Discharged","Follow up"=>"Follow up","Closed"=>"Closed",'Readmit'=>'Readmit'),'class' => 'textBoxExpnd','id' => 'transitioned_to','label'=> false));?>
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
	 jQuery("#ReferralToHospital").validationEngine();
});
</script>