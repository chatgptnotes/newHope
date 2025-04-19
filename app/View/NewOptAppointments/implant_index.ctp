<style>
.row_action img{
float:inherit;
}
</style>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Surgical Implant Management', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Add Surgical Implant'),array('action' => 'implantAdd'),array('escape' => false,'class'=>'blueBtn'));
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr class="row_title">
    <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('name', __('Name', true)); ?></strong></td>
	<td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('is_active', __('Active', true)); ?></strong></td>
    <td class="table_cell" align="left"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php 
      $cnt =0;
      if(count($surgicalImplants) > 0) {
       foreach($surgicalImplants as $surgicalImplant): 
        $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format" align="left"><?php echo $surgicalImplant['SurgicalImplant']['name']; ?> </td>
   <td class="row_format" align="left">
	 <?php if($surgicalImplant['SurgicalImplant']['is_active'] == 1) {          
	           $imgSrc = 'active.png';
	           $activeTitle = 'Active';
	           $status = 0;
          } else {           
	           $imgSrc = 'inactive.jpg';
	           $activeTitle = 'InActive';
	           $status = 1;
          }
    echo $this->Html->link($this->Html->image('icons/'.$imgSrc), array('action' => 'changeStatus', $surgicalImplant['SurgicalImplant']['id'],$status), array('admin'=>false,'escape' => false,'title' => $activeTitle, 'alt'=>$activeTitle)); ?></td>
   <td class="row_action" align="left">
   <?php echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'implantView', $surgicalImplant['SurgicalImplant']['id']), array('escape' => false,'title' => 'View', 'alt'=>'View'));
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title' => __('Edit', true), 'alt' => __('Edit', true))), array('action' => 'implantEdit', $surgicalImplant['SurgicalImplant']['id']), array('escape' => false));  
   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title' => __('Delete', true), 'alt' => __('Delete', true))), array('action' => 'implantDelete', $surgicalImplant['SurgicalImplant']['id']), array('escape' => false),__('Are you sure?', true));   
   ?></td>
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

