 <style>
#age1{ float:left!important;}
#age2{ float:left!important;}
label{ width:119px !important; text-align:left; padding:0px !important;}
#Lab{margin: 20px 0 0;}
#Allergies{margin: 20px 0 0;}
#Medication{margin: 20px 0 0;}
#Problem{margin: 20px 0 0;}
#Demographics{margin: 20px 0 0;}

.light:hover {
	background-color: #F7F6D9;
	text-decoration:none;
	    color: #000000; 
	}
	
</style>

<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));  
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
//echo $this->Html->script('jquery.autocomplete');
//echo $this->Html->css('jquery.autocomplete.css'); ?>
  <?php 
	echo $this->Html->css(array('tooltipster.css'));
	echo $this->Html->script(array('jquery.tooltipster.min.js'));
	
	?>
<script>
	

	jQuery(document).ready(function(){
	 jQuery('#admission_type').change(function() {  
	  if(jQuery('#admission_type').val() == "OPD") {
	   jQuery('#showSkipRegistration').show();
	   jQuery('#showOpdPatientStatus').show();
	   jQuery('#showIpdPatientStatus').hide();
	  } else if(jQuery('#admission_type').val() == "IPD") {
	    jQuery('#showIpdPatientStatus').show();
		jQuery('#showSkipRegistration').hide();
	    jQuery('#showOpdPatientStatus').hide();
	  } else {
	   jQuery('#ipd_patient_status').val('');
	   jQuery('#opd_patient_status').val('');
	   jQuery('#skip_registration').val('');
	   jQuery('#showSkipRegistration').hide();
	   jQuery('#showOpdPatientStatus').hide();
	   jQuery('#showIpdPatientStatus').hide();
	  }
	});
	// binds form submission and fields to the validation engine
	jQuery("#reportfrm").validationEngine();
	});
</script>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Patient List', true); ?>
	</h3>

</div>
<form name="reportfrm" id="reportfrm"
	action="<?php echo $this->Html->url(array("controller" => "reports", "action" => "admin_patient_list")); ?>"
	method="get">
	<p class="ht5"></p>
	<div align="center" id='butid'>

		<div class="btns" style="float: none">
			<input type="button" value="Preferred Communication" class="blueBtn"
				onclick="showPC()"> <input type="button"
				value="Demographics" class="blueBtn" onclick="showDemographics()">
			<input type="button" value="Problem"
				class="blueBtn" onclick="showProblem()"> <input type="button"
				value="Medication" class="blueBtn" onclick="showMedication()"> <input
				type="button" value="Drug Allergies" class="blueBtn"
				onclick="showAllergies()"> <!-- <input type="button"
				value="Lab Observation" class="blueBtn" onclick="showLab()"> -->
			<input type="submit" value="Show Graph" class="blueBtn"
				id="get report" style="display: none;">
			<?php //echo $this->Html->link(__('Cancel', true),array('action' => 'all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
		</div>
	</div>
	<div>
		<table border="0" class="table_format_body" cellpadding="0"
			cellspacing="0" width="100%">
			<!-- <tr class="row_title">
				<td id="boxSpace" class="tdLabel" valign="middle"><?php echo __("Start Date");?><font color="red">*</font></td>
				<td class="table_cell" ><strong><?php echo $this->Form->input('start_date', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px','readonly'=>'readonly', 'size'=>'20','id' => 'start_date'));?>
				</strong></td>
				<td id="boxSpace" class="tdLabel" valign="middle"><?php echo __("End Date");?> <font color="red">*</font></td>
				<td class="table_cell" colspan="4"><strong><?php echo $this->Form->input('end_date', array('type'=>'text','label'=>false,'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:120px','readonly'=>'readonly', 'size'=>'20','id' => 'end_date'));?>
				</strong></td>
			</tr> -->
			<tr class="row_title">
			<td id="boxSpace" class="tdLabel" style="padding-top: 10px"><?php echo __("First Name");?></td>
			<td  class="table_cell" style="padding-top: 10px"><?php echo $this->Form->input('first_name', array('type'=>'text','label'=>false,'class' => 'textBoxExpnd','style'=>'width:280px','id' => 'first_name','div'=>false));?></td>
			<td id="boxSpace" class="tdLabel" style="padding-top: 10px"><?php echo __("Last Name");?></td>
			<td class="table_cell" style="padding-top: 10px"><?php echo $this->Form->input('last_name', array('type'=>'text','label'=>false,'class' => 'textBoxExpnd','style'=>'width:308px','id' => 'last_name','div'=>false));?></td>
			</tr>
		</table>
	</div>
	<div id="Communication">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			align="center">
			<tr>
				<td>
					<table border="0" class="table_format_body" cellpadding="0"
						cellspacing="0" width="100%">

						<tr class="">
							<td width="15%" class="tdLabel" id="boxSpace"><?php echo __('Preferred Communication');?>
							</td>
							<td width="19%"><?php $comm = array('Email'=>'Email','Telephone'=>'Telephone','Fax'=>'Fax','Mail'=>'Mail','SMS'=>'SMS','Text'=>'Text','Denied to specify'=>'Declined to specify'); ?>
								<?php echo $this->Form->input('P_comm', array('empty'=>__('Please Select'),'options'=>$comm,'id' =>'P_comm','style'=>'width:230px','label'=>false)); ?>
							</td>
							<td class="table_cell" width="8%" style="font-size:13px;"><?php echo __("Language")?>
							</td>
							<td class="table_cell"><strong> <?php echo $this->Form->input('language', array('label'=>false,'empty'=>__('Please Select'),'options'=>$get_language,'id' =>'language','style'=>'width:230px;height:19px!important;border:1px solid #000!important;background: -moz-linear-gradient(center top , #f1f1f1, #ffffff) repeat scroll 0 0 rgba(0, 0, 0, 0) !important;')); ?>
							</strong>
							</td>
							</td>
						</tr>
					</table>
			
			
			<tr class="">
				<td class="table_cell" colspan="5" algin="right"><strong> <?php
				echo $this->Js->link('<input type="button" value="Submit" class="blueBtn" style="float:right">', array('controller'=>'reports', 'action'=>'communication', 'admin' => false,'?'=>array('flag'=>$flag)), array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn',array('buffer' => false)),'update'=>'#Communications', 'data' => '{P_comm:$("#P_comm").val(),language:$("#language").val(), start_date:$("#start_date").val(), end_date:$("#end_date").val(), first_name:$("#first_name").val(), last_name:$("#last_name").val()}','success' => $this->Js->get('#busy-indicator')->effect('fadeOut',array('buffer' => false)),'dataExpression' => true,'htmlAttributes' => array('escape' => false) ));echo $this->Js->writeBuffer();
				?>
				</strong>
				</td>
			</tr>

		</table>
		<div id="Communications"></div>

	</div>
	<div id="Demographics" style="display: none">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			align="center">
			<tr>
				<td>
					<table border="0" class="table_format_body" cellpadding="0"
						cellspacing="0" width="100%">
                        <tr class="row_title">
                         <td class="table_cell" algin="right" colspan="11" style="line-height:33px; padding:0 0 0 17px;"><strong><?php echo __("Demographic");?></strong>
				</td>
                </tr>
						<tr class="">
							<td width="9%" class="tdLabel" id="boxSpace"><?php echo __("Language")?>
							</td>
							<td class="table_cell"><strong> <?php echo $this->Form->input('language', array('label'=>false,'empty'=>__('Please Select'),'options'=>$get_language,'id' =>'language1','style'=>'width:180px')); ?>
							</strong>
							</td>
							<td width="9%" class="tdLabel" id="boxSpace"><?php echo __("Race")?>
							</td>
							<td class="table_cell"><strong> <?php echo $this->Form->input('race', array('label'=>false,'empty'=>__('Please Select'),'options'=>$get_race,'id' => 'race','style'=>'width:180px')); ?>
							</strong>
							</td>
							<td width="9%" class="tdLabel" id="boxSpace"><?php echo __("Enthnicity")?>
							</td>
							<?php  $optn=array('2135-2:Hispanic or Latino'=>'Hispanic or Latino','2186-5:Not Hispanic or Latino'=>'Not Hispanic or Latino','UnKnown'=>'UnKnown','Denied to Specific'=>'Declined to specify');
							?>
							<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('enthnicity', array('label'=>false,'empty'=>__('Please Select'),'options'=>$optn,'id' => 'enthnicity','style'=>'width:180px')); ?>
							
							</td>
							<td width="6%" class="tdLabel" id="boxSpace"><?php echo __("DOB")?>
							</td>
							<?php  //$optn1 = array('10'=>'10','20'=>'20','30'=>'30','40'=>'40','50'=>'50','60'=>'60','70'=>'70','80'=>'80','90'=>'90');?>
							<td class="tdLabel" id="boxSpace" width="12%"><strong> <?php echo $this->Form->input('age1',array('label'=>false,'id' => 'age1','div'=>false))?></strong></td>
							<td width="3%" class="tdLabel" id="boxSpace"><?php echo __("To")?></td>
							<td class="tdLabel" id="boxSpace" width="12%"><?php echo $this->Form->input('age2', array('label'=>false,'id' => 'age2','style'=>'width:80px, float:right','div'=>false)); ?>
							</td>
						<!-- 	<td class="tdLabel" id="boxSpace" width="226px"><?php echo $this->Form->input('age_unit', array('label'=>false,'id' => 'age_unit','style'=>'width:80px, float:right','empty'=>__('Select'),'options'=>array('Days'=>'Days','Months'=>'Months','Years'=>'Years'))); ?>
							</td> -->
						</tr>
						</td>
						</tr>
					</table>
			
			
			<tr class="">
				<td class="table_cell" colspan="5" algin="right"><strong> <?php
				echo $this->Js->link('<input type="button" id ="sumbmitDemographic" value="Submit" class="blueBtn" style="float:right">',
				array('controller'=>'reports', 'action'=>'demographic', 'admin' => false),
				array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn',array('buffer' => false)),'update'=>'#demo', 'data' => '{P_comm:$("#P_comm").val(),language:$("#language1").val(),race:$("#race").val(),
				age1:$("#age1").val(),age2:$("#age2").val(),
				enthnicity:$("#enthnicity").val(), start_date:$("#start_date").val(), end_date:$("#end_date").val(), first_name:$("#first_name").val(), last_name:$("#last_name").val(), age_unit:$("#age_unit").val()}','success' => $this->Js->get('#busy-indicator')->effect('fadeOut',array('buffer' => false)),'dataExpression' => true,'htmlAttributes' => array('escape' => false) ));echo $this->Js->writeBuffer();
				?>
				</strong>
				</td>
			</tr>

		</table>
		<div id="demo"></div>

	</div>
	<div id="Problem"  style="display: none">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			align="center">
			<tr class="row_title">
				<td class="table_cell" algin="right" colspan="6" style="line-height:33px; padding:0 0 0 17px;"><strong><?php echo __("Problem");?></strong>
				</td>
			</tr>
			<tr>
				<td id="boxSpace" class="tdLabel" width="24%"><?php echo $this->Form->input('Search Problem',array("type"=>"text","value"=>"","id"=>"prob",'class'=>'probCls','div'=>false,'style'=>"width:200px;"));?></td>
				<td width="6%" class="tdLabel" id="boxSpace"><?php echo __("DOB")?>
				</td>
				<?php  //$optn1 = array('10'=>'10','20'=>'20','30'=>'30','40'=>'40','50'=>'50','60'=>'60','70'=>'70','80'=>'80','90'=>'90');?>
				<td class="tdLabel" id="boxSpace" width="12%"><strong><?php echo $this->Form->input('age1',array('label'=>false,'id' => 'prob_age1','style'=>'width:111px;float:left;'))?></strong></td>
				<td width="3%" class="tdLabel" id="boxSpace"><?php echo __("To")?></td>
				<td class="tdLabel" id="boxSpace" width="12%"><?php echo $this->Form->input('age2', array('label'=>false,'id' => 'prob_age2','style'=>'width:100px;float:left;')); ?>
				</td>
				<td id="boxSpace" class="tdLabel"><?php echo $this->Form->input('Gender',array("value"=>"","id"=>"prob_sex",'empty'=>__('Please Select'),'options'=>array('Male'=>'Male','Female'=>'Female')));?>
				</td> 
				<!-- <td id="boxSpace" class="tdLabel"><?php echo $this->Form->input('Search Medication',array("type"=>"text","value"=>"","id"=>"prob1"));?></td> -->
				</tr>
              	<tr>
				<td colspan="6"><?php echo $this->Js->link('<input type="button" value="Submit" class="blueBtn" style="float:right">', array('controller'=>'reports', 'action'=>'problem', 'admin' => false), array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn',array('buffer' => false)),'update'=>'#demo_prob', 'data' => '{problem:$("#prob").val(),age1:$("#prob_age1").val(),age2:$("#prob_age2").val(),problem_Sex:$("#prob_sex").val(), start_date:$("#start_date").val(), end_date:$("#end_date").val(), first_name:$("#first_name").val(), last_name:$("#last_name").val()}','success' => $this->Js->get('#busy-indicator')->effect('fadeOut',array('buffer' => false)),'dataExpression' => true,'htmlAttributes' => array('escape' => false) ));echo $this->Js->writeBuffer();?>
				</td>
				</tr>
		</table>
		<div id="demo_prob"></div>
          
				
	</div>
	<div id="Medication" style="display: none">
		<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
			<tr class="row_title">
			<td class="table_cell" colspan="7" style="line-height:33px; padding:0 0 0 17px;"><strong><?php echo __("Medication");?> </strong></td>
            </tr>						
			<tr class="">
				<td id="boxSpace" class="tdLabel"  ><?php echo $this->Form->input('Search Medication',array("type"=>"text","value"=>"","id"=>"medication",'label','style'=>'width:250px;'));?>
				</td>
				<td id="boxSpace" class="tdLabel"  ><?php echo $this->Form->input('Drug Type',array('empty'=>__('Please Select'),'options'=>array('2'=>'Brand','1'=>'Generic'),"value"=>"","id"=>"drug_type"));?>
				</td>
				<td  class="tdLabel" id="boxSpace"><?php echo __("DOB")?>
				</td>
				<?php  //$optn1 = array('10'=>'10','20'=>'20','30'=>'30','40'=>'40','50'=>'50','60'=>'60','70'=>'70','80'=>'80','90'=>'90');?>
				<td class="tdLabel" id="boxSpace" ><strong> <?php echo $this->Form->input('age1',array('label'=>false,'id' => 'medication_age1','style'=>'width:111px;float:left;'))?></strong></td>
				<td  class="tdLabel" id="boxSpace"><?php echo __("To")?></td>
				<td class="tdLabel" id="boxSpace" ><?php echo $this->Form->input('age2', array('label'=>false,'id' => 'medication_age2','style'=>'width:100px;float:left;')); ?>
				</td>
				<td id="boxSpace" class="tdLabel" ><?php echo $this->Form->input('Gender',array("value"=>"","id"=>"medication_sex",'empty'=>__('Please Select'),'options'=>array('Male'=>'Male','Female'=>'Female')));?>
				</td> 
				<!-- <td id="boxSpace" class="tdLabel"><?php echo $this->Form->input('Search Allergies',array("type"=>"text","value"=>"","id"=>"medication_allergies"));?>
				</td> -->
			</tr> 
			<tr>
			<td colspan="7"><?php echo $this->Js->link('<input type="button" value="Submit" class="blueBtn" style="float:right">', array('controller'=>'reports', 'action'=>'medication', 'admin' => false), array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn',array('buffer' => false)),'update'=>'#demo_medication', 'data' => '{medication:$("#medication").val(),drug_type:$("#drug_type").val(),age1:$("#medication_age1").val(),age2:$("#medication_age2").val(),medication_Sex:$("#medication_sex").val(), first_name:$("#first_name").val(), last_name:$("#last_name").val()}','success' => $this->Js->get('#busy-indicator')->effect('fadeOut',array('buffer' => false)),'dataExpression' => true,'htmlAttributes' => array('escape' => false) ));echo $this->Js->writeBuffer(); ?>
			</td>
			</tr>         
		</table>
		<div id="demo_medication"></div>
         
	</div><!-- ,allergies:$("#medication_allergies").val() -->
	<div id="Allergies" style="display: none">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"
			align="center">
			<tr class="row_title">
              <td class="table_cell" colspan="3" style="line-height:33px; padding:0 0 0 17px;"><strong><?php echo __("Allergies");?> </strong>
             </td>
			</tr>						
			<tr class="">
				<td id="boxSpace" class="tdLabel" width="30%"><?php echo $this->Form->input('Search Allergies',array("type"=>"text","value"=>"","id"=>"allergies",'style'=>'width:250px;'));?>
				</td>
				<td id="boxSpace" class="tdLabel" width="30%"><?php echo $this->Form->input('Search Reactions',array("type"=>"text","value"=>"","id"=>"reaction",'style'=>'width:250px;'));?>
				</td>
				<td id="boxSpace" class="tdLabel"><?php echo $this->Form->input('Search Problem',array("type"=>"text","value"=>"","id"=>"allergies_problem",'style'=>'width:250px;'));?>
				</td>				
			</tr>
			<tr>
			<td colspan="6"><?php echo $this->Js->link('<input type="button" value="Submit" class="blueBtn" style="float:right">', array('controller'=>'reports', 'action'=>'Allergies', 'admin' => false), array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn',array('buffer' => false)),'update'=>'#demo_Allergies', 'data' => '{allergies:$("#allergies").val(),allergies_reaction:$("#reaction").val(),allergies_problem:$("#allergies_problem").val(), start_date:$("#start_date").val(), end_date:$("#end_date").val(), first_name:$("#first_name").val(), last_name:$("#last_name").val()}','success' => $this->Js->get('#busy-indicator')->effect('fadeOut',array('buffer' => false)),'dataExpression' => true,'htmlAttributes' => array('escape' => false) ));echo $this->Js->writeBuffer();?>
		</td>
		</tr>
		</table>
		<div id="demo_Allergies"></div>        
	</div>
	<!-- <div id="Lab" style="display: none">
		<table width="100%" cellpadding="0" cellspacing="0" border="0"	align="center">
			<tr class="row_title">
		     <td class="table_cell" colspan="5" style="line-height:33px; padding:0 0 0 17px;"><strong><?php echo __("Lab Observation")?></strong>
			  </td>
               </tr>
			<tr class="">
				<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Search Lab',array("type"=>"text","value"=>"","id"=>"lab"));?>
				</td>
				<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Search Problem',array("type"=>"text","value"=>"","id"=>"lab_problem"));?>
				</td>
				<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Search Lab Result',array("type"=>"text","value"=>"","id"=>"lab_result"));?>
				</td>
				<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Range', array('empty'=>__('Select'),'options'=>array('1'=>'Greater Than','2'=>'Less Than','3'=>'Equal'),'id' =>'range','style'=>'width:150px'));  ?>
				</td>
				<td class="tdLabel" id="boxSpace"><?php echo $this->Form->input('Result', array("type"=>"text","value"=>"","id"=>"result"));  ?>
				</td>				
			</tr>
			<tr>
			<td colspan="6"> <?php	echo $this->Js->link('<input type="button" value="Submit" class="blueBtn" style="float:right;margin-top:10px;">', array('controller'=>'reports', 'action'=>'lab', 'admin' => false), array('update'=>'#demo_lab', 'data' => '{lab:$("#lab").val(),problem:$("#lab_problem").val(),result:$("#lab_result").val(),result_value:$("#result").val(),range:$("#range").val(),start_date:$("#start_date").val(),end_date:$("#end_date").val(),first_name:$("#first_name").val(),last_name:$("#last_name").val()}','dataExpression' => true,'htmlAttributes' => array('escape' => false) ));echo $this->Js->writeBuffer();	?>
			</td>
			</tr>
		</table>
		<div id="demo_lab"></div>
       
	</div> -->
	<script>
	/* $(document).ready(function() {
			$('.tooltip').tooltipster({
		 		interactive:true,
		 		position:"right",
		 	});
	 });*/
	 $(document).ready(function() {
		 var flag="<?php echo $getFlag;?>";
		 if(flag=='communication'){
			 $('#Communication').show();
				$('#Demographics').hide();
				$('#Problem').hide();
				$('#Medication').hide();
				$('#Allergies').hide();
				$('#Lab').hide();
		 }else  if(flag=='demographics'){
			 $('#Demographics').show();
				$('#Problem').hide();
				$('#Medication').hide();
				$('#Allergies').hide();
				$('#Lab').hide();
				$('#Communication').hide();
		 } else  if(flag=='problem'){
			 $('#Communication').hide();
				$('#Demographics').hide();
				$('#Problem').show();
				$('#Medication').hide();
				$('#Allergies').hide();
				$('#Lab').hide();
		 } else  if(flag=='medication'){
			 $('#Demographics').hide();
				$('#Problem').hide();
				$('#Medication').show();
				$('#Allergies').hide();
				$('#Lab').hide();
		 } else  if(flag=='allergy'){
			 $('#Demographics').hide();
				$('#Problem').hide();
				$('#Medication').hide();
				$('#Allergies').show();
				$('#Lab').hide();
				$('#Communication').hide();
		 } else  if(flag=='lab'){
			 $('#Demographics').hide();
				$('#Problem').hide();
				$('#Medication').hide();
				$('#Allergies').hide();
				$('#Lab').show();
				$('#Communication').hide();
		 }
	 });

function showPC(){
		$('#Communication').show();
		$('#Demographics').hide();
		$('#Problem').hide();
		$('#Medication').hide();
		$('#Allergies').hide();
		$('#Lab').hide();
	}
function showDemographics(){
	
	$('#Demographics').show();
	$('#Problem').hide();
	$('#Medication').hide();
	$('#Allergies').hide();
	$('#Lab').hide();
	$('#Communication').hide();
}
function showProblem(){
	$('#Communication').hide();
	$('#Demographics').hide();
	$('#Problem').show();
	$('#Medication').hide();
	$('#Allergies').hide();
	$('#Lab').hide();
}
 function showMedication(){
	$('#Communication').hide();
	$('#Demographics').hide();
	$('#Problem').hide();
	$('#Medication').show();
	$('#Allergies').hide();
	$('#Lab').hide();
}
function showAllergies(){	
	$('#Demographics').hide();
	$('#Problem').hide();
	$('#Medication').hide();
	$('#Allergies').show();
	$('#Lab').hide();
	$('#Communication').hide();
}
function showLab(){
	$('#Demographics').hide();
	$('#Problem').hide();
	$('#Medication').hide();
	$('#Allergies').hide();
	$('#Lab').show();
	$('#Communication').hide();
} 
function icdwin(){
	$
			.fancybox({

				'width' : '70%',
				'height' : '120%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "snowmed","admin"=>false)); ?>" 
						
			});

}
</script>
	<script>
/*	$('#sumbmitDemographic').click(function(){
if(($('#age2').val()!='' && $('#age1').val()=='')){
alert('Please enter the lower limt of age.');	
return false;
}
else if(($('#age1').val()!='')){
	if($('#age1').val()>$('#age2').val()){
		alert('Lower limit cannot be greater then upper limt.');
		return false;
	}
}
else{
	
}
		});*/
	//------------------------------------------------------------demographic--------------------------------------------------------------------------
	var demographicURL = "<?php echo $this->Html->url(array("controller" => "reports", "action" => "demographic","admin" => false)); ?>";
	function call_demographic(){
	$.ajax({
		type: 'POST',
		url: demographicURL,
		data: 'language='+$('#language').val() + '&race=' + $('#race').val() + '&enthnicity=' + $('#enthnicity').val(),
		dataType: 'html',
		success: function(data){
			
		data=JSON && JSON.parse(data) || $.parseJSON(data);
		//var parsedJSON = eval('('+data+')');
		

		$.each(data, function(index, name) {
			//name=JSON && JSON.parse(name) || $.parseJSON(name);
			//alert(name['Person']['last_name'] + '--' + name['Person']['first_name']);
			 $('#demo').append(
	                    $('<tr>')
	                        .append($('<td>').append(name['Person']['first_name']))
	                        .append($('<td>').append(name['Person']['last_name']))
	                        
	                );
		  });
		},
		error: function(message){
		alert(message);
		} 
	});
	}
	//------------------------------------------------------------problem--------------------------------------------------------------------------
	var problemURL = "<?php echo $this->Html->url(array("controller" => "reports", "action" => "problem","admin" => false)); ?>";
	function call_problem(){//alert($('#prob').val());
	$.ajax({
		type: 'POST',
		url: problemURL,
		data: 'problem='+$('#prob').val(),
		dataType: 'html',
		success: function(data){
			
		data=JSON && JSON.parse(data) || $.parseJSON(data);
		//var parsedJSON = eval('('+data+')');
		
		
		$.each(data, function(index, name) {//alert(name['Patient']['lookup_name']);
			//name=JSON && JSON.parse(name) || $.parseJSON(name);
			//alert(name['Person']['last_name'] + '--' + name['Person']['first_name']);
			 $('#demo_prob').append(
	                    $('<tr>')
	                        .append($('<td>').append(name['Patient']['lookup_name']))
	                        
	                        
	                );
		  });
		},
		error: function(message){
		alert(message);
		} 
	});
	}
	//------------------------------------------------------------lab--------------------------------------------------------------------------
	var LabURL = "<?php echo $this->Html->url(array("controller" => "reports", "action" => "lab","admin" => false)); ?>";
	function call_lab(){alert($('#lab').val());
	$.ajax({ 
		type: 'POST',
		url: LabURL,
		data: 'lab='+$('#lab').val(),
		dataType: 'html',
		success: function(data){
			
			 data=JSON && JSON.parse(data) || $.parseJSON(data);

		$.each(data, function(index, name) {alert(name['Patient']['lookup_name']);
			$('#demo_lab').append(
	                    $('<tr>')
	                        .append($('<td>').append(name['Patient']['lookup_name'])) 
	                );
		  });
		},
		error: function(message){
		alert(message);
		} 
	});
	}
	//------------------------------------------------------------medication--------------------------------------------------------------------------
	var medicationURL = "<?php echo $this->Html->url(array("controller" => "reports", "action" => "medication","admin" => false)); ?>";
	function call_medication(){alert($('#medication').val());
	$.ajax({ 
		type: 'POST',
		url: LabURL,
		data: 'medication='+$('#medication').val(),
		dataType: 'html',
		success: function(data){
			alert(data);
			 data=JSON && JSON.parse(data) || $.parseJSON(data);

		$.each(data, function(index, name) {alert(name['Patient']['lookup_name']);
			$('#demo_medication').append(
	                    $('<tr>')
	                        .append($('<td>').append(name['Patient']['lookup_name'])) 
	                );
		  });
		},
		error: function(message){
		alert(message);
		} 
	});
	}
	//----------------------------------------------------------Allergies-------------------------------------------------------------------------
	var AllergiesURL = "<?php echo $this->Html->url(array("controller" => "reports", "action" => "Allergies","admin" => false)); ?>";
	function call_Allergies(){alert($('#allergies').val());
	$.ajax({ 
		type: 'POST',
		url: AllergiesURL,
		data: 'allergies='+$('#allergies').val(),
		dataType: 'html',
		success: function(data){
			
			 data=JSON && JSON.parse(data) || $.parseJSON(data);

		$.each(data, function(index, name) {//alert(name['Patient']['lookup_name']);
			$('#demo_Allergies').append(
	                    $('<tr>')
	                        .append($('<td>').append(name['Patient']['lookup_name'])) 
	                );
		  });
		},
		error: function(message){
		alert(message);
		} 
	});
	}
	$("#age1,#prob_age1,#medication_age1")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				yearRange : '-50:+50',
				//maxDate : new Date(),
				dateFormat: '<?php echo $this->General->GeneralDate();?>',
		onSelect : function() {
			$(this).focus();
			//foramtEnddate(); //is not defined hence commented
		}
			});
	$("#age2,#prob_age2,#medication_age2")
	.datepicker(
			{
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				yearRange : '-50:+50',
				//maxDate : new Date(),
				dateFormat: '<?php echo $this->General->GeneralDate();?>',
		onSelect : function() {
			$(this).focus();
			//foramtEnddate(); //is not defined hence commented
		}
			});//prob prob1

			$(document).ready(function(){			
				$('.probCls').autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","NoteDiagnosis","diagnoses_name",'null',"no","no","diagnoses_name <>".'',"diagnoses_name","admin" => false,"plugin"=>false)); ?>",
					 minLength: 1,				
					 messages: {noResults: '',results: function() {}
					 }
				});
				$('#medication').autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","NewCropPrescription","description",'null',"no","no","description <>".'',"description","admin" => false,"plugin"=>false)); ?>",
					 minLength: 1,				
					 messages: {noResults: '',results: function() {}
					 }
				});
				$('#allergies').autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","NewCropAllergies","name",'null',"no","no","name <>".'',"name","admin" => false,"plugin"=>false)); ?>",
					 minLength: 1,				
					 messages: {noResults: '',results: function() {}
					 }
				});
				$('#allergies_problem').autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","NoteDiagnosis","diagnoses_name",'null',"no","no","diagnoses_name <>".'',"diagnoses_name","admin" => false,"plugin"=>false)); ?>",
					 minLength: 1,				
					 messages: {noResults: '',results: function() {}
					 }
				});
				$('#lab').autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Laboratory","name",'null',"no","no","name <>".'',"name","admin" => false,"plugin"=>false)); ?>",
					 minLength: 1,				
					 messages: {noResults: '',results: function() {}
					 }
				});			
				$('#lab_problem').autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","NoteDiagnosis","diagnoses_name",'null',"no","no","diagnoses_name <>".'',"diagnoses_name","admin" => false,"plugin"=>false)); ?>",
					 minLength: 1,				
					 messages: {noResults: '',results: function() {}
					 }
				});
				$('#first_name').autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Person","first_name",'null',"no","no","first_name <>".'',"first_name","admin" => false,"plugin"=>false)); ?>",
					 minLength: 1,				
					 messages: {noResults: '',results: function() {}
					 }
				});
				$('#last_name').autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Person","last_name",'null',"no","no","last_name <>".'',"last_name","admin" => false,"plugin"=>false)); ?>",
					 minLength: 1,				
					 messages: {noResults: '',results: function() {}
					 }
				});
				/*	$('#lab_result').autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","LaboratoryHl7Result","result",'null',"no","no","result <>".'',"result","admin" => false,"plugin"=>false)); ?>",
					 minLength: 1,				
					 messages: {noResults: '',results: function() {}
					 }
				});
				$('#result').autocomplete({
					source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Laboratory","name",'null',"no","no","name <>".'',"name","admin" => false,"plugin"=>false)); ?>",
					 minLength: 1,				
					 messages: {noResults: '',results: function() {}
					 }
				});*/
			/*	 $("#age1").datepicker({
						showOn : "both",
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						changeMonth : true,
						changeYear : true,
						yearRange : '-50:+50',
						dateFormat:'<?php echo $this->General->GeneralDate();?>',
						onSelect : function() {
							var selDate = $("#age1").val();
							$('#age2').datepicker('option', {
					 			minDate: new Date(selDate)
						    });
						}
					});
					$("#age2").datepicker({
						showOn : "both",
						buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
						buttonImageOnly : true,
						changeMonth : true,
						changeYear : true,
						yearRange : '-50:+50',
						dateFormat:'<?php echo $this->General->GeneralDate();?>',
						onSelect : function() {
					 		var selDate = $("#age1").val();
					 		if(selDate == '') $(this).val('');
						}
					});*/
			});
	</script>