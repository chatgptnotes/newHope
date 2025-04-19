<style>
.row_action img{
float:inherit;
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Incident Type Management'); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Add Incident Type', true),array('action' => 'add','admin'=>true), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back', true),array('controller'=>'users','action' => 'menu','?'=>array('type'=>'master'),'admin'=>'true'), array('escape' => false,'class'=>'blueBtn'));?>
	</span> <span><?php //echo $this->Html->link(__('Back'), array('controller' => 'patients', 'action' => 'patient_information',$patient_id), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>
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

<?php } ?>

<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
	<tr class="row_title">

		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('IncidentType.name', __('Incident Type', true)); ?>
		</strong></td>
		<td class="table_cell" align="left"><strong><?php echo  __('Description', true); ?>
		</strong></td>
		<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
		</td>
	</tr>
	<?php 
	$cnt =0;
	if(count($data) > 0) {
       foreach($data as $incidentTypes):
       $cnt++;
       ?>
	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>

		<td class="row_format" align="left"><?php echo $incidentTypes['IncidentType']['name']; ?>
		</td>
		<td class="row_format" align="left"><?php echo $incidentTypes['IncidentType']['description']; ?>
		</td>
		<td class="row_action"><?php 
		echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'add', $incidentTypes['IncidentType']['id'],'admin'=>true), array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));
		?> <?php
		echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $incidentTypes['IncidentType']['id'],'admin'=>true), array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));
		?>
		</td>
	</tr>
	<?php endforeach;  ?>
	<tr>
		<TD colspan="8" align="center">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		
		</TD>
	</tr>
	<?php

      } else {
  ?>
	<tr>
		<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
	</tr>
	<?php
      }
      ?>

</table>

