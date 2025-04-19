
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
		<td width="374" align="left" valign="top">
	        <table width="100%" border="0" cellspacing="0" cellpadding="0">
	          <tr>
	          	
	            <td width="100%" align="left" valign="top" class="tempSearch"> 
	                <?php 
	                	if(!empty($this->data['DischargeTemplate']['id']) || $emptyTemplateText){
								$searchTemplate = 'none';
								$templateForm = 'block';
							}else{
								$searchTemplate = 'block';
								$templateForm = 'none';
							}
	                ?>
	                <div id="investigation_search_template" style="margin:0px 3px;display:<?php echo $searchTemplate ;?>">
						<p> Templates: 
						<?php	
						  
		 						
								 echo 	$this->Form->input('',array('name'=>$template_type,'id'=>'investigation_search','autocomplete'=>'off', 'label'=>false,'div'=>false,'value'=>'Search',
										"style"=>"margin-right:3px;","onfocus"=>"javascript:if(this.value=='Search'){this.value='';  }",
										"onblur"=>"javascript:if(this.value==''){this.value='Search';} "));
								 
								 echo $this->Js->link($this->Html->image('icons/refresh-icon.png'), array('alt'=>'Reset search','title'=>'Reset search','action' => 'investigation_template_add',$template_type), 
								 array('escape' => false,'update'=>"#$updateID",
								 'method'=>'post','complete' => $this->Js->get('#busy-indicator-investigation')->effect('fadeOut', array('buffer' => false)),
								  'before' => $this->Js->get('#busy-indicator-investigation')->effect('fadeIn', array('buffer' => false))));
								   			
								 
								 echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'investigation_add-template','style'=>'padding-left:5px;cursor:pointer'));
							?>
						</p>
					</div>	
	                <?php echo $this->Form->create('DischargeTemplate',array('action'=>'investigation_discharge_template','id'=>'DischargeTemplatefrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false)));?>
						 						 
					 	 
					 	<div id="investigation_add-template-form" style="display:<?php echo $templateForm ;?>;">
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
							<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
								<tr>
									<td style="text-align:center;"><?php echo __('Template');?>:</td>
									<td><?php 
											echo $this->Form->hidden('id');
											echo $this->Form->input('template_name',array('type'=>'text'));
											echo $this->Form->hidden('template_type',array('value'=>$template_type));
									 ?>	</td>
								</tr>
								
								<tr>
									<td colspan="2" align="right">		
								   		<?php echo $this->Html->link(__('Cancel'),"#",array('id'=>'investigation_close-template-form','class'=>'grayBtn')); ?>			     	 
										<?php echo $this->Js->submit('Submit', array('class' => 'blueBtn','div'=>false,'update'=>"#$updateID",'method'=>'post','url'=>array('action'=>'investigation_template_add','investigation','',$updateID)	)); ?>
										<?php //echo $this->Js->link(__('Submit'),array('controller'=>'radiologies','action'=>'Radiology_template'),array('class'=>'blueBtn','div'=>false,'update'=>'#templateArea','method'=>'post')); ?>
				 
									</td>
								</tr>
							</table>						 
						</div>
					 <?php echo $this->Form->end(); ?>
	            </td>
	          </tr>
	          <tr>
	            <td width="100%" align="left" valign="top" height="10"></td>
	          </tr>
	          <tr>
	            <td width="100%" align="left" valign="top" class="tempDataBorder">
	            	<p class="tempHead">Frequent templates:</p>
	            	<div class="tempData" id="template-list-<?php echo $template_type ;?>">
	                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
	                    	 
	                        <?php 
							      $cnt =0;
							      if(count($data) > 0) {
							       foreach($data as $Dischargetemp):
							       $cnt++;
							  ?>
								   <tr>		
								  
									    <td align="right">
									   <?php
									   		if($Dischargetemp['DischargeTemplate']['user_id']=='0'){
									   			echo  $this->Html->image('icons/favourite-icon.png', array('title'=> __('Admin Template', true), 'alt'=> __('Discharge Template Edit', true)));
									   		}else{
									   			echo "&nbsp;";
									   		}  
									   ?>
									   </td>  
								   <td class="row_format leftPad10" style="font-size:11px;">
								   		<?php 
								   		 
								   		 	echo $this->Js->link($Dischargetemp['DischargeTemplate']['template_name'] , array('action' => 'investigation_add_template_text', $Dischargetemp['DischargeTemplate']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator-investigation')->effect('fadeOut', array('buffer' => false)),
								    	 											'before' => $this->Js->get('#busy-indicator-investigation')->effect('fadeIn', array('buffer' => false))));
								   			 
								   		?>
								   </td>
								   <td>
								   <?php
									   if($Dischargetemp['DischargeTemplate']['user_id']=='0'){
									   		echo "&nbsp;";
									   }else{
								   			echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Discharge Template Edit', true), 'alt'=> __('Discharge Template Edit', true))),
								   								 array('action' => 'investigation_template_add',$template_type, $Dischargetemp['DischargeTemplate']['id'],$updateID), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator-investigation')->effect('fadeOut', array('buffer' => false)),
								    							'before' => $this->Js->get('#busy-indicator-investigation')->effect('fadeIn', array('buffer' => false))));
										echo $this->Js->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Discharge Template Delete', true), 'alt'=> __('Discharge Template Delete', true))),
																array('action' => 'investigation_template_delete',$template_type, $Dischargetemp['DischargeTemplate']['id'],$updateID), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
																'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));

								   		}	  
								 
								   ?>
								   </td>
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
			<?php
		      echo $this->Js->writeBuffer(); 	//please do not remove 
		  ?>		  
	 
<script>
			jQuery(document).ready(function(){
				 
		 		$('#investigation_add-template').click(function(){
		 			$('#investigation_search_template').fadeOut('slow');
		 			$('#investigation_add-template-form').delay(800).fadeIn('slow');		 			
		 			return false ;
		 		});
			 
				$('#investigation_close-template-form').click(function(){
		 			$('#investigation_add-template-form').fadeOut('slow');
		 			$('#investigation_search_template').delay(800).fadeIn('slow');
		 			return false ;
		 		});

	 			//BOF template search
	 			$('#investigation_search').keyup(function(){
		 			//collect name of search ele
		 			var searchName = $(this).attr('name');
		 			var replacedID = "templateArea-"+searchName ;	
		 			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "investigation_template_search",'investigation',"admin" => false)); ?>";
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
				