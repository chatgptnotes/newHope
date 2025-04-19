
<style>
.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td td {
	padding: 0;
}

.top-header {
	background: #3e474a;
	height: 60px;
	left: 0;
	right: 0;
	top: 0px;
	margin-top: 10px;
	position: relative;
}

textarea {
   
    width: 80px;
}

</style>
<div class="inner_title">
	<h3 style="float: left;"></h3>
</div>
<div class="clr ht5"></div>
<table border="0" class="table_format" cellpadding="0"
	cellspacing="0" width="78%" align="left">
	<tr>
	<td width="7%"></td>
		<td width="39%" class="form_lables" align="center" style="border-top:2px solid #000000;border-bottom:2px solid #000000;color:#D94A8D;"><strong><?php echo __('Expenses For Last 5 Months',true); ?></strong>
		</td>	
	</tr>
	</table>

<table width="100%" cellpadding="0" cellspacing="2" border="0" 	class="tabularForm" id="content-list"><!-- style="border-bottom:solid 10px #E7EEEF;" -->
	<tr> 
	<th width="16%" align="center" valign="top" style="text-align: center;"></th>
		<?php 
$current_date = date('F');
for($i=1;$i<6;$i++)
{
    ${"prev_mont" . $i} = date('F',strtotime("-$i Months")); 
	$numericMonth[] = date('m',strtotime("-$i Months"));
?>
<th width="16%" align="center" valign="top" style="text-align: center; min-width: 150px;" id="col_<?php echo $i;?>"><?php  echo ${"prev_mont" . $i}."</br>";?><span style="float: right;"><input class="checkboxCol"  type="checkbox" name="check[]" id="<?php echo "chk_".$i;?>" value="<?php echo $totalBillAmountForSms;?>"></span></th> 
<?php }
//echo $current_date."</br>";

?>
		<th width="16%" align="center" valign="top" style="text-align: center; min-width: 150px;">Last 5 Months Average</th>
		<th width="16%" align="center" valign="top" style="text-align: center; min-width: 150px;">PER DAY EXPENSE</th>
		
	</tr>  
	
	<?php $cnt=0;
	foreach($resultAccountsData as $key=>$value){
?>
<tr id="row_<?php echo $cnt;?>">
<td width="16%" align="center" valign="top" style="text-align: center; min-width: 150px;border-right:2px solid #000000;"><?php echo $key;?><span style="float: right;"><input class="checkboxRow"  type="checkbox" name="check[]" id="<?php echo "chk_".$cnt;?>" value="<?php echo $totalBillAmountForSms;?>"></span>
</td>
<?php
		for($i=1;$i<6;$i++){
			$numericMonth = date('n',strtotime("-$i Months"));
		?>
		<td width="16%" align="center" valign="top" style="text-align: center; min-width: 150px;border-right:2px solid #000000;" ><?php 
			if(empty($value[$numericMonth]))
				$value[$numericMonth]="0.00";
			echo $value[$numericMonth]; ?></td>
		<?php }	?>
		
		<td width="16%" align="center" valign="top" style="text-align: center; min-width: 150px;border-right:2px solid #000000;"><?php 
			if(empty($value)){
				$value="0";
			}
			$getAvgAmt=array_sum($value);
			$getAvgAmtValue=$getAvgAmt/5;
					echo $getAvgAmtValue;?></td>
		<td width="16%" align="center" valign="top" style="text-align: center; min-width: 150px;border-right:2px solid #000000;"><?php $getAvgPerDay=($getAvgAmtValue/30);
				
					$getAvgPerDayFormatNumber = number_format($getAvgPerDay, 2, '.', '');
					echo $getAvgPerDayFormatNumber;
					$getAvgPerDayArr[$cnt]=$getAvgPerDayFormatNumber;?></td>
		</tr>
	<?php $cnt++;
		} ?>
<tr>
<td colspan="8">
</td>
</tr>
<tr>
<td colspan="7" align="right"><strong>TOTAL PER DAY EXPENSE</strong></td>
<td style="border: 2px solid #000000;text-align:center;"><?php $getAvgAmtTotal=array_sum($getAvgPerDayArr);
					$getAvgAmtTotalFormatNumber = number_format($getAvgAmtTotal, 2, '.', '');
					echo $getAvgAmtTotalFormatNumber;?> </td>
</tr>
<tr>
<td colspan="8">
</td>
</tr>
<tr>
<td colspan="8"><?php echo $this->Form->submit(__('APPROVE'),array('id'=>'labsubmit','class'=>'blueBtn','style'=>'float:right; width:150px; margin: 0 10px 0 0;'));?></td>
</tr>

</table>
<script>
$(document).on('click','.checkboxRow', function() { 	 
	if(confirm("Do you really want to delete this record?")){
		currentId=$(this).attr('id'); 
		splitedId=currentId.split('_');
		ID=splitedId['1'];	
	//	var setTonewCropId=$('#newCrop'+ID).val();				
		  $("#row_"+ID).remove();							
	}else{
		return false;
	}			
});
$(document).on('click','.checkboxCol', function() { 	 
	if(confirm("Do you really want to delete this record?")){
		currentId=$(this).attr('id'); 
		splitedId=currentId.split('_');
		ID=splitedId['1'];	
	//	var setTonewCropId=$('#newCrop'+ID).val();				
		  $("#col_"+ID).remove();							
	}else{
		return false;
	}			
});

</script>