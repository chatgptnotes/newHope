<div class="inner_title">
<h3> &nbsp; <?php echo __('Referer Doctor Management', true); ?></h3>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
  <tr>
  <td colspan="10" align="right">
  <?php 
    echo $this->Html->link(__('Add Referer Doctor'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
   ?>
  </td>
  </tr>
 <tr class="row_title">
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('ReffererDoctor.id', __('Id', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('ReffererDoctor.name', __('Name', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('ReffererDoctor.description', __('Description', true)); ?></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></td>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $reffererdoctors): 
       $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format"><?php echo $reffererdoctors['ReffererDoctor']['id']; ?></td>
   <td class="row_format"><?php echo $reffererdoctors['ReffererDoctor']['name']; ?> </td>
   <td class="row_format">
     <?php
           if(strlen($reffererdoctors['ReffererDoctor']['description']) > 50) { 
           	echo substr($reffererdoctors['ReffererDoctor']['description'], 0, 50); 
           } else {
           	echo $reffererdoctors['ReffererDoctor']['description'];
           }
     ?> 
   </td>
   <td>
   <?php 
   echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Referer Doctor', true),'title' => __('View Referer Doctor', true))), array('action' => 'view',  $reffererdoctors['ReffererDoctor']['id']), array('escape' => false));
   ?>
   
   <?php 
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Referer Doctor', true),'title' => __('Edit Referer Doctor', true))),array('action' => 'edit', $reffererdoctors['ReffererDoctor']['id']), array('escape' => false));
   ?>
   
   <?php 
   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Referer Doctor', true),'title' => __('Delete Referer Doctor', true))), array('action' => 'delete', $reffererdoctors['ReffererDoctor']['id']), array('escape' => false),__('Are you sure?', true));
   
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

