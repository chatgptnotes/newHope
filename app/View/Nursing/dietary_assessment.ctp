<style>
.tddate img{float:inherit;}
</style>
<style>
#busy-indicator {
	display: none;
	left: 50%;
	margin-top: 220px;
	position: absolute;
}
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
</style>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#itemfrm").validationEngine();
	});
	
</script>
<div class="inner_title">
	<h3>
		<?php echo __('Dietary Assessment Chart'); ?>
	</h3>
	<span><?php 
	if($source=='')
		echo $this->Html->link(__('Back'),array('action' => 'patient_information',$patient_id), array('escape' => false,'class'=>'blueBtn'));
	else
		echo $this->Html->link(__('Back'),array('controller' => 'patients','action' => 'patient_information',$patient_id), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
</div>

<!-- Patient Information -->
<?php echo $this->element('patient_information');?>

<p class="ht5"></p>
<form name="itemfrm" id="itemfrm"
	action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "dietaryAssessment/".$this->params['pass'][0])); ?>"
	method="post">
	<div id="formTable">
		<table width="100%" border="0" cellspacing="0" cellpadding="0"
			id="row" align="left">
			<tr>
				<td width="13%" height="35" class="tdLabel"><span
					id="dateLabel">Date of Assessment&nbsp;<font color="red">*</font>
				</span></td>
				<td width="20%" class="tddate"><span id="first_date"><?php 	
			echo $this->Form->input('DietaryAssessment.date', array('type'=>'text','id'=>'date','label'=> false, 'div' => false, 'error' => false,'readonly'=>'readonly','class' => 'validate[required,custom[mandatory-date]] textBoxExpnd'));?>
				</span>
				</td>
				<td colspan="3" width="81%" class="tddate"><?php echo $this->Form->checkbox('previousRecord', array('id' => 'previousRecord','label'=>false,'div'=>false,'onclick'=>'getChanged(this.id);')); ?>&nbsp;Date
					of Previous Assessment&nbsp;<span id="second_date"><?php echo $this->Form->input('datePrevious', array('type'=>'text','id'=>'previousDate','label'=> false, 'div' => false, 'error' => false,'style'=>'width:150px;','readonly'=>'readonly','onchange'=> $this->Js->request(array('action' => 'dietaryAssessment','admin'=>false),array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)), 'async' => true, 'update' => '#formTable', 'data' => '{date:$("#previousDate").val(),patient_id:'.$this->params['pass'][0].'}', 'dataExpression' => true, 'div'=>false))));?>
				</span></td>
			</tr>
		</table>
		<p class="ht5"></p>
		<!-- two column table start here -->


   <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" align="center">
	  <tr>
		<td width="50%" align="left" valign="top" style="padding-top:10px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
			  <tr>
				<td width="24%" class="tdLabel">Diet Specifications</td>
				<td width="63%">
				<?php echo $this->Form->input('DietaryAssessment.diet_specification',array('class'=>'textBoxExpnd','legend'=>false,'label'=>false,'id' => 'diet_specification')); ?></td><td></td>
			  </tr>
			  <tr>
				<td class="tdLabel">RT Feed</td>
				<td><?php echo $this->Form->input('DietaryAssessment.rt_feed',array('legend'=>false,'label'=>false,'id' => 'rt_feed','class'=>'textBoxExpnd')); ?></td>
			  </tr>                              
			  <tr>
				<td class="tdLabel">Soft</td>
				<td><?php echo $this->Form->input('DietaryAssessment.soft',array('legend'=>false,'label'=>false,'id' => 'soft','class'=>'textBoxExpnd'));?></td>
			  </tr>
			  <tr>
				<td class="tdLabel">Bland</td>
				<td><?php echo $this->Form->input('DietaryAssessment.bland',array('legend'=>false,'label'=>false,'id' => 'bland','class'=>'textBoxExpnd'));?></td>
			  </tr>
			  <tr>
				<td class="tdLabel">Liquid</td>
				<td><?php echo $this->Form->input('DietaryAssessment.liquid',array('legend'=>false,'label'=>false,'id' => 'liquid','class'=>'textBoxExpnd')); ?></td>
			  </tr>
		  </table>
		</td>
			<td width="50%" align="left" valign="top" style="padding-top:7px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" >
					  <tr>
						<td width="35%" class="tdLabel">Total Calories Required Per Day</td>
						<td width="63%"><?php echo $this->Form->input('DietaryAssessment.total_calories_required',array('legend'=>false,'label'=>false,'id' => 'total_calories_required','class'=>'textBoxExpnd')); ?></td>
						<td>call/d</td>
					  </tr>
					  <tr>
						<td class="tdLabel">Proteins</td>
						<td><?php echo $this->Form->input('DietaryAssessment.proteins',array('legend'=>false,'label'=>false,'id' => 'proteins','class' => 'validate[optional,custom[onlyNumber]] textBoxExpnd'));?></td>
						<td>g/d</td>
					  </tr>
					  <tr>
						<td class="tdLabel">Carbohydrates</td>
						<td><?php echo $this->Form->input('DietaryAssessment.carbohydrates',array('legend'=>false,'label'=>false,'id' => 'carbohydrates','class'=>'textBoxExpnd')); 
						?></td>
						<td> g/d</td>
					  </tr>
					  <tr>
						<td class="tdLabel">Lipids</td>
						<td><?php echo $this->Form->input('DietaryAssessment.lipids',array('legend'=>false,'label'=>false,'id' => 'lipids','class'=>'textBoxExpnd')); ?></td>
						<td>g/d</td>
					  </tr>
			  </table>
			
	</td>
	  </tr>
	</table>
	<!-- two column table end here -->
	<div>&nbsp;</div>
	
		<div class="tdLabel2">
			<strong>DIETARY NOTES</strong>
		</div>
		<p class="ht5"></p>
		<table width="100%" cellpadding="0" cellspacing="1" border="0"
			class="tabularForm" id="progressNotes">
			<tr>
				<th width="215" style="margin:2px">Date</th>
				<!-- <th width="80">Time</th> -->
				<th width="">Progress Notes</th>
			</tr>
			<tr>
				<td class="tddate"><?php echo $this->Form->input('DietaryNote_1.date',array('class'=>'dietary_notes_date textBoxExpnd','legend'=>false, 'readonly'=>'readonly','label'=>false,'id' => 'dietary_notes_date_1')); ?>
				</td>

				<td width="86%"class="tdLabel"><?php echo $this->Form->input('DietaryNote_1.progress_note',array('legend'=>false,'label'=>false,'id' => 'dietary_notes_progress_note_1','class'=>'textBoxExpnd' )); ?>
				</td>
			</tr>
			<tr>
				<td class="tddate"><?php echo $this->Form->input('DietaryNote_2.date',array('class'=>'dietary_notes_date textBoxExpnd','legend'=>false,'label'=>false, 'readonly'=>'readonly','id' => 'dietary_notes_date_2')); ?>
				</td>
				<td width="86%"class="tdLabel"><?php echo $this->Form->input('DietaryNote_2.progress_note',array('legend'=>false,'label'=>false,'id' => 'dietary_notes_progress_note_2','class'=>'textBoxExpnd')); ?>
				</td>
			</tr>
			<tr>
				<td class="tddate"><?php echo $this->Form->input('DietaryNote_3.date',array('class'=>'dietary_notes_date textBoxExpnd','legend'=>false,'label'=>false, 'readonly'=>'readonly','id' => 'dietary_notes_date_3')); ?>
				</td>
				<!-- <td><?php echo $this->Form->input('',array('name'=>'data[DietaryAssessment][dietary_notes_time][]','legend'=>false,'label'=>false,'id' => 'dietary_notes_time_3')); ?></td> -->
				<td width="86%"class="tdLabel"><?php echo $this->Form->input('DietaryNote_3.progress_note',array('legend'=>false,'label'=>false,'id' => 'dietary_notes_progress_note_3','class'=>'textBoxExpnd' )); ?>
				</td>
			</tr>
			<!--

   -->
		</table>

		<div style="float: right">
			<input name="" type="button" id="addButton" value="Add More"
				class="blueBtn" /> <input name="" type="button" id="removeButton"
				value="Remove" class="blueBtn" style="display: none" />
		</div>
		<div class="ht5">&nbsp;</div>
		<div class="ht5">&nbsp;</div>
		<div class="ht5">&nbsp;</div>
		<div class="ht5">&nbsp;</div>

		<div class="btns">

			<input class="blueBtn" type="submit" value="Save" id="save">

			<!--  <input name="" type="button" value="Cancel" class="grayBtn" tabindex="19"/>-->

		</div>
		<div class="clr ht5"></div>
	</div>
</form>

<script>
jQuery(document).ready(function(){
	$('#second_date').hide('fast');

	var counter = 4;

	 $('#addButton').live('click',function(){ 
	$( ".dietary_notes_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
		
	});
			  });

	 $( ".dietary_notes_date" ).datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
			
		});
	$("#addButton").click(function () {	 				 
	var newNoteDiv = $(document.createElement('tr'))
    .attr("id", 'NoteDiv' + counter);
	var date_row = '<td class="tddate"><input class="dietary_notes_date" type="text" readonly="readonly" id="dietary_notes_date_'+ counter +'" name="data[DietaryNote_'+counter+'][date]"></td>';
	//var time_row = '<td><input type="text" id="dietary_notes_time_'+ counter +'" name="data[DietaryAssessment][dietary_notes_time][]"></td>';
	var progress_note = '<td width="86%" class="tdLabel" ><input type="text" id="dietary_notes_progress_note_'+ counter +'" name="data[DietaryNote_'+counter+'][progress_note]" class="textBoxExpnd"></td>';
	//var newHTml =    '<td><input  type="text" value="" id="drug' + counter + '" class=" drugText ac_input" name="drug[]" autocomplete="off"></td><td><input type="text" value="" id="dose'+counter+'" class="" name="dose[]"></td><td>'+route_option+'</td><td>'+fre_option+'</td>'+quality_opt;
	          		 			
	newNoteDiv.append(date_row +  progress_note);		 
	newNoteDiv.appendTo("#progressNotes");		
				 			 
	counter++;
	if(counter > 4) $('#removeButton').show('slow');
     });

	$("#removeButton").click(function () {
		counter--;			 
    	$("#NoteDiv" + counter).remove();
 		if(counter == 4) $('#removeButton').hide('slow');
  });

});

	$(function () {	
			 var daysToEnable = <?php echo json_encode($arrayDate); ?>;	
	// This is for datepicker
	 $("#date").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			beforeShowDay: disableSpecificDates,
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
			onSelect:function(){$(this).focus();}
		
			
		});

		

	
			//alert(daysToEnable);
            $('#previousDate').datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',
				maxDate: new Date(),
                //beforeShowDay: enableSpecificDates,
               dateFormat:'<?php echo $this->General->GeneralDate();?>',
            });
 
	//Function created to collect previous dates only. Return true if date found and false to hide date not in table
            function enableSpecificDates(date) {
                var month = date.getMonth();
                var day = date.getDate();
                var year = date.getFullYear();
                for (i = 0; i < daysToEnable.length; i++) {
                    if ($.inArray((month + 1) + '-' + day + '-' + year, daysToEnable) != -1) {
                        return [true];
                    }
                }
                return [false];
            }

	//Disable specific days
		 function disableSpecificDates(date) {
                var month = date.getMonth();
                var day = date.getDate();
                var year = date.getFullYear();
                for (i = 0; i < daysToEnable.length; i++) {
                    if ($.inArray((month + 1) + '-' + day + '-' + year, daysToEnable) != -1) {
                        return [false];
                    }
                }
                return [true];
            }
        });

	function getChanged(id){
		$('.message').hide('fast');
		if(document.getElementById('previousRecord').checked){
			//alert($('#first_date').innerHtml);
			$('#first_date').hide('slow');
			$('#dateLabel').hide('slow');
			$('#submit').hide('slow');
			$('#second_date').show('fast');


		} else {
			$('#first_date').show('fast');
			$('#dateLabel').show('fast');
			$('#second_date').hide('slow');
			$('#submit').show('fast');
		}
	}
</script>
