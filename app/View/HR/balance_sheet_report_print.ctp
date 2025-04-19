 
<style>
@media print {
	@page{     
 		size: portrait;
		} 
	#printButton {
		display: none;
	}
	
	#hideFromPage{
	display: none;
	}
}
.daredevel-tree li span.daredevel-tree-anchor {
    cursor: pointer !important;   
}
.daredevel-tree li span.daredevel-tree-anchor:hover {
    color: #76D6FF ;
  background-color: #FFFF00 ;
    
}
.prntDiv1 {
	float: left;
	padding: 0 5px 0 0;
	width: 70%;
}
.mainParentCls{
	font-size: 14px !important;
	font-weight: bold;
	/*color:#4d90fe;*/
}
/*.mainParentCls:hover { 
	 font-weight: bold;
	 color: black ;
	 background-color: #FFFF00 !important;
}*/
.parentCls{
	font-style: italic !important;
	font-size: 14px !important;
	font-weight: lighter;
	/*color:#3185AC;*/
}
/*.parentCls:hover { 
	 font-weight: bold;
	 color: black ;
	 background-color: #FFFF00 !important;
}*/
.subchldDiv1 {
	float: left;
	padding: 0 6px 0 0;
	width: 75%;
}
.subchildCls{
	font-size: 13px !important;
	font-weight: normal;	
}
/*.subchildCls:hover {
    color: black !important;
  	background-color: #FFFF00 !important;
  	font-weight: bold;
}*/
body {
	margin: 10px 0 0 0;
	padding: 0;
	font-family: Arial, Helvetica, sans-serif !important;
	font-size: 10px !important;
	/*color: #000000;*/
	/*background-color: #F0F0F0;*/
}
.ui-widget-content {
    background: url("../img/ui-bg_flat_75_ffffff_40x100.png") repeat-x scroll 50% 50% #ffffff;
    border: none;
    color: #fff;
}
input,textarea {
	border: 1px solid #999999;
	padding: none !important;
}
.ui-widget-content {
	color: #000 !important;
}
ul {
	padding-left: 20px !important;
}
.leaf {
	clear: both;
}

.expanded {
	clear: both;
}
.collapsed {
	clear: both;
}
#ui-datepicker-div{
		width: 190px;
}
li {
    list-style-type: none !important;    
}

</style>
<?php 
	ksort($accountingGroupListExpense);ksort($recurciveBalParent);ksort($recurciveBalChild);
	$getExpense=$this->General->multilevelMenu(0,$accountingGroupListExpense, $InnerArr,$getAccountingGroupName,$groupeExpIncData,Configure::read('expense_label'),$recurciveBalParentExpense,$recurciveBalChildExpense);

	ksort($accountingGroupListIndirectExpense);ksort($recurciveBalParent);ksort($recurciveBalChild);
	$getIndirectExpense=$this->General->multilevelMenu(0,$accountingGroupListIndirectExpense, $InnerArr,$getAccountingGroupName,$groupeExpIncData,Configure::read('indirect_expenses_label'),$recurciveBalParentExpense,$recurciveBalChildExpense);

	ksort($accountingGroupListIncome);ksort($recurciveBalParent);ksort($recurciveBalChild);		
	$getIncome=$this->General->multilevelMenu(0,$accountingGroupListIncome, $InnerArr,$getAccountingGroupName,$groupeExpIncData,Configure::read('income_label'),$recurciveBalParent,$recurciveBalChild);
	//debug($getIncome[1]);
	ksort($accountingGroupListIndireactIncome);ksort($recurciveBalParent);ksort($recurciveBalChild);
	$getIndirectIncome=$this->General->multilevelMenu(0,$accountingGroupListIndireactIncome, $InnerArr,$getAccountingGroupName,$groupeExpIncData,Configure::read('indirect_income_label'),$recurciveBalParent,$recurciveBalChild);	
	
	//BOF-Calculate Gross Amount
	#debug($getExpense[1]);
	#debug($getIncome[1]);
	$getGrpSumExp=(int)$getExpense[1]/*+10000*/; ////10000-For Opening Stock
	$getGrpSumInc=(int)$getIncome[1]/*+10000*/;////10000-For Closing Stock
	#debug($getGrpSumExp);
	#debug($getGrpSumInc);
	$getGross=(int)$getGrpSumInc-$getGrpSumExp;
	//debug($getGross);
	if($getGross<0){
			//If  Gross Loss
			$getProfitLossFlag=true;			
			$getGrossLoss=abs($getGross);//**If  Gross Loss	ie amount is minus so showing plus					
			///BOF-TOTAL VALUE OF EXPENSE SIDE//
			$getTotalExpExceptIndirExp=(int)$getGross+$getGrpSumInc;				
			///BOF-TOTAL VALUE OF INCOME SIDE//
			/*if($getGrossLoss<0){
				$getGrossLoss1=abs($getGrossLoss);
			}*/
			$getTotalIncExceptIndirInc=(int)$getGrpSumInc;
			//$getTotalIncExceptIndirInc=(int)$getGrossLoss+$getGrpSumInc;
			if($getTotalExpExceptIndirExp>$getTotalIncExceptIndirInc){
				$getTotalLossExpExceptIndirExpInc1=$getTotalExpExceptIndirExp;
			}else{
				$getTotalLossExpExceptIndirExpInc1=$getTotalIncExceptIndirInc;
			}
		}else{
			//If  Gross Profit				
			$getProfitLossFlag=false;
			$getGrossProfit=(int)$getGross; //If  Gross Profit
			///BOF-TOTAL VALUE OF EXPENSE SIDE//			
			$getTotalExpExceptIndirExp=(int)$getGrossProfit+$getGrpSumExp;						
			///BOF-TOTAL VALUE OF INCOME SIDE//
			$getTotalIncExceptIndirInc=(int)$getGrpSumInc;			
			if($getTotalExpExceptIndirExp>$getTotalIncExceptIndirInc){
				$getTotalProfitExpExceptIndirExpInc1=$getTotalExpExceptIndirExp;
			}else{
				$getTotalProfitExpExceptIndirExpInc1=$getTotalIncExceptIndirInc;
			}				
		}
		//////EOF-Calculate Gross Amount///////	
		
	//BOF-Calculate Net Amount
		if($getGross<0){
			$getNetLossFlag=true; //if Net Loss
			//$getGrossLoss2=abs($getGrossLoss);
			#debug($getGrossLoss);
			#debug($getIndirectExpense[1]);
			#debug($getIndirectIncome[1]);
			$getNet=(int)$getGross+$getIndirectExpense[1]-$getIndirectIncome[1];	
			//debug($getNet);	
			$getNetLoss=$getNet;				
					
			//////BOF-Calculate Total Expenses///////
			$getTotalExpense=(int)$getNet+$getIndirectIncome[1];	
			//////BOF-Calculate Total Incomes///////
			$getTotalIncomes=(int)$getGross+$getIndirectExpense[1];
		}else{
			$getNetLossFlag=false; //if Net Profit			
			$getNet=(int)$getGross-$getIndirectExpense[1]+$getIndirectIncome[1];
			$getNetProfit=$getNet;				
			//////BOF-Calculate Total Expenses//////
			$getTotalExpense=(int)$getNetProfit+$getIndirectExpense[1];				
			//////BOF-Calculate Total Incomes///////			
			$getTotalIncomes=(int)$getGrossProfit+$getIndirectIncome[1];
		}
		//BOF-Calculate Net Amount
	?>

<div class="clr ht5"></div>
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-top:solid 1px #000000;border-left:solid 1px #000000;border-right:solid 1px #000000;">
<tr>
	<td colspan="4" align="right">
	<div id="printButton">
	  <?php echo $this->Html->link(__('Print', true),'javascript:void(0)', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();')); ?>
	 </div>
 	</td>
</tr>
<tr> 
	<td  style="font-weight:bold;padding-left:20px;font-size:16px">Particulars</td>
	<td  style="border-right:solid 1px #000000;font-weight:bold;float:right;font-size:16px" ><?php echo $getLocName;?></br></td>
	<td style="font-weight:bold;padding-left:20px;font-size:16px">Particulars</td>
	<td style="font-weight:bold;float:right;font-size:16px"><?php echo $getLocName;?></br></td>
</tr>
<?php $fromdata= strtotime($this->DateFormat->formatDate2STD($from,Configure::read('date_format')));
$todata= strtotime($this->DateFormat->formatDate2STD($to,Configure::read('date_format')));?>
<tr> 
	<td  style="font-weight:bold;padding-left:20px;"></td>
	<td  style="border-right:solid 1px #000000;font-weight:bold;float:right;" ><?php   
	echo date('d-M-Y', $fromdata)." to ".date('d-M-Y', $todata);?></td>
	<td style="font-weight:bold;padding-left:20px;"></td>
	<td style="font-weight:bold;float:right;"><?php echo date('d-M-Y', $fromdata)." to ".date('d-M-Y', $todata);?></td>
</tr> 

<tr> 
	<td style="border-top:solid 1px #000000;border-right:solid 1px #000000;" width="50%" valign="top" colspan="2">
	<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding-top:20px;">
	<!-- <tr bgcolor="#a7a7a8" >
		<td style="padding-left:20px;font-weight:900;color:#FFFFFF;" bgcolor="#a7a7a8">Opening Stock</td>
		<td style="padding-right:3px;font-weight:900;float:right;color:#FFFFFF;" bgcolor="#a7a7a8"><?php echo "10,000.00";?></td>
	</tr> -->
<tr>
<td width="100%" colspan="2" valign="top">

<?php /**********************EXPENSE**/ ?>
<div id="tree" style="width: 100%;"><?php 

echo $getExpense[0];?>
</div>
<?php /****************Eof-First Treeview******/ ?>
</td>
</tr>
<?php  if($getProfitLossFlag=='0'){?>
<tr style="padding-top:50px;"> 
	<td style="font-weight:lighter;font-style:italic;padding-top:5px;color:#008000;padding-left:20px;font-size: 15px !important;"><?php echo "Gross Profit c/o";  ?></td>
	<td style="font-weight:900;float:right;padding-top:5px;color:#008000;font-size: 15px !important;"><?php $getGrossProfit1= number_format($getGrossProfit, 2, '.', ',');
	echo $getGrossProfit1;  ?></td>
</tr>
<tr>
<td style="font-weight:bold;padding-top:5px;"></td>
<td style="font-weight:900;border-top:solid 1px #000000;border-bottom:solid 1px #000000;float:right;font-size: 15px !important;"><?php $getTotalProfitExpExceptIndirExpInc11 = number_format($getTotalProfitExpExceptIndirExpInc1, 2, '.', ',');
echo $getTotalProfitExpExceptIndirExpInc11; ?>
</td>
</tr>
<?php  } ?>



<?php if($getProfitLossFlag){?>
<tr>
<td style="font-weight:bold;padding-top:5px;"></td>
<td style="font-weight:900;border-top:solid 1px #000000;border-bottom:solid 1px #000000;float:right;font-size: 15px !important;"><?php 
$getTotalLossExpExceptIndirExpInc11 = number_format($getTotalLossExpExceptIndirExpInc1, 2, '.', ',');
echo $getTotalLossExpExceptIndirExpInc11; ?>
</td>
</tr>
<tr> 
<td style="font-weight:lighter;font-style:italic;padding-top:5px;color:#D9261C;padding-left:20px;font-size: 15px !important;"><?php echo "Gross Loss b/f";  ?></td>
<td style="font-weight:900;float:right;padding-top:5px;color:#D9261C;font-size: 15px !important;"><?php 
$getGrossLoss1=abs($getGrossLoss);
$getGrossLoss11= number_format($getGrossLoss1, 2, '.', ',');
echo $getGrossLoss11;  ?></td>
</tr>
<?php  } ?>


<tr>
<td colspan="2" valign="top"><?php /***********Indirect Expense*************/ ?>
<div id="treeIndirExp" style="width: 100%;">
<?php echo $getIndirectExpense[0];?>
</div>
<?php /*****************/ ?>
</td>
</tr>
<?php if($getNetLossFlag=='0'){?>
<tr>
<td style="font-weight:lighter;font-style:italic;padding-top:5px;color:#008000;padding-left:20px;"><?php echo "Nett Profit";  ?></td>
<td style="font-weight:900;float:right;padding-top:5px;color:#008000;"><?php $getNetProfit= number_format($getNetProfit, 2, '.', ',');
		echo $getNetProfit;   ?>
</td>
</tr>
<?php }?>
</table>
</td>
<td width="50%" colspan="2" style="border-top:solid 1px #000000;" valign="top">
<table width="100%" cellpadding="0" cellspacing="0" border="0" >
<tr>
<td width="100%" colspan="2" valign="top">

<?php /************ INCOME************/ ?>
<div id="treeIncome" style="width: 100%;">
<?php echo $getIncome[0];?>	
</div>

<?php /****************Eof-First Treeview Income******/ ?>
</td>
</tr>
<tr>
<!-- <td style="font-weight:900;padding-top:5px;padding-left:20px;font-size: 15px !important;">Closing Stock</td>
<td style="font-weight:900;float:right;font-size: 15px !important;"><?php echo "10,000.00";?></td> -->
</tr>

<?php  if($getProfitLossFlag){?>
<tr> 
<td style="font-weight:lighter;font-style:italic;padding-top:5px;color:#d9261c;padding-left:20px;font-size: 15px !important;"><?php echo "Gross Loss c/o";  ?></td>
<td style="font-weight:900;float:right;color:#d9261c;font-size: 15px !important;"><?php $getGrossLoss1=abs($getGrossLoss);
$getGrossLoss11= number_format($getGrossLoss1, 2, '.', ',');
echo $getGrossLoss11;  ?></td>
</tr>

<tr>
<td style="font-weight:bold;padding-top:5px;font-size: 15px !important;"></td>
<td style="font-weight:900;border-top:solid 1px #000000;border-bottom:solid 1px #000000;float:right;font-size: 15px !important;"><?php $getTotalLossExpExceptIndirExpInc12 = number_format($getTotalLossExpExceptIndirExpInc1, 2, '.', ',');
echo $getTotalLossExpExceptIndirExpInc12; ?>
</td>
</tr>

<?php  } ?>

<?php  if($getProfitLossFlag=='0'){?>
<tr>
<td style="font-weight:bold;padding-top:5px;font-size: 15px !important;"></td>
<td style="font-weight:900;border-top:solid 1px #000000;border-bottom:solid 1px #000000;float:right;font-size: 15px !important;"><?php $getTotalProfitExpExceptIndirExpInc12 = number_format($getTotalProfitExpExceptIndirExpInc1, 2, '.', ',');
echo $getTotalProfitExpExceptIndirExpInc12; ?>
</td>
</tr>

<tr> 
<td style="font-weight:lighter;font-style:italic;padding-top:5px;color:#008000;padding-left:20px;font-size: 15px !important;"><?php echo "Gross Profit b/f";  ?></td>
<td style="font-weight:900;float:right;color:#008000;font-size: 15px !important;"><?php $getGrossProfit2= number_format($getGrossProfit, 2, '.', ',');
echo $getGrossProfit2;  ?></td>
</tr>
<?php  } ?>



<tr>
<td colspan="2" valign="top"><?php /***********Indirect Income*************/ ?>
<div id="treeIndirIncome" style="width: 100%;">
<?php echo $getIndirectIncome[0];?>	
</div>
<?php  /*****************/ ?>
</td>
</tr>

<?php if($getNetLossFlag){?>
<tr>
<td style="font-weight:lighter;font-style:italic;padding-top:5px;color:#D9261C;padding-left:20px;font-size: 15px !important;"><?php echo "Nett Loss";  ?></td>
<td style="font-weight:900;float:right;padding-top:5px;color:#D9261C;font-size: 15px !important;"><?php $getNetLoss1=abs($getNetLoss);
$getNetLoss= number_format($getNetLoss1, 2, '.', ',');
		echo $getNetLoss;   ?>
</td>
</tr>
<?php }?>
</table>
</td>
</tr>

<tr>
<td></td>
<td></td>
</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-top:solid 1px #000000;border-bottom:solid 1px #000000;border-left:solid 1px #000000;border-right:solid 1px #000000;"><!-- style="border-bottom:solid 10px #E7EEEF;" -->
<tr> 
<td width="10%" style="font-weight:900;padding-left:20px;font-size: 15px !important;">Total</td>
<td width="40%" style="border-right:solid 1px #000000;font-weight:900;float:right;font-size: 15px !important;" align="right"><?php 
//$getTotalExpense=abs($getTotalExpense);
$getTotalExpense1= number_format($getTotalExpense, 2, '.', ',');
echo $getTotalExpense1;?></td>
<td width="25%" style="font-weight:900;padding-left:20px;font-size: 15px !important;">Total</td>
<td width="25%" style="font-weight:900;font-size: 15px !important;" align="right"><?php //$getTotalIncomes=abs($getTotalIncomes);
$getTotalIncomes1= number_format($getTotalIncomes, 2, '.', ',');
echo $getTotalIncomes1;?></td>
</tr>  
</table>
