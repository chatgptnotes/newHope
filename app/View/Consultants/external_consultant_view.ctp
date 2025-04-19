<div class="inner_title">
	<h3>	
			<div style="float:left"><?php echo __('View External Consultant'); ?></div>			
			<div style="float:right;"><?php
	       		echo $this->Html->link(__('Back to List'), array('action' => 'inhouse_externaldoctor'), array('escape' => false,'class'=>'blueBtn'));
			?></div>
	</h3>
	<div class="clr"></div>
</div>
<table border="0" class="table_view_format" cellpadding="0" cellspacing="0" align="center">
 <tr class="first">
  <td class="row_format"><strong>
   <?php echo __('Initial',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Initial']['name']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('First Name',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Consultant']['first_name']?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Middle Name',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Consultant']['middle_name']?>
  </td>
 </tr>
<tr>
  <td class="row_format"><strong>
   <?php echo __('Last Name',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Consultant']['last_name']?>
  </td>
 </tr>
<tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Address1',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Consultant']['address1']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Address2',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Consultant']['address2']?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Country',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Country']['name']?>
  </td>
 </tr>
 <tr>
 <td class="row_format"><strong>
   <?php echo __('State',true); ?>
  </td>
 <td class="row_format">
   <?php echo $consultant['State']['name']?>
  </td>
 </tr>
<tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('City',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['City']['name']?>
  </td>
 </tr>
 <tr>
 <td class="row_format"><strong>
   <?php echo __('Zipcode',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Consultant']['zipcode']?>
  </td>
 </tr>
 
 <tr class="row_gray">
 <td class="row_format"><strong>
   <?php echo __('NPI No',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Consultant']['npino']?>
  </td>
 </tr>
 
 <tr>
 <td class="row_format"><strong>
   <?php echo __('CAQH Provider ID',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Consultant']['caqhproviderid']?>
  </td>
 </tr>
 
 
 <tr class="row_gray" >
 <td class="row_format"><strong>
   <?php echo __('Provider credentialing and enrollment applications status',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Consultant']['enrollment_status']?>
  </td>
 </tr>
 
 
 
 <tr>
 <td class="row_format"><strong>
   <?php echo __('Licensure Type',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Consultant']['licensuretype']?>
  </td>
 </tr>
 
 <tr class="row_gray">
 <td class="row_format"><strong>
   <?php echo __('Licensure No',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Consultant']['licensureno']?>
  </td>
 </tr>
 
 <tr>
 <td class="row_format"><strong>
   <?php echo __('Expiration Date',true); ?>
  </td>
  <td class="row_format">
  <?php 
  echo $this->DateFormat->formatDate2Local($consultant['Consultant']['expiration_date'],Configure::read('date_format'));     
  ?>
  </td>
 </tr>
 
<tr class="row_gray" >
 <td class="row_format"><strong>
   <?php echo __('Email',true); ?>
  </td>
 <td class="row_format">
   <?php echo $consultant['Consultant']['email']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Phone1',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Consultant']['phone1']?>
  </td>
 </tr>
 <tr class="row_gray" >
  <td class="row_format"><strong>
   <?php echo __('Phone2',true); ?>
  </td>
   <td class="row_format">
   <?php echo $consultant['Consultant']['phone2']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Mobile',true); ?>
  </td>
   <td class="row_format">
   <?php echo $consultant['Consultant']['mobile']?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Fax',true); ?>
  </td>
   <td class="row_format">
   <?php echo $consultant['Consultant']['fax']?>
  </td>
 </tr>
 <tr>
 <td class="row_format"><strong>
   <?php echo __('Hospital Name',true); ?>
  </td>
   <td class="row_format">
   <?php echo $consultant['Consultant']['hospital_name']?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Charges',true); ?>
  </td>
   <td class="row_format">
  <?php echo $consultant['Consultant']['charges']?>
  </td>
 </tr>
 
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Surgery Charges',true); ?>
  </td>
   <td class="row_format">
  <?php echo $consultant['Consultant']['surgery_charges']?>
  </td>
 </tr>
 
<tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Other Charges',true); ?>
  </td>
   <td class="row_format">
  <?php echo $consultant['Consultant']['other_charges']?>
  </td>
 </tr> 
 
 
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Availability',true); ?>
  </td>
  <td class="row_format">
   <?php if($consultant['Consultant']['availability'] == 1) {
           echo __('Yes',true);
         } else {
           echo __('No',true);
         }
   ?>
  </td>
  </tr>
  <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Education',true); ?>
  </td>
   <td class="row_format">
  <?php echo $consultant['Consultant']['education']?>
  </td>
  </tr>
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Has Speciality',true); ?>
  </td>
  <td class="row_format">
   <?php if($consultant['Consultant']['haspecility'] == 1) {
           echo __('Yes',true);
         } else {
           echo __('No',true);
         }
   ?>
  </td>
  </tr>
  <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Speciality Keyword',true); ?>
  </td>
   <td class="row_format">
  <?php echo $consultant['Consultant']['specility_keyword']?>
  </td>
  </tr>
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Experience',true); ?>
  </td>
   <td class="row_format">
  <?php echo $consultant['Consultant']['experience']?>
  </td>
  </tr>
  <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Date of Birth',true); ?>
  </td>
   <td class="row_format">
  <?php 
  echo $this->DateFormat->formatDate2Local($consultant['Consultant']['dateofbirth'],Configure::read('date_format'));     
  ?>
  </td>
  </tr>
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Is Active',true); ?>
  </td>
  <td class="row_format">
   <?php if($consultant['Consultant']['is_active'] == 1) {
           echo __('Yes',true);
         } else {
           echo __('No',true);
         }
   ?>
  </td>
  </tr>
  
 </table>
