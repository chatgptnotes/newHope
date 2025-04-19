<div class="inner_title">
	<h3>	
			<div style="float:left"><?php echo __('View Emergency User Details'); ?></div>			
			<div style="float:right;"><?php echo $this->Html->link(__('Back to List'), array('controller'=>'AuditLogs','action' => 'admin_emergency_access'), array('escape' => false,'class'=>'blueBtn'));?></div>
	</h3>
	<div class="clr"></div>
</div>

<table border="0" cellpadding="0" cellspacing="0" width="550"  align="center" class="table_view_format"> 
 <tr class="first">
  <td class="row_format"><strong>
   <?php echo __('Username',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['username']; ?>
  </td>
 </tr>
 <tr >
  <td class="row_format"><strong>
   <?php echo __('Initial',true); ?></strong>
  </td>
  <td>
   <?php echo $user['Initial']['name']; ?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('First Name',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['first_name']; ?>
  </td>
 </tr>
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Middle Name',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['middle_name']; ?>
  </td>
 </tr>
<tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Last Name',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['last_name']; ?>
  </td>
 </tr>
 
  <tr >
  <td class="row_format"><strong>
   <?php echo __('Sex',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['gender']; ?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Date of Birth',true); ?></strong>
  </td>
  <td>
   <?php 
        if($user['User']['dob'] != "0000-00-00")
         echo $this->DateFormat->formatDate2Local($user['User']['dob'],Configure::read('date_format'));	 
   ?>
  </td>
 </tr>
  <tr >
  <td class="row_format"><strong>
   <?php echo __('Designation',true); ?></strong>
  </td>
  <td>
   <?php echo $user['Designation']['name']; ?>
  </td>
 </tr> 
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Address1',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['address1']?>
  </td>
 </tr>
  <tr >
  <td class="row_format"><strong>
   <?php echo __('Address2',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['address2']?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Zipcode',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['zipcode']?>
  </td>
 </tr>
  <tr >
  <td class="row_format"><strong>
   <?php echo __('City',true); ?></strong>
  </td>
  <td>
   <?php echo $user['City']['name']?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('State',true); ?></strong>
  </td>
  <td>
   <?php echo $user['State']['name']?>
  </td>
 </tr>
  <tr >
  <td class="row_format"><strong>
   <?php echo __('Country',true); ?></strong>
  </td>
  <td>
   <?php echo $user['Country']['name']?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Email',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['email']?>
  </td>
 </tr>
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Phone1',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['phone1']?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Phone2',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['phone2']?>
  </td>
 </tr>
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Mobile',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['mobile']?>
  </td>
 </tr>
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Fax',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['fax']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Role',true); ?></strong>
  </td>
  <td>
   <?php echo $user['Role']['name']?>
  </td>
 </tr>
 
 <?php if($user['Department']['name']) { ?>
 <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('Specilty',true); ?></strong>
  </td>
  <td>
   <?php echo $user['Department']['name']; ?>
  </td>
 </tr>
 <?php } ?>
 <?php if(strtolower($user['Role']['name']) == strtolower(Configure::read(doctor))) { ?>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Surgeon',true); ?></strong>
  </td>
  <td>
   <?php if($user['DoctorProfile']['is_surgeon'] == 1) { echo __('Yes'); } else { echo __('No'); } ?>
  </td>
 </tr>
 <?php } ?>
 <?php if($user['Role']['name'] == "Registrar" || $user['Role']['name'] == "registrar") { ?>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Registrar',true); ?></strong>
  </td>
  <td>
   <?php if($user['DoctorProfile']['is_registrar'] == 1) { echo __('Yes'); } else { echo __('No'); } ?>
  </td>
 </tr>
 <?php } ?>
 <tr  class="row_gray">
  <td><strong>
   <?php echo __('Is Emergency',true); ?></strong>
  </td>
  <td>
    <?php 
      if($user['User']['is_emergency'] == 1) {
        echo __('Yes');
      } else {
        echo __('No');
      }
    ?>
  </td>
  </tr>
   
 </table>
