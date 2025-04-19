<style>
.firsttab {
	width: 10%
}

.firsttab td {
	font-size: 13px;
}
</style>

<?php
foreach ( $getData as $data ) {
	
	?>
<table class="firsttab">
	<tr>
		<td><b><?php echo $data['Patient']['lookup_name'];?></b></td>
	</tr>
	<tr>
		<td><?php echo $data['Laboratory']['name'];?></td>
	</tr>
	<tr>
		<td>
		<?php
	
	if (file_exists ( WWW_ROOT . "/uploads/qrcodes/labOrderQrCard/" . $data ['LaboratoryTestOrder'] ['specimen_id'] . ".png" )) {
		echo $this->Html->image ( "/uploads/qrcodes/labOrderQrCard/" . $data ['LaboratoryTestOrder'] ['specimen_id'] . ".png", array (
				'alt' => $data ['LaboratoryTestOrder'] ['specimen_id'],
				'title' => $data ['LaboratoryTestOrder'] ['specimen_id'],
				'width' => '100%',
				'height' => '52' 
		) );
	}
	?>
		</td>
	</tr>
	<tr>
		<td><?php echo $data['LaboratoryTestOrder']['specimen_id'];?>
		 <?php
	
	$id = $data ['LaboratoryTestOrder'] ['patient_id'];
	// debug($id);exit;	?>
		</td>
	</tr>
</table>
<p>
<p>
<p>
<p>
<?php }?>
<script>
jQuery(document).ready(function(){
	window.print();	
	});

</script>