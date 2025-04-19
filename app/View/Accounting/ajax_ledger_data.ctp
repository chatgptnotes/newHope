
<style>
.tabularForm1 {
    background: none repeat scroll 0 0 #d2ebf2 !important;
}
.tabularForm1 td {
	background: none repeat scroll 0 0 #C0C0C0 !important;
    color: #000 !important;
    font-size: 13px;
    padding: 3px 8px;
}
</style>

<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm1">
<?php foreach ($ledgerData as $key=> $data){
 	$totalChildBalance = $data['0']['TotalLedgerBalance'];?>
 	<tbody>
		<tr id="<?php echo $data['Account']['id']; ?>" class="idSelectable">
			<td style="padding-left:20px;" width="80%">
				<strong><?php echo $data['Account']['name'];?></strong>
				<?php echo $this->Form->hidden('Account.id',array('value'=>$data['Account']['id']));?>
			</td>
		<?php if($totalChildBalance>0){?>
			<td width="10%" align="right">
				<?php echo $this->Number->getPriceFormat((double) $totalChildBalance);
				$totalChildDebitAmount +=  (double) $totalChildBalance;?>
			</td>
			<td width="10%" align="right">
				<?php echo "";?>
			</td>
		<?php }elseif ($totalChildBalance<0){?>
			<td width="10%" align="right">
				<?php echo "";?>
			</td>
			<td width="10%" align="right">
				<?php echo $this->Number->getPriceFormat((double) -($totalChildBalance));
				$totalChildCreditAmount +=  (double) $totalChildBalance;?>
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
	<?php }?>
	</tbody>
</table>
<script>
var getLedgerTransactionsURL = "<?php echo $this->Html->url(array("controller" => 'Accounting', "action" => "legder_voucher","admin" => false)); ?>" ;
$(".idSelectable").click(function() {
	id = $(this).attr('id');
	$.fancybox({
		'width' : '90%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : getLedgerTransactionsURL+'/'+'TrialBalance'+ '/' + id
	});
});

</script>