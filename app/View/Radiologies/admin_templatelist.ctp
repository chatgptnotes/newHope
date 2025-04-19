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
			<h3><?php echo __('Radiology Templates', true); ?></h3>
			<span>
<?php
 echo $this->Html->link(__('Back', true),array('action' => 'add', $radiology_id), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
		</div>
		<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">		 
				
		   <tr class="row_title">
		   <!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('RadiologyTemplate.id', __('Id', true)); ?></strong></td>
		    --><td class="table_cell"><strong><?php echo $this->Paginator->sort('Radiology.name', __('Test', true)); ?></strong></td>
		   <td class="table_cell"><strong><?php echo $this->Paginator->sort('RadiologyTemplate.template_name', __('Template Name', true)); ?></strong></td> 
		   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
		  </tr>
		  <?php 
		      $cnt =0;
		       
		      if(count($data) > 0) {
		       foreach($data as $Radiologytemp):
		       $cnt++;
		  ?>
		   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		   <!-- <td class="row_format"><?php echo $Radiologytemp['RadiologyTemplate']['id']; ?> </td>
		    --><td class="row_format"><?php echo $Radiologytemp['Radiology']['name']; ?> </td>
		   <td class="row_format"><?php echo $Radiologytemp['RadiologyTemplate']['template_name']; ?> </td>
		   <td>
		   <?php
		   			echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View', true),
		   			 					'alt'=> __('View Template Text', true))), array('action' => 'admin_template_index', $Radiologytemp['RadiologyTemplate']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
		   			 					'alt'=> __('Edit', true))), array('action' => 'template', $Radiologytemp['RadiologyTemplate']['id']), array('escape' => false ));					
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		   			 					'alt'=> __('Delete', true))), array('action' => 'admin_template_delete', $Radiologytemp['RadiologyTemplate']['id']), array('escape' => false ),"Are you sure you wish to delete this template?");					
		   					 							
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
			});	
</script>
				