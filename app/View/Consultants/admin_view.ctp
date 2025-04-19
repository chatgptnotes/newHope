<div class="inner_title">
	<h3>	
			<div style="float:left"><?php echo __('View Consultant Details'); ?></div>			
			<div style="float:right;"><?php
	       		echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
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
 <tr>
  <td class="row_format"><strong>
   <?php 
   echo __('Marketing Team',true); ?>
  </td>
  <td class="row_format">
   <?php echo $consultant['Consultant']['market_team'];?>
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
 <tr class="row_gray">
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
 </table>
