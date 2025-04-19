<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Patient Card_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Generated Report" );
ob_clean();
flush();
?>
<style>
body{
font-size:13px;
}
</style>
<STYLE type='text/css'>
.tableTd {
border-width: 0.5pt;
border: solid;
}
.tableTdContent{
border-width: 0.5pt;
border: solid;
}
#titles{
font-weight: bolder;
}

</STYLE>
<table border="0" class="" cellpadding="0" cellspacing="0" width="100%" align="center" >
		 <tr>  
	  		<td valign="top" colspan="5" style="text-align:center;" align="center">
	  			<h2><?php echo "Patient Card";?></h2>
	  		</td>
    	</tr>
    	<tr>
	    	<?php 
		    	$getTo=explode(" ",$date);
		    	$getToFinal = str_replace("/", "-",$getTo[0]);
		    	$getToFinal=date('jS-M-Y', strtotime($getToFinal));
	    	?>
	    	<td align="" valign="top" colspan="5" style="letter-spacing: 0.1em;text-align:center;">
			  	<?php echo $getToFinal; ?>
			</td>
    	</tr>    
	</table>
<table width="100%" cellpadding="0" cellspacing="2" border="1" style="padding-top:10px">
	<tr>
	<td width="95%" valign="top">
		<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="1" 	class="tabularForm">
				<thead>
					<tr> 
						<th width="20%" align="center" valign="top"><?php echo __('User Name');?></th> 
						<th width="20%" align="center" valign="top"><?php echo __('Role');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center; "><?php echo __('Total Revenue');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center; "><?php echo __('Refund Amount');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center; "><?php echo __('Nett Amount');?></th> 
					</tr> 
				</thead>
				
				<tbody>
				<?php foreach($data as $key=> $userData) { 
				if(empty($userData['PatientCard'])) continue ;?>	
					<tr>
						<td align="left" valign="top" style= "text-align: left;">
							<div style="padding-left:0px;padding-bottom:3px;">
								<?php echo $userData['User']['full_name']; ?>
							</div>
						</td>
						<td align="left" valign="top" style= "text-align: left;">
							<?php echo $userData['Role']['name']; ?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php $amount = 0?>
							<?php foreach ($userData['PatientCard'] as $key=> $dataArray){?>
								<?php if($dataArray['type'] == "deposit"){ 
									$amount += $dataArray['amount']; } ?>
							<?php }?>
							<?php echo $amount;
							$totalRevenue +=  (double) $amount; ?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php $refundAmount = 0?>
							<?php foreach ($userData['PatientCard'] as $key=> $dataArray){ ?>
								<?php if($dataArray['type'] == "refund" || $dataArray['type'] == "Payment"){ 
									$refundAmount += $dataArray['amount']; } ?>
							<?php }?>
							<?php echo $refundAmount ;
							$totalRefund +=  (double) $refundAmount;?>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
						<?php $netAmount = ($amount - $refundAmount);
							 echo $netAmount;
							$totalNetAmount +=  (double) $netAmount?>
						</td>
				  	</tr>
			  	<?php }?>
					
				</tbody>
			<tr>
				<td class="tdLabel" colspan="2" style="text-align: right;"><font color="red"><b><?php echo __('Total :');?></b></font></td>
						<?php if(empty($totalRevenue)){ ?>
								<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
							}else{ ?>
								<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalRevenue)?></b></font></td>
						<?php }
						if(empty($totalRefund)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalRefund)?></b></font></td>
						<?php }
						 if(empty($totalNetAmount)){ ?>
							<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
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
