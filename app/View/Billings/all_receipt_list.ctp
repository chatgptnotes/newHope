<?php /*echo $this->Html->script(array('inline_msg','permission','jquery.blockUI','jquery.fancybox'));
echo $this->Html->css(array('jquery.fancybox'));  
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css'); */ ?>
<style>
label {
	width: 126px;
	padding: 0px;
}

.ui-datepicker-trigger {
	padding: 0px 0 0 0;
	clear: right;
}

.tddate img {
	float: inherit;
}
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('All Receipts List', true);?>
	</h3> 
</div>
<div class="clr">&nbsp;</div> 
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo __('Amount') ?></strong></td> 
		<td class="table_cell"><strong><?php echo __('Date') ?></strong></td> 
		<td class="table_cell"><strong><?php echo __('Bill No.') ?></strong></td> 
		<td class="table_cell"><strong><?php echo __('Print') ?></strong></td>
	</tr>
	<?php 
	$toggle =0;
	if(count($data) > 0) {
      		foreach($data as $dataVal){
			       if($toggle == 0) {
				       	echo "<tr class='row_gray'>";
				       	$toggle = 1;
			       }else{
				       	echo "<tr>";
				       	$toggle = 0;
			       }?>
	<td class="row_format"><?php echo $dataVal['Billing']['amount']; ?></td>
	<td class="row_format"><?php echo $date=$this->DateFormat->formatDate2Local($dataVal['Billing']['date'],Configure::read('date_format'),false);?></td>
	<td class="row_format"><?php echo $dataVal['Billing']['bill_number']; ?></td>
	 
	<td class="row_format"><?php 
			echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
				array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'getBilledServicePrint',$dataVal['Billing']['id']))."',
 				'_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?></td>
	<?php }?>
	</tr>
	<?php  
	}else {?>
	<tr>
		<TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php } ?>
</table>
<div class="clr inner_title" style="text-align: right;"></div>
<script> 
 

</script>