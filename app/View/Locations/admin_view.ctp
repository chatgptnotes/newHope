
<div class="inner_title">
	<h3>	
			<div style="float:left">&nbsp; <?php echo __('View Facility Details'); ?></div>			
			<div style="float:right;"><?php
	       		echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
			?></div>
	</h3>
	<div class="clr"></div>
</div>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="60%"  align="center">
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Company',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['Company']['name']; ?>
  </td>
 </tr>
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Facility Name',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['name']; ?>
  </td>
 </tr>
 <tr>
 <td class="row_format"><strong>
   <?php echo __('Address1',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['address1']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Address2',true); ?>
  </td>
 <td class="row_format">
   <?php echo $location['Location']['address2']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Zipcode',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['zipcode']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('City',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['City']['name']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('State',true); ?></strong>
  </td>
 <td class="row_format">
   <?php echo $location['State']['name']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Country',true); ?>
  </td>
  <td class="row_format">
   <?php echo $location['Country']['name']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Email',true); ?></strong>
  </td>
 <td class="row_format">
   <?php echo $location['Location']['email']?>
  </td>
 </tr>
 
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Entity Type',true); ?></strong>
  </td>
 <td class="row_format">
   <?php 
   if($location['Location']['entity_type']==1)
   {
   	$entity_type='Person';
   } else{
   	$entity_type='Non Person';
   }
   ?>
   <?php echo $entity_type?>
    
  </td>
 </tr>
 
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Phone1',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['phone1']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Phone2',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['phone2']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Mobile',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['mobile']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Mobile',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['mobile']?>
  </td>
 </tr>
 
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Fax',true); ?></strong>
  </td>
 <td class="row_format">
   <?php echo $location['Location']['fax']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Contact Person',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['contactperson']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Accreditation',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['accreditation']?>
  </td>
 </tr>
 <tr>
	  <td class="row_format"><strong>
	   <?php echo __('Checkout Time',true); ?></strong>
	  </td>
	  <td class="row_format">
	   <?php if($location['Location']['checkout_time_option'] == 1) echo __('Fixed'); else echo __('24 Hours'); ?>
	  </td>
 </tr>
 <?php if(!empty($location['Location']['case_summery_link'])){?>
  	<tr>
		  <td class="row_format"><strong>
		   <?php echo __('Case Summary Link'); ?></strong>
		  </td>
		  <td class="row_format">
		   <?php echo $location['Location']['case_summery_link'] ; ?>
		  </td>
	 </tr>
 <?php } ?>
 <?php if(!empty($location['Location']['patient_file'])){?>
  	<tr>
		  <td class="row_format"><strong>
		   <?php echo __('Patient File'); ?></strong>
		  </td>
		  <td class="row_format">
		   <?php echo $location['Location']['patient_file'] ; ?>
		  </td>
	 </tr>
 <?php } ?>
 
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Is Active',true); ?></strong>
  </td>
  <td class="row_format">
   <?php if($location['Location']['is_active'] == 1) {
           echo __('Yes',true);
         } else {
           echo __('No',true);
         }
   ?>
  </td>
  </tr>
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Hospital Billing Footer Name',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['billing_footer_name']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Hospital Service Tax No.',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['hospital_service_tax_no']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Hospital PAN No.',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['hospital_pan_no']; ?>
  </td>
 </tr>
 
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Place of Service Code',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $codeOption[$location['Location']['place_service_code']]; ?>
  </td>
 </tr>
 
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Footer for Discharge Summary',true); ?></strong>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['footer_text_discharge']; ?>
  </td>
 </tr>
  <?php if($location['Location']['header_image']){ ?>
  <tr>
	  <td class="row_format"><strong>
	   <?php echo __('Header Image',true); ?></strong>
	  </td>
	  <td class="row_format">
	   <?php 
			echo $this->Html->link($this->Html->image('/uploads/image/'.$location['Location']['header_image'],array('width'=>'100','height'=>100)),'/uploads/image/'.$location['Location']['header_image'],array('escape'=>false,'target'=>'__blank'));
			?>
	  </td>
 </tr>
 <?php } ?>
  <?php if($location['Location']['footer']){ ?>
  <tr>
	  <td class="row_format"><strong>
	   <?php echo __('Footer',true); ?></strong>
	  </td>
	  <td class="row_format">
	   <?php 
			echo $location['Location']['footer'] ;
			?>
	  </td>
 </tr>
 <?php } ?>
 </table>
