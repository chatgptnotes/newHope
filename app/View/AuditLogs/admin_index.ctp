	<style>.row_action img{float:inherit;}</style>
	<?php
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Audit Logs List', true); ?>
	</h3>
	<span> <?php

	echo $this->Html->link(__('Back', true),array('controller' => 'AuditLogs','action' => 'admin_audit_logs', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));

	?>
	</span>
</div> 
	<?php 
		echo $this->Form->create('auditLogs',array('type'=>'get','id'=>'consultantsearchfrm' ));
	?>
	<table border="0" class="table_format" cellpadding="3" cellspacing="0" width="100%" align="center">
		<tr class="row_title">
			<td class=" " align="left" width="4%"><?php echo __('From') ?>
				: </td>
			<td width="20%"><?php 
			echo $this->Form->input('from', array( 'value'=>$this->request->query['from'],'id' => 'from', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
			?>
			</td>
			<td class=" " align="left" width="3%"><?php echo __('To') ?>
				:</td>
			<td class=" " width="20%"><?php 
			echo $this->Form->input('to', array( 'value'=>$this->request->query['to'], 'id' => 'to', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));

			?>
			</td>
			<td class=" " align="left" width="5%"><?php echo __('Module') ?>
				:</td>
			<td class=" " width="20%"><?php 
				$auditModels  = Configure::read('auditModel') ; 
				echo $this->Form->input('model', array('value'=>$this->request->query['model'],'type'=>'select','options'=>$auditModels,'empty'=>__('Please Select') , 'id' => 'model', 'label'=> false, 'div' => false, 'error' => false ,'autocomplete'=>false));
 			?>
			</td>
				<td class=" " align="left" width="5%"><?php echo __('Patient') ?>
				:</td>
			<td class=" " width="11%"><?php  
				echo $this->Form->input('patient', array('value'=>$this->request->query['patient']  , 'id' => 'patientId', 'label'=> false, 'div' => false, 'error' => false ,'autocomplete'=>false));
 			?>
			</td>
			<td><?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false)); ?>
				<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'index'),array('escape'=>false, 'title' => 'refresh','style'=>'float:right;'));?>
			</td>
		</tr>
	</table>
</form>
	<?php echo $this->Form->end();?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%">
		<tr>
			<td colspan="10" align="right"><?php 
			echo $this->Html->link(__('Add User'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
			?>
			</td>
		</tr>
		<tr class="row_title">
			<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('User.username', __('User Name', true)); ?>
			
			</td>
			<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Patient.lookup_name', __('Patient', true)); ?>
			
			</td>
			<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Audit.event', __('Event', true)); ?>
			
			</td>
			<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Audit.model', __('Model', true)); ?>
			
			</td> 
			<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Audit.created', __('Activity Date/Time', true)); ?>
			
			</td>
			<td class="table_cell" align="left"><strong><?php echo __('Action', true); ?>
			
			</td>
		</tr>
		<?php 
		$cnt =0;
		if(count($data) > 0) {
       foreach($data as $user):
       $cnt++;
       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format"  align="left"><?php echo $user['User']['username']; ?>
			</td>
			<td class="row_format" align="left"><?php echo ucfirst(strtolower($user['Person']['first_name']))." ".ucfirst(strtolower(($user['Person']['last_name']))); ?>
			</td>
			<td class="row_format" align="left"><?php echo $user['Audit']['event']; ?>
			</td>
			<td class="row_format" align="left"><?php echo ($auditModels[$user['Audit']['model']])?$auditModels[$user['Audit']['model']]:$user['Audit']['model']; ?>
			</td>
			<td class="row_format" align="left">
			<?php echo $this->DateFormat->formatDate2LocalForReport($user['Audit']['created'],Configure::read('date_format'),true); ?>
			</td>
			<td class="row_action" align="left"><?php 
			echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view',  $user['Audit']['id']), array('escape' => false,'title' => __('View', true), 'alt'=>__('View', true)));
			if($this->Session->read('role') == "admin" || $this->Session->read('role') == "Admin" || $this->Session->read('role') == "superadmin" || $this->Session->read('role') == "Superadmin") {
			 echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action' => 'edit',  $user['Audit']['id']), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
			 echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $user['Audit']['id']), array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));
			}
			?>
			</td>
		</tr>
		<?php endforeach;  ?>
		<tr>
			<TD colspan="10" align="center">
			 <?php echo $this->Paginator->options(array("url" => array("?"=>"from=$from&to=$to"))); ?>
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(); ?>
				
			</span>
			</TD>
		</tr>
		<?php
         } else {
  ?>
		<tr>
			<TD colspan="10" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php
      }
      ?>
	</table>
	<script>
	$(function() {
		$("#patientId").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","CONCAT(`Person`.`first_name`,' ', `Person`.`last_name`)",'null','null','no', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true }); 
	});
	
	$(function() {
		$("#from").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: '<?php echo $this->General->GeneralDate(false);?>',			
		});	
			
	 $("#to").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: '<?php echo $this->General->GeneralDate(false);?>',			
		});
	});	
</script>