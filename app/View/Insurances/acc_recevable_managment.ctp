<div class="inner_title">
	<h3>
		<?php echo __('Account Receivable By Insurance'); ?>
	</h3>
</div>
<?php echo $this->Form->create('Insurances',array('controller'=>'Insurances','action'=>'accRecevableManagment','id'=>'accRecevableManagment','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<table style="margin: 10px" width="100%">
	<tr>
		<td align="left"></td>
		<td align="right"><?php echo $this->Form->submit('Print', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?></td>
	</tr>
</table>
<table style="border: 1px solid rgb(76, 94, 100); margin: 10px;" width="100%">
	<tr class="row_title" style="border: 1px solid rgb(76, 94, 100);">
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Payer Id #')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Insurance Company')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('0-30 Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('31-60 Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('61-90 Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('91-120 Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('121+ Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Total (in $)')?></strong></td>
	</tr>
	<tr style="border: 1px solid rgb(76, 94, 100);">
		<td class="table_cell" style="border: 1px solid rgb(76, 94, 100);"><?php echo ($insData[0]['TariffStandard']['payer_id'])? $insData[0]['TariffStandard']['payer_id']:'';?></td>
		<td class="table_cell" style="border: 1px solid rgb(76, 94, 100);"><?php echo ($insData[0]['TariffStandard']['name'])? $insData[0]['TariffStandard']['name']:'';?></td>
		<td class="table_cell" align="right" style="border: 1px solid rgb(76, 94, 100);"><?php echo ($month=='1')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right" style="border: 1px solid rgb(76, 94, 100);"><?php echo ($month=='2')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right" style="border: 1px solid rgb(76, 94, 100);"><?php echo ($month=='3')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right" style="border: 1px solid rgb(76, 94, 100);"><?php echo ($month=='4')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right" style="border: 1px solid rgb(76, 94, 100);"><?php echo ($month>'4')? $this->Number->currency($amount):$this->Number->currency('0');?></td>
		<td class="table_cell" align="right" style="border: 1px solid rgb(76, 94, 100);"><?php echo  $this->Number->currency($amount);?></td>
	</tr>
</table>
<?php echo $this->Form->end(); ?>
<table style="border: 1px solid rgb(76, 94, 100); margin: 10px" ; width="100%" cellpadding="1" cellspacing="1">
	<tr class="row_title" style="border: 1px solid rgb(76, 94, 100);">
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Patient')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Visit')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Date Of Birth')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Ins Id #')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Note')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Bill No.')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Billed (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Ins Resp (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Ins 1 Paid (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Ins 2 Paid (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Pt Resp (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Pt Paid (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Ins Bal (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Pt Bal (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100);"><strong><?php echo __('Status')?></strong></td>
		<!-- <td><?php echo __('Details')?></td> -->
	</tr>
	<?php foreach($insData as $data){?>
	<tr style="border: 1px solid rgb(76, 94, 100);">
		<td class="table_cell" style="border: 1px solid rgb(76, 94, 100);"><?php echo $data['Patient']['lookup_name'];?></td>
		<td class="table_cell" style="border: 1px solid rgb(76, 94, 100);"><?php echo $this->DateFormat->formatDate2Local($data['Patient']['form_received_on'],Configure::read('date_format'),false);?></td>
		<td class="table_cell" style="border: 1px solid rgb(76, 94, 100);"><?php echo $this->DateFormat->formatDate2Local($data['Person']['dob'],Configure::read('date_format'),false);?></td>
		<td class="table_cell" style="border: 1px solid rgb(76, 94, 100);"><?php echo $data['NewInsurance']['insurance_number'];?></td>
		<td class="table_cell" style="border: 1px solid rgb(76, 94, 100);"><?php echo $data['DumpNote']['note'];?></td>
		<td class="table_cell" style="border: 1px solid rgb(76, 94, 100);"><?php echo $data['FinalBilling']['bill_number'];?></td>
		<td class="table_cell" align="right" style="border: 1px solid rgb(76, 94, 100);"><?php echo ($data['FinalBilling']['total_amount'])? $currency.($data['FinalBilling']['total_amount']):$currency.'0';?></td>
		<td class="table_cell" align="right" style="border: 1px solid rgb(76, 94, 100);"><?php echo $currency.($data['FinalBilling']['amount_pending_ins_company'] + $data['FinalBilling']['amount_pending_ins_2_company']);?></td>
		<td class="table_cell" align="right" style="border: 1px solid rgb(76, 94, 100);"><?php echo ($data['FinalBilling']['amount_collected_ins_company'])? $currency.$data['FinalBilling']['amount_collected_ins_company']:$currency.'0';?></td>
		<td class="table_cell" align="right" style="border: 1px solid rgb(76, 94, 100);"><?php echo ($data['FinalBilling']['amount_pending_ins_2_company'])? $currency.$data['FinalBilling']['amount_pending_ins_2_company']:$currency.'0';?></td>
		<td class="table_cell" align="right" style="border: 1px solid rgb(76, 94, 100);"><?php echo ($data['FinalBilling']['copay'])? $currency.( $data['FinalBilling']['copay']):$currency.'0';?></td>
		<td class="table_cell" align="right" style="border: 1px solid rgb(76, 94, 100);"><?php echo ($data['FinalBilling']['collected_copay'])? $currency.$data['FinalBilling']['collected_copay']:$currency.'0';?></td>
		<td class="table_cell" align="right" style="border: 1px solid rgb(76, 94, 100);"><?php echo $currency.(( $data['FinalBilling']['amount_pending_ins_company'] -  $data['FinalBilling']['amount_collected_ins_company']) + ($data['FinalBilling']['amount_pending_ins_2_company'] -  $data['FinalBilling']['amount_collected_ins_2_company']));?></td>
		<td class="table_cell" align="right" style="border: 1px solid rgb(76, 94, 100);"><?php echo $currency.( $data['FinalBilling']['copay'] - $data['FinalBilling']['collected_copay']);?></td>
		<td class="table_cell" style="border: 1px solid rgb(76, 94, 100);"><?php echo $data['FinalBilling']['claim_status'] ?></td>
		<!-- <td class="table_cell"><a href="javascript:ptdetails(<?php echo $data['Patient']['id']; ?>)"><?php echo $this->Html->image('icons/uerInfo.png',array('title'=>'Patient Details')) ?></a></td> -->
	</tr>
	<?php  }?>
</table>