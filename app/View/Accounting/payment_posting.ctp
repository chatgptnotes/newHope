<?php //debug($dataId) ?>
<style>
.tableCell {
	border: 1px solid #4C5E64;
	padding: 2px 5px;
}
/*textarea{
	width:140px!important;
}*/

</style>
<div class="inner_title">
	<h3>
		<?php echo __('Advance Payment');?>
	</h3>
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('Billing',array('url'=>array('controller'=>'Accounting','action'=>'paymentPosting'),'name'=>'paymentPosting','id'=>'paymentPosting','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
echo $this->Form->hidden('patient_id',array('type'=>'text','id'=>'patientId','value'=>$dataId['Patient']['id']));
echo $this->Form->hidden('admission_type',array('type'=>'text','id'=>'admissionType','value'=>$dataId['Patient']['admission_type']));
echo $this->Form->hidden('billing_id',array('type'=>'text','id'=>'billingId','value'=>$dataId['Billing']['id']));
echo $this->Form->hidden('accounting_billing_interface_id',array('type'=>'text','id'=>'accountingBillingInterfaceId','value'=>$dataId['AccountBillingInterface']['id']));
?>
<table width="100%">
	<tr>
	<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
	<td width="95%" valign="top">
<table width="100%">
	<tr class="row_title">
		<td width="16%" style="text-align: center"><?php echo __('Patient Name')?><font color="red">*</font></td>
		<td colspan="1" style="text-align: center"><?php echo __('MRN')?></td>
		<!--<td colspan="2"><?php echo __('Guarantor name')?></td>-->
		<td colspan="1" style="text-align: center"><?php echo __('Mode Of Payment')?><font color="red">*</font></td>
		<td width="14%" style="text-align: center"><?php echo __('Account')?><font color="red">*</font></td> 
		<td colspan="1">&nbsp;</td>
	</tr>
	<tr>
		<td class="tableCell" width="20%"><?php echo $this->Form->input('lookup_name',array('type'=>'text','id'=>'lookupName','class'=>' validate[required,custom[name],custom[onlyLetterSp]','value'=>$dataId['Patient']['lookup_name']));?></td>
		<td class="tableCell" width="24%"><?php echo $this->Form->input('mrn',array('type'=>'text','id'=>'mrnCode','class'=>'textBoxExpnd','value'=>$dataId['Patient']['admission_id']));?></td>
		<!--<td class="tableCell" colspan="2"><?php echo $this->Form->input('guarantor_name', array('type'=>'text','id' => 'guarantor','class'=>'textBoxExpnd'));?></td>-->
		<td class="tableCell" width="24%"><?php echo $this->Form->input('mode_of_payment', array('class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','div' => false,'label' => false,'empty'=>__('Please select'),'autocomplete'=>'off','options'=>array('Cash'=>'Cash','Cheque'=>'Cheque','Credit Card'=>'Credit Card','Credit'=>'Credit','NEFT'=>'NEFT'),'id' => 'mode_of_payment','value'=>$dataId['Billing']['mode_of_payment'])); ?></td>
		<td class="tableCell" width="15%"><?php echo $this->Form->input('account',array('type'=>'text','id'=>'account','class'=>'validate[required,custom[mandatory-enter-only]]','value'=>$dataId['Account']['name']));
					echo $this->Form->hidden('account_id',array('type'=>'text','id'=>'account_id','value'=>$dataId['Account']['id']));
					echo $this->Form->hidden('balance',array('type'=>'text','id'=>'balance','value'=>$dataId['Account']['balance']));?>
					</td>
		<td class="tableCell" width="20%" style="text-align: center"><?php if($dataId['Billing']['refund'] == 1){
													echo $this->Form->checkbox('refund', array('checked' => 'checked'));
												}else{
													echo $this->Form->checkbox('refund');
												}echo ('Refund Amount');?></td>
	</tr>
	<tr class="row_title">
		<!--<td ><?php echo __('Pymt/Adj code')?></td>-->
		<td style="text-align: center"><?php echo __('Amount')?><font color="red">*</font></td>
		<!--<td ><?php echo __('Plan')?></td>
		<td><?php echo __('Ins status')?></td>-->
		<td style="text-align: center"><?php echo __('Date Received')?><font color="red">*</font></td>
		<td style="text-align: center"><?php echo __('Narration')?></td>
		<td style="text-align: center" colspan="2"><?php echo __('Description')?></td>
	</tr>
	<tr>
	<?php if($dataId['AccountBillingInterface']['paid_to_patient']==0.00)
	{
		$amt = $dataId['AccountBillingInterface']['amount'];
	}
	
	if($dataId['AccountBillingInterface']['amount']==0.00)
	{
		$amt = $dataId['AccountBillingInterface']['paid_to_patient'];
	}?>
	<!--<td class="tableCell"><?php echo $this->Form->input('adjustment_code',array('type'=>'text','id'=>'adjustmentCode'));?></td>-->
		<td class="tableCell"><?php echo $this->Form->input('amount',array('type'=>'text','id'=>'amount','class'=>'textBoxExpnd validate[required,custom[onlyNumber]]','value'=>$amt));?></td>
		<?php //$plan = array(''=>'Please Select','Medicare Part A'=>'Medicare Part A','Medicare Part B'=>'Medicare Part B','Medicare Part C'=>'Medicare Part C');?>
		<!--<td class="tableCell"><?php echo $this->Form->input('plan', array('id' => 'plan','options'=>$plan)); ?></td>-->
		<?php //$status = array(''=>'Please Select','OPEN'=>'OPEN','CLOSED'=>'CLOSED');?>
		<!--<td class="tableCell"><?php echo $this->Form->input('ins_status', array('id' => 'insStatus','options'=>$status)); ?></td>-->
		<?php $date = $dataId['Billing']['date']=$this->DateFormat->formatDate2Local($dataId['Billing']['date'],Configure::read('date_format'),true);?>
		<td class="tableCell"><?php echo $this->Form->input('date',array('type'=>'text','readonly'=>'readonly','style'=>'width:163px!important;','class'=>'textBoxExpnd dateCalender validate[required,custom[mandatory-enter-only]]','id'=>'date','value'=>$date));?></td>
		<td class="tableCell"><?php echo $this->Form->input('narration',array('class'=>'textBoxExpnd','type'=>'text','id'=>'narration','value'=>$dataId['Billing']['narration']));?></td>
		<td class="tableCell" colspan="2"><?php echo $this->Form->input('description', array('type'=>'textArea','id' => 'description','value'=>$dataId['Billing']['description'])); 
	?></td>
		<!--<td align="center" width="16%" class="tableCell" rowspan="1">
		<?php echo $this->Form->input('submit',array('type'=>'submit','class'=>'blueBtn','id'=>'submit'));?></td>-->
	</tr>
	<tr>
		<td colspan="5" align="right">
			<?php echo $this->Form->submit('Submit',array('div'=>false ,'class'=>'blueBtn','title'=>'Save','id'=>'submit', ));?>
		 
			<?php echo $this->Html->link(__('Cancel'), array('controller' => 'Accounting', 'action' => 'legder_voucher'), array('title'=>'Cancel','class'=>'blueBtn'));?>
		</td>
		
	</tr>
	<!--<tr>
		<td colspan="6">
			<table width="100%">
				<tr class="row_title">-->
					<!--<td width="9%"><?php echo __('Remit')?></td>
					<td width="9%"><?php echo __('Amt. Covered')?></td>
					<td width="9%"><?php echo __('Amt. Net Covered')?></td>
					<td width="9%"><?php echo __('Deductible Amount')?></td>
					<td width="9%"><?php echo __('Co-Ins Amount')?></td>-->
					<!--<td width="9%"><?php echo __('Account')?><font color="red">*</font></td>-->
				<!--</tr>-->
				<!--<tr>-->
					<!--<td class="tableCell"><?php echo $this->Form->input('remit',array('type'=>'text','id'=>'remit'));?></td>
					<td class="tableCell"><?php echo $this->Form->input('amount_covered',array('type'=>'text','id'=>'amountCovered'));?>
</td>
					<td class="tableCell"><?php echo $this->Form->input('amount_net_covered', array('id' => 'amountNetCovered')); ?></td>
					<td class="tableCell"><?php echo $this->Form->input('decuctible_amount', array('id' => 'decuctibleAmount')); ?></td>
					<td class="tableCell"><?php echo $this->Form->input('co_ins_amount',array('type'=>'text','id'=>'coInsAmount'));?></td>-->
					<!--<td class="tableCell"><?php echo $this->Form->input('account',array('type'=>'text','id'=>'account','class'=>'validate[required,custom[mandatory-enter-only]]'));
					echo $this->Form->hidden('account_id',array('type'=>'text','id'=>'account_id'));
					echo $this->Form->hidden('balance',array('type'=>'text','id'=>'balance'));?>
					</td>-->
				<!--</tr>-->
			<!--</table>-->
		<!--</td>-->
	<!--</tr>-->



</table>
<div id="transactions"></div>
</td>
</tr>
</table>
<?php echo $this->Form->end(); ?>


<script>
$(document).ready(function(){

	$('#submit').click(function() { 
		var validatePerson = jQuery("#paymentPosting").validationEngine('validate');
		return validatePerson;
		
	});
	
	
	<?php if($this->request->params['pass']['0']){?>
		getPatientFieldsLoaded("<?php echo $this->request->params['pass']['0'] ?>");
	<?php }?>
	
	$('#lookupName').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","id&lookup_name",'null',"no","null","is_discharge=0","admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 getPatientFieldsLoaded(ui.item.id,null);
		 },
		 messages: {noResults: '',results: function() {}
		 }
	});

	$('#mrnCode').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","id&admission_id",'null',"no","null","is_discharge=0","admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 getPatientFieldsLoaded(ui.item.id,null);
		 },
		 messages: {noResults: '',results: function() {}
		 }
	});

	$('#guarantor').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Guarantor","person_id&gau_first_name",'null',"0","no","is_discharge=0","admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			getPatientFieldsLoaded(null,ui.item.id);
		 },
		 messages: {noResults: '',results: function() {}
		 }
	});

	 $( "#account" ).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Account","id&name",'null','no','null',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			$('#account_id').val(ui.item.id);
			 $.ajax({
				  type: "GET",
				  url: "<?php echo $this->Html->url(array('controller' => 'app', 'action' => 'advance_autocomplete','Account','balance&name','null','no','null','admin' => false,'plugin'=>false)); ?>"+"?term="+ui.item.value,
				  success : function ( data ){
					   var patientData = jQuery.parseJSON(data);
					   $.each(patientData, 	function(val, text) {
						   $('#balance').val(parseInt(text.id));
					    });
				 }
				});
		 },
		 messages: {
		        noResults: '',
		        results: function() {},
		 }
	});

	function getPatientFieldsLoaded(patientId,personId){
		var Url = "<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "fetchPatientData","admin" => false,"plugin"=>false)); ?>";
		$.ajax({
			  type: "GET",
			  url: Url+'/'+patientId+'/'+personId,
			  success : function ( data ){ 
				  splitted = data.split("***");
				  $( "#transactions" ).html( splitted[1] );
				}
			}).done(function( data ) {
				msg = data.split("***")[0];
				var patientData = jQuery.parseJSON(msg);
				if(patientData.Patient.id) {
					$('#patientId').val(patientData.Patient.id); 
					$('#mrnCode').val(patientData.Patient.admission_id);
					$('#lookupName').val(patientData.Patient.lookup_name);
					$('#admissionType').val(patientData.Patient.admission_type);
					$('#guarantor').val(patientData[0].full_name);
				}
		});
	}

	$(".dateCalender").datepicker({
		showOn : "button",
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		changeMonth : true,
		changeYear : true, 
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate("H:I:S");?>',
       //defaultDate: new Date(firstYr)
		onSelect : function() {
			$(this).focus();
		}
	});
});  
</script>
