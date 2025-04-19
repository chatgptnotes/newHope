<?php if($ajaxHold!='Yes'){echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');}?>
<style>
.tddate img {
	float: inherit;
}
.textBoxExpnd{}
.table_format a{ padding:0px !important;}
</style>
<div id="flashMessage"></div>
<div class="inner_title">
	<h3 style="margin-left:10px;">
		&nbsp;
		<?php  echo __('Allergy List', true); ?>
	</h3>
</div><?php 
if($flag=='notPresent'){?>
<div align="center">
	<font color="red"><?php echo __('Allergy is not present in our database, so select alternate allergy.', true); ?></font>
	<?php echo $this->Form->button(__('Change Allergy'), array('id'=>'changeAllergy','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' )); ?>
</div>

<?php }
if($status == "success"){?>
		<script> 
			jQuery(document).ready(function() { 
			//parent.location.reload(true);
			parent.$.fancybox.close(); 
		});
		</script>
<?php }?>
<?php // if(!isset($this->request->params['pass']['3'])){?>
<?php 
if($controllerFlag=='Diagnoses'){
	if($allergyCheck=='yes'){
		$check='checked';
	}else{
		$check='';
	}
}else if($controllerFlag=='Notes'){	
		if($allergyCheck=='yes'){
			$check='checked';
		}else{
			$check='';
		}
}

if(!empty($allergies_data)|| !empty($this->request->data['NewCropAllergies'])){
		$check='';
		$disable='disabled';
}
?>
<div class="patient_info">
	<?php // echo $this->element('patient_information');?>
</div>
<?php 	echo $this->Form->create('NewCropAllergies',array('url'=>array('controller'=>'Diagnoses','action'=>'allallergies',$patient_id,$id),'id'=>'doctortemplatefrm', 'inputDefaults' => array('label' => false,'div' => false)));
echo $this->Form->hidden('id');
echo $this->Form->hidden('NewCropAllergies.uId',array('id'=>'uId','value'=>$uId));
?>

<div border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="70%">
	<div style="width:600px; float:left;">
		<div width="2%" style="font-size: 13px; float:left; width:110px; margin-bottom:10px;"><?php echo __('Allergy Name');?>:<font
			color="red">*</font>
		</div>
		<div width="30%" style="float:left;"><?php echo $this->Form->input('NewCropAllergies.ConceptType', array('options'=>array("NAME"=>"NAME","GROUP"=>"GROUP"),'value'=>$this->request->data['NewCropAllergies']['ConceptType'],'class' => 'textBoxExpnd','id' => 'ConceptType','label'=> false,'style'=>'width:90px;'));
		echo $this->Form->input('NewCropAllergies.name', array('type'=>'text','error' => false,'class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd', 'id' => 'name','autocomplete'=>false,'style'=>'width:320px;margin-left:10px;')); ?>
		<?php if(!empty($this->request->data['NewCropAllergies']['CompositeAllergyID'])){
			$valueComposite=$this->request->data['NewCropAllergies']['CompositeAllergyID'];
		}
		else{
			$valueComposite='';
		}
			
			echo  $this->Form->hidden('NewCropAllergies.CompositeAllergyID',array('id'=>'nameId','value'=>$valueComposite));?>
		<?php echo $this->Form->input('NewCropAllergies.newallergy', array('options'=>$temp,'empty'=>'Select alternate allergy','class' => 'textBoxExpnd','id' => 'newallergy','label'=> false,'style'=>'display:none'));?>
		</div>

		
	
		<div style="font-size: 13px; float:left;width:110px; margin-bottom:10px; clear:left;"><?php echo __('Allergy Reaction');?>:</div>
		<div width="30%"><?php echo $this->Form->input('NewCropAllergies.reaction', array('style'=>'width:420px;','class'=>'validate[optional,custom[name],custom[onlyLetterSpCh]] textBoxExpnd', 'type'=>'text','id' => 'reaction','maxlength'=>'200')); ?>
		</div>
		<div style="font-size: 13px; float:left; clear:left;width:110px;"><?php echo __("Active");?>:</div>
		<div width="26%" style="padding-right:21px;" ><?php 
          echo $this->Form->input('NewCropAllergies.status', array('style'=>'width:55px!important;','class'=>'textBoxExpnd','options' => array('A'=>'Yes','N'=>'No'),'value'=>$this->request->data['NewCropAllergies']['status'],'id' => 'status', 'label'=> false, 'div' => false, 'error' => false));?>
		</div>
		<?php echo $this->Form->input('patient_uniqueid',array('type'=>'hidden','value'=>$patient_id));?>
		<div><?php echo $this->Form->input('id',array('type'=>'hidden'));?></div>
		 <div style="width:904px; float:left">
		<div style="font-size: 13px; float:left;width:170px; margin-top:10px; clear:left;"><?php echo $this->Form->checkbox("",array("name"=>"allergycheck","checked"=>$check,"disabled"=>$disable,"id"=>"allergycheck","onclick"=>"javascript:save_checkallergy();"))?>   No known Drug Allergies</div>
        <div class="row_format" style="float:left;"><?php
		echo $this->Form->submit(__('Submit'), array('id'=>'submit','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
		?>
		</div>
        </div>
	</div>
         
	
	
	<div style="width:500px; float:left;">
    <div width="" style="font-size: 13px; float:left; width:100px; margin-bottom:10px;"><?php echo __('Severity Level');?>:<font
			color="red">*</font></div>
		<div width=""><?php echo $this->Form->input('NewCropAllergies.AllergySeverityName', array('empty'=>__('Please Select'),'options'=>array("Mild"=>"Mild","Moderate"=>"Moderate","Severe"=>"Severe"),'value'=>$this->request->data['NewCropAllergies']['AllergySeverityName'],'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'AllergySeverityName','label'=> false,'style'=>'width:134px!important;')); ?>
		</div>
        <div style="font-size: 13px;float:left; clear:left; width:100px;"><?php echo __('Onset Date');?>:<font
			color="red">*</font></div>
		<div><?php echo $this->Form->input('NewCropAllergies.onset_date', array('readonly'=>'readonly','type'=>'text','class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','id' => 'onset_date')); ?>
		</div>
		<!--<div style="font-size: 13px; float:left; clear:left;width:110px;"><?php echo __("Active");?>:</div>
		<div width="26%" style="padding-right:21px;" ><?php 
          echo $this->Form->input('NewCropAllergies.status', array('style'=>'width:55px!important;','class'=>'textBoxExpnd','options' => array('A'=>'Yes','N'=>'No'),'value'=>$this->request->data['NewCropAllergies']['status'],'id' => 'status', 'label'=> false, 'div' => false, 'error' => false));?>
		</div>
		<?php echo $this->Form->input('patient_uniqueid',array('type'=>'hidden','value'=>$patient_id));?>
		<div><?php echo $this->Form->input('id',array('type'=>'hidden'));?></div>-->
		
	</div>
</div>
<?php echo $this->Form->end();?>
<?php  
 if(count($allergies_data)== 0 || count($allergies_data)== 1 && $allergies_data[0]['NewCropAllergies']['name'] == "No Known Allergy") { ?>
<?php $checked = ($allergies_data[0]['NewCropAllergies']['name'] == "No Known Allergy") ? true : false; 
 		$disabled = ($allergies_data[0]['NewCropAllergies']['name'] != "No Known Allergy" || !empty($allergies_data)) ? false : true;?>
<!-- <table>
	<tr>
		<td style="padding-left: 15px;"><?php echo $this->Form->input('NewCropAllergies.name', array('type'=>'checkbox','id'=>'namecheck',
										'checked'=>$checked,'disabled'=>$disabled,'label'=> false, 'div' => false, 'error' => false));?>
		</td>
		<td style="font-size: 13px;"><?php echo __("No Known Medication Allergies");?></td>
	</tr>
</table> -->
<?php }?>
<?php // } ?>
<?php 
 if(count($allergies_data)!=0 && $allergies_data[0]['NewCropAllergies']['name'] != "No active allergies") { ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" style="margin-left: -32px">
	<tr>
		<td width='80px'></td>
		<td valign='top'></td>
	</tr>
	<!--  <tr><td width='20px'></td><td style="padding-left:17px">All Allergies</td></tr>-->
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
				<?php //debug($allergies_data);exit;
				$count=0;
				$toggle =0;
				$cnt_comm = 0;
				for($counter=0;$counter< count($allergies_data);$counter++){
				//	if($allergies_data[$counter]['NewCropAllergies']['patient_uniqueid'] == $patientId){
					if($toggle == 0) {
							echo "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							echo "<tr>";
							$toggle = 0;
						}
				$count++;$cnt_comm++;	 ?>
				<?php
					if($allergies_data[$counter]['NewCropAllergies']['status'] == 'A'){
						$statusDisplay = 'Active';
					}else{
						$statusDisplay = 'Inactive ';
					}
				
				?>			
					<td class="row_format">&nbsp;<?php echo $count; ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['name']; ?>
					</td>
					<td class="row_format">&nbsp;<?php echo ucwords($allergies_data[$counter]['NewCropAllergies']['note']);  ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $statusDisplay;  ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['AllergySeverityName'];  ?>
					</td>
					<?php if(empty($allergies_data[$counter]['NewCropAllergies']['onset_date']) || $allergies_data[$counter]['NewCropAllergies']['onset_date']=='//'){
						$allergies_data[$counter]['NewCropAllergies']['onset_date']='';
					}else{
						$allergies_data[$counter]['NewCropAllergies']['onset_date'] = $this->DateFormat->formatDate2Local($allergies_data[$counter]['NewCropAllergies']['onset_date'],Configure::read('date_format_us'),false);
					}
					?>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['onset_date'];  ?>
					</td>
					<td class="row_format"><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit')),
							array('action' => 'allallergies',$allergies_data[$counter]['NewCropAllergies']['patient_uniqueid'],
							$allergies_data[$counter]['NewCropAllergies']['id'],'?'=>array('personId'=>$personId)),array('escape'=>false)); 
					  echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), 
					array('action' => 'deleteAllergy',$allergies_data[$counter]['NewCropAllergies']['patient_uniqueid'], 
					$allergies_data[$counter]['NewCropAllergies']['id'],'?'=>array('personId'=>$personId,'controllerName'=>$controllerFlag)), array('escape' => false),__('Are you sure?', true)); ?>
					</td>
				</tr>
				<tr>
					<td class="row_format" colspan="3"
						style="color: red; display: none; padding-left: 30px;" 'id='cmnt_presc><?php echo $count; ?>'><span></span>
					</td>
				</tr>
				<?php } /* } */?>
			</table>
		</td>
	</tr>
</table>


<?php if($cnt_comm == 0){?>
<div align="center" style="clear:both; width:970px;">
	<div>
		<div text-align="center" style="color: red; font-size:13px;"><?php echo "There are no recorded allergies for this patient for current encounter." ?>
		</div>
	</div>
</div>
<?php } ?>
<!--  
<?php if($previousEnc == '1'){?>
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
					<td class="row_format">&nbsp;<?php echo ucwords($allergies_data[$counter]['NewCropAllergies']['reaction']);  ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['status'];  ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['AllergySeverityName'];  ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $allergies_data[$counter]['NewCropAllergies']['onset_date'] = $this->DateFormat->formatDate2Local($allergies_data[$counter]['NewCropAllergies']['onset_date'],Configure::read('date_format_us'),false);  ?>
					</td>
					<td class="row_format"><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit')),array('controller'=>'Diagnoses','action' => 'allallergies',$allergies_data[$counter]['NewCropAllergies']['patient_uniqueid'],$allergies_data[$counter]['NewCropAllergies']['id']),array('escape'=>false));
					 echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('controller'=>'Diagnoses','action' => 'deleteAllergy', $allergies_data[$counter]['NewCropAllergies']['id']), array('escape' => false),__('Are you sure?', true)); ?>
					
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
-->


<?php } else{ if( $id == '' || !isset($id)){ ?>

<div align="center" style="clear:both; width:970px;">
	<div>
		<div text-align="center" style="color: red;font-size:13px;"><?php echo "There are no recorded allergies for this patient at this time." ?>
		</div>
	</div>
</div>
<?php } } ?>
<br></br>
<script>

$('#changeAllergy').click(function(){
		$('#newallergy').show();
});

$('#newallergy').change(function(){
	if($(this).val() !=""){
	valal=document.getElementById("newallergy").options[document.getElementById('newallergy').selectedIndex].text;
	$('#name').val(valal);
	$('#nameId').val($(this).val());
	}
});

$(document).ready(function(){
	$('#patientSearchDiv').remove();	
	jQuery("#doctortemplatefrm").validationEngine({
	validateNonVisibleFields: true,
	updatePromptsPosition:true,
	});
	$('#submit').click(
	function() { 
		/*if($('#nameId').val()==''){
			alert('Please select valid Allergy');
			return false;
		}*/
	var validatePerson = jQuery("#doctortemplatefrm").validationEngine('validate');
	});	 
	/*$("#name").autocomplete("<?php //echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","NewCropAllergies","name",'null','null','null','null','name',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});*/
	//  AllergyMaster table
	
	/* $('#ConceptType').on('focus',function() {
							 
	 }); */
	 $('#name').on('focus',function() { 
		 if($('#ConceptType').val()=='GROUP'){
				var	getConceptType= "ConceptType=GROUP";	
			}else  if($('#ConceptType').val()!='GROUP'){
				var	getConceptType='ConceptType<>=GROUP';	
			}		
					
	$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","AllergyMaster",'CompositeAllergyID',"name")); ?>"+'/'+'status=A&'+getConceptType,
			
		{
		width: 250,
		selectFirst: true,
		showNoId:true,
		valueSelected:true,
		loadId : 'name,nameId'
		});

}); 
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
				$('#submit').attr('disabled','disabled');
		}
		$.ajax({
			url: "<?php echo $this->Html->url(array("controller" => 'Diagnoses', "action" => "allallergies",$patient_id, "admin" => false)); ?>"+"/"+"null"+"/"+action,
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
			maxDate : new Date(),	
			yearRange: '-100:' + new Date().getFullYear(),		 
			dateFormat:'<?php echo $this->General->GeneralDate();?>',	
			onSelect : function() {
				$(this).focus();
			}		
		});
});	

/***BOF No Active Allergy***/	
function save_checkallergy(){
	if($('#allergycheck').prop('checked')) 
	{	var checkall=1;
	}else{
	  	var checkall=0;
    }
patientid="<?php echo $patientId?>";
patient_uid="<?php echo $personId?>";
var ajaxUrl = "<?php echo $this->Html->url(array("controller" =>$controllerFlag, "action" => "setNoActiveAllergy","admin" => false)); ?>";
    $.ajax({
     type: 'POST',
     url: ajaxUrl+"/"+patientid+"/"+checkall+"/"+patient_uid,
     //data: formData,
     dataType: 'html',
     success: function(data){

    	 if($('#allergycheck').prop('checked')) 
    	 {	
    		 $( '#allergycheck', parent.document ).prop('checked',true);
    	 }else{
    		 $( '#allergycheck', parent.document ).prop('checked',false);
    	 } 
    	 
     },
	 error: function(message){
        alert(message);
     }        
   });
}
/***EOF No Active Allergy***/
</script>
