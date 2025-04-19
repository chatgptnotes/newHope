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

#msg {
    width: 180px;
    margin-left: 34%;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Day Book', true); ?>
	</h3>
</div> 
<?php echo $this->Form->create('Voucher',array('id'=>'voucher','url'=>array('controller'=>'Accounting','action'=>'sub_group_summary','admin'=>false),));?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
	<td width="95%" valign="top">
		<table align="center" style="margin-top: 10px">
			<tr>
				<td align="center"><strong><?php echo __('Sub Group Name');?></strong></td>
				<td><?php echo $this->Form->input('Group.name',array('id'=>'group','label'=>false,'div'=>false,'type'=>'text','autocomplete'=>'off','class' => 'validate[required,custom[mandatory-enter]]'));
											echo $this->Form->hidden('Group.group_id',array('id'=>'group_id'));?></td>
				<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?>
				<?php echo $this->Form->end();?></td>
			</tr>
		</table>

		<div id="container">
			<table width="100%" cellpadding="0" cellspacing="2" border="0" 	class="tabularForm"><!-- style="border-bottom:solid 10px #E7EEEF;" -->
				<thead>
					<tr> 
						<th width="35%" align="center" valign="top">Particulars</th> 
						<!-- <th width="13%" align="center" valign="top" style="text-align: center;">Debit</th> -->
						<th width="13%" align="center" valign="top" style="text-align: center; ">Total Amount</th> 
						<th width="5%" align="center" valign="top" style="text-align: center;">View Details</th>
					</tr> 
				</thead>
				
				<tbody>
				<?php foreach($data as $key=> $subGroupData) { ?>
					<tr>
						<td align="left" valign="top" style= "text-align: left;">
							<div style="padding-left:0px;padding-bottom:3px;">
								<?php echo $subGroupData['AccountingGroup']['name']; ?>
							</div>
						</td>
						<!-- <td class="tdLabel">
							<?php //echo $this->Number->currency($voucherPaymentDetails['VoucherPayment']['paid_amount']) ;
							//$debit +=  (int) $voucherPaymentDetails['VoucherPayment']['paid_amount'];?>
						</td> -->
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo $this->Number->currency($subGroupData[0]['sumAmount']) ;
							$total +=  (int) $subGroupData[0]['sumAmount'];?>
						</td>
						<td class="tdLabel" style= "text-align: center;">
							<?php echo $this->Html->link($this->Html->image('icons/view-icon.png'),
							array('action' =>'account_payable',$subGroupData['AccountingGroup']['id']),
							array('escape' => false,'title' => 'View', 'alt'=>'View','admin'=>false));?>
				  		</td>
				  	</tr>
			  	<?php }?>
					
				</tbody>
			<tr>
				<td class="tdLabel" colspan="0" style="text-align: left;"><?php echo __('Grand Total :');?></td>
					<?php 
						if(empty($total)){ ?>
							<td class="tdLabel"><?php echo " ";?></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($total)?></td>
						<?php } ?>
				<td class="tdLabel" colspan="0" style="text-align: left;"><?php echo " "?></td>
			</tr>  
			<?php echo $this->Form->end();?>
			</table>
		</div>
	</td>
	</tr>
</table>

<script>
$(document).ready(function(){
	$( "#group" ).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","AccountingGroup","name",'null',"null",'null',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			$('#group_id').val(ui.item.id);
		 },
		 messages: {
		        noResults: '',
		        results: function() {},
		 }
	});
});
</script>
	