<style>
.row_action img{
float:inherit;
}
.table_format {
    padding: 1px;
}
</style>
	<div class="inner_title">
		<h3><?php echo __('Group Creation List'); ?></h3>			
 		<span>
 		<?php 
	 		if ($this->Session->read('role') == 'Admin' || $this->Session->read('role') == 'Account Manager' || $this->Session->read('role') == 'Account Assistant'){
	 			echo $this->Html->link(__('Add Group', true),array('action' => 'group_add'), array('escape' => false,'class'=>'blueBtn'));
	 		}
			//echo $this->Html->link(__('KPI Dashboard', true),array('action' => 'kpiDashboard','admin'=>false), array('escape' => false,'class'=>'blueBtn'));
 			echo $this->Html->link(__('Back'), array('controller' => 'Accounting', 'action' => 'group_creation'), array('escape' => false,'class'=>'blueBtn',
 					'style'=>'margin-left: 5px;'));
		?>
 		</span>
	</div>
	<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('Account',array('url'=>array('controller'=>'Accounting','action'=>'group_creation','admin'=>true),'type'=>'get','id'=>'index',
		'inputDefaults'=>array('div'=>false,'label'=>false,'error'=>false)));?>
<table border="0" cellpadding="0" cellspacing="0" width="400px" align="center">
	<tbody>
		<tr class="row_title">
			<td align="center" style="padding-left: 5px;">
				<?php echo __('Group Name'); ?> :
			</td>
			<td>
				<?php echo $this->Form->input('group_name', array('class'=>'validate[required,custom[name]] textBoxExpnd','type'=>'text',
						'id'=>'group_name','label'=>false,'div'=>false,'error'=>false,'value'=>$this->params->query['group_name']));?>
			</td>  
			
			<td align="center" colspan="2">
				<?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'search'));?>
			</td> 
			<td>
				<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Accounting','action'=>'group_creation','admin'=>true),array('escape'=>false));?>	
			</td>
		</tr>
	</tbody>
</table> 
<?php echo $this->Form->end();?>
<div class="clr inner_title" style="text-align: right;"></div>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center; padding-top: 10px;">
	<tr>
		<td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
		<td width="95%" valign="top">
			<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
 				<tr class="row_title">
   					<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('AccountingGroup.name', __('Group Name', true)); ?></strong></td>
   					<td class="table_cell" align="left"><strong><?php echo __('Action', true); ?></strong>
   				</tr>
			  <?php 
			  	 $cnt =0;
			       if(count($data) > 0) {
			       foreach($data as $group): 
			         $cnt++;
			  ?>
 				<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   					<td class="row_format" align="left"><?php echo ucfirst($group['AccountingGroup']['name']); ?> </td>
   					<td class="row_action" align="left">
   						<?php echo $this->Html->link($this->Html->image('icons/view-icon.png'),array('action'=>'group_view',$group['AccountingGroup']['id']),
   								array('escape' => false,'title' => 'View', 'alt'=>'View'));?>
    					<?php echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action'=>'group_edit', $group['AccountingGroup']['id']),
    							array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));?>
   						<?php 
   						if($countResult[$group['AccountingGroup']['id']] == '0'){
   							echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action'=>'admin_group_delete',
   								$group['AccountingGroup']['id']), array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));
						}
						?>
  					</td>
  				</tr>
  			<?php endforeach; ?>
				<tr>
				    <TD colspan="8" align="center">
				    <!-- Shows the page numbers -->
				 	<?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				 	<!-- Shows the next and previous links -->
				 	<?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				 	<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				 	<!-- prints X of Y, where X is current page and Y is number of pages -->
				 	<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
				    </TD>
				</tr>
  					<?php } else { ?>
  				<tr>
   					<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
  				</tr>
  				<?php } ?>
 			</table>
 		</td>
	</tr>
</table>
<script>
$(document).ready(function(){
	$( "#group_name" ).autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","AccountingGroup","name",'null',"null",
				'null',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});
});
$("#search").click(function(){
	var validateForm = jQuery("#index").validationEngine('validate');
	if(validateForm == true){
		return true;
	}else{
		return false;
	}
});
</script>
  