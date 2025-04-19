<div class="inner_title">
<h3><?php echo __('Cashier Transaction Open', true); ?></h3>
<span>
<?php 
		echo $this->Html->link('Logout',array('controller'=>'users','action'=>'logout'),array('escape'=>false,'class'=>'blueBtn'));
	?>
</span>
</div>

<form name="cashierfrm" id="cashierfrm" method="post" autocomplete="off" action="<?php echo Router::url('/');?>">
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
		<tr>
			<td colspan="2" align="center">
				<?php echo $this->Form->submit('Open',array('label'=>false,'id'=>'open','class' => 'blueBtn'));?>
			</td>
		</tr>
	</table>
</form>
<script>
$('#open').click(function() {
	window.location = "<?php echo Router::url('/');?>";
   // return false;
});	
</script>