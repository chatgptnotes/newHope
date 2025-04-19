<div class="inner_title">
 <h3>&nbsp;	
  <?php echo __('View Medical Item'); ?>	</h3>
  <span><?php
	echo $this->Html->link(__('Back'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
   ?></span>		
  
 
<div class="clr"></div>
</div>
<table border="0" cellpadding="0" cellspacing="0" align="center" class="table_view_format">
<tr class="first">
  <td class="row_format"><strong>
   <?php echo __('Item Category',true); ?></strong>
  </td>
  <td>
   <?php echo $MedicalItem['OtItemCategory']['name']; ?>
  </td>
 </tr>
 <tr >
  <td class="row_format">
  <strong>
   <?php echo __('Medical Name',true); ?>
  </strong>
  </td>
  <td>
   <?php echo $MedicalItem['PharmacyItem']['name']; ?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format">
   <strong>
   <?php echo __('Description',true); ?>
   </strong>
  </td>
  <td>
   <?php echo $MedicalItem['MedicalItem']['description']; ?>
  </td>
  </tr>
 <tr class="row_gray">
   <td class="row_format">
   <strong>
   <?php echo __('In Stock',true); ?>
   </strong>
  </td>
  <td>
   <?php echo $MedicalItem['MedicalItem']['in_stock']; ?>
  </td>
 </tr>
   
 </table>
  <table align="right">
 <tr>
	<td colspan="4" align="right">
	 <?php echo $this->Html->link(__('Cancel', true),array('action' => 'medical_item_list',"admin"=>true), array('escape' => false,'class'=>'grayBtn')); ?>
	 
	</td>
	</tr>
 </table>