<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
		<td width="374" align="left" valign="top">
	        <table width="100%" border="0" cellspacing="0" cellpadding="0">
	          <tr>
	          	
	            <td width="100%" align="left" valign="top" class="tempSearch"> 
	                <?php //BOF dialog form 
	                 
					 		if(!empty($this->data['DischargeTemplate']['id']) || $emptyTemplateText){
					 			$template_form  = "block";
					 			$search_template ='none';
					 		}else{
					 			$template_form  = "none";
					 			$search_template = 'block';
					 		}
					 		 
					 	?>
	                <div id="search_template_care_plan" style="margin:0px 3px;display:<?php echo $search_template ;?>">
						<p> Templates: 
						<?php								
								 echo 	$this->Form->input('',array('name'=>$template_type,'id'=>'search-care_plan','autocomplete'=>'off', 'label'=>false,'div'=>false,'value'=>'Search',
										"style"=>"margin-right:3px;","onfocus"=>"javascript:if(this.value=='Search'){this.value='';  }",
										"onblur"=>"javascript:if(this.value==''){this.value='Search';} "));
								 
								 echo $this->Js->link($this->Html->image('icons/refresh-icon.png'), array('alt'=>'Reset search','title'=>'Reset search','action' => 'template_add',$template_type), 
								 array('escape' => false,'update'=>"#$updateID",
								 'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								  'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
								   			
								 
								 echo $this->Html->image('icons/plus-icon.png',array('alt'=>'Add Template text ','title'=>'Add Template text','id'=>'add_template_care_plan','style'=>'padding-left:5px;cursor:pointer'));
							?>
						</p>
					</div>	
	                <?php echo $this->Form->create('DischargeTemplate',array('action'=>'template_add','id'=>'DischargeTemplatefrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false,'error'=>false)));?>
						 						 
					 	 
					 	<div id="care_plan-add-template-form" style="display:<?php echo $template_form ;?>;">
							<?php 
							  if(!empty($errors)) {
							?>
								<table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center" class="error">
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
								   		<?php echo $this->Html->link(__('Cancel'),"#",array('id'=>'care_plan-close-template-form','class'=>'grayBtn')); ?>			     	 
										<?php echo $this->Js->submit('Submit', array('class' => 'blueBtn','div'=>false,'update'=>"#$updateID",'method'=>'post','url'=>array('action'=>'template_add','care_plan','',$updateID)	)); ?>
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
								   		 
								   		 	echo $this->Js->link($Dischargetemp['DischargeTemplate']['template_name'] , array('action' => 'add_template_text', $Dischargetemp['DischargeTemplate']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								    	 											'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
								   			 
								   		?>
								   </td>
								   <td align="right">
								   <?php
									   if($Dischargetemp['DischargeTemplate']['user_id']=='0'){
									   		echo "&nbsp;";
									   }else{
								   			echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Discharge Template Edit', true), 'alt'=> __('Discharge Template Edit', true))),
								   								 array('action' => 'template_add',$template_type, $Dischargetemp['DischargeTemplate']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
								    							'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
											echo $this->Js->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete Discharge Template', true), 'alt'=> __('Delete Discharge Template', true))),
								   								 array('action' => 'template_delete',$template_type, $Dischargetemp['DischargeTemplate']['id']), array('escape' => false,'update'=>"#$updateID",'method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
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
		 		$('#add_template_care_plan').click(function(){
		 			$('#search_template_care_plan').fadeOut('slow');
		 			$('#care_plan-add-template-form').delay(800).fadeIn('slow');		 			
		 			return false ;
		 		});
			 
				$('#care_plan-close-template-form').click(function(){
		 			$('#care_plan-add-template-form').fadeOut('slow');
		 			$('#search_template_care_plan').delay(800).fadeIn('slow');
		 			return false ;
		 		});

	 			//BOF template search
	 			$('#search-care_plan').keyup(function(){
		 			//collect name of search ele
		 			var searchName = $(this).attr('name');
		 			var replacedID = "templateArea-"+searchName ;	
		 			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "template_search",'care_plan',"admin" => false)); ?>";
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
				