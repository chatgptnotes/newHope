<div class="inner_title">
	<h3>
		<?php echo __('Accounts', true); ?>
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
echo $this->Form->create('accounting', array('url'=>array('controller'=>'accounting','action'=>'account_type',$patient_id),'id'=>'Acc_type','inputDefaults' => array(
															        'label' => false,'div' => false,'error'=>false,'legend'=>false,'O'))) ;

echo $this->Form->hidden('Account.patient_id',array('value'=>$info['Patient']['id']));
echo $this->Form->hidden('Account.id',array());
echo $this->Form->hidden('Account.account_creation_type',array('value'=>'patient'));


?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
	<tr>
		<th colspan="3"><?php echo __("Accounts") ; ?></th>
	</tr>
	
	<tr>
		<td width="50%"  class="tdLabel" id="boxSpace" valign="top">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr> 
					<th ><?php echo __("Single Account") ; ?></th>
				</tr>
				
				<tr> 
					<td valign="top" class="tdLabel" id="boxSpace">
					
					<table align="center" cellpadding="1" cellspacing="1" border="0">
					<tr height="40px">
					<td ><?php $CreateBtnUrl =  array('controller'=>'accounting','action'=>'account_creation',$patient_id);?>
     					<?php  echo $this->Html->link(__('Create'),$CreateBtnUrl,array('class'=>'blueBtn','div'=>false)); ?></td>
					</tr>
					
					<tr height="40px">
					<td><?php $DisplayBtnUrl =  array('controller'=>'accounting','action'=>'account_creation',$patient_id);?>
     					<?php  echo $this->Html->link(__('Display'),$DisplayBtnUrl,array('class'=>'blueBtn','div'=>false)); ?></td>
					</tr>
					
					<tr height="40px">
					<td><?php $AlterBtnUrl =  array('controller'=>'accounting','action'=>'account_creation',$patient_id);?>
    					 <?php  echo $this->Html->link(__('Alter'),$AlterBtnUrl,array('class'=>'blueBtn','div'=>false)); ?></td>
					</tr>
					</table>
					
					</td>
					
				</tr>
		</table>
		</td>
		
		<td width="50%"  class="tdLabel" id="boxSpace" valign="top">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr> 
					<th ><?php echo __("Multiple Account") ; ?></th>
				</tr>
				
				<tr> 
					<td valign="top" class="tdLabel" id="boxSpace">
					
					<table align="center" cellpadding="1" cellspacing="1" border="0">
					<tr height="40px">
					<td ><?php $CreateBtnUrl =  array('controller'=>'accounting','action'=>'',$patient_id);?>
     					<?php  echo $this->Html->link(__('Create'),$CreateBtnUrl,array('class'=>'blueBtn','div'=>false)); ?></td>
					</tr>
					
					<tr height="40px">
					<td><?php $DisplayBtnUrl =  array('controller'=>'accounting','action'=>'',$patient_id);?>
     					<?php  echo $this->Html->link(__('Display'),$DisplayBtnUrl,array('class'=>'blueBtn','div'=>false)); ?></td>
					</tr>
					
					<tr height="40px">
					<td><?php $AlterBtnUrl =  array('controller'=>'accounting','action'=>'',$patient_id);?>
    					 <?php  echo $this->Html->link(__('Alter'),$AlterBtnUrl,array('class'=>'blueBtn','div'=>false)); ?></td>
					</tr>
					</table>
					
					
					</td>
					
				</tr>
		</table>
		</td>
	</tr>
	
	<tr>
	<td align="center" colspan="2"></td>
	</tr>
	<tr>
	<td align="center" colspan="2"><?php $cancelBtnUrl =  array('controller'=>'patients','action'=>'',$patient['Patient']['id']);?>
     <?php  echo $this->Html->link(__('Quit'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false)); ?></td>
	</tr>
	
</table>


</div>
<?php echo $this->Form->end();?>

