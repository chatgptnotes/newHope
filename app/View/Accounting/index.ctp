<div class="inner_title">
	<h3>
		<?php echo __('Account Listing', true); ?>
	</h3>
</div>
<div class="clr">&nbsp;</div>
<style>
label {
	width: 126px;
	padding: 0px;
}

.table_format {
    padding: 2px;
}
</style>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%" align="center">
	<tr>
		<td colspan="2" align="left" class="error">
		<?php 
			foreach($errors as $errorsval){
		         echo $errorsval[0];
		         echo "<br />";
		     }
		?>
		</td>
	</tr>
</table>
<?php }  

echo $this->Form->create('Account',array('url'=>array('controller'=>'Accounting','action'=>'index'),'type'=>'get',
'id'=>'index','inputDefaults'=>array('div'=>false,'label'=>false,'error'=>false)));
?>
 <table border="0" cellpadding="2" cellspacing="0" align="center">
 	<?php  if(AuthComponent::user()['id'] == 1): ?>
	<tbody>
		<tr class="row_title">
			<td>
				<?php echo __('Name') ?> :
			</td>
			
			<td>
				<?php echo $this->Form->input('name', array('class'=>'validate[required,custom[name]] textBoxExpnd','type'=>'text','id'=>'name',
						'label'=> false,'div'=>false,'error'=>false,'value'=>$this->params->query['name']));?>
			</td>  
			
			<td>
				<?php echo __('Group Name') ?> :
			</td>
			
			<td>
				<?php echo  $this->Form->input('group_name',array('class'=>'validate[required,custom[name]] textBoxExpnd','type'=>'text','id'=>'group_name',
						'label'=>false,'div'=>false,'error'=>false,'value'=>$this->params->query['group_name']));?>
			</td>  
			
			<td>
				<?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));?>
			</td>
			
			<td>
				<?php echo $this->Form->submit(__('Show All Hidden Ledgers'),array('class'=>'blueBtn','div'=>false,'label'=>false,'value'=>'1',
						'name'=>'showLedger'));?>
			</td> 
			<?php 
			if ($this->Session->read('role') == 'Admin' || $this->Session->read('role') == 'Account Manager'){?> 
			<td>
    		 	<?php  echo $this->Html->link(__('Add Account'),array('controller'=>'Accounting','action'=>'account_creation'),
    		 			array('class'=>'blueBtn','div'=>false,'style'=>'margin-right: 0px;')); ?>
			</td>
			<?php }?>
			<td>
				<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'index'),array('escape'=>false));?>	
			</td>
		</tr>
	</tbody>
	<?php endif; ?>
</table> 
<?php echo $this->Form->end();?>
<div class="clr inner_title" style="text-align: right;"></div>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align: center; padding-top:10px;">
	<tr>
	<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
	<td width="95%" valign="top">
	<?php  if(AuthComponent::user()['id'] == 1): ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align: center;">
	<?php if(isset($data) && !empty($data)){  ?>
	<tr class="row_title">
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Account.name', __('Name', true)); ?></strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Account.status', __('Status', true)); ?></strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('AccountingGroup.name', __('Group Name', true)); ?></strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Account.account_code', __('Account Code', true)); ?></strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Account.balance', __('Balance', true)); ?></strong></td>
		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Account.opening_balance', __('Opening Balance', true)); ?></strong></td>
		<td class="table_cell" align="left"><strong><?php echo  __('Action'); ?></strong></td>
	</tr>
	<?php 	
	$toggle =0;
	if(count($data) > 0){
		foreach($data as $accountData){
	       if($toggle == 0) {
		       	echo "<tr class='row_gray'>";
		       	$toggle = 1;
	       }else{
		       	echo "<tr>";
		       	$toggle = 0;
	       }
	?>
	<td class="row_format" align="left"><?php echo ucfirst($accountData['Account']['name']); ?></td>
	<td class="row_format" align="left"><?php echo ucfirst($accountData['Account']['status']); ?></td>
	<td class="row_format" align="left"><?php echo ucfirst($accountData['AccountingGroup']['name']); ?></td>
	<td class="row_format" align="left"><?php echo $accountData['Account']['account_code']; ?></td>
	<td class="row_format" align="left">
		<?php if($accountData['Account']['balance'] < 0 ){
				$balanceData = $this->Number->currency(ceil(($accountData['Account']['balance'])*(-1)));
			}else{
				$balanceData = $this->Number->currency(ceil($accountData['Account']['balance']));
			}?>
		<?php if($accountData['Account']['balance']==0){
				echo $balanceData.' ' ; echo $accountData['Account']['payment_type'];
			}else if($accountData['Account']['balance']<0){
				echo $balanceData.' Cr' ;
			}else{ 
				echo $balanceData.' Dr' ;
			}?>
	</td>
	<td class="row_format" align="left">
		<?php if($accountData['Account']['opening_balance'] < 0 ){
				$balanceData = $this->Number->currency(ceil(($accountData['Account']['opening_balance'])*(-1)));
			}else{
				$balanceData = $this->Number->currency(ceil($accountData['Account']['opening_balance']));
			}?>
		<?php 
		if($accountData['Account']['opening_balance']==0){
			echo $balanceData.' ' ; echo $accountData['Account']['payment_type'];
		}else if($accountData['Account']['payment_type']=="Dr"){
			echo $balanceData.' Dr' ;
		}else{
			echo $balanceData.' Cr' ;
		}?>
	</td>
	
	<!--if there is no entry in ledger than they delete else ledger will not deleted.-->
	<td align="left">
		<?php 
			echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action'=>'account_creation',$accountData['Account']['id']),
				array('escape'=>false,'title'=>'Edit','alt'=>'Edit')); 
			if($accountData['Account']['balance'] == '0' && $countResult[$accountData['Account']['id']] == '0'){
				echo $this->Html->link($this->Html->image('icons/delete-icon.png'),array('action'=>'delete',$accountData['Account']['id']),
				array('escape'=>false,'title'=>'Delete','alt'=>'Delete'),__('Are you sure?', true));
   			}
   		?>
	</td>
	</tr>
	<?php } 
	//set get variables to pagination url
	$this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
	?>
	<tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->first(__('« First', true),array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->last(__('Last »', true),array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?></span>
		
		</TD>
	</tr>
	<?php }	
		}else{?>
	<tr>
		<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php } ?>
</table>
<?php else: ?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
				<tr> 
					<td>
						<h3 style='text-align:center'> You're not authorized!  </h3>
					</td>
				</tr>

			</table>
<?php endif; ?>
</td>
</tr>
</table>

<script>
  $(document).ready(function(){
	  $( "#name" ).autocomplete({
		  source: "<?php echo $this->Html->url(array("controller" => "Accounting", "action" => "ledger_search","name","plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});
	  $("#name").attr('placeHolder','Search by Name').focus();
	  $( "#group_name" ).autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","AccountingGroup","name",'null',"null",'null',"admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				
			 },
			 messages: {
			        noResults: '',
			        results: function() {}
			 }
		});	
	  $("#group_name").attr('placeHolder','Serach by Group');	
	 });
</script>