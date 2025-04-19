<div class="inner_title">
 <h3>	
  <div style="float:left"><?php echo __('View Enterprise Rate'); ?></div>			
  <div style="float:right;">
   <?php
   	echo $this->Html->link(__('Back'), array('action' => 'hospital_rate', 'superadmin' => true), array('escape' => false,'class'=>'blueBtn'));
   ?>
  </div>
 </h3>
<div class="clr"></div>
</div>
<table border="0" cellpadding="0" cellspacing="0" align="center" class="table_view_format">
<tr class="first">
  <td class="row_format"><strong>
   <?php echo __('Enterprise Name',true); ?></strong>
  </td>
  <td>
   <?php echo $hospitalrate['Facility']['name']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format">
  <strong>
   <?php echo __('IPD Rate',true); ?>
  </strong>
  </td>
  <td>
   <?php echo $hospitalrate['HospitalRate']['ipd_rate']; ?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format">
   <strong>
   <?php echo __('IPD Rate',true); ?>
   </strong>
  </td>
  <td>
   <?php echo $hospitalrate['HospitalRate']['opd_rate']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format">
  <strong>
   <?php echo __('Emergency Rate',true); ?>
  </strong>
  </td>
  <td>
   <?php echo $hospitalrate['HospitalRate']['emergency_rate']; ?>
  </td>
 </tr>
 </table>
