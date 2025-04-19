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
									   		 	echo $this->Html->link($doctortemp['DoctorTemplateText']['template_text'] , '#'.$template_data['DoctorTemplate']['template_type'],
									   		 	 				array('escape' => false,'class'=>"templateText",'style'=>"font-size:12px;color:#ffffff;"));
									   			 
									   		?>
									   </td>
									   <td align="right" valign="top">
									   		
									   		<?php 
									   			echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Doctor Template Edit', true), 'alt'=> __('Doctor Template Edit', true))),
									   			 					array('action' => 'add_template_text',$template_id,$doctortemp['DoctorTemplateText']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
									    							'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
									    							?>
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
		  <?php
		      echo $this->Js->writeBuffer(); 	//please do not remove 
		  ?>		  
	 
			                  <script>
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
		 		 $('#add_new_temp').click(function(){
		 			$('#search_template').fadeOut('slow');
		 		 	$('#templateForm').delay(800).fadeIn('slow');		 		 
		 		 	return false ;
		 		 }); 
				 
				 $('#close-template-text-form').click(function(){
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
					  		var textareaID = "#plancare_desc";
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
</script>