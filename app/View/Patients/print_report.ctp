<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		<?php echo $title_for_layout; ?>
</title>
			<?php echo $this->Html->css(array('internal_style.css')); ?>
<style>
.print_form{
	background:none;
	font-color:black;
	color:#000000;
}
.formFull td{
	color:#000000;
}
.tabularForm {
    background:#000;
}
.tabularForm td {
    background: #ffffff;
    color: #333333;
    font-size: 13px;
    padding: 5px 8px;
}
</style>
</head>
<body class="print_form" onload="javascript:window.print();window.close();">
<div class="inner_title">
	<h3><?php echo __('Patient Report', true); ?></h3>
	
</div>
<table border="0" class="tabularForm"  cellpadding="0" cellspacing="1" width="100%" style="text-align:center;">

 <tr class="row_title">
  	   <td class="table_cell"><strong><?php echo __('Patient Name', true); ?></strong></td>
	   <td class="table_cell"><strong><?php echo __('MRN', true); ?></strong></td>					  
	   <td class="table_cell"><strong><?php echo __('Patient ID', true); ?></strong></td>
	   <td class="table_cell"><strong><?php echo __('Registration Type', true); ?></strong></td>					   
	   <td class="table_cell"><strong><?php echo  __('Sex'); ?></strong></td>
	   <td class="table_cell"><strong><?php echo  __('Age'); ?></strong></td>				   
  </tr>
	<?php
	$toggle =0;
	foreach($pdfData as $patients){
		if($toggle == 0) {
			echo "<tr>";
			$toggle = 1;
		}else{
			echo "<tr>";
			$toggle = 0;
		}
	?>
	<td class="row_format"><?php echo $patients['Patient']['lookup_name']; ?> </td>
	<td class="row_format"><?php echo $patients['Patient']['admission_id']; ?> </td>
	<td class="row_format"><?php echo $patients['Patient']['patient_id']; ?> </td>
	<td class="row_format"><?php echo $patients['Patient']['admission_type']; ?> </td>
	<td class="row_format"><?php echo ucfirst($patients['Person']['sex']); ?> </td>
	<td class="row_format"><?php echo $patients['Person']['age']; ?> </td>
								   
	
 <?php	} ?>
 	
 
 </table>
 </body>
</html>
 