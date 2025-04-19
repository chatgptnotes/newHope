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
margin: 0mm;  
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
<div style="margin-left: 6%; margin-top: <?php echo $margin; ?>" >
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="tbl table_format" align="center">
          <tr>
            <td width="10%" style="font-size: 15px;font-family: arial;"><strong>Name:</strong></td>
            <td width="20%"style="font-size: 15px;font-family: arial;"  align="left"><?php  
            if(!empty($patientDocumentdata['Patient']['lookup_name'])) 
            	echo $patientDocumentdata['Patient']['lookup_name'];?></td>
            <td width="10%" style="font-size: 15px;font-family: arial;" align="left"><strong>Visit ID:</strong></td>
            <td width="10%" style="font-size: 15px;font-family: arial;"><?php echo $patientDocumentdata['Patient']['admission_id'];?></td>         
            <td width="10%" style="font-size: 15px;font-family: arial;" align="left" valign="top"><strong>Age/Sex:</strong></td>
            <td width="20%" style="font-size: 15px;font-family: arial;" align="left" valign="top"><?php echo $patientDocumentdata['Patient']['age']." / ".ucfirst($patientDocumentdata['Patient']['sex']);?></td>
			
            <td width="20%" style="font-size: 15px;font-family: arial;" align="left" valign="top"><?php echo $this->DateFormat->formatDate2Local($patientDocumentdata['PatientDocument']['date'],Configure::read('date_format'),true);?></td>
            </tr>

<?php //echo $this->element('patient_header'); ?></div>
<!--<div class="" style="text-align: center;"><h3>Report on Radiologist</h3></div>-->


	<tr>
		<th colspan="6" style="font-size: 15px;font-family: arial;text-decoration: underline;"><strong> <?php
		$radNameList=array();
		foreach($radName as $radNames){
			$radNameList[]=ucwords(strtolower(html_entity_decode($radNames)));
		}
		$radNameDisplay=implode(",\n", $radNameList);	
		
		echo $radNameDisplay; ?></strong></th>
	</tr>
	
	<?php 	if(!empty($patientDocumentdata['PatientDocument']['note'])){?>
			<tr>			
				<td colspan="6" valign="top" style="padding-left: 20px;font-size: 15px;font-family: arial;text-align: justify-all;"><li><?php echo nl2br(ucfirst($patientDocumentdata['PatientDocument']['note']));?></li></td>
			</tr>	
	<?php }?>
</table>
<p class="ht5"></p>
<p class="ht5"></p>
<div align="right"  style="padding-right:60px;font-weight:bold;">Radiologist</div>
<div align="right"  style="padding-right:60px;font-weight:bold;"><?php if(!empty($serviceProviderData['ServiceProvider']['contact_person'])){
																			echo $serviceProviderData['ServiceProvider']['contact_person'];
																		}else{
																			echo "Dr. Neerja Prasad Tiwari";
																		}?></div>

<?php /*if($website=='kanpur' && $this->params->query['flag']=='print_with_header'){?>
<table width='100%' border="0" cellspacing="0" cellpadding="0"
	style="padding-top: 45%">
	<tr>

		<td class="boxBorderBotSolid"><?php echo $this->Html->image('icons/footer_perfect.jpg',array('width'=>'100%','height'=>'50%'));?>
		</td>

	</tr>
</table>
<?php }*/?>

<script>
window.onload = function() { window.print(); }
 </script>
</html>