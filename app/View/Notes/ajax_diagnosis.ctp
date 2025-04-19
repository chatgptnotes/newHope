<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css(array('jquery.autocomplete'));?>
<style>
.loadLinkPharse{
cursor:pointer;
font-size: 14px !important;
}
.li:before {  
    color: red; /* or whatever color you prefer */
}
a li span:hover {
  color: black ;
  background-color: #FFFFFF ;
}
</style>
<?php

echo $this->Form->create('NoteDiagnosis',array('id'=>'saveProDiagnosis'));?>
<table width="50%" border="0" cellspacing="1" cellpadding="0" style="padding-left: 45px;
    padding-top: 12px; padding-bottom: 10px;">
	<tr>
		<td width="23%"><strong>Diagnosis Name:</strong></td>   
		<td width="40%"><?php echo $this->Form->input('diagnoses_name',array('class'=>'textBoxExpnd AutoComplete','escape'=>false,'multiple'=>false,
												'label'=>false,'div'=>false,'id'=>'diagnosis_name','autocomplete'=>false,'placeHolder'=>'Prov Diagnosis Search','style'=>'width:286px;'));
										echo $this->Form->hidden('testCode',array('id'=>'code_problem1'));
										echo $this->Form->hidden('patient_id',array('value'=>$patientId));
										echo $this->Form->hidden('note_id',array('value'=>$noteId));
										echo $this->Form->hidden('code_system',array('value'=>'1'));?></td>
		<td width="40%"> <input id="saveProProblem" value="Save" class="blueBtn" type="Button">&nbsp;<span><?php echo $this->Html->link('Diagnosis Master',array("controller" => "SmartPhrases", "action" => "diagnosis_list", "admin" => false,'plugin' => false, 'superadmin'=> false), array('target'=>"_blank",'escape' => false)); ?></td>
	</tr>
</table>
<table width="50%" border="0" cellspacing="1" cellpadding="0" style="padding-left: 45px;
    padding-top: 12px; padding-bottom: 20px;" >
	<tr id="pharseshowtexttr" style="display:none" valign="top">
		<td width="30%" style="font-size: 14px;">
			Following phrase can be used for above diagnosis:
		</td>
		<td></td>
		<td width="65%" id="pharseshowtext" style="display:none;font-size: 14px;">
			
		</td>
	</tr>
	
</table>
<?php echo $this->Form->end();?>
<script>
$(document).ready(function(){
$('#diagnosis_name').focus();	
});
$("#diagnosis_name").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "googlecompleteproblem","SnomedMappingMaster","id",'icd9name','null','icd9name',"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	loadId:'diagnosis_name,code_problem1',
	showNoId:true,
	valueSelected:true,
	onItemSelect:function() {
		var id=$('#code_problem1').val();
		getsmartPharse(id);
	 }		
});
$('#saveProProblem').click(function(){
	var formDataNew = $('#saveProDiagnosis').serialize();	
	var id=$('#code_problem1').val();
	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "notes", "action" => "ajax_diagnosis",$patientId,$noteId,$appointmentId)); ?>";
	  $.ajax({
       	beforeSend : function() {
       		$('#busy-indicator').show('fast');
       	},
       	type: 'post',
       	url: ajaxUrl,
       	dataType: 'html',
       	data:formDataNew,
       	success: function(data){
       		getSubData();
       		$('#busy-indicator').hide('fast');
       		$('#diagnosis_name').val('');
       		if(id!=""){
       			$('#alertMsg').show().html('Prov Diagnosis Saved Successfully.');     
       			$('#alertMsg').fadeOut(5000);  			   			
       		}else{
       			$('#alertMsgError').show().html('Please select valid Prov Diagnosis name.');    
       			$('#alertMsgError').fadeOut(50000);  
       		}
       	 
       		//var loadID=currentAttrValue.split('#');
       	//	$('#'+loadID[1]).html(data);
    	   },
    	  });	
});
function getsmartPharse(id){
	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "notes", "action" => "getsmartPharseDia")); ?>";
	  $.ajax({
     	beforeSend : function() {
     		$('#busy-indicator').show('fast');
     	},
     	type: 'post',
     	url: ajaxUrl+"/"+id,
     	dataType: 'html',
     	//data:formDataNew,
     	success: function(data){
     		$('#busy-indicator').hide('fast');
     		var obj = jQuery.parseJSON( data);
     		var linkStr="";
     		$.each(obj, function( key, value ) {
         		if(value!==" "){
     				linkStr+='<a class="loadLinkPharse" id='+value+'><li style="list-style: square;color:#FF0000;" class="bullColor"><span style="color:#31859C;">'+$.trim(value)+"inv  "+'</li></span></a>'
         		}
     			});
     		if($.trim(data)!=".inv"){         			     	
	     		$('#pharseshowtexttr').show();
	     		$('#pharseshowtext').show();
	     		$('#pharseshowtext').html(" ");
	     		$('#pharseshowtext').html(linkStr);
     		}
     		
  	   },
  	  });	
}
$(document).on('click','.loadLinkPharse',function(){
	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "loadLinkPharse")); ?>";
	  $.ajax({
   	beforeSend : function() {
   		$('#busy-indicator').show('fast');
   	},
   	type: 'post',
   	url: ajaxUrl+"/"+$(this).attr('id'),
   	dataType: 'html',
   	//data:formDataNew,
   	success: function(dataload){
   		$('#busy-indicator').hide('fast');
   		var objparse = jQuery.parseJSON(dataload);
   		var linkStr=""; 	
 		
 		if(objparse.ChiefComplaint!=null){ 	
 			linkStr+="Chief Complaints :\n";
 	 		$.each(objparse.ChiefComplaint, function( key, value ) { 	 	 		 		
 	 	 		linkStr+=value.name+"\n";		
 	 			});
 		}
 		if(objparse.Laboratory!=null){ 	
 		linkStr+="Laboratory :\n";
 		$.each(objparse.Laboratory, function( key, value ) {  	 		
 	 		linkStr+=value.name+"\n";		
 			});
 		}
 		if(objparse.Radiology!=null){ 
 		linkStr+="Radiology :\n";
 		$.each(objparse.Radiology, function( key, value ) {
 	 		linkStr+=value.name+"\n";		
 			});
 		}
 		$('#messageLabRad').val(' ');
			$('#messageLabRad').val(linkStr);
			$('#messageLabRad').focus();
			
	   },
	  });	
});


</script>