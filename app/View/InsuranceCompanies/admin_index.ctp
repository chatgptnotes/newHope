<style>
.row_action img{
float:inherit;
}
</style>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>

<?php } ?>
<div class="inner_title">
<h3><img src="images/appointment_icon.png" /> &nbsp; <?php echo __('Insurance Companies', true); ?></h3>
<span><input name="" type="text" class="textBoxFade"  value="Search" onfocus="javascript:if(this.value=='Search'){this.value=''; this.className='textBox';}" onblur="javascript:if(this.value==''){this.value='Search'; this.className='textBoxFade'};"/> <a href="#"><img src="images/search_icon.png" style="vertical-align:middle;" /></a></span>
</div>

	<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
	 <tr>
  		<td colspan="16" align="right"><?php echo $this->Html->link(__('New Insurance Company'), array('action' => 'add')); ?></td>
 	 </tr>
	<tr>
		<!-- 	<td class="table_cell"><strong><?php echo $this->Paginator->sort('id');?></strong></td>
			 -->
			 <td class="table_cell"><strong><?php echo $this->Paginator->sort('name');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('address');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('city_id');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('state_id');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('zip');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('phone');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('fax');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('email');?></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('is_active');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('is_deleted');?></strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('created_by');?></strong></td>

			<td class="table_cell"><strong><?php echo __('Actions');?></strong></td>
	</tr>
	<?php
	  $toggle =0;
      if(count($insuranceCompanies) > 0) {
       foreach($insuranceCompanies as $insuranceCompany): 
       if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
	   ?>
	<tr>
		<!-- <td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['id']); ?>&nbsp;</td>
		 -->
		 <td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['name']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['address']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['city_id']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['state_id']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['zip']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['phone']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['fax']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['email']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['is_active']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['is_deleted']); ?>&nbsp;</td>
		<td class="row_format"><?php echo h($insuranceCompany['InsuranceCompany']['created_by']); ?>&nbsp;</td>

		
		
					<td class="row_action"><?php 
   echo $this->Html->link($this->Form->button(__('View', true), array('type' => 'button','class' => 'blueBtn')), array('action' => 'view', $insuranceCompany['InsuranceCompany']['id']), array('escape' => false));
   ?>
   &nbsp;&nbsp;|&nbsp;&nbsp;<?php 
   echo $this->Html->link($this->Form->button(__('Edit', true), array('type' => 'button','class' => 'blueBtn')),  array('action' => 'edit', $insuranceCompany['InsuranceCompany']['id']), array('escape' => false));
   ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php 
  echo $this->Form->button(__('Delete', true), array('type' => 'button','class' => 'blueBtn' ,'onclick' => "deleteJavaScriptCode(this);",'url' =>$this->Html->url(array('action' => 'delete', $insuranceCompany['InsuranceCompany']['id']))));
   
   ?></td>
		
	</tr>
<?php endforeach; ?>
	</table>
	 <?php
  
      } else {
  ?>
  <tr>
   <TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
  </tr>
  <?php
      }
  ?>
	</table>
	
</div>