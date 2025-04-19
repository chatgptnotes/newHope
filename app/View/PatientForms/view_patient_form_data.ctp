<?php 
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
<h3> &nbsp; <?php echo __('Incident Form', true); ?></h3>
</div>
 <div class="btns">
  <?php #echo $this->Html->link(__('Print'), array('action' => 'printPatientForm',$patient_form_nr,$patient_nr), array('escape' => false,'class'=>'grayBtn'));
	echo $this->Html->link('Print','#',
			 array('class'=>'grayBtn', 'escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('admin' => false, 'action'=>'printPatientForm',$patient_form_nr,$patient_nr))."', '_blank',
			 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,left=400,top=400');  return false;"));
   			
	?>
 </div>  
<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">


<?php $i=1;
	foreach($formQuestions as $formquestion){?>
		<tr><td align="left"><strong>
		<?php echo $i.')&nbsp;'.$formquestion['FormQuestion']['name']; ?>
		</strong></td></tr>
  <?php	 foreach($formAnswers as $formAnswer){
  
			if($formAnswer['PatientDataForms']['form_question_id'] == $formquestion['FormQuestion']['id']){?>
				<tr><td align="left">
		<?php	echo $formAnswer['PatientDataForms']['data'];
		?>		
				</td></tr>
			
	<?php	}//end if
		
		}//foreach
				?>
	<?php $i++;
	}

?>