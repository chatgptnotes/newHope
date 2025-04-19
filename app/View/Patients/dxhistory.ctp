<?php
echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js'));
echo $this->Html->css(array('internal_style.css'));?>

<div class="inner_title">
	<h3>
		&nbsp;
		<?php  echo __('Diagnosis History', true); ?>
	</h3>
</div>
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><div class="alert">
				<?php 
				foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
			</div></td>
	</tr>
</table>
<?php } ?>

<p class="ht5"></p>
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" style="margin-right: 20px">

	<?php //debug($icd_imo);exit;
	 if(empty($icd_imo)) { ?>
	
	<table align="center">
		<tr>
			<td text-align="center" style="color: red"><?php echo "There are no recorded diagnosis for this patient at this time." ?>
			</td>
		</tr>
	</table>
	<?php } else{?>
	<div style="padding-left: 18px;">
		<?php // echo $this->Html->link(__('Medication'),'#', array('escape' => false,'class'=>'blueBtn', 'id'=>'medication'));?>
		<?php  echo $this->Html->link(__('Comment'),'#', array('escape' => false,'class'=>'blueBtn ', 'id'=>'comment'));?>
	</div>



	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%">
		<tr class="row_title">
			<td class="table_cell"><strong>Current Diagnoses code and Description</strong>
			</td>
			<td class="table_cell"><strong>Disease Status</strong></td>
			<td class="table_cell"><strong>Start</strong></td>
			<td class="table_cell"><strong>Stop</strong></td>
			<!-- <td class="table_cell"><strong>Comments</strong></td> -->
			<td class="table_cell"><strong>Action</strong></td>
		</tr>
		<?php
		//-----------------------------to connect the socket--------------------------------------------------
			
		$cnt_comm=0;
		$toggle =0;
		if(count($icd_imo) > 0) {
					foreach($icd_imo as $disp){
					if($disp['NoteDiagnosis']['patient_id'] == $patientId){	

				 $cnt_comm++;
				 if($disp['NoteDiagnosis']['disease_status']== ''&& $disp['NoteDiagnosis']['start_dt']== '' && $disp['NoteDiagnosis']['end_dt']=='' ){ ?>
		<tr class="row_gray">

			<td class="row_format"><?php echo $disp[NoteDiagnosis][snowmedid]; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $disp[NoteDiagnosis][snowmedid]; ?>
			</td>
			<td class="row_format" colspan="3"><?php echo $this->Html->link('Add',array('action' => 'edit_diagnosis',$patient_id,$disp['NoteDiagnosis']['snowmedid'])); ?>
			</td>


		</tr>
		<?php if(empty($disp['NoteDiagnosis']['snowmedid'])) {?>
		<tr class="row_title">
			<td class="row_format" colspan="4"
				style="color: red; display: none; padding-left: 30px"
				id='cmnt<?php echo $cnt_comm?>'><span><?php  echo "Comment Not Found"; ?>
			</span></td>
		</tr>


		<?php }
}
				else{  ?>
		<tr class="row_gray">
			<td class="row_format">&nbsp;<?php echo  $disp[NoteDiagnosis][snowmedid]; ; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  $disp[NoteDiagnosis][diagnoses_name];; ?>
			</td>
			<td class="row_format">&nbsp;<?php echo $disp[NoteDiagnosis][disease_status]; ?>
			</td>
			<td class="row_format">&nbsp;<?php echo $this->DateFormat->formatDate2Local($disp[NoteDiagnosis][start_dt],Configure::read('date_format_us'),false); ?>
			</td>
			<td class="row_format">&nbsp;<?php echo $this->DateFormat->formatDate2Local($disp[NoteDiagnosis][end_dt],Configure::read('date_format_us'),false); ?>
			</td>
			<!-- <td class="row_format">&nbsp;<?php echo $disp[NoteDiagnosis][comment]; ?>
			</td> -->
			<td class="row_format">&nbsp;<?php echo $this->Html->link($this->Html->image('edit-icon.png',array('title'=>'Edit Problem','error'=>false)),array('action' => 'edit_diagno',$patient_id,$disp['NoteDiagnosis']['snowmedid'],$disp['NoteDiagnosis']['id']),array('escape' => false)); ?>
			</td>
		</tr>
		<?php if(!empty($disp[NoteDiagnosis][icd_id])) {?>
		<tr class="row_title">
			<td class="row_format" colspan="4"
				style="color: green; display: none; padding-left: 30px"
				id='cmnt<?php echo $cnt_comm?>'><span><?php  echo $disp[NoteDiagnosis][comment]; ?>
			</span></td>
		</tr>

		<?php }
}
}
}
		}?>
	</table>
	
	<?php if($cnt_comm == 0){?>
	<table align="center">
		<tr>
			<td text-align="center" style="color: red"><?php echo "There are no recorded diagnosis for this patient for current encounter." ?>
			</td>
		</tr>
	</table>
<?php } ?>	
	
	
	
	
	
	
	
	
	
	
	
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">
	<tr class="row_title">
	<td class="table_cell"><strong>Previous Diagnoses code and Description</strong>
	</td>
	<td class="table_cell"><strong>Disease Status</strong></td>
	<td class="table_cell"><strong>Start</strong></td>
	<td class="table_cell"><strong>Stop</strong></td>
	<!-- <td class="table_cell"><strong>Comments</strong></td> -->
	<td class="table_cell"><strong>Action</strong></td>
	</tr>
	<?php
	//-----------------------------to connect the socket--------------------------------------------------
		
	$cnt_comm=0;
	$toggle =0;
	if(count($icd_imo) > 0) {
		foreach($icd_imo as $disp){
		if($disp['NoteDiagnosis']['patient_id'] < $patientId){
			$cnt_comm++;
			if($disp['NoteDiagnosis']['disease_status']== ''&& $disp['NoteDiagnosis']['start_dt']== '' && $disp['NoteDiagnosis']['end_dt']=='' ){ ?>
			<tr class="row_gray">
	
				<td class="row_format"><?php echo $disp[NoteDiagnosis][snowmedid]; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $disp[NoteDiagnosis][snowmedid]; ?>
				</td>
				<td class="row_format" colspan="3"><?php echo $this->Html->link('Add',array('action' => 'edit_diagnosis',$patient_id,$disp['NoteDiagnosis']['snowmedid'])); ?>
				</td>
	
	
			</tr>
			<?php if(empty($disp['NoteDiagnosis']['snowmedid'])) {?>
			<tr class="row_title">
				<td class="row_format" colspan="4"
					style="color: red; display: none; padding-left: 30px"
					id='cmnt<?php echo $cnt_comm?>'><span><?php  echo "Comment Not Found"; ?>
				</span></td>
			</tr>
	
	
			<?php }
	}
					else{  ?>
			<tr class="row_gray">
				<td class="row_format">&nbsp;<?php echo  $disp[NoteDiagnosis][snowmedid]; ; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  $disp[NoteDiagnosis][diagnoses_name];; ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $disp[NoteDiagnosis][disease_status]; ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $this->DateFormat->formatDate2Local($disp[NoteDiagnosis][start_dt],Configure::read('date_format_us'),false); ?>
				</td>
				<td class="row_format">&nbsp;<?php echo $this->DateFormat->formatDate2Local($disp[NoteDiagnosis][end_dt],Configure::read('date_format_us'),false); ?>
				</td>
				<!--<td class="row_format">&nbsp;<?php echo $disp[NoteDiagnosis][comment]; ?>
				</td>-->
				<td class="row_format">&nbsp;<?php echo $this->Html->link($this->Html->image('edit-icon.png',array('title'=>'Edit Problem','error'=>false)),array('action' => 'edit_diagno',$patient_id,$disp['NoteDiagnosis']['snowmedid'],$disp['NoteDiagnosis']['id']),array('escape' => false)); ?>
				</td>
			</tr>
			<?php if(!empty($disp[NoteDiagnosis][icd_id])) {?>
			<tr class="row_title">
				<td class="row_format" colspan="4"
					style="color: green; display: none; padding-left: 30px"
					id='cmnt<?php echo $cnt_comm?>'><span><?php  echo $disp[NoteDiagnosis][comment]; ?>
				</span></td>
			</tr>
	
			<?php }
	}
	}
		}
	}?>
	
	
		</table>
		<?php if($cnt_comm == 0){?>
			<table align="center">
				<tr>
					<td text-align="center" style="color: red"><?php echo "There are no recorded diagnosis for this patient for previous encounter." ?>
					</td>
				</tr>
			</table>
		<?php } ?>	
	<?php } //end of empty?>
	<!-- 	<tr>
		<td><input name="" type="submit" value="Transfer" class="blueBtn"
			id="dxhistory" style="margin: 0px;" /></td>
	</tr> -->


	<br></br>

	<!--  
<table width="100%" cellpadding="0" cellspacing="0" border="0"
	align="center" style="margin-right: 20px;">
	<tr>
		<td width='80px'></td>
		<td valign='top'>Terminal Diagnoses</td>
	</tr>
	<tr>
		<td width='20px'></td>
		<td>
			<table border="1" class="patientInfo" width="90%">
				<tr>
					<td width="60%" style="padding-left: 10px;"><h4>Diagnoses</h4></td>
					<td width="20%" style="padding-left: 10px;"><h4>Start</h4></td>
					<td width="20%" style="padding-left: 10px;"><h4>Stop</h4></td>
				</tr>
			/*	<?php// foreach($terminal as $disp) { ?>
				<tr>
					<td width="60%">&nbsp;<?php //echo $disp[icds][icd_code]; ?>
						&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $disp[icds][description]; ?>
					</td>
					<td width="20%">&nbsp;<?//php echo $disp[NoteDiagnosis][start_dt]; ?>
					</td>
					<td width="20%">&nbsp;<?//php echo $disp[NoteDiagnosis][end_dt]; ?>
					</td>
				</tr>
			<?php// } ?>
			</table>
		</td>
	</tr>
	<!-- 	<tr>
		<td><input name="" type="submit" value="Transfer" class="blueBtn"
			id="dxhistory" style="margin: 0px;" /></td>
	</tr> 
</table>
-->


	<script>
	jQuery(document).ready(function() {

		$('#dxhistory').click(function() {

			parent.$.fancybox.close();

		});

	});

	
	
	 //--------toggle----

  //  $(document).ready(function(){
//      $("#medication").click(function(){
//        $("#md").toggle();
//      });
//    });


 
	 
   
    $(document).ready(function(){
    	  $("#comment").click(function(){
            var cnt_comm=0;
            $( "td span" ).each(function(){
        		  cnt_comm++;
        		  
    			     $("#cmnt"+cnt_comm).toggle();
	       		});
        	    
    	  });
    	});

</script>