<div class="inner_title">
<h3><?php echo __('Tax Rule Management', true); ?></h3>
<span>
<?php
echo $this->Html->link(__('Add Tax Rule', true),array('action' => 'admin_add_taxrules'), array('escape' => false,'class'=>'blueBtn')); 
echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>

</div>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%">
  <tr class="row_title">
   <td class="table_cell" align="left"><strong><?php echo (__('Tax authority', true)); ?></td>
   <td class="table_cell" align="left"><strong><?php echo  (__('Discription', true)); ?></td>
   <td class="table_cell" align="left"><strong><?php echo  (__('Is Active', true)); ?></td>
   <td class="table_cell" align="left"><strong><?php echo (__('Action', true)); ?></td>
  </tr>
  
  <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
    <td class="row_format">Washington State</td>
    <td class="row_format" align="left">Sale tax rule </td>
   <td class="row_format" align="left">Yes </td>
    <td class="row_format" align="left">
   <?php echo $this->Html->image('icons/view-icon.png');?>
    
   <?php echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit_taxrules'), array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));?>
  
   <?php echo $this->Html->image('icons/delete-icon.png'); ?>
   </td>
  </tr>
 </table>
  