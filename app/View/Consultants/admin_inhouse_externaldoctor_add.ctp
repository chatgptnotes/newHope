<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#consultantsfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3><?php echo __('Add External Consultant', true); ?></h3>
</div>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
<form name="consultantsfrm" id="consultantsfrm" action="<?php echo $this->Html->url(array("controller" => "consultants", "action" => "inhouse_externaldoctor_add", 'admin'=> true)); ?>" method="post" >
      <?php  // this id is for external consultant //
             echo $this->Form->input('Consultant.refferer_doctor_id', array('type' => 'hidden', 'value' => 5)); 
        ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Initial',true); ?>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Consultant.initial_id', array(/*'class' => 'validate[required,custom[custominitial]]',*/ 'options' => $initials, 'empty' => 'Select Initial', 'id' => 'custominitial', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('First Name',true); ?>
        <font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.first_name', array('class' => 'validate[required,custom[customfirstname],custom[onlyLetterSp]]', 'id' => 'customfirstname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Middle Name',true); ?>
       
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.middle_name', array('class' => 'validate[custom[onlyLetterSp]]','id' => 'custommiddlename', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Last Name',true); ?>
        <font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.last_name', array('class' => 'validate[required,custom[customlastname],custom[onlyLetterSp]]', 'id' => 'customlastname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
        <?php echo __('Address1',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('Consultant.address1', array('cols' => '35', 'rows' => '10', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false/*,'class' => 'validate[required,custom[mandatory-enter]]'*/));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Address2',true); ?>
	</td>
	<td>
         <?php 
        echo $this->Form->textarea('Consultant.address2', array('cols' => '35', 'rows' => '10', 'id' => 'customaddress2', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Country',true); ?>
	</td>
	<td>
       <?php 
			 echo $this->Form->input('Consultant.country_id', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry'/*, 'class' => 'validate[required,custom[mandatory-select]]'*/,'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'consultants','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false))));

			//echo $this->Form->input('Consultant.country_id', array('class' => 'validate[required,custom[customcountry]]', 'options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('State',true); ?>
	</td>
	<td id="changeStates">
        <?php 
		  $states = '';
          echo $this->Form->input('Consultant.state_id', array('options' => $states, 'empty' => 'Select State'/*, 'class' => 'validate[required,custom[mandatory-select]]'*/,'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('City',true); ?>
	</td>
	<td id="changeCities">
        <?php 
		  $cities = '';
          echo $this->Form->input('Consultant.city_id', array('options' => $cities,'empty' => 'Select City', 'id' => 'customcity', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Zipcode',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.zipcode', array('class' => 'validate[optional,custom[onlyNumber]]','maxlength'=>'6','id' => 'customzipcode', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Email',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.email', array('class' => 'validate["",custom[email]]','id' => 'customemail', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Phone1',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.phone1', array('class' => 'validate[optional,custom[onlyNumber]]','maxlength'=>'15','id' => 'customphone1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Phone2',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.phone2', array('class' => 'validate[optional,custom[onlyNumber]]','maxlength'=>'15','id' => 'customphone2', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Mobile',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.mobile', array('class' => 'validate[required,custom[onlyNumber]]','maxlength'=>'10','id' => 'custommobile', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Fax',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.fax', array('id' => 'customfax','maxlength'=>'20', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Company Name',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.hospital_name', array(/*'class' => 'validate[required,custom[customhospitalname]]',*/ 'id' => 'customhospitalname', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<!-- <tr>
	<td class="form_lables" align="right">
	<?php //echo __('Availability',true); ?>
	</td>
	<td>
        <?php 
          //echo $this->Form->input('Consultant.availability', array('options' => array('1'=>'Yes', '0' => 'No'), 'id' => 'customavailability', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr> -->
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Education',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.education', array(/*'class' => 'validate[required,custom[customeducation]]',*/ 'id' => 'customeducation', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Has speciality',true); ?>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Consultant.haspecility', array('options' => array('1'=>'Yes', '0' => 'No'), 'id' => 'customspecility', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr id="customspecility_keywordshow">
	<td class="form_lables" align="right">
        <?php echo __('Description of specialty and training',true); ?>
	
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('Consultant.specility_keyword', array(/*'class' => 'validate[required,custom[customspecility_keyword]]',*/ 'cols' => '35', 'rows' => '10', 'id' => 'customspecility_keyword', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Experience',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.experience', array('id' => 'customexperience', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Date of Birth',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.dateofbirth', array('type' => 'text','readonly'=>'readonly', 'id' => 'customdateofbirth', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd'));
        ?>
	</td>
	 <tr>
		<td class="form_lables" align="right">
			<?php echo __('Account Group',true); ?>
		</td>
		<td>
	        <?php 
	        echo $this->Form->input('Consultant.accounting_group_id', array('type'=>'select','options'=>$group,'value'=>$groupId,'id' => 'group_id','class'=>'' ,'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select'));
	        ?>
		</td>
	</tr>
	<?php if($this->Session->read('website.instance')=='kanpur'){?>
	<!-- for accounting sharing doctor percentage by amit jain -->
	<tr>
		<td class="form_lables" align="right">
			<?php echo __('Doctor Commission',true); ?>
		</td>
		<td>
			<span style="float:left;"><?php echo __('External Charges (%) '); ?></span>
			<?php echo $this->Form->input('Service.external_charges', array('type' => 'text','class' => 'textBoxExpnd','label' => false,'legend' => false ,'id'=>'externalCharges','style'=>"width:50px;",'maxlength'=>'3'));?>
			<span style="float:left;"><?php echo __('Hospital Charges (%) '); ?></span>
			<?php echo $this->Form->input('Service.hospital_charges', array('type' => 'text','class' => 'textBoxExpnd','label' => false,'legend' => false ,'id'=>'hospitalCharges','style'=>"width:50px;",'maxlength'=>'3'));?>
			<span style="float:left;"><?php echo __('From:'); ?></span>
			<?php echo $this->Form->input('Service.from', array('class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd','style'=>'width:70px','id'=>'from','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'From','autocomplete'=>'off'));?>
		</td>	
	</tr>
<?php }?>
	</tr>
     <!--   <tr>
	<td class="form_lables" align="right">
	<?php echo __('Is Active',true); ?>
	</td>
	<td>
        <?php 
          //echo $this->Form->input('Consultant.is_active', array('options' => array('1'=>'Yes', '0' => 'No'), 'id' => 'customis_active', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr> -->
        <tr>
	<td colspan="2" align="center">
        &nbsp;
	</td>
	</tr>
	
	<tr>
	<td colspan="2" align="center">
        <?php echo $this->Html->link('Cancel',array("action" => "inhouse_externaldoctor", 'admin'=> true), array('class' => 'blueBtn','escape' => false)); ?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn" id="save">
	</td>
	</tr>
	</table>
</form>
<script>
$(document).ready(function(){

	$('#save').click(function() { 
				var externalCharges = $( "#externalCharges").val();
				externalCharges = externalCharges.trim();
				if(externalCharges == ''){
					$("#from").removeClass("validate[required,custom[mandatory-enter]]");
				}else{
					$("#from").addClass("validate[required,custom[mandatory-enter]]");
				}
			});

	jQuery("#consultantsfrm").validationEngine({
	validateNonVisibleFields: true,
	updatePromptsPosition:true,
	});
	
	});
$(document).ready(function(){
		//script to include datepicker
		$(function() {
			var firstYr = new Date().getFullYear()-100;
			var lastYr = new Date().getFullYear()-20;
			
			$( "#customdateofbirth" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true, 
				yearRange: firstYr+':'+lastYr,
				dateFormat: '<?php echo $this->General->GeneralDate();?>',
                                defaultDate: new Date(firstYr)
			
			});		
		});
               $('#customspecility').change(function() {
                 var specility = $('#customspecility').val();
                 if(specility == 1) {
                    $('#customspecility_keywordshow').show();
                 } else {
                    $('#customspecility_keywordshow').hide();
                 }
               });
               var specility = $('#customspecility').val();
                 if(specility == 1) {
                    $('#customspecility_keywordshow').show();
                 } else {
                    $('#customspecility_keywordshow').hide();
                 }
                 // hide the pop up error message after selecting another fields/
               $("body").click(function(){
                            $("form").validationEngine('hide');
                           });
               // end //
	});
	
	$("#externalCharges").keyup(function(){
		if($(this).val() > 100){
			alert("Percentage should be less than or equal to 100");
			$(this).val("");
			}
		
		var display = 100 - this.value;
		$("#hospitalCharges").val(display);
		
	});
	
	$("#hospitalCharges").keyup(function(){
		if($(this).val() > 100){
			alert("Percentage should be less than or equal to 100");
			$(this).val("");
			}
		
		var display = 100 - this.value;
		$("#externalCharges").val(display);
	});
	
	$("#from").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		minDate: new Date(),
	//	maxDate: new Date(),
		//maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',			
	});	
</script>