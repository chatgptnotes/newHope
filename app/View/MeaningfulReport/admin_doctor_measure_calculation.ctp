<div class="inner_title">
	<h3>	
			<div style="float:left"><?php echo __('Problem List Calculation Details'); ?></div>			
			<div style="float:right;">
			 <?php echo $this->Html->link(__('Back to List'), array('action' => 'auto_measure_calculation'), array('escape' => false,'class'=>'blueBtn')); ?>
			</div>
	</h3>
	<div class="clr"></div>
</div>
<div>
 <table>
  <tr>
   <td align="left"><b><?php echo __('Doctor Name');?></b></td><td> :<?php echo $doctorDetails['DoctorProfile']['doctor_name']; ?></td>
  </tr>
  <tr>
   <td align="left"><b><?php echo __('Specilty');?></b></td><td> :<?php echo $doctorDetails['Department']['name'];  ?></td>
  </tr>
  <tr>
  <td  align="left">
  <b><?php echo __('Measure Count'); ?></b></td><td> :<?php if(count($doctorPatientList) > 0) echo count($doctorPatientList); else echo "0"; ?>
  </td>
  </tr>
  <tr>
  <td  align="left">
  <b><?php echo __('Total Count'); ?></b></td><td> :<?php if(count($doctorTotalCount)) echo count($doctorTotalCount); else echo "0"; ?>
  </td>
  </tr>
  <tr>
  <td  align="left">
  <b><?php echo __('Measure Calculation'); ?></b></td>
  <td>:
  <?php 
        if(count($doctorPatientList) > 0 && count($doctorTotalCount) > 0) { 
         $measureCalculation = (count($doctorPatientList)/count($doctorTotalCount))*100;
         echo $this->Number->toPercentage($measureCalculation);
        } else {
            echo  "0.00%";
        }
   
   ?>
  </td>
  </tr>
 </table>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
  <tr class="row_title">
   <td class="table_cell"><strong><?php echo __('Sr.No.', true); ?></td>
   <td class="table_cell"><strong><?php echo __('Patient Name', true); ?></td>
   <td class="table_cell"><strong><?php echo __('Sex', true); ?></td>
   <td class="table_cell"><strong><?php echo __('Email', true); ?></td>
   <td class="table_cell"><strong><?php echo __('Mobile', true); ?></td>
   </tr>
  <?php 
      $cnt =0;
      if(count($doctorPatientList) > 0) {
       foreach($doctorPatientList as $doctorPatientListVal): 
       $cnt++;
  ?>
   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
   <td class="row_format"><?php echo $cnt; ?> </td>
   <td class="row_format"><?php echo $doctorPatientListVal['Patient']['lookup_name']; ?> </td>
   <td class="row_format"><?php echo ucfirst($doctorPatientListVal['Patient']['sex']); ?> </td>
   <td class="row_format"><?php echo $doctorPatientListVal['Person']['email']; ?> </td>
   <td class="row_format"><?php echo $doctorPatientListVal['Person']['mobile']; ?> </td>
   </tr>
  <?php endforeach;  ?>
   
  <?php
         } else {
  ?>
  <tr>
   <td colspan="5" align="center"><?php echo __('No record found', true); ?>.</td>
  </tr>
  <?php
      }
  ?>
  
</table>
