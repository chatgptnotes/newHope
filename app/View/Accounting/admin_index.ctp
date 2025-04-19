<div class="inner_title">
<h3><?php echo __('Accounting Management', true); ?></h3>

<span>
<?php
echo $this->Html->link(__('Add Accounting', true),array('action' => 'add'), array('escape' => false,'class'=>'blueBtn')); 
echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));?>
</span>
</div>

<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
  
  <tr class="row_title">
  <!--   <td class="table_cell"><strong><?php echo ( __('Id', true)); ?></strong></td>
   -->
   <td class="table_cell"><strong><?php echo ( __('Class', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo ( __('Status', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo (__('Effective', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo (__('Asset', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo ( __('Chargeable', true)); ?></strong></td>
     <td class="table_cell"><strong><?php echo ( __('Non chargeable ', true)); ?></strong></td>
     
      <td class="table_cell"><strong><?php echo ( __('Is Active', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo (__('Action', true)); ?></strong></td>
  </tr>
  <?php 
     // $cnt =0;
      //if(count($data) > 0) {
       //foreach($data as $hospital):
      // $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <!-- <td class="row_format"><?php echo $hospital['Facility']['id']; ?></td>
    -->
    <td class="row_format"><?php echo $hospital['Facility']['name']; ?> </td>
   <td class="row_format"><?php echo $hospital['Facility']['zipcode']; ?> </td>
   <td class="row_format"><?php echo $hospital['Facility']['email']; ?> </td>
   <td class="row_format"><?php echo $hospital['Facility']['mobile']; ?> </td>
   <td class="row_format">
    <?php 
           echo __('Yes', true); 
           
        
    ?> 
   </td>
     <td class="row_format">
    <?php 
           echo __('Yes', true); 
          
    ?> 
   </td>
    <td class="row_format">
    <?php 
           echo __('Yes', true); 
          
    ?> 
   </td>
   <td>
   <?php 
   echo $this->Html->image('icons/view-icon.png');
  echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit'), array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));
	echo $this->Html->image('icons/delete-icon.png');
	//echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view', $hospital['Facility']['id']), array('escape' => false,'title' => 'View', 'alt'=>'View'));
	//echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit', $hospital['Facility']['id']), array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));
	//echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $hospital['Facility']['id']), array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));
   ?>
  </tr>
  <?php //endforeach;  ?>
   <tr>
    <TD colspan="8" align="center">
    <!-- Shows the page numbers -->
 <?php //echo $this->Paginator->numbers(); ?>
 <!-- Shows the next and previous links -->
 <?php //echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'disabled')); ?>
 <?php //echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'disabled')); ?>
 <!-- prints X of Y, where X is current page and Y is number of pages -->
 <?php //echo $this->Paginator->counter(); ?>
    </TD>
   </tr>
  <?php
  
      //} else {
  ?>
  <tr>
   <TD colspan="8" align="center"><?php //echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
     // }
  ?>
  
 </table>

