<div class="inner_title">
 <h3>	
  <div style="float:left"><?php echo __('View Corporate Location Details'); ?></div>			
  <div style="float:right;">
   <?php
	echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
   ?>
  </div>
 </h3>
<div class="clr"></div>
</div>
<table border="0" cellpadding="0" cellspacing="0"  align="center" class="table_view_format">
 <tr>
 <!--<tr>
  <td class="row_format"><strong>
   <?php echo __('Credit Type',true); ?>
  </td>
  <td class="row_format">
   <?php //echo $corporatelocation['CreditType']['name']; ?>
  </td>
 </tr>
 --><tr>
  <tr class="first">
  <td class="row_format"><strong>
   <?php echo __('Name',true); ?>
  </td>
  <td class="row_format">
   <?php echo $corporatelocation['CorporateLocation']['name']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Description',true); ?>
  </td>
  <td class="row_format">
   <?php echo $corporatelocation['CorporateLocation']['description']; ?>
  </td>
 </tr>
 </table>
