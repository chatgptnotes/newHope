<?php echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->css(array('jquery.autocomplete.css','skeleton.css'));
?>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#preferencefrm").validationEngine();
	});
</script>
<div class="inner_title">
<h3><?php echo __('Add Preference Card', true); ?></h3>
<span><?php  	echo $this->Html->link("Back",array('action'=>'rad_preferencecard',$patient_id),array('escape'=>false,'class'=>'blueBtn')); 	         			
                            	?></span>
</div>
<?php echo $this->element('patient_information');  ?>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?>
  </td>
 </tr>
</table>
<?php } ?>
<?php echo $this->Form->create('Preference',array("url"=>array("controller"=>"Radiologies","action" => "save_preference_card",$patientid), "admin" => false,'type' => 'file','id'=>'preferencefrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); ?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  align="center">
	<tr>
	<td class="form_lables" align="right">
	<?php echo __('Preference Card Title',true); ?><font color="red">*</font>
	</td>
	<td>
        <?php  echo $this->Form->input('PreferencecardRad.patient_id', array('type' => 'hidden', 'value'=> $patient_id));
        echo $this->Form->input('PreferencecardRad.card_title', array('class' => 'validate[required,custom[name]]', 'id' => 'customzipcode','style'=>'width:250px;', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
		<td class="form_lables" align="right">
		<?php echo __('Procedure Name'); ?><font color="red">*</font>
		</td>
		<td>
        <?php 
          echo $this->Form->input('PreferencecardRad.procedure_id', array('empty'=>'Please Select','options' => $procedure, 'id' => 'procedure_id', 'label'=> false, 'div' => false, 'error' => false,'style'=> 'width:270px',
          														  'class' => 'validate[required,custom[mandatory-select]]',));
        ?>
        </td>
	</tr>
	
	<tr>
	<td class="form_lables" align="right">
	<?php echo __(Configure::read('doctorLabel'),true); ?><font color="red">*</font>
	</td>
	<td>
        <?php
	     		 
	        echo $this->Form->input('PreferencecardRad.doctor_id', array('empty'=>'All Doctors','options' => $doctorlist, 'id' => 'doctor_id', 'label'=> false, 'div' => false, 'error' => false,
          														  'class' => 'validate[required,custom[mandatory-select]]',));
        ?>
	</td>
	</tr>
	
	<tr>
	<td class="form_lables" align="right" valign="top">
	<?php echo __('Instrument Set Name',true); ?><font color="red">*</font>
	</td>
	
	<td>
	<table width="100%" id="intrumentid">
	<tr><td>
        <?php echo $this->Form->input('', array('type'=>'text' ,'class' => 'drugText validate[required,custom[mandatory-select]]','id'=>"instrument$i",'name'=> 'data[instrument][]','value'=>$drugValue,'counter'=>$i,style=>"width:250px;")); ?>
        &nbsp;
	<input name="" type="button" id="addButton" value="Add More"
				class="blueBtn" style="text-align:right"/> <input name="" type="button" id="removeButton"
				value="Remove" class="blueBtn" style="display: none" />
	</td></tr>
	</table>
	
	</td>
	
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Equipment Name',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('PreferencecardRad.equipment_name', array('cols' => '35', 'rows' => '10', 'id' => 'equipment', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables" align="right" valign="top">
	<?php echo __('SPD Items',true); ?>
	</td>
	<td>
	<table width="100%" id="spdid">
	<tr><td>
        <?php 
		 
          echo $this->Form->input('', array('class' => 'spdtext', 'id' => 'spd_1','name'=> 'data[spd][]', 'label'=> false, 'div' => false,'style'=>'width:150px;', 'error' => false));
	  echo " Qty<font color='red'>*</font>: ".$this->Form->input('', array('id' => 'spdqt_1','name'=> 'data[spdqt][]', 'label'=> false,'class' => 'validate[required,custom[mandatory-select]]', 'div' => false,'style'=>'width:48px;', 'error' => false));
        ?>
	<input name="" type="button" id="addButton_spd" value="Add More"
				class="blueBtn" style="text-align:right"/> <input name="" type="button" id="removeButton_spd"
				value="Remove" class="blueBtn" style="display: none" />

	</td></tr>
	</table>
	</td>
	</tr>
	<tr>
	<td class="form_lables" align="right" valign="top">
	<?php echo __('Radiology Item Name',true); ?>
	</td>
	<td>
        <table width="100%" id="orid">
	<tr><td>
        <?php 
		 
          echo $this->Form->input('', array('class' => 'ortext','name'=> 'data[or][]', 'id' => 'or_1', 'label'=> false, 'div' => false,'style'=>'width:150px;', 'error' => false));
	  echo " Qty<font color='red'>*</font>: ".$this->Form->input('PreferencecardRad.orqt_1', array('name'=> 'data[orqt][]', 'id' => 'orqt_1', 'label'=> false,'class' => 'validate[required,custom[mandatory-select]]', 'div' => false,'style'=>'width:48px;', 'error' => false));
        ?>
	<input name="" type="button" id="addButton_or" value="Add More"
	class="blueBtn" style="text-align:right"/> <input name="" type="button" id="removeButton_or" value="Remove" class="blueBtn" style="display: none" />

	</td></tr>
	</table>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Medications',true); ?>
	</td>
	
        <td>
        <?php 
        echo $this->Form->textarea('PreferencecardRad.medications', array('cols' => '35', 'rows' => '10', 'id' => 'medication', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
       
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Dressing',true); ?>
	</td>
	
       <td>
        <?php 
        echo $this->Form->textarea('PreferencecardRad.dressing', array('cols' => '35', 'rows' => '10', 'id' => 'dressing', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
   
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Prep and Position',true); ?>
	</td>
	
        <td>
        <?php 
        echo $this->Form->textarea('PreferencecardRad.position', array('cols' => '35', 'rows' => '10', 'id' => 'position', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
   
	</td>
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Notes',true); ?>	</td>
	
        <td>
        <?php 
        echo $this->Form->textarea('PreferencecardRad.notes', array('cols' => '35', 'rows' => '10', 'id' => 'notes', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>

	
	</tr>
   
   
	<tr>
	<td colspan="2" align="center">
        <?php 
   	echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));
        ?>
	&nbsp;&nbsp;<input type="submit" value="Submit" class="blueBtn">
	</td>
	</tr>
	</table>
<?php echo $this->Form->end();?>

<script>
       $(document).ready(function(){
    	/*   jQuery(document).ready(function(){
   			 
   			jQuery("#labManagerfrm").validationEngine();

   			  
   		});*/

     		 

		//for instrument add & remove button
		var counter = 2;
		 
		   $("#addButton").click(function () {	 				 
	          var newNoteDiv = $(document.createElement('tr'))
                 .attr("id", 'NoteDiv' + counter);
	          var instrument_row = '<td><input class="drugText validate[required,custom[mandatory-select]] " type="text" id="instrument_'+ counter +'" name="data[instrument][]"  style="width:250px"></td>';
	        //var time_row = '<td><input type="text" id="dietary_notes_time_'+ counter +'" name="data[DietaryAssessment][dietary_notes_time][]"></td>';
	     //var progress_note = '<td><input type="text" id="dietary_notes_progress_note_'+ counter +'" name="data[DietaryNote_'+counter+'][progress_note]" class="textBoxExpnd" style="width:98%"></td>';
	//var newHTml =    '<td><input  type="text" value="" id="drug' + counter + '" class=" drugText ac_input" name="drug[]" autocomplete="off"></td><td><input type="text" value="" id="dose'+counter+'" class="" name="dose[]"></td><td>'+route_option+'</td><td>'+fre_option+'</td>'+quality_opt;
	          		 			
	newNoteDiv.append(instrument_row);		 
	newNoteDiv.appendTo("#intrumentid");		
				 			 
	counter++;
	if(counter > 2) $('#removeButton').show('slow');
     });

	$("#removeButton").click(function () {
		counter--;			 
    	$("#NoteDiv" + counter).remove();
 		if(counter == 2) $('#removeButton').hide('slow');
  });

  //for SPD add & remove button
		var counter_spd = 2;
		 
		  $("#addButton_spd").click(function () {	 				 
	          var newNoteDiv_spd = $(document.createElement('tr'))
                 .attr("id", 'NoteDiv_spd' + counter_spd);
	          var spd_row = '<td><input class="spdtext" type="text" id="spd_'+ counter +'" name="data[spd][]"  style="width:150px">';
	          var qt_row = ' Qty<font color="red">*</font>: <input type="text" id="dietary_notes_time_'+ counter +'" name="data[spdqt][]" class="validate[required,custom[mandatory-select]] " style="width:48px"></td>';
	     //var progress_note = '<td><input type="text" id="dietary_notes_progress_note_'+ counter +'" name="data[DietaryNote_'+counter+'][progress_note]" class="textBoxExpnd" style="width:98%"></td>';
	//var newHTml =    '<td><input  type="text" value="" id="drug' + counter + '" class=" drugText ac_input" name="drug[]" autocomplete="off"></td><td><input type="text" value="" id="dose'+counter+'" class="" name="dose[]"></td><td>'+route_option+'</td><td>'+fre_option+'</td>'+quality_opt;
	          		 			
	newNoteDiv_spd.append(spd_row + qt_row);		 
	newNoteDiv_spd.appendTo("#spdid");		
				 			 
	counter_spd++;
	if(counter_spd > 2) $('#removeButton_spd').show('slow');
     });

	$("#removeButton_spd").click(function () {
		counter_spd--;			 
    	$("#NoteDiv_spd" + counter_spd).remove();
 		if(counter_spd == 2) $('#removeButton_spd').hide('slow');
  });

  //for OR add & remove button
		var counter_or = 2;
		 
		   $("#addButton_or").click(function () {	 				 
	          var newNoteDiv_or = $(document.createElement('tr'))
                 .attr("id", 'NoteDiv_or' + counter_or);
	          var or_row = '<td><input class="ortext" type="text" id="dietary_notes_date_'+ counter +'" name="data[or][]"  style="width:150px">';
	          var orqt_row = ' Qty<font color="red">*</font>: <input type="text" id="dietary_notes_time_'+ counter +'" name="data[orqt][]" class="validate[required,custom[mandatory-select]] "style="width:48px"></td>';
	     //var progress_note = '<td><input type="text" id="dietary_notes_progress_note_'+ counter +'" name="data[DietaryNote_'+counter+'][progress_note]" class="textBoxExpnd" style="width:98%"></td>';
	//var newHTml =    '<td><input  type="text" value="" id="drug' + counter + '" class=" drugText ac_input" name="drug[]" autocomplete="off"></td><td><input type="text" value="" id="dose'+counter+'" class="" name="dose[]"></td><td>'+route_option+'</td><td>'+fre_option+'</td>'+quality_opt;
	          		 			
	newNoteDiv_or.append(or_row + orqt_row);		 
	newNoteDiv_or.appendTo("#orid");		
				 			 
	counter_or++;
	if(counter_or > 2) $('#removeButton_or').show('slow');
     });

	$("#removeButton_or").click(function () {
		counter_or--;			 
    	$("#NoteDiv_or" + counter_or).remove();
 		if(counter_or == 2) $('#removeButton_or').hide('slow');
  });

  $('.drugText')
	.live(
	'focus',
	function() {
	var counter = $(this).attr("counter");
       if ($(this).val() == "") {
		$("#Pack" + counter).val("");
	}$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "preferences", "action" => "getdeviceused","admin" => false,"plugin"=>false)); ?>",
	{
	width : 250,
	selectFirst : false,
});
});//EOF autocomplete

$('.spdtext')
	.live(
	'focus',
	function() {
	var counter = $(this).attr("counter");
       if ($(this).val() == "") {
		$("#Pack" + counter).val("");
	}$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "preferences", "action" => "getradspditem","admin" => false,"plugin"=>false)); ?>",
	{
	width : 250,
	selectFirst : false,
});
});//EOF autocomplete

$('.ortext')
	.live(
	'focus',
	function() {
	var counter = $(this).attr("counter");
       if ($(this).val() == "") {
		$("#Pack" + counter).val("");
	}$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "preferences", "action" => "getraditem","admin" => false,"plugin"=>false)); ?>",
	{
	width : 250,
	selectFirst : false,
});
});//EOF autocomplete
	
				
		  
       });//eof ready
       
       
 </script>
