<div class="inner_title">
<h3><?php echo __('Manufacturer Management', true); ?></h3>
<span>
<?php
echo $this->Html->link(__('Add Manufacturer', true),array('action' => 'admin_add_manufacturers'), array('escape' => false,'class'=>'blueBtn')); 
echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%">
  
  <tr class="row_title"> <td class="table_cell"><strong><?php echo (__('ID', true)); ?></td>
    <td class="table_cell" align="left"><strong><?php echo (__('Name', true)); ?></td>
   <td class="table_cell" align="left"><strong><?php echo  (__('Address', true)); ?></td>
   <td class="table_cell" align="left"><strong><?php echo  (__('Phone No', true)); ?></td>
   <td class="table_cell" align="left"><strong><?php echo  (__('Is Active', true)); ?></td>
   <td class="table_cell" align="left"><strong><?php echo (__('Action', true)); ?></td>
  </tr>
  
  
  	<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
    <td class="row_format">1026589</td>
   <td class="row_format" align="left">Health Care </td>
   <td class="row_format" align="left">Beaverton,OR,97006,US </td>
   <td class="row_format" align="left">8162766909 </td>
   <td class="row_format" align="left">Yes</td>
   <td class="row_format" align="left">
   <?php 
   		echo $this->Html->image('icons/view-icon.png');
   ?>
    
   <?php 
   		echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit_manufacturers'), array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));
   ?>
  
   <?php  
   		echo $this->Html->image('icons/delete-icon.png');
   
   ?>
   </td>
   
  </tr>
 </table>
  