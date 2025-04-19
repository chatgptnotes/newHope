<?php 
  echo $this->Html->script(array('jquery.fancybox-1.3.4'));//jquery-1.9.1.js
  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));//,'internal_style.css'
 ?>
 <style>
 .highlightColor:hover{
 	background-color:#FFEBEB;
 }
 a.blueBtn {
    padding: 0px 10px;
}
.ho:hover{
		cursor: pointer;
		background-color:#C1BA7C;
		}
 </style>
 <div class="inner_title" id="Test1">
	<h3>
		&nbsp;
		<?php echo __('Activity Posting', true); ?>
	</h3>
	<span>
	<?php //echo $this->Html->link(__('Add New Authorization'),array('action' => 'newInsuranceAuthorization',$patient['Patient']['id']), 
 		//array('escape' => false,'class'=>'blueBtn','id'=>'addNewInsuranceAuthorization','style'=>'margin-left:0px;float:right'));
		echo $this->Form->button('Add', array('class'=>'blueBtn','style'=>'float:right; margin-left: 5px;','type' => 'button','id'=>'Test'));?>
	</span>
</div>

<table align="center" style="margin-top: 5px" width="100%">
	<tr>
	<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
	<td width="95%" valign="top">
	<table width="100%" id="cashBook">
	<tr class="row_title">
		<td class="table_cell"><?php echo __('Batch ID');?></td>
		<td class="table_cell"><?php echo __('Handover Amount');?></td>
		<td class="table_cell"><?php echo __('Transaction Posted');?></td>
		<td class="table_cell"><?php echo __('Total Amount Overriden');?></td>
		<td class="table_cell"><?php echo __('Posting Organization');?></td>
		<td class="table_cell"><?php echo __('Last Posting');?></td>
		<td class="table_cell"><?php echo __('Default Svc. Date');?></td>
		<td class="table_cell"><?php echo __('Created Modified By');?></td>
		<td class="table_cell"><?php echo __('Handover Cashier');?></td>
	</tr>
	<?php if(count($cashBookData) > 0){ $count = 0; ?>
	<?php foreach($cashBookData as $data) { $count++; ?>
	<?php if($count%2==0){
			$class = "ho"; 
		} else {
			$class = "row_gray ho"; 
		} ?>
	<tr id="<?php echo $data['CashierBatch']['id']; ?>" class="<?php echo $class; ?> idSelectable">
		<input type="hidden" id="start_transaction_id_<?php echo $data['CashierBatch']['id']; ?>" value="<?php echo $data['CashierBatch']['start_transaction_date'].','.$data['CashierBatch']['end_transaction_date'];?>">
		
		<td class="table_cell"><?php echo $data['CashierBatch']['batch_number'];?></td>
		<td class="table_cell" style="text-align:center;"><?php echo $data['CashierBatch']['handover_shift_cash'];?></td>
		<td class="table_cell" style="text-align:center;"><?php echo $data['CashierBatch']['trans_posted'];?></td>
		<td class="table_cell" style="text-align:center;"><?php echo $data['CashierBatch']['total_amount_overidden'];?></td>
		<td class="table_cell" style="text-align:center;"><?php echo $data['Location']['name'];?></td>
		<td class="table_cell" style="text-align:center;"><?php echo $data['CashierBatch']['last_posting'];?></td>
		<?php $date = $data['CashierBatch']['default_svc_date']=$this->DateFormat->formatDate2Local($data['CashierBatch']['default_svc_date'],Configure::read('date_format'),true);?>
		<td class="table_cell" style="text-align:center;"><?php echo $date;?></td>
		<td class="table_cell"><?php echo $data['User']['first_name'].' '.$data['User']['last_name'];?></td>
		<td class="table_cell"><?php echo $data['UserAlias']['first_name'].' '.$data['UserAlias']['last_name'];?></td>
		
	</tr>	
	<?php }?>
	<?php }?>
	
</table>
</td>
</tr>
</table>	
<script>
var fileDailyCashURL = "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "fileDailyCash","admin" => false)); ?>" ;
var getCashierTransactionsURL = "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getCashierTransactions","admin" => false)); ?>" ;
var fromLogout = "<?php echo $fromLogout;?>";

$( document ).ready(function() {
	if(fromLogout == 'true'){
		$( "#Test" ).trigger( "click" );
	}
});
	
$( "#Test" ).click(function() { 
	$.fancybox({
		'width' : '70%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : fileDailyCashURL + '/' + fromLogout
	});
});

$(".idSelectable").click(function() {
	id = $(this).attr('id');
	$("#cashBook tr").removeClass('highlightColor');
	$(this).closest('tr').addClass('highlightColor');
	//var transaction_numbers = $(this).parents('tr').find('td input[type="hidden"]').val();alert(transaction_numbers);
	//var transaction_numbers = $(this).find('input').val();
	//transaction_numbers = transaction_numbers.split(',');
	$.fancybox({
		'width' : '60%',
		'height' : '80%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : getCashierTransactionsURL + '/' + id
	});
});
</script>