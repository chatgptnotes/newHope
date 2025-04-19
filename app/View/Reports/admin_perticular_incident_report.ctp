<?php 
//pr($data);exit;
  if(!empty($errors)) {
?>

<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Particular Incident Report', true); ?></h3>

</div>
 <form name="reportfrm" id="reportfrm" action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "admin_perticular_incident_report/")); ?>" method="post" >
 <table align="center">
	 <tr>
		 <td colspan="8" align="right">Format</td>
		 <td><b>:</b></td>
		 <td colspan="8" align="left" width="70%"><?php
			echo $this->Form->input('IncidentReport.format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF')));
			  
		 ?></td>
	 </tr>
	 <tr>
		 <td colspan="8" align="right">Incident Type</td>
		 <td><b>:</b></td>
		 <td colspan="8" align="left" width="70%">
			<?php
				$patient_fall  = array('medication error'=>'Medication Error','patient fall'=>'Patient Fall','bed sores'=>'Bed Sores','needle stick injury'=>'Needle Stick Injury','ranfusion error'=>'Tranfusion Error','Other'=>'Other');
				echo $this->Form->input('IncidentReport.incident', array('label'=>false,'div'=>false,'error'=>false,'id' => 'incident','options'=>$patient_fall));
			?>
		</td>
	 </tr>
	  <?php 
			$currentYear = date("Y");
			 for($i=0;$i<=10;$i++) {
				$lastTenYear[$currentYear] = $currentYear;
				$currentYear--;
			 }
	  ?>
		<tr id = "year">
		 <td colspan="8" align="right">Year</td>
		 <td><b>:</b></td>
		  <td colspan="8" align="left">
			<?php 
	        echo $this->Form->input('IncidentReport.year', array('id'=>'year','label'=> false, 'div' => false, 'error' => false,'options' =>$lastTenYear));?>
			
		  </td>
		 </tr>
	 <?php
		$monthArray = array('01'=> 'January','02'=> 'February','03'=> 'March','04'=> 'April','05'=> 'May','06'=> 'June','07'=> 'July','08'=> 'August','09'=> 'September','10'=> 'October','11'=> 'November','12'=> 'December',);
	 ?>
		<tr id="month">
		   <td colspan="8" align="right">Month</td>
		   <td><b>:</b></td>
		   <td colspan="8" align="left">
			<?php 
	        echo $this->Form->input('IncidentReport.month', array('id'=>'month','label'=> false, 'div' => false, 'error' => false,'options' =>$monthArray,'empty'=>'All'));?>
			
		  </td>
		   
	  </tr>
	</table>
    <p class="ht5"></p>
	   <div align="center">
	  
		<div class="btns" style="float:none">
				<input type="submit" value="Get Report" class="blueBtn" id="submit" >&nbsp;&nbsp;
				<input type="submit" value="Show Graph" class="blueBtn" id="graph" onclick = "document.pressed=this.value" style="display:none;" >&nbsp;&nbsp;
				<?php echo $this->Html->link(__('Cancel', true),array('action' => 'all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
		</div>
		
	 </div>

 </form> 
