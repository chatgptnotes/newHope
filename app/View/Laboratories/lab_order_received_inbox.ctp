<style>
.is_read {
	font-weight: bold;
	font-size: 14px;
}

#forward_message_text {
	display: none;
}

#open_message {
	display: none;
}

.class_td {
	font-size: 16px;
	font-weight: bold;
	background: -moz-linear-gradient(center top, #3E474A, #343D40) repeat
		scroll 0 0 transparent;
	border-bottom: 1px solid #3E474A;
	color: #FFFFFF;
}

.class_td1 {
	background: -moz-linear-gradient(center top, #3E474A, #343D40) repeat
		scroll 0 0 transparent;
	border-bottom: 1px solid #3E474A;
	color: #FFFFFF;
	font-size: 14px;
	font-weight: bold;
}

.class_td2 {
	background: -moz-linear-gradient(center top, #3E474A, #343D40) repeat
		scroll 0 0 transparent;
	border-bottom: 1px solid #3E474A;
	color: #FFFFFF;
	font-size: 14px;
	font-weight: bold;
}

.table_format {
	border: 1px solid #3E474A;
}

.email_format {
	border: 1px solid #3E474A;
}
</style>
<div id="message_error" align="center"></div>
<div class="inner_title" style="margin-bottom: 25px;">
	<h3><?php echo __('Inbox') ?></h3>
	<span><?php
	echo $this->Html->link ( __ ( 'Back', true ), array (
			'controller' => 'laboratories',
			'action' => 'index' 
	), array (
			'escape' => false,
			'class' => 'blueBtn' 
	) );
	?></span>
</div>
<div align="right"></div>
<div align="center" id='temp-busy-indicator' style="display: none;">
&nbsp;
<?php echo $this->Html->image('indicator.gif', array()); ?>
</div>

<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo __('First Name') ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('Last Name') ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('DOB') ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('Sex') ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('Date of Requisition') ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('No of Orders') ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('Received From') ?> </strong></td>
		<td class="table_cell"><strong><?php echo __('Clinical Lab Result') ?> </strong></td>
	</tr>
<?php
$toggle = 0;

foreach ( $data as $singleRecord ) {
	if ($toggle == 0) {
		echo "<tr class='row_gray'>";
		$toggle = 1;
	} else {
		echo "<tr>";
		$toggle = 0;
	}
	?>
			
<td class="row_format"><?php echo $singleRecord['OutsideLabOrder']['first_name']; ?></td>
	<td class="row_format"><?php echo $singleRecord['OutsideLabOrder']['last_name']; ?></td>
	<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($singleRecord['OutsideLabOrder']['dob'],Configure::read('date_format_us'),false); ?></td>
	<td class="row_format"><?php echo $singleRecord['OutsideLabOrder']['sex']; ?></td>
	<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($singleRecord['OutsideLabOrder']['date_of_requisition'],Configure::read('date_format_us'),false); ?></td>
	<td class="row_format"><?php echo $singleRecord['OutsideLabOrder']['no_of_orders']; ?></td>
	<td class="row_format"><?php echo $singleRecord['OutsideLabOrder']['received_from']; ?></td>
	<td class="row_format"><?php echo $singleRecord['OutsideLabOrder']['clinical_lab_result']; ?></td>
<?php
}

?>	
<tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers -->
<?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
<!-- Shows the next and previous links -->
<?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
 
		
		
		
		
		
		</TD>
	</tr>
</table>
