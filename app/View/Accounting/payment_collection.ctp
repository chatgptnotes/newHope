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

#msg {
    width: 180px;
    margin-left: 34%;
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
#fancybox-wrap{
height:400px !important;
}
#fancybox-content{
height:400px !important;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Payment Collection', true).' ('.$patientName['Patient']['lookup_name'].')'; ?>
	</h3>
</div> 
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="100%" valign="top">
		<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
				<thead>
					<tr> 
						<th width="30%" align="center" valign="top">Service Group Name</th> 
						<th width="18%" align="center" valign="top" style="text-align: center; ">Amount</th> 
					</tr> 
				</thead>
				
				<tbody>
				<?php foreach($data as $key=> $userData) { ?>
					<tr>
						<td align="left" valign="top" style= "text-align: left;">
							<div style="padding-left:0px;padding-bottom:3px;">
								<b><?php echo $key; ?></b>
							</div>
							<?php foreach ($userData as $key => $allData){
									foreach ($allData as $key => $data){?>
									<div style="padding-left: 35px; font-size:13px; font-style:italic;">
										<?php echo $key ; ?>
									</div>
									<?php }?>
							<?php }?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php foreach ($userData as $key => $allData){
									foreach ($allData as $key => $data){?>
									<div style="padding-left: 35px; font-size:13px; font-style:italic;">
										<?php echo round($data); 
										$totalRevenue +=  (int) round($data);?>
									</div>
									<?php }?>
							<?php }?>
						</td>
				  	</tr>
			  	<?php }?>	
				</tbody>
				<tr>
				<td class="tdLabel" colspan="0" style="text-align: left;"><font color="red"><b><?php echo __('Grand Total :');?></b></font></td>
				<?php if(empty($totalRevenue)){ ?>
						<td class="tdLabel"><?php echo " ";?></td><?php
					}else{ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalRevenue)?></b></font></td>
				<?php } ?>
				</tr>
			<?php echo $this->Form->end();?>
			</table>
			<br>
			<?php if(!empty($totalRevenue)){?>
			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
				<thead>
					<tr>
						<th class="tdLabel" colspan="0" style="text-align: center;"><?php echo __('Total Refund Amount');?></th>
						<th class="tdLabel" colspan="0" style="text-align: center;"><?php echo __('Total PatientCard Deposit');?></th>
						<th class="tdLabel" colspan="0" style="text-align: center;"><?php echo __('Total PatientCard Payment/Refund');?></th>
					</tr>
				</thead>	
				<tbody>
					<tr>
						<td class="tdLabel"  style= "text-align: center;">
							<div style="padding-left: 35px; font-size:13px; font-style:italic;">
								<?php echo round($billingData['0']['billing_refund']); ?>
							</div>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<div style="padding-left: 35px; font-size:13px; font-style:italic;">
								<?php echo round($cardDeposit['0']['card_total']); ?>
							</div>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<div style="padding-left: 35px; font-size:13px; font-style:italic;">
								<?php echo round($cardPayment['0']['card_payment']); ?>
							</div>
						</td>
					</tr>
					<tr>
						<td class="tdLabel" colspan="2" style="text-align: left;"><font color="red"><b><?php echo __('Calculations :');?></b></font></td>
						<td class="tdLabel" colspan="0" style="text-align: center;"><font color="red"><b>
							<?php 
							$totalAmount = $totalRevenue+$billingData['0']['billing_refund']+$cardDeposit['0']['card_total']-$cardPayment['0']['card_payment'];
									echo $totalRevenue;
									echo __(' + '); 
									echo $billingData['0']['billing_refund']; 
									echo __(' + ');
									echo $cardDeposit['0']['card_total'];
									echo __(' - ');
									echo $cardPayment['0']['card_payment'];
									echo __(' = ');
									echo $totalAmount;
							?>
						</b></font></td>
					</tr>
				</tbody>
			</table>
			<?php }?>
		</div>
	</td>
	</tr>
</table>

<script>

$(document).ready(function(){
	
});
</script>
	