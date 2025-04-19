<style>
<!--
.textBoxExpnd{
	float: none ;
}
body{
	background:none;
	margin-top:10px !important;
	padding:none !important;
}
-->
</style>
<?php 
	$data = $this->data['OperativeNote'] ;		

?>
<div class="inner_title">&nbsp;
	<span><?php echo $this->Html->link('Print','javascript:void(0)',array('escape'=>false,'class'=>'blueBtn','onclick'=>'window.print();','id'=>'printButton'))?></span></div>
	<table width="100%" style="border-bottom: solid 2px black">
		<tr>
			<td width="50%"><?php echo $this->Html->image('hope-logo-sm.gif');?></td>
			<td width="50%"><b>Hope Hospitals</b> Plot No. 2, Behind Go Gas,Teka Naka, <br>Kamptee
				Road, Nagpur - 440 017 <br> <b>Phone: </b>+91 712 2980073 <b>Email:
			</b>info@hopehospital.com<br><b>Website: </b>www.hopehospital.com</td>
		</tr>
		<tr><td style="font-size: 20px;font-weight: bold; text-align: center;" colspan="2"><?php echo "OPERATION NOTES";?></td></tr>
	</table>
 <?php echo $this->element('print_patient_info') ?>

<table width="100%" border="0" class="table_format">
	<!-- <tr>
		<td ><b>Name Of Patient : </b></td>
		<td colspan="3" style="border-bottom:solid 1px black"><?php echo  $patientDetailsForView['Patient']['lookup_name'] ;?></td>
	</tr> -->
	<tr>
		<td><b>Surgery : </b></td>
		<?php ?>
		<td colspan="3" style="border-bottom:solid 1px black"><?php echo ucfirst($otList['Surgery']['name']);?></td>
	</tr>
	<tr>
		<td><b>Diagnosis : </b></td>
		<?php $final_diagnosis=isset($oprNotes['OperativeNote']['diagnosis'])?$oprNotes['OperativeNote']['diagnosis']:"";?>
		<td colspan="3" style="border-bottom:solid 1px black"><?php echo ucfirst($final_diagnosis);?></td>
	</tr>
	<tr>
		<td><b>Dept./Ward : </b></td>
		<td style="border-bottom:solid 1px black"><?php   
 			echo $department['Department']['name']." / ".$wardInfo['Ward']['name'];  ?></td>
		<td><b>Surgeon :</b></td>
		<td style="border-bottom:solid 1px black"><?php  

			$surgeon=isset($MuraliData['DoctorProfile']['doctor_name'])?$MuraliData['DoctorProfile']['doctor_name']:'';  
				echo $surgeon ;?></td>
	</tr>
	<tr>
		<td><b>Procedure : </b></td>
		<td style="border-bottom:solid 1px black"><?php  
			echo  $oprNotes['OperativeNote']['procedure_name'] ;?></td>
		<td ><b>Assist Surgeon :</b></td>
		<td style="border-bottom:solid 1px black"><?php echo $data['assist_surgeon'];?></td>
	</tr>
	<tr>
		<td valign="top"><b>Sensitivity : </b></td>
		<td valign="top" style="border-bottom:solid 1px black"><?php echo $oprNotes['OperativeNote']['sensitivity'];?></td>
		<td valign="top"><b>Anaesthesia : </b></td>
		<td><table width="100%" border="0" >
				<tr>
					<td style="border-bottom:solid 1px black"><b>(1)</b> <?php 
								 $anaesthesist1 = ($oprNotes['OperativeNote']['anaesthesia_1']) ? 'Dr.'.$oprNotes['OperativeNote']['anaesthesia_1'] : '';
								 $anaesthesist2 = ($oprNotes['OperativeNote']['anaesthesia_2']) ? 'Dr.'.$oprNotes['OperativeNote']['anaesthesia_2'] : '';
								 /*if(empty($otList['AnaeUser']['first_name'])){
								 	$anaesthesist=ucwords($data['anaesthesia_1']);
								 }	*/							
								echo  $anaesthesist1 ;
						?></td>
				</tr>
				<?php if($anaesthesist2){ ?>
				<tr>
					<td style="border-bottom:solid 1px black"><b>(2)</b> <?php echo ucwords($anaesthesist2);?></td>
				</tr>
			<?php } ?>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top"><b>Date : </b></td>
		<td valign="top" style="border-bottom:solid 1px black"><?php 
			if(!empty($oprNotes['OperativeNote']['ot_date'])){
				$surgeryDate = $this->DateFormat->formatDate2Local($oprNotes['OperativeNote']['ot_date'],Configure::read('date_format'),false) ;
			}		
			//$surgeryDate .= " ".$otList['OptAppointment']['start_time'] ; 
			echo  $surgeryDate ;?></td>
		<td valign="top"><b>Staff Nurse : </b></td>
		<td valign="top" style="border-bottom:solid 1px black"> 
				<?php 
					if($oprNotes['OperativeNote']['scrubbed']==1) echo 'Scrubbed, ' ;
					if($oprNotes['OperativeNote']['rotating']==1) echo 'Rotating' ;  ?>
			</td>
	</tr> 
	<!-- <tr>
			
			<td valign="top"><b>Diagnosis:</b></td>
			<td valign="top"><?php echo implode(',',$problemData);?></td>
			</td>
			<td valign="top"><b>Package :</b></td>
			<td valign="top"><?php echo $_SESSION['packName']; ?></td>
			</td>

		</tr> -->
</table>
<table width="100%" border="0px" class="table_format">
	<tr>
		<td width="5%" valign="top"><b>Routine / Emergency : </b></td>
		<td valign="top" colspan="3" style="border-bottom:solid 1px black">
			<?php 
					if($oprNotes['OperativeNote']['routine_emergency']==0) echo 'Routine, ' ;
					if($oprNotes['OperativeNote']['routine_emergency']==1) echo 'Emergency' ;  
			?>
		</td> 
	</tr>
	<tr>
		<td valign="top"><b>OT : </b></td>
		<td style="border-bottom:solid 1px black"><?php echo $otRoom[$otList['OptAppointment']['opt_id']] ;?></td>
	</tr>
	<tr>
		<td><b>Tourniquet Time : </b></td>
		<td style="border-bottom:solid 1px black"><?php echo $oprNotes['OperativeNote']['tourniquet_time'];?></td>
	</tr>
	<tr>
		<td><b>Blood Loss : </b></td>
		<td style="border-bottom:solid 1px black"><?php echo $oprNotes['OperativeNote']['blood_loss'];?></td>
	</tr>
	<tr>
		<td><b>BT Given or Not : </b></td>
		<td style="border-bottom:solid 1px black"><?php echo $oprNotes['OperativeNote']['bt_given'];?></td>
	</tr>
	<tr>
		<td valign="top"><b>Operation Notes :</b></td>
		<td width="24%" valign="top" colspan="3">
			<div style="min-height: 200px">
				<table width="100%">
					<tr><td style="line-height: 25px"><u><?php echo nl2br($oprNotes['OperativeNote']['operation_notes']);?></u></td></tr>
					</table>
			</div>
		</td>
	</tr>
	<tr><td colspan="4">&nbsp;</td></tr>
	<tr>
		<td colspan="4">
			<table width="100%">
				<tr>
					<td valign="top" width="21%"><b>Date/Time :</b></td>
					<td valign="top" width="20%">
					<?php
					if(!empty($oprNotes['OperativeNote']['ot_notes_date']))
					echo $this->DateFormat->formatDate2Local($oprNotes['OperativeNote']['ot_notes_date'],Configure::read('date_format'),true) ;;?></td>
					<td valign="top" width="22%"><b>Signature of Surgeon </b></td>
					<td>________________________________</td>
				</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td valign="top">&nbsp;</td>
					<td valign="top"><b>Name Of Surgeon :</b></td>
					<td><?php echo $surgeon ;?></td>
				</tr>
			</table>
		</td>
	</tr>
	
</table>
<p>&nbsp;</p> 
 
