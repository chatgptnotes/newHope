<div class="inner_title">
<h3><?php echo __('External Consultant', true); ?></h3>
<span>
<?php
  echo $this->Html->link('Add',array("action" => "inhouse_externaldoctor_add"), array('class' => 'blueBtn','escape' => false));
  echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px;'));
?>
</span>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
  <tr>
  <td colspan="8" align="right">
  <?php 
     
  ?>
  </td>
  </tr>
  <tr class="row_title">
   <!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Id', true)); ?></strong></td>
    -->
    <td class="table_cell"><strong><?php echo $this->Paginator->sort('first_name', __('First Name', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('last_name', __('Last Name', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('email', __('Email', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('mobile', __('Mobile', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('ReffererDoctor.name', __('Type', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $consultant):
         $cnt++
  ?>
   <tr <?php if($cnt%2 ==0) { echo "class='row_gray'"; }?> >
   <!--<td class="row_format"><?php echo $consultant['Consultant']['id']; ?></td>
   -->
   <td class="row_format"><?php echo $consultant['Initial']['name']." ".$consultant['Consultant']['first_name']; ?> </td>
   <td class="row_format"><?php echo $consultant['Consultant']['last_name']; ?> </td>
   <td class="row_format"><?php echo $consultant['Consultant']['email']; ?> </td>
   <td class="row_format"><?php echo $consultant['Consultant']['mobile']; ?> </td>
   <td class="row_format"><?php echo $consultant['ReffererDoctor']['name']; ?></td>
   <td>
   <?php 
   		echo $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'inhouse_externaldoctor_view', $consultant['Consultant']['id']), array('escape' => false,'title' => 'View', 'alt'=>'View'));
   ?>
    
   <?php 
   		echo $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'inhouse_externaldoctor_edit', $consultant['Consultant']['id']), array('escape' => false,'title' => 'Edit', 'alt'=>'Edit'));
   ?>
  
   <?php 
   		echo $this->Html->link($this->Html->image('icons/delete-icon.png'), array('action' => 'inhouse_externaldoctor_delete', $consultant['Consultant']['id']), array('escape' => false,'title' => 'Delete', 'alt'=>'Delete'),__('Are you sure?', true));
   
   ?>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="8" align="center">
    <!-- Shows the page numbers -->
 <?php echo $this->Paginator->numbers(); ?>
 <!-- Shows the next and previous links -->
 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'disabled')); ?>
 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'disabled')); ?>
 <!-- prints X of Y, where X is current page and Y is number of pages -->
 <?php echo $this->Paginator->counter(); ?>
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

