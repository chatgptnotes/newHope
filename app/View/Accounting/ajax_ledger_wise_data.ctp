
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
	if($data['amount'] == '0') continue;
 	$totalChildBalance = $data['amount'];?>
 	<tbody>
		<tr id="<?php echo $key; ?>" class="idSelectable">
			<td style="padding-left:20px;" width="80%">
				<strong><?php echo $data['name'];?></strong>
				<?php echo $this->Form->hidden('Account.id',array('value'=>$key));?>
			</td>
		<?php if($totalChildBalance>0){?>
			<td width="10%" align="center">
				<?php echo $this->Number->getPriceFormat((double) $totalChildBalance);
				$totalChildDebitAmount +=  (double) $totalChildBalance;?>
			</td>
			<td width="10%" align="center">
				<?php echo "";?>
			</td>
		<?php }elseif ($totalChildBalance<0){?>
			<td width="10%" align="center">
				<?php echo "";?>
			</td>
			<td width="10%" align="center">
				<?php echo $this->Number->getPriceFormat((double) - ($totalChildBalance));
				$totalChildCreditAmount +=  (double) $totalChildBalance;?>
			</td>
		<?php }else{?>
			<td width="10%" align="center">
				<?php echo "";?>
			</td>
			<td width="10%" align="center">
				<?php echo "";?>
			</td>
		<?php }?>
		</tr>
	<?php }?>
	</tbody>
</table>
<script>
$(document).ready(function(){
var getLedgerTransactionsURL = "<?php echo $this->Html->url(array("controller" => 'Accounting', "action" => "legder_voucher","admin" => false)); ?>";
$(".idSelectable").dblclick(function() {
	var locationId = '<?php echo $locationId;?>';
	var tran_date_from = '<?php echo $from;?>';
	var from = tran_date_from.split("/");
	var tran_date_to = '<?php echo $to;?>';
	var to = tran_date_to.split("/");
	var id = $(this).attr('id');
	$.fancybox({
		'width' : '90%',
		'height' : '90%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : getLedgerTransactionsURL + '/' +'TrialBalance' + '/' + id + '/' + locationId + '/' + from + '/' + to
	});
});
});
</script>