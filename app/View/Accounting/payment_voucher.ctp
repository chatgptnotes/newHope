<?php   
	echo $this->Html->script(array('jquery.fancybox-1.3.4'));
  	echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));  
  	
  	if($action=='print' && !empty($lastInsertID)){
  		echo "<script>var openWin = window.open('".$this->Html->url(array("controller" => "Accounting",'action'=>'printPaymentVoucher',$lastInsertID))."', '_blank',
                       'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
                  window.location='".$this->Html->url(array('action'=>'payment_voucher'))."'  </script>"  ;
  	}
?>
<style>
.cost{
	text-align: right;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Payment Voucher'); ?>
	</h3>
</div>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%" align="center">
	<tr>
		<td colspan="2" align="left">
			<div class="alert">
				<?php 
				foreach($errors as $errorsval){
			         echo $errorsval[0];
			         echo "<br />";
			     }
			     ?>
			</div>
		</td>
	</tr>
</table>
<?php }  
	echo $this->Form->create('accounting', array('url'=>array('controller'=>'Accounting','action'=>'payment_voucher'),'id'=>'Complaintfrm',
		'inputDefaults' => array('label' => false,'div' => false,'error'=>false,'legend'=>false,'O'))) ;
?>
<table width="100%" cellpadding="1" cellspacing="1" border="0">
	<tr>
	<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
	<td width="95%" valign="top">
<table width="100%" cellpadding="1" cellspacing="1" border="0">
	<tr>
		<td width="10%">
			<?php 
				 if ($dataDetail['VoucherPayment']['id']==null){
					echo __('Payment No. :'); echo $pv_no;
				 }else{
					echo __('Payment No. :'); echo $dataDetail['VoucherPayment']['id'];
				 }
				echo $this->Form->hidden('VoucherPayment.payment_voucher_no',array('type'=>'text','id'=>'payment_voucher_no','value'=>$pv_no));
				echo $this->Form->hidden('VoucherLog.id',array('value'=>$dataDetail['VoucherLog']['id']));
			?>
		</td>
		
		<td width="10%">
			<?php 
				echo __("Is External Payment");
				echo $this->Form->checkbox('VoucherPayment.isExternal',array('id'=>'isExternal','class'=>'isExternal','legend'=>false,
					"hiddenField"=>false,'label'=>false,'div'=>false));
			?>
		</td>
		
		<td width="10%">
			<?php echo __('Day :'); echo date('l', strtotime($date = date('Y-m-d')));?>
		</td>
		
		<td width="30%">
            <?php echo $this->Form->input('VoucherPayment.is_staff',array('type'=>'checkbox','name'=>'is_staff','div'=>false,'label'=>'Staff','hiddenField'=>false,'id'=>'is_staff')); ?>
        </td>
        
		<td width="2%"><?php echo __('Date :')?></td>
		
		<?php if(!empty($id)){?>
		<td width="5%">
			<?php echo $this->Form->input('VoucherPayment.date', array('label'=>false,'type'=>'text','value'=>$this->data['VoucherPayment']['date'],
				'id' => 'date' ,'class'=>'textBoxExpnd')); ?>
		</td>
		<?php }else {?>
		<td width="5%">
			<?php $date = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
			echo $this->Form->input('VoucherPayment.date', array('label'=>false,'type'=>'text','value'=>$date,'id' =>'date',
				'class'=>'textBoxExpnd')); ?>
		</td>
		<?php }?>
	</tr>
	
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="table">
	<tbody>
	<tr>
		<th width="60%" align="center" valign="top" style="text-align: left; padding: 5px 0 0 50px;"><strong><?php echo __('Particulars');?></strong></th>
		<th width="20%" align="center" valign="top" style="text-align: center;"><strong><?php echo __('Debit');?></strong></th>
		<th width="20%" align="center" valign="top" style="text-align: center;"><strong><?php echo __('Credit');?></strong></th>
	</tr>
	<?php echo $this->Form->hidden('field',array('id'=>'no_of_field','value'=>'1'));
	echo $this->Form->hidden('field',array('id'=>'no_of_field-1','value'=>'1'));?>
	<tr id="row1">
		<td colspan="3">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
			<tr>
				<td class="searchdiv" style="width:60%;"><?php echo __('Cr :')?><font color="red">*</font>
				<?php echo $this->Form->input('VoucherPayment.account_name',array('class'=>'validate[required,custom[mandatory-enter]]',
						'id'=>'account_name','placeholder'=>'Party to be credited','value'=>$this->data['AccountAlias']['name'])); 
					 echo $this->Form->hidden('VoucherPayment.id',array('type'=>'text'));
					 echo $this->Form->hidden('VoucherPayment.account_id', array('type'=>'text','id'=>'account_id'));
					 ?>
				</td>
				<td style="text-align: right; width:20%;">
					<?php echo " "; ?>
				</td>
				<td style="text-align: right; width:20%;">
					<?php echo $this->Form->input('VoucherPayment.user.1.credit_amount',array('class'=>'validate[required,custom[onlyNumber]] inputBox cost',
					'id' =>'credit_amount','type'=>'text','placeholder'=>'Credit Amount','value'=>$this->data["VoucherPayment"]["paid_amount"],'autocomplete'=>'off')); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" style="text-align: left; padding-left:60px;padding-top:5px; font-style:italic;">
					<?php echo __('Current Balance :');
					if(!$this->data['AccountAlias']['balance']){?>
					<b><span id="account_current_balance" ></span></b>
					<?php }else{?>
					<b><span id="account_current_balance" ><?php echo $this->data['AccountAlias']['balance'];?></span></b>
					<?php }?>
				</td>
				<td rowspan="1" colspan="2"></td>
			</tr>
			<tr>
				<td style="width:60%;" id="usernameLabel"><?php echo __('Dr :')?><font color="red">*</font>
				<?php 
					echo $this->Form->input('VoucherPayment.user.1.username', array('class'=>'validate[required,custom[mandatory-enter]] username',
					'id'=>'username_1','label'=>false,'div'=>false,'error'=>false,'autocomplete'=>false,'placeholder'=>'Party to be debited','value'=>$this->data['Account']['name'])); 
					echo $this->Form->hidden('VoucherPayment.user.1.user_id', array('type'=>'text','id'=>'userHidden_1','value'=>$this->data['VoucherPayment']['user_id']))."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					?>

				
				
				</td>
				<td style="width:60%; display: none;" id="staffnameLabel"><?php echo __('Dr :')?><font color="red">*</font>
				<?php 
					echo $this->Form->input('VoucherPayment.user.1.staffusername', array('class'=>'validate[required,custom[mandatory-enter]] staffname',
					'id'=>'username_1','label'=>false,'div'=>false,'error'=>false,'autocomplete'=>false,'placeholder'=>'Party to be debited','value'=>$this->data['Account']['name'])); 
					echo $this->Form->hidden('VoucherPayment.user.1.staff_user_id', array('type'=>'text','id'=>'staffHidden_1','value'=>$this->data['VoucherPayment']['user_id']));
				?>
				</td>
				<td style="text-align: right; width:20%;">
					<?php echo $this->Form->input('VoucherPayment.user.1.paid_amount',array('class'=>'validate[required,custom[onlyNumber]] paid_amount inputBox cost',
					'id' =>'paid_amount','type'=>'text','placeholder'=>'Debit Amount','value'=>$this->data["VoucherPayment"]["paid_amount"],'autocomplete'=>'off'));
					echo $this->Form->hidden('VoucherPayment.user.1.previous_paid_amount', array('type'=>'text','id' =>'previousPaidAmount','value'=>$this->data['VoucherPayment']['paid_amount']));?>
				</td>
				<td style="text-align: center; width:20%;">
					<?php echo " "; ?>
				</td>
			</tr>
			<tr>
				<td valign="top" style="text-align: left; padding-left:60px;padding-top:5px; font-style:italic;">
				<?php echo __('Current Balance :')?>
				<?php if(!$this->data['Account']['balance']){?>
					<b><span id="user_current_balance-1" ></span></b>
					<?php }else{?>
					<b><span id="user_current_balance-1" ><?php echo $this->data['Account']['balance'];?></span></b>
				<?php }?>
				</td>
				<td rowspan="1" colspan="2"></td>
			</tr>
			</table>
		</td>
	</tr>
</tbody>
</table>

<table>
<tr>
	<td id="userAddMore">
		<?php echo $this->Html->link(__('Add More'), 'javascript:void(0);', array('title'=>'Add','class'=>'blueBtn addParticular','onclick'=>'AddParticular()','id'=>'addParticular'));?>
	</td>
	<td id="staffAddMore" style="display: none;">
		<?php echo $this->Html->link(__('Add More'), 'javascript:void(0);', array('title'=>'Add','class'=>'blueBtn addParticularStaff','onclick'=>'AddParticularStaff()','id'=>'addParticularStaff'));?>
	</td>
</tr>
</table>
<table width="100%" class="tabularForm" cellpadding="0" cellspacing="1" border="0">
	<tr>
		<td valign="middle" style="width:60%;"><?php echo __('Narration :');?> 
		 	<?php echo $this->Form->input('VoucherPayment.narration', array('class' => 'inputBox','id' => 'narration','type'=>'textarea'));?>
		 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<?php echo __('Name Of Patient :');?>
				<?php echo $this->Form->input('VoucherPayment.patientname', array('id' => 'patientname','type'=>'text','placeholder'=>'Search Patient')); ?>
		</td>
		<td style="width:20%; padding-left: 40px;" id="debit_total"><?php echo __("Debit Total:");?><?php echo $this->data['JournalEntry']['debit'];?></td>
		<td style="width:20%; padding-left: 40px;" id="credit_total"><?php echo __("Credit Total:");?><?php echo $this->data['JournalEntry']['credit'];?></td>
	</tr>
	<tr>
		<td colspan="3" align="center" style="padding: 20px 0 20px 0">
		<?php if(!empty($id)){
			echo $this->Html->link('Print','javascript:void(0)',
	   		array('escape' => false,'class'=>'blueBtn printButton','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printPaymentVoucher',
     		$id))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
		}?>	
		
		<?php echo $this->Form->submit('Save',array('class'=>'blueBtn','title'=>'Save','style'=>'text-align:right;','id'=>'save','div'=>false,'name'=>'print')) ; ?>
		<a class="blueBtn" href="javascript:history.back();">Cancel</a>
		</td>
	</tr>
</table>
</td>
</tr>
</table>
<?php  echo $this->Form->end(); ?>
<script>
// for account
$(document).ready(function(){


	$("#patientname").autocomplete({
	    source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","no","admin" => false,"plugin"=>false)); ?>",
		select: function(event,ui){

			// Get the current value of the textarea
		    var currentValue = $("#narration").val();
		    
		    // The text you want to append
		    var textToAppend = " For Patient "+ui.item.value;

		    // Concatenate the new text with the current value
		    var updatedValue = currentValue + textToAppend;
		    
		    // Set the updated value back to the textarea
		    $("#narration").val(updatedValue);
		},
		 messages: {
	        noResults: '',
	        results: function() {},
	 	}
	});
	
$("#date").datepicker({
		showOn : "both",
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		changeMonth : true,
		changeYear : true,
		yearRange: '-100:' + new Date().getFullYear(),
		dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
		onSelect : function() {
			$(this).focus();
		}
});
	
$("#account_name").autocomplete({
	 source: "<?php echo $this->Html->url(array("controller"=>"accounting","action"=>"advance_autocomplete","Account","name",'null',"null",'no','type'=>'CashBankOnly',"admin"=>false,"plugin"=>false)); ?>" ,
	 minLength: 1,
	 select: function( event, ui ) {
		 $('#account_id').val(ui.item.id);
		 var id = ui.item.id;
			var ajaxUrl = "<?php  echo $this->Html->url(array("controller"=>"accounting","action"=>"get_account_current_balance","admin"=>false)); ?>";
				$.ajax({
			          type: 'POST',
			          url: ajaxUrl+"/"+id,
			          data: '',
			          dataType: 'html',
			          success: function(data){
			          	if(data != ''){	 
			        	  data = jQuery.parseJSON(data);
				          if(data.acountType == 'Cr'){ 
				        	$("#account_current_balance").html('<font color="red">'+data.credit+'</font>');
				          }else{
			        		$("#account_current_balance").html(data.credit);
				          } 
						} 
			          	$("#credit_amount").focus();
			        },
						error: function(message){
			              alert("Internal Error Occured. Unable to set data.");
			          }
			      });
		 		},
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
});	

$(document).on('keyup','.paid_amount',function(){
    debitAmt=0; amount=0;
	if (/[^0-9\.]/g.test(this.value)){
     	this.value = this.value.replace(/[^0-9\.]/g,'');
    }

    $(".paid_amount").each(function( index ) {
        if($(this).val()!='' && $(this).val()!=undefined){
        	debitAmt += parseFloat($(this).val());
        }
	});
	
	$('#debit_total').html('Debit Total :'+debitAmt);
});

$(document).on('keyup','#credit_amount',function(){
	if (/[^0-9\.]/g.test(this.value)){
     	this.value = this.value.replace(/[^0-9\.]/g,'');
    }
	var amount=$('#credit_amount').val();
	$('#credit_total').html('Credit Total :'+amount); 
});

$('#is_staff').click(function(){
    if($(this).is(':checked') == true){ 
        $('#staffnameLabel').show();
        $('#userAddMore').hide();
        $('#usernameLabel').hide();
        $('#staffAddMore').show();
    }else{
        $('#staffnameLabel').hide();
        $('#userAddMore').show();
        $('#usernameLabel').show();
        $('#staffAddMore').hide();
    }
});

	// for users..
	var number_of_field=1;
	$(document).ready(function(){
			$( ".username" ).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "accounting", "action" => "advance_autocomplete","Account","name",'null',"null",'no','type'=>'Patient',"admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				var rowId=$(this).attr('id').split('_')[1];
				 
				$('#userHidden_'+rowId).val(ui.item.id);
				var id = ui.item.id;
				var ajaxUrl = "<?php  echo $this->Html->url(array("controller"=>"accounting","action"=>"get_account_current_balance","admin"=>false)); ?>";
				$.ajax({
			          type: 'POST',
			          url: ajaxUrl+"/"+id,
			          data: '',
			          dataType: 'html',
			          success: function(data){
			        	  data = jQuery.parseJSON(data);
				          if(data.acountType == 'Cr'){ 
				        	$("#user_current_balance-1").html('<font color="red">'+data.credit+'</font>');
				          }else{
			        		$("#user_current_balance-1").html(data.credit); 
				          } 
				          $("#narration").html(data.narrationPayment);  
					      $("#paid_amount").focus()
			        },
						error: function(message){
			              alert("Internal Error Occured. Unable to set data.");
			          }
			      });
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});

$('.addParticular').on('click',function(){
	var field = $("#no_of_field").val();
		$( ".username" ).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller"=>"accounting","action"=>"advance_autocomplete","Account","name",'null',"null",'no','type'=>'Patient',"admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				var rowId=$(this).attr('id').split('_')[1];
				$('#userHidden_'+rowId).val(ui.item.id);
				var id = ui.item.id; 
				var ajaxUrl = "<?php  echo $this->Html->url(array("controller"=>"accounting","action"=>"get_account_current_balance","admin"=>false)); ?>";
				$.ajax({
			          type: 'POST',
			          url: ajaxUrl+"/"+id,
			          data: '',
			          dataType: 'html',
			          success: function(data){ 
			        	  var field = $("#no_of_field").val();
			        	  data = jQuery.parseJSON(data);
				          if(data.acountType == 'Dr'){ 
				        	$("#user_current_balance-"+rowId).html('<font color="red">'+data.credit+'</font>');
				          }else{
			        		$("#user_current_balance-"+rowId).html(data.credit); 
				          } 
				          $("#narration").html(data.narrationPayment);  
			        },
						error: function(message){
			              alert("Internal Error Occured. Unable to set data.");
			          }
			      });
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
		$(".username").attr('placeHolder','Party to be debited');
	});

$('.addParticularStaff').on('click',function(){
	var field = $("#no_of_field").val();
		$( ".staffname" ).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller"=>"accounting","action"=>"employeeAutocomplete","Account","name",'null',"null",'no','type'=>'Patient',"admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				var rowId=$(this).attr('id').split('_')[1];
				$('#staffHidden_'+rowId).val(ui.item.id);
				var id = ui.item.id; 
				var ajaxUrl = "<?php  echo $this->Html->url(array("controller"=>"accounting","action"=>"get_account_current_balance","admin"=>false)); ?>";
				$.ajax({
			          type: 'POST',
			          url: ajaxUrl+"/"+id,
			          data: '',
			          dataType: 'html',
			          success: function(data){ 
			        	  var field = $("#no_of_field").val();
			        	  data = jQuery.parseJSON(data);
				          if(data.acountType == 'Dr'){ 
				        	$("#user_current_balance-"+rowId).html('<font color="red">'+data.credit+'</font>');
				          }else{
			        		$("#user_current_balance-"+rowId).html(data.credit); 
				          } 
				          $("#narration").html(data.narrationPayment);  
			        },
						error: function(message){
			              alert("Internal Error Occured. Unable to set data.");
			          }
			      });
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
		$(".staffname").attr('placeHolder','Party to be debited');
	});
	
	$("#account_name").focus().attr('placeHolder','Party to be credited');
	$(".username").attr('placeHolder','Party to be debited');
});
	
function AddParticular(){
	var amountNotEnter = 0;amount=0;
	$(".paid_amount").each(function( index ) {
		amount = parseInt($(".paid_amount").val()!=''?$(".paid_amount").val():'0');
        if(amount == '' || amount == undefined || isNaN(amount) || amount == '0'){
        	alert("Please Enter Amount");
        	amountNotEnter = 1 ;
        }
	});
	if(amountNotEnter == '1'){
		return false;
	}
	var count = parseInt($("#no_of_field").val())+1;
	var fields = '';
		fields += '<tr id="row'+count+'">';
		fields += 	'<td colspan="3">'
		fields += 		'<table width="100%" class="tabularForm">';
		fields += 			'<tr>';
		fields += 				'<td align="left" valign="top" style="text-align: left;"><?php echo __('Dr :')?><font color="red">*</font> <input type="text" name="data[VoucherPayment][user]['+count+'][username]" class="validate[required,custom[mandatory-enter]] username" id="username_'+count+'" autocomplete="false" placeholder="Party to be debited"/> <input type="hidden" name="data[VoucherPayment][user]['+count+'][user_id]" id="userHidden_'+count+'" /></td>'; 
		fields +=				'<td style="text-align: right; width:20%;"><input type="text" class = "validate[required,custom[onlyNumber]] paid_amount cost" name="data[VoucherPayment][user]['+count+'][paid_amount]"  id = "paid_amount_'+count+'" placeholder= "Debit Amount"/></td>';
		fields +=				'<td style="text-align: center; width:20%;"></td>';
		fields += 			'</tr>';
		fields += 			'<tr>';
		fields +=				'<td valign="top" style="text-align: left;"><?php echo __('Current Balance :')?><b><span id="user_current_balance-'+count+'" ></span></td>';
		fields +=				'<td valign="middle" style="text-align:center;" colspan="2"> <a href="javascript:void(0);" id="deleteRow_'+count+'" onclick="deletRow('+count+');"><?php echo $this->Html->image('/img/cross.png');?></a></td>';
		fields += 			'</tr>';
		fields += 		'</table>';
		fields += 	'</td>';	
		fields += '</tr>';
		
		$("#no_of_field").val(count);
		$("#table").append(fields);	
}

function AddParticularStaff(){
	var amountNotEnter = 0;amount = 0;
	$(".paid_amount").each(function( index ) {
		amount = parseInt($(".paid_amount").val()!=''?$(".paid_amount").val():'0');
        if(amount == '' || amount == undefined || isNaN(amount) || amount == '0'){
        	alert("Please Enter Amount");
        	amountNotEnter = 1 ;
        }
	});
	if(amountNotEnter == '1'){
		return false;
	}
	var count = parseInt($("#no_of_field").val())+1;
	var fields = '';
		fields += '<tr id="row'+count+'">';
		fields += 	'<td colspan="3">'
		fields += 		'<table width="100%" class="tabularForm">';
		fields += 			'<tr>';
		fields += 				'<td align="left" valign="top" style="text-align: left;"><?php echo __('Dr :')?><font color="red">*</font> <input type="text" name="data[VoucherPayment][user]['+count+'][staffusername]" class="validate[required,custom[mandatory-enter]] staffname" id="username_'+count+'" autocomplete="false" placeholder="Party to be debited"/> <input type="hidden" name="data[VoucherPayment][user]['+count+'][staff_user_id]" id="staffHidden_'+count+'" /></td>'; 
		fields +=				'<td style="text-align: right; width:20%;"><input type="text" class = "validate[required,custom[onlyNumber]] paid_amount cost" name="data[VoucherPayment][user]['+count+'][paid_amount]"  id = "paid_amount_'+count+'" placeholder= "Debit Amount"/></td>';
		fields +=				'<td style="text-align: center; width:20%;"></td>';
		fields += 			'</tr>';
		fields += 			'<tr>';
		fields +=				'<td valign="top" style="text-align: left;"><?php echo __('Current Balance :')?><b><span id="user_current_balance-'+count+'" ></span></td>';
		fields +=				'<td valign="middle" style="text-align:center;" colspan="2"> <a href="javascript:void(0);" id="deleteRow_'+count+'" onclick="deletRow('+count+');"><?php echo $this->Html->image('/img/cross.png');?></a></td>';
		fields += 			'</tr>';
		fields += 		'</table>';
		fields += 	'</td>';	
		fields += '</tr>';
		
		$("#no_of_field").val(count);
		$("#table").append(fields);	
}
	
$('#print').click(function(){
	window.print();	
});

$(document).ready(function(){
	$('.inputBox').keypress('',function(e) {
		var id = $(this).attr('id');
	    if(e.keyCode==13){		//key enter
	    	if(id === "credit_amount"){
	    		$("#username_1").focus();
	    		e.preventDefault();
	    	}else if(id === "paid_amount"){
	    		$("#narration").focus();
	    		e.preventDefault();	
	    	}else if(id === "narration"){
	    		$("#save").focus();
	    	    e.preventDefault();
	    	}
	    }
	});
});
		
var childSubmitted = false;	
function addJournal(){
	$.fancybox({
		'width' : '70%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'hideOnOverlayClick':false,
		'showCloseButton': true,
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller"=>'Accounting',"action"=>"journal_entry",'0',"isPayment","admin"=>false)); ?>",
		'onClosed':function(){
			if(childSubmitted == true){
				$('#Complaintfrm').submit();
			}
		}
	});
};

$(".staffname").autocomplete({
	 source: "<?php echo $this->Html->url(array("controller"=>"accounting","action"=>"employeeAutocomplete","Account","name",'null',"null",'no','type'=>'Patient',"admin" => false,"plugin"=>false)); ?>",
	 minLength: 1,
	 select: function( event, ui ) {
		var rowId=$(this).attr('id').split('_')[1];
		$('#staffHidden_'+rowId).val(ui.item.id);
		var id = ui.item.id;
		var ajaxUrl = "<?php  echo $this->Html->url(array("controller"=>"accounting","action"=>"get_account_current_balance","admin" => false)); ?>";
		$.ajax({
	          type: 'POST',
	          url: ajaxUrl+"/"+id,
	          data: '',
	          dataType: 'html',
	          success: function(data){
	        	  data = jQuery.parseJSON(data);
		          if(data.acountType == 'Cr'){ 
		        	$("#user_current_balance-1").html('<font color="red">'+data.credit+'</font>');
		          }else{
	        		$("#user_current_balance-1").html(data.credit); 
		          } 
		          $("#narration").html(data.narrationPayment);  
	        },
				error: function(message){
	              alert("Internal Error Occured. Unable to set data.");
	          }
	      });
	 },
	 messages: {
	        noResults: '',
	        results: function() {}
	 }
});

function deletRow(id){
	$("#row"+id).remove();
   	number_of_field--;
}

$("#save").click(function(){
	debitAmt=0; creditAmt=0;
	var validateForm = jQuery("#Complaintfrm").validationEngine('validate');

	if(validateForm == true){
		validateForm == false;

		$(".paid_amount").each(function( index ) {
			var debitAmount = parseFloat($(this).val()!=''?$(this).val():'0');
				if(!isNaN(debitAmount)){
					debitAmt += parseFloat(debitAmount);
				}
			});

		var creditAmt = $("#credit_amount").val();
		if(debitAmt == 0 && creditAmt == 0){
			$('#credit_amount').validationEngine('showPrompt', 'Debit & Credit Amount Should Not Be Zero or Blank', 'text', 'topLeft', true);
			validateForm = false;
			return false;
		}else if(debitAmt==creditAmt){
			validateForm = true;
		}else{
			$('#credit_amount').validationEngine('showPrompt', 'Debit & Credit Amount Not Equal', 'text', 'topLeft', true);
			validateForm = false;
		}
	}
	
	if(validateForm == true){
		 if ($("#isExternal").is(":checked")){ 
			 var isExternal = '1';
			 addJournal();
			 return false;
		 }else{
			 var isExternal = '0';
		 }
		$("#save").hide();
	}else{
		return false;
	}
});
</script>