<?php  	
/* echo $this->Html->css(array('internal_style','jquery.autocomplete'));
 echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js',
 		'jquery.autocomplete','validationEngine.jquery','jquery.validationEngine',
 		'/js/languages/jquery.validationEngine-en','jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js',
 		'jquery.fancybox-1.3.4'));
echo $this->Html->css(array('home-slider.css','ibox.css','jquery.fancybox-1.3.4.css')); */
?>
<?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));      
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js','slides.min.jquery.js','jquery.isotope.min.js','jquery.custom.js','ibox.js','jquery.fancybox-1.3.4','jquery.selection.js','jquery.autocomplete','ui.datetimepicker.3.js'));?>

<style>
.verticalButton {
	padding-top: 25px;
}
</style>
<div class="inner_title">
	<h3>
		<?php 
		echo __('Patient referral-Prepare letter', true); ?>
	</h3>

</div>
<div style="float: left; width: 20%; display: none" id='template'>
	<style>
.padding_bottom {
	padding-bottom: 15px;
}
</style>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="374" align="left" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>

						<td width="100%" align="left" valign="top" class="tempSearch"><?php //BOF dialog form 
if(!empty($this->data['NoteTemplate']['id']) || $emptyTemplateText){
					 			$template_form  = "block";
					 			$search_template ='none';
					 		}else{
					 			$template_form  = "none";
					 			$search_template = 'block';
					 		}
					 		?>
							<div id="search_template" style="margin:0px 3px;display:<?php echo $search_template ;?>">
								<label style="padding-top: 19px">Templates:</label>
								<p>
									<br>
									<?php								
								 echo 	$this->Form->input('',array('name'=>$template_type,'id'=>'search','autocomplete'=>'off', 'label'=>false,'div'=>false,'value'=>'Search',
										"style"=>"margin-right:3px;","onfocus"=>"javascript:if(this.value=='Search'){this.value='';  }",
										"onblur"=>"javascript:if(this.value==''){this.value='Search';} "));

								 echo $this->Js->link($this->Html->image('icons/refresh-icon.png'), array('alt'=>'Reset search','title'=>'Reset search','action' => 'add',$template_type),
								 array('escape' => false,'update'=>"#$updateID",
								 'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								  'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));


								 echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'add-template','style'=>'padding-left:5px;cursor:pointer'));
								 ?>
								</p>
							</div> <?php echo $this->Form->create('NoteTemplate',array('action'=>'add_doctor_template','id'=>'doctortemplatefrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>


							<div id="add-template-form" style="display:<?php echo $template_form ;?>;">
								<?php

								if(!empty($errors)) {
							?>
								<table border="0" cellpadding="0" cellspacing="0" width=""
									align="center" id="error">
									<tr>
										<td colspan="2" align="left" class="error"
											style="color: #8C0000"><?php 
											foreach($errors as $errorsval){
									         		echo $errorsval[0];
									         		echo "<br />";
									     		}
									     		?>
										</td>
									</tr>
								</table>
								<?php } ?>
								<table border="0" class="table_format" cellpadding="0"
									cellspacing="0" width="100%">
									<tr>
										<td style="text-align: center;"><?php echo __('Template');?>:</td>
										<td><?php 
										echo $this->Form->hidden('id');
										echo $this->Form->input('template_name',array('type'=>'text'));
										echo $this->Form->hidden('template_type',array('value'=>'implants'));
									 ?>
										</td>
									</tr>

									<tr>
										<td colspan="2" align="right"><?php echo $this->Html->link(__('Cancel'),"#",array('id'=>'close-template-form','class'=>'grayBtn')); ?>
											<?php echo $this->Js->submit('Submit', array('class' => 'blueBtn','div'=>false,'update'=>"#template",'method'=>'post','url'=>array('controller'=>'notes','action'=>'add',"implants")	)); ?>
											<?php //echo $this->Js->link(__('Submit'),array('controller'=>'doctor_templates','action'=>'doctor_template'),array('class'=>'blueBtn','div'=>false,'update'=>'#templateArea','method'=>'post')); ?>

										</td>
									</tr>
								</table>
							</div> <?php echo $this->Form->end(); ?>
						</td>
					</tr>
					<tr>
						<td width="100%" align="left" valign="top" height="10"></td>
					</tr>
					<tr>
						<td width="100%" align="left" valign="top" class="tempDataBorder">
							<p class="tempHead">Frequent templates:</p>
							<div class="tempData"
								id="template-list-<?php echo $template_type ;?>">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">

									<?php 
									$cnt =0;
									if(count($data) > 0) {
							       foreach($data as $key=>$doctortemp){
							       $cnt++;
							       ?>
									<tr>

										<td align="right" styel="padding-bottom:15px"><?php
										if($doctortemp['NoteTemplate']['user_id']=='0'){
									   			echo  $this->Html->image('icons/favourite-icon.png', array('title'=> __('Admin Template', true), 'alt'=> __('Doctor Template Edit', true)));
									   		}else{
									   			echo "&nbsp;";
									   		}
									   		?>
										</td>
										<td class="row_format leftPad10" style="padding-bottom: 15px">
											<?php 

											echo $this->Html->link($doctortemp['NoteTemplate']['template_name'],"javascript:void(0)",array('label'=>false,'id'=>'temp_'.$key,'onclick'=>'displayText("'.$key.'")'));
											?>
										</td>
										<td style="padding-bottom: 15px"><?php
										if($doctortemp['NoteTemplate']['user_id']=='0'){
										   			echo "&nbsp;";
										   }else{
								   					echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Doctor Template Edit', true), 'alt'=> __('Doctor Template Edit', true))),
								   								 array('controller'=>'NoteTemplate','action' => 'add','implants', $doctortemp['NoteTemplate']['id']), array('escape' => false,'update'=>"#template",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								    							'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));

								   			}
								   				
								   			?></td>
									</tr>
									<?php }  ?>
									<?php		  
					      } else {
					  ?>
									<tr>
										<TD  class="classTd" colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
									</tr>
									<?php
					      }
					      ?>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<?php
	echo $this->Js->writeBuffer(); 	//please do not remove
	?>


</div>
<div style="float: left; width: 5%; margin-left: -20px"
	class='verticalButton'>
	<?php echo $this->Form->input('Template',array('type'=>'button','id'=>'showTemplate','label'=>false,'style'=>'height:40px;width:85px;transform:rotate(90deg)'))?>
</div>
<div class="section" id="subjective"><?php echo $this->Form->create('Faxreferral',array('action'=>'','type'=>'post', 'id'=> 'referral' ));?>
	<table width="80%" cellpadding="0" cellspacing="0" border="0"
		class="formFull formFullBorder">
		<tr>

			<td width="70%" align="left" valign="top">

				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						
						<td width="20">&nbsp;<?php echo ('')?>
						</td>
						<?php //debug($getDoctorName);
							if(!empty($getDoctorName)){
								foreach($getDoctorName as $name){
                                  $fullName[]=$name['User']['first_name']." ".$name['User']['last_name'];
								}
								$fullNameImplode=implode(',',$fullName);
								$name=$fullNameImplode;
									
							}
							else{
										$name=$recipients['Recipient']['name'];
							}?>
						<td valign="top" colspan="4"><?php echo $this->Form->input('subject', array('type'=>'text','label'=>false,'id' => 'subjective_desc'  ,'style'=>'width:90%','value'=>'Hello'.' '.$name)); ?><br />

						</td>
					</tr>


					<tr>
						<td width="20">&nbsp;</td>
						<td valign="top" colspan="4"><?php echo $this->Form->textarea('Introduction', array('id' => 'subjective_desc'  ,'label'=>true,'rows'=>'4','style'=>'width:90%','value'=>'I am referring a patient of mine to you for an appointment.I have included the information pertaining to this patient below to better assist in continuity of care.')); ?><br />

						</td>


					</tr>
				</table>
				<div id="printLetter">
				<table width="90%" class="row_format" border="0" cellspacing="0"
					cellpadding="0" style="margin-bottom: 10px; margin-left: 17px;">
					<tr class="row_title classTr">
						<td><strong><?php echo ('Vital')?> </strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr class='row_gray' style="padding-top: 5px;">
						<td class='myTd' width="40" style="padding: 10px 5px;"><?php echo ('Height:');
						echo $vitals['BmiResult']['height_result']; ?></td>
						<td class='myTd' width="40" style="padding: 10px 5px;"><?php echo ('Weight:');
						echo $vitals['BmiResult']['weight_result']; ?></td>
						<td class='myTd' width="40" style="padding: 10px 5px;"><?php echo ('B.M.I.:');
						echo $vitals['BmiResult']['bmi']; ?></td>
						<td class='myTd' width="40" style="padding: 10px 5px;"><?php echo ('Blood Pressure:');
						echo $vitals['BmiBpResult']['systolic'].'/'.$vitals['BmiBpResult']['diastolic']; ?></td>
						<td class='myTd' width="40" style="padding: 10px 5px;"><?php echo ('Temp:');
						echo $vitals['BmiResult']['temperature'].' '.$vitals['BmiResult']['myoption']; ?></td>


					</tr>
				</table>

				<table width="90%" class="row_format" border="0" cellspacing="0"
					cellpadding="0" style="margin-bottom: 10px; margin-left: 17px;">
					<tr class="row_title classTr" style="padding-top: 5px;">
						<td width="50"><strong><?php echo ('Diagnoses')?> </strong></td>
						<td width="25"><strong><?php echo ('Start')?> </strong></td>
						<td width="25"><strong><?php echo ('Stop')?> </strong></td>
					</tr>
					</tr>
					<?php $toggle =0;
					if(count($diagnosis) > 0) {
				      		foreach($diagnosis as $patients){
				       $cnt++;

							    if($toggle == 0) {
								      	echo "<tr class='row_gray' style='padding-top:5px;'>";
								      	$toggle = 1;
							       }else{
								       echo "<tr style='padding-top:5px;'>";
								       $toggle = 0;
							      }
							      ?>
					<td width="50" class='myTd' style="padding: 10px 5px;"><?php echo $patients['NoteDiagnosis']['diagnoses_name']?>
					</td>


					<td width="25" class='myTd' style="padding: 10px 5px;"><?php echo $this->DateFormat->formatDate2Local($patients['NoteDiagnosis']['start_dt'],Configure::read('date_format'))?>
						<?php ?></td>

					<td width="25" class='myTd' style="padding: 10px 5px;"><?php echo $this->DateFormat->formatDate2Local($patients['NoteDiagnosis']['end_dt'],Configure::read('date_format'))?>
						<?php ?></td>
					<?php } ?>
					<?php } else {?>
					<tr>
						<TD class="classTd" colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
					</tr>
					<?php
							      }
							      ?>
					</tr>
				</table>

				<table width="90%" class="row_format " border="0" cellspacing="0"
					cellpadding="0" style="margin-bottom: 10px; margin-left: 17px;">
					<tr class="row_title classTr" style='padding-top: 5px;'>
						<td width="50"><strong><?php echo ('Medication')?> </strong></td>
						<td width="25 !important"><strong><?php echo ('Start')?> </strong>
						</td>
						<td width="25"><strong><?php //echo ('Stop')?> </strong></td>
					</tr>
					<?php $toggle =0;
					if(count($medication) > 0) {
				      		foreach($medication as $patients){
				       $cnt++;

							    if($toggle == 0) {
								      	echo "<tr class='row_gray' style='padding-top:5px;'>";
								      	$toggle = 1;
							       }else{
								       echo "<tr style='padding-top:5px;'>";
								       $toggle = 0;
							      }
							      ?>

					<td width="50" class='myTd' style="padding: 10px 5px;"><?php echo $patients['NewCropPrescription']['description']?>
						<?php  ?></td>

					<td width="25" class='myTd' style="padding: 10px 5px;" style="padding:10px"><?php echo $this->DateFormat->formatDate2Local($patients['NewCropPrescription']['date_of_prescription'],Configure::read('date_format'))?>
						<?php  ?></td>

					<td width="25" class='myTd' ><?php echo $this->DateFormat->formatDate2Local($patients['NewCropPrescription']['end_date'],Configure::read('date_format'))
					?> <?php  ?></td>
					<?php } ?>
					<?php } else {?>
					<tr>
						<TD class="classTd" colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
					</tr>
					<?php
					}
			  ?>
					</tr>
				</table>
				</div>
				<table width="90%" style="margin-bottom: 10px; margin-left: 17px;"
					class="row_format" border="0" cellspacing="0" cellpadding="0">
					<tr class="row_title classTr" style='padding-top: 5px;'>
						<td width="50"><strong><?php echo ('Conclusion')?> </strong></td>
						<td></td>
						<td width="25"><strong><?php echo ('')?> </strong></td>
						<td width="25"><strong><?php echo ('')?> </strong></td>
					</tr>
					<tr class="">
						<td width="100%" class='myTd'><?php echo $this->Form->input('subject', array('class'=>'myTd','type'=>'text','label'=>false,'id' => 'conclusion'  ,'style'=>'width:98%;','value'=>"For follow  up, I would appreciate it if you could",)); ?>
						</td>

					</tr>
				</table>
				<div id='endText' class='myTd' >
				<table width="100%" class="row_format" border="0" cellspacing="0"
					cellpadding="0">
					<tr>
						<td width="100%"><?php echo $this->Form->input('subject', array('type'=>'text','readonly'=>'readonly','label'=>false,'id' => 'subjective_desc1','style'=>'width:20%; float:right','value'=>"Sincerely",)); ?>
						</td>
					</tr>
					<tr class="">
						<td width="100%"><?php echo $this->Form->input('subject', array('type'=>'text','readonly'=>'readonly','label'=>false,'id' => 'subjective_desc2'  ,'style'=>'width:20%; float:right','value'=>$provider['User']['first_name']." ".$provider['User']['last_name'])); ?>
						</td>

					</tr>

				</table>
				</div>
				<table width="100%" class="row_format" border="0" cellspacing="0"
					cellpadding="0">
					<tr>
					</tr>
					<tr class="">

					</tr>

				</table>

				<div class="inner_title">

					<span> <?php if(empty($getDoctorName)&& empty($emailsId)){
						echo $this->Html->link(__('Generate Fax Report'), array('controller'=>'recipients','action' => 'referral_pdf',$patient_id,$id,$userid), array('escape' => false,'class'=>"blueBtn"));
						echo $this->Html->link(__('Send Fax'), array('controller'=>'recipients','action' => 'send_fax',$id), array('escape' => false,'class'=>"blueBtn"));
					}else{
							echo $this->Html->link(__('Attach to mail'),'javascript:void(0)', array('escape' => false,'class'=>"blueBtn",'id'=>'dataFile'));
							//echo $this->Html->link(__('Preview'),"javascript:void(0)", array('escape' => false,'class'=>"blueBtn",'id'=>'preview'));
							echo $this->Html->link(__('Preview'),'javascript:void(0)',array('onclick'=>'printPreview("'.$patient_id.'")','class'=>'blueBtn','div'=>false,'label'=>false));

					}
					?>
					</span>
				</div>
			</td>
		</tr>
	</table>
	<?php echo $this->Form->end(); ?>
</div>

<!-- For generating the report -->
<div style="display: none;">  
<?php echo $this->Form->create('',array('id'=>'printLetterfrm' ,'inputDefaults'=>array('div'=>false)));?>
<table width="100%" class=""  cellspacing="0" cellpadding="4" border='0'>
	<tr class="row_title" style='padding-top: 5px;'>
	<td id='hello'></td>
	<?php echo $this->Form->hidden('head',array('id'=>'head_text'));?>
	</tr>
	<tr class="row_title" style='padding-top: 5px;'>
	<td id='body'></td>
	<?php echo $this->Form->hidden('body',array('id'=>'body_text'));?>
	</tr>
	<tr class="row_title" style='padding-top: 5px;'>
	<td id='conclusion'></td>
		<?php echo $this->Form->hidden('tail',array('id'=>'conclusion_text'));?>
		<?php echo $this->Form->hidden('patient_id',array('value'=>$patient_id));?>
	</tr>
	<tr>
	<td id='Sincerely' align='right'></td>
		<?php echo $this->Form->hidden('Sincerely',array('id'=>'Sincerely_txt'));?>
	</tr>
	</table>
	<?php echo $this->Form->end();?>
</div>	
<script>
	var toggle = 0;
	$('#showTemplate').click(function() {
				if(toggle == '1'){
					$('#template').fadeOut();
					toggle='0';
				}else{
					 toggle='1';
					$('#template').fadeIn();
				}
	});
	</script>
<script>
var formData='';
jQuery(document).ready(function(){
	var body = $("#printLetter").html();
	var subjective_desc = $("#subjective_desc").val();
	var conclusion = $("#conclusion").val();
	var Sincerely=$("#endText").html();
	$("#hello").html(subjective_desc );
	$("#body").html(body );
	$("#conclusion").html(conclusion);
	$("#Sincerely").html(Sincerely);
	$("#head_text").val(subjective_desc);
	$("#body_text").val(body);
	$("#Sincerely_txt").val(Sincerely);
	$("#conclusion_text").val(conclusion);	
 
	
});
	

			jQuery(document).ready(function(){
				$('#selection').click(function(){		 	 
			 	    var  icd_text='' ;
					var icd_ids = $( '#diagnosis', window.opener.document ).val();		 				 	 
			 		$("input:checked").each(function(index) {
			 			 if($(this).attr('name') != 'undefined'){    	
					        $( '#diagnosis', window.opener.document ).val($( '#diagnosis', window.opener.document ).val()+"\r\n"+$(this).val());
					    }
					});		 	
			 		window.close();
		 	     });
		 		$('#add-template').click(function(){
		 			$('#search_template').fadeOut('slow');
		 			$('#add-template-form').delay(800).fadeIn('slow');		 			
		 			return false ;
		 		});
			 
				$('#close-template-form').click(function(){
					$('#error').html('');
		 			$('#add-template-form').fadeOut('slow');
		 			$('#search_template').delay(800).fadeIn('slow');
		 			return false ;
		 		});

	 			//BOF template search
	 			$('#search').keyup(function(){
		 			//collect name of search ele
		 			var searchName = $(this).attr('name');
		 			var replacedID = "templateArea-"+searchName ;	
		 			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'notes', "action" => "template_search",$template_type,"admin" => false)); ?>";
		 			//check if the request is for current text
		 			var template_type ='<?php echo $template_type; ?>' ; 
		 			if(template_type !='' && template_type==searchName){
	 					$.ajax({  
				 			  type: "POST",						 		  	  	    		
							  url: ajaxUrl,
							  data: "searchStr="+$(this).val(),
							  context: document.body,
							  beforeSend:function(){
						    		// this is where we append a loading image
						    		$('#busy-indicator').show('fast');
							  },					  		  
							  success: function(data){	
								 
								    $('#busy-indicator').hide('fast');				 					 				 								  		
							   		$("#template-list-"+searchName).html(data);								   		
							   		$("#template-list-"+searchName).fadeIn();
							   		
							  }
						});
		 			}else{
			 			return false ;
		 			}
	 			});
	 			//EOF tempalte search
						
			});	
			function displayText(id){
				var  linkData=$("#temp_"+id).html();
				var allText= $("#conclusion").val()+" "+linkData;
				$("#conclusion").val(allText);
			}
			function printPreview(patientId){
				$
				.fancybox({
					'width' : '50%',
					'height' : '80%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "Recipients", "action" => "printLetter")); ?>" + "/" +'<?php echo $patient_id?>',
					 	
				});
			}


			$("#dataFile").click(function(){
				var formData =$("#printLetterfrm").closest("form").serialize();
				$.ajax({  
		 			  type: "POST",						 		  	  	    		
					  url:"<?php echo $this->Html->url(array("controller" =>"Messages", "action" =>"order_ref",$patient_id,"admin" => false)); ?>",
					  data: formData,
					  context: document.body,
					  beforeSend:function(){
				    		// this is where we append a loading image
				    		$('#busy-indicator').show('fast');
					  },					  		  
					  success: function(data){
						  parent.loadFckEditor(data);
						  //parent.oFCKeditor.html('');//.SetHTML(data);	
						  //$('#message', parent.document).html(data);
						  parent.$.fancybox.close();					   		
					  }
				});	
			});
				
			
</script>
