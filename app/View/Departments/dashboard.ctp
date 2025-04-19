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
<h3> &nbsp; <?php echo __('Dashboard', true); ?></h3>

</div>
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
   
  <tr class="row_title">
   <!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Id', true)); ?></strong></td>
    -->
     <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('name', __('Specialty Name', true)); ?></strong></td>
     <td class="table_cell" align="left"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php
  	  $toggle =0;
      if(count($data) > 0) {
       foreach($data as $countries): 
        if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
  ?>
 
   <!-- <td class="row_format"><?php echo $countries['Department']['id']; ?></td>
    -->
    <td class="row_format" align="left"><?php echo ucfirst($countries['Department']['name']); ?> </td> 
   	<td class="row_format" align="left">
   <?php 
   		echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View', true), 'title' => __('View', true))), array('action' => 'dashboard', $countries['Department']['id']), array('escape' => false));
    
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

