<table width="100%" cellpadding="0" cellspacing="5" border="0"> 
			                        <?php 			   
									      $cnt =0;
									      if(count($data) > 0) {
									       foreach($data as $doctortemp):
									       $cnt++;
									  ?>
									   <tr >		  
									   
									    <td class="recordActive" style="font-size:11px;">												
									   	<?php 
									   		 	echo $this->Html->link($doctortemp['DischargeTemplateText']['template_text'] , '#radiology',
									   		 	 				array('escape' => false,'class'=>"templateText"));
									   			 
									   		?>
									   </td>
									   <td align="right" valign="top">
									   		
									   		<?php 
									   			echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Doctor Template Edit', true), 'alt'=> __('Doctor Template Edit', true))),
									   			 					array('action' => 'investigation_add_template_text',$template_id,$doctortemp['DischargeTemplateText']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator-investigation')->effect('fadeOut', array('buffer' => false)),
									    							'before' => $this->Js->get('#busy-indicator-investigation')->effect('fadeIn', array('buffer' => false))));
									    							?>
									    </td>
									   <td>
									   <?php
									   			/*echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Doctor Template Edit', true), 'alt'=> __('Doctor Template Edit', true))), array('action' => 'edit', $doctortemp['DoctorTemplate']['id']), array('escape' => false,'update'=>'#doctemp_content','method'=>'post','complete' => $this->Js->get('#busy-indicator-investigation')->effect('fadeOut', array('buffer' => false)),
									    												'before' => $this->Js->get('#busy-indicator-investigation')->effect('fadeIn', array('buffer' => false))));
												echo $this->Js->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Doctor Template Delete', true), 'alt'=> __('Doctor Template Delete', true))), array('action' => 'delete', $doctortemp['DoctorTemplate']['id']), array('update'=>'#doctemp_content','method'=>'post','escape' => false,'complete' => $this->Js->get('#busy-indicator-investigation')->effect('fadeOut', array('buffer' => false)),
									    												'before' => $this->Js->get('#busy-indicator-investigation')->effect('fadeIn', array('buffer' => false)),'confirm'=>"Are you sure you wish to delete this template?"));
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
			  		 			  		  
			  		if($(this).attr('id')=='add-para'){
			  			$('#doctors-note').val($('#doctors-note').val()+"\n");
				  		$('#doctors-note').focus(); 
				  	 	return false ;
				  	}else{						  				  		  
				  		$('#doctors-note').val($('#doctors-note').val()+" "+$(this).text());
				  		$('#doctors-note').focus();
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
		 			var ajaxUrl = "<?php echo $this->Html->url(array("action" => "investigation_template_text_search",$template_id,'investigation',"admin" => false)); ?>";
 					$.ajax({  
			 			  type: "POST",						 		  	  	    		
						  url: ajaxUrl,
						  data: "searchStr="+$(this).val(),
						  context: document.body,
						  beforeSend:function(){
					    		// this is where we append a loading image
					    		$('#busy-indicator-investigation').show('fast');
						  },					  		  
						  success: function(data){						 
							    $('#busy-indicator-investigation').hide('fast');				 					 				 								  		
						   		$("#template-list-"+searchName).html(data);								   		
						   		$("#template-list-"+searchName).fadeIn();
						   		
						  }
					});
	 			});
	 			//EOF tempalte search
			  
			});	
</script>