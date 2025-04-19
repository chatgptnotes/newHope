<?php
echo $this->Html->css(array('internal_style'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
?>
<style>
body{
font-size:13px;
}
.red td{
	background-color:antiquewhite !important;
}
.idSelectable:hover{
		cursor: pointer;
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
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Referral Report', true); ?>
	</h3>
	<span>
		<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div> 
<?php echo $this->Form->create('Spot',array('id'=>'voucher','url'=>array('controller'=>'Accounting','action'=>'referralSharingReport','admin'=>false)));?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="95%" valign="top">
		<table align="center" style="margin-top: 10px">
			<tr>
			<?php 
				$monthArray = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June',
                                        '07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
                 	for($i=2010;$i<=date('Y')+5;$i++){
            			$yearArray[$i] = $i; 
            		}
            ?>
                <td align="center"><?php echo "Month";?></td>
                <td align="center">
                	<?php echo $this->Form->input('month',array('empty'=>'Please Select','options'=>$monthArray,
                                                        'class'=>'textBoxExpnd ','label'=>false,'default'=>date('m'))); ?>
                </td>
                <td align="center"><?php echo "Year"; ?></td>
                <td align="center">
                	<?php echo $this->Form->input('year',array('empty'=>'Please Select','options'=>$yearArray,
                                                        'class'=>'textBoxExpnd ','label'=>false,'default'=>date('Y')));?>
                </td>
				<td>
					<?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?>
				</td>
				<td>
					<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'referralSharingReport'),array('escape'=>false));?>
				</td>
			</tr>
		</table>

		<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
				<thead>
					<tr> 
						<th width="20%" align="center" valign="top"><?php echo __('Referral Doctor');?></th> 
						<th width="20%" align="center" valign="top" style="text-align: center;"><?php echo __('Total Collection');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Total S Payable');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Total B Payable');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Total S Paid');?></th>
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Total B Paid');?></th>
					</tr> 
				</thead>
				
				<tbody>
				<?php foreach($spotData as $key=> $userData) { ?>
					<tr id="<?php echo $key; ?>" class="idSelectable">
					<input type="hidden" id="start_transaction_id_<?php echo $key; ?>" value="<?php echo $date?>">
						<td align="left" valign="top" style= "text-align: left;">
							<div style="padding-left:0px;padding-bottom:3px;">
								<?php echo $key; ?>
							</div>
						</td>
						<td align="left" style= "text-align: right;">
						<?php echo $userData['collection_amount'] ?round($userData['collection_amount']) :0;
							$totalCollection +=  (double) round($userData['collection_amount']);?>
						</td>
						<td class="tdLabel"  style= "text-align: right;">
							<?php echo $userData['s_payable'] ?round($userData['s_payable']) :0;
							$totalSPayable +=  (double) round($userData['s_payable']);?>
						</td>
						<td class="tdLabel"  style= "text-align: right;">
							<?php echo $userData['b_payable'] ?round($userData['b_payable']) :0;
							$totalBPayable +=  (double) round($userData['b_payable']);?>
						</td>
						<td class="tdLabel"  style= "text-align: right;">
							<?php echo $userData['s_paid'] ?round($userData['s_paid']) :0;
							$totalSPaid +=  (double) round($userData['s_paid']);?>
						</td>
						
						<td class="tdLabel"  style= "text-align: right;">
							<?php echo $userData['b_paid'] ?round($userData['b_paid']) :0;
							$totalBPaid +=  (double) round($userData['b_paid']);?>
						</td>
				  	</tr>
			  	<?php }?>
					
				</tbody>
			<tr>
				<td class="tdLabel" style="text-align: right;"><font color="red"><b><?php echo __('Total :');?></b></font></td>
						<?php 
						if(empty($totalCollection)){ ?>
							<td class="tdLabel" style= "text-align: right;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: right;"><font color="red"><b><?php echo $this->Number->currency($totalCollection);?></b></font></td>
						<?php }
						if(empty($totalSPayable)){ ?>
							<td class="tdLabel" style= "text-align: right;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: right;"><font color="red"><b><?php echo $this->Number->currency($totalSPayable);?></b></font></td>
						<?php }
						if(empty($totalBPayable)){ ?>
							<td class="tdLabel" style= "text-align: right;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: right;"><font color="red"><b><?php echo $this->Number->currency($totalBPayable);?></b></font></td>
						<?php } 
						if(empty($totalSPaid)){ ?>
							<td class="tdLabel" style= "text-align: right;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: right;"><font color="red"><b><?php echo $this->Number->currency($totalSPaid);?></b></font></td>
						<?php }
						if(empty($totalBPaid)){ ?>
							<td class="tdLabel" style= "text-align: right;"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: right;"><font color="red"><b><?php echo $this->Number->currency($totalBPaid);?></b></font></td>
						<?php } ?>
			</tr>  
			<?php echo $this->Form->end();?>
			</table>
		</div>
	</td>
	</tr>
</table>

<script>

var referralConsultantReportURL = "<?php echo $this->Html->url(array("controller" => 'Accounting', "action" => "referralConsultantReport")); ?>";

$(document).ready(function(){
	$(".idSelectable").dblclick(function() {
		team = $(this).attr('id');
		var spot_date = $(this).find('input').val();
		var tran_date = spot_date.split("/");
		$.fancybox({
			'width' : '70%',
			'height' : '90%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : referralConsultantReportURL + '/' + tran_date + '/' + team
		});
	}); 
 	$("#date").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});
});
</script>