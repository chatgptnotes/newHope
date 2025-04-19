<style>
.table_format1 {
    width: 40% !important;
}
</style>
<div id="doctemp_content">
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
	<div id="docTemplate">
		<div class="inner_title">
			<h3><?php echo __('Radiology Template', true); ?></h3>
			<span>
<?php
if($this->params->query['flag']=='edit'){
    echo "";
}else{
	echo $this->Html->link(__('Add', true),'javascript:void(0)', array('escape' => false,'class'=>'blueBtn','id'=>'addBtn'));
}


 	if($template_id){
 		echo $this->Html->link(__('Back', true),array('action' => 'template'), array('escape' => false,'class'=>'blueBtn'));
	}else{	
		echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
 	}
?>
</span>
		</div>
		<table border="0">
	<tr id="tariff-opt-area">
		<?php       echo $this->Form->create('',array('url'=>array('action'=>'template', 'admin' => true), 'id'=>'servicefrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
		)));
		?>
		<td align="left" ><?php echo $this->Form->input('', array('name'=>'rad_name','type'=>'text','id' => 'rad_name','style'=>'width:150px;','autocomplete'=>'off','placeholder'=>'Select Radiology','class'=>'textBoxExpnd'));
								echo $this->Form->hidden('',array('name'=>'rad_id','id'=>'rad_id'));?>
		</td>
		<td align="left" id="searchBtn" style="display: none"><?php echo $this->Form->submit('Search', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?></td>
		<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'template', 'admin' => true),array('escape'=>false, 'title' => 'refresh'));?></td>
		<?php echo $this->Form->end();?>
	</tr>
</table>
		<?php 	echo $this->Form->create('RadiologyTemplate',array('url'=>array('controller'=>'radiologies','action'=>'admin_template_add'),'id'=>'RadiologyTemplatefrm', 'inputDefaults' => array('label' => false,'div' => false)));
				echo $this->Form->hidden('id');
			?>	
				<table border="0" class="table_format table_format1"  cellpadding="0" cellspacing="0" width="40%"  id='addRadio' align="right">
						 <tr>
						  <td ><?php echo __('Radiology Name :');?><font color="red">*</font></td>
						  <td>						  		
     						<?php   echo $this->Form->input('Radiology.name',array('type'=>'text','class'=>'validate[required,custom[mandatory-enter]]','id'=>"radiology-filter",
									'autocomplete'=>'off','label'=>false,'div'=>false,'placeholder'=>' Search Radiology'));
							echo $this->Form->hidden('radiology_id',array('id'=>'radiology_id'));?>
						  </td>
						 </tr>
						 <tr>
						  <td><?php echo __('Template Name :');?><font color="red">*</font></td>
						  <td>						  		
						     		<?php echo $this->Form->input('template_name', array('type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'customdescription')); ?>
						  </td>
						 </tr>	
						 <tr> <td class="row_format" align="right" colspan="2">
						   <?php
						       echo $this->Html->link(__('Cancel', true),'javascript:void(0)', array('escape' => false,'class'=>'blueBtn','id'=>'cancelBtn'));
								echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn','id'=>'submit'));
						   ?>
						  </td></tr>
				</table>	
		 <?php echo $this->Form->end();?>	
	 
		<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">		 
				
		   <tr class="row_title">
		   <!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('RadiologyTemplate.id', __('Id', true)); ?></strong></td>
		    --><td class="table_cell"><strong><?php echo $this->Paginator->sort('Radiology.name', __('Radiology Name', true)); ?></strong></td>
		   <td class="table_cell"><strong><?php echo $this->Paginator->sort('RadiologyTemplate.template_name', __('Template Name', true)); ?></strong></td> 
		   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
		  </tr>
		  <?php 
		      $cnt =0;
		       
		      if(count($data) > 0) {
		       foreach($data as $data):
		       $cnt++;
		  ?>
		   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		   <!-- <td class="row_format"><?php echo $data['RadiologyTemplate']['id']; ?> </td>
		    --><td class="row_format"><?php echo $data['Radiology']['name']; ?></td>
		   <td class="row_format"><?php echo $data['RadiologyTemplate']['template_name']; ?> </td>
		   <td>
		   <?php
		   			echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View', true),
		   			 					'alt'=> __('View Template Text', true))), array('action' => 'admin_template_index', $data['RadiologyTemplate']['id'],'?'=>array('radiologyId'=>$data['Radiology']['id'])), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
		   			 					'alt'=> __('Edit', true))), array('action' => 'template', $data['RadiologyTemplate']['id'],'?'=>array('flag'=>'edit')), array('escape' => false ));					
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		   			 					'alt'=> __('Delete', true))), array('action' => 'admin_template_delete', $data['RadiologyTemplate']['id']), array('escape' => false ),"Are you sure you wish to delete this template?");					
		   					 							
		   ?>
		  </tr>
		  <?php endforeach;  ?>
		   <tr>
		       <TD colspan="8" align="center" class="table_format" >		    
							 <?php echo $this->Paginator->numbers( array('update'=>'#doctemp_content',    												
		    												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),'class' => 'paginator_links','escape'=>false)); ?>
							 <?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#doctemp_content',    												
		    												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
							 <?php echo $this->Paginator->next(__('Next »', true), array('update'=>'#doctemp_content',    												
		    												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
							 
							 <span class="paginator_links">
							 	<?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
							 </span>
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
		      
		      echo $this->Js->writeBuffer(); 	//please do not remove 
		  ?>
		  
		 </table>
	 </div>
</div>
<script>
			jQuery(document).ready(function(){
				var tempId= '<?php echo $this->params->pass[0];?>';
				if(tempId!=''){
				$('#addRadio').show();
				}else{
			   $('#addRadio').hide();
			    }
				//$('#radiology_id').val('');
				$('#selection').click(function(){		 	 
			 	    var  icd_text='' ;
					var icd_ids = $( '#Radiology', window.opener.document ).val();		 				 	 
			 		$("input:checked").each(function(index) {
			 			 if($(this).attr('name') != 'undefined'){    	
					        $( '#Radiology', window.opener.document ).val($( '#Radiology', window.opener.document ).val()+"\r\n"+$(this).val());
					    }
					});		 	
			 		window.close();
		 	     });
		 	
				// binds form submission and fields to the validation engine
				  jQuery("#RadiologyTemplatefrm").validationEngine();
					 
				 
				function ajaxPost(formname,updateId){ 
						 
				        $.ajax({
				            data:$("#"+formname).closest("form").serialize(), 
				            dataType:"html",
				            beforeSend:function(){
							    // this is where we append a loading image
							    $('#busy-indicator').show('fast');
							},				            
				            success:function (data, textStatus) {
				             	$('#busy-indicator').hide('slow');
				                $("#"+updateId).html(data);
				               
				            }, 
				            type:"post", 
				            url:"<?php echo $this->Html->url((array('controller'=>'Radiology_templates','action' => 'Radiology_template')));?>"
				        }); 
				}
				
				$('#addBtn').click(function(){
					$('#addRadio').show();
				})
				$('#submit').click(function(){
					var validatePerson = jQuery("#RadiologyTemplatefrm").validationEngine('validate'); 
				 	if(!validatePerson){
					 	return false;
					}else{
 						$('#addRadio').hide();
					}
				})
				$('#cancelBtn').click(function(){
 					$('#addRadio').hide();
				})

		
				 $('#radiology-filter').autocomplete({
						source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Radiology","name",'null','0','null', "admin" => false,"plugin"=>false)); ?>",
						setPlaceHolder : false,
						select: function(event,ui){	
						 $('#radiology_id').val(ui.item.id);
						},
						messages: {
				         noResults: '',
				         results: function() {},
					   },
					});
				 $("#searchBtn").hide();
				 $('#rad_name').autocomplete({
						source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Radiology","name",'null','0','null', "admin" => false,"plugin"=>false)); ?>",
						setPlaceHolder : false,
						select: function(event,ui){	
						 $("#searchBtn").show();
						 $('#rad_id').val(ui.item.id);
						 
						},
						messages: {
				         noResults: '',
				         results: function() {},
					   },
					});
			});	
</script>
				