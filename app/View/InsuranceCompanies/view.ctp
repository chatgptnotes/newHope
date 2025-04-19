<div class="inner_title">
	<h3>	
			<div style="float:left"><?php echo __('View Insurance Company Details'); ?></div>			
			<div style="float:right;"><?php
	       		echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
			?></div>
	</h3>
	<div class="clr"></div>
</div>
<table border="0" cellpadding="0" cellspacing="0" align="center" class="table_view_format">
  <tr class="first">
  <td class="row_format">
   <strong><?php echo __('Insurance Type'); ?></strong>
  </td>
  <td>
   <?php echo $insuranceCompany['InsuranceType']['name']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format">
   <strong><?php echo __('Name'); ?></strong>
  </td>
  <td>
   <?php echo $insuranceCompany['InsuranceCompany']['name']; ?>
  </td>
 </tr>
  <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('Address'); ?></strong>
  </td>
  <td>
   <?php echo $insuranceCompany['InsuranceCompany']['address']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format">		
   <strong><?php echo __('Country'); ?></strong>
  </td>
  <td>
   <?php echo $insuranceCompany['Country']['name']; ?>
  </td>
 </tr>	
  <tr class="row_gray">
  <td class="row_format">		
   <strong><?php echo __('State'); ?></strong>
  </td>
  <td>
   <?php echo $insuranceCompany['State']['name']; ?>
  </td>
 </tr>	
 <tr>
  <td class="row_format">
   <strong><?php echo __('City'); ?></strong>
  </td>
  <td>
   <?php echo $insuranceCompany['City']['name']; ?>
  </td>
 </tr>	
  <tr class="row_gray">
  <td class="row_format">		
   <strong><?php echo __('Zip'); ?></strong>
  </td>
  <td>
   <?php echo $insuranceCompany['InsuranceCompany']['zip']; ?>
  </td>
 </tr>	
 <tr>
  <td class="row_format">		
   <strong><?php echo __('Phone'); ?></strong>
  </td>
  <td>
   <?php echo $insuranceCompany['InsuranceCompany']['phone']; ?>
  </td>
 </tr>	
  <tr class="row_gray">
  <td class="row_format">		
   <strong><?php echo __('Fax'); ?></strong>
  </td>
  <td>
   <?php echo $insuranceCompany['InsuranceCompany']['fax']; ?>
  </td>
  </tr>	
  <tr>
   <td class="row_format">		
    <strong><?php echo __('Email'); ?></strong>
   </td>
   <td>
    <?php echo $insuranceCompany['InsuranceCompany']['email']; ?>
   </td>
  </tr>	
   <tr class="row_gray">
   <td class="row_format">		
    <strong><?php echo __('Active?'); ?></strong>
   </td>
   <td>
    <?php 
          if($insuranceCompany['InsuranceCompany']['is_active'] == 1) {
             echo __('Yes');
          } else {
             echo __('No');
          }
    ?>
   </td>
  </tr>	
 </table>