<style>

	#accordionCust div{
		border:none;
	}

	
</style>
		<?php
		if(!empty($this->data['DischargeTemplate']['id']) || $emptyTemplateText){
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
				<div id="investigation_search_template" style="display:<?php echo $searchTemplate;?>;margin: 0 3px;">
					<p>
						Template: 
						<?php								
							 echo 	$this->Form->input('',array('name'=>'investigation','id'=>'investigation_search','autocomplete'=>'off', 'label'=>false,'div'=>false,'value'=>'Search',
									"onfocus"=>"javascript:if(this.value=='Search'){this.value='';  }",
									"onblur"=>"javascript:if(this.value==''){this.value='Search';} "));
							 
							 echo 	$this->Js->link($this->Html->image('icons/refresh-icon.png'), array('alt'=>'Reset search','title'=>'Reset search','action' => 'investigation_add_template_text',$template_id), 
							 		array('style'=>'padding-left:5px;','escape' => false,'update'=>"#$updateID",
							 		'method'=>'post','complete' => $this->Js->get('#busy-indicator-investigation')->effect('fadeOut', array('buffer' => false)),
							    	'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
							 
							 echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'investigation_add_new_temp','style'=>'padding-left:5px;cursor:pointer'));
							 echo $this->Html->link($this->Html->image('icons/paragraph-icon.png',array('alt'=>'Add Template text ','title'=>'Add Paragraph','style'=>'padding-left:5px;cursor:pointer;text-align:right;')),'#'.'investigation',array('class'=>'templateText','escape'=>false,'id'=>'investigation_add-para'));
						?>
					</p>
				</div>  
				<div id="investigation_templateForm" style="display:<?php echo $templateForm;?>">
				<?php 
							  if(!empty($errors)) {
							?>
								<table border="0" cellpadding="0" cellspacing="0" width=""  align="center" class="error">
									<tr>
								  		<td colspan="2" align="center" class=" " style="color:#8C0000">
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
					<?php echo $this->Form->create('',array('action'=>'investigation_add_template_text','id'=>'DischargeTemplatefrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false)));?>
					<?php
						//template id
						echo $this->Form->hidden('DischargeTemplateText.template_id',array('value'=>$template_id));
						echo $this->Form->hidden('DischargeTemplateText.id');
						
					?>	
							<table border="0" class="table_format"  cellpadding="0" cellspacing="0">
									 <tr>
										  <td><?php echo __('Template Text');?>:</td>
										  <td>							  		
										     	<?php echo $this->Form->textarea('DischargeTemplateText.template_text', array('class' => 'validate[required,custom[mandatory-enter]]','id' => 'customdescription', 'label'=> false, 'div' => false,'error' => false ,'rows'=>'3','style'=>'width:200px')); ?>
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
											'url'=>array('action'=>'investigation_add_template_text')));							        
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
			                	<div class="left">Template : <?php  echo $template_data['DischargeTemplate']['template_name'];?></div>
			                    <div class="right">
			                    	<?php
			                    	 
			                    	 echo   $this->Js->link($this->Html->image('icons/close-icon.png'), array( 'action' => 'investigation_template_add','investigation'), array('class'=>'','escape' => false,'update'=>"#$updateID",'method'=>'post',
					 						'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
				    	 					'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
				    	 			?>
			                    </div>
			                    <div class="clr"></div>
			                </div>
			            	<div class="tempData1" id="template-list-investigation">
			                    <table width="100%" cellpadding="0" cellspacing="5" border="0"> 
			                        <?php 			   
									      $cnt =0;
									      if(count($data) > 0) {
									       foreach($data as $Radiologytemp):
									       $cnt++;
									  ?>
									   <tr >		  
									   
									    <td class="recordActive" style="font-size:11px;">												
									   	<?php 
									   		 	echo $this->Html->link($Radiologytemp['DischargeTemplateText']['template_text'] ,'#'.'investigation',
									   		 	 				array('escape' => false,'class'=>"templateText"));
									   			 
									   		?>
									   </td>
									   <td align="right" valign="top">
									   		
									   		<?php 
									   			echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Discharge Template Edit', true), 'alt'=> __('Discharge Template Edit', true))),
									   			 					array('action' => 'investigation_add_template_text',$template_id,$Radiologytemp['DischargeTemplateText']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
									    							'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
									    							?>
									    </td>
									   <td>
									   <?php
									   			/*echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Radiology Template Edit', true), 'alt'=> __('Radiology Template Edit', true))), array('action' => 'edit', $Radiologytemp['DischargeTemplate']['id']), array('escape' => false,'update'=>'#doctemp_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
									    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
												echo $this->Js->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Radiology Template Delete', true), 'alt'=> __('Radiology Template Delete', true))), array('action' => 'delete', $Radiologytemp['DischargeTemplate']['id']), array('update'=>'#doctemp_content','method'=>'post','escape' => false,'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
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
<script><!--
			jQuery(document).ready(function(){
				 
		 		 $('#investigation_add_new_temp').click(function(){
		 			$('#investigation_search_template').fadeOut('slow');
		 		 	$('#investigation_templateForm').delay(800).fadeIn('slow');		 		 
		 		 	return false ;
		 		 }); 
				 
				 $('#investigation_close-template-text-form').click(function(){
				 	$('#investigation_templateForm').fadeOut('slow');
		 		 	$('#investigation_search_template').delay(800).fadeIn('slow');
		 		 	return false ;
				 }); 
				  
				$('.templateText').click(function(){
				  		//add current text to diagnosis textarea
				  		var templateType = $(this).attr('href');
				  		 
						 
				  		if($(this).attr('id')=='investigation_add-para'){
				  			$('#investigation_desc').val($('#investigation_desc').val()+"\n");
					  		$('#investigation_desc').focus(); 
					  	 	return false ;
					  	}else{						  				  		  
					  		$('#investigation_desc').val($('#investigation_desc').val()+" "+$(this).text());
					  		$('#investigation_desc').focus();
					  		$(this).removeAttr("href");
					  		$(this).css('text-decoration','none');
					  		$(this).attr('class','templateadd');
					  		$(this).unbind('click');
					  	 	return false ;
					  	}
				});					
								

				//BOF template search
	 			$('#investigation_search').keyup(function(){
					
		 			//collect name of search ele
		 			var searchName = $(this).attr('name');
					 
		 			var replacedID = "templateArea-"+searchName ;	
		 			var ajaxUrl = "<?php echo $this->Html->url(array( "action" => "investigation_template_text_search",$template_id ,'investigation',"admin" => false)); ?>";
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
							    $('#busy-indicator-investigation').hide('fast');				 					 				 								  		
						   		$("#template-list-"+searchName).html(data);								   		
						   		$("#template-list-"+searchName).fadeIn();
						   		
						  }
					});
	 			});
	 			//EOF tempalte search
			  
			});	
--></script>
				