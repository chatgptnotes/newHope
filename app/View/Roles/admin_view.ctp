<?php
	//template file for role details view
	//debug($new);exit;
?>
<div class="inner_title">
	<h3>	
			<div style="float:left">&nbsp; <?php echo __('View Role Details'); ?></div>			
			<div style="float:right;"><?php
	       		echo $this->Html->link(__('Back to List'), array('action' => 'index'), array('escape' => false,'class'=>'blueBtn'));
			?></div>
	</h3>
	<div class="clr"></div>
</div>

<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="center">
   <?php 
        if(!empty($errors)) {
         echo implode($errors,"<br />");
        }
   ?>
  </td>
 </tr>
</table>

<table border="0" class="table_view_format" cellpadding="0" cellspacing="0" width="550"  align="center">
	 <tr class="first">
		<td class="row_format"><strong>
		<?php echo __('Role Name')?> 
		</td>
		<td class="row_format">
			<?php echo $role['Role']['name']; ?>
		</td>
	</tr>	
	<tr>
		<td class="row_format"><strong>
		<?php echo __('Has Specialty ');  ?> 
		</td>
		<td class="row_format">
			 <?php  echo ($role['Role']['hasspecility']==1)?'Yes':'No'; ?>
		</td>
	</tr>
	<!-- <tr  class="row_gray">
		<td class="row_format"><strong>
		<?php echo __('Location ');  ?> 
		</td>
		<td class="row_format">
			 <?php  echo $role['Location']['name']; ?>
		</td>
	</tr> -->
	<tr  class="row_gray">
		<td class="row_format"><strong>
		<?php echo __('Store Location ');  ?> 
		</td>
		<td class="row_format">
			 <?php  echo $role['StoreLocation']['name']; ?>
		</td>
	</tr>
	 <tr >
		<td class="row_format"><strong>
		 <?php echo __('Created By');  ?> 
		</td>
		<td class="row_format">
	         <?php  echo $role['User']['first_name']." ".$role['User']['last_name']; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong>
		 <?php echo __('Modified By');  ?> 
		</td>
		<td class="row_format">
	         <?php  echo $role['User']['first_name']." ".$role['User']['last_name']; ?>
		</td>
	</tr>
	 <tr>
		<td class="row_format"><strong>
		 <?php echo __('Created On');  ?> 
		</td>
		<td class="row_format">
	         <?php 
				echo $this->DateFormat->formatDate2Local($role['Role']['create_time'],Configure::read('date_format'),true);	
	         ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td class="row_format"><strong>
		 <?php echo __('Modified On');  ?> 
		</td>
		<td class="row_format">
	         <?php  echo $this->DateFormat->formatDate2Local($role['Role']['modify_time'],Configure::read('date_format'),true);?>
		</td>
	</tr>
	 
	</table>
</form>