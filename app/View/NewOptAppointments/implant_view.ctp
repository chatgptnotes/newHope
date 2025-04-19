<div class="inner_title">
 <h3>	
 <?php echo __('View Surgical Implant'); ?></h3>
 <span>
<?php
 echo $this->Html->link(__('Back', true),array('controller' => 'NewOptAppointments', 'action' => 'implantIndex', 'admin' => false), array('escape' => false,'class'=>'blueBtn'));?>
</span>
  </div>
 
<div class="clr"></div>

<table border="0" cellpadding="0" cellspacing="0" align="left" class="table_view_format">
 <tr >
  <td class="row_gray"><strong>
   <?php  echo __('Implant Name',true); ?>
  </td>
  <td class="row_gray">
   <?php echo $getSurgicalImplant['SurgicalImplant']['name']; ?>
  </td>
 </tr> 
  
 
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Is Active',true); ?>
  </td>
  <td class="row_format">
   <?php if($getSurgicalImplant['SurgicalImplant']['is_active'])
			echo "Yes";
		 else
			echo "No";?>
  </td>
 </tr>
 </table>
