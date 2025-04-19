<?php echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en'));
echo $this->Html->css(array('internal_style.css','validationEngine.jquery.css'));
?>
<style>
.descField textarea {
    height: 500px;
    width: 530px;
}
#patientInfoLinkText {
    width:500px;
}
@media print {
  		.printButton{display:none;}
    }
</style>
<div class="inner_title">
	<h3 align="center">
		&nbsp;
		<?php echo 'Patient Information - '.$diagnosis_name;?>
	</h3>	
</div>

<?php echo $this->Form->create('SnomedMappingMaster',array('type' => 'g','id'=>'infoButtonDiaFrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )));

echo $this->Form->hidden('NoteDiagnosis.diagnoses_name',array('id'=>'diagnoses_name','value'=>$get_snomwd_code['NoteDiagnosis']['diagnoses_name']));
echo $this->Form->hidden('NoteDiagnosis.patient_id',array('id'=>'patient_id','value'=>$get_snomwd_code['NoteDiagnosis']['patient_id']));
echo $this->Form->hidden('NoteDiagnosis.id',array('id'=>'dia_id','value'=>$get_snomwd_code['NoteDiagnosis']['id']));
echo $this->Form->hidden('SnomedMappingMaster.mapTarget',array('id'=>'icd_id','value'=>$snomedMappingMasterData['SnomedMappingMaster']['mapTarget']));?>
<table border="0" cellpadding="0" cellspacing="0" width="99%" style="padding-top: 10px;" align="center">
<?php
if($get_details ==""){ ?>
<tr><td width="99%" class="printButton" colspan="4">
<p align="center"><font color="red"><?php
echo __("We don't have an exact match for the problem you selected. ");?></font><a  target="_blank" href="https://vsearch.nlm.nih.gov/vivisimo/cgi-bin/query-meta?v%3Aproject=<?php echo $aProject?>&query=<?php echo $diagnosis_name;?>"><u>Click here</u></a><font color="red"> to search.</font></p>
</td>
</tr>
<tr><td width="99%" class="printButton" colspan="4"><p align="center"><font color="red">You may add content below.</font></p></td></tr>
<tr><td>&nbsp;</td></tr>
<?php //if(!empty($get_snomwd_code['NoteDiagnosis']['patient_info'])){?>
<tr class="row_title">			
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="4">
	<strong><?php echo ucFirst($get_snomwd_code['NoteDiagnosis']['diagnoses_name']); ?></strong>
	</td>	
</tr>
 <tr><td>&nbsp;</td></tr>
<tr>
		<td class="tdLabel" id="boxSpace" width="19%" valign="top"><?php echo __('Description'); ?>
		</td>
		<td>		
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>	
		<td>
		<?php if(empty($snomedMappingMasterData['SnomedMappingMaster']['patient_info'])){
		$showTextBox="block";
		}else{
		$showTextBox="none";
		}?><div id="patientInfoText" class="descField" style="display:<?php echo $showTextBox?>;"><!--class="descField"-->
		<?php echo $this->Form->input('patient_info', array('type'=>'textarea','class' => '','id' => 'patient_info', 'label'=> false, 'div' => false, 'error' => false,'value'=>$snomedMappingMasterData['SnomedMappingMaster']['patient_info'],'placeholder'=>'Paste patient education content here...'));?>
		</div></td>
		<?php  //if(!empty($getMedicationData['NewCropPrescription']['patient_info'])){?>
		<td class="tdLabel" id="boxSpace">	
		<?php if(!empty($snomedMappingMasterData['SnomedMappingMaster']['patient_info'])){
		$showLabel="block";
		}else{
		$showLabel="none";
		}?>
		<div style="width:560px;float:left;display:<?php echo $showLabel?>;" id="patientInfoLabel" >
		<?php 
		$description=explode('.',$snomedMappingMasterData['SnomedMappingMaster']['patient_info']);
		foreach($description as $data){
			 echo "<p>".$data."</p>";
		 }?>
		</div>
		</td>
		</tr>
		<tr>
		<td class="printButton" colspan="7">
		<div class="btns"><?php echo $this->Html->link('Print',"javascript:void(0)",array('class'=>'blueBtn','label'=>false,'id'=>'print'));?>	
		</div> 
		</td><?php echo $this->Form->checkbox('NoteDiagnosis.is_printed',array('id'=>'is_printed','style'=>"display:none;")); //,'value'=>$get_snomwd_code['NoteDiagnosis']['is_printed']?>
		</tr>
		</table>		
		</td>		
</tr>
<!-- <tr class="printButton">
		<td class="tdLabel" id="boxSpace" colspan="2" style="text-align:center;"><strong><font color="red"><?php echo __('OR'); ?></font></strong>
		</td>				
</tr> -->
<tr><td>&nbsp; </td></tr>
<tr class="printButton">
		<td class="tdLabel" id="boxSpace" width="19%"><?php echo __('Link/URL'); ?>
		</td>
		<td>		
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>	
		<td>
		<?php if(empty($snomedMappingMasterData['SnomedMappingMaster']['patient_info_link'])){
		$showTextBox1="block";
		}else{
		$showTextBox1="none";
		}?>
		<div id="patientInfoLinkText" style="display:<?php echo $showTextBox1?>;"><!--class="descField"-->
		<?php echo $this->Form->input('patient_info_link', array('class' => ' textBoxExpnd ','type'=>'text','id' => 'patient_info_link', 'label'=> false, 'div' => false, 'error' => false,'value'=>$snomedMappingMasterData['SnomedMappingMaster']['patient_info_link'],'style'=>'width:360px;'));?>
		</div></td><!-- validate[optional,custom[url]] -->
		
		<td class="tdLabel" id="boxSpace">	
		<?php /*if(!empty($getMedicationData['NewCropPrescription']['patient_info_link'])){
		$showLabel2="block";
		}else{
		$showLabel2="none";
		}*/ ?>
		<div style="float:left;" id="patientInfoLinkLabel" >
		<a target="_blank" id="patientInfoLinkLabel1" href="<?php echo $snomedMappingMasterData['SnomedMappingMaster']['patient_info_link']; ?>"><?php echo $snomedMappingMasterData['SnomedMappingMaster']['patient_info_link']; ?></a>
		<?php //echo $getMedicationData['NewCropPrescription']['patient_info_link'];?>			
		</div>
		</td>
		<?php /*if(empty($getMedicationData['NewCropPrescription']['patient_info_link'])){
			$showTextBox2="block";
			}else{
			$showTextBox2="none";
			}*/?>		
		<!-- <td class="tdLabel"  id="boxSpace"><a target="_blank" id="patientLinkrght" href="<?php echo $snomedMappingMasterData['SnomedMappingMaster']['patient_info_link']; ?>"><?php echo __('Click here'); ?></a></td> -->
		<?php //} ?>
		</tr>		
		</table>		
		</td>		
</tr>		
<?php //}?>
<?php } else{?>
<tr><td>
<?php echo $this->Form->input('language', array('class' => 'textBoxExpnd ','options'=>array('EN'=>'English','ES'=>'Spanish'),'id' => 'language_patient','style'=>'width:250px;', 'label'=> false, 'div' => false, 'error' => false,'onchange'=>"changeLanguage(this);"));?>
</td>
</tr>
<tr>
<td class="tdLabel " id="boxSpace">
<?php echo $get_details;?>
</td>
</tr>
<tr>
<td><div class="btns printButton"><?php echo $this->Html->link('Print',"javascript:void(0)",array('class'=>'blueBtn','label'=>false,'id'=>'printparty'));?>	
</div></td><?php echo $this->Form->checkbox('NoteDiagnosis.is_printed',array('id'=>'is_printed','style'=>"display:none;")); //,'value'=>$get_snomwd_code['NoteDiagnosis']['is_printed']?>
</tr>
<?php }?>
</table>
</html>
<script>
$('#print').click(function(){
	window.print();	
});
$('#printparty').click(function(){
	window.print();	
});
<?php if($status == "success"){?>
	jQuery(document).ready(function() { 
		parent.$.fancybox.close(); 
	});
<?php   } ?>

	//////////////////*********BOF-Its for Description********///////////////////////
	$('#patient_info').focusout(function (){
		var icd_id=$("#icd_id").val(); 
		var diagnoses_name=$("#diagnoses_name").val();
		var patient_id=$("#patient_id").val();		
		var dia_id=$("#dia_id").val();
		var patientInfo=$("#patient_info").val(); 
		var htmlData = '';
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "patients", "action" => "addInfoDescription", "admin" => false)); ?>"+ '/'+icd_id+"/"+ '/'+diagnoses_name+"/"+patient_id+'/'+dia_id,
			  context: document.body,
			  data:"mapTarget="+icd_id+"&diagnoses_name="+diagnoses_name+"&patient_id="+patient_id+"&id="+dia_id+"&patient_info="+patientInfo,
			  success: function(data){ 
				  if($.trim(data) == "success"){					
						htmlData=$("#patient_info").val();					
						/*htmlData=htmlData.split(".");						
						var cnt=0;
						for(cnt=0;cnt< htmlData;cnt++){
						htmlData="<p>"+htmlData+"</p>";						
						}*/
						$('#patientInfoLabel').html(htmlData);								
					  if(htmlData==''){
						  $('#patientInfoLabel').hide();
						  $('#patientInfoText').show();	
						  $('#print').hide();		
					  }else{
						  alert("Description saved successfully.");
						  $('#patientInfoLabel').show();
						  $('#patientInfoText').hide();
						  $('#print').show();		
					  }
					 }			  
			  }		  
			});
	  	 return true;     
	}); 
	var test;
	$('#print,#printparty').click(function (){
	//	var toggleId = $(this).attr('class');
		var id= $(this).attr('id'); 
		var icd_id=$("#icd_id").val(); 
		var diagnoses_name=$("#diagnoses_name").val();
		var patient_id=$("#patient_id").val();	
		var dia_id=$("#dia_id").val();
		var value;
		if(id=='print' || id=='printparty'){
			$('#is_printed').attr('checked', true);
			value=1;
	    }else{
	    	$('#is_printed').attr('checked', false);
	    	value=0;
	    }
	//	$('.'+toggleId).toggle();
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "patients", "action" => "addIsPrinted", "admin" => false)); ?>"+ '/'+icd_id+"/"+ '/'+diagnoses_name+"/"+patient_id+'/'+dia_id,
			  context: document.body,
			  data:"patient_id="+patient_id+"&id="+dia_id+"&is_printed="+value,	
			  success: function(data){				
						parent.$.fancybox.close(); 			
			  } 		 		  
		});
	  	 return true;     
	});
	$('#patientInfoLabel').click(function (){
		var id= $(this).attr('id');
		if(id){
			$('#patientInfoText').show();
			$('#patientInfoLabel').hide();
			$('#print').hide();
		}else{	
			$('#patientInfoText').hide();		
			$('#patientInfoLabel').show();
			$('#print').show();
		}
	});
///////////////////*********BOE-Its for Description********///////////////////////
///////////////////*********BOF-Its for Link/URL********///////////////////////

	$("#infoButtonDiaFrm").validationEngine();

	$('#patient_info_link').focusout(function (){
		var validateMandatory = jQuery("#infoButtonDiaFrm").validationEngine('validate');
		if(validateMandatory == false){ 			
			return false;
		}else{ 
			var txt = $('#patient_info_link').val();
			var re = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
			if (re.test(txt)) {
			//alert('Valid URL')
			}
			else {
			alert('Please Enter Valid URL');
			return false;
			}	
			/*if($('#patient_info').val()!="" && $('#patient_info_link').val()!=""){
				alert('Please enter Description or Link/URL');			
				return false;
			}*/
			var icd_id=$("#icd_id").val(); 
			var diagnoses_name=$("#diagnoses_name").val();
			var patient_id=$("#patient_id").val();		
			var dia_id=$("#dia_id").val();
			var patientInfoLink=$("#patient_info_link").val(); 
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "patients", "action" => "addInfoLink", "admin" => false)); ?>"+ '/'+icd_id+"/"+ '/'+diagnoses_name+"/"+patient_id+'/'+dia_id,
			  context: document.body,
			  data:"mapTarget="+icd_id+"&diagnoses_name="+diagnoses_name+"&patient_id="+patient_id+"&id="+dia_id+"&patient_info_link="+patientInfoLink,			
			  success: function(data){ 			
				  if($.trim(data) == "success"){					
						linkData = $("#patient_info_link").val();			  		
				  		$('#patientInfoLinkLabel1').text(linkData);	  		
				  		$('#patientInfoLinkLabel1').attr('href',linkData);	
				  		if(linkData==''){
					  		$('#patientInfoLinkText').show();
				  		}else{	 
				  		alert("Link saved successfully.");
				  		$('#patientInfoLinkLabel').show();
				  		$('#patientInfoLinkLabel1').show();
					  	$('#patientInfoLinkText').hide().val('');	
				  		}			 
					 }			  
			  }		  
			});
	  	 return true; 
		}
	}); 
	
	$('#patientInfoLinkLabel').click(function (){		
		var id= $(this).attr('id');
		if(id){
			$('#patientInfoLinkText').show();		
			$('#patientInfoLinkLabel').hide();
		}else{	
			$('#patientInfoLinkText').hide();		
			$('#patientInfoLinkLabel').show();			
		}
	});
///////////////////*********BOE-Its for Link/URL********///////////////////////  

//})


function changeLanguage(target){
	var icd_id=$("#icd_id").val(); 	
	var diagnoses_name="<?php echo $diagnosis_name;?>"; 
	var patient_id="<?php echo $id;?>"; 
	var langvalue=target.value; 
    var url = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "infobutton", "admin" => false)); ?>"+"/"+icd_id+"/"+diagnoses_name+"/"+patient_id+"/null/null/"+langvalue;
	window.location.href=url;
}
</script>

