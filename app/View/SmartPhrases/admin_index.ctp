<?php 
  	echo $this->Html->script('jquery.autocomplete');
  	echo $this->Html->css('jquery.autocomplete.css');
?>
<!-- <div id="doctemp_content"> -->


	<div class="inner_title">
		<h3>
			<?php echo __('Smart Phrases', true); ?>
		</h3>
		<span> <?php if(!empty($patientIdNew)){
		echo $this->Html->link(__('Back', true),array('controller' => 'Notes', 'action' => 'clinicalNote',$patientIdNew,$appointmentIdNew,$noteIdNew,'admin'=>false), array('escape' => false,'class'=>'blueBtn'));
		}else if(!empty($this->request->query['nursePriscription'])){
			echo $this->Html->link(__('Back', true),array('controller' => 'Notes', 'action' => 'addNurseMedication',$this->request->query['nursePriscription'],'?' => array('from'=>'Nurse'),'admin'=>false), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px'));
		}
		else{
		echo $this->Html->link(__('Back', true),array('controller' => 'Users', 'action' => 'menu', '?' => array('type'=>'master'),'admin'=>true), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px'));
		}
		?>
		</span>
	</div>
	<div id="docTemplate">
	<?php 	echo $this->Form->create('SmartPhrase',array('action'=>'admin_index','id'=>'SmartPhrasefrm', 'inputDefaults' => array('label' => false,'div' => false)));
	echo $this->Form->hidden('SmartPhrase.id');
	echo $this->Form->hidden('SmartPhrase.patientId',array('value'=>$patientIdNew));
	echo $this->Form->hidden('SmartPhrase.appointmentId',array('value'=>$appointmentIdNew));
	echo $this->Form->hidden('SmartPhrase.noteId',array('value'=>$noteIdNew));
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td valign="top" width="20%">
				<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		id="smartTable" width="100%">
		<tr>
			<td><label><?php echo __('Phrase Name');?>:<font color="red">*</font>
			</label></td>
			<td><?php	
			$readOnly = ($this->request->data['SmartPhrase']['id']) ? true : false;			
				echo $this->Form->input('SmartPhrase.phrase', array('style'=>'width:157px;','class' => 'validate[required,custom[mandatory-enter],ajax[ajaxSmartPhraseCall],custom[spaceNotAllow]] ','id' => 'template_type','readonly'=>$readOnly)); ?>
			</td>
			<?php /* lab List */?>
			
			
			<?php /* rad List */?>
			
			
			<?php /* Med List */?>
			
			
		</tr>
		<tr>
			<td><label><?php echo __('Synonyms');?>:<font color="red">*</font>
			</label></td>
			<td><?php echo $this->Form->input('SmartPhrase.synonyms', array('style'=>'width:250px;','type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'customdescription')); ?>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __('Link Diagnosis');?>:
			</label></td>
			<td><?php 
			echo $this->Form->input('diagnoses_name',array('class'=>'textBoxExpnd AutoComplete','escape'=>false,'multiple'=>false,
					'label'=>false,'div'=>false,'id'=>'diagnosis_name','autocomplete'=>false,'placeHolder'=>'Prov Diagnosis Search','style'=>'width:150px;'));
			echo $this->Form->hidden('testCode',array('id'=>'code_problem'));
			echo $this->Form->hidden('',array('id'=>'diaCode','name'=>'diaCode'));
			echo $this->Form->hidden('',array('id'=>'diaCodeDelete','name'=>'diaCodeDelete'));
			?> 
			<span><?php echo $this->Html->link('Diagnosis Master',array("controller" => "SmartPhrases", "action" => "diagnosis_list", "admin" => false,'plugin' => false, 'superadmin'=> false), array('target'=>"_blank",'escape' => false)); ?>
			</span>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __('Order Type');?>:<font color="red">*</font>
			</label></td>
			<td><?php 
			$getExpdrp=strstr($this->request->data['SmartPhrase']['phrase_text'],'CMED');			
			
			/*if(empty($getExpdrp)){
				$getExpdrp=strstr($this->request->data['SmartPhrase']['phrase_text'],'PHYSIO');			
					$getExpdrp=substr($getExpdrp,0,6);					
					if(trim($getExpdrp)=='PHYSIO'){
						$getSelected=trim($getExpdrp);
					}
			}else{*/
				$getExpdrp=substr($getExpdrp,0,4);
				if(trim($getExpdrp)=='CMED'){
						$getSelected=trim($getExpdrp);
				}
			//}
			echo $this->Form->input('SmartPhrase.drp', array('empty'=>__('Please Select'),'options'=>array('LAB'=>'LAB','RAD'=>'RAD','CMED'=>'Medication','PHYSIO'=>'PhysioTherapy'),'style'=>'width:172px;','id' => 'tempReplace','label'=> false,'selected'=>$getSelected,'class' => 'validate[required,custom[mandatory-select]]')); ?>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __("Specialty");?>:</label></td>
			<td><?php echo $this->Form->input('SmartPhrase.department_id', array('empty'=>__('Please Select'),'options'=>$departments,'style'=>'width:172px;','id' => 'department_id','label'=> false)); ?>
			</td>
		</tr>
		<tr>
			<td><label><?php echo __('Selected Order Type');?>:<font color="red">*</font>
			</label></td>
			<td><?php echo $this->Form->input('SmartPhrase.phrase_text', array('type'=>'textarea','class' => 'validate[required,custom[mandatory-enter]]','id' => 'phrase_text')); ?>
			</td>
<?php  $phText=str_replace("\n",",",$phrase_text_array);
$phTextexp=explode(',',$phText);

foreach($phTextexp as $data){
	if(!empty($data) && $data !=" "){
	$phTextStr.=trim($data).",";
	}
}
		?>
		</tr>
		<tr>
			<td><label><?php echo __("Chief Complaints");?>:</label></td>
			<td><?php 
			echo $this->Form->textarea('chief_complaints', array('style'=>'width:250px;','id' => 'chief_complaints','label'=> false,'name'=>'chief_complaints','value'=>$getArrayLabRad['ChiefComplaint']['0']['name'])); ?>
			</td>
		</tr>
		<?php if($this->Session->read('website.instance')=='hope'){?>
			<tr>
				<td><label><?php echo __("Nursing Phrase");?>:</label></td>
				<td><?php 
				echo $this->Form->checkbox('SmartPhrase.is_nursing', array('id' => 'nurseFlag','label'=> false)); ?>
				</td>
			</tr>
		<?php }?>
	<!--	<tr>
			<td><label><?php echo __('Multiple Phrase');?>:</label></td>
			<td style="width: 50px;"><?php echo $this->Form->checkbox('SmartPhrase.has_multiple', array('id' => 'has_multiple','label'=> false,'div' => false,'error' => false)); ?>
				<span id="add_more" style="display: none"><?php echo $this->Html->link(__('Add More'),'#', array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));?>
			</span> <span id="removeButton" style="display: none"><?php echo $this->Html->link(__('Remove'),'#', array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));?>
			</span>
			</td>
			<td><label><?php echo __('Custom Phrase');?>:</label></td>
			<td><?php echo $this->Form->checkbox('SmartPhrase.has_custom', array('hiddenField'=>false,'id' => 'has_custom','label'=> false,'div' => false,'error' => false)); ?>
			</td>-->
			<tr>
			<td><input type="button" value="Submit" class="blueBtn" id="Submit"/><?php  
		//	echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn','id'=>'Submit'));?>
			</td>
		</tr>
		<!-- <tr>
			<td>&nbsp;</td>

		</tr>
	 	<tr class="newTextField" style="display: none">
			<td><?php echo __('List Name');?></td>
			<td><?php echo __('List Content');?></td>
		</tr>
		<tr class="newTextField" style="display: none">

			<td><?php echo $this->Form->input('0.SmartPhraseMultiple.list_name', array('style'=>'width:137px;','id' => 'list_name_0')); ?>
			</td>
			<td><?php echo $this->Form->input('0.SmartPhraseMultiple.list_content', array('style'=>'width:137px;','class' => 'validate[required,custom[mandatory-select]] customValidation','id' => 'list_content_0')); ?>
			</td>
		</tr>  -->

	</table>
			</td>
<?php echo $this->Form->end();?>
			<td valign="top" width="80%">
					<table width="100%" border="0" cellspacing="1" cellpadding="0">
						<tr>
							<td width="300px" valign="top" style="padding-top:20px;">
							<!-- Lab -->
							<span id="lab_ajax" style="display:none" valign="top">	
								<?php 
								echo $this->Form->input('test_name',array('class'=>'textBoxExpnd AutoComplete','escape'=>false,'multiple'=>false,
										'label'=>false,'div'=>false,'id'=>'test_name','autocomplete'=>false,'placeHolder'=>'Lab Search','style'=>'width:216px;'));
								echo $this->Form->hidden('testCode',array('id'=>'testCode'));
								echo $this->Form->hidden('',array('id'=>'labCode','name'=>'labCode'));
								?>
							</span>
								<!-- Rad -->
							<span id="rad_ajax" style="display:none">
							<?php echo $this->Form->input('test_name',array('class'=>'textBoxExpnd AutoComplete','escape'=>false,'multiple'=>false,
											'label'=>false,'div'=>false,'id'=>'SelectRad1','autocomplete'=>false,'placeHolder'=>'Lab Search','style'=>'width:216px;'));
									echo $this->Form->hidden('testCode',array('id'=>'test_CodeRad'));
									echo $this->Form->hidden('',array('id'=>'radCode','name'=>'radCode'));
							?>
							</span>
							<span id="physio_ajax" style="display:none">
							<?php echo $this->Form->input('test_name',array('class'=>'textBoxExpnd AutoComplete','escape'=>false,'multiple'=>false,
											'label'=>false,'div'=>false,'id'=>'SelectPhysio','autocomplete'=>false,'placeHolder'=>'Physio Search','style'=>'width:216px;'));
									echo $this->Form->hidden('testCode',array('id'=>'test_CodePhysio'));
									echo $this->Form->hidden('',array('id'=>'physioCode','name'=>'physioCode'));
							?>
							</span>
								<!-- Diagnosis -->
							<span>
							
							</span>
							</td>	
							<td valign="top">
								<table id=LabTableIdLIst  class="table_format">
									<tr><td colspan="2"> <b>Lab List</b></td></tr>
									<?php //debug($getArrayLabRad);
									foreach($getArrayLabRad['Laboratory'] as $getArrayLab){?>
									<tr id="LabTr<?php echo $getArrayLab['id']?>">
										<td colspan=""><?php echo $getArrayLab['name'];?></td>
										<td class="removeLabRow" id ="LabRow_<?php echo $getArrayLab['id']?>"><?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove'));?></td>
									</tr>
									
									<?php $strLabId.= $getArrayLab['id'].' ';}?>
									
								</table>
							</td>
							<td valign="top">
							<table id=RadTableIdLIst  class="table_format">
									<tr><td colspan="2"><b>Rad List</b></td></tr>
									<?php foreach($getArrayLabRad['Radiology'] as $getArrayRad){?>
									<tr id="RadTr<?php echo $getArrayRad['id']?>">
										<td colspan=""><?php echo $getArrayRad['name'];?></td>
										<td class="removeRadRow" id ="RadRow_<?php echo $getArrayRad['id']?>"><?php echo $this->Html->image('/img/icons/cross.png',
	    	        	    		 array('alt' => 'Remove'));?></td>
									</tr>
									<?php $strRadId.= $getArrayRad['id'].' ';}?>
								</table>
							</td>
							<td valign="top">
							<table id=PhysioTableIdLIst  class="table_format">
									<tr><td colspan="2"><b>Physiotherapy List</b></td></tr>
									<?php foreach($getArrayPhysio as $getArrayTarif){			
								?>
									<tr id="PhysioTr<?php echo $getArrayTarif['idTariffList']?>">
										<td colspan=""><?php echo $getArrayTarif['display'];?></td>
										<td class="removePhysioRow" id ="PhysioRow_<?php echo $getArrayTarif['idTariffList']?>"><?php echo $this->Html->image('/img/icons/cross.png',
	    	        	    		 array('alt' => 'Remove'));?></td>
									</tr>
										<?php $strPhysioId.= $getArrayTarif['idTariffList'].' ';}?>
								</table>
							</td>
							<td valign="top">
							<table id=DiaTableIdLIst  class="table_format">
									<tr><td colspan="2"><b>Mapped Diagnosis List</b></td></tr>
									<?php foreach($getArrayDia as $getArrayDia){?>
									<tr id="DiaTr<?php echo $getArrayDia['SnomedMappingMaster']['id']?>">
										<td colspan=""><?php echo $getArrayDia['SnomedMappingMaster']['icd9name'];?></td>
										<td class="removeDaiRow" id ="DaiRow_<?php echo $getArrayDia['SnomedMappingMaster']['id']?>"><?php echo $this->Html->image('/img/icons/cross.png',
	    	        	    		 array('alt' => 'Remove'));?></td>
									</tr>
										<?php $strDiaId.= $getArrayDia['SnomedMappingMaster']['id'].' ';}?>
								</table>
							</td>
							
						</tr>
						<tr>
							<td id="med_ajax" style="display:none" colspan="5" width="100%"></td>						
						</tr>
					</table>
			
			</td>
		</tr>
	</table>
	</div>

<?php echo $this->Form->create('',array('action'=>'admin_index','type'=>'get'));
	echo $this->Form->hidden('SmartPhrase.patientId',array('value'=>$patientIdNew));
	echo $this->Form->hidden('SmartPhrase.appointmentId',array('value'=>$appointmentIdNew));
	echo $this->Form->hidden('SmartPhrase.noteId',array('value'=>$noteIdNew));?>	
<table border="0" class=""  cellpadding="0" cellspacing="0" width="400px" align="center">
	<tbody>				    			 				    
		<tr class="row_title">				 		
			<td><label><?php echo __('Phrase Name') ?> :</label></td>		
			<td>											 
		    	<?php 
		    		 echo    $this->Form->input('phrase', array('id' => 'phrase_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td> 
		 	<td align="right">
				<?php
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
							
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="100%">
		<tr class="row_title">
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('SmartPhrase.phrase', __('Phrase', true)); ?>
			</strong></td>
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('SmartPhrase.phrase_text', __('Phrase Text', true)); ?>
			</strong></td>
			<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
			</td>
		</tr>
		<?php 
		$cnt =0;
		if(count($dataTest) > 0) {
		       foreach($dataTest as $phrasedata):
		       $cnt++;
		       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format"><?php echo $phrasedata['SmartPhrase']['phrase']; ?>
			</td>
			<td class="row_format"><?php echo substr($phrasedata['SmartPhrase']['phrase_text'],0,50); ?>
			</td>
			<td><?php
			echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View', true),
		   			 					'alt'=> __('View', true))), array('action' => 'admin_template_index', $phrasedata['SmartPhrase']['id']), array('escape' => false ));
					if(!empty($this->params->query['nursePriscription'])){
						echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
							'alt'=> __('Edit', true))), array('controller'=>'SmartPhrases', $phrasedata['SmartPhrase']['id'],'admin'=>true,'?'=>$this->params->query), array('escape' => false));

					}else{
							echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
								'alt'=> __('Edit', true))), array('controller'=>'SmartPhrases', $phrasedata['SmartPhrase']['id'],'admin'=>true,'?'=>array('patientId'=>$patientIdNew,'appointmentId'=>$appointmentIdNew,'noteId'=>$noteIdNew)), array('escape' => false));

					}
					
					if(!empty($this->params->query['nursePriscription'])){
						echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		'alt'=> __('Delete', true))), array('action' => 'admin_phrase_delete', $phrasedata['SmartPhrase']['id'],'?'=>$this->params->query), array('escape' => false ),"Are you sure you wish to delete this Phrase?");
					
					}else{
						echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		'alt'=> __('Delete', true))), array('action' => 'admin_phrase_delete', $phrasedata['SmartPhrase']['id']), array('escape' => false ),"Are you sure you wish to delete this Phrase?");
					
					}
		   			
					

		   ?>
		
		</tr>
		<?php endforeach;  ?>
			<?php $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column		
			$this->Paginator->options(array('url' =>array("?"=>$queryStr)));?>
		<tr>
			<TD colspan="8" align="center" class="table_format"><?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#docTemplate',    												
					'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), array('update'=>'#docTemplate',    												
						'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>

				<span class="paginator_links"> <?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			</span><?php echo $this->Paginator->numbers(array('update'=>'#docTemplate'));
			?>
			</TD>
		</tr>
		<?php

		      } else {
		  ?>
		<tr>
			<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
		</tr>
		<?php
		      }

		   // echo $this->Js->writeBuffer(); 	//please do not remove
		      ?>

	</table>


<script>
var toSaveArrayLab=[];
var toSaveArrayRad=[];
var toSaveArrayMed =[];
var toSaveArrayDia =[];
var toSaveArrayPhysio =[];
var toDeleteArrayDia =[];
var toDeleteArrayPhysio =[];
var phraseText =[];
			jQuery(document).ready(function(){				
				var editCase=$('#template_type').val();
				if(editCase!=""){
					jQuery("#template_type").removeClass('validate[required,custom[mandatory-enter],ajax[ajaxSmartPhraseCall]]');	
					/*$('#med_ajax').show();
					$('#rad_ajax').hide();
					$('#lab_ajax').hide();
					ajaxMedicationList(editCase);*/
				}
				var medDrp=$('#tempReplace option:selected').val();		
				var editCase=$('#template_type').val();	
				if(medDrp=='CMED'){
					$('#med_ajax').show();
					$('#rad_ajax').hide();
					$('#lab_ajax').hide();
					$('#physio_ajax').hide();
					ajaxMedicationList(editCase);
				}
				 jQuery("#SmartPhrasefrm").validationEngine();	
				 
				var id="<?php echo  rtrim($strLabId,' ')?>";
				/** Lab Array **/
				var labId=id.split(' ');
				 $.each( labId, function( i, val ) {
					 toSaveArrayLab.push(val);
				 });
				 /** Rad Array **/
				 var id="<?php echo  rtrim($strRadId,' ')?>";
					var radId=id.split(' ');
					 $.each( radId, function( i, val ) {
						 toSaveArrayRad.push(val);
					 });
				 /** Dia Array **/
					 var diaId="<?php echo  rtrim($strDiaId,' ')?>";
						var Id=diaId.split(' ');
						 $.each(Id, function( i, val ) {
							 toSaveArrayDia.push(val);
						 });

						 /** Physio Array **/
						 var physioId="<?php echo  rtrim($strPhysioId,' ')?>";
							var Id=physioId.split(' ');
							 $.each(Id, function( i, val ) {
								 toSaveArrayPhysio.push(val);
							 });
		 	    var counter =0; 
		 	    $("#has_multiple").click(function(){
		 	    	if($("#has_multiple").is(':checked')){
							$("#add_more").show('slow');
							$(".newTextField").show('slow'); 
			 	    	}else{
							$("#add_more").hide('slow');
							$(".newTextField").hide('slow'); 
				 	    	}
			 	    });

		 	    $("#add_more").click(function () {	
		 	    		$(".newTextField").show('slow'); 
		 	   	var newNoteDiv = $(document.createElement('tr'))
		 	       .attr("id", 'NoteDiv' + counter);
		 	   	var multiple_row = '<td><input type="text" id="list_name_'+ (counter+1) +'" name="data['+(counter+1)+'][SmartPhraseMultiple][list_name]"></td><td><input type="text" ,class = "validate[required,custom[mandatory-select]] customValidation" id="list_content_'+ (counter+1) +'" name="data['+(counter+1)+'][SmartPhraseMultiple][list_content]"></td>';
		 	   		          		 			
		 	   	newNoteDiv.append(multiple_row);		 
		 	   	newNoteDiv.appendTo("#smartTable");		
		 	   				 			 
		 	   	counter++;
		 	   	if(counter == 1){ 
			 	   	$('#removeButton').show('slow');
			 	   $("#has_multiple").attr("disabled", true);
		 	   	}
		 	        });

		 	   	$("#removeButton").click(function () {
		 	   		counter--;		
		 	       	$("#NoteDiv" + counter).remove();
		 	    		if(counter == 0) {
		 	    			$("#has_multiple").removeAttr("disabled");
			 	    		$('#removeButton').hide('slow');
		 	    		}
		 	     });		
		 	 /*  $(".customValidation").live(function () {
		 		  jQuery("#SmartPhrasefrm").validationEngine();	
		 	     });	*/		 


		 	   $("#phrase_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","SmartPhrase","phrase","admin" => false,"plugin"=>false)); ?>", {
					width: 250,
					selectFirst: true
				});	

			<?php if($this->params->query['nursePriscription']){?>
		 	  $('#nurseFlag').attr('checked', true);
		 	 <?php }?>	 
				
			});	
			// Aditya-to make template dynamic
			$('#tempReplace').change(function(){				
				jQuery("#template_type").validationEngine('hide'); 
				var currentVal=$('#phrase_text').val();
				var phTxt="<?php echo  rtrim($phTextStr,',')?>";
				
				/** avoid dulicate text in phrase txt **/
				var phTxtFinal=phTxt.split(',');
				 $.each(phTxtFinal, function( i, val ) {
					 phraseText.push(val);
				 });
			    var templateVal=$('#tempReplace').val();
			 	var q=  $.inArray(templateVal,phraseText);
			 
				if(q !="-1"){
				}else{
					if(templateVal!=''){
						$('#phrase_text').val(currentVal+'\n'+ templateVal+'\n');
						 phraseText.push(templateVal);
					}
				}
				/** Eod **/
				if(templateVal=='CMED'){
					$('#med_ajax').show();
					$('#rad_ajax').hide();
					$('#lab_ajax').hide();
					$('#physio_ajax').hide();
					
				/*	$('#DiaTableIdLIst').hide();*/
					var editCase=$('#template_type').val();
					if(editCase!=""){
						$('#med_ajax').show();
						$('#rad_ajax').hide();
						$('#lab_ajax').hide();
						$('#physio_ajax').hide();
						ajaxMedicationList(editCase);
					}else{
					ajaxMedicationList();
					}
					  
				}else if(templateVal=='RAD'){
					$('#rad_ajax').show();
					$('#lab_ajax').hide();
					$('#physio_ajax').hide();
					//$('#med_ajax').hide();
					/* $('#DiaTableIdLIst').hide();
					$('#LabTableIdLIst').hide();
					$('#MedTableIdLIst').hide();
					$('#RadTableIdLIst').show();*/
					
					}
				else if(templateVal=='LAB'){
					$('#rad_ajax').hide();
					$('#lab_ajax').show();
					$('#physio_ajax').hide();
					//$('#med_ajax').hide();
					
				/*	$('#DiaTableIdLIst').hide();
					$('#RadTableIdLIst').hide();
					$('#MedTableIdLIst').hide();
					$('#LabTableIdLIst').show();*/

				}
				else if(templateVal=='PHYSIO'){
					$('#rad_ajax').hide();
					$('#lab_ajax').hide();
					$('#physio_ajax').show();
					
				/*	$('#DiaTableIdLIst').hide();
					$('#RadTableIdLIst').hide();
					$('#MedTableIdLIst').hide();
					$('#LabTableIdLIst').show();*/

				}
				
				});
			//EOD
			// LAB Auto complete
			$("#test_name").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "labRadAutocomplete"
					,"Laboratory",'id',"dhr_order_code","name","admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				valueSelected:true,
				showNoId:true,
				loadId : 'test_name,testCode',
				onItemSelect:function () { 
					var toSaveLab=$('#test_name').val();
					var toSaveLabValue=$('#testCode').val();
					toSaveArrayLab.push(toSaveLabValue);	
					$('#test_name').val('');
					$('#showLABList').show();
					$("#LabTableIdLIst").find('tbody')
	        	    .append($('<tr>').attr('class', 'labClass').attr('id',"LabTr"+toSaveLabValue)
	        	    .append($('<td>').attr('class','text').text(toSaveLab))
	        	    .append($('<td>').attr('class','removeLabRow text').attr('id', 'LabRow_'+toSaveLabValue).
	    	        	    html('<?php echo $this->Html->image('/img/icons/cross.png',
	        	    		 array('alt' => 'Remove'));?>')));
					
				}
			});

	        	    $("#SelectRad1").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "labRadAutocomplete","Radiology",'id',"dhr_order_code","name","admin" => false,"plugin"=>false)); ?>", {
	        	    	width: 250,
	        	    	selectFirst: true,
	        	    	valueSelected:true,
	        	    	showNoId:true,
	        	    	loadId : 'SelectRad1,test_CodeRad',
	        	    	onItemSelect:function () { 
	        	    		var toSaveRad=$('#SelectRad1').val();
	    					var toSaveRadValue=$('#test_CodeRad').val();
	    					toSaveArrayRad.push(toSaveRadValue);	 
	    					$('#SelectRad1').val('');
	    					$('#showRadList').show();
	    					$("#RadTableIdLIst").find('tbody')
	    	        	    .append($('<tr>').attr('class', 'RadClass').attr('id',"RadTr"+toSaveRadValue)
	    	        	    .append($('<td>').attr('class','text').text(toSaveRad))
	    	        	    .append($('<td>').attr('class','removeRadRow text').attr('id', 'RadRow_'+toSaveRadValue).html('<?php echo $this->Html->image('/img/icons/cross.png',
	    	        	    		 array('alt' => 'Remove'));?>')));
	        	    	}
	        	    });

	    	        	    $("#SelectPhysio").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "PhysioAutocomplete","TariffList",'id',"service_category_id","name","admin" => false,"plugin"=>false)); ?>", {
	    	        	    	width: 250,
	    	        	    	selectFirst: true,
	    	        	    	valueSelected:true,
	    	        	    	showNoId:true,
	    	        	    	loadId : 'SelectPhysio,test_CodePhysio',
	    	        	    	onItemSelect:function () { 
	    	        	    		var toSavePhysio=$('#SelectPhysio').val();	    	        	    		
	    	    					var toSavePhysioValue=$('#test_CodePhysio').val();	    	    				
	    	    					toSaveArrayPhysio.push(toSavePhysioValue);	    	    				
	    	    					$('#SelectPhysio').val('');
	    	    					$('#showPhysioList').show();
	    	    					$("#PhysioTableIdLIst").find('tbody')
	    	    	        	    .append($('<tr>').attr('class', 'PhysioClass').attr('id',"PhysioTr"+toSavePhysioValue)
	    	    	        	    .append($('<td>').attr('class','text').text(toSavePhysio))
	    	    	        	    .append($('<td>').attr('class','removePhysioRow text').attr('id', 'PhysioRow_'+toSavePhysioValue).html('<?php echo $this->Html->image('/img/icons/cross.png',
	    	    	        	    		 array('alt' => 'Remove'));?>')));
	    	        	    	}
	    	        	    });
	    	        	   
	    	    	        	 $('#Submit').click(function(){		
	    	    	        		 jQuery("#template_type").validationEngine('hide'); 
	    	    	        		var valiadateData =jQuery("#SmartPhrasefrm").validationEngine('validate');	    	    	        	    	        
	    	    	        		if(valiadateData==false){		    	    	        	
		    	    	        		return false;
	    	    	        		}        	
		    	    	        	 var labCodestr = toSaveArrayLab.join(',');
		    	    	        	 var radCodestr = toSaveArrayRad.join(',');
		    	    	        	 var physioCodestr = toSaveArrayPhysio.join(','); 
		    	    	        	 var diaCodestr = toSaveArrayDia.join(',');
		    	    	        	 var diaCodesDeletestr = toDeleteArrayDia.join(',');
		    	    	        	 //$('#medCode').val(medCodestr);
		    	    	        	 $('#labCode').val(labCodestr);
		    	    	        	 $('#radCode').val(radCodestr);
		    	    	        	 $('#physioCode').val(physioCodestr);
		    	    	        	 $('#diaCode').val(diaCodestr);
		    	    	        	 $('#diaCodeDelete').val(diaCodesDeletestr);
		    	    	        	var phraseName= $('#template_type').val();
		    	    	        	 //return false;	
		    	    	        	 var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "ajaxMedicationList","admin" => false)); ?>";
	    	    	        		 var formData = $('#frmMed').serialize();
	    	    	        		 $.ajax({
	    	    	        		 	beforeSend : function() {
	    	    	        		 		$('#busy-indicator').show('fast');
	    	    	        		 	},
	    	    	        		 	type: 'POST',
	    	    	        		 url: ajaxUrl,
	    	    	        		 	data: formData+"&physioCodestr="+physioCodestr+"&phraseName="+phraseName,
	    	    	        		 	dataType: 'html',
	    	    	        		   	success: function(data){
	    	    	        		 	 	if(data!=''){
	    	    	        		 	 		$('#busy-indicator').hide('fast');
	    	    	        		 	 		//alert(data);
	    	    	        		 	   	
	    	    	        		 	  	}	
	    	    	        		 		jQuery("#template_type").validationEngine('hide'); 
	    	    	        		 	 	$('#SmartPhrasefrm').submit();
	    	    	        		 	 	jQuery("#template_type").validationEngine('hide');
	    	    	        		  	},
	    	    	        		 });								
		    	    	        	
		    	    	        	 });   	    	    	        
	    	    	        	 $(document).on('click','.removeLabRow', function() {
	    	    	        	 //$('.removeLabRow').on("click",function(){
	    	    	        		 var currentIdLab=$(this).attr('id');	    	    	        		
	    	    	        			var trToDel=currentIdLab.split('_');	    	    	        		
	    	    	        			$('#LabTr'+trToDel[1]).remove();
	    	    	        			var toPop=trToDel[1];
	    	    	        			var index = toSaveArrayLab.indexOf(toPop);
	    	    	        			if (index > -1) {
	    	    	        				toSaveArrayLab.splice(index, 1);
	    	    	        			}
		    	    	        	 });
		    	    	        	 $(document).on('click','.removeRadRow', function() {
	    	    	        	// $('.removeRadRow').on("click",function(){
	    	    	        		 var currentIdRad=$(this).attr('id');
	    	    	        			var trToDel=currentIdRad.split('_');
	    	    	        			$('#RadTr'+trToDel[1]).remove();
	    	    	        			var toPop=trToDel[1];
	    	    	        			var index = toSaveArrayRad.indexOf(toPop);
	    	    	        			if (index > -1) {
	    	    	        				toSaveArrayRad.splice(index, 1);
	    	    	        			}

	    	    	        	 });
	    	    	        	 $(document).on('click','.removeDaiRow', function() {
	    	    	        	// $('.removeDaiRow').on("click",function(){
	    	    	        		 var currentIdMed=$(this).attr('id');
	    	    	        			var trToDel=currentIdMed.split('_');
	    	    	        			$('#DiaTr'+trToDel[1]).remove();
	    	    	        			var toPop=trToDel[1];	    	    	        		
	    	    	        			var index = toSaveArrayDia.indexOf(toPop);
	    	    	        			if (index > -1) {
	    	    	        				toSaveArrayDia.splice(index, 1);
	    	    	        				toDeleteArrayDia.push(toPop);
	    	    	        			}
	    	    	        			

	    	    	        	 });

	    	    	        	 $(document).on('click','.removePhysioRow', function() {
	 	    	    	        	// $('.removeDaiRow').on("click",function(){
	 	    	    	        		 var currentIdMed=$(this).attr('id');
	 	    	    	        			var trToDel=currentIdMed.split('_');
	 	    	    	        			$('#PhysioTr'+trToDel[1]).remove();
	 	    	    	        			var toPop=trToDel[1];	    	    	        		
	 	    	    	        			var index = toSaveArrayPhysio.indexOf(toPop);
	 	    	    	        			if (index > -1) {
	 	    	    	        				toSaveArrayPhysio.splice(index, 1);
	 	    	    	        				toDeleteArrayPhysio.push(toPop);
	 	    	    	        			}
	 	    	    	        			

	 	    	    	        	 });
	    	    	        	 $("#diagnosis_name").autocomplete("<?php echo $this->Html->url(array("controller" => "Laboratories", "action" => "googlecompleteproblem","SnomedMappingMaster","id",'icd9name','null','icd9name',"admin" => false,"plugin"=>false)); ?>", {
	    	    	        			width: 250,
	    	    	        			selectFirst: true,
	    	    	        			loadId:'diagnosis_name,code_problem',
	    	    	        			showNoId:true,
	    	    	        			valueSelected:true,
	    	    	        			onItemSelect:function() {
	    	    	        				var toSaveDai=$('#diagnosis_name').val();
	    	    	    					var toSaveDiaValue=$('#code_problem').val();
	    	    	    					toSaveArrayDia.push(toSaveDiaValue);	 
	    	    	    					$('#diagnosis_name').val('');
	    	    	    					//$('#showRadList').show();
	    	    	    					$("#DiaTableIdLIst").find('tbody')
	    	    	    	        	    .append($('<tr>').attr('class', 'DiaClass').attr('id',"DiaTr"+toSaveDiaValue)
	    	    	    	        	    .append($('<td>').attr('class','text').text(toSaveDai))
	    	    	    	        	    .append($('<td>').attr('class','removeDaiRow text').attr('id', 'DaiRow_'+toSaveDiaValue).html('<?php echo $this->Html->image('/img/icons/cross.png',
	    	    	    	        	    		 array('alt' => 'Remove'));?>')));
	    	    	        			 }		
	    	    	        		});

	  function ajaxMedicationList(pharseName){
	   var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "SmartPhrases", "action" => "ajaxMedicationList","admin" => false)); ?>";
		$.ajax({
	    	beforeSend : function() {
	    		$('#busy-indicator').show('fast');
	    	},
	   	type: 'POST',
	    url: ajaxUrl+'/'+pharseName,
	   //	data: "labName="+toSaveArrayLab+"&RadId="+toSaveArrayRad+"&ProcedureId="+toSaveArrayProcedure,
	  	dataType: 'html',
		  	success: function(data){
			 	if(data!=''){
			   		$('#busy-indicator').hide('fast');
			   		$('#med_ajax').html(data);
			   		//$('#smartName').val($('#template_type').val());
			   		
			  	}	
		 	},
		});
	  }

		$("#template_type").keyup(function () {
		//	$(document).on('keyup','#template_type', function() { 
			$('#smartName').val($('#template_type').val());	
			
 	     });		    	        	 
</script>
