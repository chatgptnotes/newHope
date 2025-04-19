<style>
.table_format td{padding:7px 20px;}
</style>
<div class="inner_title">
<h3>
<div style="float:left"><?php echo __('View Doctor', true); ?></div>			
			<div style="float:right;"><?php
	       		echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
			?></div>
</h3>
<div class="clr"></div>
</div>
<table border="0" cellpadding="0" cellspacing="0" align="center" class="table_view_format"> 
 <tr class="first">
  <td class="row_format">
    <strong><?php echo __('Initial',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Initial']['name']; ?>
  </td>
 </tr>
 <tr>
  <td class="row_format">
   <strong><?php echo __('Doctor Name',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['DoctorProfile']['doctor_name']; ?>
  </td>
 </tr>
  <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('Address1',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Doctor']['address1']?>
  </td>
 </tr>
 <tr>
  <td class="row_format">
   <strong><?php echo __('Address2',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Doctor']['address2']?>
  </td>
 </tr>
  <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('Zipcode',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Doctor']['zipcode']?>
  </td>
 </tr>
 <tr>
  <td class="row_format">
   <strong><?php echo __('City',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['City']['name']?>
  </td>
 </tr>
  <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('State',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['State']['name']?>
  </td>
 </tr>
 <tr>
  <td class="row_format">
   <strong><?php echo __('Country',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Country']['name']?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('Email',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Doctor']['email']?>
  </td>
 </tr>
 <tr>
  <td class="row_format">
   <strong><?php echo __('Phone1',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Doctor']['phone1']?>
  </td>
 </tr>
  <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('Phone2',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Doctor']['phone2']?>
  </td>
 </tr>
 <tr>
  <td class="row_format">
   <strong><?php echo __('Mobile',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Doctor']['mobile']?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('Fax',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Doctor']['fax']?>
  </td>
 </tr>
 <tr>
  <td class="row_format">
   <strong><?php echo __('NPI No',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Doctor']['npi']?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('DEA #',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Doctor']['dea']?>
  </td>
 </tr>
 
 <tr>
  <td >
   <strong><?php echo __('UPIN #',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Doctor']['upin']?>
  </td>
 </tr>
 
 <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('State ID',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Doctor']['state']?>
  </td>
 </tr>
 
 <tr>
  <td class="row_format">
   <strong><?php echo __('CAQH Provider ID',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Doctor']['caqh_provider_id']?>
  </td>
 </tr>
 
  <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('Provider credentialing and enrollment applications status',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Doctor']['enrollment_status']?>
   <?php // echo $applicationStatus[$doctor['DoctorProfile']['enrollment_status']]; ?>
  </td>
 </tr>
 
 <tr>
  <td class="row_format">
   <strong><?php echo __('Licensure Type',true); ?></strong>
  </td>
  <td>
   <?php 
    echo $licenture['LicensureType']['name']?>
   </td>
 </tr>
 
 <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('Licensure No',true); ?></strong>
  </td>
  <td>
   <?php echo $users['User']['licensure_no']?>
  </td>
 </tr>
 
 <tr>
 <td class="row_format">
 <strong><?php echo __('Expiration Date',true); ?></strong>
  </td>
 
  <td>
    <?php echo $this->DateFormat->formatDate2Local($doctor['Doctor']['expiration_date'],Configure::read('date_format'),false); ?>
  </td>
  
 </tr>
 
 <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('Role',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['Role']['name']?>
  </td>
 </tr>

 <tr>
  <td class="row_format">
   <strong><?php echo __('Active',true); ?></strong>
  </td>
  <td>
   <?php if($doctor['Doctor']['is_active'] == 1) {
           echo __('Yes',true);
         } else {
           echo __('No',true);
         }
   ?>
  </td>
  </tr>
  <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('Specialty',true); ?></strong>
  </td>
  <td>
   <?php echo $department['Department']['name']?>
  </td>
  </tr>
   <tr>
  <td class="row_format">
   <strong><?php echo __('Education',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['DoctorProfile']['education']?>
  </td>
  </tr>
  <tr class="row_gray" >
  <td class="row_format">
   <strong><?php echo __('Has Specialty ',true); ?></strong>
  </td>
  <td>
   <?php 
        if($doctor['DoctorProfile']['haspecility'] == 1) { 
          echo __('Yes',true);
        } else {
          echo __('No',true);
        } 
   ?>
  </td>
  </tr>
  <tr>
  <td class="row_format">
   <strong><?php echo __('Specialty  Keyword',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['DoctorProfile']['specility_keyword']?>
  </td>
  </tr>
  <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('Experience',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['DoctorProfile']['experience']?>
  </td>
  </tr>
  <tr>
  <td class="row_format">
   <strong><?php echo __('Date of Birth',true); ?></strong>
  </td>
  <td>
   <?php //echo $doctor['DoctorProfile']['dateofbirth'];exit;
   if(isset($doctor['DoctorProfile']['dateofbirth']) && $doctor['DoctorProfile']['dateofbirth'] !='0000-00-00'){
   	 
   	echo $this->DateFormat->formatDate2Local($doctor['DoctorProfile']['dateofbirth'],Configure::read('date_format'));
   }
   ?>
  </td>
  </tr>
  <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('Profile Description',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['DoctorProfile']['profile_description']?>
  </td>
  </tr>
  <tr>
  <td class="row_format">
   <strong><?php echo __('Present Event Color Code',true); ?></strong>
  </td>
  <td>
   <?php echo $doctor['DoctorProfile']['present_event_color']?>
  </td>
  </tr>
  <tr class="row_gray">
  <td class="row_format">
   <strong><?php echo __('Registrar',true); ?></strong>
  </td>
  <td>
   <?php if($doctor['DoctorProfile']['is_registrar'] == 1) echo __('Yes'); else  echo __('No');?>
  </td>
  </tr>
  <tr>
  <td class="row_format">
   <strong><?php echo __('Surgeon',true); ?></strong>
  </td>
  <td>
    <?php if($doctor['DoctorProfile']['is_surgeon'] == 1) echo __('Yes'); else  echo __('No');?>
  </td>
  </tr>
 </table>
