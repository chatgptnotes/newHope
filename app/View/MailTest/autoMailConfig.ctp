<div class="inner_title">
	<h3>
		<?php echo __('Auto Email Configuration', true); ?>
	</h3>
	
</div> 
<div class="clr">&nbsp;</div>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
				<?php 
				foreach($errors as $errorsval){
			         echo $errorsval[0];
			         echo "<br />";
			     }     
			     ?>
		</div>
		</td>
	</tr>
</table>
<?php }   


echo $this->Form->create('accounting', array('url'=>array('controller'=>'accounting','action'=>'account_creation',$info['Patient']['id']),'id'=>'Acc_details','inputDefaults' => array(
															        'label' => false,'div' => false,'error'=>false,'legend'=>false,'O'))) ;

 
 
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	<tr>
		<td colspan="3"><?php echo __("Ledger Creation") ; ?></td>
		<td colspan="3"><?php echo __("Ledger Creation") ; ?></td>
	</tr>
	<tr>
		<td colspan="3"><?php echo __("Ledger Creation") ; ?></td>
		<td colspan="3"><?php echo __("Ledger Creation") ; ?></td>
	</tr>
	<tr>
		<td colspan="3"><?php echo __("Ledger Creation") ; ?></td>
		<td colspan="3"><?php echo __("Ledger Creation") ; ?></td>
	</tr>
	<tr>
		<td colspan="3"><?php echo __("Ledger Creation") ; ?></td>
		<td colspan="3"><?php echo __("Ledger Creation") ; ?></td>
	</tr>
	<tr>
		<td colspan="3"><?php echo __("Ledger Creation") ; ?></td>
		<td colspan="3"><?php echo __("Ledger Creation") ; ?></td>
	</tr>
	<tr>
		<td colspan="3"><?php echo __("Ledger Creation") ; ?></td>
		<td colspan="3"><?php echo __("Ledger Creation") ; ?></td>
	</tr>
</table>

<?php echo $this->Form->end();?>