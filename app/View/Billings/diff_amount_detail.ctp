<table style="border: solid 1px black; margin: 21px 0 0 118px;
    padding: 11px 0 0;" width="75%" align="center">
	<tr>
		<th>
		<?php if(!empty($diffArray)){
			echo '<strong>Charges details </strong>';
		?>
		</th>
	</tr>
	<?php foreach($diffArray as $key=>$detail){?>
		<tr>
			<td><?php echo $key?></td>
			<td><?php echo $this->Number->currency(ceil($detail));?></td>
		</tr>
	<?php }
	}?>
</table>