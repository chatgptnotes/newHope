<div class="inner_title">
<h3> &nbsp; <?php echo __('Credit Type Management', true); ?></h3>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
  <tr>
  <td colspan="10" align="right">
  <?php 
    echo $this->Html->link(__('Add Credit Type'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
   ?>
  </td>
  </tr>
 <tr class="row_title">
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('CreditType.id', __('Id', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('CreditType.name', __('Name', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('CreditType.description', __('Description', true)); ?></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></td>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $credittypes): 
       $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format"><?php echo $credittypes['CreditType']['id']; ?></td>
   <td class="row_format"><?php echo $credittypes['CreditType']['name']; ?> </td>
   <td class="row_format">
     <?php
           if(strlen($credittypes['CreditType']['description']) > 50) { 
           	echo substr($credittypes['CreditType']['description'], 0, 50); 
           } else {
           	echo $credittypes['CreditType']['description'];
           }
     ?> 
   </td>
   <td>
   <?php 
   echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Credit Type', true),'title' => __('View Credit Type', true))), array('action' => 'view',  $credittypes['CreditType']['id']), array('escape' => false));
   ?>
   
   <?php 
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Credit Type', true),'title' => __('Edit Credit Type', true))),array('action' => 'edit', $credittypes['CreditType']['id']), array('escape' => false));
   ?>
   
   <?php 
   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Credit Type', true),'title' => __('Delete Credit Type', true))), array('action' => 'delete', $credittypes['CreditType']['id']), array('escape' => false),__('Are you sure?', true));
   
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

