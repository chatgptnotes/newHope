<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html moznomarginboxes mozdisallowselectionprint>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php //$hospital_details = $this->General->billingHeader($this->Session->read('locationid'));?>
<?php //echo $this->Html->charset(); ?>

	<?php echo $this->Html->css('internal_style.css');?> 
	<style>
	body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;}
	.heading{font-weight:bold; padding-bottom:10px; font-size:19px; text-decoration:underline;}
	.headBorder{border:1px solid #ccc; padding:3px 0 15px 3px;}
	.title{font-size:10px; text-decoration:underline; font-weight:bold; padding-bottom:10px;color:#000;}
	input, textarea{border:1px solid #999999; padding:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.tbl .totalPrice{font-size:10px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
	.tabularForm td{background:none;}
	@media print {

  		#printButton{display:none;}
    }
    .bor_right{border-left:1px solid #000;}
    .border{border-top:1px solid #000 !important;border-bottom:1px solid #000 !important;}
	/*.tabularForm {
	    background: none repeat scroll 0 0 #d2ebf2 !important;
		}*/
.tabularForm td {
		background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
		 padding: 3px 8px;
	}
	.tabularForm {
    background: #000000 none repeat scroll 0 0 !important;
}
.topics tr { line-height: 20px; }
.borderBott{
	border-bottom:1px dashed #494949;
}
.borderRight{
	border-right:1px dashed #494949;
}
input {
    border: medium none;
}
input:focus, select:focus, textarea:focus
</style> 
 
</head>
<body style="background:none;width:98%;margin:auto;">
<table align="center" width="40%">
		<tr>
			<td align="right">
			<div id="printButton">
			  <?php echo $this->Html->link(__('Print', true),'javascript void(0)', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();')); ?>
			 </div>
		 	</td>
		</tr>	
</table>	
<?php //echo $this->Form->create('',array('url'=>array('action'=>'saveRtgs'),'id'=>'saveRtgsid'));
//$getTotalAmt=$paymentEntry['VoucherPayment']['paid_amount']+$hrDetails['HrDetail']['rtgs_charges'];?>
<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" class="topics">
<tr>
<td valign="top" width="20%" align="left" class="borderRight"> 

<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" class="topics">
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Counter Foil</td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:12px;"><strong><?php echo $this->Html->image('SBI.jpg',
	   				array('escape' => false));?>&nbsp;&nbsp;State Bank of India</strong></td>
</tr>

<tr>
<td valign="top" style="text-align:left;font-size:10px;">Branch &nbsp;<?php if(!empty($hrDetails['HrDetail']['branch_name'])){
		  echo $hrDetails['HrDetail']['branch_name'];
		}else{
			echo " ................................";
		}?></td>
</tr>

<tr>
<td valign="top" style="text-align:left;font-size:10px;">Date &nbsp;<?php if(!empty($paymentEntry['VoucherPayment']['date'])){
		  echo $this->DateFormat->formatDate2Local($paymentEntry['VoucherPayment']['date'],Configure::read('date_format'),false); 
		}else{
			echo " ...................................";
		}?></td>
</tr>

<tr>
<td valign="top" style="text-align:left;font-size:10px;">Received  &nbsp;<?php if(!empty($paymentEntry['VoucherPayment']['paid_amount'])){
		  echo $this->Number->currency($paymentEntry['VoucherPayment']['paid_amount']); 
		}else{
			echo "Rs. ......................";
		}?></td>
</tr>

<tr>
<td valign="top" style="text-align:left;font-size:10px;">From ...................................</td>
</tr>

<tr>
<td valign="top" style="text-align:left;font-size:10px;">By Cheque No. ....................</td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Transfer for RTGS </td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">On ......................................</td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Bank <?php echo $hrDetails['HrDetail']['bank_name'];?></td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Branch <?php echo $hrDetails['HrDetail']['branch_name'];?></td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Favouring .............................</td>
</td>
</tr>

<tr>
<td valign="top" style="text-align:left;font-size:10px;">.............................................</td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">A/c No. <?php echo $hrDetails['HrDetail']['account_no'];?></td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">IFSC Code  <?php echo $hrDetails['HrDetail']['ifsc_code'];?></td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Amount  <?php if(!empty($paymentEntry['VoucherPayment']['paid_amount'])){
		  echo $this->Number->currency($paymentEntry['VoucherPayment']['paid_amount']);
	  }else{
		  echo "Rs. ...........................";
	  }?></td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Bank's</td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Charges Rs. ..........................   <?php /*if(!empty($hrDetails['HrDetail']['rtgs_charges'])){
		  echo $this->Number->currency($hrDetails['HrDetail']['rtgs_charges']);
	  }else{
		  echo "Rs. .................. ";
	  }*/?> </td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Total Rs.................................. <?php 
/*if(!empty($getTotalAmt)){
		  echo $this->Number->currency($getTotalAmt);
	  }else{
		  echo "Rs. ............................................ ";
	  }*/?></td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;"><?php 
	/*$getAmountWord=$this->RupeesToWords->no_to_words($getTotalAmt);	
	$getExpAmtWord=explode(" ",$getAmountWord);
	$getExpAmtWord=array_filter($getExpAmtWord);
	$getExpAmtWord=array_values($getExpAmtWord);
	
if(!empty($getTotalAmt)){
	echo $getExpAmtWord[0]." ".$getExpAmtWord[1];
}else{
	echo " Repees...............................................";
}*/?>Repees...................................</td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;"><?php /*if(!empty($getTotalAmt)){
	echo $getExpAmtWord[2]." ".$getExpAmtWord[3]." )";
}else{
	echo " ..................................................Only)";
}*/?>......................................Only)</td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;"></td>
</tr>
</table>
</td>

<td valign="top" width="2%" align="right">
</td> 

<td valign="top" width="78%" align="right">
<table border="0" cellpadding="0" cellspacing="0" align="right" width="100%" class="topics">
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Item Code No. ..................</td>
</tr>
<tr>
<td valign="top" style="text-align:letf;font-size:16px;padding-left:150px;"><strong>Application for RTGS Remittance</strong></td>
</tr>

<tr>
<td valign="top" style="text-align:left;font-size:14px;"><strong><?php echo $this->Html->image('SBI.jpg',
	   				array('escape' => false));?>&nbsp;&nbsp;State Bank of India</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:10px;">Date :<?php if(!empty($paymentEntry['VoucherPayment']['date'])){
		  echo $this->DateFormat->formatDate2Local($paymentEntry['VoucherPayment']['date'],Configure::read('date_format'),false); 
		}else{
			echo "...................................";
		}?></span></td>
</tr>

<tr>
<td valign="top" style="text-align:left;font-size:10px;padding-left:15px;">Branch (Code.............................).</td>
</tr>

<tr>
<td valign="top" style="text-align:left;font-size:10px;">Please remit the sum of &nbsp;&nbsp; <?php if(!empty($paymentEntry['VoucherPayment']['paid_amount'])){
		  echo $this->Number->currency($paymentEntry['VoucherPayment']['paid_amount']);
	  }else{
		  echo "Rs. ..........................................................................(";
	  }?>
<?php if(!empty($paymentEntry['VoucherPayment']['paid_amount'])){
	echo "  &nbsp;&nbsp;&nbsp;&nbsp;(".$this->RupeesToWords->no_to_words($paymentEntry['VoucherPayment']['paid_amount']).")";
}else{
	echo "Rs. .....................................only)";
}?></td>
</tr>

<tr>
<td valign="top" style="text-align:left;font-size:10px;">As per details below by debiting my/our account No.  35220879896</td>
</tr>

<tr>
<td valign="top" style="text-align:left;font-size:10px;">For the total amount including your charges</td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Name of the beneficiary &nbsp;&nbsp; <?php if(!empty($paymentEntry['Account']['name'])){
	echo ucwords($paymentEntry['Account']['name']);
}else{
	echo " .................................................................................................................................";
}?></td>
</tr>

<tr>
<td valign="top" style="text-align:left;font-size:10px;">Destination Bank's name &nbsp;&nbsp;<?php 
if(!empty($hrDetails['HrDetail']['branch_name'])){
	echo ucwords($hrDetails['HrDetail']['bank_name']);
}else{
	echo "................................................................................................................................";
}?></td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Branch&nbsp;&nbsp;
<?php if(!empty($hrDetails['HrDetail']['branch_name'])){
		  echo $hrDetails['HrDetail']['branch_name']."  ";
	  }else{
		  echo " .....................................................................";
	  }?> &nbsp;&nbsp;IFSC Code &nbsp;&nbsp;<?php if(!empty($hrDetails['HrDetail']['ifsc_code'])){
		  echo $hrDetails['HrDetail']['ifsc_code'];
	  }else{
		  echo "...............................................................";
	  }?> </td>
</tr>
<tr>

<td valign="top" style="text-align:left;font-size:10px;">
<table border="0" cellpadding="0" cellspacing="0"  align="left" width="100%">
<tr>
<td valign="top" style="text-align:left;font-size:10px;" width="11%">Account No. <?php $accountNoSplit = str_split($hrDetails['HrDetail']['account_no']);
?>
</td>
<td style="text-align:left;" valign="top" width="89%">
<table border="1" cellpadding="0" cellspacing="0">
<tr>
<td width="30px" height="20px" style="padding-left: 2px;"><?php echo $accountNoSplit[0];?>
</td>
<td width="30px" height="20px" style="padding-left: 2px;"><?php echo $accountNoSplit[1];?>
</td >
<td width="30px" height="20px" style="padding-left: 2px;"><?php echo $accountNoSplit[2];?>
</td>
<td width="30px" height="20px" style="padding-left: 2px;"><?php echo $accountNoSplit[3];?>
</td>
<td width="30px" height="20px" style="padding-left: 2px;"><?php echo $accountNoSplit[4];?>
</td>
<td width="30px" height="20px" style="padding-left: 2px;"><?php echo $accountNoSplit[5];?>
</td>
<td width="30px" height="20px" style="padding-left: 2px;"><?php echo $accountNoSplit[6];?>
</td>
<td width="30px" height="20px" style="padding-left: 2px;"><?php echo $accountNoSplit[7];?>
</td>
<td width="30px" height="20px" style="padding-left: 2px;"><?php echo $accountNoSplit[8];?>
</td>
<td width="30px" height="20px" style="padding-left: 2px;"><?php echo $accountNoSplit[9];?>
</td>
<td width="30px" height="20px" style="padding-left: 2px;"><?php echo $accountNoSplit[10];?>
</td>
<td width="30px" height="20px" style="padding-left: 2px;"><?php echo $accountNoSplit[11];?>
</td>
</tr>
</table>
</td>
</tr>
</table>

</td>
</tr>

<tr>
<td valign="top" style="text-align:left;font-size:10px;">Amount (in words)&nbsp;&nbsp; <?php if(!empty($paymentEntry['VoucherPayment']['paid_amount'])){
	echo $this->RupeesToWords->no_to_words($paymentEntry['VoucherPayment']['paid_amount']);
}else{
	echo "Rs. .......................................................................................................................................";
}?></td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Amount (in figure) &nbsp;&nbsp;
<?php if(!empty($paymentEntry['VoucherPayment']['paid_amount'])){
		  echo $this->Number->currency($paymentEntry['VoucherPayment']['paid_amount']);
	  }else{
		  echo ".........................................................................................................................................";
	  }?></td>
</tr>

<tr>
<td valign="top" style="text-align:left;font-size:10px;" ><span style="float:left;">Charges Rs. ....................................................................................................................................................</span>	  	
<?php /*if($print){
	if(!empty($hrDetails['HrDetail']['rtgs_charges'])){
		echo $this->Number->currency($hrDetails['HrDetail']['rtgs_charges']);
	}else{
	 echo "
..............................................................................................................................................................................................................";
	}
}else{?>
<span class="borderBott"> <?php echo $this->Form->input('HrDetail.rtgs_charges', array('type'=>'text','label'=>false,'id' => 'rtgs_charges','class'=>'textBoxExpnd','div'=>false,'style'=>'width:91px;height:23px;','value'=>$hrDetails['HrDetail']['rtgs_charges']));
echo $this->Form->hidden('HrDetail.id', array('label'=>false,'id' => 'HrdetailsID','class'=>'textBoxExpnd','div'=>false,'value'=>$hrDetails['HrDetail']['id']));
echo $this->Form->hidden('HrDetail.type_of_user', array('label'=>false,'id' => 'type_of_user','class'=>'textBoxExpnd','div'=>false,'value'=>$hrDetails['HrDetail']['type_of_user']));
echo $this->Form->hidden('HrDetail.user_id', array('label'=>false,'id' => 'user_id','class'=>'textBoxExpnd','div'=>false,'value'=>$hrDetails['HrDetail']['user_id']));
echo $this->Form->hidden('VoucherPayment.id', array('label'=>false,'id' => 'user_id','class'=>'textBoxExpnd','div'=>false,'value'=>$paymentEntry['VoucherPayment']['id']));?>
	 </span>
	<?php }*/?>
	 </td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Total  Rs. ............................................................................................................................................................. <?php /*if(!empty($getTotalAmt)){
		  echo $this->Number->currency($getTotalAmt);
	  }else{
		  echo " Rs. .............................................................................................................................................................................................................................. ";
	  }*/?> </td>
</tr><tr>
<td valign="top" style="text-align:left;font-size:10px;">Date of Transfer/Cash &nbsp;&nbsp;<?php echo $this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'),false); ?>&nbsp;&nbsp; Name of Applicant &nbsp;DRM Hope hospital pvt.ltd</td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">Amount&nbsp;&nbsp; <?php if(!empty($paymentEntry['VoucherPayment']['paid_amount'])){
		  echo $this->Number->currency($paymentEntry['VoucherPayment']['paid_amount']);
	  }else{
		  echo "Rs. .............................................";
	  }?>&nbsp;&nbsp;Address ......................................................................................</td>
</tr><tr>
<td valign="top" style="text-align:left;font-size:10px;">Scroll No. .................................................................................. Tel ...................................................</td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">UTR No. ...............................................</td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;"></td>
</tr>
<tr>
<td valign="top" style="text-align:left;font-size:10px;">(Please see conditions on the reverse)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>  Signature .................................</strong></td>
</tr>
</table>
</td>
</tr>
<!--<tr>
<td colspan="4">
<?php //if($print){?>
<table align="center" width="40%">
		<tr>
			<td align="left">
			<div id="printButton">
			  <?php echo $this->Html->link(__('Print', true),'javascript void(0)', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();')); ?>
			 </div>
		 	</td>
		</tr>	
</table>-->
<?php //}else{?>
<!--<table align="center" border="0" width="100%">
	<tr>
         <td align="center"><div class="btns"><input name="submit" type="submit" value="Submit & Print" class="blueBtn"/></div></td>
	</tr>
	</table>
<?php //}?>
</td>
</tr>-->
</table>

</body>
</html>
<?php echo $this->Form->end();?>

<script>
 /*$(document).ready(function () {
	 $('#rtgs_charges').focus();
  });*/
</script>