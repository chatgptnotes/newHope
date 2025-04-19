<style>
.row_action img{
float:inherit;
}
</style>
<div class="inner_title">
<h3><?php echo __('Insurance Companies', true); ?></h3>
<span>
<?php echo $this->Html->link(__('Add Insurance Company'), array('action' => 'add'), array('escape' => false,'class'=>'blueBtn'));

 echo $this->Html->link(__('Back', true),array('controller' => 'corporate_locations', 'action' => 'common'), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
 <tr class="row_title">
 <!--  <td class="table_cell"><strong><?php echo $this->Paginator->sort('id');?></strong></td> 
   --><td class="table_cell" align="left"><strong><?php echo $this->Paginator->sort('name');?></strong></td>
  <td class="table_cell"><strong><?php echo $this->Paginator->sort('zip');?></strong></td>
  <td class="table_cell"><strong><?php echo $this->Paginator->sort('phone');?></strong></td>
  <td class="table_cell"><strong><?php echo $this->Paginator->sort('fax');?></strong></td>
  <td class="table_cell"><strong><?php echo $this->Paginator->sort('email');?></td>
  <td class="table_cell"><strong><?php echo __('Actions');?></strong></td>
 </tr>
 <?php
      $cnt =0;
      if(count($insuranceCompanies) > 0) {
       foreach($insuranceCompanies as $insuranceCompany): 
       $cnt++;
 ?>
 <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
  <!-- <td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['id']); ?>&nbsp;</td>
   -->
   <td class="row_format" align="left"><?php echo h($insuranceCompany['InsuranceCompany']['name']); ?>&nbsp;</td>
  <td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['zip']); ?>&nbsp;</td>
  <td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['phone']); ?>&nbsp;</td>
  <td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['fax']); ?>&nbsp;</td>
  <td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['email']); ?>&nbsp;</td>
  <td class="row_action">
  <?php 
   echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View Insurance Company'),'alt'=> __('View Insurance Company'))), array('action' => 'view',  $insuranceCompany['InsuranceCompany']['id']), array('escape' => false));
   ?>
   
   <?php 
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit Insurance Company'),'alt'=> __('Edit Insurance Company'))),array('action' => 'edit', $insuranceCompany['InsuranceCompany']['id']), array('escape' => false));
   ?>
   
   <?php 
   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete Insurance Company'),'alt'=> __('Delete Insurance Company'))), array('action' => 'delete', $insuranceCompany['InsuranceCompany']['id']), array('escape' => false),__('Are you sure?', true));
   
   ?>
   </td>
 </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="7" align="center">
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
   <TD colspan="13" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>
</table>