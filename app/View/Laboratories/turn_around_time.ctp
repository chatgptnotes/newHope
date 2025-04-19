<style>
.row_action a {
	padding: 0px;
}

label {
	text-align: left !important;
	width: auto !important;
	padding-top: 0px !important;
}
</style>

<div class="inner_title">
	<h3>  <?php
	echo __ ( 'Turn Around Time Report' );
	?> </h3>
</div>
<table border="0" class=" " cellpadding="0" cellspacing="0" width="100%"
	align="center" style="margin-top: 10px;">
	<tr class="row_title">
		<td align="left" class="row_title">Patient ID</td>
		<td align="center" class="row_title">Patient Name</td>
		<td align="center" class="row_title">Test Name</td>
		<td align="center" class="row_title">Ordered Date Time</td>
		<td align="center" class="row_title">Resulted Date Time</td>
		<td align="left" class="row_title">Turn Around time</td>
	</tr>
	
	<?php
	
	foreach ( $testOrdered as $data ) {
		
		if ($toggle == 0) {
			echo "<tr class='row_gray'>";
			$toggle = 1;
		} else {
			echo "<tr>";
			$toggle = 0;
		}
		?>
		<td align="left" class="row_format"><?php echo $data['Patient']['admission_id'];?></td>
	<td align="center" class="row_format"><?php echo $data['Patient']['lookup_name'];?></td>
	<td align="center" class="row_format"><?php echo $data['Laboratory']['name'];?></td>

	<td align="center" class="row_format">
		<?php
		
		echo $this->DateFormat->formatDate2Local ( $data ['LaboratoryTestOrder'] ['start_date'], Configure::read ( 'date_format' ), true );
		?></td>
	<td align="center" class="row_format">
		<?php echo $this->DateFormat->formatDate2Local($data['LaboratoryResult']['result_publish_date'],Configure::read('date_format'),true); ?></td>
	<td align="center" class="row_format"><?php
		
		$elapsed = $this->DateFormat->dateDiff ( $data ['LaboratoryTestOrder'] ['start_date'], $data ['LaboratoryResult'] ['result_publish_date'] );
		$show = '';
		
		// if(!empty($elapsed->h)){
		$show .= $elapsed->h . ":";
		// }
		// if(!empty($elapsed->i))
		$show .= $elapsed->i . ":";
		// }
		// if(!empty($elapsed->s)){
		$show .= $elapsed->s;
		// }
		echo $show;
		?></td>
	</tr>
	<?php }?>
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

</table>