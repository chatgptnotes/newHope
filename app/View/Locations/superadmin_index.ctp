<div class="inner_title">
<h3><?php echo __('Facility Management', true); ?></h3>
</div>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%">
  <tr>
  <td colspan="8" align="right">
  <?php 
   	echo $this->Html->link(__('Add Facility', true),array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
  ?>
  </td>
  </tr>
  <tr class="row_title">
   <!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Id', true)); ?></td>
    --><td class="table_cell"><strong><?php echo $this->Paginator->sort('name', __('Facility Name', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('zipcode', __('Zipcode', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('email', __('Email', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('mobile', __('Mobile', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('is_active', __('Active', true)); ?></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></td>
  </tr>
  <?php 
      $cnt=0;
      if(count($data) > 0) {
       foreach($data as $location): 
        $cnt++;
  ?>
  <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
  <!--   <td class="row_format"><?php echo $location['Location']['id']; ?></td>
   -->
   <td class="row_format"><?php echo $location['Location']['name']; ?> </td>
   <td class="row_format"><?php echo $location['Location']['zipcode']; ?> </td>
   <td class="row_format"><?php echo $location['Location']['email']; ?> </td>
   <td class="row_format"><?php echo $location['Location']['mobile']; ?> </td>
   <td class="row_format">
    <?php if($location['Location']['is_active'] == 1) {
           echo __('Yes', true); 
          } else { 
           echo __('No', true);
          }
    ?> 
   </td>
   <td class="row_format">
   <?php 
   		echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view', $location['Location']['id']), array('escape' => false,'title' => 'View', 'alt'=>'View'));
  
   		echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit', $location['Location']['id']), array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));
   
   		echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $location['Location']['id']), array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));
   ?>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="8" align="center">
    <!-- Shows the page numbers -->
 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
 <!-- Shows the next and previous links -->
 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
 <!-- prints X of Y, where X is current page and Y is number of pages -->
 <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
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

