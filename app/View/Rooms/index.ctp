<div class="inner_title">
	<h3>	
			<div style="float:left"><?php echo __('Room Management').' - '.$wardName; ?></div>			
			<div style="float:right;"><?php
	       		echo $this->Html->link(__('Back'), array('controller' => 'wards', 'action' => 'index', 'admin' => true), array('escape' => false,'class'=>'blueBtn'));
			?>
			<?php 
   echo $this->Html->link(__('Add Room'), array('action' => 'add',$ward_id), array('escape' => false,'class'=>'blueBtn'));
   ?>
			</div>
	</h3>
	<div class="clr"></div>
</div>
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

<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr>
  <td colspan="8" align="right">
  <?php 
   //echo $this->Html->link(__('Add Room'), array('action' => 'add',$ward_id), array('escape' => false,'class'=>'blueBtn'));
   ?>
  </tr>
  </td>
  
  </tr>
  <tr>
   <!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Id', true)); ?></strong></td>
    -->
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('name', __('Room Name', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('bed_prefix', __('Bed Prefix', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('no_of_beds', __('Maximum Beds', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  
  <?php
  	  $toggle =0;
      if(count($data) > 0) {
       foreach($data as $room): 
        if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
  ?>
  
   <!-- <td class="row_format"><?php echo $room['Room']['id']; ?></td>
    -->
   <td class="row_format"><?php echo $room['Room']['name']; ?></td>
   <td class="row_format"><?php echo $room['Room']['bed_prefix']; ?></td>
   <td class="row_format"><?php echo $room['Room']['no_of_beds']; ?></td>
   <td class="row_format">
		   <?php 
			   echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title' => __('View', true),'alt' => __('View', true))), array('controller' => 'beds', 'action' => 'index', $room['Room']['id'],$room['Room']['ward_id'],'admin' => false), array('escape' => false));
			    
			   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title' => __('Edit', true),'alt' => __('Edit', true))),array('controller' => 'rooms','action' => 'edit', $room['Room']['id'],$room['Room']['ward_id'],'admin' => false), array('escape' => false));
			   
			   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title' => __('Delete', true),'alt' => __('Delete', true))), array('action' => 'delete', $room['Room']['id'],'admin' => false), array('escape' => false),__('Are you sure?', true));
		   
		   ?>
	</td>
   </tr>
   <?php endforeach;  
   ?>
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

 