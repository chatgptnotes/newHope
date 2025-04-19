<?php	echo $this->Html->css(array('internal_style','jquery.autocomplete','validationEngine.jquery.css'));
					echo $this->Html->script(array('jquery-1.5.1.min','jquery.autocomplete','jquery.validationEngine','/js/languages/jquery.validationEngine-en'));
			?>
 
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
		
 
<?php echo $this->Form->create('DoctorTemplate',array('action'=>'edit','id'=>'doctortemplatefrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false)));?>	
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="500px" >
 <tr>
  <td><label><?php echo __('Description');?>:</label></td>
  <td>
     <?php 
     		echo $this->Form->hidden('id', array()); 
      		echo $this->Form->textarea('description', array('class' => 'validate[required,custom[customdescription]]','id' => 'customdescription', 'label'=> false, 'div' => false,'error' => false ,'rows'=>'6','style'=>'width:500px')); ?>
  </td>
 </tr>
 <tr class="row_title">				 
  <td class="row_format" align="right" colspan="2">
   <?php
	echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
        echo $this->Js->writeBuffer(); 	
   ?>
  </td>
 </tr>	
</table>	
 <?php echo $this->Form->end();?>	
 <table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
			<tr>
					<td align="right" colspan="3">
						<?php 
					    		 echo    $this->Form->button(__('Apply selection'), array('type'=>'button','id' => 'selection','label'=> false, 'div' => false, 'error' => false,'class'=>'blueBtn'));
					    	?>
					</td>
				</tr>
				
		   <tr class="row_title">
		   <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Id', true)); ?></strong></td>
		   <td class="table_cell"><strong><?php echo $this->Paginator->sort('template_type', __('Template Type', true)); ?></strong></td>
		   <td class="table_cell"><strong><?php echo $this->Paginator->sort('description', __('Description', true)); ?></strong></td>
		   <td class="table_cell"><strong><?php echo __('Action', true); ?></strong></td>
		  </tr>
		  <?php 
		      $cnt =0;
		      if(count($data) > 0) {
		       foreach($data as $doctortemp):
		       $cnt++;
		  ?>
		   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		   <td class="row_format"><?php echo $this->Form->checkbox('',array('name'=>$doctortemp['DoctorTemplate']['id'],'value'=>$doctortemp['DoctorTemplate']['description'])); ?></td>
		   <td class="row_format"><?php echo $doctortemp['DoctorTemplate']['template_type']; ?> </td>
		   <td class="row_format"><?php echo $doctortemp['DoctorTemplate']['description']; ?> </td>
		   <td>
		   <?php
		   			echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Doctor Template Edit', true), 'alt'=> __('Doctor Template Edit', true))), array('action' => 'edit', $doctortemp['DoctorTemplate']['id']), array('escape' => false,'update'=>'#doctemp_content','method'=>'post','complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))));
					echo $this->Js->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Doctor Template Delete', true), 'alt'=> __('Doctor Template Delete', true))), array('action' => 'delete', $doctortemp['DoctorTemplate']['id']), array('update'=>'#doctemp_content','method'=>'post','escape' => false,'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'confirm'=>"Are you sure you wish to delete this template?"));
		   ?>
		  </tr>
		  <?php endforeach;  ?>
		   <tr>
		       <TD colspan="8" align="center" class="table_format" >		    
							 
							 <?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#doctemp_content',    												
		    												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
							 <?php echo $this->Paginator->next(__('Next »', true), array('update'=>'#doctemp_content',    												
		    												'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
							 
							 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); 					 
							 
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
		      
		      echo $this->Js->writeBuffer(); 	//please do not remove 
		  ?>
		  
		 </table>
</div>
 
<script>
			jQuery(document).ready(function(){
				$('#selection').click(function(){		 	 
			 	    var  icd_text='' ;
					var icd_ids = $( '#diagnosis', window.opener.document ).val();		 				 	 
			 		$("input:checked").each(function(index) {
			 			 if($(this).attr('name') != 'undefined'){    	
					        $( '#diagnosis', window.opener.document ).val($( '#diagnosis', window.opener.document ).val()+"<br>"+$(this).val());
					    }
					});		 	
			 		window.close();
		 	     });
		 	
				// binds form submission and fields to the validation engine
				  
					jQuery("#doctortemplatefrm").submit(function(){
						var returnVal = jQuery("#doctortemplatefrm").validationEngine('validate');						 
						if(returnVal){					 
					 		ajaxPost('doctortemplatefrm','doctemp_content');
					 	}
					});
				 
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
				            url:"<?php echo $this->Html->url((array('controller'=>'doctor_templates','action' => 'doctor_template')));?>"
				        }); 
				}
			});	
</script>
				