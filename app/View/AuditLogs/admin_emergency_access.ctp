<style>.row_action img{float:inherit;}</style>
<?php
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Emergency User Management', true); ?>
	</h3>
	<span> <?php
	echo $this->Html->link(__('Add User'), array('action' => 'admin_add_emergency_user'), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back', true),array('controller'=>AuditLogs,'action' => 'audit_logs'), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div>
<form name="usersearchfrm" id="consultantsearchfrm"
	action="<?php echo $this->Html->url(array("action" => "emergency_access")); ?>"
	method="post">
	<table border="0" class="table_format" cellpadding="3" cellspacing="0"
		width="100%" align="center">
		<tr class="row_title">
			<td class=" " align="left" width="12%"><?php echo __('First Name') ?>
				:</td>
			<td class=" "><?php 
			echo $this->Form->input('', array('name' => 'first_name', 'id' => 'first_name', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));
			?>
			</td>
			<td class=" " align="left" width="12%"><?php echo __('Last Name') ?>
				:</td>
			<td class=" "><?php 
			echo $this->Form->input('', array('name' => 'last_name', 'id' => 'last_name', 'label'=> false, 'div' => false, 'error' => false, 'type'=> 'text','autocomplete'=>false));

			?>
			</td>
			<td><?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false)); ?>
				<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'index'),array('escape'=>false, 'title' => 'refresh'));?>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>
	
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%">
		
		<tr class="row_title">
			<!--  <td class="table_cell"><strong><?php echo $this->Paginator->sort('User.id', __('Id', true)); ?></td>
   -->
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('User.username', __('Username', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('User.first_name', __('First Name', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('User.last_name', __('Last Name', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('Role.name', __('Role', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('User.mobile', __('Mobile', true)); ?>
			
			</td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('User.expiary_date', __('Expiry Date', true)); ?>
			
			</td>


			<!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('User.is_active', __('Active', true)); ?></td>
    -->
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
			<!-- <td class="row_format"><?php echo $user['User']['id']; ?></td>
    -->
			<td class="row_format"><?php echo $user['User']['username']; ?>
			</td>
			<td class="row_format"><?php echo $user['Initial']['name']."&nbsp;".$user['User']['first_name']; ?>
			</td>
			<td class="row_format"><?php echo $user['User']['last_name']; ?>
			</td>
			<td class="row_format"><?php echo $user['Role']['name']; ?>
			</td>
			<td class="row_format"><?php echo $user['User']['mobile']; ?>
			</td>
			<td class="row_format"><?php echo $this->DateFormat->formatDate2Local($user['User']['expiary_date'],Configure::read('date_format'),true); ?>
			</td>


			<!-- <td class="row_format">
    <?php if($user['User']['is_active'] == 1) {
           //echo __('Yes', true); 
          } else { 
           //echo __('No', true);
          }
    ?> 
   </td>
    -->
			<td class="row_action" align="left"><?php 
			echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view_emergency_user',  $user['User']['id']), array('escape' => false,'title' => __('View', true), 'alt'=>__('View', true)));
			?> <?php
			echo $this->Html->link($this->Html->image('icons/sign-icon.png'),array('controller'=>'Permissions','action' => 'user_permission', $user['User']['id'],'emer'), array('escape' => false,'title' => __('Assign Permission', true), 'alt'=>__('Assign Permission', true)));
			?> <?php
			echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action' => 'edit_emergency_user', $user['User']['id']), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
			?> <?php
			//if(($user['Role']['name'] != "admin" || $user['User']['created_by'] == $this->Session->read('userid')) && $user['User']['id'] != $this->Session->read('userid')) {
    //echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('controller'=>'Users','action' => 'delete', $user['User']['id']), array('escape' => false,'title' => __('Delete', true), 'alt'=>__('Delete', true)),__('Are you sure?', true));
   //}

   ?></td>
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
	<script>
	$(function() {
		$("#first_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","User","first_name",'null','null','no', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
		$("#last_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","User","last_name",'null','null','no', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true });
	});
</script>