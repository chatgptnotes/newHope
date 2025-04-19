<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg','jquery.blockUI'));
?>
<div class="inner_title">
	<h3>
		<?php echo __('Account Receivable By Patient');?> | 
		<?php echo $this->Html->link('View By Insurance',array('controller'=>'Insurances','action'=>'claim_balance_company'));?> | 
		<?php echo $this->Html->link('Summary',array('controller'=>'Accounting','action'=>'paymentRecieved'));?>
	</h3>
</div>
<?php echo $this->Form->create('Insurances',array('controller'=>'Insurances','action'=>'account_receivable_patient','id'=>'accountReceivablePatient','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));?>
<table style="border: 1px solid rgb(76, 94, 100); margin: 10px;" width="100%">
	<tr class="row_title">
		<td align="left" ><?php echo $this->Form->input('', array('name'=>'patient','type'=>'text','id' => 'patient','style'=>'width:150px;','autocomplete'=>'off','placeholder'=>'Patient')); ?>
		<?php echo $this->Form->input('', array('name'=>'phone','type'=>'text','id' => 'phone','style'=>'width:150px;','autocomplete'=>'off','placeholder'=>'Phone')); ?>
		<?php echo $this->Form->submit('Search', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?></td>
		
<?php echo $this->Form->end(); ?>
<?php echo $this->Form->create('Insurances',array('controller'=>'Insurances','action'=>'account_receivable_patient_excel','id'=>'accountReceivablePatientExcel','inputDefaults' => array(
'label' => false,
'div' => false,
'error' => false,
'legend'=>false,
'fieldset'=>false
)
));?>
		<td align="right"><?php echo $this->Html->link(__('Print'),'',
						     		array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Insurances','action'=>'print_account_receivable_patient'))."', '_blank',
						           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?>
		<?php echo $this->Form->submit('Export To File', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?></td>
 	</tr>
</table>
<?php echo $this->Form->end(); ?>
<table cellspacing="1" cellpadding="0" border="0" width="100%" align="center" class="tabularForm" style="margin-top: 40px;">
	<tr class="row_title">
		<th><?php echo __('Patient')?></th>
		<th><?php echo __('Date Of Birth')?></th>
		<th><?php echo __('Phone')?></th>
		<th><?php echo __('Billing Notes')?></th>
		<th><?php echo __('0-30 Days (in $)')?></th>
		<th><?php echo __('31-60 Days (in $)')?></th>
		<th><?php echo __('61-90 Days (in $)')?></th>
		<th><?php echo __('91-120 Days (in $)')?></th>
		<th><?php echo __('121+ Days (in $)')?></th>
		<th><?php echo __('Total (in $)')?></th>
	</tr>
	<?php  $i=0;
	foreach($insCompanyList as $data){
	if(!empty($data['Patient']['lookup_name'])){?>
	<tr <?php //if($i%2 == 0) echo "class='row_gray'"; ?>>
		<td class="row_format"><?php echo ($data['Patient']['lookup_name'])? $data['Patient']['lookup_name']:'';?></td>
		<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($data['Person']['dob'],Configure::read('date_format'),false);?></td>
		<td class="row_format"><?php echo ($data['Patient']['mobile_phone'])? $data['Patient']['mobile_phone']:'';?></td>
		<td class="row_format"><?php echo ($data['DumpNote']['note'])? $data['DumpNote']['note']:'';?></td>
		<td class="row_format" align="right"><?php echo ($data['0']['MONTH']=='1')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right"><?php echo ($data['0']['MONTH']=='2')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right"><?php echo ($data['0']['MONTH']=='3')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right"><?php echo ($data['0']['MONTH']=='4')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right"><?php echo ($data['0']['MONTH']>'4')? $this->Number->currency($data['0']['ins_bal']):$this->Number->currency('0');?></td>
		<td class="row_format" align="right"><?php echo  $this->Number->currency($data['0']['ins_bal']); ?></td>
	</tr>
	<?php } $i++; }?>
	<tr>
	    <td colspan="10" align="center">
		     <!-- Shows the page numbers -->
			 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			 <!-- Shows the next and previous links -->
			 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			 <!-- prints X of Y, where X is current page and Y is number of pages -->
			 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
	    </td>
   </tr>
</table>

<script>

$(document).ready(function(){
	 
	$("#phone").autocomplete("<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "search_patient",'mobile_phone',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});
	
	$("#patient").autocomplete("<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "search_patient",'lookup_name', "admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});
	});
</script>