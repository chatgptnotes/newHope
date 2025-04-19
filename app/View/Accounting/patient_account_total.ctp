<?php 
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
?>
<div class="inner_title">
	<h3>
		<?php echo __('Patient Total Balance'); ?>
	</h3>
</div>
<?php echo $this->Form->create('Patient_account',array('id'=>'patientAccount','url'=>array('controller'=>'Accounting','action'=>'patient_account_total','admin'=>false),));?>
<table align="center" style="margin-top: 10px" width="100%">
	<tr>
	<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
	<td width="95%" valign="top">
<table align="center" style="margin-top: 10px">
	<tr>
		<td align="center"><strong><?php echo __('Account');?> </strong>
		</td>
		<td><?php echo $this->Form->input('Voucher.name',array('id'=>'user','label'=>false,'div'=>false,'type'=>'text','autocomplete'=>'off','class' => 'validate[required,custom[mandatory-enter]]'));
			echo $this->Form->hidden('Voucher.user_id',array('id'=>'user_id'));?>
		<td><?php echo $this->Form->submit('Submit',array('class'=>'blueBtn','label'=> false, 'div' => false));
		echo $this->Form->end();?></td>
	</tr>
</table>
<?php if($click==1){?>
<table cellspacing="0" cellpadding="0" width="80%" align="center"
		style="margin-top: 20px">
		<tr>
			<td><b><?php 
			echo __('Ledger : '); echo ucwords($name['Patient']['lookup_name']);?>
			</b></td>
		</tr>
	</table>
	<table class="formFull" width="80%" align="center" cellspacing="0">
		<tr class="row_gray">
			<th class="tdLabel"><?php echo __('Date');?></th>
			<th class="tdLabel"><?php echo __('Particulars');?></th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th class="tdLabel"><?php echo __('Voucher Type');?></th>
			<th class="tdLabel"><?php echo __('Voucher Number');?></th>
			<th class="tdLabel"><?php echo __('Debit');?></th>
			<th class="tdLabel"><?php echo __('Credit');?></th>
			<th class="tdLabel"><?php echo __('View');?></th>
		</tr>
	<?php 
	/* $toggle=0;$row=0;
	foreach($data as $data){
		if($toggle == 0) {
			echo "<tr>";
			$toggle = 1;
		}else{
			echo "<tr class='row_gray'>";
			$toggle = 0;
		} */?>
			
			<!--  <td class="tdLabel"><?php //echo $this->DateFormat->formatDate2Local($data['AccountBillingInterface']['date'],Configure::read('date_format'),false); ?>
			</td>
			<td class="tdLabel"><?php //echo $data['Account']['name'];?>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td class="tdLabel"><?php //echo 'Journal'; ?>
			</td>
			<td class="tdLabel"><?php
				//echo $data['AccountBillingInterface']['id'];
			?>
			<?php //if($data['AccountBillingInterface']['type']=='Dr'){
				//$debit=$debit+$data['AccountBillingInterface']['amount'];?>
				<td class="tdLabel"><?php 
				//echo $this->Number->currency($data['AccountBillingInterface']['amount']);?></td> 
				<?php //}
				//else {
				?>	
				<td><?php //echo " "; ?>
				</td><?php //}
				
			?>
			</td> <?php //if($data['AccountBillingInterface']['type']=='Cr'){?>
			<?php 
			//$credit=$credit+$data['AccountBillingInterface']['paid_to_patient'];?>
			<td class="tdLabel"><?php 
			//echo $this->Number->currency($data['AccountBillingInterface']['paid_to_patient']) ; ?>
			</td>
			<?php //}
			//else {?>
			<td><?php  echo " ";?></td>-->
			<?php //} 
					//}//EOF forecah
					if(empty($data)){
			?>
			<tr><td colspan="9">&nbsp;</td></tr>
			<tr >&nbsp;<td colspan="9"></td></tr>
			<tr><td colspan="9"><?php echo " " ?></td></tr>
			<tr><td colspan="9">&nbsp;</td></tr>
			<tr><td colspan="9">&nbsp;</td></tr><?php    }?> 
			<tr><td colspan="9" style="border-top: solid 2px #3E474A;margin-bottom:-1px">&nbsp;</td></tr>			
			<tr>
				<td class="tdLabel" colspan="6" style="text-align: right;"><?php echo __('Total Amount :');?>
				</td>
			<?php if(empty($total)){?>
			<td class="tdLabel" >
			<?php echo " ";?></td>		
			<td class="tdLabel"><?php echo " ";?></td>
			<?php }
			else{?>
					<td class="tdLabel" >
						<?php echo $this->Number->currency($total['FinalBilling']['total_amount']);?></td>
						<td class="tdLabel"><?php echo " ";?></td>
						
			<?php }	?>
			</tr>			
	</table>
	<?php }?>
	</td>
</tr>
</table>
<script>
$(document).ready(function(){
	 $( "#user" ).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Patient","lookup_name",'null',"no",'null','is_discharge'=>'1',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			$('#user_id').val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {},
		 }
	});
	 jQuery("#patientAccount").validationEngine({
			validateNonVisibleFields: true,
			updatePromptsPosition:true,
			});	
});
</script>
