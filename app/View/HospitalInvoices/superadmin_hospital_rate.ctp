<div class="inner_title">
<h3> &nbsp; <?php echo __('Enterprise Rate', true); ?></h3>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
  <tr>
  <td colspan="5" align="right">
  <?php echo $this->Html->link(__('Add Enterprise Rate'), array('controller' => 'hospital_invoices', 'action' => 'add_hospital_rate', 'superadmin' => true), array('escape' => false,'class'=>'blueBtn'));?>
  <?php echo $this->Html->link(__('Back'), array('controller' => 'hospital_invoices', 'action' => 'index', 'superadmin' => true), array('escape' => false,'class'=>'blueBtn'));?>
  </td>
  </tr>
 <tr class="row_title">
   <td class="table_cell" ><strong><?php echo $this->Paginator->sort('Facility.name', __('Enterprise Name', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('HospitalRate.ipd_rate', __('IPD Rate', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('HospitalRate.opd_rate', __('OPD Rate', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('HospitalRate.emergency_rate', __('Emergency Rate', true)); ?></strong></td>
   <td class="table_cell" align="center"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $dataval): 
       $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format" ><?php echo $dataval['Facility']['name']; ?> </td>
   <td class="row_format"><?php echo $dataval['HospitalRate']['ipd_rate']; ?> </td>
   <td class="row_format"><?php echo $dataval['HospitalRate']['opd_rate']; ?> </td>
   <td class="row_format"><?php echo $dataval['HospitalRate']['emergency_rate']; ?> </td>
   <td align="center">
   <?php 
   echo $this->Html->link($this->Html->image('icons/view-icon.png', array('alt' => __('View Hospital Rate', true),'title' => __('View Hospital Rate', true))), array('action' => 'view_hospital_rate', 'superadmin' => true,  $dataval['HospitalRate']['id']), array('escape' => false));
   ?>
   <?php 
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit Hospital Rate', true),'title' => __('Edit Hospital Rate', true))),array('action' => 'edit_hospital_rate', 'superadmin' => true, $dataval['HospitalRate']['id']), array('escape' => false));
   ?>
   <?php 
   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('alt' => __('Delete Hospital Rate', true),'title' => __('Delete Hospital Rate', true))), array('action' => 'delete_hospital_rate', 'superadmin' => true, $dataval['HospitalRate']['id']), array('escape' => false),__('Are you sure?', true));
   ?>
   </td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="5" align="center">
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
   <TD colspan="5" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>
</table>

