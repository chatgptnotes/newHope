<div class="inner_title">
<h3><img src="images/appointment_icon.png" /> &nbsp; <?php echo __('Doctor Management', true); ?></h3>
</div>

<table border="0" cellpadding="0" class="table_format" cellspacing="0" width="100%">
  <tr class="row_title">
  <td colspan="10" align="right">
  <?php echo $this->Html->link('Add Doctor',array("action" => "add"), array('class' => 'blueBtn','escape' => false)); ?>
  </td>
  </tr>
  <tr>
   <!--  <td class="table_cell"><strong><?php echo $this->Paginator->sort('Doctor.id', __('Id', true)); ?></td>
   -->
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Doctor.first_name', __('First Name', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Doctor.last_name', __('Last Name', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Doctor.email', __('Email', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Doctor.mobile', __('Mobile', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Doctor.is_active', __('Active', true)); ?></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></th>
  </tr>
  <?php 
       $cnt=0;
       if(count($data) > 0) {
       foreach($data as $doctor): 
         $cnt++;
  ?>
  <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?> >
   <!--  <td class="row_format"><?php echo $doctor['Doctor']['id']; ?></td>
   -->
   <td class="row_format"><?php echo $doctor['Doctor']['first_name']; ?> </td>
   <td class="row_format"><?php echo $doctor['Doctor']['last_name']; ?> </td>
   <td class="row_format"><?php echo $doctor['Doctor']['email']; ?> </td>
   <td class="row_format"><?php echo $doctor['Doctor']['mobile']; ?> </td>
   <td class="row_format">
    <?php if($doctor['Doctor']['is_active'] == 1) {
           echo __('Yes', true); 
          } else { 
           echo __('No', true);
          }
    ?> 
   </td>
   <td>
   <?php 
   		echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view', $doctor['Doctor']['id']), array('escape' => false,'title' => 'View', 'alt'=>'View'));
   ?>
    
   <?php 
   		echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit', $doctor['Doctor']['id']), array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));
   ?>
  
   <?php 
   		echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'delete', $doctor['Doctor']['id']), array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));
   
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

