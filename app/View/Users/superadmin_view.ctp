<div class="inner_title">
	<h3>	
			<div style="float:left"><?php echo __('View User Details'); ?></div>			
			<div style="float:right;"><?php
	       		echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
			?></div>
	</h3>
	<div class="clr"></div>
</div>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
<tr>
  <td class="form_lables"><strong>
   <?php echo __('Company',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $facilitiesdata['Facility']['name']; ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Username',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['User']['username']; ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('User alias',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['User']['alias']; ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Initial',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['Initial']['name']; ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('First Name',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['User']['first_name']; ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Middle Name',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['User']['middle_name']; ?>
  </td>
 </tr>
<tr>
  <td class="form_lables"><strong>
   <?php echo __('Last Name',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['User']['last_name']; ?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Address1',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['User']['address1']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Address2',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['User']['address2']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Zipcode',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['User']['zipcode']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('City',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['City']['name']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('State',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['State']['name']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Country',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['Country']['name']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Email',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['User']['email']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Phone1',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['User']['phone1']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Phone2',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['User']['phone2']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Mobile',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['User']['mobile']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Fax',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['User']['fax']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Role',true); ?>
  </td>
  <td class="form_lables">
   <?php echo $user['Role']['name']?>
  </td>
 </tr>
 <tr>
  <td class="form_lables"><strong>
   <?php echo __('Last Login',true); ?>
  </td>
  <td class="form_lables">
   <?php 
       if($user['User']['last_login']) {
        echo date("d/m/Y H:i:s", strtotime($user['User']['last_login']));
       } else {
        echo __('Still Not Logged In');
       }
   ?>
  </td>
 </tr>
<tr>
  <td class="form_lables"><strong>
   <?php echo __('Active',true); ?>
  </td>
  <td class="form_lables">
   <?php if($user['User']['is_active'] == 1) {
           echo __('Yes',true);
         } else {
           echo __('No',true);
         }
   ?>
  </td>
  </tr>
  <!--<tr>
  <td class="form_lables"><strong>
   <?php //echo __('Createdby',true); ?>
  </td>
  <td class="form_lables">
   <?php //echo $user['User']['created_by']?>
  </td>
  </tr>
  <tr>
  <td class="form_lables"><strong>
   <?php //echo __('Modifiedby',true); ?>
  </td>
  <td class="form_lables">
   <?php //echo $user['User']['modified_by']?>
  </td>
  </tr>
  <tr>
  <td class="form_lables"><strong>
   <?php //echo __('Createdtime',true); ?>
  </td>
  <td class="form_lables">
   <?php //echo $user['User']['create_time']?>
  </td>
  </tr>
  <tr>
  <td class="form_lables"><strong>
   <?php //echo __('Modifiedtime',true); ?>
  </td>
  <td class="form_lables">
   <?php //echo $user['User']['modify_time']?>
  </td>
  </tr>-->
 </table>
