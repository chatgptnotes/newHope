<?php echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');?>
<style>
.tddate img {
	float: inherit;
}
</style>
<div id="flashMessage"></div>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Allergy List', true); ?>
	</h3>
</div><?php 
if($status == "success"){?>
		<script> 
			jQuery(document).ready(function() { 
			//parent.location.reload(true);
			 $( '#flashMessage', parent.document).html("Allergy saved succesfully.");
			$('#flashMessage', parent.document).show();
			parent.$.fancybox.close(); 
		});
		</script>
<?php   } ?>
<?php if(!isset($this->request->params['pass']['3'])){?>
<div class="patient_info">
	<?php //echo $this->element('patient_information');?>
</div>

<?php 	echo $this->Form->create('NewCropAllergies',array('url'=>array('controller'=>'Patients','action'=>'allallergies',$patient_id),'id'=>'doctortemplatefrm', 'inputDefaults' => array('label' => false,'div' => false)));
echo $this->Form->hidden('id');
?>

<table border="0" class="table_format" cellpadding="0" cellspacing="2"
	width="70%">
	<tr>
		<td width="10% !important" style="font-size: 13px;"><?php echo __('Allergy Name');?>:<font
			color="red">*</font>
		</td>
		<td width="15%"><?php echo $this->Form->input('NewCropAllergies.name', array('type'=>'text','error' => false,'class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd', 'id' => 'name','autocomplete'=>false)); ?>
		<?php echo  $this->Form->hidden('NewCropAllergies.CompositeAllergyID',array('id'=>'nameId'));?>
		</td>

		<td width="10%" style="font-size: 13px;" valign="top"><?php echo __('Severity Level');?>:<font
			color="red">*</font></td>
		<td width="33%" valign="top"><?php echo $this->Form->input('NewCropAllergies.AllergySeverityName', array('empty'=>__('Please Select'),'options'=>array("Mild"=>"Mild","Moderate"=>"Moderate","Severe"=>"Severe"),'value'=>$this->request->data['NewCropAllergies']['AllergySeverityName'],'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'AllergySeverityName','label'=> false)); ?>
		</td>
	</tr>
	<tr>
		<td width="10%" style="font-size: 13px;"><?php echo __('Allergy Reaction');?>:</td>
		<td width="30%"><?php echo $this->Form->input('NewCropAllergies.reaction', array('class'=>'textBoxExpnd', 'type'=>'text','id' => 'reaction')); ?>
		</td>
		<td style="font-size: 13px;"><?php echo __('Onset Date');?>:<font
			color="red">*</font></td>
		<td><?php echo $this->Form->input('NewCropAllergies.onset_date', array('readonly'=>'readonly','type'=>'text','class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','id' => 'onset_date')); ?>
		</td>
	</tr>
<tr>
		<td width="10%"style="font-size: 13px" valign="top"><?php echo __("Status");?>:</td>
		<td width="26%" style="padding-right:21px;" valign="top"><?php 
          echo $this->Form->input('NewCropAllergies.status', array('class'=>'textBoxExpnd','options' => array('A'=>'Yes','No'=>'No'),'value'=>$this->request->data['NewCropAllergies']['status'],'id' => 'status', 'label'=> false, 'div' => false, 'error' => false));?>
		</td>
		<?php echo $this->Form->input('patient_uniqueid',array('type'=>'hidden','value'=>$patient_id));?>
		<td><?php echo $this->Form->input('id',array('type'=>'hidden'));?></td>
		<td class="row_format" align="left" colspan="1"><?php
		echo $this->Form->submit(__('Submit'), array('id'=>'submit','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
		?>
		</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<?php 
 if(count($allergies_data)== 0 || count($allergies_data)== 1 && $allergies_data[0]['NewCropAllergies']['name'] == "No Known Allergy") { ?>
<?php $checked = ($allergies_data[0]['NewCropAllergies']['name'] == "No Known Allergy") ? true : false; 
 		$disabled = ($allergies_data[0]['NewCropAllergies']['name'] != "No Known Allergy" || !empty($allergies_data)) ? false : true;?>
<table>
	<tr>
		<td style="padding-left: 15px;"><?php echo $this->Form->input('NewCropAllergies.name', array('type'=>'checkbox','id'=>'namecheck',
										'checked'=>$checked,'disabled'=>$disabled,'label'=> false, 'div' => false, 'error' => false));?>
		</td>
		<td style="font-size: 13px;"><?php echo __("No Known Medication Allergies");?></td>
	</tr>
</table>
<?php }?>
<?php } ?>
<?php 
 if(count($allergies_data)!=0 && $allergies_data[0]['NewCropAllergies']['name'] != "No Known Allergy") { ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" style="margin-left: -32px">
	<tr>
		<td width='80px'></td>
		<td valign='top'></td>
	</tr>
	<tr><td width='20px'></td><td style="padding-left:17px">Current Allergies</td></tr>
	<tr>
		<td width='20px'></td>
		<td>
			<table border="0" class="table_format" cellpadding="0"
				cellspacing="0" width="97%">
				<tr class="row_title">
					<td class="table_cell"><strong>Sr. #</strong></td>
					<td class="table_cell"><strong>Name</strong></td>
					<td class="table_cell"><strong>Reaction</strong></td>
					<td class="table_cell"><strong>Status</strong></td>
					<td class="table_cell"><strong>Severity Level</strong></td>
					<td class="table_cell"><strong>Onset Date</strong></td>
					<td class="table_cell"><strong>Action</strong></td>
				</tr>
				<?php
				$count=0;
				$toggle =0;
				$cnt_comm = 0;
				for($counter=0;$counter< count($allergies_data);$counter++){
					if($allergies_data[$counter]['NewCropAllergies']['patient_uniqueid'] == $patientId){
					if($toggle == 0) {
							echo "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							echo "<tr>";
							$toggle = 0;
						}
				$count++;$cnt_comm++;	
               if($allergies_data[$counter]['NewCropAllergies']['status']=='A')
               	  $allergyStatus="Active";
               else
               	  $allergyStatus="Inactive";
				?>
				
					<td class="row_format">&nbsp;<?php echo $count; ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['name']; ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['reaction'];  ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergyStatus;  ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['AllergySeverityName'];  ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['onset_date'] = $this->DateFormat->formatDate2Local($allergies_data[$counter]['NewCropAllergies']['onset_date'],Configure::read('date_format_us'),false);  ?>
					</td>
					<td class="row_format"><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit')),array('controller'=>'Patients','action' => 'allallergies',$allergies_data[$counter]['NewCropAllergies']['patient_uniqueid'],$allergies_data[$counter]['NewCropAllergies']['id']),array('escape'=>false)); ?>
					</td>
				</tr>
				<tr>
					<td class="row_format" colspan="3"
						style="color: red; display: none; padding-left: 30px"
						'id='cmnt_presc<?php echo $count; ?>'><span></span>
					</td>
				</tr>
				<?php } }?>
			</table>
		</td>
	</tr>
</table>


<?php if($cnt_comm == 0){?>
<table align="center">
	<tr>
		<td text-align="center" style="color: red"><?php echo "There are no recorded allergies for this patient for current encounter." ?>
		</td>
	</tr>
</table>
<?php } ?>

<?php if($previousEnc){?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" style="margin-left: -32px">
	<tr>
		<td width='80px'></td>
		<td valign='top'></td>
	</tr>
	<tr><td width='20px'></td><td style="padding-left:17px">Previous Allergies</td></tr>
	<tr>
		<td width='20px'></td>
		<td>
			<table border="0" class="table_format" cellpadding="0"
				cellspacing="0" width="97%">
				<tr class="row_title">
					<td class="table_cell"><strong>Sr. #</strong></td>
					<td class="table_cell"><strong>Name</strong></td>
					<td class="table_cell"><strong>Reaction</strong></td>
					<td class="table_cell"><strong>status</strong></td>
					<td class="table_cell"><strong>Severity Level</strong></td>
					<td class="table_cell"><strong>Date</strong></td>
					<td class="table_cell"><strong>Action</strong></td>
				</tr>
				<?php
				$count=0;
				$toggle =0;
				$cnt_comm1 = 0;
				for($counter=0;$counter< count($allergies_data);$counter++){
	if($allergies_data[$counter]['NewCropAllergies']['patient_uniqueid'] < $patientId){
	if($toggle == 0) {
		echo "<tr class='row_gray'>";
		$toggle = 1;
	}else{
		echo "<tr>";
		$toggle = 0;
	}
	$count++;$cnt_comm1++;	 ?>
				<tr>
					<td class="row_format">&nbsp;<?php echo $count; ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['name']; ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['reaction'];  ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['status'];  ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['AllergySeverityName'];  ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['onset_date'] = $this->DateFormat->formatDate2Local($allergies_data[$counter]['NewCropAllergies']['onset_date'],Configure::read('date_format_us'),false);  ?>
					</td>
					<td class="row_format"><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit')),array('controller'=>'Patients','action' => 'allallergies',$allergies_data[$counter]['NewCropAllergies']['patient_uniqueid'],$allergies_data[$counter]['NewCropAllergies']['id']),array('escape'=>false)); ?>
					</td>
				</tr>
				<tr>
					<td class="row_format" colspan="3"
						style="color: red; display: none; padding-left: 30px"
						id='cmnt_presc<?php echo $count; ?>'><span></span>
					</td>
				</tr>
				<?php } ?>
				<?php } ?>
			</table>
		</td>
	</tr>
</table>

<?php if($cnt_comm1 == 0){?>
<table align="center">
	<tr>
		<td text-align="center" style="color: red"><?php echo "There are no recorded allergies for this patient for previous encounter." ?>
		</td>
	</tr>
</table>
<?php } ?>
<?php }?>











<?php } else{ ?>
<table align="center">
	<tr>
		<td text-align="center" style="color: red"><?php echo "There are no recorded allergies for this patient at this time." ?>
		</td>
	</tr>
</table>
<?php } ?>
<br></br>
<script>
$(document).ready(function(){
	$('#patientSearchDiv').remove();
		
	jQuery("#doctortemplatefrm").validationEngine({
	validateNonVisibleFields: true,
	updatePromptsPosition:true,
	});
	
	$('#submit').click(function() { 
	var validatePerson = jQuery("#doctortemplatefrm").validationEngine('validate');
	});	 
	
	//  AllergyMaster table
	// $('#name').on('focus',function() { 
	$('#name').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","AllergyMaster",'CompositeAllergyID',"name",'null',"admin" => false,"plugin"=>false)); ?>",
		{
			width: 250,
			selectFirst: true,
			valueSelected:true,
			loadId : 'name,nameId'
		});

//}); 
});
$(document).ready(function(){
	if($('#namecheck').attr('checked')) {
		$('#submit').attr('disabled',true);
		}
	$("#namecheck").click(function(){ 
		if($(this).attr('checked')) {
				var action = "insert";
				$('#submit').attr('disabled',true);
		}else{
				var action = "delete";
				$('#submit').attr('disabled',false);
		}
		$.ajax({
			url: "<?php echo $this->Html->url(array("controller" => 'Patients', "action" => "allallergies",$patient_id, "admin" => false)); ?>"+"/"+"null"+"/"+action,
		     context: document.body,
		     success: function(data){
		    	 parent.location.reload(); 
		    }
		});
	});
	
	jQuery(document).ready(function() {
		$('#allergies').click(function() {
			parent.$.fancybox.close();
		});
	});

	 $(document).ready(function(){
   	  $("#comment").click(function(){
           var cnt_comm=0;
           $( "td span" ).each(function(){
       		  cnt_comm++;
   			  $("#cmnt_drug"+cnt_comm).toggle();
	       		});       	    
   	  });
   	});

	 $(document).ready(function(){
	   	  $("#comment").click(function(){
	           var cnt_comm=0;
	           $( "td span" ).each(function(){
	       		  cnt_comm++;
	   			  $("#cmnt_food"+cnt_comm).toggle();
		       		});	       	    
	   	  });
	   	});

	 $(document).ready(function(){
	   	  $("#comment").click(function(){
	           var cnt_comm=0;
	           $( "td span" ).each(function(){
	       		  cnt_comm++;
	   			  $("#cmnt_env"+cnt_comm).toggle();
		       		});	       	    
	   	  });
	   	});
	   	
	 $("#onset_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			changeTime:true,
			showTime: true,  		
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate();?>',	
			onSelect : function() {
				$(this).focus();
			}		
		});
});		
</script>
