<?php echo $this->Html->css('internal_style'); ?>
<?php echo $this->Html->script(array('jquery-1.5.1.min.js','jquery.fancybox-1.3.4'))?>
<style>
label{ 
	width:70%;
	margin-right: 0px;
    padding-top: 0px;
    text-align: left;
}
</style>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
<?php
if(count($data) > 0) {
	?>
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo 'Reference No.'; ?> </strong> </td>
		<td class="table_cell"><strong><?php echo 'Credit Days'; ?> </strong> </td>
		<td class="table_cell"><strong><?php echo 'Amount'; ?> </strong> </td>
		 
	</tr>
	<?php  
	foreach($data as $entry){ 
		if($toggle == 0) {
			echo "<tr class='".$entry['VoucherReference']['id'] ." row_gray'>";
			$toggle = 1;
		}else{
			echo "<tr class='".$entry['VoucherReference']['id'] ."'>";
			$toggle = 0;
		}
		 
		?>
	 	
		<td class="row_format">
			<span style="dispaly:none" id='<?php echo 'ref_no'.$entry['VoucherReference']['id'];?>' value='<?php echo $entry['VoucherReference']['reference_no'] ;?>'></span>
		 <?php 
					 
			echo $this->Form->radio('reference_id',array($entry['VoucherReference']['id']=>$entry['VoucherReference']['reference_no']),
				array( 'legend'=>false,'id'=>'reference_id'  ,'type'=>'radio','div'=>false,'label'=>false,'style'=>'float:left;' )); ?> </td>
		<td class="row_format" id="<?php echo 'cr_day'.$entry['VoucherReference']['id'] ; ?>" value="<?php echo $entry['VoucherReference']['credit_period']; ?>"> <?php echo $entry['VoucherReference']['credit_period']; ?> </td>
		 <td class="row_format" id="<?php echo $entry['VoucherReference']['id'] ; ?>" value="<?php echo $entry['VoucherReference']['amount']; ?>"> <?php  echo $this->Number->currency($entry['VoucherReference']['amount']); ?> </td>
	 

<?php }//EOF foreach
	}else {//EOF if ?> 
	<tr>
		<td>No Record Found</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="3" align="right"> 
			<?php echo $this->Form->button('close',array('id'=>'close')); ?>
		</td>
	</tr>
</table>
<script>
	$(document).ready(function(){
		$("#close").click(function(){ 

			eleid = "<?php echo $eleid?>" ;			
			selectedVal = $("input:radio[name=data[reference_id]]:checked").val() ;	
			 parent.againstReference.push(selectedVal); 
			 if(selectedVal){
				//$('#reference_'+eleid, parent.document).val(selectedVal);  
				concatAmt= "reference_amount_"+eleid;
				crDay= "credit_period_"+eleid; 
				reference="reference_no_"+eleid;
				$('#'+concatAmt, parent.document).val($("#"+selectedVal).attr('value')); //voucher_reference_id
				$('#voucher_reference_id_'+eleid, parent.document).val(selectedVal);
				$('#'+reference, parent.document).val($("#ref_no"+selectedVal).attr('value'));
				$('#'+crDay, parent.document).val($("#cr_day"+selectedVal).attr('value')); //for credit date by amit jain
							
			}else{
				$('#reference', parent.document).val('') ;
				$('#'+eleid, parent.document).focus();
			}
			
			parent.$.fancybox.close();
		});
		$.each(parent.againstReference, function(key, value) {
			 $( "."+value ).hide();
			});

	});
</script>
