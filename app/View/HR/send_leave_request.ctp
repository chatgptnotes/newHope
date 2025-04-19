<style>
 .textBoxExpnd{
 width: 40.3%;
 }

 .textboxwidth{
 width: 90.3%;
 }
</style>

<div class="inner_title">
	<h3>
		<?php echo __('', true); ?>
	</h3>
	<span> <?php
	//echo $this->Html->link(__('Back'), array('controller'=>'SmartPhrases','action'=>'diagnosis_list'), array('escape' => false,'class'=>'blueBtn back'));

	?>
	</span>

</div>

<div class="clr ht5" style="height: 25px"></div>

<?php  echo $this->Form->create('',array('type' => 'file','id'=>'LeaveForm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));?>

<table width="38%"  border="0"
	cellspacing="0" cellpadding="0" class="" align="center">
	<tr><td style="color: #3185AC;font-size: 16px"><strong>Apply Leave</strong></td></tr>
	<tr><td height="15px"></td></tr>
	</table>
<table width="38%"  border="0"
	cellspacing="0" cellpadding="0" class="formFull" align="center">
    
    <tr><td height="15px"></td></tr>
    
	<tr>
		<td  valign="middle" class="tdLabel" id="boxSpace"><font color="red">*</font>Employee ID</td>
		
		
		<td width="250"><?php echo $this->Form->input('SnomedMappingMaster.icd9name',
				array('type'=>'select','id'=>'name', 'class'=>"textBoxExpnd validate[required,custom[mandatory-enter]]",
							 'tabindex'=>1,'div'=>false,'label'=>false));?>
		</td>

		
	</tr>

		<tr>
		<td width="100" valign="middle" class="tdLabel" id="boxSpace"><font color="red">*</font>Leave Type</td>
	
		
		<td width="250"><?php echo $this->Form->input('SnomedMappingMaster.icd9name',
				array('type'=>'select','id'=>'name', 'class'=>"textBoxExpnd validate[required,custom[mandatory-enter]]",
							 'tabindex'=>1,'div'=>false,'label'=>false));?>
		</td>

		
	</tr>
		<tr>
		<td colspan="2">
		<table border="0" width="100%" cellspacing="0" cellpadding="0" class="" align="center">
	        <tr>
	        	<td width="104" valign="middle" class="tdLabel" id="boxSpace"><font color="red">*</font>From</td>
		        <td width="100" valign="middle" class="tdLabel" id="boxSpace"><?php 
		    		echo $this->Form->input('', array('id'=>'fromDate','value'=>$this->request->query['from'] ,'label'=> false, 'div' => false, 'error' => false)); 
		    	?></td>
	
		        <td width="18" valign="" class="" id=""><font color="red">*</font>To</td>
				<td width="100" valign="middle" class="tdLabel" id="boxSpace"><?php 
			    		echo $this->Form->input('', array('id'=>'toDate','value'=>$this->request->query['to'] ,'label'=> false, 'div' => false, 'error' => false)); 
			    	?></td>
		</tr></table></td>
	</tr>
       	<tr>
		<td width="100" valign="middle" class="tdLabel" id="boxSpace">Team Email ID</td>
	
		
		<td width="250"><?php echo $this->Form->input('SnomedMappingMaster.icd9name',
				array('type'=>'text','id'=>'name','width'=>'20%', 'class'=>"textboxwidth validate[required,custom[mandatory-enter]]",
							 'tabindex'=>1,'div'=>false,'label'=>false));?>
		</td>

		
	</tr>

       	<tr>
		<td width="100" valign="middle" class="tdLabel" id="boxSpace">Reason For Leave</td>
		
		
		<td width="250"><?php echo $this->Form->input('SnomedMappingMaster.icd9name',
				array('type'=>'textarea','rows'=>'1','cols'=>'2','id'=>'name', 'class'=>" ",
							 'tabindex'=>1,'div'=>false,'label'=>false));?>
		</td>

		
	</tr>
	<tr><td height="15px"></td></tr>
	
</table>

<div style="text-align:center;padding-top: 10px">	<?php
                                		 
                                		echo $this->Form->submit(__('Save'), array('id'=>'save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
                                		echo "&nbsp;".$this->Form->submit(__('Save & New'), array('id'=>'','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
                                		//echo $this->Html->link(__('Cancel'), array('controller'=>'HR','action' => 'send_leave_request'), array('escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));
                                		echo "&nbsp;".$this->Html->link('Cancel',array('controller'=>'Reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));
                                		?></div>
<?php echo $this->Form->end();?>

<script>
$(document).ready(function(){

$("#fromDate").datepicker
({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});	
		
 $("#toDate").datepicker
 ({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: 'dd/mm/yy',			
	});


		$("#save").click(function(){
			var valid=jQuery("#LeaveForm").validationEngine('validate');
			if(valid){
				return true;
			}else{
				return false;
			}
			});

	});
</script>
