<?php //echo $this->Html->css(array('jquery.autocomplete'));
//echo $this->Html->script(array('jquery.autocomplete'));?>
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
</div>

<?php 	echo $this->Form->create('NewCropAllergies',array('url'=>array('controller'=>'Diagnoses','action'=>'allallergies',$patient_id,$id),'id'=>'Allergyfrm', 'inputDefaults' => array('label' => false,'div' => false)));
echo $this->Form->hidden('NewCropAllergies.id',array('id'=>'uId','value'=>$putAllergyData['NewCropAllergies']['id']));
?>

<div border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="70%">
	<div style="width:600px; float:left;">
		<div width="2%" style="font-size: 13px; float:left; width:110px; margin-bottom:10px;"><?php echo __('Allergy Name');?>:
		</div>
		<div width="30%" style="float:left;"><?php //echo $this->Form->input('NewCropAllergies.ConceptType', array('options'=>array("NAME"=>"NAME","GROUP"=>"GROUP"),'value'=>$this->request->data['NewCropAllergies']['ConceptType'],'class' => 'textBoxExpnd','id' => 'ConceptType','label'=> false,'style'=>'width:90px;'));
		echo $this->Form->input('NewCropAllergies.name', array('type'=>'text','error' => false,'class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd', 'id' => 'name','autocomplete'=>false,'style'=>'width:320px;','value'=>$putAllergyData['NewCropAllergies']['name'])); ?>
		<?php if(!empty($putAllergyData['NewCropAllergies']['CompositeAllergyID'])){
			$valueComposite=$putAllergyData['NewCropAllergies']['CompositeAllergyID'];
		}
		else{
			$valueComposite='';
		}
			
			echo  $this->Form->hidden('NewCropAllergies.CompositeAllergyID',array('id'=>'nameId','value'=>$valueComposite));?>
		<?php echo $this->Form->input('NewCropAllergies.newallergy', array('options'=>$temp,'empty'=>'Select alternate allergy','class' => 'textBoxExpnd','id' => 'newallergy','label'=> false,'style'=>'display:none'));?>
		</div>

		
	
		<div style="font-size: 13px; float:left;width:110px; margin-bottom:10px; clear:left;"><?php echo __('Allergy Reaction');?>:</div>
		<div width="30%"><?php echo $this->Form->input('NewCropAllergies.reaction', array('style'=>'width:320px;','class'=>'validate[optional,custom[name],custom[onlyLetterSpCh]] textBoxExpnd', 'type'=>'text','id' => 'reaction','maxlength'=>'200','value'=>$putAllergyData['NewCropAllergies']['reaction'])); ?>
		</div>
		<div style="font-size: 13px; float:left; clear:left;width:110px;"><?php echo __("Active");?>:</div>
		<div width="26%" style="padding-right:21px;" ><?php echo $this->Form->input('NewCropAllergies.status', array('style'=>'width:55px!important;','class'=>'textBoxExpnd','options' => array('A'=>'Yes','N'=>'No'),'value'=>$putAllergyData['NewCropAllergies']['status'],'id' => 'status', 'label'=> false, 'div' => false, 'error' => false));?>
		</div>
		<?php echo $this->Form->input('patient_uniqueid',array('type'=>'hidden','value'=>$putAllergyData['NewCropAllergies']['patient_uniqueid']));?>
		<div><?php echo $this->Form->input('id',array('type'=>'hidden'));?></div>
		 <div style="width:904px; float:left">
		<!-- <div style="font-size: 13px; float:left;width:170px; margin-top:10px; clear:left;"><?php echo $this->Form->checkbox("",array("name"=>"allergycheck","checked"=>$check,"disabled"=>$disable,"id"=>"allergycheck","onclick"=>"javascript:save_checkallergy();"))?>   No known Drug Allergies</div> -->
        <div class="row_format" style="float:left;"><input id="saveAllergy" value="Save" class="blueBtn" type="Button"></td>
		</div>
        </div>
	</div>
         
	
	
	<div style="width:500px; float:left;">
    <div width="" style="font-size: 13px; float:left; width:100px; margin-bottom:10px;"><?php echo __('Severity Level');?>:</div>
		<div width=""><?php echo $this->Form->input('NewCropAllergies.AllergySeverityName', array('empty'=>__('Please Select'),'options'=>array("Mild"=>"Mild","Moderate"=>"Moderate","Severe"=>"Severe"),'value'=>$putAllergyData['NewCropAllergies']['AllergySeverityName'],'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'AllergySeverityName','label'=> false,'style'=>'width:134px!important;')); ?>
		</div>
        <div style="font-size: 13px;float:left; clear:left; width:100px;"><?php echo __('Onset Date');?>:</div>
		<div><?php //$putAllergyData['NewCropAllergies']['onset_date']= $this->DateFormat->formatDate2Local($putAllergyData['NewCropAllergies']['onset_date'],Configure::read('date_format'));
				echo $this->Form->input('NewCropAllergies.onset_date', array('readonly'=>'readonly','type'=>'text','class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','id' => 'onset_date','value'=>$putAllergyData['NewCropAllergies']['onset_date'],'style'=>'width:120px')); ?>
		</div>		
	</div>
</div>
<?php echo $this->Form->end();?>

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
	 jQuery(document).on('focus', '#name', function(e){
		 $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "testcomplete","AllergyMaster",'CompositeAllergyID',"name","status=A",'null','null')); ?>",
		{
		width: 250,
		selectFirst: true,
		showNoId:true,
		valueSelected:true,
		loadId : 'name,nameId'
		});
	}); 
	 jQuery(document).on('focus', '#onset_date', function(e){
	 $(this ).datepicker({
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
});
$(document).ready(function(){
	$('#name').focus();		
	 $('#onset_date').datepicker({
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

$('#saveAllergy').click(function(){
	var formDataNew = $('#Allergyfrm').serialize();
	var id=$('#nameId').val();
	var AllergyUniqueid=$('#uId').val();
	
	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "notes", "action" => "ajax_allallergies",$patientId,$noteId,$appointmentId)); ?>";
	  $.ajax({
       	beforeSend : function() {
       		$('#busy-indicator').show('fast');
       	},
       	type: 'post',
       	url: ajaxUrl+"/"+AllergyUniqueid,
       	dataType: 'html',
       	data:formDataNew,
       	success: function(data){
       		getSubData();
       		$('#busy-indicator').hide('fast');
       		$('#name').val('');
       		$('#AllergySeverityName').val('');
       		$('#reaction').val('');
       		$('#onset_date').val('');
       		$('#status').val(''); 		
       			 
			 if(id!=""){
				 $('#alertMsg').show().html('Allergy Saved Successfully.');
				 $('#alertMsg').show().fadeOut(5000); 			   			
	       	}else{
	       		$('#alertMsgError').show().html('Please select valid Allergy name.');    
	       		$('#alertMsgError').show().fadeOut(50000);  
	       	}
			
    	   },
    	  });	
});
</script>
