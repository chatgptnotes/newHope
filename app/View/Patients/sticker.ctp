<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title></title>
<?php echo $this->Html->css(array('internal_style.css')); ?>
<style type="text/css">
@media print {
	body {
		background-color: #FFFFFF;
		background-image: none;
		color: #000000
	}
	#ad {
		display: none;
	}
	#leftbar {
		display: none;
	}
	#contentarea {
		width: 100%;
	}
}
</style>
</head>
<body style="background: #fff; color: #000; width: 800px;">

<div class="patient_info1">
<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top">
		<table cellspacing="0" cellpadding="0" width="100%" border="1">
		<?php for($i=1; $i<=10;$i++){ ?>
			<tr>
			<?php for($j=1; $j<=4; $j++){?>
				
				<?php if($i== 10){?>
				<td  valign="bottom" style="width: 200px;height:90px">
					<table  cellspacing="0" cellpadding="0" align="center">
				<?php }elseif($i > 4){?>
				<td valign="bottom" style="width: 200px;height:107px">
					<table  cellspacing="0" cellpadding="0" width="100%" align="center">
					<?php }else{?>
				 <td valign="middle" style="width: 200px;height:107px">
					<table  cellspacing="0" cellpadding="0" width="100%" align="center">
				<?php }?>
				<?php	$complete_name  = ucfirst($patient['Initial']['name'])." ".ucfirst($patient['Patient']['lookup_name']) ; ?>
					<tr>
						<!-- <td valign="top" align="right"><strong>Name :</strong></td> -->
						<td valign="middle" align="center"><?php echo $complete_name ;?></td>
					</tr>
					<tr>
						<!--	<td valign="top" align="right"><strong><?php echo __("MRN")?> :</strong></td>-->
						<td valign="middle" align="center"><?php echo $patient['Patient']['admission_id'] ;?></td>
					</tr>
					<tr>
										<!-- <td valign="top" align="right"><strong>Age/Sex :</strong></td>-->
										<td valign="middle" align="center"><?php echo $patient['Patient']['age'].",".ucfirst($patient['Patient']['sex']) ;?></td>
									</tr>
									
									
					<tr>
						<!--	<td valign="top" align="right"><strong>Hospital :</strong></td>-->
						<td valign="middle" align="center"><?php echo $facilityDetails['Facility']['name'] ;?></td>
					</tr>
				</table>
				</td>
				<?php } ?>
			</tr>
			<?php } ?>
		</table>
		</td>
		</tr>
</table>
</div>

</body>
</html>
