<?php echo $this->Html->css('internal_style'); ?>
<?php echo $this->Html->script(array('jquery-1.5.1.min.js','jquery.fancybox-1.3.4'))?>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
<?php
if(count($data) > 0) {
	?>
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo 'Reference No.'; ?> </strong> </td>
		 
	</tr>
	<?php  
	foreach($data as $entry){ 
		if($toggle == 0) {
			echo "<tr class='row_gray'>";
			$toggle = 1;
		}else{
			echo "<tr>";
			$toggle = 0;
		}
		 
		?>
	 	
		<td class="row_format"> <?php echo $this->Form->radio('reference_id',array($entry['JournalEntryUser']['id']=>$entry['JournalEntryUser']['reference_no']),array('label'=>false,'legend'=>false,'name'=>'reference_id'  ,'type'=>'radio','div'=>false )); ?> </td>
	 

<?php }//EOF foreach
	}else {//EOF if ?> 
	<tr>
		<td>No Record Found</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2" align="right">
			<?php echo $this->Form->button('close',array('id'=>'close')); ?>
		</td>
	</tr>
</table>
<script>
	$(document).ready(function(){
		$("#close").click(function(){ 
			selectedVal = $('input[name=reference_id]:checked').val() ;
			$('#journal_entry_id', parent.document).val(selectedVal);
			if(selectedVal == ''){
				$('#reference_id', parent.document).val('') ;
			}
			parent.$.fancybox.close();
		});
	});
</script>
