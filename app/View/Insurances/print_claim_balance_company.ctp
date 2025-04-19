<div class="inner_title">
	<h3>
		<?php echo __('Accounts Receivable By Insuarance'); ?>
	</h3>
</div>
<?php echo $this->Form->create('Insurances',array('controller'=>'Insurances','action'=>'print_claim_balance_company','id'=>'printClaimBalanceCompany','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));?>
<table style="margin: 10px" width="100%">
	<tr>
		<td align="left"></td>
		<td align="right"><?php echo $this->Form->submit('Print', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?></td>
	</tr>
</table>
<table style="border: 1px solid rgb(76, 94, 100); margin: 10px;" width="100%" id="claimTable">
	<tr class="row_title" style="border: 1px solid rgb(76, 94, 100); margin: 10px;">
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('Payer Id #')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('Insurance Company')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('0-30 Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('31-60 Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('61-90 Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('91-120 Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('121+ Days (in $)')?></strong></td>
		<td style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><strong><?php echo __('Total (in $)')?></strong></td>
	</tr>
	<?php  $i=0;
	foreach($insCompanyList as $data){
	if(!empty($data['TariffStandard']['name'])){?>
	<tr <?php if($i%2 == 0) echo "class='row_gray'"; ?> style="border: 1px solid rgb(76, 94, 100); margin: 10px;">
		<td class="row_format" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['TariffStandard']['payer_id'])? $data['TariffStandard']['payer_id']:'';?></td>
		<td class="row_format" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['TariffStandard']['name'])? $data['TariffStandard']['name']:'';?></td>
		<td class="row_format" align="right" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['0']['MONTH']=='1')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['0']['MONTH']=='2')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['0']['MONTH']=='3')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['0']['MONTH']=='4')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo ($data['0']['MONTH']>'4')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right" style="border: 1px solid rgb(76, 94, 100); margin: 10px;"><?php echo  $this->Number->currency($data['0']['ins_bal']); ?></td>
	</tr>
	<?php } $i++; }?>
</table>