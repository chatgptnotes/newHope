<style>
	.drop {
		border: 0.1em solid #808000;
	}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Account Receivable', true); ?>
	</h3>
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('Account_Payable',array('id'=>'account_Payable','url'=>array('controller'=>'Accounting','action'=>'account_receivable',$user[0]['User']['id'],'admin'=>false),));?>
<table border="0" cellpadding="2" cellspacing="0" align="center">
	<tbody>
		<tr class="row_title">
			<td align="center"><strong><?php echo __('Account');?> </strong></td>
			<td><?php echo $this->Form->input('VoucherEntry.name',array('id'=>'user','label'=>false,'div'=>false,'type'=>'text','autocomplete'=>'off','class' => 'validate[required,custom[mandatory-enter]]'));
			echo $this->Form->hidden('VoucherEntry.user_id',array('id'=>'user_id'));?>
			<td><?php echo __('From');?></td>
			<td><?php echo $this->Form->input('VoucherEntry.from', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly'));?></td>
			<td><?php echo __('To');?></td>
			<td><?php echo $this->Form->input('VoucherEntry.to', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly'));?></td>
			<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false,'id'=>'search'));?></td>
		</tr> 
	</tbody>
</table> 
<?php  echo $this->Form->end();?>
<div class="clr inner_title" style="text-align: right;"></div>

<table align="center" style="margin-top: 10px" width="100%">
	<tr>
		<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
		<td width="95%" valign="top">
		<table class="formFull" cellspacing="0" cellpadding="0" width="80%" align="center">
			<tr class="row_gray">
				<th class="tdLabel" width="10%"><?php echo __('Date');?></th>
				<th class="tdLabel" width="10%"><?php echo __('Reference No');?></th>
				<th class="tdLabel" width="10%"><?php echo __('Party`s name');?></th>
				<th class="tdLabel" width="10%"><?php echo __('Pending Amount');?></th>
				<th class="tdLabel" width="10%"><?php echo __('Due On');?></th>
				<th class="tdLabel" width="10%"><?php echo __('Overdue by days');?></th>
			</tr>
			<?php $toggle=0;$row=0;
					foreach($receivableAmt as $pay){ 
				if($toggle == 0) {
								echo "<tr>";
								$toggle = 1;
							}else{
								echo "<tr class='row_gray'>";
								$toggle = 0;
							}?>
						<td width="10%" class="tdLabel"><?php echo $this->DateFormat->formatDate2Local($pay['VoucherReference']['date'],Configure::read('date_format'),false); ?></td>
						<td class="tdLabel" width="10%"><?php echo $pay['VoucherReference']['reference_no'];?></td>
						<td class="tdLabel" width="10%"> <?php echo $pay['Account']['name'];?></td>
						<td class="tdLabel" width="10%"><?php echo $this->Number->currency($pay['VoucherReference']['amount']); ?></td>
						<td class="tdLabel" width="10%"><?php echo date("d/m/Y",strtotime($pay['VoucherReference']['date']." +". $pay['VoucherReference']['credit_period']." Days")); ?></td>
						<td class="tdLabel" width="10%"><?php $voucherDue=date("Y-m-d",strtotime($pay['VoucherReference']['date']." +". $pay['VoucherReference']['credit_period']." Days"));
						if($voucherDue>date('Y-m-d')){
						$duedate=$this->DateFormat->dateDiff(date('Y-m-d'),$voucherDue);
						echo $duedate->days;
						}
						else echo " ";?></td> 
				   </tr>
					<?php 
					if($row == 0) {
					echo "<tr>";
					$row = 1;
					}
					else{
						echo "<tr class='row_gray'>";
						$row = 0;
					}?>
						<td>&nbsp;</td>
						<td class="tdLabel"><i><?php echo $this->DateFormat->formatDate2Local($pay['VoucherReference']['date'],Configure::read('date_format'),false); echo " "; ?>
							<?php echo $pay['VoucherReference']['voucher_type'];?></i>
						</td>
						<td class="tdLabel" style="text-align: center">
							<?php echo $pay['VoucherReference']['id']; echo "&nbsp;&nbsp;&nbsp;";?>
							<?php echo $this->Number->currency($pay['VoucherReference']['amount']); ?>
						</td>
						 <td colspan="3">&nbsp;</td>
					</tr>
		<?php 
			//foreach for child entries
			if(is_array($pay['ReferenceChild'])){
				foreach($pay['ReferenceChild'] as $key => $child){
	 				  echo "<tr>"; 
					  ?>
				 <td>&nbsp;</td>
				 <td class="tdLabel"><i>
				 <?php echo $this->DateFormat->formatDate2Local($child['date'],Configure::read('date_format'),false);
				 	   echo " ";  
				 	   echo $child['voucher_type'];?>
				 </i></td>
				 <td><i><?php echo $child['paid_amount']?></i></td> 
				 
				<?php  
			}
		}
	?>
	
	<?php $total=$total+$pay['VoucherReference']['amount']; 
}?>
	<tr>
		<td colspan="3" align="right" style="border-top: solid 2px #3E474A;"><?php echo __('Total   :');?></td>
		<td colspan="3" class="tdLabel" style="border-top: solid 2px #3E474A;">&nbsp;<?php echo $this->Number->currency($total); ?></td>
	</tr>
</table>
</td>
</tr>
</table>
<script>
$(function() {
	$("#user").focus();
	$("#from").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate('HH:II:SS');?>',			
	});	 
 	$("#to").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate('HH:II:SS');?>',	 		
	});
	 
	$( "#search" ).click(function(){ 
		 result  = compareDates($( '#from' ).val(),$( '#to' ).val(),'<?php echo $this->General->GeneralDate();?>') //function with dateformat 
		 if(!result){ 
		 	alert("To date should be greater than from date");
		 }
		 return result ;
	});
});
$(document).ready(function(){
	$('#user').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","account","name",'null',"null",'null',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#user_id').val(ui.item.id); 
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
	 jQuery("#account_Payable").validationEngine({
			validateNonVisibleFields: true,
			updatePromptsPosition:true,
			});	
});  
</script>
