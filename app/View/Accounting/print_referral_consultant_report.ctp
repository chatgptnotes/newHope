<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html moznomarginboxes mozdisallowselectionprint>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php echo $this->Html->charset(); ?>
		<title>
				<?php echo __('Hope', true); ?>
		</title>
			<?php echo $this->Html->css('internal_style.css');?> 
		<style>
			@media print {
		  		#printButton{display:none;}
		    }
		    body{
				font-size:13px;
			}
			.red td{
				background-color:antiquewhite !important;
			}
		</style> 
	</head>
	<div class="inner_title">
	<h3>
		<?php echo __('Marketing Team', true).' ('.$team.')'; ?>
	</h3>
	<span>
		<div id="printButton">
			  <?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();')); ?>
		</div>
	</span>
</div> 
	<body style="background:none;width:98%;margin:auto;">
		<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
			<thead>
				<tr> 
					<th width="30%" align="center" valign="top"><?php echo __("Referral Doctors");?></th> 
					<th width="14%" align="center" valign="top" style="text-align: center;"><?php echo __("Total S Payable");?></th>
					<th width="20%" align="center" valign="top" style="text-align: center;"><?php echo __("Total B Payable");?></th>
					<th width="18%" align="center" valign="top" style="text-align: center;"><?php echo __("Total S Paid");?></th> 
					<th width="18%" align="center" valign="top" style="text-align: center;"><?php echo __("Total B Paid");?></th> 
				</tr> 
			</thead>
			
			<tbody>
			<?php foreach($consultantData as $key=> $userData) { ?>
				<tr id="<?php echo $userData['consultant_id']; ?>" class="idPatient">
				<input type="hidden" id="start_transaction_id_<?php echo $userData['consultant_id']; ?>" value="<?php echo $date.','.$key?>";>
					<td align="left" valign="top" style= "text-align: left;">
						<div style="padding-left:0px;padding-bottom:3px;">
						<?php echo $key;?>
						</div>
					</td>
					<td class="tdLabel"  style= "text-align: center;">
						<?php echo  $userData['s_payable'] ?round($userData['s_payable']) :0;
						$totalSPayable +=  (float) round($userData['s_payable']);?>
					</td>
					<td class="tdLabel"  style= "text-align: center;">
						<?php echo $userData['b_payable'] ?round($userData['b_payable']) :0;
						$totalBPayable +=  (float) round($userData['b_payable']);?>
					</td>
					<td class="tdLabel"  style= "text-align: center;">
						<?php echo $userData['s_paid'] ?round($userData['s_paid']) :0;
						$totalSPaid +=  (float) round($userData['s_paid']);?>
					</td>
					
					<td class="tdLabel"  style= "text-align: center;">
					<?php echo $userData['b_paid'] ?round($userData['b_paid']) :0;
						$totalBPaid +=  (float) round($userData['b_paid']);?>
					</td>
			  	</tr>
		  	<?php }?>
				
			</tbody>
		<tr>
			<td class="tdLabel" colspan="0" style="text-align: right;"><font color="red"><b><?php echo __('Total :');?></b></font></td>
					<?php
					if(empty($totalSPayable)){ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></td><?php
					}else{ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalSPayable)?></b></font></td>
					<?php }
					if(empty($totalBPayable)){ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></td><?php
					}else{ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalBPayable)?></b></font></td>
					<?php } 
					if(empty($totalSPaid)){ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></td><?php
					}else{ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalSPaid)?></b></font></td>
					<?php }
					if(empty($totalBPaid)){ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency(0);?></td><?php
					}else{ ?>
						<td class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalBPaid)?></b></font></td>
					<?php } ?>
		</tr>  
		<?php echo $this->Form->end();?>
		</table>
	</body>
 </html>