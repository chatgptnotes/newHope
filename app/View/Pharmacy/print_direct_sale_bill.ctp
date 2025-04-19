<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" moznomarginboxes
	mozdisallowselectionprint>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true);

$website=$this->Session->read("website.instance");
if($website=='kanpur')
{
	$paddingTop="10px";
	$paddingLeft="4px";

	if($this->request->query['flag'] == 'without_header')
	{
		$paddingTop="25%";
	}
}
else
{
	$paddingTop="100px";
	$paddingLeft="0px";
}

?>
</title>
<?php echo $this->Html->css('internal_style.css');?>

<style>
body {
	margin: 10px 0 0 0;
	padding: 0;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #000000;
}

.heading {
	font-weight: bold;
	padding-bottom: 10px;
	font-size: 19px;
	text-decoration: underline;
}

.headBorder {
	border: 1px solid #ccc;
	padding: 3px 0 15px 3px;
}

.title {
	font-size: 14px;
	text-decoration: underline;
	font-weight: bold;
	padding-bottom: 10px;
	color: #000;
}

input,textarea {
	border: 1px solid #999999;
	padding: 5px;
}

.tbl {
	background: #CCCCCC;
}

.tbl td {
	background: #FFFFFF;
}

.tbl .totalPrice {
	font-size: 14px;
}

.adPrice {
	border: 1px solid #CCCCCC;
	border-top: 0px;
	padding: 3px;
}

.
.tabularForm td {
	background: none;
}

@media print {
	#printButton {
		display: none;
	}
}
</style>

</head>
<body style="background: none; width: 98%; margin: auto;">

	<?php /*if(!empty($directPharData['PharmacySalesBill']['discount'])){
if(strtolower($directPharData['PharmacySalesBill']['payment_category'])!='finalbill'){
	 		$directPharData['PharmacySalesBill']['amount']=$directPharData['PharmacySalesBill']['amount']+$directPharData['PharmacySalesBill']['discount'];
$receiptLabel='DISCOUNT';
}elseif(strtolower($directPharData['PharmacySalesBill']['payment_category'])=='finalbill' && $this->params->query['flag']!='discountAmount'){
			$directPharData['PharmacySalesBill']['amount']=$directPharData['PharmacySalesBill']['amount'];
}elseif($this->params->query['flag']='discountAmount'){
			$directPharData['PharmacySalesBill']['amount']=$directPharData['PharmacySalesBill']['discount'];
}
 }*/?>
	<!--
set padding to 50px to adjust print page with default header coming on page
	-->
	<table width="200" style="float: right">
		<tr>
			<td align="right">
				<div id="printButton">
					<?php 

					//echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));
					?>
				</div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	<?php 
	$website  = $this->Session->read('website.instance');
	if($website=='vadodara'){
	?>
	<table width="800">
		<tr>
			<td><div style="float: left">
					<?php echo  $this->Html->image('icons/MSA.jpg',array('width'=>100,'height'=>100)) ; ?>
				</div></td>
			<td><div style="float: right">
					<?php echo  $this->Html->image('icons/KCHRC.jpg',array('width'=>100,'height'=>100)) ; ?>
			   </div>
			</td>
		</tr>
	</table>
	<?php } ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="padding-top:<?php echo $paddingTop;?>; padding-left:<?php echo $paddingLeft;?>;">

		<!-- <tr>
		  	<td>&nbsp;</td>
		  	<?php //if($directPharData['PharmacySalesBill']['refund']==1){?>
		  	<td align="" valign="top" colspan="1" style="text-decoration:underline;letter-spacing: 0.2em;"><strong>REFUND RECEIPT</strong></td>
		  	<?php //}else{?>
		  	<td align="" valign="top" colspan="1" style="text-decoration:underline;letter-spacing: 0.2em;"><strong><?php //echo $receiptLabel?$receiptLabel:'';?> RECEIPT</strong></td>
		  	<?php //}?>
		  </tr> -->
		<tr>
			<td>&nbsp;</td>
		</tr>

		<tr>
			<?php  if($directPharData['PharmacySalesBill']['refund']==1){?>
			<td width="200">Refund To:</td>
			<?php }else{?>
			<td width="200">Received with thanks from :</td>
			<?php }?>
			<td><?php echo $directPharData['PharmacySalesBill']['customer_name'];?>
			</td>
		</tr>

		<tr>
			<td>The sum of :</td>
			<?php //debug($directPharData['PharmacySalesBill']['refund']);?>
			<td><?php  if($directPharData['PharmacySalesBill']['refund']==1){
				echo $this->RupeesToWords->no_to_words($directPharData['PharmacySalesBill']['paid_to_patient']);
			}else{
				  			echo $this->RupeesToWords->no_to_words($directPharData['PharmacySalesBill']['paid_amnt']);
						}?>
			</td>
		</tr>
		<tr>
			<td>By :</td>
			<td><?php
			echo $directPharData['PharmacySalesBill']['payment_mode'];?>
			</td>
		</tr>
		<?php if($website =='kanpur'){
			if($this->request->query['flag'] == 'roman_header' || $this->request->query['flag_roman'] == 'roman_header'){
					$display='none';
				}
		}else{
		    		$display='';
		       }
		  if($directPharData['PharmacySalesBill']['remark']){//if remark present thn show?>
		<tr style="display:<?php echo $display; ?>">
			<td>Remarks :</td>
			<td><?php echo $directPharData['PharmacySalesBill']['remark']; ?> <?php if($website == 'kanpur') echo "&nbsp;".$directPharData['PharmacySalesBill']['id']; ?>
			</td>
		</tr>
		<?php }?>
		<tr>
			<td>Date :</td>
			<td><?php echo $this->DateFormat->formatDate2Local($directPharData['PharmacySalesBill']['create_time'],Configure::read('date_format'),true); ?>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td><?php 
			if($directPharData['PharmacySalesBill']['discount'])
				echo __("Discount : ") .$directPharData['PharmacySalesBill']['discount'];
			?>
			</td>
		</tr>
		<tr>
			<td><?php 
			//	if($website !='kanpur'){ //--not for kanpur only  --yashwant
			if($directPharData['PharmacySalesBill']['refund']==1){
					echo $directPharData['PharmacySalesBill']['paid_to_patient']."/-";
				}else{
		  			echo $directPharData['PharmacySalesBill']['paid_amnt']."/-";
				}echo $this->Html->image('icons/rupee_symbol.png');
				//}
				?>
			</td>
		</tr>
		<tr>
			<td>Username :&nbsp;<strong><?php echo $directPharData['User']['first_name'].' '.$directPharData['User']['last_name']; ?>
			</strong>
			</td>
			<td style="float: right ;padding-right: 10%">Name & Sign of Patient
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Authorised Signatory</td>
			<!-- <td>Authorised Signatory</td> -->
		</tr>


	</table>

</body>
<script>
window.onload = function() { window.print(); }
</script>
</html>



