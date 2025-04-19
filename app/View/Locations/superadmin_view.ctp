<div class="inner_title">
	<h3>	
			<div style="float:left"><?php echo __('View Facility Details'); ?></div>			
			<div style="float:right;"><?php
	       		echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
			?></div>
	</h3>
	<div class="clr"></div>
</div>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="60%"  align="center">
  <tr>
  <td class="row_format"><strong>
   <?php echo __('Facility Name',true); ?>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['name']; ?>
  </td>
 </tr>
 <tr>
 <td class="row_format"><strong>
   <?php echo __('Address1',true); ?>
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
   <?php echo __('Zipcode',true); ?>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['zipcode']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('City',true); ?>
  </td>
  <td class="row_format">
   <?php echo $location['City']['name']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('State',true); ?>
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
   <?php echo __('Email',true); ?>
  </td>
 <td class="row_format">
   <?php echo $location['Location']['email']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Phone1',true); ?>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['phone1']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Phone2',true); ?>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['phone2']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Mobile',true); ?>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['mobile']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Fax',true); ?>
  </td>
 <td class="row_format">
   <?php echo $location['Location']['fax']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Contact Person',true); ?>
  </td>
  <td class="row_format">
   <?php echo $location['Location']['contactperson']?>
  </td>
 </tr>
 <tr>
  <td class="row_format"><strong>
   <?php echo __('Active',true); ?>
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
	<td colspan="2" align="center">
        &nbsp;
	</td>
 </tr>
 </table>
