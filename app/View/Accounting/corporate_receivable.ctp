<?php
echo $this->Html->css(array('internal_style'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
?>

<style>
.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
}
.tabularForm td {
	 background: none repeat scroll 0 0 #fff !important;
    color: #000 !important;
    font-size: 13px;
    padding: 3px 8px;
}
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
</style>
<?php echo $this->Html->script('topheaderfreeze') ;?>
<div class="inner_title">
	<h3>
		<?php echo __('Corporate Receivable', true); ?>
	</h3>
	<span>
		<?php echo $this->Html->link(__('Corporate Received'),array('action'=>'corporate_received'),array('escape'=>false,'class'=>'blueBtn'));?>
		<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div> 

<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="95%" valign="top">
		<?php echo $this->Form->create('Voucher',array('id'=>'voucher','type'=>'GET','url'=>array('controller'=>'Accounting','action'=>'corporate_receivable','admin'=>false),));?>
		<table align="center" style="margin-top: 10px">
			<tr>
				<td><?php echo $this->Form->input('Voucher.from', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'From'));?></td>
				<td><?php echo $this->Form->input('Voucher.to', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'To'));?></td>
				<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?>
				</td>
			</tr>
		</table>
		<?php echo $this->Form->end();?>
	
			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm" id="container-table"><!-- style="border-bottom:solid 10px #E7EEEF;" -->
				<thead>
					<tr> 
						<th width="50%" align="center" valign="top"><?php echo __('Company Name');?></th> 
						<th width="40%" align="center" valign="top" style="text-align: center; "><?php echo __('Total Receivable')?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center; "><?php echo __('View')?></th> 
					</tr> 
				</thead>
				
				<tbody>
				<?php 
				 
				foreach($data as $key=> $userData) { 
				$netAmount = round($userData['0']['total_amount'] - $userData['0']['amount_paid'] - $userData['0']['discount'] - $userData[0]['tds']);?>
					<tr>
						<td align="left" valign="top" style= "text-align: left;">
							<div style="padding-left:0px;padding-bottom:3px;">
								<?php echo ucwords(strtolower($userData['TariffStandard']['name'])); ?>
							</div>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo (double) $netAmount ;
							$totalRevenue +=  (double) $netAmount;?>
						</td>
						<td class="tdLabel"  style= "align: center;">
						<?php echo  $this->Html->image('icons/view-icon.png',array('id'=>$userData['TariffStandard']['id'],'escape' => false,'title' => 'View', 'alt'=>'View','class'=>"iframe" ));?>
						</td>
				  	</tr>
			  	<?php }?>
					
				</tbody>
			<?php echo $this->Form->end();?>
			</table>
		
	</td>
	</tr>
</table>
<table width="100%" >
	<tr>
		<td width="47%"  class="tdLabel" colspan="0" style="text-align: center;"><font color="red"><b><?php echo __('Grand Total :');?></b></font></td>
			<?php if(empty($totalRevenue)){ ?>
		<td width="45%"  class="tdLabel"><font color="red"><b><?php echo $this->Number->currency(0);?></b></font></td><?php
			}else{ ?>
		<td width="45%"  class="tdLabel" style= "text-align: center;"><font color="red"><b><?php echo $this->Number->currency($totalRevenue)?></b></font></td>
			<?php } ?>
		<td width="10%"  class="tdLabel"><?php echo " ";?></td>
	</tr>  
</table>
<script>

$(document).ready(function(){
	$("#from").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',			
	});	 
 	$("#to").datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});

 	$(document).ready(function(){	
 		$(".iframe").click(function() {
 			id = $(this).attr('id'); 
 			getPaymentCollectionsURL = "<?php echo $this->Html->url(array('controller'=>"Accounting",'action'=>"corporate_patient_details",'?'=>$this->params->query)); ?>" ;
 			 
 			$.fancybox({
 				'width' : '80%',
 				'height' : '80%',
 				'autoScale' : true,
 				'transitionIn' : 'fade',
 				'transitionOut' : 'fade',
 				'hideOnOverlayClick':false,
 				'type' : 'iframe',
 				<?php if($this->params->query){  ?>
 				'href' : getPaymentCollectionsURL + '&tariff_standard_id='+id
 				<?php }else{?>
 				'href' : getPaymentCollectionsURL + '?tariff_standard_id='+id 				
 				<?php }?>
 			});
 		});
 	});
 	//$("#container-table").freezeHeader({ 'height': '400px' });
});
</script>
	