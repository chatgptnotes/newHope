
<?php // debug($data); exit ?>

<?php if(!empty($data)) {?>
<div class="inner_title">
	<h3>  <?php echo __('Assigned Labs'); ?> </h3>
</div>
<table border="1" class=" " cellpadding="0" cellspacing="0" width="100%"
	align="center" style="margin-top: 10px;">
	<tr class="row_title">
		<td align="left" class="table_cell">Sr.No</td>
		<td align="left" class="table_cell">ID</td>
		<td align="left" class="table_cell">Test Name</td>
	</tr>
	<?php $i=0; foreach($data as $datas){ $i++?>
<tr>
		<td class="row_format"><?php echo $i ?></td>
		<td class="row_format"><?php echo $datas['LabManager']['order_id'];?></td>
		<td class="row_format"><?php echo $datas['Laboratory']['name'];?></td>
	</tr>
<?php } ?></table>
<?php
} else {
	?>
<div class="inner_title">
	<h3> <?php	echo __('No Lab Assigned'); ?> </h3>
</div>
<?php  } ?>
