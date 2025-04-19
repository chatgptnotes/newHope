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
	@page {
  size: A4;
  /* margin: 0; */
  margin-top: 48px !important ;
  margin-right: 24px !important ;
  margin-left: 24px !important ;
  margin-bottom: 48px !important ;
}

	table td {
	    font-size: 12px !important;
	}
}

table td {
    font-size: 12px;
}
</style>
</head>
<body onload="window.print();" style="background: #fff; color: #000; width: 800px;">

<div class="patient_info1">
<table width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top">
		<table cellspacing="0" cellpadding="0" width="100%" border="1">
		<?php /* debug($patient); */for($i=1; $i<=9;$i++){ ?>
			<tr>
			<?php for($j=1; $j<=4; $j++){?>
			
				<?php if($i== 9){?> <!-- width: 200px;height:135px -->
				<td  valign="middle" style="">
					<table  cellspacing="0" cellpadding="1" align="left" style="padding: 5px 5px 5px 5px">
				<?php }elseif($i > 4){?>
				<td valign="middle" style="">
					<table  cellspacing="0" cellpadding="1" width="100%" align="left" style="padding: 5px 5px 5px 5px">
					<?php }else{?>
				 <td valign="middle" style="">
					<table  cellspacing="0" cellpadding="1" width="100%" align="left" style="padding: 5px 5px 5px 5px">
				<?php }?>
				<?php	$complete_name  = ucfirst($patient['Initial']['name'])." ".ucfirst($patient['Patient']['lookup_name']) ; ?>
					
					<tr>
						
						<td valign="middle" align="left" colspan="2"><b><?php echo $complete_name ;?></b></td>
						
					</tr>

					<tr>
						
						<td valign="middle" align="left" width="100%">UHID :<?php echo $patient['Patient']['patient_id'];?>
						
					</tr>
					<tr>
						
						<td valign="middle" align="left" colspan="2">Visit ID: <?php echo $patient['Patient']['admission_id']; ;?></td>
					</tr>
					
					<tr>
						<!-- <td valign="top" align="right"><strong>Age/Sex :</strong></td>-->
						<?php /* $age=explode(" ",$patient['Patient']['age']); */?>
						<td valign="middle" align="left" colspan="2">Age/Gender: <?php echo $patientAge ." / ".ucfirst($patient['Patient']['sex']) ;?></td>
						
						
					</tr>
									
									
					<!-- <tr>
						
						<td valign="middle" align="left" colspan="2">Visit Date: <?php echo date('d/m/Y H:i A',strtotime($patient['Patient']['form_received_on'])) ;?></td>
					</tr> -->
					<tr>
						
						<td valign="middle" align="left" colspan="2">Consultant: <?php echo "Dr.".$patient['User']['first_name']." ".$patient['User']['last_name'] ;?></td>
					</tr>

					<tr>
						
						<td valign="middle" align="left" colspan="2">Tariff: <?php echo $patient['TariffStandard']['name'] ;?></td>
					</tr>

					<!-- <tr> 
						 <td valign="top" align="left" colspan="2"><?php $bar = new TCPDFBarcode($patient['Patient']['patient_id'],'C128'); 
					    echo $bar->getBarcodeSVG(0.7,10);?></td>
						
					</tr> -->
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
<script>

</script>
