<?php $label = ($this->request->params['pass'][true] == 'labOverDue') ? 'Overdue Lab' : 'Overdue Rad' ;?>
<div class="inner_title">
	<h3><?php echo __($label);?></h3>
</div>
<p class="ht5"></p>
<!-- billing activity form start here -->
<div id="search-filter">
	<?php
	echo $this->element ( 'patient_information' );
	?>
</div>
<?php if($this->request->params['pass'][true] == 'labOverDue'){?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
	<tr class="row_title">
		<td class="tdLabel" align="left"><strong><?php echo  __('Lab Order id', true); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo  __('Test Name', true); ?>
		</strong></td>
		<td class="table_cell" align="left" width="20%"><strong><?php echo __('Order Date', true); ?>
		</strong></td>
	</tr>
	<?php
	$toggle = 0;
	if (count ( $testOrdered ) > 0) {
		$toggle ++;
		foreach ( $testOrdered as $key => $labs ) {
			if (empty ( $labs ['LaboratoryResult'] ['id'] )) {
				if ($toggle == 0) {
					echo "<tr class='row_gray'>";
					$toggle = 1;
				} else {
					echo "<tr>";
					$toggle = 0;
				}
				?>
	<td class="row_format" align="left"><?php echo $labs['LaboratoryTestOrder']['order_id']; ?>
	</td>
	<td class="row_format" align="left"><?php echo $labs['Laboratory']['name']; ?>
	</td>
	</td> <?php $labTime = substr($this->DateFormat->formatDate2LocalForReport($labs['LaboratoryTestOrder']['create_time'],Configure::read('date_format'),true),-9); ?>
	<td class="tdLabel" align="left"><?php echo $this->DateFormat->formatDate2Local($labs['LaboratoryTestOrder']['start_date'],Configure::read('date_format'),false).' '.$labTime; ?>
	</td>

	</tr>
	<?php
			}
		}
		?>
	<tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		</span>
		</TD>
	</tr>
	<?php
	} else {
		?>
	<tr>
		<TD colspan="8" align="center" class="error"><?php echo __('No test assigned to selected patients', true); ?>.</TD>
	</tr>
	<?php
	}
	?>
</table>
<?php }else{?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
	<tr class="row_title">
		<td class="tdLabel" align="left"><strong><?php echo  __('Rad Order id', true); ?>
		</strong></td>
		<td class="table_cell" align="left" width="%"><strong><?php echo  __('Test Name', true); ?>
		</strong></td>
		<td class="table_cell" align="left" width="80px"><strong><?php echo __('Order Date', true); ?>
		</strong></td>
	</tr>
	<?php
	$toggle = 0;
	if (count ( $testOrdered ) > 0) {
		$toggle ++;
		foreach ( $testOrdered as $key => $labs ) {
			if (empty ( $labs ['RadiologyResult'] ['id'] )) {
				if ($toggle == 0) {
					echo "<tr class='row_gray'>";
					$toggle = 1;
				} else {
					echo "<tr>";
					$toggle = 0;
				}
				?>
	<td class="row_format" align="left"><?php echo $labs['RadiologyTestOrder']['order_id']; ?>
	</td>
	<td class="row_format" align="left"><?php echo $labs['Radiology']['name']; ?>
	</td>
	<td class="tdLabel" align="left"><?php echo $this->DateFormat->formatDate2Local($labs['RadiologyTestOrder']['start_date'],Configure::read('date_format'),false); ?>
	</td>

	</tr>
	<?php
			}
		}
		?>
	<tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		</span>
		</TD>
	</tr>
	<?php
	} else {
		?>
	<tr>
		<TD colspan="8" align="center" class="error"><?php echo __('No test assigned to selected patients', true); ?>.</TD>
	</tr>
	<?php
	}
	?>
</table>
<?php }?>
