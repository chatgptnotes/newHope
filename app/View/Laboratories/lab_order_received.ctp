<div class="inner_title" style="margin-bottom: 25px;">
	<h3><?php echo __('') ?></h3>
	<span><?php
	
	echo $this->Html->link ( __ ( 'Enter Lab Requisition' ), array (
			'action' => 'createOutsideLabOrder' 
	), array (
			'escape' => false,
			'class' => 'blueBtn' 
	) );
	?>
									    <?php
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

<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo  __('First Name', true); ?></strong></td>
		<td class="table_cell"><strong><?php echo  __('Last Name', true); ?></strong></td>
		<td class="table_cell"><strong><?php echo  __('DOB', true); ?></strong></td>
		<td class="table_cell"><strong><?php echo  __('Sex', true); ?></strong></td>
		<td class="table_cell"><strong><?php echo  __('Date of Requisition', true); ?></strong></td>
		<td class="table_cell"><strong><?php echo  __('No of Orders', true); ?></strong></td>
		<td class="table_cell"><strong><?php echo  __('Received From', true); ?></strong></td>
		<td class="table_cell"><strong><?php echo  __('Clinical Lab Result', true); ?></strong></td>
		<td class="table_cell"><strong><?php echo  __('Action', true); ?></strong></td>
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
	<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($singleRecord['OutsideLabOrder']['date_of_requisition'],Configure::read('date_format_us'),true); ?></td>
	<td class="row_format"><?php echo $singleRecord['OutsideLabOrder']['no_of_orders']; ?></td>
	<td class="row_format"><?php echo $singleRecord['OutsideLabOrder']['received_from']; ?></td>
	<td class="row_format"><?php echo $singleRecord['OutsideLabOrder']['clinical_lab_result']; ?></td>
	<td class="row_format"><?php
	echo $this->Html->link ( $this->Html->image ( 'icons/edit-icon.png', array (
			'title' => 'Edit Result' 
	) ), array (
			'controller' => 'Laboratories',
			'action' => 'editOutsideLabOrder',
			$singleRecord ['OutsideLabOrder'] ['id'] 
	), array (
			'escape' => false 
	) );
	?></td>
	</tr>
<?php }?>
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