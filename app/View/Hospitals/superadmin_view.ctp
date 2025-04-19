<div class="inner_title">
	<h3>	
			<div style="float:left">&nbsp; <?php echo __('View Enterprise Details'); ?></div>			
			<div style="float:right;"><?php
	       		echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
			?></div>
	</h3>
	<div class="clr"></div>
</div>

<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Company Name',true); ?>
  </td>
  <td class="row_format">
   <?php echo $hospital['Facility']['name']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Alias Name',true); ?>
  </td>
  <td class="row_format">
   <?php echo $hospital['Facility']['alias']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Address1',true); ?>
  </td>
  <td class="row_format">
   <?php echo $hospital['Facility']['address1']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Address2',true); ?>
  </td>
  <td class="row_format">
   <?php echo $hospital['Facility']['address2']?>
  </td>
 </tr>
 <tr>
 <td class="row_format"><strong>
   <?php echo __('Zipcode',true); ?>
  </td>
  <td class="row_format">
   <?php echo $hospital['Facility']['zipcode']?>
  </td>
 </tr>
 <tr>
 <td class="row_format"><strong>
   <?php echo __('Zip 4',true); ?>
  </td>
  <td class="row_format">
   <?php echo $hospital['Facility']['zip_four']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('City',true); ?>
  </td>
  <td class="row_format">
   <?php echo $hospital['Facility']['city']?>
  </td>
 </tr>
 <tr>
 <td class="row_format"><strong>
   <?php echo __('State',true); ?>
  </td>
 <td class="row_format">
   <?php echo $hospital['State']['name']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Country',true); ?>
  </td>
  <td class="row_format">
   <?php echo $hospital['Country']['name']?>
   
  </td>
 </tr>
 <tr>
 <td class="row_format"><strong>
   <?php echo __('Email',true); ?>
  </td>
 <td class="row_format">
   <?php echo $hospital['Facility']['email']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Phone1',true); ?>
  </td>
  <td class="row_format">
   <?php echo $hospital['Facility']['phone1']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Phone2',true); ?>
  </td>
   <td class="row_format">
   <?php echo $hospital['Facility']['phone2']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Mobile',true); ?>
  </td>
   <td class="row_format">
   <?php echo $hospital['Facility']['mobile']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Fax',true); ?>
  </td>
   <td class="row_format">
   <?php echo $hospital['Facility']['fax']?>
  </td>
 </tr>
 <tr>
 <td class="row_format"><strong>
   <?php echo __('Contact Person',true); ?>
  </td>
   <td class="row_format">
   <?php echo $hospital['Facility']['contactperson']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Maximum Locations',true); ?>
  </td>
   <td class="row_format">
  <?php echo $hospital['Facility']['maxlocations']?>
  </td>
 </tr>
 
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Discharge from ED/Observation Possible',true); ?>
  </td>
   <td class="row_format">
  <?php echo $hospital['Facility']['discharge_from_ed']?>
  </td>
 </tr>
 
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Active',true); ?>
  </td>
  <td class="row_format">
   <?php if($hospital['Facility']['is_active'] == 1) {
           echo __('Yes',true);
         } else {
           echo __('No',true);
         }
   ?>
  </td>
  </tr>
  
 </table>
