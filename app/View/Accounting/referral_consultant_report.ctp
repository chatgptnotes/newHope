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

#fancybox-wrap{
	height:400px !important;
}
#fancybox-content{
	height:400px !important;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Marketing Team', true).' ('.$team.')'; ?>
	</h3>
	<span>
		<?php echo $this->Html->link($this->Html->image('icons/printer.png',array('title'=>'Print Referral Doctor')),'#',
		array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'printReferralConsultantReport','?'=>array('date'=>$date,'team'=>$team)))."', '_blank',
		'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200');  return false;")); ?>
		</span>
</div> 
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="100%" valign="top">
		<div id="container">
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
		</div>
	</td>
	</tr>
</table>

<script>
var referralPatientReportURL = "<?php echo $this->Html->url(array("controller" => 'Accounting', "action" => "referralPatientReport")); ?>";
$(document).ready(function(){	
	$(".idPatient").click(function() {
		id = $(this).attr('id');
		var spot_date = $(this).find('input').val();
		var transDate = spot_date.split(",");
		$.fancybox({
			'width' : '100%',
			'height' : '100%',
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : referralPatientReportURL + '/' + transDate[0] + '/' + id + '/' + transDate[1]
		});
	});
});
</script>
	