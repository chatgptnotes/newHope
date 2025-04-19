<style>
.row_action img{
float:inherit;
}
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
<h3><?php echo __('Country Management'); ?></h3>			
 <span><?php  echo $this->Html->link(__('Add Country'),array('action' => 'add'),array('escape' => false,'class'=>'blueBtn')); 
 echo $this->Html->link(__('Back'), array('controller' => 'countries', 'action' => 'geographicmap'), array('escape' => false,'class'=>'blueBtn'));?></span>

</div>
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  </td>
  
  </tr>
  <tr class="row_title">
   <!--  <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Id', true)); ?></strong></td>
   -->
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('name', __('Name', true)); ?></strong></td>
   <td class="table_cell" align="left"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php
  	  $cnt =0;
      if(count($data) > 0) {
       foreach($data as $countries): 
        $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <!--  <td class="row_format"><?php echo $countries['Country']['id']; ?></td>
   -->
   <td class="row_format" align="left"><?php echo ucfirst($countries['Country']['name']); ?> </td>
      
   <td class="row_action" align="left">
   <?php 
   echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit', $countries['Country']['id']), array('escape' => false));
  
   echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $countries['Country']['id']), array('escape' => false),__('Are you sure?', true));
   
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
   <TD colspan="2" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>
  
 </table>

