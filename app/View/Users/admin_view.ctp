<?php //debug($user);?>
<div class="inner_title">
	<h3>
		<div style="float: left">
			<?php echo __('View User Details'); ?>
		</div>
		<div style="float: right;">
			<?php if($emer == 'emer'){ 
				echo $this->Html->link(__('Back to List'), array('controller'=>'AuditLogs','action' => 'admin_emergency_access'), array('escape' => false,'class'=>'blueBtn'));
			}else{
				if($activeFlag=='0'||$activeFlag=='1'|| $activeFlag=='2' || $activeFlag=='3'){
					echo $this->Html->link(__('Back to List'), array('action' => 'index',$activeFlag), array('escape' => false,'class'=>'blueBtn'));
				}else{
					echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
				}
			}
			?>
		</div>
	</h3>
	<div class="clr"></div>
</div>

<table border="0" cellpadding="0" cellspacing="0" width="550"
	align="center" class="table_view_format">
	<tr class="first">
		<?php //debug($user);exit; ?>
		<td class="row_format"><strong> <?php echo __('Username',true); ?>
		</strong>
		</td>
		<td><?php echo $user['User']['username']; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Initial',true); ?>
		</strong>
		</td>
		<td><?php echo $user['Initial']['name']; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('First Name',true); ?>
		</strong>
		</td>
		<td><?php echo $user['User']['first_name']; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Middle Name',true); ?>
		</strong>
		</td>
		<td><?php echo $user['User']['middle_name']; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Last Name',true); ?>
		</strong>
		</td>
		<td><?php echo $user['User']['last_name']; ?>
		</td>
	</tr>

	<tr>
		<td class="row_format"><strong> <?php echo __('Sex',true); ?>
		</strong>
		</td>
		<td><?php echo $user['User']['gender']; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Date of Birth',true); ?>
		</strong>
		</td>
		<td><?php 
		if($user['User']['dob'] != "0000-00-00")
			echo $this->DateFormat->formatDate2Local($user['User']['dob'],Configure::read('date_format'));
		?>
		</td>
	</tr>

	<?php if(strtolower($user['Role']['name']) == strtolower(Configure::read('doctor'))) { ?>
	<tr>
		<td class="row_format"><strong> <?php echo __('NPI',true); ?>
		</strong>
		</td>
		<td><?php //if($user['DoctorProfile']['npi'] == 1) { echo __('NPI'); } else { echo __('No'); } ?>
			<?php echo $userData['User']['npi']; ?>
		</td>
	</tr>
	<?php } ?>


	<?php if(strtolower($user['Role']['name']) == strtolower(Configure::read('doctor'))) { ?>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Dea #',true); ?>
		</strong>
		</td>
		<td><?php //if($user['User']['dea'] == 1) { echo __('Yes'); } else { echo __('No'); } ?>
			<?php echo $userData['User']['dea']; ?>
		</td>
	</tr>
	<?php } ?>

	<?php if(strtolower($user['Role']['name']) == strtolower(Configure::read('doctor'))) { ?>
	<tr>
		<td class="row_format"><strong> <?php echo __('UPIN #',true); ?>
		</strong>
		</td>
		<td><?php //if($user['DoctorProfile']['upin'] == 1) { echo __('Yes'); } else { echo __('No'); } ?>
			<?php echo $userData['User']['upin']; ?>
		</td>
	</tr>
	<?php } ?>

	<?php if(strtolower($user['Role']['name']) == strtolower(Configure::read('doctor'))) { ?>
	<!-- <tr class="row_gray">
  <td class="row_format"><strong>
   <?php echo __('State',true); ?></strong>
  </td>
  <td>
   <?php //if($user['DoctorProfile']['state'] == 1) { echo __('Yes'); } else { echo __('No'); } ?>
   <?php echo $userData['User']['state']; ?>
  </td>
 </tr> -->
	<?php } ?>





	<?php if(strtolower($user['Role']['name']) == strtolower(Configure::read('doctor'))) { ?>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Provider credentialing and enrollment applications status',true); ?>
		</strong>
		</td>
		<td><?php // if($user['DoctorProfile']['enrollment_status'] == 1) { echo __('Yes'); } else { echo __('No'); } ?>
			<?php echo $userData['User']['enrollment_status']; ?>
		</td>
	</tr>
	<?php } ?>

	<?php if(strtolower($user['Role']['name']) == strtolower(Configure::read('doctor'))) { ?>
	<tr>
		<td class="row_format"><strong> <?php echo __('Licensure Type',true); ?>
		</strong>
		</td>
		<td><?php // if($user['DoctorProfile']['licensure_type'] == 1) { echo __('Yes'); } else { echo __('No'); } ?>
			<?php //debug($userData);exit;?> <?php echo $userData['LicensureType']['name']; ?>
		</td>
	</tr>
	<?php } ?>

	<?php if(strtolower($user['Role']['name']) == strtolower(Configure::read('doctor'))) { ?>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Licensure No',true); ?>
		</strong>
		</td>
		<td><?php //if($user['DoctorProfile']['licensure_no'] == 1) { echo __('Yes'); } else { echo __('No'); } ?>
			<?php echo $userData['User']['licensure_no']; ?>
		</td>
	</tr>
	<?php } ?>

	<?php if(strtolower($user['Role']['name']) == strtolower(Configure::read('doctor'))) { ?>
	<tr>
		<td class="row_format"><strong> <?php echo __('Expiration Date',true); ?>
		</strong>
		</td>
		<td><?php //debug($doctor['User']['expiration_date']);exit;?> <?php echo $this->DateFormat->formatDate2Local($userData['User']['expiration_date'],Configure::read('date_format'),false); ?>
		</td>

		</td>
	</tr>
	<?php } ?>


	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Designation',true); ?>
		</strong>
		</td>
		<td><?php echo $user['Designation']['name']; ?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Address1',true); ?>
		</strong>
		</td>
		<td><?php echo $user['User']['address1']?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Address2',true); ?>
		</strong>
		</td>
		<td><?php echo $user['User']['address2']?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Zipcode',true); ?>
		</strong>
		</td>
		<td><?php echo $user['User']['zipcode']?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('City',true); ?>
		</strong>
		</td>
		<td><?php echo $user['City']['name']?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('State',true); ?>
		</strong>
		</td>
		<td><?php echo $user['State']['name']?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Country',true); ?>
		</strong>
		</td>
		<td><?php echo $user['Country']['name']?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Email',true); ?>
		</strong>
		</td>
		<td><?php echo $user['User']['email']?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Phone1',true); ?>
		</strong>
		</td>
		<td><?php echo $user['User']['phone1']?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Phone2',true); ?>
		</strong>
		</td>
		<td><?php echo $user['User']['phone2']?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Mobile',true); ?>
		</strong>
		</td>
		<td><?php echo $user['User']['mobile']?>
		</td>
	</tr>
	<tr>
		<td class="row_format"><strong> <?php echo __('Fax',true); ?>
		</strong>
		</td>
		<td><?php echo $user['User']['fax']?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Role',true); ?>
		</strong>
		</td>
		<td><?php echo $user['Role']['name']?>
		</td>
	</tr>

	<?php if($user['Department']['name']) { ?>
	<tr>
		<td class="row_format"><strong> <?php echo __('Speciality',true); ?>
		</strong>
		</td>
		<td><?php echo $user['Department']['name']; ?>
		</td>
	</tr>
	<?php } ?>
	<?php if(strtolower($user['Role']['name']) == strtolower(Configure::read('doctor'))) { ?>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Surgeon',true); ?>
		</strong>
		</td>
		<td><?php if($user['DoctorProfile']['is_surgeon'] == 1) { 
			echo __('Yes');
		} else { echo __('No');
} ?>
		</td>
	</tr>
	<?php } ?>
	
	<?php if(strtolower($user['Role']['name']) == strtolower(Configure::read('doctor'))) { ?>
	<tr >
		<td class="row_format"><strong> <?php echo __('OPD Doctor',true); ?>
		</strong>
		</td>
		<td><?php echo ($user['DoctorProfile']['is_opd_allow']) ?  __('Yes') : __('No');
 ?>
		</td>
	</tr>
	<?php } ?>

	<?php if($user['Role']['name'] == "Registrar" || $user['Role']['name'] == "registrar") { ?>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('Registrar',true); ?>
		</strong>
		</td>
		<td><?php if($user['DoctorProfile']['is_registrar'] == 1) { 
			echo __('Yes');
		} else { echo __('No');
} ?>
		</td>
	</tr>
	<?php } ?>
	<?php if($emer){?>
	<tr >
		<td><strong> <?php echo __('Account Expiary',true); ?>
		</strong>
		</td>
		<td><?php echo $this->DateFormat->formatDate2Local($user['User']['expiary_date'],Configure::read('date_format'),true); ?>
		</td>
	</tr>
	<?php }?>

	<?php if(strtolower($user['Role']['name']) == strtolower(Configure::read('doctor'))) { ?>
	<tr class="row_gray">
		<td class="row_format"><strong> <?php echo __('CAQH Provider ID',true); ?>
		</strong>
		</td>
		<td><?php //if($user['DoctorProfile']['caqh_provider_id'] == 1) { echo __('Yes'); } else { echo __('No'); } ?>
			<?php echo $userData['User']['caqh_provider_id']; ?>
		</td>
	</tr>
	<?php } ?>
	<?php /*?>
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Createdby',true); ?></strong>
  </td>
  <td>
   <?php echo $createdBy['User']['full_name'] ; ?>
  </td>
  </tr>
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Modifiedby',true); ?></strong>
  </td>
  <td>
   <?php echo $modifiedBy['User']['full_name'] ;?>
  </td>
  </tr>
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Createdtime',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['create_time']?>
  </td>
  </tr>
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Modifiedtime',true); ?></strong>
  </td>
  <td>
   <?php echo $user['User']['modify_time']?> 
  </td>
  </tr>
   <?php */?>

</table>
