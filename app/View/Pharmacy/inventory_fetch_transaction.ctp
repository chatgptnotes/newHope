<?php
echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));	
?>
<style>
th {
    background: -moz-linear-gradient(center top , #3E474A, #343D40) repeat scroll 0 0 transparent;
    border-bottom: 1px solid #3E474A;
    color: #FFFFFF;
    font-size: 12px;
    padding: 5px 8px;
    text-align: left;
}
.row_gray {
    background-color: #252C2F;
    border-top: 1px solid #000000;
    margin: 0;
    padding: 7px 3px;
	color:#fff !important;
}
/*.whiteclass{ color:#fff;}*/
</style> 
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table-format">
  
</table>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  <tr class="row_title" >
   
   <th class="row_format" style='text-align:center'><strong><?php echo  __('Vendor Name', true) ;?> </th>
   <th class="row_format" style='text-align:center'><strong><?php echo __('Code', true);  ?></th>
  </tr>
  <?php 
      $cnt =0;
      if(count($data) > 0) {
       foreach($data as $supplier): 
       $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?> onclick="window.location.href='<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "view_transaction",$supplier['InventorySupplier']['id'],"inventory" => true,"plugin"=>false)); ?>';" style="cursor:pointer">

   <td class="row_format" ><?php echo $supplier['InventorySupplier']['name']; ?> </td>
  <td class="row_format"><?php echo $supplier['InventorySupplier']['code']; ?> </td>
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

 