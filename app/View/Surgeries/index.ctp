<?php echo $this->Html->script(array('inline_msg','jquery.autocomplete' ,'jquery.selection.js','jquery.fancybox-1.3.4' ,'jquery.tooltipster.min.js' ,'jquery.blockUI','jquery.contextMenu'));
	echo $this->Html->css(array('tooltipster.css','jquery.autocomplete.css','jquery.fancybox-1.3.4.css','jquery.contextMenu')); ?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Surgery Management', true); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Add Surgery'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back'), array('controller' => 'opts', 'action' => 'listAllOt'), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
	
</div>
	<div style="padding: 15px 0 0 20px">
		<?php echo $this->Form->create(array(
				'inputDefaults' => array(
							        'label' => false,
							       
				)
    ));?>
		<div style="float:left; padding: 0 8px 0 0;">Surgery Name:</div>
			<?php echo $this->Form->input('surgery_name',array('id'=>'surgery_name','label'=>false, 'div'=>false));?>
		
			<?php echo $this->Form->submit('Submit',array('id'=>'submit','name'=>'Submit','class'=>'blueBtn',
					'label'=>false,'div'=>false));?></div>
		<?php $this->Form->end();?>
	
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr class="row_title">
		<!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('Surgery.id', __('Id', true)); ?></td>
    -->
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('Surgery.name', __('Name', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo $this->Paginator->sort('Surgery.description', __('Description', true)); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $surgeries):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		<!-- <td class="row_format"><?php echo $surgeries['Surgery']['id']; ?></td>
    -->
		<td class="row_format"><?php echo $surgeries['Surgery']['name']; ?>
		</td>
		<td class="row_format"><?php
		if(strlen($surgeries['Surgery']['description']) > 50) {
           	echo substr($surgeries['Surgery']['description'], 0, 50);
           } else {
           	echo $surgeries['Surgery']['description'];
           }
           ?>
		</td>
		<td><?php 
		echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Surgery', true),'title' => __('View Surgery', true))), array('action' => 'view',  $surgeries['Surgery']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Surgery', true),'title' => __('Edit Surgery', true))),array('action' => 'edit', $surgeries['Surgery']['id']), array('escape' => false));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Surgery', true),'title' => __('Delete Surgery', true))), array('action' => 'delete', $surgeries['Surgery']['id']), array('escape' => false),__('Are you sure?', true));
			
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
		<TD colspan="4" align="center"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php
      }
      ?>
</table>

<script>

$(document).ready(function(){
	 
	$("#surgery_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Surgery","name",'null','null','null','location_id='.$this->Session->read('locationid'),"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});
});
</script>
