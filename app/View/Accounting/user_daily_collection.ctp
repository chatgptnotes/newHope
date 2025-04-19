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
.idPatient:hover{
		cursor: pointer;
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
		<?php echo __('User Daily Collection', true).' ('.$userName['User']['full_name'].')'; ?>
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
						<th width="14%" align="center" valign="top" style="text-align: center;">Discount</th>
						<th width="20%" align="center" valign="top" style="text-align: center;">Nett Amount</th>
					</tr> 
				</thead>
				
				<tbody>
				<?php foreach($billingDetails as $key=> $userData) {
				$amountSum = ($userData['patient']['0']['billing_total']+$userData['patient_card_deposit']['0']['card_total'])-$userData['patient_card_payment']['0']['card_payment'];
				$refundSum = $userData['patient']['0']['billing_refund']+$userData['patient_card_refund']['0']['card_refund'];
				$discountSum = $userData['patient']['0']['total_discount'];
				if(($amountSum == 0) && ($refundSum == 0) && ($discountSum == 0)){
					continue;
				}
					?>
					<tr id="<?php echo $userData['patient']['Patient']['id']; ?>" class="idPatient">
					<input type="hidden" id="start_transaction_id_<?php echo $userData['patient']['Patient']['id']; ?>" value="<?php echo $date.','.$userId?>">
						<td align="left" valign="top" style= "text-align: left;">
							<div style="padding-left:0px;padding-bottom:3px;">
							<?php
								if(!empty($userData['patient']['Patient']['lookup_name'])){
								 	echo $userData['patient']['Patient']['lookup_name'].' ('.$userData['patient']['Patient']['admission_id'].')';
								 }else{
									echo $userData['patient_card_deposit']['Person']['first_name']." ".$userData['patient_card_deposit']['Person']['last_name'].' ('.$userData['patient_card_deposit']['Person']['patient_uid'].')';
								}
							?>
							</div>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo  $amountSum ?round($amountSum) :0;
							$totalRevenue +=  (float) round($amountSum);?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $refundSum ?round($refundSum) :0;
							$totalRefund +=  (float) round($refundSum);?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $discountSum ?round($discountSum) :0;
							$totalDiscount +=  (float) round($discountSum);?>
						</td>
						
						<td class="tdLabel"  style= "text-align: center;">
						<?php $netAmount = ($amountSum - $refundSum );
							 echo $netAmount;
							$totalNetAmount +=  (float) $netAmount?>
						</td>
				  	</tr>
			  	<?php }?>
					
				</tbody>
			<tr>
				<td class="tdLabel" colspan="0" style="text-align: right;"><font color="red"><b><?php echo __('Total :');?></b></font></td>
						<?php
						if(empty($totalRevenue)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalRevenue)?></b></font></td>
						<?php }
						if(empty($totalRefund)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalRefund)?></b></font></td>
						<?php } 
						if(empty($totalDiscount)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalDiscount)?></b></font></td>
						<?php }
						if(empty($totalNetAmount)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalNetAmount)?></b></font></td>
						<?php } ?>
			</tr>  
			<?php echo $this->Form->end();?>
			</table>
		</div>
	</td>
	</tr>
</table>

<script>
var getPaymentCollectionsURL = "<?php echo $this->Html->url(array("controller" => 'Accounting', "action" => "payment_collection")); ?>" ;

$(document).ready(function(){	
	$(".idPatient").click(function() {
		id = $(this).attr('id');
		var transaction_date = $(this).find('input').val();
		var transDate = transaction_date.split(",");
		var tran_date = transDate[0].split("/");
		var userid =  transDate[1];
		$.fancybox({
			'width' : '100%',
			'height' : '100%',
			//'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : getPaymentCollectionsURL + '/' + tran_date + '/' + userid + '/' + id
		});
	});
});
</script>
	