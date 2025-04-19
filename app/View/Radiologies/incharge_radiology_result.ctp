<style>
.tddate img {
	float: inherit;
}
</style>
<?php ?>
<div class="inner_title">
	<h3>Radiology Result</h3>
</div>
<p class="ht5"></p>

<!-- billing activity form start here -->
<?php 
//echo $this->element('patient_information');
?>
<div class="clr ht5"></div>

<?php echo  $this->Form->create('RadiologyReport',array('id'=>'radManagerfrm','type'=>'file','url'=>array('controller'=>'radiologies','action'=>'ajax_radiology_manager_test_order',$patient_id),
			 'inputDefaults'=>array('label'=> false, 'div' => false, 'error' => false))); ?>
<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm" align="center">
	<tr>
		<th colspan="2"><?php echo __('Upload Reports');?> <strong> <?php echo " - ".$radiologyTestName; ?>
		</strong></th>
	</tr>
	<tr>

		<td valign="top" width="100%"><?php
		$labID = $this->data['Radiology']['radiology_id'] ;

		?>
			<div class="ht5"></div>
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="padding: 0 10px 0 0;" width="10%" valign="top"><?php echo __('Upload file/record ')?>
					</td>
					<td width="50%" style="padding: 0;">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">

							<tr>
								<td valign="top" width="50%"><?php	

								echo $this->Form->hidden('radiology_id',array('value'=>$labID));
								echo $this->Form->hidden('patient_id',array('value'=>$patient_id));
								$resultID = isset($data[0]['RadiologyResult']['id'])?$data[0]['RadiologyResult']['id']:'' ;
								echo $this->Form->hidden('RadiologyResult.id',array('value'=>$resultID));
								echo $this->Form->hidden('RadiologyResult.radiology_id',array('value'=>$labID));
								echo $this->Form->hidden('RadiologyResult.patient_id',array('value'=>$patient_id));
								echo $this->Form->hidden('RadiologyResult.radiology_test_order_id',array('value'=>$rad_test_order_id));

								?>
									<div id='TextBoxesGroup'>
										<div id="TextBoxDiv0">
											<?php 
											echo $this->Form->input('',array('name'=>'data[RadiologyReport][file_name][]','type'=>'file','class' => 'validate[required,custom[mandatory-select]]'));
											echo "<i>(File must be less than 2 MB)</i>";
											echo $this->Form->textarea('',array('name'=>'data[RadiologyReport][description][]','rows'=>5,'style'=>'width:60%;'));

											?>

										</div>
									</div>
								</td>
								<td class="tempHead"><?php 
									
								if(!isset($data[0]['RadiologyReport']['file_name'])){
			              	  				$display ="none";
			              	  			}else{
			              	  				$display ="block";
			              	  	}
													              	  			?>
									<div id="icdSlc"   style="display:<?php echo $display ;?>;">
										<?php               	  			 
										foreach($data as $temData){
		              	  					if($temData['RadiologyReport']['file_name']){
		              	  						$id = $temData['RadiologyReport']['id'];
		              	  						echo "<p id="."icd_".$id." style='padding:0px 10px;'>";
		              	  						$replacedText =$temData['RadiologyReport']['file_name'] ;
		              	  						echo $this->Html->link($replacedText,'/uploads/radiology/'.$temData['RadiologyReport']['file_name'],array('escape'=>false,'target'=>'__blank','style'=>'text-decoration:underline;'));
		              	  						echo $this->Html->link($this->Html->image('/img/icons/cross.png'),array('action'=>'delete_report',$patient_id,$labID,$id,$rad_test_order_id),array('escape'=>false,"align"=>"right","id"=>"$id" ,"title"=>"Remove"
		              	  			                                ,"style"=>"cursor: pointer;","alt"=>"Remove","class"=>"radio_eraser"),'Are you sure ?');
			              	  			        echo "</p>";
		              	  					}
		              	  				}
										?>
									</div>
								</td>
							</tr>
						</table>
					</td>

				</tr>
				<tr>
					<td class="form_lables">&nbsp;</td>
					<td><input type="button" class="grayBtn" id="addButton"
						value="Add more"> <input type="button" class="grayBtn"
						id="removeButton" value="Remove" style="display: none;">
					</td>
				</tr>
				<tr>
					<td colspan="2" width="100%" style="padding: 0;"><?php echo __('Notes'); ?>
						<br /> <br /> <?php echo  $this->Form->create('RadiologyDoctorNote',array('id'=>'labManagerfrm','type'=>'file','url'=>array('controller'=>'radiologies','action'=>'radiology_doctor_view',$patient_id),
			 'inputDefaults'=>array('label'=> false, 'div' => false, 'error' => false))); ?>
						<table width="100%" cellpadding="0" cellspacing="1" border="0"
							class="tabularForm" align="center">


							<td valign="top" width="100%"><?php
							$labID = $this->data['Radiology']['radiology_id'] ;

							?>
								<div class="ht5"></div>
								<table width="100%" cellpadding="0" cellspacing="0" border="0">

									<tr>
										<td width="40%" style="padding: 0;" valign="top">
											<div id="templateArea-radiology">
												<?php
												echo $this->requestAction('radiologies/template_add/radiology/null/null/'.$labID);
												?>
											</div>
										</td>
										<td width="60%" style="padding: 0;" valign="top"><?php		                 

										$note = isset($data[0]['RadiologyResult']['note'])?$data[0]['RadiologyResult']['note']:'' ;
										echo $this->Form->textarea('RadiologyResult.note',array('id'=>'doctors-note','rows'=>18,'style'=>'width:95%;','value'=>$note));
										?>
										</td>
									</tr>
								</table>
							</td>
							</tr>
						</table>
						<p class="ht5"></p>
						<p class="ht5"></p>
						<div align="right">
							<?php 
							//echo $this->Form->submit(__('Save'), array('id'=>'add-more','title'=>'Save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));

							//echo $this->Html->link(__('Cancel'), array('action'=>'radiology_test_list',$patient_id), array('escape' => false,'class' => 'grayBtn','id'=>'cancel-order-form'));

							echo $this->Js->writeBuffer();
							?>
						</div> <?php echo $this->Form->end();	 ?>
					</td>
				</tr>
				<tr>
					<td style="padding: 0 10px 0 0;"><?php echo __('No of Slices')?></td>
					<td width="50%" style="padding: 0;"><?php
					$split = isset($data[0]['RadiologyResult']['split'])?$data[0]['RadiologyResult']['split']:'' ;
					echo $this->Form->input('RadiologyResult.split',array('value'=>$split));
					?>
					</td>
				</tr>

				<tr>
					<td style="padding:10px 10px 0 0;"><?php echo __('Radiologist')?></td>
					<td width="50%" style="padding: 0;"><?php 
					echo $this->Form->input('RadiologyResult.user_id',array('type'=>'select','options'=>$radiologist,'empty'=>__('Please Select'),
		                   		  									'value'=>$data[0]['RadiologyResult']['user_id']));?>
					</td>
				</tr>


				<tr>
					<td style="padding: 10px 10px 0 0;"><?php echo __('Image Impression')?>
					</td>
					<!-- <td width="50%" style="padding: 10px 0 0 0;"><?php  $img = isset($data[0]['RadiologyResult']['img_impression'])?$data[0]['RadiologyResult']['img_impression']:'' ;
															echo $this->Form->input('RadiologyResult.img_impression', array('style'=>'width:250px; float:left;','empty'=>__('Select'),'options'=>array('Positive'=>'Within Normal Limits','Negative'=>'Abnormal Findings'), 'id'=>'img_impression',
																		'class' => 'textBoxExpnd','value'=>$data[0]['RadiologyResult']['img_impression'])); ?>
															</td> -->

					<td width="50%" style="padding: 10px 0 0 0;"><?php  $img = isset($data[0]['RadiologyResult']['img_impression'])?$data[0]['RadiologyResult']['img_impression']:'' ;
					echo $this->Form->textarea('RadiologyResult.img_impression', array('style'=>'width:250px; float:left;','rows'=>1, 'id'=>'img_impression',
																		'class' => '','value'=>$data[0]['RadiologyResult']['img_impression'])); ?>
					</td>
				</tr>
				<tr>
					<td style="padding: 10px 10px 0 0;"><?php echo __('Advice')?></td>
					<td width="50%" style="padding: 10px 0 0 0;"><?php  $img = isset($data[0]['RadiologyResult']['advice'])?$data[0]['RadiologyResult']['advice']:'' ;
					echo $this->Form->textarea('RadiologyResult.advice', array('style'=>'width:250px; float:left;','rows'=>1, 'id'=>'advice',
																		'class' => '','value'=>$data[0]['RadiologyResult']['advice'])); ?>
					</td>
				</tr>


			</table>
		</td>


	</tr>
</table>

<p class="ht5"></p>
<p class="ht5"></p>
<div style="float: right">
	<table>
		<tr>
			<td class="tddate"><?php 

			if($data[0]['RadiologyResult']['confirm_result']==1){
								$checked = 'checked';
								echo "<strong>Result Publish On : </strong>";
								//echo $this->DateFormat->formatDate2Local($data[0]['RadiologyResult']['result_publish_date'],Configure::read('date_format'),true) ;
								$resultDateVal = $this->DateFormat->formatDate2Local($data[0]['RadiologyResult']['result_publish_date'],Configure::read('date_format'),true) ;
								echo $this->Form->input('RadiologyResult.confirm_result',array('id'=>'confirm_result','type'=>'checkbox','value'=>1,'checked'=>$checked,'autocomplete'=>'off'));
								echo $this->Form->input('RadiologyResult.result_publish_date',array('id'=>'result_publish_date','type'=>'text','autocomplete'=>false,'value'=>$resultDateVal,'autocomplete'=>'off'));
								echo $this->Form->input('RadiologyResult.confirm_result',array('type'=>'hidden','value'=>1));
							}else{
								$checked = '';
								echo "<strong>Publish Result</strong>";
								echo $this->Form->input('RadiologyResult.confirm_result',array('id'=>'confirm_result','type'=>'checkbox','value'=>1,'checked'=>$checked,'autocomplete'=>'off'));
								echo $this->Form->input('RadiologyResult.result_publish_date',array('id'=>'result_publish_date','type'=>'text','autocomplete'=>false,'readonly'=>'readonly','autocomplete'=>'off'));
							} ?>
			</td>
		</tr>
	</table>
	<?php 
	echo "&nbsp;&nbsp;";
	echo $this->Html->link(__('Cancel'), array('action'=>'radDashBoard'), array('escape' => false,'class' => 'grayBtn','id'=>'cancel-order-form'));
	echo $this->Form->submit(__('Save'), array('id'=>'add-more','title'=>'Save','escape' => false,'class' => 'blueBtn','label' => false,'div' => false,'error'=>false));

	echo $this->Js->writeBuffer();
	?>
</div>
<?php echo $this->Form->end();	 ?>

<script><!--
       $(document).ready(function(){
    	/*   jQuery(document).ready(function(){
   			 
   			jQuery("#labManagerfrm").validationEngine();

   			  
   		});*/

     		 

		//BOF dynamic file uploader
		var counter = 1;
		 
		    $("#addButton").click(function () {		 
				 			 
				var newTextBoxDiv = $(document.createElement('div'))
				     .attr("id", 'TextBoxDiv' + counter); 
				
				newTextBoxDiv.append().html('<input type="file" id="textbox' + counter + '" value="" class="validate[required,custom[mandatory-enter]]" name="data[RadiologyReport][file_name][]"><i>(File must be less than 2 MB)</i><textarea id="textbox' + counter + '" value="" class="validate[required,custom[mandatory-enter]]" name="data[RadiologyReport][description][]" rows=5 style="width:60%"></textarea>');			 
				newTextBoxDiv.appendTo("#TextBoxesGroup"); 
				
				counter++;
				if(counter > 1) $('#removeButton').show('slow');
		     });
		 
		     $("#removeButton").click(function () {
					if(counter==1){
			          alert("No more textbox to remove");
			          return false;
			        }   			 
					counter--;			 
			        $("#TextBoxDiv" + counter).remove();
			        $("#CostDiv" + counter).remove();
			 		if(counter == 1) $('#removeButton').hide('slow');
			  });
		//EOF dynamic file uploader

		   //function to check search filter
				$('#radManagerfrm').submit(function(){
					var msg = false ; 
					 
					$("form input:text").each(function(){
					       //access to form element via $(this)
					        
					       if($(this).val() !=''){
					       		msg = true  ;
					       }
					    }
					);
					$("form textarea").each(function(){
						 
					       //access to form element via $(this)
					       if($(this).val() !=''){
					       		msg = true  ;
					       }
					    }
					);
					$("form input:file").each(function(){
						 
					       //access to form element via $(this)
					       if($(this).val() !=''){
					       		msg = true  ;
					       }
					    }
					);
					if(!msg){
						alert("Please fill atleast one value .");
						return false ;
					}		
				});
				
		  
       });//eof ready
       
       $(function() {	
			//calender
			$( "#result_publish_date" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true, 
				yearRange: '1950',			 
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
	            onSelect:function(){
					$(this).focus();
					$('#confirm_result').attr('checked',true);
	            }
			});

			$('#confirm_result').click(function(){
				if($('#confirm_result').is(":checked")){
				<?php 
                 $newDate =  $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format_us'),true);
                  ?>
                   var showdate = '<?php echo $newDate; ?>';
                   $( "#result_publish_date" ).val(showdate);
				}else{
					$( "#result_publish_date" ).val(''); 
				}
			});
		});
 </script>


