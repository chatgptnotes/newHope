<style>
.row_action img{
float:inherit;
}
</style>
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
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Manage Patient Centric Department', true); ?>
	</h3>
	<span> <?php
	echo $this->Html->link(__('Add Patient Centric Department'), array('action' => 'add',"admin"=>true), array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div>
<div class="btns">
	<?php
	
	?>
</div>
<table
	class="table_format" border="0" cellpadding="0" cellspacing="0"
	width="100%" style="text-align: center;">
	<!-- <tr>
	  <td colspan="8" align="right">
	  <?php
             echo $this->Html->link(__('Add Patient Centric Department'), array('action' => 'add',"admin"=>true), array('escape' => false,'class'=>'blueBtn'));
	   ?>
	  </td>
  </tr> -->
	<tr class="row_title">

		<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('name', __('Name', true)); ?>
		</strong></td>
		<!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('linked_with', __('Mapped With', true)); ?></strong></td>-->
		<td class="table_cell" align="left"><strong><?php echo __('Action', true); ?> </strong>
		</td>
	</tr>
	<?php
	$toggle =0;
	if(count($data) > 0) {
       foreach($data as $department):
       if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
       ?>


	<td class="row_format" align="left"><?php echo ucfirst($department['PatientCentricDepartment']['name']); ?>
	</td>
	<!--   <td class="row_format"><?php // echo ($department['PatientCentricDepartment']['linked_with']); ?> </td>-->
	<td class="row_action" align="left"><?php
	echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit', true), 'title' => __('Edit', true))), array('action' => 'edit', $department['PatientCentricDepartment']['id'],"admin"=>true), array('escape' => false));

	echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete', true), 'title' => __('Delete', true))), array('action' => 'delete', $department['PatientCentricDepartment']['id'],"admin"=>true), array('escape' => false),__('Are you sure?', true));

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
			<span class="paginator_links"><?php echo $this->Paginator->counter(); ?>
		</span>
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

