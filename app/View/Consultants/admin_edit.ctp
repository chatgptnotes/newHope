<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#consultantsfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
<h3><?php echo __('Edit Referral Doctor', true); ?></h3>
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
<form name="consultantsfrm" id="consultantsfrm" action="<?php echo $this->Html->url(array("controller" => "consultants", "action" => "edit", 'admin'=> true)); ?>" method="post" >
        <?php 
             echo $this->Form->input('Consultant.id', array('type' => 'hidden')); 
        ?>
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
        <?php 
          echo $this->Form->input('Consultant.corporate_sublocation_id', array('class' => 'sublocations', 'options' => $sponsor, 'empty' => 'Select Sponsor', 'id' => 'sublocations', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
		  <tr class="hiderows">
	<td class="form_lables" align="right">
	<?php echo __('Marketing Team',true); ?><font color="red">*</font>
	</td>
	<td>
         <?php 
          echo $this->Form->input('Consultant.market_team', array('class' => 'validate[required,custom[mandatory-select]]', 'options' => $marketing_teams, 'empty' => 'Select Market Team', 'id' => 'customrefering', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
	<tr class="hiderows">
	<td class="form_lables" align="right">
	<?php echo __('Referal Spot amount',true); ?> <font color="red">*</font>
	</td>
	<td>
         <?php 
          echo $this->Form->input('Consultant.referal_spot_amount', array('type'=>'text','class' => 'validate[required,custom[onlyNumber]]' , 'id' => 'customrefering', 'label'=> false, 'div' => false, 'error' => false));
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
	        <?php $date = $this->DateFormat->formatDate2Local($this->request->data['Consultant']['camp_date'],Configure::read('date_format'),false);
	     	   echo $this->Form->input('Consultant.camp_date', array('style'=>'float:left','class' => 'validate[required,custom[mandatory-select]]','type'=>'text','value'=>$date, 'id' => 'campdate', 'label'=> false,'autocomplete'=>'off', 'div' => false, 'error' => false));
	        ?>
		</td>
	</tr>
	<tr class="hiderows">
	<td class="form_lables" align="right">
	<?php echo __('Profit Sharing',true); ?>        
	</td>
	<td>
        <?php 
        echo $this->Form->input('Consultant.profit_percentage', array('type' => 'text', 'id' => 'profit_percentage', 'label'=> false, 'div' => false, 'error' => false));
        ?>%
	</td>
	</tr>
	 <tr class="hiderows">
	<td class="form_lables" align="right">
	<?php echo __('Account Group',true); ?>
	</td>
	<td>
        <?php 
        if(empty($this->data['Consultant']['accounting_group_id']) || $this->data['Consultant']['accounting_group_id']=='0'){
        	$Id = $groupId;
        }else{
        	$Id = $this->data['Consultant']['accounting_group_id'];
        }
        echo $this->Form->input('Consultant.accounting_group_id', array('type'=>'select','options'=>$group,'value'=>$Id,'id' => 'group_id','class'=>'' ,'label'=> false, 'div' => false, 'error' => false,'empty'=>'Please Select'));
        ?>
	</td>
	</tr>
	  <tr class="hiderows">
		<th align="left" colspan="2">Bank account details<?php echo $this->Form->hidden('HrDetail.id',array('id'=>'HrDetailId','value'=>$hrDetails['HrDetail']['id']));?></th>
	</tr>
	<tr class="hiderows">
		<td class="form_lables" align="right">Bank name</td>
		<td><?php echo $this->Form->input('HrDetail.bank_name', array('label'=>false,'div'=>false,'id' => 'bank_name','class'=> 'textBoxExpnd','value'=>$hrDetails['HrDetail']['bank_name'])); ?>
		</td>
	</tr>
	<tr class="hiderows">
		<td class="form_lables" align="right">Bank Branch</td>
		<td><?php echo $this->Form->input('HrDetail.branch_name', array('label'=>false,'id' => 'branch_name','class'=>'textBoxExpnd','value'=>$hrDetails['HrDetail']['branch_name'])); ?>
		</td>			
	</tr>
	<tr class="hiderows">
		<td class="form_lables" align="right">Account number</td>
		<td><?php echo $this->Form->input('HrDetail.account_no', array('type'=>'text','label'=>false,'id' => 'account_no','class'=>'textBoxExpnd validate["",custom[onlyNumber]]','value'=>$hrDetails['HrDetail']['account_no'])); ?></td>
	</tr>
	<tr class="hiderows">
		<td class="form_lables" align="right">IFSC Code</td>
		<td><?php echo $this->Form->input('HrDetail.ifsc_code', array('type'=>'text','label'=>false,'id' => 'ifsc_code','class'=>'textBoxExpnd','maxlength'=>'11','value'=>$hrDetails['HrDetail']['ifsc_code'])); ?></td>
	</tr>
	<tr class="hiderows">
		<td class="form_lables" align="right">Bank pass book copy obtained</td>
		<td>
		<?php echo $this->Form->checkbox('HrDetail.pass_book_copy', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'neft_authorized_received','checked'=>$hrDetails['HrDetail']['pass_book_copy'])); ?>
		</td>
	</tr>
  
	<tr class="hiderows">
		<td  class="form_lables" align="right">NEFT authorization received</td>
		<td>
		<?php echo $this->Form->checkbox('HrDetail.neft_authorized_received', array('style'=>'float:left','legend'=>false,'label'=>false,'class' => 'neft_authorized_received','checked'=>$hrDetails['HrDetail']['neft_authorized_received'])); ?>
		</td>
	</tr>  		
	<tr class="hiderows">
		<td class="form_lables" align="right">PAN</td>
		<td><?php 	echo $this->Form->input('HrDetail.pan', array( 'id' => 'pan','type'=>'text', 'selected'=>'84', 'label'=> false, 'div' => false, 'error' => false,'class' => 'textBoxExpnd','value'=>$hrDetails['HrDetail']['pan']));?>
		</td>
	</tr> 
	</table>
</td>

<td valign="top" width="50%">
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  align="center">
<tr>
	<td class="form_lables" align="right">
        <?php echo __('Address1',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('Consultant.address1', array('cols' => '35', 'rows' => '4', 'id' => 'customaddress1', 'label'=> false, 'div' => false, 'error' => false));
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
	<?php echo __('Country',true); ?>
	</td>
	<td>
       <?php 
	      echo $this->Form->input('Consultant.country_id', array('options' => $countries, 'empty' => 'Select Country', 'id' => 'customcountry', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'consultants','action' => 'get_state_city','reference'=>'State','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeStates', 'data' => '{reference_id:$("#customcountry").val()}', 'dataExpression' => true, 'div'=>false))));

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
		 
          echo $this->Form->input('Consultant.state_id', array('options' => $states, 'empty' => 'Select State', 'id' => 'customstate', 'label'=> false, 'div' => false, 'error' => false,'onchange'=> $this->Js->request(array('controller'=>'consultants','action' => 'get_state_city','reference'=>'City','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#changeCities', 'data' => '{reference_id:$("#customstate").val()}', 'dataExpression' => true, 'div'=>false))));
        ?>
	</td>
	</tr>
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('City',true); ?>
	</td>
	<td id="changeCities">
        <?php 
		  
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
        <tr >
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
        <tr >
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
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
</td>
</tr>
</table>

        
</form>
<script>
	if($('#customreferingdoc').val() == '7'){
		$('.typedate').show();
		$(".hiderows").hide();
		 // $("#customfirstname").removeClass("validate[required,custom[name],custom[onlyLetterSp]] customName");	 
		 // $("#customfirstname").addClass("validate[required,custom[mandatory-select]] customdate");
		 // $("#customfirstname").css('float','left');
		 // $("#customfirstname").attr('readOnly','readOnly');
		
		 }else{
		//   $("#customfirstname").datepicker("destroy");	 
		 //  $("#customfirstname").removeClass("validate[required,custom[mandatory-select]] customdate");
		 //  $("#customfirstname").addClass("validate[required,custom[name],custom[onlyLetterSp]] customName");	
		   $(".hiderows").show();
		   $('.typedate').hide(); 
		}

		 $("#campdate" ).datepicker({
				showOn: "both",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',			 
				dateFormat:'<?php echo $this->General->GeneralDate();?>'
			});
					
$('#submit').click(function(){ 
	if($("form").validationEngine('validate'))
		$('#submit').hide();
	
});       
$(document).ready(function(){
		//script to include datepicker
                var firstYr = new Date().getFullYear()-100;
		var lastYr = new Date().getFullYear()-20;
		$(function() {
			$( "#customdateofbirth" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
                        defaultDate: '-52y',
			yearRange: firstYr+':'+lastYr,
			dateFormat: '<?php echo $this->General->GeneralDate();?>',
                        defaultDate: new Date(firstYr)
			
		});		
		});
		
		 $('#customreferingdoc').change(function (){ 
             //alert($(this).val());
 			if($(this).val() == '7'){
 				$('.typedate').show();
 				$(".hiderows").hide();
 				  $("#customfirstname").removeClass("validate[required,custom[name],custom[onlyLetterSp]] customName");	 
 				  $("#customfirstname").addClass("validate[required,custom[mandatory-select]] customdate");
 				  $("#customfirstname").css('float','left');
 				  $("#customfirstname").attr('readOnly','readOnly');
 				  $("#customfirstname" ).datepicker({
 						showOn: "both",
 						buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
 						buttonImageOnly: true,
 						changeMonth: true,
 						changeYear: true,
 						yearRange: '1950',			 
 						dateFormat:'<?php echo $this->General->GeneralDate();?>'
 					});
					
 				 }else{
 				   $("#customfirstname").datepicker("destroy");	 
 				   $("#customfirstname").removeClass("validate[required,custom[mandatory-select]] customdate");
 				   $("#customfirstname").addClass("validate[required,custom[name],custom[onlyLetterSp]] customName");	
 				   $(".hiderows").show();
 				   $('.typedate').hide(); 
 				}
 			});
         $('#submit').click(function(){ 
 			if($("form").validationEngine('validate'))
 				$('#submit').hide();
 			
 		});

			
		$( "#customdate" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',			 
			dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>'
		});
		$('#submit').click(function(){ 
			if($("form").validationEngine('validate'))
				$('#submit').hide();
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