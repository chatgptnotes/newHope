<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Category Management', true); ?></h3>

</div>
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr>
  <td colspan="8" align="right">
  <?php 
   echo $this->Html->link(__('Add Category'),array('action' => 'add'),array('escape' => false,'class'=>'blueBtn')); 
  ?>
  </tr>
  </td>
  
  </tr>
  <tr class="row_title">
    <th class="table_cell"><strong><?php echo $this->Paginator->sort('Id', __('Sr. No', true)); ?></strong></th>
   <th class="table_cell"><strong><?php echo $this->Paginator->sort('catecory_code', __('Category Code', true)); ?></strong></th>
   <th class="table_cell"><strong><?php echo $this->Paginator->sort('name', __('Name', true)); ?></strong></th>
   <th class="table_cell"><strong><?php echo $this->Paginator->sort('created_by', __('Created By', true)); ?></strong></th>
   <th class="table_cell"><strong><?php echo __('Action', true); ?></strong></th>
  </tr>
  <?php
  	  $cnt =0;
      if(count($data) > 0) {
       foreach($data as $category): 
        $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format"><?php echo $category['InventoryCategory']['id']; ?></td>
   <td class="row_format"><?php echo $category['InventoryCategory']['category_code']; ?></td>
   <td class="row_format"><?php echo ucfirst($category['InventoryCategory']['name']); ?> </td>
   <td class="row_format"><?php echo ($category['User']['first_name']=='')?__('Admin'):ucfirst($category['User']['first_name'])." ".ucfirst($category['User']['last_name']); ?> </td>
   
   <td class="row_format">
   <?php 
   echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit', $category['InventoryCategory']['id']), array('escape' => false));
  
   echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $category['InventoryCategory']['id']), array('escape' => false),__('Are you sure?', true));
   
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

