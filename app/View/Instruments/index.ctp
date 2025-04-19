<style>
.row_action img{
float:inherit;
}
</style>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Instrument Management', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Add Instrument'),array('action' => 'add'),array('escape' => false,'class'=>'blueBtn'));
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr class="row_title">
     <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('id', __('Id', true)); ?></strong></td>
    <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('name', __('Name', true)); ?></strong></td>
    <td class="table_cell" align="left"><strong><?php echo __('Active', true); ?></strong></td>
    <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('is_active', __('Action', true)); ?></strong></td>
  </tr>
  <?php 
  $page = (isset($this->params->named['page']))?$this->params->named['page']:1 ;
  $srNo = ($this->params->paging[$this->Paginator->defaultModel()]['limit']) * ($page-1);
  
  	
  
  
      $cnt =0;
      if(count($instruments) > 0) {
       foreach($instruments as $designation): 
        $cnt++;
       $srNo++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
    <td class="row_format" align="left"><?php echo $srNo; ?></td>
   <td class="row_format" align="left"><?php echo $designation['DeviceMaster']['device_name']; ?> </td>
    <td class="row_format" align="left">
    <?php if($designation['DeviceMaster']['is_active'] == 1) {
           echo __('Yes', true); 
	           $imgSrc = 'active.png';
	           $activeTitle = 'Active';
	           $status = 0;
          } else { 
           echo __('No', true);
	           $imgSrc = 'inactive.jpg';
	           $activeTitle = 'InActive';
	           $status = 1;
          }
    ?> 
   </td>
   <td class="row_action" align="left">
   <?php 
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title' => __('Edit', true), 'alt' => __('Edit', true))), array('action' => 'edit', $designation['DeviceMaster']['id']), array('escape' => false));
   echo $this->Html->link($this->Html->image('icons/'.$imgSrc), array('action' => 'change_status', $designation['DeviceMaster']['id'],$status),
   		array('admin'=>true,'escape' => false,'title' => $activeTitle, 'alt'=>$activeTitle));
   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title' => __('Delete', true), 'alt' => __('Delete', true))), array('action' => 'delete', $designation['DeviceMaster']['id']), array('escape' => false),__('Are you sure?', true));
   
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

