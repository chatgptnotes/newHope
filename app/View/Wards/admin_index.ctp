<style>.row_action img{float:inherit;}</style>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Ward Management', true); ?></h3>
<span><?php  echo $this->Html->link(__('Add Ward'), array('action' => 'addWard','admin'=>false), array('escape' => false,'class'=>'blueBtn','div'=>false));
   		echo $this->Html->link('Back',array('action'=>'ward_occupancy','admin'=>false),array('escape'=>true,'class'=>'blueBtn' ));?></span>
</div>

<?php// debug($wards); exit;?>
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
   		
   ?>
  </tr>
  </td>
  
  </tr>
  <tr class="row_title">
   <!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Id', true)); ?></strong></td>
    -->
    <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('name', __('Ward Type', true)); ?></strong></td>
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('Location.name', __('Location', true)); ?></strong></td>
   <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('wardid', __('Ward ID', true)); ?></strong></td>
   <td class="table_cell" align="center"><strong><?php echo $this->Paginator->sort('no_of_rooms', __('Maximum Rooms', true)); ?></strong></td>
   <!-- <td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('created_by', __('Created By', true)); ?></strong></td>
    --><td class="table_cell" align="left"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php
  	  $toggle =0;
      if(count($data) > 0) {
       foreach($data as $wards): 
        if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
  ?>
 
   <!-- <td class="row_format"><?php echo $wards['Ward']['id']; ?></td>
    -->
    <td class="row_format" align="left"><?php echo ucfirst($wards['Ward']['name']); ?> </td>
   <td class="row_format" align="left"><?php echo ucfirst($wards['Location']['name']); ?> </td>
   <td class="row_format" align="left"><?php echo ucfirst($wards['Ward']['wardid']); ?> </td>
   <td class="row_format" align="center"><?php echo ucfirst($wards['Ward']['no_of_rooms']); ?> </td>
 <!--   <td class="row_format" align="left"><?php echo ($wards['User']['first_name']=='')?__('Admin'):ucfirst($wards['User']['first_name'])." ".ucfirst($wards['User']['last_name']); ?> </td>
    -->
  	 <td class="row_action" align="left">
		   <?php 
			   echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View', true), 'title' => __('View', true))), array('controller' => 'rooms', 'action' => 'index', $wards['Ward']['id'],'admin' => false), array('escape' => false));
			    
			   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit', true), 'title' => __('Edit', true))),array('action' => 'editWard', $wards['Ward']['id'],'admin' => false), array('escape' => false));
			   
			   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete', true), 'title' => __('Delete', true))), array('action' => 'delete', $wards['Ward']['id'],'admin' => true), array('escape' => false),__('Are you sure?', true));
		   
		   ?>
	</td>
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

