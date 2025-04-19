<?php //debug($data); exit; ?>
<?php if(!empty($data)) {?>
<div class="inner_title"><h3>  <?php echo __('Assigned Radiology Tests'); ?> </h3>
</div>
<table border="1" class=" " cellpadding="0" cellspacing="0" width="100%" align="center" style="margin-top:10px;">
	<tr class="row_title">	
	    <td align="left" class="row_title">Sr. No</td>
       <td align="left" class="row_title">ID</td>
		<td align="Center" class="row_title">Test Name</td>
	
	</tr>
	<?php  $i=0; foreach($data as $datas){ $i++;?>
<tr>
<td class="row_format" align="left"><?php echo $i; ?></td>
 <td class="row_format" align="left"><?php echo $datas['RadiologyTestOrder']['order_id'];?></td>
<td class="row_format" align="Center"><?php echo $datas['Radiology']['name'];?></td></tr>
<?php }?>
</table>
<?php } else 
  { ?>
  <div class="inner_title"> <h3> <?php	echo __('No Lab Assigned'); ?> </h3> </div>
 <?php  } ?>
