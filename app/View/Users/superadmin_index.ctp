<div class="inner_title">
	<h3>&nbsp; <?php echo __('User Management', true); ?></h3>
	<span>
		<?php 
		   	echo $this->Html->link(__('Add User', true),array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
		   ?>
	</span>
</div>

<table border="0" cellpadding="0"  cellspacing="0" width="100%">
  <tr>
  <td colspan="10" align="right">
  	&nbsp;
  </td>
  </tr>
  <tr class="row_title">

   <td class="table_cell"><strong><?php echo $this->Paginator->sort('FacilityUserMapping.username', __('Username', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Facility.name', __('Company', true)); ?></td>
      <td class="table_cell"><strong><?php echo   __('Action', true); ?></td>
  </tr>
  <?php 
       $cnt =0;
      if(count($data) > 0) {
       foreach($data as $user): 
       $cnt++;
  ?>
  
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>

   <td class="row_format"><?php echo $user['FacilityUserMapping']['username'] ; ?> </td>
   <td class="row_format"><?php echo $user['Facility']['name']; ?> </td>

   <td>
   <?php 
   		echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view', $user['Facility']['id'],$user['FacilityUserMapping']['username']), array('escape' => false, 'title' => 'View', 'alt'=>'View'));
   ?>
    
   <?php 
   		echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit', $user['Facility']['id'],$user['FacilityUserMapping']['username']), array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));
   ?>
  
   <?php 
   		//echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $user['Facility']['id'],$user['FacilityUserMapping']['username']), array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));
   
   ?>
   </td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="10" align="center">
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
   <TD colspan="10" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>
</table>

