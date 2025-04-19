<style>
.loadLinkPharseF{
cursor:pointer;
font-size: 14px !important;
}
.loadLinkPharseDiagnosisF{
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
echo $this->Form->create('NoteDiagnosis',array('id'=>'saveFinalDiagnosis'));?>
<table width="50%" border="0" cellspacing="1" cellpadding="0" style="padding-left: 45px;
    padding-top: 12px;">
	<tr>
		<td width="20%"><strong>Diagnosis Name:</strong></td>   
		<td width="40%"><?php echo $this->Form->input('diagnoses_name',array('class'=>'textBoxExpnd AutoComplete','escape'=>false,'multiple'=>false,
												'label'=>false,'div'=>false,'id'=>'diagnosis_name1','autocomplete'=>false,'placeHolder'=>'Final Diagnosis Search','style'=>'width:286px;'));
										echo $this->Form->hidden('testCode',array('id'=>'code_problem'));
										echo $this->Form->hidden('patient_id',array('value'=>$patientId));
										echo $this->Form->hidden('note_id',array('value'=>$noteId));
										?></td>
		<td width="40%"> <input id="saveProProblem1" value="Save" class="blueBtn" type="Button"></td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="0" style="padding-left: 45px;
    padding-top: 12px; padding-bottom: 20px;" >
<tr>
<td width="50%" valign="top">

	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="" id="" >
	<tr>
	<td>
	<tr id="pharseshowtextDiagnosisListTr" style="display:none;padding-top:10px;" valign="top">
		<td width="40%" style="font-size: 14px;">
			Select Provisional Diagnosis:
		</td>
		<td id="pharseshowtextDiagnosisList" style="display:none;font-size: 14px;font-weight: normal;">			
		</td>
	</tr>
	</table>
</td>
<td width="50%" valign="top">
	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="" id="" >
	<tr id="pharseshowtexttrF" style="display:none" valign="top">
		<td width="30%" style="font-size: 14px">Following phrase can be used for above diagnosis:
		</td>
		<td></td>
		<td width="65%" id="pharseshowtextF" style="display:none;font-size: 14px;font-weight: normal;">
			
		</td>
	</tr>
	</table>
</td>
</tr>
</table>
<?php echo $this->Form->end();?>
<script>
$(document).ready(function(){	
	$('#diagnosis_name1').focus();	
	var noteId="<?php echo $noteId?>";	
	getsmartPharseDiagnosisFinal(noteId);	
	});
function getsmartPharseDiagnosisFinal(noteId){

	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "notes", "action" => "getsmartPharseDiagnosisFinal")); ?>";
	  $.ajax({
     	beforeSend : function() {
     		$('#busy-indicator').show('fast');
     	},
     	type: 'post',
     	url: ajaxUrl+"/"+noteId,
     	dataType: 'html',
     	//data:formDataNew,
     	success: function(data){
     		$('#busy-indicator').hide('fast');
     		var dataSplited1=data.split('_');
     		var obj = jQuery.parseJSON(data);     	
     		var linkStr="";
     		if(obj!=""){ 	 
     		$.each(obj, function( key, value ) {
     			var dataSplited=value.split('_');
         		if(dataSplited['0']!==" "){     
         		//	valuermoveSp=value.replace(" ", "") ;       		
     				linkStr+='<a class="loadLinkPharseDiagnosisF" id='+dataSplited['1']+'><li style="list-style: square;color:#FF0000;" class="bullColor"><span style="color:#31859C;">'+$.trim(dataSplited['0'])+'</span></li></a>'  /// style="color:#FF0000;"
         		}
     			});
     		}
     		if($.trim(dataSplited1['0'])!="."){     	
     		$('#pharseshowtextDiagnosisListTr').show();
     		$('#pharseshowtextDiagnosisList').show();
     		$('#pharseshowtextDiagnosisList').html(" ");
     		$('#pharseshowtextDiagnosisList').html(linkStr);
     		}
     		
     		
  	   },
  	  });	
}
//$(document).on('change', '#diagnosis_name1', function() {
	//alert("GFFGF");
$('#diagnosis_name1').autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "googlecomplete","SnomedMappingMaster","id",'icd9name','null','icd9name',"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	loadId:'diagnosis_name1,code_problem',
	showNoId:true,
	valueSelected:true,
	onItemSelect:function() {		
		var id=$('#code_problem').val();	
		getsmartPharseFinal(id);
		
	 }		
});
//});
$('#saveProProblem1').click(function(){
	var formDataNew = $('#saveFinalDiagnosis').serialize();
	var id=$('#code_problem').val();
	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "notes", "action" => "ajax_active_problem",$patientId,$noteId,$appointmentId)); ?>";
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
       		$('#diagnosis_name1').val('');
       		
       		if(id!=""){
       			$('#alertMsg').show().html('Final Diagnosis Saved Successfully.');     
       			$('#alertMsg').fadeOut(5000);  			   			
       		}else{
       			$('#alertMsgError').show().html('Please select valid Final Diagnosis name.');    
       			$('#alertMsgError').fadeOut(50000);  
       		}
			
    	   },
    	  });	
});
function getsmartPharseFinal(id,diaName){

	var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "notes", "action" => "getsmartPharseFinal")); ?>";
	  $.ajax({
     	beforeSend : function() {
     		$('#busy-indicator').show('fast');
     	},
     	type: 'post',
     	url: ajaxUrl+"/"+id+"/"+diaName,
     	dataType: 'html',
     	//data:formDataNew,
     	success: function(data){
     		$('#busy-indicator').hide('fast');
     		var obj = jQuery.parseJSON(data);     	
     		var linkStr="";
     		$.each(obj, function( key, value ) {         		
         		if(value!==" "){             		
     				linkStr+='<a class="loadLinkPharseF" id='+value+'><li style="list-style: square;color:#FF0000;" class="bullColor"><span style="color:#31859C;">'+$.trim(value)+"  "+'</span></li></a><input  type="hidden" class="diaIdCls" id="' + id + '"  name="diaName[]" value="'+diaName+'" >'
         		}
     			});
     		if($.trim(data)!="."){     	
     		$('#pharseshowtexttrF').show();
     		$('#pharseshowtextF').show();
     		$('#pharseshowtextF').html(" ");
     		$('#pharseshowtextF').html(linkStr);
     		}
     		
     		
  	   },
  	  });	
}

</script>