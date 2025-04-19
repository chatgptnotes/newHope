<?php
  if(!empty($errors)) {
?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
		<tr>
	  		<td colspan="2" align="left" class="error">
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
<style>

	#accordionCust div{
		border:none;
	}

	
</style>
		<?php
			if($emptyText){
				$searchTemplate = 'none';
				$templateForm = 'block';
			}else{
				$searchTemplate = 'block';
				$templateForm = 'none';
			}
		?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>	          	
            <td width="100%" align="left" valign="top" class="tempSearch"> 	 
				<div id="search_template" style="display:<?php echo $searchTemplate;?>;margin: 0 3px; float:left;">
					<p>
						Template:<br>
						<?php								
							 echo 	$this->Form->input('',array('name'=>$template_data['DoctorTemplate']['template_type'],'id'=>'search','autocomplete'=>'off', 'label'=>false,'div'=>false,'value'=>'Search',
									"onfocus"=>"javascript:if(this.value=='Search'){this.value='';  }",
									"onblur"=>"javascript:if(this.value==''){this.value='Search';} "));
							 
							 echo 	$this->Js->link($this->Html->image('icons/refresh-icon.png'), array('alt'=>'Reset search','title'=>'Reset search','action' => 'add_template_text',$template_id), 
							 		array('style'=>'padding-left:5px;','escape' => false,'update'=>"#$updateID",
							 		'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
							    	'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
							 
							 echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'add_new_temp','style'=>'padding-left:5px;cursor:pointer'));
							 echo $this->Html->link($this->Html->image('icons/paragraph-icon.png',array('alt'=>'Add Template text ','title'=>'Add Paragraph','style'=>'padding-left:5px;cursor:pointer;text-align:right;')),'#'.$template_data['DoctorTemplate']['template_type'],array('class'=>'templateText','escape'=>false,'id'=>'add-para'));
						?>
					</p>
				</div>  
				<div id="templateForm" style="display:<?php echo $templateForm;?>">
					<?php echo $this->Form->create('',array('action'=>'add_template_text','id'=>'doctortemplatefrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false)));?>
					<?php
						//template id
						echo $this->Form->hidden('DoctorTemplateText.template_id',array('value'=>$template_id));
						echo $this->Form->hidden('DoctorTemplateText.id');
						
					?>	
							<table border="0" class="table_format"  cellpadding="0" cellspacing="0">
									 <tr>
										  <td><?php echo __('Template Text');?>:</td>
										  <td>							  		
										     	<?php echo $this->Form->textarea('DoctorTemplateText.template_text', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'customdescription', 'label'=> false, 'div' => false,'error' => false ,'rows'=>'3','style'=>'width:200px')); ?>
										  </td>
									 </tr>
									 <tr class="row_title">				 
									  <td class="row_format" align="right" colspan="2">
									   <?php
									   		echo $this->Html->link(__('Cancel'),"#",array('id'=>'close-template-text-form','class'=>'grayBtn'));
											echo $this->Js->submit(__('Submit'), array('label'=> false,'div' => false,'class'=>'blueBtn',
											'update'=>"#$updateID",'method'=>'post',
											'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
						    	 			'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
											'url'=>array('controller'=>'doctor_templates','action'=>'add_template_text')));							        
									   ?>
									  </td>
									 </tr>	
							</table>	
					 <?php echo $this->Form->end();?>	
			 	</div>
		 	 </td>
          </tr>
          <tr>
            <td width="100%" align="left" valign="top" height="10"></td>
          </tr>
	    </table>
	 	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
			    <td width="374" align="left" valign="top">
			        <table width="100%" border="0" cellspacing="0" cellpadding="0">
			          <tr>
			            <td width="100%" align="left" valign="top" class="tempDataBorder">
			            	<div class="tempHead" >
			                	<div class="left">Template : <?php  echo $template_data['DoctorTemplate']['template_name'];?></div>
			                    <div class="right">
			                    	<?php
			                    	 
			                    	 echo   $this->Js->link($this->Html->image('icons/close-icon.png'), array('controller'=>'doctor_templates','action' => 'add',$template_data['DoctorTemplate']['template_type']), array('class'=>'','escape' => false,'update'=>"#$updateID",'method'=>'post',
					 						'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
				    	 					'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
				    	 			?>
			                    </div>
			                    <div class="clr"></div>
			                </div>
			            	<div class="tempData1" id="template-list-<?php echo $template_data['DoctorTemplate']['template_type']; ?>">
			                    <table width="100%" cellpadding="0" cellspacing="5" border="0"> 
			                        <?php 			   
									      $cnt =0;
									      if(count($data) > 0) {
									       foreach($data as $doctortemp):
									       $cnt++;
									  ?>
									   <tr >		  
									   
									    <td class="recordActive" style="font-size:14px;color:#ffffff;">												
									   	<?php 
									   		 	echo $this->Html->link($doctortemp['DoctorTemplateText']['template_text'] ,'#'.$template_data['DoctorTemplate']['template_type'],
									   		 	 				array('escape' => false,'class'=>"templateText" ,'style'=>"font-size:12px;color:#ffffff;"));
									   			 
									   		?>
									   </td>
									   <td align="right" valign="top">
									   		
									   		<?php 
									   			echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Doctor Template Edit', true), 'alt'=> __('Doctor Template Edit', true))),array('action' => 'add_template_text',$template_id,$doctortemp['DoctorTemplateText']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
									    							'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
									    							
									   			echo $this->Js->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Doctor Template delete', true), 'alt'=> __('Doctor Template delete', true))),
									   			 					array('action' => 'delete_template_text',$template_id,$doctortemp['DoctorTemplateText']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
									    							'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));

				    							?>


				    							<?php $string = preg_replace('~[\r\n]+~', '', $doctortemp['DoctorTemplateText']['template_text']); ?>
				    							 <button type="button" onclick="quickGPT('<?php echo $template_data['DoctorTemplate']['template_type'] ?>', '<?php echo $string; ?>')" class="ques"> 
			   									<?php echo $this->Html->image('icons/search_icon.png', array('title'=> __('Search', true), 'alt'=> __('Search', true), 'height'=> __('12px', true))); ?>
									    </td>
									   <td>
									   <?php
									   			/*echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Doctor Template Edit', true), 'alt'=> __('Doctor Template Edit', true))), array('action' => 'edit', $doctortemp['DoctorTemplate']['id']), array('escape' => false,'update'=>'#doctemp_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
									    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
												echo $this->Js->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Doctor Template Delete', true), 'alt'=> __('Doctor Template Delete', true))), array('action' => 'delete', $doctortemp['DoctorTemplate']['id']), array('update'=>'#doctemp_content','method'=>'post','escape' => false,'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
									    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'confirm'=>"Are you sure you wish to delete this template?"));
									  			*/
									   ?>
									  </tr>
									  <?php endforeach;  ?>				   
							  <?php		  
							      } else {
							  ?>
							  <tr>
							   		<TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
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
    
		<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">		  
			<?php 	  
		      $this->Js->effect('fadeIn');		      	      
		      echo $this->Js->writeBuffer(); 	//please do not remove 
		  ?>		  
	</table>	 
<script>
			jQuery(document).ready(function(){
				 

			  

		 		 $('#add_new_temp').click(function(){
		 			$('#flashMessage').remove();
		 			$('#search_template').fadeOut('slow');
		 		 	$('#templateForm').delay(800).fadeIn('slow');		 		 
		 		 	return false ;
		 		 }); 
				 
				 $('#close-template-text-form').click(function(){
					 $('#flashMessage').remove();
				 	$('#templateForm').fadeOut('slow');
		 		 	$('#search_template').delay(800).fadeIn('slow');
		 		 	return false ;
				 }); 
				  
				$('.templateText').click(function(){
				  		//add current text to diagnosis textarea
				  		var templateType = $(this).attr('href');
				  		var splittedVar = templateType.split("#");
				  		if(splittedVar[1] == 'diagnosis'){
				  			var textareaID = "#final_diagnosis";	
					  	}else if(splittedVar[1] == 'examine'){
					  		var textareaID = "#general_examine";
						}else if(splittedVar[1] == 'care_plan'){
					  		var textareaID = "#care_plan_desc";
						}else if(splittedVar[1] == 'complaints'){
					  		var textareaID = "#complaints_desc";
						}else if(splittedVar[1] == 'lab-reports'){
					  		var textareaID = "#lab-reports_desc";
						}else if(splittedVar[1] == 'surgery'){
					  		var textareaID = "#surgery_desc";
						}else if(splittedVar[1] == 'investigation'){
					  		var textareaID = "#investigation_desc";
						}
						 
				  		if($(this).attr('id')=='add-para'){
				  			$(textareaID).val($(textareaID).val()+"\n");
					  		$(textareaID).focus(); 
					  	 	return false ;
					  	}else{						  				  		  
					  		$(textareaID).val($(textareaID).val()+" "+$(this).text());
					  		$(textareaID).focus();
					  		$(this).removeAttr("href");
					  		$(this).css('text-decoration','none');
					  		$(this).attr('class','templateadd');
					  		$(this).unbind('click');
					  	 	return false ;
					  	}
				});					
								

				//BOF template search
	 			$('#search').keyup(function(){
		 			//collect name of search ele
		 			var searchName = $(this).attr('name');
		 			var replacedID = "templateArea-"+searchName ;	
		 			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'doctor_templates', "action" => "template_text_search",$template_id,$template_data['DoctorTemplate']['template_type'],"admin" => false)); ?>";
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
	 			});
	 			//EOF tempalte search


			});	

			function quickGPT(template, question) {
					var prevVal = $('#gptInput_' + template).val();
					
					$('#gptInput_' + template).val(prevVal + ', ' + question);
					// $('.get_gpt_reply[data-template="' + template + '"]').click();
				}
</script>
				