<div class="whole_screen" id="clincalHistoryLoad" >
   <div style="" class="navigation_section">
	<ul id="nav">
	<li><a href="#">Subjective</a> 
		<ul>
					<li><a href="#" class="Subjective" id='cc'>Chief Complaints</a></li>
					<li><a href="#" class="Subjective" id='hpi'>History of Presenting Illness</a></li>
					<li><a href="#" class="Subjective" id='ros'>Review of System</a></li>
         </ul>
	</li>
	
	<li><a href="#">Objective</a>
		<ul>
			<li><a href="#" class="Objective" id='Vital'>Vital</a></li>
			<li><a href="#" class="Objective" id='Physical'>Physical Examination</a></li>
        </ul>
    </li>
		
	<li><a href="#">Assessment</a>
	   <ul>
					<li><a href="#" class="Assessment" id='Diagnosis'>Diagnosis</a></li>
	   </ul>
	</li>
		
	<li><a href="#">Plan</a>
				<ul>
					<li><a href="#" class="Plan" id="plan">Plan</a></li>
				</ul>
	</li>
	<!--  <li><?php echo $this->Html->link('Progress Note',array('controller'=>'Notes','action'=>'soapNote',$patientId,$noteId,'appt'=>$appointmentId),array(''));?></li>
 -->
	</ul>	

	</div>
    <div class="right_sec">
	<div class="search_sec">
  <form class="form_sec">
    <input type="text" placeholder="Template Search" class="search_txt" id="templateSearch" />
    <input type="button" src="icons/views_icon.png" class="search_img" id="templateSearchImg"/>
  </form>
</div>
</div>


  </div>
  <div  class="right_sec" style="float: inherit;">
  	<table>
  		<tr>
  			<?php foreach($prevNotes as $key=>$data){ ?>
  				<td> <?php 
  				$explData=explode(' ',$data['Note']['create_time']);
  				$explDataele=explode('-',$explData[0]);
  				$eledata=$explDataele[2]."/".$explDataele[1]."/".$explDataele[0];
  				if($key!='0'){
  				echo $this->Html->link($eledata,
  						array("controller" => "Notes", "action" => "clinicalNote",$data['Note']['patient_id'],$data['Appointment']['id'],$data['Note']['id'],"?"=>array('readOnly'=>'readOnly')),
  						array('class'=>'blueBtn','target'=>'_blank'));
}?>
  				</td>
  			<?php }?>
  		</tr>
  	</table>  
  </div>
  <script>

//*********************************************EOD****************************************************************//
//subjective
$('.Subjective').click(function(){
	//getSubData();
	$('#templateSearch').val('');
	var toLoadSub=$(this).attr('id');
	if(toLoadSub=='cc'){
		
		var ajaxUrlSub= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "loadCc",$patientId,$noteId,$appointmentId,"admin" => false)); ?>";
	}else if(toLoadSub=='hpi'){
		
		var ajaxUrlSub= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "loadSubjective",$patientId,$noteId,$appointmentId,"?"=>array('typeShow'=>'hpi'),"admin" => false)); ?>";
	}else if(toLoadSub=='ros'){
		
		var ajaxUrlSub= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "loadSubjective",$patientId,$noteId,$appointmentId,"?"=>array('typeShow'=>'ros'),"admin" => false)); ?>";
	}
	$.ajax({
   	beforeSend : function() {
   		$('#busy-indicator').show('fast');
   	},
   	type: 'POST',
   	url: ajaxUrlSub,
   	//data: formData,
   	dataType: 'html',
   	success: function(data){
   		
   	if(data!=''){
   		$('#busy-indicator').hide('fast');
   	 $('#loadMenu').show();
  			 $('#loadMenu').html(data);
  			
   	}
   	
		
   },
	});
});
//Objective
$('.Objective').click(function(){
	//getSubData();
	$('#templateSearch').val('');
	var toLoadSub=$(this).attr('id');
	if(toLoadSub=='Vital'){
		
		var ajaxUrlSub= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "ajax_vital",$patientId,$noteId,$appointmentId,"admin" => false)); ?>";
	}else if(toLoadSub=='Physical'){
		
		var ajaxUrlSub= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "loadObjective",$patientId,$noteId,$appointmentId,"admin" => false)); ?>";
	}
	$.ajax({
   	beforeSend : function() {
   		$('#busy-indicator').show('fast');
   	},
   	type: 'POST',
   	url: ajaxUrlSub,
   	//data: formData,
   	dataType: 'html',
   	success: function(data){
   	if(data!=''){
   		$('#loadMenu').show();
   		$('#busy-indicator').hide('fast');
  			 $('#loadMenu').html(data);
   	}
   
		
   },
	});
});
//Assessment
$('.Assessment').click(function(){
	//getSubData();
	$('#templateSearch').val('');
	var toLoadSub=$(this).attr('id');
	if(toLoadSub=='Diagnosis'){
		
		var ajaxUrlSub= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "loadAssis",$patientId,$noteId,$appointmentId,"admin" => false)); ?>";
	}
	$.ajax({
   	beforeSend : function() {
   		$('#busy-indicator').show('fast');
   	},
   	type: 'POST',
   	url: ajaxUrlSub,
   	//data: formData,
   	dataType: 'html',
   	success: function(data){
   	if(data!=''){
   		$('#loadMenu').show();
   		$('#busy-indicator').hide('fast');
  			 $('#loadMenu').html(data);
   	}
   
		
   },
	});
});
//Plan
$('.Plan').click(function(){
	//getSubData();
	$('#templateSearch').val('');
	var toLoadSub=$(this).attr('id');
	if(toLoadSub=='plan'){
		
		var ajaxUrlSub= "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "loadPlan",$patientId,$noteId,$appointmentId,"admin" => false)); ?>";
	}
	$.ajax({
   	beforeSend : function() {
   		$('#busy-indicator').show('fast');
   	},
   	type: 'POST',
   	url: ajaxUrlSub,
   	//data: formData,
   	dataType: 'html',
   	success: function(data){
   	if(data!=''){
   		$('#loadMenu').show();
   		$('#busy-indicator').hide('fast');
  			 $('#loadMenu').html(data);
   	}
   
		
   },
	});
});
//**********************************************************Tempalte***********************************************
$("#templateSearch").keypress(function(e) {
   				 if(e.which == 13) {
    						searchTemplate($("#templateSearch").val(),'true');
    					}
				});
			$("#templateSearchImg").click(function() {	 
				searchTemplate($("#templateSearch").val(),'true');
				});
			
				function searchTemplate(searchTitle,searchFrom){
				searchFromTemplate = (searchFrom === undefined) ? searchFromTemplate : searchFrom;
				var serachText=$('#templateSearch').val();
				if(serachText==''){
					alert('Please enter data');
					return false;
				}
				searchTitle = (searchTitle === undefined) ? serachText : searchTitle;
				
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "getSoap","admin" => false)); ?>";
				$.ajax({
				 			  type: "POST",
				 			  url: ajaxUrl+"/"+searchTitle+"/"+ searchFromTemplate,
				 			  beforeSend:function(){
				 			  	// this is where we append a loading image
				 			  	$('#busy-indicator').show('fast');
				 			  },
				 			  success: function(data){
					 			  if(searchFromTemplate == 'true'){
					 				 searchFromTemplate = 'false';
				 				 	var displayData=data.split('|~|');
									$('#subjectiveDisplay').html(displayData[0]);
									$('#objectiveDisplay').html(displayData[1]);
									$('#assessmentDisplay').html(displayData[2]);
									$('#planDisplay').html(displayData[3]);
									$('#rosDisplay').html(displayData[4]);
									$('#busy-indicator').hide('slow');
					 			  }else{
					 				 $('#search').val('');
					 				 var data=jQuery.parseJSON(data);
					 				$('#templateTitleContainer').html('');
					 				 $.each(data,function (key, value){
						 				$('#templateTitleContainer').append($('<td>').attr({onclick:'javascript:searchTemplate("'+value+'","true")'})
						 						.css({ 'font-size' : '13px', 'color' : '#31859c', 'text-decoration' : 'underline', 'cursor' : 'pointer' }).text(value));
								 	});
					 				 
					 				$('#busy-indicator').hide('slow');
					 			  }
							  }
						});
			}

				var searchFromTemplate= 'false';
				$("#templateSearch").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","NoteTemplate","template_name",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true,
					onItemSelect : function (){
						searchFromTemplate = 'true';
					}
				});
  </script>