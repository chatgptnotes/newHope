<?php /*echo $this->Html->script(array('inline_msg','permission','jquery.blockUI','jquery.fancybox'));
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');*/ 
echo $this->Html->css(array('jquery.fancybox'));
echo $this->Html->script(array('jquery.fancybox')); ?>
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
<div class="clr inner_title" style="text-align: right;"></div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo __('Patient Name') ?></strong></td> 
		<td class="table_cell"><strong><?php echo __('Encounter Date') ?></strong></td>
		<td class="table_cell"><strong><?php echo __('Patient Type') ?></strong></td>
		<td class="table_cell"><strong><?php echo __('Receipt') ?></strong></td>
	</tr>
	<?php 
	$toggle =0;
	if(count($data) > 0) {
      		foreach($data as $patients){
		       if($toggle == 0) {
			       	echo "<tr class='row_gray'>";
			       	$toggle = 1;
		       }else{
			       	echo "<tr>";
			       	$toggle = 0;
		       }?>
	<td class="row_format"><?php echo $patients['Patient']['lookup_name']; ?></td>
	<td class="row_format"><?php echo $this->DateFormat->formatDate2LocalForReport($patients['Patient']['form_received_on'],Configure::read('date_format'),false) ?></td>
	<td class="row_format"><?php echo $patients['Patient']['admission_type'];?></td>
	
	<?php if(strtolower($patients['Patient']['admission_type'])=='ipd'){?>
		<td height='22px' class="row_format"><?php echo $this->Html->link('Provisional Invoice','#',
			array('style'=>'','class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printReceipt',$patients['Patient']['id']))."'
			, '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));?>
		<?php 
			echo $this->Html->link('Detailed Invoice','javascript:void(0)',
				array('class'=>'blueBtn','escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'billings','action'=>'detail_payment',$patients['Patient']['id']
				))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1050,height=670,left=150,top=100'); return false;"));
		 ?></td>
	<?php }else{?>		
		<td height='22px' class="row_format"><?php echo $this->Html->link('Receipts','javascript:void(0)',array('class'=> 'blueBtn receipt','id'=>'receipt_'.$patients['Patient']['id'],
			'escape' => false,'label'=>false,'div'=>false));?></td>	
	<?php } }?>
	</tr>
	 
	<?php					  
	}else{?>
	<tr>
		<TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php } ?>
</table>
<script>
  

//for receipts  --yashwant
 $(".receipt").click(function(){
	 var currentID=$(this).attr('id');
	 var splitedVar=currentID.split('_');
	 patientID=splitedVar[1];
	 $.fancybox({ 
		 	'width' : '50%',
			'height' : '80%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'hideOnOverlayClick':false,
			'showCloseButton':true,
			'onClosed':function(){
			},
			'href' : "<?php echo $this->Html->url(array("controller" =>"Billings","action" =>"allReceiptList","admin"=>false)); ?>"+'/'+patientID,
	 });
 });

</script>