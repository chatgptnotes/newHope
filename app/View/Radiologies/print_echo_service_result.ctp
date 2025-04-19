<html moznomarginboxes mozdisallowselectionprint>
<head>
<title></title>
<style>
@page   
{  
size: auto;   
margin: 4mm;  
}  	
body {
    background: #fff none repeat scroll 0 0;
    font-family: Calibri;
    font-size: 10px;
    margin: 0;
    padding-top: 20px;
}	
table td {
    font-size: 14px;
}
.alignR{
float: right;
}
.fontBold{font-weight: bold;}
.textLeft{text-align: left;}
</style>
<div style="float:right;" id="printButton" >
		<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
	</div> 
<table width="90%" align="center" style="margin-top:18%">
	<tr><td><?php  //	echo $this->element('vadodara_header');?></td></tr>
</table>

<?php $unserData=unserialize($serviceDetails['Radiology2DEchoResult']['comment']);
$ageExp=explode(" ", $serviceDetails['Patient']['age']);
$age=$ageExp[0];

?>
<table width="100%" cellpadding="2" cellspacing="0" border="1" align="center" class="tabularForm" >
	<tr>
		<td colspan="6"><strong>Name : <?php echo $serviceDetails['Patient']['lookup_name'] ?></strong></td>
	</tr>
	<tr>
		<td colspan="3"><strong>Age/Gender : <?php echo $age." / ".ucfirst($serviceDetails['Patient']['sex']) ?></strong></td>
		<td colspan="3"><strong>Date : <?php echo $this->DateFormat->formatDate2Local($serviceDetails['Radiology2DEchoResult']['result_date'],Configure::read('date_format'),true); ?></strong></td>
	</tr>
  <tr>
  	<td colspan="6" style="text-align: center;font-size: 16px"><b><?php echo "2D ECHOCARDIOGRAPHY";?></b></td>
  </tr> 
</table>


<table width="100%" cellpadding="2" cellspacing="0" border="1" align="center" class="tabularForm" id="tableList1">
   
	<tr>
	 	<td class="fontBold textLeft">Aorta</td>
	 	<td class="textLeft"><?php echo $serviceDetails['Radiology2DEchoResult']['aorta'] ; ?></td>
	 	<td class="fontBold textLeft" class="fontBold">LVID(d)</td>
	 	<td class="textLeft"><?php echo $serviceDetails['Radiology2DEchoResult']['lvid_d']; ?></td>
	</tr>
	
	<tr>
	 	<td class="fontBold textLeft">AV cusp opening</td>
	 	<td class="textLeft"><?php echo $serviceDetails['Radiology2DEchoResult']['av_cusp_opening'] ; ?></td>
	 	<td class="fontBold textLeft">LVID(s)</td>
	 	<td class="textLeft"><?php echo $serviceDetails['Radiology2DEchoResult']['lvid_s']; ?></td>
	</tr>
	<tr>
	 	<td class="fontBold textLeft">Left Atrium</td>
	 	<td class="textLeft"><?php echo $serviceDetails['Radiology2DEchoResult']['left_atrium']; ?></td>
	 	<td class="fontBold textLeft">IVS(d)</td>
	 	<td class="textLeft"><?php echo $serviceDetails['Radiology2DEchoResult']['ivs_d']; ?></td>
	</tr>
	<tr>
	 	<td class="fontBold textLeft">LVEF</td>
	 	<td class="textLeft"><?php echo $serviceDetails['Radiology2DEchoResult']['lvef']; ?></td>
	 	<td class="fontBold textLeft">LVPW(d)</td>
	 	<td class="textLeft"><?php echo $serviceDetails['Radiology2DEchoResult']['lvpw_d']; ?></td>
	</tr>
	<tr>
	 	<td class="fontBold textLeft">Right Atrium</td>
	 	<td class="textLeft"><?php echo $serviceDetails['Radiology2DEchoResult']['right_atrium']; ?></td>
	 	<td class="fontBold textLeft">Right Ventricle(d)</td>
	 	<td class="textLeft"><?php echo $serviceDetails['Radiology2DEchoResult']['right_ventricle_d']; ?></td>
	</tr>
	<tr>
		<td class="fontBold textLeft">Septum</td>
		<td colspan="3"><?php echo $serviceDetails['Radiology2DEchoResult']['septum']; ?></td>
	</tr>
	<tr>
		<td class="fontBold textLeft">Cardiac valves</td>
		<td colspan="3"><?php echo $serviceDetails['Radiology2DEchoResult']['cardiac_valves'] ; ?></td>
	</tr>
	<tr>
		<td class="fontBold textLeft">Wall motion abnormality</td>
		<td colspan="3"><?php echo $serviceDetails['Radiology2DEchoResult']['wall_motion_abnormality'] ; ?></td>
	</tr>
	<tr>
		<td class="fontBold textLeft">LVEF</td>
		<td colspan="3"><?php echo $serviceDetails['Radiology2DEchoResult']['lvef_text'] ; ?></td>
	</tr>
	<tr>
		<td class="fontBold textLeft">LV clot/ vegetation/ pericardial effusion</td>
		<td colspan="3"><?php echo $serviceDetails['Radiology2DEchoResult']['lv_clot_vegetation'] ; ?></td>
	</tr>
	<tr>
		<td class="fontBold textLeft">IVC</td>
		<td colspan="3"><?php echo $serviceDetails['Radiology2DEchoResult']['ivc'] ; ?></td>
	</tr>
	<tr>
		<td class="fontBold textLeft">E/A</td>
		<td ><?php echo $serviceDetails['Radiology2DEchoResult']['ea'] ; ?></td>
		<td class="fontBold textLeft">Diastolic Dysfunction</td>
		<td ><?php echo $serviceDetails['Radiology2DEchoResult']['diastolic_dysfunction'] ; ?></td>
	</tr>
	<tr>
		<td class="fontBold textLeft">PASP by TR jet</td>
		<td colspan="3"><?php echo $serviceDetails['Radiology2DEchoResult']['pasp_by_tr_jet'] ; ?></td>
	</tr>

</table>
<table width="100%" cellpadding="0" cellspacing="1" border="1" align="center" class="tabularForm" id="tableList1">
	
	<tr>
		<td></td>
		<td class="fontBold">PG mm of Hg</td>
		<td class="fontBold">MG mm of Hg</td>
		<td class="fontBold">Grades of Regurgitation</td>
	</tr>
	<tr>
		<td class="fontBold">Mitral Valve</td>
		<td><?php echo $serviceDetails['Radiology2DEchoResult']['mitral_valve_pg'] ; ?></td>
		<td><?php echo $serviceDetails['Radiology2DEchoResult']['mitral_valve_mg'] ; ?></td>
		<td><?php echo $serviceDetails['Radiology2DEchoResult']['mitral_valve_grade'] ; ?></td>
	</tr>
	<tr>
		<td class="fontBold">Aortic Valve</td>
		<td><?php echo $serviceDetails['Radiology2DEchoResult']['aortic_valve_pg'] ; ?></td>
		<td><?php echo $serviceDetails['Radiology2DEchoResult']['aortic_valve_mg'] ; ?></td>
		<td><?php echo $serviceDetails['Radiology2DEchoResult']['aortic_valve_grade'] ; ?></td>
	</tr>
	<tr>
		<td class="fontBold">Tricuspid Valve</td>
		<td><?php echo $serviceDetails['Radiology2DEchoResult']['tricuspid_valve_pg'] ; ?></td>
		<td><?php echo $serviceDetails['Radiology2DEchoResult']['tricuspid_valve_mg'] ; ?></td>
		<td><?php echo $serviceDetails['Radiology2DEchoResult']['tricuspid_valve_grade'] ; ?></td>
	</tr>
	<tr>
		<td class="fontBold">Pulm Valve/RVOT</td>
		<td><?php echo $serviceDetails['Radiology2DEchoResult']['pulm_valve_pg'] ; ?></td>
		<td><?php echo $serviceDetails['Radiology2DEchoResult']['pulm_valve_mg'] ; ?></td>
		<td><?php echo $serviceDetails['Radiology2DEchoResult']['pulm_valve_grade'] ; ?></td>
	</tr>
</thed>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" align="center" class="tabularForm" id="tableList1">
	<tr>
	    <td class="fontBold textLeft">FINAL IMPRESSION</td>
	 	<td class="fontBold textLeft"><?php echo $serviceDetails['Radiology2DEchoResult']['final_impression']; ?></td>
	</tr>
	
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="right" class="tabularForm" id="tableList1" style="padding-top:150px;">
	<tr>
    <td class="fontBold textLeft" style="float:right;">Dr AKSHAY DALAL <br>MD MEDICINE, DNB CARDIOLOGY  <br> MMC 0814 
</td>
	 
	</tr>
	
</table>
<script>
	window.onload = function() { window.print(); }
</script>
