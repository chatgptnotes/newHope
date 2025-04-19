
<div class="inner_title" style="margin-top: 10px;">
	<h3 style="float: left;"></h3>
	<span><?php echo $this->Html->link(__('Back', true),array('controller' => 'HR', 'action' => 'expense_main'), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px'));
		?></span>
</div>
<div class="clr ht5"></div>

<table width="100%" cellpadding="0" cellspacing="0" border="0"
	 align="center" style="padding: 12px;margin-top: 5px">
<tr>
<td width="12%"></td>
<td width="63%" class="form_lables" align="center" style="border-top:2px solid #4C85AA;border-bottom:2px solid #4C85AA;color:#FF0000;" bgcolor="#d2ebf2"><strong><?php 
$getFullArr=unserialize($getExpenseData['Expense']['acc_name_all_amt']);
			$getArrKey=array_keys($getFullArr['Expense']);		
		unset($getArrKey['0']);			
		$getArrKey1 = array_pop($getArrKey);
		$getArrKey2 = array_pop($getArrKey);	
$countOfColums=count($getArrKey);
echo __('Expenses For Last',true)." ".$countOfColums." ".__('Months',true); //52 25?></strong>
</td>	
<td width="24%">
</td>
</tr>
</table>
<div class="clr ht5"></div>
<?php echo $this->Form->create('',array('type' => 'file',
		'url' => array('controller' => 'HR', 'action' => 'save_expense'),'class'=>'manage','style'=>array("float"=>"left","width"=>"100%"),'id'=>'expenseFrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
																								    )
			));	 
?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" 	class="tabularForm" id="content-list"><!-- style="border-bottom:solid 10px #E7EEEF;" -->
	<tr> 
	<th width="12%" align="center" valign="top" style="text-align: center;">Account Name</th>
	<?php 	foreach($getArrKey as $keyMonth=>$getArrKeys){ ?>
		<th width="12%" align="center" valign="top" style="text-align: center; min-width: 150px;color:#FF0000 ! important;"> <?php  echo $getArrKeys;?></th> 
		<?php } ?>
		<th width="12%" align="center" valign="top" style="text-align: center; min-width: 150px;"><?php echo __('Last',true)." ".$countOfColums." ".__('Months Average',true);?></th>
		<th width="12%" align="center" valign="top" style="text-align: center; min-width: 150px;">PER DAY EXPENSE</th>		
	</tr>  

	<?php 	
$cnt=0;
$count=count($getFullArr['Expense']['acc_name']);
for($k=0;$k<$count;$k++){	

?>
<tr>
<td width="12%" align="center" valign="top" style="text-align: center; min-width: 150px;border-right:2px solid #000000;"><?php echo $getFullArr['Expense']['acc_name'][$cnt];	?>
</td>
<?php	foreach($getArrKey as $keyMonth1=>$getArrKeys1){?>
		<td width="12%" align="center" valign="top" style="text-align: center; min-width: 150px;border-right:2px solid #000000;">
		<?php echo $getFullArr['Expense'][$getArrKeys1][$cnt]; ?></td>
		<?php }	?>
		
		<td width="12%" align="center" valign="top" style="text-align: center; min-width: 150px;border-right:2px solid #000000;"><?php 		
					echo $getFullArr['Expense']['month_avg_amt'][$cnt];	?></td>
		<td width="12%" align="center" valign="top" style="text-align: center; min-width: 150px;border-right:2px solid #000000;"><?php 
					
					echo $getFullArr['Expense']['month_avg_per_day'][$cnt];	?>
			</td>
		</tr>
	<?php $cnt++;
		
		} ?>

</table>
<table width="100%" cellpadding="0" cellspacing="2" border="0" 	 ><!-- style="border-bottom:solid 10px #E7EEEF;" -->
<tr>
<td colspan="8">
</td>
</tr>
<tr>	
<td>
</td>
<td align="right" width="69%"><strong>TOTAL PER DAY EXPENSE</strong></td>
<td style="border: 2px solid #000000;text-align:center;" width="10%"><?php echo $getExpenseData['Expense']['total_per_day_expense'];?> 
</td>
</tr>
<?php if(!empty($getExpenseData['Expense']['comment'])){?>
<tr>
<td><strong>Comment:</strong></td>
<td><?php echo $getExpenseData['Expense']['comment'];?></td>
<td>
</td>
<td>
</td>
</tr>
<?php } ?>
</table>
<?php echo $this->Form->end();?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
