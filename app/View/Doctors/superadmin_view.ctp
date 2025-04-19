<div class="inner_title">
<h3><?php echo __('View Doctor', true); ?></h3>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Initial',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['Initial']['name']; ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Doctor Name',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['DoctorProfile']['doctor_name']; ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Address1',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['Doctor']['address1']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Address2',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['Doctor']['address2']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Zipcode',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['Doctor']['zipcode']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('City',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['City']['name']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('State',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['State']['name']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Country',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['Country']['name']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Email',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['Doctor']['email']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Phone1',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['Doctor']['phone1']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Phone2',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['Doctor']['phone2']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Mobile',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['Doctor']['mobile']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Fax',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['Doctor']['fax']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Role',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['Role']['name']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Active',true); ?>
  </td>
  <td class="form_lables">
   <?php if($doctor['Doctor']['is_active'] == 1) {
           echo __('Yes',true);
         } else {
           echo __('No',true);
         }
   ?>
  </td>
  </tr>
  <tr>
  <td class="form_lables"><strong>
   <?php echo __('Specilty',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $department['Department']['name']?>
  </td>
  </tr>
  <tr>
  <td class="form_lables"><strong>
   <?php echo __('Education',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['DoctorProfile']['education']?>
  </td>
  </tr>
  <tr>
  <td class="form_lables"><strong>
   <?php echo __('Has Speciality',true); ?>
  </td>
  <td class="form_lables">
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
  <td class="form_lables"><strong>
   <?php echo __('Speciality Keyword',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['DoctorProfile']['specility_keyword']?>
  </td>
  </tr>
  <tr>
  <td class="form_lables"><strong>
   <?php echo __('Experience',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['DoctorProfile']['experience']?>
  </td>
  </tr>
  <tr>
  <td class="form_lables"><strong>
   <?php echo __('Date of Birth',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['DoctorProfile']['dateofbirth']?>
  </td>
  </tr>
  <tr>
  <td class="form_lables"><strong>
   <?php echo __('Profile Description',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $doctor['DoctorProfile']['profile_description']?>
  </td>
  </tr>
  <tr>
   <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
   <td align="center" colspan="2">
    <?php 
   	echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
    ?>
   </td>
  </tr>
 </table>
