<?php 
  echo $this->Html->script(array('jquery.fancybox-1.3.4'));//jquery-1.9.1.js
  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));//,'internal_style.css'
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
.subHead{
	display:none;
}
.headRow{
	cursor:pointer;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Trial Balance', true); ?>
	</h3>
</div>
<div class="clr ht5"></div>

<?php echo $this->Form->create('VoucherPayment',array('type' => 'GET','url' => array('controller' => 'Accounting', 'action' => 'trialBalanceReport'),
		'class'=>'manage','style'=>array("float"=>"left","width"=>"100%"),'id'=>'HeaderForm',
		'inputDefaults' => array('label' => false,'div' => false,'error' => false)));	 
?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
		<td width="95%" valign="top">
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	<tr> 
		<td rowspan ="3" style="padding-left:50px;" width="80%">
			<strong><?php echo __("Particulars");?></strong>
		</td>
		<td width="20%" align="center">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
				<tr>
					<td align="center" colspan="2">
						<strong><?php echo $this->Session->read(location_name);?></strong>
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<strong><?php echo __("Closing Balance");?></strong>
					</td>
				</tr>
				<tr>
					<td align="center">
						<?php echo __("Debit");?>
					</td>
					<td align="center">
						<?php echo __("Credit");?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
<?php foreach ($groupData as $key=> $data){
 if($data['0']['TotalBalance'] == '0') continue ;
 $totalBalance = $data['0']['TotalBalance'];?>
 <tbody id="s_<?php echo $data['AccountingGroup']['id']; ?>">
	<tr id="head_<?php echo $data['AccountingGroup']['id']; ?>" class="headRow">
		<td style="padding-left:20px;" width="80%">
			<strong><?php echo $data['AccountingGroup']['name'];?></strong>
		</td>
	<?php if($totalBalance>0){?>
		<td width="10%" align="right">
			<?php echo $this->Number->getPriceFormat((double) $totalBalance);
			$totalDebitAmount +=  (double) $totalBalance;?>
		</td>
		<td width="10%" align="right">
			<?php echo "";?>
		</td>
	<?php }elseif ($totalBalance<0){?>
		<td width="10%" align="right">
			<?php echo "";?>
		</td>
		<td width="10%" align="right">
			<?php echo $this->Number->getPriceFormat((double)-($totalBalance));
			$totalCreditAmount +=  (double) $totalBalance;?>
		</td>
	<?php }else{?>
		<td width="10%" align="right">
			<?php echo "";?>
		</td>
		<td width="10%" align="right">
			<?php echo "";?>
		</td>
	<?php }?>
	</tr>
	<tr id="subHead_<?php echo $data['AccountingGroup']['id']; ?>" class="subHead">
		<td colspan="3">
			<div id="subHeadLedger_<?php echo $data['AccountingGroup']['id']; ?>" class="subHeadLedger"></div>
		</td>
	<tr>
</tbody>
<?php }?>
<?php
 if($totalDebitAmount != -($totalCreditAmount)){?>
	<tr>
		<td style="padding-left:20px;" width="80%">
			<div style="font-style:italic;"><?php echo __("Diff. in Opening Balances");?></div>
		</td>
		
		<?php if($totalDebitAmount < $totalCreditAmount){?>
		<td width="10%" align="right" style="text-align: right;">
			<?php 
			$totalDebitDiff = ($totalDebitAmount-$totalCreditAmount);
				echo $this->Number->getPriceFormat($totalDebitDiff);
			?>
		</td>
		<td width="10%" align="right" style="text-align: right;">
			<?php echo "";?>
		</td>
		<?php }elseif($totalDebitAmount > $totalCreditAmount){ ?>
		<td width="10%" align="right" style="text-align: right;">
			<?php echo "";?>
		</td>
		<td width="10%" align="right" style="text-align: right;">
			<?php 
			if($totalCreditAmount < 0){
				$totalCreditAmount = -($totalCreditAmount);
			}
			$totalCreditDiff = ($totalDebitAmount-$totalCreditAmount);
				echo $this->Number->getPriceFormat($totalCreditDiff);
			?>
		</td>
		<?php }?>
	</tr>
<?php }?>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
	<tr>
		<td style="padding-left:20px;" width="80%">
			<strong><?php echo __("Grand Total");?></strong>
		</td>
		<td width="10%" align="right">
			<b><?php echo $this->Number->getPriceFormat($totalDebitAmount+$totalDebitDiff);?></b>
		</td>
		<td width="10%" align="right">
			<b>
				<?php 
					if($totalCreditAmount < 0){
						$totalCreditAmount = -($totalCreditAmount);
					}
					echo $this->Number->getPriceFormat($totalCreditAmount+$totalCreditDiff);
				?>
			</b>
		</td>
	</tr>
</table>
</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<script>
	$('.headRow').on('click',function(){
		var id = $(this).attr('id').split("_")[1]; 
		if($.trim($("#subHeadLedger_"+id).html()) == ''){
		$.ajax({
			method : 'Post',
			url : "<?php echo $this->Html->url(array("controller"=>'Accounting',"action"=>"getGroupWiseLedger","admin"=>false));?>",
			data:"GroupId="+id,
			context: document.body,
			 beforeSend:function(data){
             	$('#busy-indicator').show();
			 },
 		success: function(data){
 	 		$('.subHead').hide();
 	 		$("#subHead_"+id).toggle('show');
 				$("#subHeadLedger_"+id).html(data).fadeIn('slow');
				$('#busy-indicator').hide();
	   		}
		});
		}else{
			//$('.subHead').hide();
 	 		$("#subHead_"+id).toggle('show');
			$("#subHeadLedger_"+id).fadeIn('slow');
		}
		
	});
</script>