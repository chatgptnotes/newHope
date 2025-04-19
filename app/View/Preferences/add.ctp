
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#preferencefrm").validationEngine();
	
		
		
			
	});
</script>
<div class="inner_title">
<h3><?php echo __('Add Preference Card', true); ?></h3>
<span>
	<?php  	
		echo $this->Html->link(__('Back'),array("controller" => "Preferences", "action" => "user_preferencecard", $patient_id), array('escape' => false,'class'=>"blueBtn "));
		//echo $this->Html->link("Back",array('controller'=>!empty($returnController)?$returnController:'preferences','action'=>'preferencecard',$patient_id,$this->request->pass[1]),array('escape'=>false,'class'=>'blueBtn')); 	         			
    ?>
</span>
</div>
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
<!--<form name="locationfrm" id="locationfrm" action="<?php echo $this->Html->url(array("controller" => "locations", "action" => "add", "admin" => true)); ?>" method="post"  >
--><?php echo $this->Form->create('Preference',array("url"=>array("action" => "save_preference_card",$patientid), "admin" => false,'type' => 'file','id'=>'preferencefrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	))); ?>
	<?php  //echo $this->Form->hidden('Preferencecard.type',array('value'=>$type));?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  align="center">
	
	<tr>
	<td class="form_lables" align="right" width="10%">
	<?php echo __('Preference Card Title',true); ?><font color="red">*</font>
	</td>
	<td width="20%">
        <?php  echo $this->Form->input('Preferencecard.patient_id', array('type' => 'hidden', 'value'=> $patient_id));
        echo $this->Form->input('Preferencecard.card_title', array('class' => 'validate[required,custom[name]]', 'id' => 'customzipcode','style'=>'width:30%;', 'label'=> false, 'div' => false, 'error' => false));
        ?>
	</td>
	</tr>
	<tr>
		<td class="form_lables" align="right">
		<?php echo __('Procedure Name'); ?><font color="red">*</font>
		</td>
		<td>
			<table width="100%" id="prcedureId">
			<tr><td>
		     <span style="float:left">   
		     <?php echo $this->Form->input('', array('type'=>'text' ,'class' => 'procedure validate[required,custom[mandatory-select]]','id'=>"procedure_0",'name'=> 'data[procedure][0]','style'=>"width:250px;")); 
		     	   echo $this->Form->hidden('', array( 'class'=>'','id' => 'procedureid_0','name'=>'data[procedure_id][0]' ));
		     ?>
		     &nbsp;</span>
			<?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),'alt'=> __('Add', true),'id'=>'addButton_surg'));?>
			</td></tr>
			</table>
		</td>
		<!--  <td>
        <?php 
         /* echo $this->Form->input('Preferencecard.procedure_id', array('empty'=>'Please Select','options' => $procedure, 'id' => 'procedure_id', 'label'=> false, 'div' => false, 'error' => false,'style'=> 'width:270px',
          														  'class' => 'validate[required,custom[mandatory-select]]',));*/
        ?>
        <?php //echo  $this->Form->input('Preferencecard.procedure_id',array('options'=>$procedure, 'multiple'=>true,'id' => 'other_consultant','style'=>'width:288px;')); ?>
        </td>-->
	</tr>
	
	<tr>
	<td class="form_lables" align="right">
	<?php echo __(Configure::read('doctorLabel'),true); ?><font color="red">*</font>
	</td>
	<td>
        <?php
	     		 
	        echo $this->Form->input('Preferencecard.doctor_id', array('empty'=>'All Doctors','options' => $doctorlist, 'id' => 'doctor_id', 'style'=>'width:32%;','label'=> false, 'div' => false, 'error' => false,
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
	     <span style="float:left">   <?php echo $this->Form->input('', array('type'=>'text' ,'class' => 'drugText validate[required,custom[mandatory-select]]','id'=>"instrument$i",'name'=> 'data[instrument][0]','value'=>$drugValue,'counter'=>$i,style=>"width:250px;")); ?>
	        &nbsp;</span>
		<?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),'alt'=> __('Add', true),'id'=>'addButton'));?>
		</td></tr>
		</table>
	</td>
	
	</tr><tr>
	<td class="form_lables" align="right">
	<?php echo __('Equipment Name',true); ?>
	</td>
	<td>
        <?php 
        echo $this->Form->textarea('Preferencecard.equipment_name', array('cols' => '35', 'rows' => '10', 'id' => 'equipment','style'=>'width:30%;', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
        <tr>
	<td class="form_lables" align="right" valign="top">
	<?php echo __('CSSD Items',true); ?>
	</td>
	<td>
	<table width="100%" id="spdid">
	<tr><td>
      <span style="float:left">  <?php 
		 
          echo $this->Form->input('', array('class' => 'spdtext textCls', 'id' => 'spd_0','name'=> 'data[spd][0]', 'label'=> false, 'div' => false,'style'=>'width:150px;', 'error' => false));
	  echo " Qty: ".$this->Form->input('', array('id' => 'spdqt_0','name'=> 'data[spdqt][0]', 'label'=> false,'class' => 'qtyCls', 'div' => false,'style'=>'width:48px;', 'error' => false)); //validate[required,custom[mandatory-select]]
        ?></span>
        <?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
						'alt'=> __('Add', true),'id'=>'addButton_spd'));?>
	 <!-- <input name="" type="button" id="addButton_spd" value="Add More"
				class="blueBtn" style="text-align:right"/><input name="" type="button" id="removeButton_spd"
				value="Remove" class="blueBtn" style="display: none" /> -->

	</td></tr>
	</table>
	</td>
	</tr>
	<tr>
	<td class="form_lables" align="right" valign="top">
	<?php if($this->request->pass[1]=="Radiology"){
			 echo __('Radiology Item Name',true); 
         	 } else if($this->request->pass[1]=="OR") {
			echo __('OR Item Name',true); 
			}else{
			echo __('Lab Item Name',true);
		} 
			?>
	</td>
	<td>
        <table width="100%" id="orid">
	<tr><td>
	<span style="float:left">   
        <?php 		 
          echo $this->Form->input('', array('class' => 'ortext textCls','name'=> 'data[or][0]', 'id' => 'or_0', 'label'=> false, 'div' => false,'style'=>'width:150px;', 'error' => false));
	  echo " Qty: ".$this->Form->input('', array('name'=> 'data[orqt][0]', 'id' => 'orqt_0', 'label'=> false,'class' => 'orqtCls', 'div' => false,'style'=>'width:48px;', 'error' => false));
        ?></span>
	<?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
						'alt'=> __('Add', true),'id'=>'addButton_or'));?><!--<input name="" type="button" id="addButton_or" value="Add More" class="blueBtn" style="text-align:right" /> 
	 <input name="" type="button" id="removeButton_or" value="Remove" class="blueBtn" style="display: none" /> -->

	</td></tr>
	</table>
	</tr>
        <tr>
	<td class="form_lables" align="right" valign="top">
	
	<?php echo __('Medication Name',true); ?>
	
		<td>
		<table width="100%" id="medid">
		<tr><td>
	     <span style="float:left">     <?php 
	        echo $this->Form->hidden('', array( 'class'=>'medtext ','id' => 'itemCode_0','name'=>'data[itemC][0]' , 'label'=> false, 'div' => false,'style'=>'width:150px;', 'error' => false));
	          echo $this->Form->input('', array( 'class'=>'medtext textCls','id' => 'med_0','name'=>'data[med][0]' , 'label'=> false, 'div' => false,'style'=>'width:150px;', 'error' => false));
	          echo $this->Form->hidden('', array( 'class'=>'','id' => 'drug-id_0','name'=>'data[drug_id][0]' ));
		 	 echo " Qty: ".$this->Form->input('', array('id' => 'medqt_0','name'=> 'data[medqt][0]', 'label'=> false,'class' => 'medqtCls', 'div' => false,'style'=>'width:48px;', 'error' => false)); //validate[required,custom[mandatory-select]]
	        ?></span>
		<?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
						'alt'=> __('Add', true),'id'=>'addButton_med'));?><!--<input name="" type="button" id="addButton_med" value="Add More"
					class="blueBtn" style="text-align:right"/> 
		<!--  <input name="" type="button" id="removeButton_med"
					value="Remove" class="blueBtn" style="display: none" />-->
	
		</td></tr>
		</table>
		</td>
	<?php // echo __('Medications',true); ?>
<!-- 	</td> -->
	
<!--         <td> -->
        <?php 
//         echo $this->Form->textarea('Preferencecard.medications', array('cols' => '35', 'rows' => '10', 'id' => 'medication', 'label'=> false, 'div' => false, 'error' => false));
//         ?>
<!--         </td> -->
       
	</td> 
	</tr>
        <tr>
	<td class="form_lables" align="right">
	<?php echo __('Dressing',true); ?>
	</td>
	
       <td>
        <?php 
        echo $this->Form->textarea('Preferencecard.dressing', array('cols' => '35', 'rows' => '10', 'style'=>'width:30%;','id' => 'dressing', 'label'=> false, 'div' => false, 'error' => false));
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
        echo $this->Form->textarea('Preferencecard.position', array('cols' => '35', 'rows' => '10', 'style'=>'width:30%;','id' => 'position', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
   
	</td>
	</tr>
    <tr>
	<td class="form_lables" align="right">
	<?php echo __('Notes',true); ?>	</td>
	
        <td>
        <?php 
        echo $this->Form->textarea('Preferencecard.notes', array('cols' => '35', 'rows' => '10', 'style'=>'width:30%;','id' => 'notes', 'label'=> false, 'div' => false, 'error' => false));
        ?>
        </td>
	</tr>
   
   
	<tr>
	<td colspan="2" align="center">
        <?php 
   			echo $this->Html->link(__('Cancel', true),array('action' => 'index'), array('escape' => false,'class'=>'grayBtn'));
   			//echo $this->Html->link(__('Cancel', true),'javascript:void(0);', array('escape' => false,'class'=>'grayBtn Back'))."&nbsp;&nbsp;";
   			//echo $this->Html->link(__('Submit', true),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'submit-form'));
        ?>
			 <input type="submit" value="Submit" class="blueBtn"> 
	</td>
	</tr>
	</table>
<?php echo $this->Form->end();?>

<script>
       $(document).ready(function(){
    	/*   jQuery(document).ready(function(){
   			 
   			jQuery("#labManagerfrm").validationEngine();

   			  
   		});*/
   		//$('.spdtext').on('keyup',function(){
   		/****BOF- When type CSSD item then Value put in quantity***/
   	   	$(document).on('keyup','.spdtext',function(){
   	   		
			var currentId=$(this).attr('id');
			splitedVar=currentId.split('_');
			textId=splitedVar[1];

			if($(this).val()!=''){
				$('#spdqt_'+textId).val('1');
			}else{
				$('#spdqt_'+textId).val('');
			}		
		});

   		/****EOF- When type CSSD item then Value put in quantity***/
   		
   		/****BOF- When type Lab item then Value put in quantity***/
   		
   		$(document).on('keyup','.ortext',function(){
   			var currentId=$(this).attr('id');
			splitedVar=currentId.split('_');
			textId=splitedVar[1];

			if($(this).val()!=''){
				$('#orqt_'+textId).val('1');
			}else{
				$('#orqt_'+textId).val('');
			}		
			
			});
   		/****EOF- When type Lab item then Value put in quantity***/
   		
   		/****BOF- When type MEdication item then Value put in quantity***/
   		
   			$(document).on('keyup','.medtext',function(){
   				var currentId=$(this).attr('id');
   				splitedVar=currentId.split('_');
   				textId=splitedVar[1];

   				if($(this).val()!=''){
   					$('#medqt_'+textId).val('1');
   				}else{
   					$('#medqt_'+textId).val('');
   				}		
			});
   		/****EOF- When type MEdication item then Value put in quantity***/

		//for instrument add & remove button
		var counter = 1;
		 
		   $("#addButton").click(function () {	 				 
	          var newNoteDiv = $(document.createElement('tr'))
                 .attr("id", 'NoteDiv' + counter);
	          var instrument_row = '<td><input class="drugText validate[required,custom[mandatory-select]] " type="text" id="instrument_'+ counter +'" name="data[instrument]['+ counter +']"  style="width:30%">';
	          var img_row = '<span class=currentRemoveIns id=currentRemoveIns_'+counter+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></td>';
			    		
			newNoteDiv.append(instrument_row+img_row);		 
			newNoteDiv.appendTo("#intrumentid");		
				 			 
			counter++;
			/*if(counter > 1) $('#removeButton').show();*/
    		 });

		/*	$("#removeButton").click(function () {
				counter--;			 
    			$("#NoteDiv" + counter).remove();
 				if(counter == 1) $('#removeButton').hide();
  			});
*/
			// BOF-remove current row Instrument
			$(document).on('click','.currentRemoveIns', function() {
					currentId=$(this).attr('id'); 
					splitedId=currentId.split('_');
					ID=splitedId['1'];
					$("#NoteDiv"+ID).remove();			
		 	});
		
			// EOF-remove current row Instrument
  
  //for SPD add & remove button
		var counter_spd = 1;
		 
		  $("#addButton_spd").click(function () {	 				 
	          var newNoteDiv_spd = $(document.createElement('tr'))
                 .attr("id", 'NoteDiv_spd' + counter_spd);
	          var spd_row = '<td><input class="spdtext textCls" type="text" id="spd_'+ counter_spd +'" name="data[spd]['+counter_spd+']"  style="width:20%">';
	          var qt_row = ' Qty: <input type="text" id="spdqt_'+ counter_spd +'" name="data[spdqt]['+counter_spd+']" class="qtyCls " style="width:48px">'; 
	          var img_row = '<span class=currentRemoveSpd id=currentRemoveSpd_'+counter_spd+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></span></td>';
		      		 			
	newNoteDiv_spd.append(spd_row + qt_row+img_row);		 
	newNoteDiv_spd.appendTo("#spdid");		
				 			 
	counter_spd++;
	//if(counter_spd > 2) $('#removeButton_spd').show('slow');
     });

	/*$("#removeButton_spd").click(function () {
		counter_spd--;			 
    	$("#NoteDiv_spd" + counter_spd).remove();
 		if(counter_spd == 1) $('#removeButton_spd').hide('slow');
  });*/
	$(document).on('click','.currentRemoveSpd', function() {
		currentId=$(this).attr('id'); 
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		$("#NoteDiv_spd"+ID).remove();			
	});

  //for OR add & remove button
		var counter_or = 1;
		 
		   $("#addButton_or").click(function () {	 				 
	          var newNoteDiv_or = $(document.createElement('tr'))
                 .attr("id", 'NoteDiv_or' + counter_or);
	          var or_row = '<td><input class="ortext textCls" type="text" id="or_'+ counter_or +'" name="data[or]['+counter_or+']"  style="width:20%">';
	          var orqt_row = ' Qty: <input type="text" id="orqt_'+ counter_or +'" name="data[orqt]['+counter_or+']" class="orqtCls"style="width:48px">';
	          var img_row = '<span class=currentRemoveOr id=currentRemoveOr_'+counter_or+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></span></td>';
	          		 			
	newNoteDiv_or.append(or_row + orqt_row+img_row);		 
	newNoteDiv_or.appendTo("#orid");		
				 			 
	counter_or++;
	//if(counter_or > 1) $('#removeButton_or').show('slow');
     });

	/*$("#removeButton_or").click(function () {
		counter_or--;			 
    	$("#NoteDiv_or" + counter_or).remove();
 		if(counter_or == 2) $('#removeButton_or').hide('slow');
  });*/
	$(document).on('click','.currentRemoveOr', function() {
		currentId=$(this).attr('id'); 
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		$("#NoteDiv_or"+ID).remove();		
	 });
// for medication add & remove button-
	var counter_med = 1;
	 
	  $("#addButton_med").click(function () {				 
        var newNoteDiv_med = $(document.createElement('tr'))
           .attr("id", 'NoteDiv_med' + counter_med);
        var med_row = '<td><input class="medtext textCls" type="text" id="med_'+ counter_med +'" name="data[med]['+counter_med+']"  style="width:20%"><input class="medtext" type="hidden" id="drug-id_'+ counter_med +'" name="data[drug_id]['+ counter_med +']"   >'; //name="data[spd][]"
        var qt_row = ' Qty: <input type="text" id="medqt_'+ counter_med +'" name="data[medqt]['+counter_med+']"  class="medqtCls" style="width:48px">';
        var img_row = '<span class=currentRemovemed id=currentRemove_'+counter_med+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></td>'
	newNoteDiv_med.append(med_row + qt_row + img_row);		 
	newNoteDiv_med.appendTo("#medid");		
				 			 
	counter_med++;
	//if(counter_med > 1) $('#removeButton_med').show('slow');
	});

// for surgery add and remove

var counter_surg = 1;
$("#addButton_surg").click(function () {				 
  var newNoteDiv_surge = $(document.createElement('tr')).attr("id", 'NoteDiv_surge' + counter_surg);
  var surg_row = '<td><input id="procedure_'+counter_surg+'" class="procedure validate[required,custom[mandatory-select]]" type="text" style="width:30%;" name="data[procedure]['+counter_surg+']"><input class="procedure" type="hidden" id="procedureid_'+ counter_surg +'" name="data[procedure_id]['+counter_surg+']">'; 
  var img_row = '<span class=currentRemovesurge id=currentRemove_'+counter_surg+'><?php echo $this->Html->image('/img/cross.png',array('alt'=>'Delete','title'=>'delete','style'=>'float:inherit; padding:0 0 0 6;'),array());?></td>'
	newNoteDiv_surge.append(surg_row + img_row);		 
	newNoteDiv_surge.appendTo("#prcedureId");		
			 			 
counter_surg++;
});

// remove current row 
$(document).on('click','.currentRemovemed', function() {
		currentId=$(this).attr('id'); 
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		$("#NoteDiv_med"+ID).remove();
		
	 });


//remove current row 
$(document).on('click','.currentRemovesurge', function() {
		currentId=$(this).attr('id'); 
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		$("#NoteDiv_surge"+ID).remove();
		
	 });
// end of medication code

  $('.drugText').on('focus',
	function() {
	var counter = $(this).attr("counter");
       if ($(this).val() == "") 
           {
		$("#Pack" + counter).val("");
			}
		$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "preferences", "action" => "getdeviceused","admin" => false,"plugin"=>false)); ?>",
	{
	width : 250,
	selectFirst : false,
});
});//EOF autocomplete

$('.spdtext')
	.on(
	'focus',
	function() {
	var counter = $(this).attr("counter");
       if ($(this).val() == "") {
		$("#Pack" + counter).val("");
	}$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "preferences", "action" => "getspditem","admin" => false,"plugin"=>false)); ?>",
	{
	width : 250,
	selectFirst : false,
});
});//EOF autocomplete



$('.ortext')
	.on(
	'focus',
	function() {
	var counter = $(this).attr("counter");
       if ($(this).val() == "") {
		$("#Pack" + counter).val("");
	}$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "preferences", "action" => "getoritem","admin" => false,"plugin"=>false)); ?>",
	{
	width : 250,
	selectFirst : false,
});
});//EOF autocomplete


//$('.medtext').on('focus',function() {
//$('.medtext').on('keyup.autocomplete', function(){


	$(document).on('focus','.procedure', function() {
			
		var currentId = $(this).attr("id");
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		currentID = $(this).attr('id').split("_")[1];
			 
		$(this).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","Surgery","id&name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {					
				$('#procedureid_'+ID).val(ui.item.id);
			 },
			 messages: {
			        noResults: '',
			        results: function() {},
			 }
		});
	
	});//EOF autocomplete procedure

	$(document).on('focus','.medtext', function() {
		
		var currentId = $(this).attr("id");
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		
		   if ($(this).val() == "") {
				$("#Pack" + counter).val("");
		   }

		   currentID = $(this).attr('id').split("_")[1];
			 
		$(this).autocomplete({
			 source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advanceMultipleAutocomplete","PharmacyItem","id&name&drug_id",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {					
				$('#drug-id_'+ID).val(ui.item.id);
			 },
			 messages: {
			        noResults: '',
			        results: function() {},
			 }
		});

	});
				
		  
});//eof ready
       
       $(".Back").click(function(){
    	   $.ajax({
				url: '<?php echo $this->Html->url(array("controller" => "Preferences", "action" => "user_preferencecard", "admin" => false,'plugin' => false, $patient_id)); ?>',
				beforeSend:function(data){
					$('#busy-indicator').show();
				},
				success: function(data){
					$('#busy-indicator').hide();
					$("#render-ajax").html(data);
			     }
			});
		 });
       
     /*  $("#submit-form").click(function()
    	{
    	   var is_validate = jQuery("#preferencefrm").validationEngine('validate');

    	   if(is_validate)
    	   {
    		   	var form_value = $("#preferencefrm").serialize();
				
    		   	$.ajax({
        		   	type: 'post',
    		   		url: '<?php echo $this->Html->url(array("controller" => "preferences", "action" => "save_preference_card",$patientid,"admin" => false,"plugin"=>false)); ?>',
    		   		data: form_value,
    		   		beforeSend:function(data){
    		   			$('#busy-indicator').show();
    		   		},
    		   		success:function(data){
    		   			$('#busy-indicator').hide();
    		   			//alert(data);
    		   		}
    		   	});
    	   }
    	}); */  
 </script>
 
