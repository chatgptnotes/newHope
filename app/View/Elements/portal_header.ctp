<?php 
echo $this->Html->css('prettyPhoto.css');
echo $this->Html->script(array('jquery.ui.accordion.js','jquery.prettyPhoto','bsa.js'));
$complete_name  = ucfirst($patient[0]['lookup_name']) ;
$b_string=implode(",",$b);
$c_string=implode(",",$c);



?>



<!-- <div class="patient_info section"> -->
<div style="padding-bottom:45px;">
<table width="50%" cellpadding="0" cellspacing="0" border="0"
	align="right" valign='top' style="">
	<tr class="row_title">
		<?php $nameexp=explode(' ',$recivePortalData['dataForPotal']['Patient']['lookup_name']); 
		if(!empty($recivePortalData['dataForPotal']['Person']['middle_name'])){
			$patientName=$recivePortalData['dataForPotal']['Person']['last_name'].",".$recivePortalData['dataForPotal']['Person']['first_name'].",".$recivePortalData['dataForPotal']['Person']['middle_name'];
		}
		else{
			$patientName=$recivePortalData['dataForPotal']['Person']['first_name'].",".$recivePortalData['dataForPotal']['Person']['last_name'];
}?>
		<td class="table_cell" width="50%" height="30%" colspan='4'><?php echo __('Patient Name')?><strong>:&nbsp;</strong><b><?php echo $patientName;?>
		</b></td>
	</tr>
	<tr class="row_title">
		<td class="table_cell" width="20%"><?php echo __('DOB')?>:<b><?php  echo $this->DateFormat->formatDate2Local($recivePortalData['dataForPotal']['Person']['dob'],Configure::read('date_format'),false);?></b></td>
		<td class="table_cell" width="20%"><?php echo __('Gender')?>:<b><?php echo ucfirst($recivePortalData['dataForPotal']['Person']['sex']); ?></b></td>
		<td class="table_cell" width="20%"><?php echo __('MRN')?>:<b><?php echo $recivePortalData['dataForPotal']['Patient']['admission_id']; ?></b></td>
		<?php $firstthree=substr($recivePortalData['dataForPotal']['Person']['mobile'],0,6);
		$firstthreechunk=chunk_split($firstthree,3, "-");
		$middlethree=substr($recivePortalData['dataForPotal']['Person']['mobile'], -4);
		$phone=$firstthreechunk.$middlethree;
		 ?>
		 <?php if(!empty($recivePortalData['dataForPotal']['Person']['mobile'])){?>
		<td class="table_cell" width="20%"><?php echo __('Phone')?>:<b><?php echo $phone; ?></b></td>
<?php }?>
	</tr>
</table>
</div>
<!-- </div> -->
<!-- BuySellAds.com Ad Code -->
<style type="text/css" media="screen">
.bsap a {
	float: left;
}
</style>


