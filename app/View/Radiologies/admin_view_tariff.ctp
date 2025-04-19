<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
<div class="inner_title">
<h3><?php echo __('Tariff Standard Radiology Rates'); ?></h3>			
 <span><?php //echo $this->Html->link(__('Back'), array('controller' => 'tariffs', 'action' => 'viewStandard'), array('escape' => false,'class'=>'blueBtn'));?></span>
</div>
<div class="btns">
               		<?php 
                           	echo $this->Html->link(__('Back'),array('action'=>'index','admin'=>true),array('escape' => false,'class'=>'blueBtn')) ;
					 		echo $this->Html->link(__('Add Tariff Standard'),array('action' => 'addStandard'),array('escape' => false,'class'=>'blueBtn'));
					 		?>		
</div>
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  
  <tr class="row_title">
   <!--  <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Id', true)); ?></strong></td>
   -->
   <td class="table_cell"><strong><?php echo $this->Paginator->sort('name', __('Name', true)); ?></strong></td>
   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
  </tr>
  <?php
  	  $cnt =0;
      if(count($data) > 0) {
       foreach($data as $tariff): 
        $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <!--  <td class="row_format"><?php echo $tariff['TariffStandard']['id']; ?></td>
   -->
   <td class="row_format"><?php echo ucfirst($tariff['TariffStandard']['name']); ?> </td>
   <td class="row_format">
   <?php 
   		echo $this->Html->link($this->Html->image('icons/view-icon.png',array('title'=>'Add Amount','alt'=>'Add Amount')), array('action' => 'edit_tariff_amount', $tariff['TariffStandard']['id']), array('escape' => false));
   
   ?></td>
  </tr>
  <?php endforeach;  ?>
   <tr>
    <TD colspan="8" align="center">
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
   <TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>
  
 </table>

