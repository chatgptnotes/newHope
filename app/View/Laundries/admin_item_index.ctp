<style>
.row_action img{
float:inherit;
}
.row_action img{float:inherit;}
</style>
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
<h3>&nbsp; <?php echo __('Laundry Item Management', true); ?></h3>
<span><?php 
	echo $this->Html->link(__('Add Item'),array('controller'=>'laundries','action' => 'item_add','admin'=>true),array('escape' => false,'class'=>'blueBtn')); 
	echo $this->Html->link(__('Allot Items to Room'),array('controller'=>'laundries','action' => 'index','inventory'=>true),array('escape' => false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Laundry Manager'),array('controller'=>'laundries','action' => 'manager','inventory'=>true),array('escape' => false,'class'=>'blueBtn'));
	?></span>

</div>
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr>
  <td colspan="6" align="right">
	
  <!-- <?php 
		echo $this->Html->link(__('Laundry'),array('controller'=>'laundries','action' => 'index','inventory'=>true),array('escape' => false,'class'=>'blueBtn')); 
?> -->
	</td>
 
  
  </tr>
  
  
  </tr>
  <tr class="row_title">
    <td class="table_cell" width="8%" align="left"><strong><?php echo $this->Paginator->sort('Sr. No', __('Sr. No', true)); ?></strong></td>
   
   <td class="table_cell" width="12%" align="left"><strong><?php echo $this->Paginator->sort('item_code', __('Item Code', true)); ?></strong></td>
   <td class="table_cell" width="23%" align="left"><strong><?php echo $this->Paginator->sort('name', __('Name', true)); ?></strong></td>
   <td class="table_cell" width="22%" align="left"><strong><?php echo $this->Paginator->sort('created_by', __('Created By', true)); ?></strong></td>
   <td class="table_cell" width="20%" align="left"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php
  	  $cnt =0;
      if(count($data) > 0) {
       foreach($data as $item): 
        $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format"  align="left"><?php echo $cnt; ?></td>
    
   <td class="row_format" align="left"><?php echo ucfirst($item['LaundryItem']['item_code']); ?> </td>
   <td class="row_format" align="left"><?php echo $item['LaundryItem']['name']; ?></td>
   <td class="row_format" align="left"><?php echo ($item['User']['first_name']=='')?__('Admin'):ucfirst($item['User']['first_name'])." ".ucfirst($item['User']['last_name']); ?> </td>
   
   <td class="row_action" align="left">
   <?php 
   echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'item_edit', $item['LaundryItem']['id']), array('escape' => false,'title'=>'edit this!'));
  
   echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'item_delete', $item['LaundryItem']['id']), array('title'=>'Delete this!','escape' => false),__('Are you sure?', true));
   
    
   ?></td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="8" align="center">
    <!-- Shows the page numbers -->
<?php if($this->params['paging']['LaundryItem']['pageCount'] > 1) {?>
 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
 <!-- Shows the next and previous links -->
 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
 <!-- prints X of Y, where X is current page and Y is number of pages -->
 <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
    </TD>
   </tr>
  <?php
		}
      } else {
  ?>
  <tr>
   <td colspan="8" align="center"><?php echo __('No record found', true); ?>.</td>
  </tr>
  <?php
      }
  ?>
  
 </table>

 
