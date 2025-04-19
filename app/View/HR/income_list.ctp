<table width="100%" cellpadding="0" cellspacing="0" border="0"
	 align="center" style="padding: 12px;margin-top: 5px">
<?php if(!empty($resultAccountsData)){ ?>
<tr>
<td width="12%"></td>
<td width="63%" class="form_lables" align="center" style="font-weight:bold;border-top:2px solid #4C85AA;border-bottom:2px solid #4C85AA;color:#266A2E;" bgcolor="#d2ebf2" id="showHeading"><?php echo __('Incomes For Last 5 Months',true); ?>
</td>	
<td width="24%">
</td>
</tr>
</table>
<div class="clr ht5"></div>
<?php 
echo $this->Form->create('',array('type' => 'file',
		'url' => array('controller' => 'HR', 'action' => 'save_income'),'class'=>'manage','style'=>array("float"=>"left","width"=>"100%"),'id'=>'incomeFrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
																								    )
			));	 
?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" 	class="tabularForm" id="content-list1"><!-- style="border-bottom:solid 10px #E7EEEF;" -->
	<tr> 
	<th width="12%" align="center" valign="top" style="text-align: center;">Account Name</th>
	<?php $startDate11 = date("Y-m", strtotime($startDate."+1 month"));		
	$currentDate = date("Y-m-d h:i:s");
	echo $this->Form->hidden('Incomes.start_date',array('id'=>'start_date','value'=>$currentDate));	
	for($i=1;$i<6;$i++){
		$numericMonthHeader = date('n',strtotime($startDate11."- $i Months"));		
   		${"prev_mont" . $i} = date('F',strtotime($startDate11." - $i months")); ?>
<th width="12%" align="center" valign="top" style="text-align: center; min-width: 150px;color:#266A2E ! important;"  class="colTh_<?php echo $i;?>" id="rowcol_<?php echo $i;?>"> <?php  echo ${"prev_mont" . $i};?><span style="float: right;"><input id="<?php echo "chk_".$numericMonthHeader."_".$i;?>" class="ChkBoxMonthlySelectAll" type="checkbox" name="check[]" value="<?php echo $startDate;?>"></span></th> 
<?php } ?>
		<th width="12%" align="center" valign="top" style="text-align: center; min-width: 150px;" id="showAvgHeading">Last 5 Months Average</th>
		<th width="12%" align="center" valign="top" style="text-align: center; min-width: 150px;">PER DAY INCOME</th>		
	</tr>  

	<?php $cnt=0;
		$cntCol=0;
	foreach($resultAccountsData as $key=>$value){
if(!empty($key)){?>
<tr id="row_<?php echo $cntCol;?>">
<td width="12%" align="center" valign="top" style="text-align: center; min-width: 150px;border-right:2px solid #000000;"><?php echo $key;
	echo $this->Form->hidden('patient_id',array('id'=>'acc_name','name' => 'Income[acc_name][]','value'=>$key));
	?><span style="float: right;"><input class="checkboxRow"  type="checkbox" name="check[]" id="<?php echo "chk_".$cntCol;?>"></span>
</td>
<?php
		for($j=1;$j<6;$j++){
			$numericMonth = date('n',strtotime($startDate11."- $j Months"));			
			$MonthName = date('F',strtotime($startDate11."- $j Months"));			
		//	${"prev_mont" . $j} = date('F',strtotime($startDate11." - $j months"));			
		?>
		<td width="12%" align="center" valign="top" style="text-align: center; min-width: 150px;border-right:2px solid #000000;" totalVar ="<?php echo 'getAvgAmt_'.$cntCol;?>" class="col_<?php echo $j;?>" id="rowcol_<?php echo $cntCol;?>">
		<?php 
			if(empty($value[$numericMonth]))
				$value[$numericMonth]="0.00";
				echo $value[$numericMonth]; 
				echo $this->Form->hidden('month_total',array('class'=>'monthTotal_'.$j,'name' => 'Income['.$MonthName.'][]','value'=>$value[$numericMonth]));?></td>
		<?php }	?>
		
		<td width="12%" align="center" valign="top" style="text-align: center; min-width: 150px;border-right:2px solid #000000;" id="monthtoatalAvg_<?php echo $cntCol;?>"><?php 
			if(empty($value)){
				$value="0";
			}
			$getAvgAmt=array_sum($value);
			$getAvgAmtValue=$getAvgAmt/5;
			$getAvgAmtValue = number_format($getAvgAmtValue, 2, '.', '');
					echo $getAvgAmtValue;
			?></td>
			<?php 	echo $this->Form->hidden('getavg',array('id'=>'getAvgAmt_'.$cntCol,'name' => 'getAvgAmt','value'=>$getAvgAmt));
			echo $this->Form->hidden('month_avg_amt',array('id'=>'monthAvgAmt_'.$cntCol,'name' => 'Income[month_avg_amt][]','value'=>$getAvgAmtValue));
		?>
		<td width="12%" align="center" valign="top" style="text-align: center; min-width: 150px;border-right:2px solid #000000;" id="totalperDayIncome_<?php echo $cntCol;?>"><?php 
					$getAvgPerDay=($getAvgAmtValue/30);
					$getAvgPerDayFormatNumber = number_format($getAvgPerDay, 2, '.', '');
					echo $getAvgPerDayFormatNumber;
					$getAvgPerDayArr[$cnt]=$getAvgPerDayFormatNumber;?></td>
					<?php echo $this->Form->hidden('month_avg_per_day',array('id'=>'monthavgperday_'.$cntCol,'class'=>'monthavgperday','name' => 'Income[month_avg_per_day][]','value'=>$getAvgPerDayFormatNumber));
					?>
		</tr>
	<?php }
		 $cnt++;
		$cntCol++;
		} ?>

</table>
<table width="100%" cellpadding="0" cellspacing="2" border="0" 	 ><!-- style="border-bottom:solid 10px #E7EEEF;" -->
<tr>
<td colspan="8">
</td>
</tr>
<tr>	
<td align="right" width="69%"><strong>TOTAL PER DAY INCOME</strong></td>
<td style="border: 2px solid #000000;text-align:center;font-weight:bold;" width="10%" id="totalperDayIncomeval"><?php $getTotalPerDayExp=array_sum($getAvgPerDayArr);
					$getAvgAmtTotalFormatNumber = number_format($getTotalPerDayExp, 2, '.', '');
					echo $getAvgAmtTotalFormatNumber;
					?> 
</td>
<?php echo $this->Form->hidden('total_per_day_income',array('id'=>'total_per_day_income','name' => 'total_per_day_income','value'=>$getAvgAmtTotalFormatNumber));?>

</tr>
<tr>
<td colspan="8">
</td>
</tr>
<tr>
<td colspan="7"><?php echo $this->Form->textarea('comment',array('id'=>'comment','style'=>"width:500px;",'name'=>'comment','placeholder'=>'Comment'));?>
</td>
</tr>
<tr>
<td colspan="8"><?php echo $this->Form->submit(__('APPROVE'),array('id'=>'approvesubmit','class'=>'blueBtn','style'=>'float:right; width:150px; margin: 0 10px 0 0;'));?></td>
</tr>
</table>
<?php echo $this->Form->end();?>

<div class="clr ht5"></div>
<?php }else{?>
<div style="text-align:center;color:#FF0000;"><strong><?php echo "No Record Found";?></strong>
</div>
<?php } ?>
<div class="inner_title">
	<h3 style="float: left;">Incomes List</h3>
</div>

<div class="clr ht5"></div>
<?php if(!empty($getIncomeAllData)){?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" 	class="tabularForm" id="content-list1"><!-- style="border-bottom:solid 10px #E7EEEF;" -->
	<tr> 
	<th width="1%" align="center" valign="top" style="text-align: left;">Sr.No.</th>
	<th width="12%" align="center" valign="top" style="text-align: center;">Date</th>
	<th width="6%" align="center" valign="top" style="text-align: center;">Action</th>	
	<th width="12%" align="center" valign="top" style="text-align: center;">Comment</th>		
	</tr>  
	<?php foreach($getIncomeAllData as $key=>$getIncomeAllDatas){
	$getFullArr=unserialize($getIncomeAllDatas['Income']['acc_name_all_amt']);
			$getArrKey=array_keys($getFullArr['Income']);		
		unset($getArrKey['0']);			
		$getArrKey1 = array_pop($getArrKey);
		$getArrKey2 = array_pop($getArrKey);?>
<tr>
<td><?php echo $key+1;?></td>
<td style="text-align: center;"><?php foreach($getArrKey as $keyMonth=>$getArrKeys){ ?>
			<strong><?php echo $getArrKeys;?></strong><?php echo ",";
		}
		echo $getIncomeAllDatas['Income']['start_date'];
	?>
</td>
<td align="center" valign="top" style="text-align: center;">
<?php	echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Income', true),'title' => __('View Income', true))),array('controller'=>'HR','action' => 'view_income',$getIncomeAllDatas['Income']['id']), array('escape' => false));
		 echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('controller'=>'HR','action' => 'delete_income', $getIncomeAllDatas['Income']['id']), array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));
?>
</td>
<td align="center" valign="top" style="text-align: center;" id="commentLabel_<?php echo $key;?>" class="commentCls"><span id="CommentLbl_<?php echo $key;?>"  class="commentLblCls"><?php 
if(empty($getIncomeAllDatas['Income']['comment'])){
	$getIncomeAllDatas['Income']['comment']="-";
}
echo $getIncomeAllDatas['Income']['comment'];?></span>
<?php echo $this->Form->input('comment_txt',array('id'=>'commentInTxt_'.$key,'style'=>"width:500px;display:none;",'name'=>'comment_txt','class'=>'commentTxtCls','label'=>false));
			echo $this->Form->hidden('rec_id',array('id'=>'recId_'.$key,'style'=>"width:500px;",'name'=>'rec_id','value'=>$getIncomeAllDatas['Income']['id']));?>
<div id="ShowCommMsg"></div>
			</td>
</tr>
<?php } ?>
</table>
<?php }else{?>
<div style="text-align:center;color:#FF0000;"><strong><?php echo "No Record Found";?></strong>
</div>
<?php }?>
