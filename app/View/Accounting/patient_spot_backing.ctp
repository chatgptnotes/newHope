<style>
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
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Referral Report', true); ?>
	</h3>
	<span>
		<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div> 

<?php echo $this->Form->create('Spot',array('id'=>'voucher','url'=>array('controller'=>'Accounting','action'=>'patientSpotBacking','admin'=>false)));?>
	<table align="center" style="margin-top: 10px">
		<tr>
			<?php $monthArray = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July',
					'08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
				for($i=2010;$i<=date('Y')+5;$i++){
					$yearArray[$i] = $i; 
				}
			?>
			<td align="center"><?php echo "Month";?></td>
			<td align="center">
				<?php echo $this->Form->input('month',array('empty'=>'Please Select','options'=>$monthArray,'class'=>'textBoxExpnd',
						'label'=>false,'default'=>date('m'))); ?>
			</td>
			<td align="center"><?php echo "Year";?></td>
			<td align="center">
				<?php echo $this->Form->input('year',array('empty'=>'Please Select','options'=>$yearArray,'class'=>'textBoxExpnd',
						'label'=>false,'default'=>date('Y')));?>
			</td>
			<td>
				<?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?>
			</td>
			<td>
				<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'patientSpotBacking'),array('escape'=>false));?>
			</td>
		</tr>
	</table>
	<div id="container">
		<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
			<thead>
				<tr> 
					<th width="20%" align="center" valign="top"><?php echo __('Patient Name');?></th> 
					<th width="20%" align="center" valign="top" style="text-align: right;"><?php echo __('Total Received');?></th>
					<th width="80%" style="text-align: center;" colspan="4"><?php echo __("Referral Details");?>
						<table width="100%">
							<tr>
								<th width="25%" align="center" valign="top" style="text-align: left;"><?php echo __('Referral Doctor');?></th>  
								<th width="25%" align="center" valign="top" style="text-align: right;"><?php echo __('S Paid');?></th>
								<th width="25%" align="center" valign="top" style="text-align: right;"><?php echo __('B Paid');?></th>
								<th width="25%" align="center" valign="top" style="text-align: right;"><?php echo __('Total');?></th>
							</tr>
						</table>
					</th>
				</tr> 
			</thead>
			
			<tbody>
			<?php foreach($finalData as $key=> $userData) { ?>
				<tr>
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo $userData['name']; ?>
					</td>
					<td align="left" style= "text-align: right;">
					<?php echo $userData['paid_amount'] ?round($userData['paid_amount']) :0;
						$totalCollection +=  (double) round($userData['paid_amount']);?>
					</td>
					<td class="tdLabel" style="text-align: right;" colspan="4">
						<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
						<?php foreach ($userData['referral'] as $refKey=> $refData){?>
							<tr>
								<td align="left" valign="top" style= "text-align: left;" width="25%">
									<?php echo $refData['referral_name']; ?>
								</td>
								<td align="right" valign="top" style= "text-align: right;" width="25%">
									<?php echo $refData['spot_amount'] ?round($refData['spot_amount']) :0;
										$spotCollection[$refKey] +=  (double) round($refData['spot_amount']);?>
								</td>
								<td align="right" valign="top" style= "text-align: right;" width="25%">
									<?php echo $refData['backing_amount'] ?round($refData['backing_amount']) :0;
										$backingCollection[$refKey] +=  (double) round($refData['backing_amount']);?>
								</td>
								<td align="right" valign="top" style= "text-align: right;" width="25%">
									<?php
										$totalAmount = $spotCollection[$refKey] + $backingCollection[$refKey];
										echo $totalAmount ?round($totalAmount) :0;
									?>
								</td>
							</tr>
						<?php }?>
						</table>
					</td>
			  	</tr>
		  	<?php }?>
			</tbody>
		</table>
	</div>
<script>
$(document).ready(function(){
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