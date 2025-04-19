<style>
@media print {
	#printButton {
		display: none;
	}
}
body{
	background:none;
	margin-top:10px !important;
	padding:none !important;
}
.a {
	text-align: center;
}
</style>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
	<table width="100%" style="border-bottom: solid 2px black">
		<tr>
			<td width="50%"><?php echo $this->Html->image('hope-logo-sm.gif');?></td>
			<td width="50%"><b>Hope Hospitals</b> Plot No. 2, Behind Go Gas,Teka Naka, <br>Kamptee
				Road, Nagpur - 440 017 <br> <b>Phone: </b>+91 712 2980073 <b>Email:
			</b>info@hopehospital.com<br><b>Website: </b>www.hopehospital.com</td>
		</tr>
		<tr><td style="font-size: 20px;font-weight: bold; text-align: center;" colspan="2"><?php echo "ANAESTHESIA NOTES";?></td></tr>
	</table>
	<?php $anaedata=$this->data;
	$personModel=new Person();
	$age=$personModel->getCurrentAge($patient['Person']['dob']);
	?>

	<span id="printButton"><?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));
	?>
	</span>
	<table width="100%" style="border-bottom: solid 2px black" >
		<tr>
			<td width="20%"><b>Date: </b></td>
			<td><?php echo $this->DateFormat->formatDate2Local($otList['OptAppointment']['schedule_date'],Configure::read('date_format')).' '.$otList['OptAppointment']['start_time']?>
			</td>
			<td><b>Dept:</b></td>
			<td><?php echo $department['Department']['name']." / ".$wardInfo['Ward']['name']; ?>
			</td>		
		</tr>
		<tr>
			<td><b>Name Of Patient :</b></td>
			<td><?php echo $patientDetailsForView['Patient']['lookup_name'] ; ?>
			</td>
			<td><b>Weight: </b></td>
			<td><?php echo $anaedata['AnaesthesiaNote']['weight'] ;?> KG(s)</td>
		</tr>
		<tr>
			<td><b>Age:</b></td>
			<td><?php echo !empty($age)?$age:$patientDetailsForView['Patient']['age']; ?> </td>
			<td><b>Sex:</b> </td><td><?php echo ucfirst($patientDetailsForView['Patient']['sex'])?></td>
		</tr>
		<tr>			
			<td><b>Surgeon :</b> </td>
			<td>
				<table>
					<tr>
						<td><b>1)</b> <?php echo $surgeon = ucfirst($otList['User']['first_name']).' '.ucfirst($otList['User']['last_name']) ; ?></td>
					</tr>
					<tr>
						<td><b>2)</b> <?php echo $anaedata['AnaesthesiaNote']['surgeon2'] ; ?></td>
					</tr>
				
				</table>
			</td>			
			<td colspan="1"><b>Anaesthesiologists :</b></td>
			<td><?php $anaesthesist = 'Dr. '.$otList['AnaeUser']['first_name']." ".$otList['AnaeUser']['last_name'];
		     if(empty($otList['AnaeUser']['first_name'])){
		     	$anaesthesist=$anaedata['AnaesthesiaNote']['anaethesiologists'];
		     }
		     echo $anaesthesist; ?>
			</td>
		</tr>		
		<tr>
			<td colspan="1"><b>Name Of Procedure :</b></td>
			<td><?php echo ucfirst(!empty ($otList['Surgery']['name'])?$otList['Surgery']['name']:$anaedata['AnaesthesiaNote']['procedure_name']); ?></td>
			<td><b>Consent: </b></td>
			<td><?php echo $anaedata['AnaesthesiaNote']['consent'];?></td>
		</tr>
		<tr>
			
			<td><b>ASA Grade:</b></td>
			<td><?php echo $anaedata['AnaesthesiaNote']['asa_grade'] ;?></td>
			</td>
			<td><b>NBM Since :</b></td>
			<td><?php echo $anaedata['AnaesthesiaNote']['nbm_since']; ?></td>
			</td>

		</tr>
		<tr>
			
			<!-- <td><b>Diagnosis:</b></td>
			<td><?php echo implode(',',$problemData);?></td>
			</td> -->
			<td><b>Package :</b></td>
			<td><?php echo $_SESSION['packName']; ?></td>
			</td>

		</tr>
	</table>
	<table width="100%" border="0" style="border-bottom: solid 1px black;">
		<tr>
			<td width="20%"><b>Past Illness :</b></td>
			
				<td style="line-height: 25px ;border-bottom:solid 1px black"><?php echo ucfirst($anaedata['AnaesthesiaNote']['past_illness'] ); ?></td>
		</tr>
		
		<tr>
			<td><b>Past Anaesthetics :</b></td>
		
				<td style="line-height: 25px ;border-bottom:solid 1px black"><?php echo ucfirst($anaedata['AnaesthesiaNote']['past_anaesthetics']) ; ?></td>
		</tr>
		<tr>
			<td><b>Pre - Op condition:</b></td>
			<td style="line-height: 25px ;border-bottom:solid 1px black"><?php echo ucfirst($anaedata['AnaesthesiaNote']['pre_opcondition'] ); ?></td>
						<!-- <tr><td style="border-bottom:solid 1px black">&nbsp;</td></tr>	 -->
					
		</tr>
		<tr>
			<td><b>Mallampatti Grade :</b></td>
			<td style="line-height: 25px ;border-bottom:solid 1px black"><?php echo ucfirst( $anaedata['AnaesthesiaNote']['mallampatti_grade']) ; ?></td>
		</tr>

		<tr>
			<td><b>Investigations:</b></td>
			<td style="line-height: 25px ;border-bottom:solid 1px black"><?php echo ucfirst($anaedata['AnaesthesiaNote']['investigations'] ); ?></td>
		</tr>

		
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<table width="100%" border="0" style="border-bottom: solid 1px black;">
		<tr >
			<th scope="col" style="border-bottom: solid 1px black; font-size: 15px"><b>Pre Medication</b></th>
		</tr>
		<tr>
			<td width="100%" valign="top">
				<table width="100%" border="0">
					<tr>
						<td><b>Time :</b></td>
						<td><?php echo $anaedata['AnaesthesiaNote']['pre_med_time']; ?></td>
					</tr>
					<tr>
						<td><b>Drug:</b></td>
						<td><?php echo ucfirst($anaedata['AnaesthesiaNote']['pre_med_drug']); ?></td>

					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table width="100%" border="0">
	</table>
	<?php if($anaedata['AnaesthesiaNote']['general']=='0'){?>
	<table width="100%" border="0px">
              <tr>
                <td colspan="4"><b>General Anaesthesia</b></td>
              </tr>
              <tr>
                <td>Induction</td>
                <td><?php echo ucfirst($anaedata['AnaesthesiaNote']['induction'])?></td>
                <td>Type</td>
                <td><?php echo ucfirst($anaedata['AnaesthesiaNote']['type1'])?></td>
              </tr>
              <tr>
                <td>ETT No</td>
                <td><?php echo ucfirst($anaedata['AnaesthesiaNote']['ettno'])?></td>
                <td>Oral/Nasal</td>
                <td><?php echo ucfirst($anaedata['AnaesthesiaNote']['on'])?></td>
              </tr>
              <tr>
                <td>Relaxation</td>
                <td><?php echo ucfirst($anaedata['AnaesthesiaNote']['relaxation'])?></td>
                <td>Ventilation</td>
                <td><?php echo ucfirst($anaedata['AnaesthesiaNote']['ventilation'])?></td>
              </tr>
              <tr>
                <td>Gases</td>
                <td><?php echo ucfirst($anaedata['AnaesthesiaNote']['gases'])?></td>
                <td>Reversal</td>
                <td><?php echo ucfirst($anaedata['AnaesthesiaNote']['reversal'])?></td>
              </tr>
              <tr>
                <td>Inhalational agent</td>
                <td><?php echo ucfirst($anaedata['AnaesthesiaNote']['agent'])?></td>
                <td>Extubatoin</td>
                <td><?php echo ucfirst($anaedata['AnaesthesiaNote']['extubatoin'])?></td>
              </tr>
    </table>
    <?php }?>

    <?php if($anaedata['AnaesthesiaNote']['general']=='1' || $anaedata['AnaesthesiaNote']['general']=='2'){?>
			<table width="100%" border="0">
					<tr>
						<th colspan="4" style="border-bottom: solid 1px black; font-size: 15px ; text-align: left"><b>Regional / Nerve Block</b></th>

					</tr>
					<tr>
						<td width="20%"><b>Type :</b></td>
						<td width="30%"><?php echo ucfirst($anaedata['AnaesthesiaNote']['type']);?></td>

						<td width="19%"><b>Onset:</b></td>
						<td><?php echo ucfirst($anaedata['AnaesthesiaNote']['onset'] ); ?></td>
					</tr>
					<tr>
						<td><b>Needle :</b></td>
						<td><?php echo ucfirst($anaedata['AnaesthesiaNote']['needle']) ; ?></td>
						<td><b>Level :</b></td>
						<td><?php echo  ucfirst($anaedata['AnaesthesiaNote']['level']); ?></td>
					</tr>
					<tr>
						<td><b>Space:</b></td>
						<td><?php echo ucfirst( $anaedata['AnaesthesiaNote']['space']); ?></td>
						<td><b>Duration :</b></td>
						<td><?php echo ucfirst($anaedata['AnaesthesiaNote']['duration']); ?></td>
					</tr>
					<tr>
						<td><b>Drug:</b></td>
						<td><?php echo ucfirst($anaedata['AnaesthesiaNote']['regional_drug']) ; ?></td>
						<td><b>Recovery :</b></td>
						
						<td><?php echo ucfirst($anaedata['AnaesthesiaNote']['recovery']) ; ?></td>
						
					</tr>
					<tr>
						<td><b>Volume:</b></td>
						<td><?php echo ucfirst($anaedata['AnaesthesiaNote']['volume']); ?></td>
						<td><b>Top - up :</b></td>
						<td><?php echo ucfirst($anaedata['AnaesthesiaNote']['top_up']); ?></td>
					</tr>
			</table>
    <?php }?>
    <?php if($anaedata['AnaesthesiaNote']['general']=='3'){?>
			<table width="100%" border="0">
					<tr>
						<th colspan="4" style="border-bottom: solid 1px black; font-size: 15px ; text-align: left"><b>Local Stand By</b></th>

					</tr>
					<tr>
						<td width="20%"><b>Type :</b></td>
						<td width="30%"><?php echo ucfirst($anaedata['AnaesthesiaNote']['local']);?></td>
					</tr>
			</table>
    <?php }?>


<table width="100%">
				<tr>
					<td valign="top" width="21%"><b>&nbsp;</b></td>
					<td valign="top" width="20%">&nbsp;</td>
					<td valign="top" width="22%"><b>Signature of Doctor </b></td>
					<td>________________________________</td>
				</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td valign="top">&nbsp;</td>
					<td valign="top"><b>Name Of Surgeon :</b></td>
					<td><?php echo ucfirst($dname) ;?></td>
				</tr>
			</table>

</body>
</html>
