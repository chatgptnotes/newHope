<?php 
echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en'));
echo $this->Html->css(array('internal_style.css','validationEngine.jquery.css'));
?>
<style>
.descField textarea {
    height: 500px;
    width: 530px;
}
@media print {
  		.printButton{display:none;}
    }
</style>
<div class="inner_title">
	<h3 align="center">
		&nbsp;
		<?php echo __('Patient Education-Medications', true); ?>
	</h3>

</div>

<?php echo $this->Form->create('NewCropPrescription',array('type' => 'file','id'=>'infoButtonFrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
echo $this->Form->hidden('NewCropPrescription.id',array('id'=>'nowcrop_id','value'=>$getMedicationData['NewCropPrescription']['id']));
echo $this->Form->hidden('PharmacyItem.drug_id',array('id'=>'PharmacyItem_drug_id')); 
echo $this->Form->hidden('NewCropPrescription.drug_id',array('id'=>'drug_id','value'=>$getMedicationData['NewCropPrescription']['drug_id']));
echo $this->Form->hidden('NewCropPrescription.patient_uniqueid',array('id'=>'patient_id','value'=>$getMedicationData['NewCropPrescription']['patient_uniqueid']));

?>
<table border="0" cellpadding="0" cellspacing="0" width="99%" style="padding-top: 10px;" align="center">
<tr><td width="99%" class="printButton" colspan="4" >
<p align="center"><font color="red"><?php
echo __("We don't have an exact match for the medication you selected. You may add content below.");?></font><!-- <a  target="_blank" href="https://vsearch.nlm.nih.gov/vivisimo/cgi-bin/query-meta?v%3Aproject=medlineplus&query=<?php echo $new_url;?>"><u>Click here</u></a> to search. --></font></p>
</td>
<tr><td>&nbsp;</td></tr>

</tr>
<?php ///if(!empty($getMedicationData['NewCropPrescription']['patient_info'])){?>
<tr class="row_title">			
	<td class="tdLabel" id="boxSpace" width="19%" align="left" colspan="4">
	<strong><?php echo ucFirst($getMedicationData['NewCropPrescription']['drug_name']); ?></strong>
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
		<?php 
		if(empty($getPharmacyItemData['PharmacyItem']['patient_info'])){
		$showTextBox="block";
		}else{
		$showTextBox="none";
		}?><div id="patientInfoText" class="descField" style="display:<?php echo $showTextBox?>;"><!--class="descField"-->
		<?php echo $this->Form->input('patient_info', array('type'=>'textarea','class' => '','id' => 'patient_info', 'label'=> false, 'div' => false, 'error' => false,'value'=>$getPharmacyItemData['PharmacyItem']['patient_info'],'placeholder'=>'Paste patient education content here...'));?>
		</div></td>
		<?php  //if(!empty($getMedicationData['NewCropPrescription']['patient_info'])){?>
		<td class="tdLabel" id="boxSpace">	
		<?php if(!empty($getPharmacyItemData['PharmacyItem']['patient_info'])){
		$showLabel="block";
		}else{
		$showLabel="none";
		}?>
		<div style="word-wrap: break-word;width:560px;float:left;display:<?php echo $showLabel?>;" id='patientInfoLabel' >
		<?php 
		$description=explode('.',$getPharmacyItemData['PharmacyItem']['patient_info']);
		foreach($description as $data){
			 echo "<p>".$data."</p>";
		 }?>
		</div>
		</td>
		</tr>
		<?php //if(!empty($getMedicationData['NewCropPrescription']['patient_info'])){?>
		<tr>
		<td class="printButton" width="10%" colspan="7">
		<div class="btns"><?php echo $this->Html->link('Print',"javascript:void(0)",array('class'=>'blueBtn','label'=>false,'id'=>'print'));?>	
		</div> 
		</td><?php echo $this->Form->checkbox('NewCropPrescription.PrintLeaflet',array('id'=>'is_printed','style'=>"display:none;")); //,'value'=>$get_snomwd_code['NoteDiagnosis']['is_printed']?>
		</tr>
		<?php //}?>
		</table>		
		</td>		
</tr>
<!-- <tr class="printButton">
		<td class="tdLabel" id="boxSpace" colspan="2" style="text-align:center;"><strong><font color="red"><?php echo __('OR'); ?></font></strong>
		</td>				
</tr> -->
<tr class="printButton">
		<td class="tdLabel" id="boxSpace" width="19%"><?php echo __('Link/URL'); ?>
		</td>
		<td>		
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>	
		<td>
		<?php if(empty($getPharmacyItemData['PharmacyItem']['patient_info_link'])){
		$showTextBox1="block";
		}else{
		$showTextBox1="none";
		}?>
		<div id="patientInfoLinkText" style="display:<?php echo $showTextBox1?>;"><!--class="descField"-->
		<?php echo $this->Form->input('patient_info_link', array('class' => 'textBoxExpnd ','type'=>'text','id' => 'patient_info_link', 'label'=> false, 'div' => false, 'error' => false,'value'=>$getPharmacyItemData['PharmacyItem']['patient_info_link'],'style'=>'width:360px;'));?>
		</div></td>
		
		<td class="tdLabel" id="boxSpace">	
		<?php /*if(!empty($getMedicationData['NewCropPrescription']['patient_info_link'])){
		$showLabel2="block";
		}else{
		$showLabel2="none";
		}*/ ?>
		<div style="float:left;" id="patientInfoLinkLabel" >
		<a target="_blank" id="patientInfoLinkLabel1" href="<?php echo $getPharmacyItemData['PharmacyItem']['patient_info_link']; ?>"><?php echo $getPharmacyItemData['PharmacyItem']['patient_info_link']; ?></a>
		<?php //echo $getMedicationData['NewCropPrescription']['patient_info_link'];?>			
		</div>
		</td>
		<?php /*if(empty($getMedicationData['NewCropPrescription']['patient_info_link'])){
			$showTextBox2="block";
			}else{
			$showTextBox2="none";
			}*/?>		
		<!-- <td class="tdLabel"  id="boxSpace"><a target="_blank" id="patientLinkrght" href="<?php //echo $getPharmacyItemData['PharmacyItem']['patient_info_link']; ?>"><?php echo __('Click here'); ?></a></td> -->
		<?php //} ?>
		</tr>		
		</table>		
		</td>		
</tr>	
</table>
<?php echo $this->Form->end();?>
<script>
$('#print').click(function(){	
	window.print();	
});


/*jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#infoButtonFrm").validationEngine();
});*/
<?php if($status == "success"){?>
	jQuery(document).ready(function() { 
		parent.$.fancybox.close(); 
	});
<?php   } ?>	
	///////////////////*********BOF-Its for Description********///////////////////////
	$('#patient_info').focusout(function (){
		var drug_id=$("#drug_id").val();
		var patient_id=$("#patient_id").val();		
		var newCropid=$("#nowcrop_id").val();
		var patientInfo=$("#patient_info").val(); 
		var htmlData = '';
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addInfoDescription", "admin" => false)); ?>"+ '/'+drug_id+"/"+patient_id+'/'+newCropid,
			  context: document.body,
			  data:"drug_id="+drug_id+"&patient_uniqueid="+patient_id+"&id="+newCropid+"&patient_info="+patientInfo,
			  success: function(data){ 
				 if($.trim(data) == "success"){					
					htmlData=$('#patient_info').val(); 
					/*htmlData=htmlData.split(".");
					var cnt=0;
					for(cnt=0;cnt< htmlData;cnt++){
						htmlData="<p>"+htmlData+"</p>";
						
					}	*/		
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
	$('#print').click(function (){
		//	var toggleId = $(this).attr('class');
			var id= $(this).attr('id'); 
			var drug_id=$("#drug_id").val();
			var patient_id=$("#patient_id").val();		
			var newCropid=$("#nowcrop_id").val();
			var patientInfo=$("#patient_info").val(); 
			var value;
			if(id=='print'){
				$('#is_printed').attr('checked', true);
				value='T';
		    }else{
		    	$('#is_printed').attr('checked', false);
		    	value='F';
		    }
		//	$('.'+toggleId).toggle();
			$.ajax({
				  type : "POST",
				  url: "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addIsPrinted", "admin" => false)); ?>"+ '/'+drug_id+"/"+patient_id+'/'+newCropid,
				  context: document.body,
				  data:"drug_id="+drug_id+"&patient_uniqueid="+patient_id+"&id="+newCropid+"&PrintLeaflet="+value,	
				  success: function(data){	
					  parent.window.bulbgreen = true;	
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

	$("#infoButtonFrm").validationEngine();

	$('#patient_info_link').focusout(function (){
		var validateMandatory = jQuery("#infoButtonFrm").validationEngine('validate');
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
				//alert('Please enter Description or Link/URL');			
				//return false;
			}*/
		var drug_id=$("#drug_id").val();
		var patient_id=$("#patient_id").val();		
		var newCropid=$("#nowcrop_id").val();
		var patientInfoLink=$("#patient_info_link").val();
		$.ajax({
			  type : "POST",
			  url: "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "addInfoLink", "admin" => false)); ?>"+ '/'+drug_id+"/"+patient_id+'/'+newCropid,
			  context: document.body,
			  data:"drug_id="+drug_id+"&patient_uniqueid="+patient_id+"&id="+newCropid+"&patient_info_link="+patientInfoLink,			
			  success: function(data){ 		
				 if($.trim(data) == "success"){					
					linkData = patientInfoLink;			  		
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
</script>

