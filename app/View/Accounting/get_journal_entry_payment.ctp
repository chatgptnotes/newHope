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
	 	<td class="table_cell"><input type="checkbox" class="checked_all" id=selectall checked="checked"/>All</td>
		<td class="table_cell"><strong><?php echo 'Date'; ?> </strong> </td>
		<td class="table_cell"><strong><?php echo 'Reference No.'; ?> </strong> </td>
		<td class="table_cell"><strong><?php echo 'Credit Days'; ?> </strong> </td>
		<td class="table_cell"><strong><?php echo 'Amount'; ?> </strong> </td>
		<td class="table_cell"><strong><?php echo 'Payment Type'; ?> </strong> </td>
		 
	</tr>
	<?php  
	foreach($data as $key=>$entry){ 
		if($toggle == 0) {
			echo "<tr class='".$entry['VoucherReference']['id'] ."'>";
			$toggle = 1;
		}else{
			echo "<tr class='".$entry['VoucherReference']['id'] ."'>";
			$toggle = 0;
		}
		 
		?>
		<td class="row_format">
		<?php echo $this->Form->input("test.", array('id'=>'voucherReferenceId_'.$entry['VoucherReference']['id'],"type" => "checkbox","checked"=>"checked",
			"class"=>"checkbox1 selectCheck",'legend'=>false,'name'=>"data[VoucherReference][id]",'value'=>$entry['VoucherReference']['id'],"hiddenField"=>false));?>
		</td>
	 	<td class="row_format">  <?php echo $entry['VoucherReference']['date']; ?> </td>
		<!-- <td class="row_format">
			<span style="dispaly:none" id='<?php //echo 'ref_no'.$entry['VoucherReference']['id'];?>' value='<?php //echo $entry['VoucherReference']['reference_no'] ;?>'></span>
		 <?php 
					 
			//echo $this->Form->radio('reference_id',array($entry['VoucherReference']['id']=>$entry['VoucherReference']['reference_no']),
				//array( 'legend'=>false,'id'=>'reference_id'  ,'type'=>'radio','div'=>false,'label'=>false,'style'=>'float:left;' )); ?> </td> -->
		<td class="row_format" id='<?php echo 'ref_no'.$entry['VoucherReference']['id'];?>' value='<?php echo $entry['VoucherReference']['reference_no'] ;?>'> <?php echo $entry['VoucherReference']['reference_no']; ?> </td>
		<td class="row_format" id="<?php echo 'cr_day'.$entry['VoucherReference']['id'] ; ?>" value="<?php echo $entry['VoucherReference']['credit_period']; ?>"> <?php echo $entry['VoucherReference']['credit_period']; ?> </td>
		<td class="row_format" id="<?php echo $entry['VoucherReference']['id'] ; ?>" value="<?php echo $entry['VoucherReference']['amount']; ?>"> <?php  echo $this->Number->currency($entry['VoucherReference']['amount']); ?> </td>
	 	<td class="row_format" id="<?php echo 'payment_type'.$entry['VoucherReference']['id'] ; ?>" value="<?php echo $entry['VoucherReference']['payment_type']; ?>"> <?php  echo $entry['VoucherReference']['payment_type']; ?> </td>

<?php }//EOF foreach
	}else {//EOF if ?> 
	<tr>
		<td>No Record Found</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="3" align="right"> 
			<?php echo $this->Form->button('close',array('id'=>'close','class'=>'close')); ?>
		</td>
	</tr>
</table>
<script>
	$(document).ready(function(){

		$(function(){$("#selectall").click(function(){
			$('.checkbox1').attr('checked',this.checked);
			});
		$(".checkbox1").click(function(){
			if($(".checkbox1").length==$(".checkbox1:checked").length){
				$("#selectall").attr("checked","checked");
				}else{
				$("#selectall").removeAttr("checked");
				}
			});
		});
		 
		//$("#close").click(function(){ 

			//eleid = "<?php //echo $eleid?>" ;			
			//selectedVal = $("input:checked[name=data[reference_id]]:checked").val() ;	
			//alert(selectedVal);
			// parent.againstReference.push(selectedVal); 
			 //if(selectedVal){
				//$('#reference_'+eleid, parent.document).val(selectedVal);  
				//concatAmt= "reference_amount_"+eleid;
				//crDay= "credit_period_"+eleid; 
				//reference="reference_no_"+eleid;
				//$('#'+concatAmt, parent.document).val($("#"+selectedVal).attr('value')); //voucher_reference_id
				//$('#voucher_reference_id_'+eleid, parent.document).val(selectedVal);
				//$('#'+reference, parent.document).val($("#ref_no"+selectedVal).attr('value'));
				//$('#'+crDay, parent.document).val($("#cr_day"+selectedVal).attr('value')); //for credit date by amit jain
							
			//}else{
				//$('#reference', parent.document).val('') ;
				//$('#'+eleid, parent.document).focus();
			//}
			
			//parent.$.fancybox.close();
		//});
		//$.each(parent.againstReference, function(key, value) {
		//	 $( "."+value ).hide();
		//	});



		$(".close").click(function(){ 
			var chkRegular = new Array();
			eleid = "<?php echo $eleid?>" ;
			splittedForEle = eleid.split('-');
			var firstCount = splittedForEle[0];
			var count = splittedForEle[1];
			var tempCount = false;
			var totalAmount = 0;
			$(".checkbox1").each(function(){
				if($(this).is(':checked')){
					if(tempCount == true){
						parent.$(".add-row_user").trigger("click");
					}
					var newCount = firstCount+"-"+count; 
					var id = $(this).attr('id');
					splittedArr = id.split("_");  
 					var selectedVal = splittedArr[1] ;	
					 parent.againstReference.push(selectedVal); 
					 if(selectedVal){
						$('#reference_'+newCount, parent.document).val(3);  
						concatAmt= "reference_amount_"+newCount;
						crDay= "credit_period_"+newCount; 
						reference="reference_no_"+newCount;
						$('#'+concatAmt, parent.document).val($("#"+selectedVal).attr('value')); //voucher_reference_id
						$('#voucher_reference_id_'+newCount, parent.document).val(selectedVal);
						$('#'+reference, parent.document).val($("#ref_no"+selectedVal).attr('value'));
						$('#'+crDay, parent.document).val($("#cr_day"+selectedVal).attr('value')); //for credit date by amit jain
						$('#payment_type_'+newCount, parent.document).val($("#payment_type"+selectedVal).attr('value')); //for credit date by amit jain
						totalAmount += parseInt($("#"+selectedVal).attr('value'));
						tempCount = true;
						count++;
				 	}else{
						$('#reference', parent.document).val('') ;
						$('#'+newCount, parent.document).focus();
					}
					
				} 
				});
			 $('#paid_amount',parent.document).val((totalAmount));
				parent.$.fancybox.close();   
			});		
	});
</script>
