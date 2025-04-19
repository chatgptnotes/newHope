<style>.row_action img{float:inherit;}</style>
<div class="inner_title">
<h3><?php echo __('Manage Preference Card', true); ?></h3>
<span>
<?php
echo $this->Html->link(__('Add Preference Card', true),array('action' => 'add_preference',$patient_id), array('escape' => false,'class'=>'blueBtn'));
 echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>"blueBtn"));
 ?>
</span>
</div>

<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%">
  <tr>
  <td colspan="8" align="right">
  <?php 
       ?>
  </td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr class="row_title">
   
    <td class="table_cell" align="left"><strong>Preference Card</strong></td>
   <td class="table_cell" align="left"><strong>Procedure Name</strong></td>
   <td class="table_cell" align="left"><strong>Primary care provider</strong></td>
   <td class="table_cell" align="left"><strong>Action</strong></td>
 
  </tr>
  <?php 
      $cnt=0;
      if(count($getData) > 0) {
      

       foreach($getData as $pref_data): 
        $cnt++;
  ?>
  <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
  
   <td class="row_format" align="left"><?php echo ucwords($pref_data['PreferencecardRad']['card_title']); ?> </td>
   <td class="row_format" align="left"><?php echo $pref_data['Surgery']['name']; ?> </td>
   <td class="row_format" align="left"><?php echo "DR. ".$pref_data['User']['first_name']." ".$pref_data['User']['last_name'] ?> </td>
   <td class="row_action" align="left">
   
    <?php  //echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Add/Edit')),array('controller'=>'radiologies','action' => 'radiology_result',$labs['RadioManager']['patient_id'],$labs['Radiology']['id'],$labs['RadioManager']['id']), array('escape'=>false));
		echo  $this->Html->link($this->Html->image('icons/view-icon.png'), array('action' => 'view_preference',$pref_data['PreferencecardRad']['id'],$pref_data['PreferencecardRad']['patient_id']), array('escape' => false,'title' => __('View', true), 'alt'=>__('View', true)));
		echo  $this->Html->link($this->Html->image('icons/edit-icon.png'), array('action' => 'edit_preference',$pref_data['PreferencecardRad']['id'],$pref_data['PreferencecardRad']['patient_id']), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
     echo $this->Html->link($this->Html->image('icons/print.png'),'#',array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_preferencecard',$pref_data['PreferencecardRad']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700');  return false;"));
    echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('alt'=>__('Delete'),'title'=>__('Delete'))), array('action' => 'delete', $pref_data['PreferencecardRad']['id']), array('escape' => false,'title'=>'Delete'),"Are you sure you wish to delete this Preference card?");

    

    ?>
   </td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="8" align="center">
    <!-- Shows the page numbers -->
 <?php //echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
 <!-- Shows the next and previous links -->
 <?php //echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
 <?php //echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
 <!-- prints X of Y, where X is current page and Y is number of pages -->
 <span class="paginator_links"><?php //echo $this->Paginator->counter(); ?></span>
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

