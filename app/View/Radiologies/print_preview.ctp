<html moznomarginboxes mozdisallowselectionprint>
<head>
<title></title>
<style>
h1 {
	border-bottom: 2px solid black;
	font-weight: normal;
	margin-bottom: 5px;
	width: 140px;

}

@page   
{  
size: auto;   
margin: 4mm;  
}  
body  
{  
background-color:#FFFFFF;   
margin: 0px;  
}
</style>
</head>
<body style="background:none;width:98%;margin:auto;">
        <?php $margin = "18%";?>
<div style="margin-left: 1%; margin-top: <?php echo $margin; ?>" >
<?php echo $this->element('patient_header'); ?></div>
<!-- <div class="" style="text-align: center;"><h3>Report on Radiology</h3></div> -->

<table width="100%" cellpadding="0" cellspacing="3" border="0" class="" align="center" >
	<tr>
		<th style="text-decoration: underline;"><strong> <?php echo $radiologyTestName; ?></strong></th>
	</tr>
	<tr>
		<td>
			<table width="100%" cellpadding="5" cellspacing="5" border="0" style="margin-left: 0%">
		
				<tr>
					<td valign="top" align="left"><b><?php echo __('Findings')?>:</b></td>
					<td class="" valign="top" colspan="3" style="font-size: 14px;">
						<font face="Times New Roman"  ><?php   
					$note = isset($data[0]['RadiologyResult']['note'])?$data[0]['RadiologyResult']['note']:'' ;
					echo nl2br($note); ?></font></td>
				</tr>

				<?php if($data[0]['RadiologyResult']['split']!=""){?>
				<tr>
					<td valign="top" align="left"><b><?php echo __('No of Slices')?>:</b>
					</td>
					<td class="" valign="top"><?php  
					$split = isset($data[0]['RadiologyResult']['split'])?$data[0]['RadiologyResult']['split']:'' ;
					echo nl2br($split); ?></td>
				</tr>
				<?php }?>
					  <?php
					  if($data[0]['RadiologyResult']['img_impression']!=""){?>
					<tr>
						<td valign="top" align="left"><b><?php echo __('Impression')?>:</b>
						</td>
						<td class="" valign="top"><strong><?php  
						$imgImpr = isset($data[0]['RadiologyResult']['img_impression'])?$data[0]['RadiologyResult']['img_impression']:'' ;
						echo nl2br($imgImpr); ?></strong></td>
					</tr>
					<?php }?>
					
				  <?php if($data[0]['RadiologyResult']['advice']!=""){?>
					<tr>
						<td valign="top" align="left"><b><?php echo __('Advice')?>:</b>
						</td>
						<td class="" valign="top"><strong><?php  
						$advice = isset($data[0]['RadiologyResult']['advice'])?$data[0]['RadiologyResult']['advice']:'' ;
						echo nl2br($advice); ?></strong></td>
					</tr>
					<?php }?>
				<tr>
					<td colspan="3" align="right"
						style="text-align: right;  border-top: 1px solid; padding-right: 10%; padding-top: 7%;">
						<b><?php   echo "DR."." ".strtoupper($radiologist['User']['full_name']) ;?> </b>
					</td>
				</tr>
			</table>
		</td>
	
	</tr>
</table>


<script>
window.onload = function() { window.print(); }
 </script>
</html>