<style>.row_action img{float:inherit;}</style> <?php
 echo $this->Html->script('jquery.autocomplete_pharmacy');
  echo $this->Html->css('jquery.autocomplete.css');

?>
<?php
  if(!empty($errors)) {
?>

<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
   <?php
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?>
  </td>
 </tr>
</table>
<?php } ?>
 <div class="inner_title">
<h3> &nbsp; <?php echo __('Specialty Management - List Outward', true); ?></h3>
	<span style="margin-top:-25px;">

	</span>

<div align="right">
 <?php
   echo $this->Html->link(__('Add Outward'), array('action' => 'outward'), array('escape' => false,'class'=>'blueBtn'));
   ?>
   <?php
   echo $this->Html->link(__('Get Specialty Stock Value'), array('action' => 'stock_value'), array('escape' => false,'class'=>'blueBtn'));
   ?>
  <?php
   echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
   ?>
</div>
</div>

<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">

  <tr class="row_title">
    <td class="table_cell" align="left"><strong>Sr. No.  </td>
   <td class="table_cell" align="left"><strong><?php echo  $this->Paginator->sort('InventoryOutward.date', __('Date')) ;?></strong></td>
  <td class="table_cell" align="left"><strong>Action</td>
  </tr>
  <?php
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $outward):
       $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
     <td class="row_format" align="left"><?php echo  $cnt; ?> </td>
    <td class="row_format" align="left"><?php echo $this->DateFormat->formatDate2Local($outward['InventoryOutward']['date'],Configure::read('date_format')); ?> </td>
<td class="row_action" align="left">
   <?php
   echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('alt' => __('Edit', true),'title' => __('Edit', true))),array('action' => 'outward_edit', $outward['InventoryOutward']['id']), array('escape' => false));
   ?>


   </td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="10" align="center">
     <!-- Shows the page numbers -->
     <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
     <!-- Shows the next and previous links -->
     <?php echo $this->Paginator->prev(__('<< Previous', true), null, null, array('class' => 'paginator_links')); ?>
     <?php echo $this->Paginator->next(__('Next >>', true), null, null, array('class' => 'paginator_links')); ?>
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

