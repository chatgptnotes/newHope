<?php 
echo $this->Html->css(array('internal_style'));
  echo $this->Html->script(array('jquery.fancybox-1.3.4'));//jquery-1.9.1.js
  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));//,'internal_style.css'
 ?>

<style>
body{
font-size:13px;
}
.red td{
	background-color:antiquewhite !important;
}

.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
	}
	.tabularForm td {
		 background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
	    padding: 3px 8px;
	}

#msg {
    width: 180px;
    margin-left: 34%;
}
#fancybox-wrap{
height:400px !important;
}
#fancybox-content{
height:400px !important;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Patient Card', true).' ('.$userName['User']['full_name'].')'; ?>
	</h3>
</div> 
<?php //echo $this->Form->create('Voucher',array('id'=>'voucher','url'=>array('controller'=>'Accounting','action'=>'daily_collection','admin'=>false),));?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="100%" valign="top">
		<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
				<thead>
					<tr> 
						<th width="30%" align="center" valign="top">Patient Name</th> 
						<th width="18%" align="center" valign="top" style="text-align: center; ">Total Revenue</th> 
						<th width="18%" align="center" valign="top" style="text-align: center; ">Refund Amount</th> 
						<th width="15%" align="center" valign="top" style="text-align: center; ">Nett Amount</th> 
					</tr> 
				</thead>
				
				<tbody>
				<?php foreach($data as $key=> $userData) {
					if((count($userData['PatientCard']) == 0)){
						continue;
					}
					?>
					<tr id="<?php echo $userData['Person']['id']; ?>" class="idPatient">
					<input type="hidden" id="start_transaction_id_<?php echo $userData['Person']['id']; ?>" value="<?php echo $date.','.$userId?>">
						<td align="left" valign="top" style= "text-align: left;">
							<div style="padding-left:0px;padding-bottom:3px;">
								<?php echo $userData['Person']['full_name']; ?>
							</div>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
						<?php $amount = null?>
							<?php foreach ($userData['PatientCard'] as $key=> $dataArray){?>
								<?php if($dataArray['type'] == "deposit"){ 
									$amount += $dataArray['amount']; } ?>
							<?php }?>
							<?php echo $amount;
							$totalRevenue +=  (int) $amount; ?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php $refundAmount = null?>
							<?php foreach ($userData['PatientCard'] as $key=> $dataArray){?>
								<?php if($dataArray['type'] == "refund" || $dataArray['type'] == "Payment"){ 
									$refundAmount += $dataArray['amount']; } ?>
							<?php }?>
							<?php echo $refundAmount ;
							$totalRefund +=  (int) $refundAmount;?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
						<?php $netAmount = ($amount - $refundAmount);
							 echo $netAmount;
							$totalNetAmount +=  (int) $netAmount?>
						</td>
				  	</tr>
			  	<?php }?>
					
				</tbody>
			<tr>
				<td class="tdLabel" colspan="0" style="text-align: left;"><?php echo __('Grand Total :');?></td>
						<?php if(empty($totalRevenue)){ ?>
								<td class="tdLabel"><?php echo " ";?></td><?php
							}else{ ?>
								<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalRevenue)?></td>
						<?php }
						if(empty($totalRefund)){ ?>
							<td class="tdLabel"><?php echo " ";?></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalRefund)?></td>
						<?php }
						if(empty($totalNetAmount)){ ?>
							<td class="tdLabel"><?php echo " ";?></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalNetAmount)?></td>
						<?php } ?>
			</tr>  
			<?php echo $this->Form->end();?>
			</table>
		</div>
	</td>
	</tr>
</table>

<script>
//var getPaymentCollectionsURL = "<?php //echo $this->Html->url(array("controller" => 'Accounting', "action" => "payment_collection")); ?>" ;

//$(document).ready(function(){	
	//$(".idPatient").dblclick(function() {
	//	id = $(this).attr('id');
	//	var transaction_date = $(this).find('input').val();
	//	var transDate = transaction_date.split(",");
	//	var tran_date = transDate[0].split("/");
	//	var userid =  transDate[1];
	//	$.fancybox({
	//		'width' : '100%',
	//		'height' : '100%',
			//'autoScale' : true,
	//		'transitionIn' : 'fade',
	//		'transitionOut' : 'fade',
	//		'type' : 'iframe',
	//		'href' : getPaymentCollectionsURL + '/' + tran_date + '/' + userid + '/' + id
	//	});
	////});
//});
</script>
	