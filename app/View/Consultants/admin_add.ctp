<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#consultantsfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3><?php echo __('Add Referral Doctor', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Back', true),array("action" => "index", 'admin'=> true), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
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
<form name="consultantsfrm" id="consultantsfrm" action="<?php echo $this->Html->url(array("controller" => "consultants", "action" => "add", 'admin'=> true)); ?>" method="post" >
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  align="center">
<tr>
<td valign="top" width="50%">
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  align="center">
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Initial',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Consultant.initial_id', array('class' => 'validate[required,custom[custominitial]]', 'options' => $initials, 'empty' => 'Select Initial', 'id' => 'custominitial', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
    <tr>
	<td class="form_lables" align="right">
	<?php echo __('Type',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
          echo $this->Form->input('Consultant.refferer_doctor_id', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $referingdoctor, 'empty' => 'Select Type', 'id' =>'customreferingdoc', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr class="hiderows">
	<td class="form_lables" align="right">
	<?php echo __('Sponsors',true); ?>
	</td>
	<td>
        <?php echo $this->Form->input('Consultant.corporate_sublocation_id', array('class' => 'sublocations', 'options' => $sponsor, 'empty' => 'Select Sponsor', 'id' => 'sublocations', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr class="hiderows">
	<td class="form_lables" align="right">
	<?php echo __('Marketing Team',true); ?><font color="red">*</font>
	</td>
	<td>
         <?php 
          echo $this->Form->input('Consultant.market_team', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $marketing_teams, 'empty' => 'Select Market Team', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr class="hiderows">
	<td class="form_lables" align="right">
	<?php echo __('Referal Spot amount',true); ?> <font color="red">*</font>
	</td>
	<td>
         <?php 
          echo $this->Form->input('Consultant.referal_spot_amount', array('type'=>'text','class' => 'validate[required,custom[onlyNumber]]' , 'id' => 'customreferings', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr class="form_lables" >
		<td class="form_lables" align="right">
			<?php echo __('First Name',true); ?>
        	<font color="red">*</font>
		</td>
		<td class="form_lables">
	        <?php 
	     	   echo $this->Form->input('Consultant.first_name', array('class' => 'validate[required,custom[name],custom[onlyLetterSp]] customName', 'id' => 'customfirstname', 'label'=> false,'autocomplete'=>'off', 'div' => false, 'error' => false));
	        ?>
		</td>
	</tr>
    <tr class="hiderows">
		<td class="form_lables" align="right">
			<?php echo __('Middle Name',true); ?>
		</td>
		<td>
       		<?php  echo $this->Form->input('Consultant.middle_name', array('id' => 'custommiddlename', 'label'=> false, 'div' => false, 'error' => false));?>
		</td>
	</tr>
    <tr class="form_lables" >
		<td class="form_lables" align="right">
			<?php echo __('Last Name',true); ?>
        	<font color="red">*</font>
		</td>
		<td>
        	<?php echo $this->Form->input('Consultant.last_name', array('class' => 'validate[required,custom[name],custom[onlyLetterSp]]', 'id' => 'customlastname', 'label'=> false, 'div' => false,'autocomplete'=>'off','error' => false)); ?> 
		</td>
	</tr>
	<tr class="form_lables typedate" style='display:none'>
		<td  align="right" >
			<?php echo __('Camp Date ',true); ?><font color="red">*</font>
		</td>
		<td class = "form_lables">
	        <?php 
	     	   echo $this->Form->input('Consultant.camp_date', array('style'=>'float:left','class' => 'validate[required,custom[mandatory-select]]','type'=>'text', 'id' => 'campdate', 'label'=> false,'autocomplete'=>'off', 'div' => false, 'error' => false));
	        ?>
		</td>
	</tr>
	<tr class="hiderows">
	<td class="form_lables hiderows" align="right">
	<?php echo __('Profit Sharing',true); ?><font color="red">*</font>        
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.profit_percentage', array('type' => 'text', 'id' => 'profit_percentage', 'label'=> false, 'div' => false, 'error' => false));
        ?>%
	</td>

</tr>
    <tr class="hiderows" >
    	<td class="form_lables hiderows" align="right">
        	<?php echo __('Referral Type', true); ?><font color="red">*</font>
        </td>
        <td>
            <?php 
            echo $this->Form->input('Consultant.referral_type', array(
                'type' => 'select', 
                'options' => ['Doctor' => 'Doctor', 'Ambulance Driver' => 'Ambulance Driver', 'Other' => 'Other'], 
                'id' => 'referral_type', 
                'label'=> false, 
                'div' => false, 
                'error' => false
            ));
            ?>
        </td>
	</tr>
	  <tr class="hiderows" >
    <td class="form_lables hiderows" align="right">
	<?php echo __('Date of Birth', true); ?><font color="red">*</font>
</td>
<td>
    <?php 
    echo $this->Form->input('Consultant.dob', array('type' => 'date', 'id' => 'dob', 'label'=> false, 'div' => false, 'error' => false));
    ?>
</td>
	</tr>
	<tr class="hiderows" >
    
            <td class="form_lables hiderows" align="right">
            	<?php echo __('Education Degree', true); ?><font color="red">*</font>
            </td>
            <td>
                <?php 
                echo $this->Form->input('Consultant.education_degree', array(
                    'type' => 'select', 
                    'options' => ['SSC' => 'SSC', 'HSC' => 'HSC', 'Graduation' => 'Graduation', 'Post Graduation' => 'Post Graduation', 'Doctorate' => 'Doctorate'], 
                    'id' => 'education_degree', 
                    'label'=> false, 
                    'div' => false, 
                    'error' => false
                ));
                ?>
            </td>
	</tr>
	<tr class="hiderows" >
    
<td class="form_lables hiderows" align="right">
	<?php echo __('Specialization', true); ?><font color="red">*</font>
</td>
<td>
    <?php 
    echo $this->Form->input('Consultant.specialization', array('type' => 'text', 'id' => 'specialization', 'label'=> false, 'div' => false, 'error' => false));
    ?>
</td>

	</tr>
		<tr class="hiderows" >
    
<td class="form_lables hiderows" align="right">
	<?php echo __('Company Name', true); ?><font color="red">*</font>
</td>
<td>
    <?php 
    echo $this->Form->input('Consultant.company_name', array('type' => 'text', 'id' => 'company_name', 'label'=> false, 'div' => false, 'error' => false));
    ?>
</td>

	</tr>
	
	 <tr class="hiderows">
	<td class="form_lables hiderows" align="right">
	<?php echo __('Account Group',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.accounting_group_id', array('type'=>'select','options'=>$group,'id' => 'group_id','class'=>'','value'=>$groupId,'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select'));
        ?>
	</td>
	</tr>
     <tr class="form_lables hiderows">
		<th align="left" colspan="2">Bank account details</th>
	</tr>
	<tr class="hiderows">
		<td class="form_lables hiderows" align="right">Bank name</td>
		<td><?php echo $this->Form->input('HrDetail.bank_name', array('label'=>false,'div'=>false,'id' => 'bank_name','class'=> 'textBoxExpnd')); ?>
		</td>
	</tr>
	<tr class="hiderows">
		<td class="form_lables" align="right">Bank Branch</td>
		<td><?php echo $this->Form->input('HrDetail.branch_name', array('label'=>false,'id' => 'branch_name','class'=>'textBoxExpnd')); ?>
		</td>			
	</tr>
	<tr class="hiderows">
		<td class="form_lables" align="right">Account number</td>
		<td><?php echo $this->Form->input('HrDetail.account_no', array('type'=>'text','label'=>false,'id' => 'account_no','class'=>'textBoxExpnd validate["",custom[onlyNumber]]')); ?></td>
	</tr>
	<tr class="hiderows">
		<td class="form_lables" align="right">IFSC Code</td>
		<td><?php echo $this->Form->input('HrDetail.ifsc_code', array('type'=>'text','label'=>false,'id' => 'ifsc_code','class'=>'textBoxExpnd','maxlength'=>'11')); ?></td>
	</tr>
	<tr class="hiderows">
		<td class="form_lables" align="right">Bank pass book copy obtained</td>
		<td>
		<?php echo $this->Form->checkbox('HrDetail.pass_book_copy', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'neft_authorized_received')); ?>
		</td>
	</tr>
  
	<tr class="hiderows">
		<td  class="form_lables" align="right">NEFT authorization received</td>
		<td>
		<?php echo $this->Form->checkbox('HrDetail.neft_authorized_received', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'neft_authorized_received')); ?>
		</td>
	</tr>  		
	<tr class="hiderows">
		<td class="form_lables" align="right">PAN</td>
		<td><?php 	echo $this->Form->input('HrDetail.pan', array( 'id' => 'pan','type'=>'text', 'selected'=>'84', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd'));?>
		</td>
	</tr> 
</table>
</td>


<td valign="top" width="50%">
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  align="center">
  <tr>
	<td class="form_lables" align="right">
        <?php echo __('Address1',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('Consultant.address1', array('cols' => '35', 'rows' => '4','class' => 'validate[required,custom[mandatory-enter]]', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
<tr class="hiderows">
	<td class="form_lables" align="right">
	<?php echo __('Address2',true); ?>
	</td>
	<td>
         <?php 
        echo $this->Form->textarea('Consultant.address2', array('cols' => '35', 'rows' => '4', 'id' => 'customaddress2', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Country',true); ?><font color="red">*</font>
	</td>
	<td>
       <?php 
			 echo $this->Form->input('Consultant.country_id', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry', 'class' => 'validate[required,custom[mandatory-select]]','label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'consultants','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false))));

			//echo $this->Form->input('Consultant.country_id', array('class' => 'validate[required,custom[customcountry]]', 'options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('State',true); ?><font color="red">*</font>
	</td>
	<td id="changeStates">
        <?php 
		  $states = '';
          echo $this->Form->input('Consultant.state_id', array('options' => $states, 'empty' => 'Select State','class' => 'validate[required,custom[mandatory-select]]', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false));
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
        echo $this->Form->input('Consultant.zipcode', array('id' => 'customzipcode', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Email',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.email', array('id' => 'customemail', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
    <tr class="hiderows">
	<td class="form_lables" align="right">
	<?php echo __('Phone1',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.phone1', array('id' => 'customphone1', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr class="hiderows">
	<td class="form_lables" align="right">
	<?php echo __('Phone2',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.phone2', array('id' => 'customphone2', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
    <tr>
	<td class="form_lables" align="right">
	<?php echo __('Mobile',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.mobile', array('id' => 'custommobile','class'=>'validate[required,custom[phone,minSize[10],onlyNumber]]', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr class="hiderows">
	<td class="form_lables" align="right">
	<?php echo __('Fax',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.fax', array('id' => 'customfax', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
        <tr class="hiderows">
	<td colspan="2" align="center">
        &nbsp;
	</td>
	</tr>
	<tr>
	<td colspan="2" align="center">
        <?php echo $this->Html->link('Cancel',array("action" => "index", 'admin'=> true), array('class' => 'blueBtn','escape' => false)); ?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn" id="submit">
	</td>
	</tr>
	</table>
</td>
</tr>
</table>
	 
</form>
<script>
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
                    $('#customspecility_keyword').show();
                 } else {
                    $('#customspecility_keyword').hide();
                 }
               });
               var specility = $('#customspecility').val();
                 if(specility == 1) {
                    $('#customspecility_keyword').show();
                 } else {
                    $('#customspecility_keyword').hide();
                 }
                 // hide the pop up error message after selecting another fields/
               $("body").click(function(){
                            $("form").validationEngine('hide');
                           });              
               // end //
               $("#campdate" ).datepicker({
      						showOn: "both",
       						buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
       						buttonImageOnly: true,
       						changeMonth: true,
       						changeYear: true,
       						yearRange: '1950',			 
       						dateFormat:'<?php echo $this->General->GeneralDate();?>'
       					});
               $('#customreferingdoc').change(function (){ 
       			if($(this).val() == '7'){
       				$('.typedate').show();
       				$(".hiderows").hide();
       				//  $("#customfirstname").removeClass("validate[required,custom[name],custom[onlyLetterSp]] customName");	 
       				 // $("#customfirstname").addClass("validate[required,custom[mandatory-select]] customdate");
       				//  $("#customfirstname").css('float','left');
       				//  $("#customfirstname").attr('readOnly','readOnly');
     					
       				 }else{
       				 //  $("#customfirstname").datepicker("destroy");	 
       				 //  $("#customfirstname").removeClass("validate[required,custom[mandatory-select]] customdate");
       				 //  $("#customfirstname").addClass("validate[required,custom[name],custom[onlyLetterSp]] customName");	
       				  $(".hiderows").show();
       				   $('.typedate').hide(); 
       				}
       			});
               $('#submit').click(function(){ 
       			if($("form").validationEngine('validate'))
       				$('#submit').hide();
       			
       		});

   $("#submit").click(function(){
	   $('#custommobile').addClass('validate[required,custom[phone,minSize[10],onlyNumber]]');
	   var mob = $('#custommobile').val();
	   var moblenget = mob.length;
	   if(moblenget > 10){
		   $('#custommobile').addClass('validate[required,custom[phone,minSize[10],onlyNumber]]');
		   $('#custommobile').val(" ");
	   }
   });	
});
</script>