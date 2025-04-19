<div class="inner_title">
 <h3>	
  <div style="float:left"><?php echo __('View Insurance Type Details'); ?></div>			
  <div style="float:right;">
   <?php
	echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
   ?>
  </div>
 </h3>
<div class="clr"></div>
</div>
<table border="0" cellpadding="0" cellspacing="0" align="center" class="table_view_format"> 
 <tr class="first">
  <td class="row_format"><strong>
   <?php echo __('name',true); ?>
  </td>
  <td>
   <?php echo $insurancetype['InsuranceType']['name']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Description',true); ?>
  </td>
  <td>
   <?php echo $insurancetype['InsuranceType']['description']; ?>
  </td>
 </tr>
 </table>
