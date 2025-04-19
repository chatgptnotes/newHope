<div class="inner_title">
<h3> &nbsp; <?php echo __('Corporate Location Management', true); ?></h3>
<span>
<?php echo $this->Html->link(__('Add Corporate Location'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));
 echo $this->Html->link(__('Back', true),array('controller' => 'corporate_locations', 'action' => 'common'), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
 <tr class="row_title">
   <!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('CorporateLocation.id', __('Id', true)); ?></td>
    -->
    <td class="table_cell"><strong><?php echo $this->Paginator->sort('CorporateLocation.name', __('Name', true)); ?></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('CorporateLocation.description', __('Description', true)); ?></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></td>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $corporatelocations): 
       $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <!-- <td class="row_format"><?php echo $corporatelocations['CorporateLocation']['id']; ?></td>
    -->
    <td class="row_format"><?php echo $corporatelocations['CorporateLocation']['name']; ?> </td>
   <td class="row_format">
     <?php
           if(strlen($corporatelocations['CorporateLocation']['description']) > 50) { 
           	echo substr($corporatelocations['CorporateLocation']['description'], 0, 50); 
           } else {
           	echo $corporatelocations['CorporateLocation']['description'];
           }
     ?> 
   </td>
   <td>
   <?php 
   echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Corporate Location', true),'title' => __('View Corporate Location', true))), array('action' => 'view',  $corporatelocations['CorporateLocation']['id']), array('escape' => false));
   ?>
   
   <?php 
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Corporate Location', true),'title' => __('Edit Corporate Location', true))),array('action' => 'edit', $corporatelocations['CorporateLocation']['id']), array('escape' => false));
   ?>
   
   <?php 
   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Corporate Location', true),'title' => __('Delete Corporate Location', true))), array('action' => 'delete', $corporatelocations['CorporateLocation']['id']), array('escape' => false),__('Are you sure?', true));
   
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

