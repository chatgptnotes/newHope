<?php echo $this->Html->script(array('inline_msg'));?>
<style>
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
</style>
<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
if(!empty($errors)) {
	?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left" class="error"><?php 
		foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		}
		     		?>
		</td>
	</tr>
</table>
<?php }
if($this->params->query['type']=='OPD'){
	$urlType= 'Ambulatory';
	$serachStr ='OPD';
	$searchStrArr = array('type'=>'OPD');
}else if($this->params->query['type']=='emergency'){
		$urlType= 'Emergency';
		$serachStr ='IPD&is_emergency=1';
		$searchStrArr = array('type'=>'IPD','is_emergency'=>1);
	}else if($this->params->query['type']=='IPD'){
		$urlType= 'Inpatient' ;
		$serachStr ='IPD&is_emergency=0' ;
		$searchStrArr = array('type'=>'IPD','is_emergency'=>0);
	}
	$queryStr =  $this->General->removePaginatorSortArg($this->params->query) ;
	?>
<style>
label {
	width: 126px;
	padding: 0px;
}
</style>
<div class="inner_title">
	<div style="float: left">
			<h3>
				<?php echo __('Manage Patient Insurance'); ?>
			</h3>
		</div>
	<table border="0" class=" " cellpadding="0" cellspacing="0" width="100%"
		align="center">
		<tbody>

			<tr class="">
				<!--  <td class="" align="right"><font color='white' size='-1'>Payment Preference</font>
		<?php echo $this->Form->input(__('Person.payment_category'),array('div'=>false,'label'=>false,'id'=>'paycheck',
				'empty'=>__("Select"),'options'=>array('cash'=>'Self','Primary'=>'Primary','Secondary'=>'Secondary'),'selected'=>$getPersonPayType,'onchange'=>"javascript:changePaytype('$getPersonID')"));?></td> -->
					<td valign="top" align="right" style="font-size: 13px;" id="boxSpace"><?php echo $this->Html->link(('Claim Manager'), array('controller'=>'Insurances','action' => 'claimManager',$patient_id,true), array('class'=>'blueBtn','escape' => false,'title'=>'Claim Submission-First Scrubbing'));?><font color='black'
					size='-1'>Show inactive list</font> <?php	echo " ". $this->Form->checkbox(__('Show inactive list'),array('div'=>false,'label'=>false,'id'=>'listcheck','onclick'=>"javascript:showinactivelist()"))."   ". $this->Html->link(__('Add'),array('controller'=>'patients','action'=>'addInsurance',$patient_id),array('class'=>'blueBtn','div'=>false,'label'=>false));?>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div id= 'verifymsg' style="display:none;font-weight:bold; text-align:center;background-color:#394145;color:#78D83E; height:21px;padding-top: 10px;"><strong></strong></div>
<?php echo $this->element('patient_information');?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
<?php 
if(!empty($getDataNewInsurance)){?>
<div class="inner_title" >
		<h3>
			&nbsp;
			<?php
			echo __('Active Insurance details ')
			?>
		</h3>
		<span></span>
	</div>
	<tr class="row_title">
		<td class="table_cell tdLabel"  id="boxSpace" width="16%"><strong><?php echo  __('Primary Insurance', true); ?>
		</strong>
		</td>
		<td class="table_cell tdLabel"  id="boxSpace" width="16%"><strong><?php echo  __('Secondary Insurance', true); ?>
		</strong></td>
		<td class="table_cell tdLabel"  id="boxSpace" width="16%"><strong><?php echo  __('Tertiary Insurance', true); ?> </strong>
		</td>
		<td class="table_cell tdLabel"  id="boxSpace" width="16%"><strong><?php echo  __('Action'); ?> </strong>
		</td>
		<td class="table_cell tdLabel"  id="boxSpace" width="16%"><strong><?php echo  __('Active Insurance'); ?> </strong>
		</td>
		<!-- <td class="table_cell tdLabel"  id="boxSpace" width="16%"><strong><?php echo  __('Is Verified'); ?> </strong>
		</td> -->
		<td class="table_cell tdLabel"  id="boxSpace" width="16%"><strong><?php echo  __('Check Eligibility'); ?> </strong>
		</td>
	</tr>
	<?php 	$toggle =0;
	//if(count($getDataNewInsurance) > 0) {
				      		foreach($getDataNewInsurance as $data){	
$getNewinsuranceId=$data['NewInsurance'][id];						
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
							       ?>
	<td class="row_format table_cell tdLabel"  id="boxSpace" width="16%"><?php if($data['NewInsurance']['priority']=='P' || $data['NewInsurance']['priority']=='Primary' || $data['NewInsurance']['priority']==''){
		echo $data['NewInsurance']['tariff_standard_name'];
	}else{
	echo $data['Secondary']['0']['tariff_standard_name']; 	  
	} ?>
	</td>
	<td class="row_format table_cell tdLabel"  id="boxSpace" width="16%"><?php if($data['NewInsurance']['priority']=='S' || $data['NewInsurance']['priority']=='Secondary'){
		echo $data['NewInsurance']['tariff_standard_name'];
	}else if($data['Secondary']['0']['priority']=='S'){
	echo $data['Secondary']['0']['tariff_standard_name']; 	 
	}?>
	</td>
	<td class="row_format table_cell tdLabel"  id="boxSpace" width="16%"><?php  if($data['NewInsurance']['priority']=='T' || $data['NewInsurance']['priority']=='Tertiary'){
		echo $data['NewInsurance']['tariff_standard_name'];
	}else if($data['Secondary']['1']['tariff_standard_name']){
	echo $data['Secondary']['1']['tariff_standard_name']; 
	}else if($data['Secondary']['0']['priority']=='T'){
	echo $data['Secondary']['0']['tariff_standard_name']; 
	}	  	 ?>
	</td>
	<td class="row_format table_cell tdLabel"  id="boxSpace" width="16%"><?php 
	echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('controller'=>'patients','action'=>'editInsurance',$data['NewInsurance']['id'],$data['NewInsurance']['patient_id']),array('title'=>'Edit','alt'=>'Edit','escape' => false));
	?>
	</td>
	<td class="row_format table_cell tdLabel"  id="boxSpace" width="16%">
	<?php
	$is_activechk = ($data['NewInsurance']['is_active'] == '0') ? true : false;
	echo $this->Form->checkbox('NewInsurance.is_active', array('label'=>false,'id' => 'is_inactive-'.$getNewinsuranceId,'title'=>'Active','class'=>'InactiveCls','checked'=>$is_activechk));
	
	echo $this->Form->hidden('refference_id',array('id'=>'refference_idinactive','value'=>$getNewinsuranceId));?>
	
	</td>
	<?php $expLokkupName=explode(' ',$patient['0']['lookup_name']);
		$surName=$expLokkupName['2'];
		$name=$expLokkupName['1'];
		$expPatientDob=explode('-',$patient['Person']['dob']);
		
		//find relation to insured
		if($data['NewInsurance']['relation']=="spouse")
			$relationInsured="01";
		elseif($data['NewInsurance']['relation']=="child")
		    $relationInsured="19";
		elseif($data['NewInsurance']['relation']=="other")
		    $relationInsured="34";
		elseif($data['NewInsurance']['relation']=="D")
		    $relationInsured="D";
		else
			$relationInsured="S";
		
		$strDob=$expPatientDob['1']."/".$expPatientDob['2']."/".$expPatientDob['0'];?>
		<td class="row_format table_cell tdLabel"  id="boxSpace" width="16%"><?php echo $this->Html->link($this->Html->image('icons/1361479921_credit-card.png'),
				'javascript:void(0)',array('onclick'=>'check_eligibility(\''.$hospital_location.'\',\''.$data['NewInsurance']['tariff_standard_name'].'\',
				\''.$surName.'\',\''.$name.'\',\''.$strDob.'\',\''.$data['NewInsurance']['payer_id'].'\',\''.$relationInsured.'\',\''.$data['NewInsurance']['policy_no'].'\');','title'=>'Edit','alt'=>'Edit','escape' => false));?>
	</td>
	</tr>
<?php }
		}else{?>
	<tr>
		<TD colspan="8" align="center" class="error tdLabel" id="boxSpace"><?php echo __('No record found', true); ?>.</TD>
	</tr>
<?php }?>
</table>
<!-- inactive list -->
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" id='inactive' style="display:none;">
<?php 
if(!empty($getDataNewInsuranceInactive)){?>
<tr>
<td colspan="6">
<div class="inner_title" >
		<h3>
			&nbsp;
			<?php
			echo __('Inactive Insurance details ')
			?>
		</h3>
		<span></span>
	</div>
	</td>
	</tr>
	<tr class="row_title">
		<td class="table_cell tdLabel"  id="boxSpace" width="16%"><strong><?php echo  __('Primary Insurance', true); ?>
		</strong>
		</td>
		<td class="table_cell tdLabel"  id="boxSpace" width="16%"><strong><?php echo  __('Secondary Insurance', true); ?>
		</strong></td>
		<td class="table_cell tdLabel"  id="boxSpace" width="16%"><strong><?php echo  __('Tertiary Insurance', true); ?> </strong>
		</td>
		<td class="table_cell tdLabel"  id="boxSpace" width="16%"><strong><?php echo  __('Action'); ?> </strong>
		</td>
		<td class="table_cell tdLabel"  id="boxSpace" width="16%"><strong><?php echo  __('In Active Insurance'); ?> </strong>
		</td>
		<!-- <td class="table_cell tdLabel"  id="boxSpace" width="16%"><strong><?php echo  __('Is Verified'); ?> </strong>
		</td> -->
		<td class="table_cell tdLabel"  id="boxSpace" width="16%"><strong><?php echo  __('Check Eligibility'); ?> </strong>
		</td>
	</tr>
	<?php 	$toggle =0;
	//if(count($getDataNewInsurance) > 0) {
				      		foreach($getDataNewInsuranceInactive as $data){	
					$getNewinsuranceId=$data['NewInsurance'][id];					
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
							       ?>
	<td class="row_format table_cell tdLabel"  id="boxSpace" width="16%"><?php if($data['NewInsurance']['priority']=='P' || $data['NewInsurance']['priority']=='Primary' || $data['NewInsurance']['priority']==''){
		echo $data['NewInsurance']['tariff_standard_name'];
	} ?>
	</td>
	<td class="row_format table_cell tdLabel"  id="boxSpace" width="16%"><?php if($data['NewInsurance']['priority']=='S' || $data['NewInsurance']['priority']=='Secondary'){
		echo $data['NewInsurance']['tariff_standard_name'];
	}else{
	echo $data['Secondary']['0']['tariff_standard_name']; 	 
	}?>
	</td>
	<td class="row_format table_cell tdLabel"  id="boxSpace" width="16%"><?php  if($data['NewInsurance']['priority']=='T' || $data['NewInsurance']['priority']=='Tertiary'){
		echo $data['NewInsurance']['tariff_standard_name'];
	}else{
	echo $data['Secondary']['1']['tariff_standard_name']; 
	}	  	 ?>
	</td>
	<td class="row_format table_cell tdLabel"  id="boxSpace" width="16%"><?php 
	echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('controller'=>'patients','action'=>'editInsurance',$data['NewInsurance']['id'],$data['NewInsurance']['patient_id']),array('title'=>'Edit','alt'=>'Edit','escape' => false));?>
	</td>
	<td class="row_format table_cell tdLabel"  id="boxSpace" width="16%">
	<?php 
	$is_activechk = ($data['NewInsurance']['is_active'] == '1') ? true : false;
	echo $this->Form->checkbox('NewInsurance.is_active', array('label'=>false,'id' => 'is_active-'.$getNewinsuranceId,'title'=>'Active','class'=>'activeCls','checked'=>$is_activechk));
	echo $this->Form->hidden('refference_id',array('id'=>'refference_idina','value'=>$getNewinsuranceId));?>
	
	</td>
	<?php $expLokkupName=explode(' ',$patient['0']['lookup_name']);
		$surName=$expLokkupName['2'];
		$name=$expLokkupName['1'];
		$expPatientDob=explode('-',$patient['Person']['dob']);
		
		//find relation to insured
		if($data['NewInsurance']['relation']=="spouse")
			$relationInsured="01";
		elseif($data['NewInsurance']['relation']=="child")
		    $relationInsured="19";
		elseif($data['NewInsurance']['relation']=="other")
		    $relationInsured="34";
		elseif($data['NewInsurance']['relation']=="D")
		    $relationInsured="D";
		else
			$relationInsured="S";
		
		$strDob=$expPatientDob['1']."/".$expPatientDob['2']."/".$expPatientDob['0'];?>
		<td class="row_format table_cell tdLabel"  id="boxSpace" width="16%"><?php echo $this->Html->link($this->Html->image('icons/1361479921_credit-card.png'),
				'javascript:void(0)',array('onclick'=>'check_eligibility(\''.$hospital_location.'\',\''.$data['NewInsurance']['tariff_standard_name'].'\',
				\''.$surName.'\',\''.$name.'\',\''.$strDob.'\',\''.$data['NewInsurance']['payer_id'].'\',\''.$relationInsured.'\',\''.$data['NewInsurance']['policy_no'].'\');','title'=>'Edit','alt'=>'Edit','escape' => false));?>
	</td>
	</tr>
<?php }
		}else{?>
	<tr>
		<TD colspan="8" align="center" class="error tdLabel" id="boxSpace"><?php echo __('No record found', true); ?>.</TD>
	</tr>
<?php }?>
</table>
<script>

$('.verifyRecord').click(function () {	
	verifiedValue = (this.checked == true)? 1 : 0;
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "isVerified")); ?>"+ '/' +  $(this).attr('id') + '/' + verifiedValue;
	$.ajax({
		type: 'POST',
		beforeSend : function() {
    		// this is where we append a loading image
    		$('#busy-indicator').show('fast');
    		},
		url: ajaxUrl,
		dataType: 'html',
 		success: function(data){
 			 $('#busy-indicator').hide('fast');	
 	 		if(data==1){
 	 			$('#verifymsg').show();
 	 			$('#verifymsg').html('Verified Successfully');
 	 		}
 	 			else{
 	 				$('#verifymsg').show();
 	 	 			$('#verifymsg').html('Concealed Successfully');
 	 			}
 	     	}
	
	});
			
});
	//script to include datepicker
		$(function() {
			$("#dob").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>', 
		});
		});
			/*$("#PatientSearchForm").click(function(){
			  $('input:text').each(function(){
			    alert($(this).text())
			  });
			}); */
			
			
		$('#PatientSearchForm').submit(function(){
			var msg = false ; 
			$("form input:text").each(function(){
			       //access to form element via $(this)
			       
			       if($(this).val() !=''){
			       		msg = true  ;
			       }
			    }
			);
			if(!msg){
				alert("Please fill atleast one field .");
				return false ;
			}		
		});
		
		 
   
  $(document).ready(function(){
	  $('#inactive').hide();
	  $('#inactivediv').hide();
			$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name",'null','null','null','admission_type='.$serachStr,"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","patient_id",'null','null','null','admission_type='.$serachStr, "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#admission_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id",'null','null','null','admission_type='.$serachStr, "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
	 	});
	function showinactivelist(){
		//listcheck
		var getVal=$('#listcheck:checked').val(); //alert(getVal);
		if(getVal==1){
		$('#inactive').show();
		$('#inactivediv').show();
		}
		else{
			$('#inactive').hide();
			$('#inactivediv').hide();
		}
		
	}
	 /* function changePaytype(getPersonID){
		var getValPaycheck=$('#paycheck option:selected').val();
		//alert(getValPaycheck);
			 var ajaxUrl = "<?php //echo $this->Html->url(array("controller" => 'Patients', "action" => "presonpaymentupdate","admin" => false)); ?>"+"/"+ getPersonID + "/"+ getValPaycheck;
			 $.ajax({
			 type : "POST",
			 url : ajaxUrl,
			 context : document.body,
			 success : function(data) {
				 alert("Update Record");
			 },
			 error: function(){
				 alert("Internal Error Occured. Unable To Update.");
				 },
			 
			 });
		
	} */
	//$('.check_eligibility').click(function(){
	function check_eligibility(locationId,insuranceCompanyName,surName,name,Dob,payer_id,relationInsured,insuredId){
		

        if(payer_id=="")
        	payer_id="61101";
        
			/*
		var opt= $('#service_type').val();
		if(opt==''){
			alert('Please select service type.' );
			return false;
		}*/
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "eligibilityCheck")); ?>"+ '/'+ <?php echo $patient_id;?>;
		$.ajax({
			type: 'POST',
			beforeSend : function() {
	    		// this is where we append a loading image
	    		$('#busy-indicator').show('fast');
	    		},
			url: ajaxUrl,
			dataType: 'html',
	 		success: function(data){
	 			 $('#busy-indicator').hide('fast');	
	 	 		if(data==1){
	 	 			var url='https://eligibilityapi.zirmed.com/1.0/Rest/Gateway/GatewayAsync.ashx?UserID=drmhope82108&Password=zirmed123&DataFormat=SF1&ResponseType=HTML';
	 	 			 url+='&Data='+locationId// hopital name
	 	 			url+='|'+insuranceCompanyName// insurance co name
	 	 			url+='|'+insuredId;//insuredID
	 	 			 url+='|'+surName;// surname
	 	 			 url+='|'+name;//name
	 	 			 url+='|'+Dob//dob
	 	 			 url+='|'+relationInsured;// relation to insured
	 	 			 url+='|'+"";
	 	 		 url+='|'+'<?php echo Date('m/d/Y')?>'// date of service range
	 	 		 url+='|'+30;  //"30" (Health Benefit Plan Coverage) 
	 	 			 url+='|'+"";
	 	 		 url+='|'+payer_id;//  PayerId33333
	 	 			 url+='|'+"";
	 	 			 url+='|'+"1";
	 	 			 url+='|'+"1P1";
	 	 			 url+='|'+"";
	 	 			 url+='|'+"";
	 	 			 url+='|'+"";
	 	 			 url+='|'+"";
	 	 			 url+='|'+"";
	 	 					$.fancybox({
	 	 						'width' : '80%',
	 	 						'height' : '80%',
	 	 						'autoScale' : true,
	 	 						'transitionIn' : 'fade',
	 	 						'transitionOut' : 'fade',
	 	 						'type' : 'iframe',
	 	 						'hideOnOverlayClick':false,
	 	 						'showCloseButton':true,
	 	 						'href' :url,
	 	 						//'href' : '&Data=ABCCLINIC|HUMANA|H333224444|DOE|JOHN|9/5/1988|S||10/18/2011|99242||61101||1|1P|||123456789||HPI-1234567890',
	 	 						//'href' : "<?php echo $this->Html->url(array("controller"=>"Insurances", "action" => "eligibilityCheck","admin" => false)); ?>"+"/"+url,
	 	 			
	 	 					});	
	 	 		}
	 	 			else{
	 	 			}
	 	     	}
		
		});
		
	}
	$(document).ready(function(){
		$('.activeCls').click(function (){
			//	var toggleId = $(this).attr('class');			
			var patientId="<?php echo $patient_id;?>";			
				var id= $(this).attr('id');
				var splittedVar = id.split("-");	
				var value;
				if($( '#is_active-'+splittedVar[1] ).is(':checked') == false) {
					value=0;
			    }else{	    	
			    	value=1;
			    }			  
				 $.ajax({
					  type : "POST",
					  url: "<?php echo $this->Html->url(array("controller" => "patients", "action" => "saveInsuranceActive", "admin" => false)); ?>",
					  context: document.body,
					  data: "is_active="+value+"&id="+splittedVar[1]+"&patient_id="+patientId,
					  beforeSend:function(){
			 			  	// this is where we append a loading image
			 			  	$('#busy-indicator').show('fast');},
					  success: function(data){ 
						  $('#busy-indicator').hide('fast');
						  inlineMsg(id,'Active Insurance successfully');	
						  parent.location.reload(true); 			 
					  }
				});	
			});
		$('.InactiveCls').click(function (){
			//	var toggleId = $(this).attr('class');			
			var patientId="<?php echo $patient_id;?>"; 							
				var id= $(this).attr('id');
				var splittedVar = id.split("-");		
				var value;
				if($( '#is_inactive-'+splittedVar[1] ).is(':checked') == true) {
					value=0;
			    }else{	    	
			    	value=1;
			    }			
				 $.ajax({
					  type : "POST",
					  url: "<?php echo $this->Html->url(array("controller" => "patients", "action" => "saveInsuranceActive", "admin" => false)); ?>",
					  context: document.body,
					  data: "is_active="+value+"&id="+splittedVar[1]+"&patient_id="+patientId,
					  beforeSend:function(){
			 			  	// this is where we append a loading image
			 			  	$('#busy-indicator').show('fast');},
					  success: function(data){ 
						  $('#busy-indicator').hide('fast');
						  inlineMsg(id,'Inactive Insurance successfully');	
						  parent.location.reload(true); 				 
					  }
				});	
			});
		  });  

	  </script>

	