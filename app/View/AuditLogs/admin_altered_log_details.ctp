<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Altered Audit Logs', true); ?>
	</h3>
	<span> <?php
	echo $this->Html->link(__('Back', true),array('controller' => 'AuditLogs','action' => 'admin_audit_logs', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%">
		<tr>
			<td colspan="10" align="right"><?php 
			echo $this->Html->link(__('Add User'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
			?>
			</td>
		</tr>
		<tr class="row_title">
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('User.username', __('User Name', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('Audit.event', __('Event', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('Audit.model', __('Model', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('Audit.created', __('Activity Date/Time', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo __('Action', true); ?>
			
			</td>
		</tr>
	<?php 
		$cnt =0;
		if(count($data) > 0) {
       foreach($data as $user):
       $cnt++;
       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format"><?php echo $user['User']['username']; ?>
			</td>
			<td class="row_format"><?php echo $user['Audit']['event']; ?>
			</td>
			<td class="row_format"><?php echo $user['Audit']['model']; ?>
			</td>
			<td class="row_format">
			<?php echo $this->DateFormat->formatDate2Local($user['Audit']['created'],Configure::read('date_format'),true); ?>
			</td>
			<td><?php 
			echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view_altered_log',  $user['Audit']['id']), array('escape' => false,'title' => __('View', true), 'alt'=>__('View', true)));
			?>
			</td>
		</tr>
		<?php endforeach;  ?>
		<tr>
			<TD colspan="10" align="center">
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
	