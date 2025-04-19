<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		<?php echo $title_for_layout; ?>
</title>
			<!-- <?php echo $this->Html->css(array('internal_style.css')); ?> -->
<style>
.ht5 {
    height: 10px;
    margin: 0;
    padding: 0;
}
</style>
</head>
<body class="print_form" onload="window.print();window.close();"> <!-- onload="window.print();window.close();" -->
<div class="ht5">&nbsp;</div>
<table border="0" class="table_format" width="100%">
	 <tr>
		  <td class="row_format" width="16%"><strong>
		   <?php echo __('S/B Consultant',true); ?></strong>		  </td>
		   <td align="center"><b>:</b></td>
		  <td width="84%" class="row_format">
		   <?php  echo ucfirst($registrar[0]['fullname']); ?>		  </td>
	 </tr>
	 <tr>
		  <td class="row_format"><strong>
		   <?php echo __('S/B Registrar',true); ?></strong>
		  </td>
		   <td align="center"><b>:</b></td>
		  <td class="row_format">
		   <?php echo ucfirst($consultant[0]['fullname']); ?>
		  </td>
	 </tr>
	 <tr>
		  <td class="row_format"><strong>
		   <?php echo __('Create Time',true); ?></strong>
		  </td>
		   <td align="center"><b>:</b></td>
		  <td class="row_format">
		   <?php $noteDate = explode(' ',$note['Note']['note_date']);
				 echo $this->DateFormat->formatDate2Local($note['Note']['note_date'],Configure::read('date_format'),true);
			?>
		  </td>
	 </tr>	
 	
	<tr>
		  <td class="row_format" colspan="2"><strong>
				<?php echo __('Prescribed Medicine',true); ?></strong>
		  </td>
	 </tr>
 </table>
 	<div class="ht5">&nbsp;</div>		 	 	 
	<table width="100%" border="1" cellspacing="1" cellpadding="0" id='DrugGroup' class="tabularForm">
		<tr>
		  <td width="27%" height="20" valign="top" align="center"><b>Name of Medication</b></td>	
		  <td width="7%" valign="top" align="center"><b>Routes</b></td>		
		  <td width="8%" valign="top" align="center"><b>Dose</b></td>								  
		  <td width="9%" valign="top" align="center"><b>Quantity</b></td>
		  <td width="9%" valign="top" align="center"><b>No. Of Days</b></td>				 
		  <td width="20%" valign="top" colspan="4" align="center"><b>Timings</b></td>				 
	  </tr>
	 <?php foreach($medicines as $drugs) {?>				
				<tr>
					<td><?php echo $drugs['PharmacyItem']['name']; ?></td>
					<td><?php echo $drugs['SuggestedDrug']['route']; ?></td>
					<td><?php echo $drugs['SuggestedDrug']['frequency']; ?></td>
					<td><?php echo $drugs['SuggestedDrug']['quantity']; ?></td>
					<td><?php echo $drugs['SuggestedDrug']['dose']; ?></td>
					<?php if(!empty($drugs['SuggestedDrug']['first'])){  ?>
					<td><?php 
						if($drugs['SuggestedDrug']['first'] < 12){
							echo $drugs['SuggestedDrug']['first'].' AM' ;
						}else{
							if($drugs['SuggestedDrug']['first'] == 12)
								echo $drugs['SuggestedDrug']['first'].' PM' ;
							else
								echo $drugs['SuggestedDrug']['first']-12 .' PM' ; 
						}
					}else {?>
						</td>
						<td> -- </td> 
					<?php } ?>
					<?php if(!empty($drugs['SuggestedDrug']['second'])){ 
							 
					?>
					<td><?php 
						if($drugs['SuggestedDrug']['second'] < 12){
							echo $drugs['SuggestedDrug']['second'].' AM' ;
						}else{
							if($drugs['SuggestedDrug']['second'] == 12)
								echo $drugs['SuggestedDrug']['second'].' PM' ;
							else
								echo $drugs['SuggestedDrug']['second']-12 .' PM' ; 
						}
					}else {?>
						</td>
					<td> -- </td> 
					<?php } ?>
					<?php if(!empty($drugs['SuggestedDrug']['third'])){ ?>
					<td><?php 
						if($drugs['SuggestedDrug']['third'] < 12){
							echo $drugs['SuggestedDrug']['third'].' AM' ;
						}else{
							if($drugs['SuggestedDrug']['third'] == 12)
								echo $drugs['SuggestedDrug']['third'].' PM' ;
							else
								echo $drugs['SuggestedDrug']['third']-12 .' PM' ; 
						}
					}else {?>
						</td>
					<td> -- </td> 
					<?php } ?> 
					<?php if(!empty($drugs['SuggestedDrug']['forth'])){ 
							 	
					?>
					<td><?php 
						if($drugs['SuggestedDrug']['forth'] < 12){
							echo $drugs['SuggestedDrug']['forth'].' AM' ;
						}else{
							if($drugs['SuggestedDrug']['forth'] == 12)
								echo $drugs['SuggestedDrug']['forth'].' PM' ;
							else
								echo $drugs['SuggestedDrug']['forth']-12 .' PM' ; 
						}
					}else {?>
						</td>
					<td> -- </td> 
					<?php } ?> 
				</tr>
			<?php } ?>
	</table>					   		

 </body>
