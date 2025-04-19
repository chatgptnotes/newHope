<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg','jquery.blockUI'));
?>
<style>
.light:hover {
	background-color: #99B0B9;
}
iconTd {
	font-size: 9px;
	width: 5%;
	cursor: pointer;
	text-align: center;
}

</style>
<div class="inner_title">
	<h3>
		<?php echo __('Claim Submission Dash Borad'); ?>
	</h3>
	<span><?php  //echo $this->Html->link('Back',array("controller"=>"tariffs","action"=>"viewStandard"),array('escape'=>false,'class'=>'blueBtn','title'=>'Back')); ?>
	</span>

</div>
<table style="border: 1px solid #4C5E64; margin: 5px;" width="100%">
	<tr>
		<td class="iconTd" onclick='pager.prev();'><?php echo $this->Html->image('/img/icons/prev.png',array('alt'=>'Previous','title'=>'Previous'));?>
		</td>
		<td class="iconTd" onclick='pager.next();'><?php echo $this->Html->image('/img/icons/next.png',array('alt'=>'Next','title'=>'Next'));?>
		</td>
		<td class="iconTd"><?php echo $this->Html->link($this->Html->image('/img/claim_icons/showoneline_1.png'),
				array('controller'=>'Billings','action' => 'editErrorManagement'),
				array('escape' => false,'title'=>'Refresh','style'=>'text-decoration: none;'));?>
		</td>
		<td class="iconTd"><span class="selectAll"><?php echo $this->Html->image('/img/claim_icons/hide.png',array('alt'=>'Select/Deselect','title'=>'Select/Deselect'));?>
		
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/claim_icons/hide.png',array('alt'=>'Hide Errors','title'=>'Hide Errors','style'=>'float:right;padding-right:30px'));?>
		</td>
		<?php $claimStatus = array('Batch'=>'Batch')?>
		<td class="iconTd"><?php echo $this->Form->input('claim_status', array('empty' => 'All Current Statuses','options'=>$claimStatus,'style'=>'width: 43%','id' =>'suffix','label'=>false,'style'=>array('algin-Text:center'))); ?>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/claim_icons/drop.png',array('alt'=>'Drop To Paper','title'=>'Drop To Paper','style'=>'float:right;padding-right:30px'));?>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/assign_claims.png',array('alt'=>'Assign Claims','title'=>'Assign Claims','id'=>'assignClaims','style'=>'float:right;padding-right:30px'));?>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/claim_icons/newbatch.PNG',array('alt'=>'New Batch','title'=>'New Batch','style'=>'float:right;padding-right:30px','id'=>'newBatch'));?>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/claim_icons/mappayers.PNG',array('alt'=>'Map Payer','title'=>'Map Payer','style'=>'float:right;padding-right:30px','id'=>'newPayer'));?>
		</td>
		<td class="iconTd"><span class="followUp"><?php echo $this->Html->image('/img/icons/followup.png',array('alt'=>'Followup','title'=>'Followup','style'=>'float:right;padding-right:30px'));?>
		</span>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/notes_error.png',array('alt'=>'Notes','title'=>'Notes','style'=>'float:right;padding-right:30px'));?>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/unlock.png',array('alt'=>'Unlock','title'=>'Unlock','style'=>'float:right;padding-right:30px'));?>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/send_edi.png',array('alt'=>'Send EDI','title'=>'Send EDI','style'=>'float:right;padding-right:30px'));?>
		</td>
		<td class="iconTd"><?php echo $this->Html->image('/img/icons/support_ticket.png',array('alt'=>'Support','title'=>'Support','style'=>'float:right;padding-right:30px'));?>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="iconTd" onclick='pager.prev();'>Prev</td>
		<td class="iconTd" onclick='pager.next();'>Next</td>
		<td class="iconTd"><?php echo $this->Html->link('Refresh',
				array('controller'=>'Billings','action' => 'editErrorManagement'),
				array('escape' => false,'title'=>'Refresh','style'=>'text-decoration: none;'));?>
		</td>
		<td class="iconTd"><span class="selectAll">Show One Line</span></td>
		<td class="iconTd">Hide Duplicates</td>
		<td class="table_cell tableCell"></td>
		<td class="iconTd">Reset</span>
		</td>
		<td class="iconTd">Batch Hierarchy</td>
		<td class="iconTd">New Batch</td>
		<td class="iconTd">Map Payer</td>
		<td class="iconTd">MAp Provider</td>
		<td class="iconTd">Edit/ Erroe Management</span>
		</td>
		<td class="iconTd">History</span>
		</td>
		<td class="iconTd">Status Management</td>
		<td class="iconTd">Claim Sbu Mgmt Reports</td>
		<td class="iconTd">Show Error</td>
		<td class="iconTd"><span class='editClaims'>Support Tickets</span></td>
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%" >
	<tr class="row_title">

		<td width="1%" align="center"><?php echo __('Total files')?></td>
		<td width="1%" align="center"><?php echo __('Rtn To Prov')?></td>
		<td width="9%" align="center">
			<table width="100%">
				<tr class="row_title">
					<td colspan=7 align='center'>Not Submitted</td>
				</tr>
				<tr class="row_title">
					<td>Translated</td>
					<td>Map Payer</td>
					<td>Map Provider</td>
					<td>Suspended</td>
					<td>Ready</td>
					<td>Failed</td>
					<td>Total</td>
				</tr>
			</table>
		</td>
		<td width="9%" align="center">
			<table width="100%">
				<tr class="row_title">
					<td colspan=5 align='center'>Submitted</td>
				</tr>
				<tr class="row_title">
					<td>Sent</td>
					<td>Received</td>
					<td>Processed</td>
					<td>Remit</td>
					<td>Total</td>
				</tr>
			</table>
		</td>
		<td width="2%" align="center"><?php echo __('Total files')?></td>
	</tr>
	<tr class="row_title">

		<td width="1%" align="center"><?php echo $this->Html->image('/img/icons/phone.png',array('style'=>'float: none;'));?>
		</td>
		<td width="1%" align="center"><?php echo __('Batch')?></td>
		<td width="1%" align="center"><?php echo __('Submission Date')?></td>
		<td width="1%" colspan=2 align="center"><?php echo __('File Name')?></td>
	</tr>
</table>
<table width="100%" cellspacing=0 cellpadding=0>
	<tr class='light'>
		<td width="1%" align="left"><font color='#01BE01'><?php echo __('345')?><br />9878.00</font></td>
		<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
		<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
		<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
		<td width="1%" align="left"><?php echo __('26')?><br />4337.00</td>
		<td width="1%" align="left"><font color='red'><?php echo __('95')?><br />20633.00</font>
		</td>
		<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
		<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
		<td width="1%" align="left"><?php echo __('121')?><br />24098.00</td>
		<td width="1%" align="left"><?php echo __('23')?><br />000.00</td>
		<td width="1%" align="left"><?php echo __('156')?><br />4337.00</td>
		<td width="1%" align="left"><?php echo __('30')?><br />4337.00</td>
		<td width="1%" align="left"><?php echo __('15')?><br />4337.00</td>
		<td width="1%" align="left"><?php echo __('24')?><br />4337.00</td>
		<td width="1%" align="left"><font color='#01BE01'><?php echo __('345')?><br />4337.00</font>
		</td>
	</tr>
	<tr class='light'>
		<td width="1%" align="left"><font color='#01BE01'><?php echo __('345')?><br />9878.00</font></td>
		<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
		<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
		<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
		<td width="1%" align="left"><?php echo __('26')?><br />4337.00</td>
		<td width="1%" align="left"><font color='red'><?php echo __('95')?><br />20633.00</font>
		</td>
		<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
		<td width="1%" align="left"><?php echo __('1')?><br />000.00</td>
		<td width="1%" align="left"><?php echo __('121')?><br />24098.00</td>
		<td width="1%" align="left"><?php echo __('23')?><br />000.00</td>
		<td width="1%" align="left"><?php echo __('156')?><br />4337.00</td>
		<td width="1%" align="left"><?php echo __('30')?><br />4337.00</td>
		<td width="1%" align="left"><?php echo __('15')?><br />4337.00</td>
		<td width="1%" align="left"><?php echo __('24')?><br />4337.00</td>
		<td width="1%" align="left"><font color='#01BE01'><?php echo __('345')?><br />4337.00</font>
		</td>
	</tr>
</table>
<?php echo $this->Form->end(); ?>

<script>
$('#newBatch').click(function(){ 
	$.fancybox({
				'width' : '100%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "MailTest", "action" => "addBatch")); ?>",
				
						
			});

});
$('#newPayer').click(function(){ 
	$.fancybox({
				'width' : '100%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "MailTest", "action" => "newPayer")); ?>",
				
						
			});

});

		</script>
