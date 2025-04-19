<style>
    
    label {
    color: #000 !important;
    float: left;
    font-size: 13px;
    margin-right: 10px;
    padding-top: 7px;
    text-align: left !important;;
    width: 97px;
}
.table_format td {
    font-size: 13px;
}
</style>
<div id="doctemp_content">
	<?php
	if(!empty($errors)) {
?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"
		align="center">
		<tr>
			<td colspan="2" align="left" class="error"><?php 
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
			<h3>
				<?php echo __('Histo Template', true); ?>
			</h3>
			<span> <?php
			echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
			?>
			</span>
		</div>
		<?php 	echo $this->Form->create('DoctorTemplate',array('action'=>'template_add_histo','id'=>'doctortemplatefrm', 'inputDefaults' => array('label' => false,'div' => false)));
		echo $this->Form->hidden('id');
		?>
		<table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="500px">

			<tr>
				<td><label><?php echo __('Template Type');?>:<font
				color="red">*</font></label>
				</td>
				<td><?php 
				$templateType= array('complaints'=>'Presenting Complaints','lab-reports'=>'Lab Reports','examine'=>'Examination','diagnosis'=>'Diagnosis','surgery'=>'Surgery','care_plan'=>'Care Plan','histo_pathology'=>'Histo Pathology' );
					
					
						     				echo $this->Form->input('template_type', array('style'=>'width:400px','readonly'=>'readonly','selected'=>'histo_pathology','options'=>$templateType,'empty'=>__('Please select'),'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'template_type')); ?>
				</td>
			</tr>
                         
                       <tr class="histoTemplateSubCategories">
					<td><label><?php echo __('Histo Category');?>:<font
				color="red">*</font></label>
				</td>
				<td><?php echo $this->Form->input('department_id', array('style'=>'width:400px','empty'=>'Please Select','options'=>$histoCategoriesData,'type'=>'select','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd')); ?>
				</td>
			</tr>
                        
			<tr>
					<td><label style="width: 99px;"><span id="tempalteNameText"><?php echo __('Template Name');?>:</span><font
				color="red">*</font></label>
				</td>
				<td><?php echo $this->Form->input('template_name', array('style'=>'width:400px','type'=>'text','class' => 'validate[required,custom[mandatory-enter]] textBoxExpnd','id' => 'customdescription')); ?>
				</td>
			</tr>
                        <tr>
						  <td><label><?php echo __('Template Text');?>:<font
				color="red">*</font></label></td>
						  <td>						  		
						     		<?php echo $this->Form->textarea('DoctorTemplateText.template_text', array('style'=>'width:389px','rows'=>'10','columns'=>'6','type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'customdescription')); ?>
						  </td>
						 			 
						 
						 </tr>
			
                        <tr>
			
			
			
			<tr id="generalSpeciality" style="dispaly:block">

				
				<td class="row_format" align="right" colspan="4"><?php
				echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
				?></td>
			</tr>
			<!-- 
			<tr id="histoSpeciality" style="display: none">

				<td><label><?php echo __("Histo Section");?>:<font
				color="red">*</font></label>

				</td>
				<td><?php echo $this->Form->input('department_id', array('empty'=>__('Please Select'),'options'=>$histoSections,'style'=>'width:175px;','class' => 'validate[required,custom[mandatory-select]]','id' => 'department_id','label'=> false)); ?>
				</td>
				<td class="row_format" align="right" colspan="2"><?php
				echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
				?></td>
			</tr>
			 -->




		</table>
		<?php echo $this->Form->end();?>

		<table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="100%">

			<tr class="row_title">
				<!-- <td class="table_cell"><strong><?php echo $this->Paginator->sort('DoctorTemplate.id', __('Sr.No.', true)); ?></strong></td>
		    -->



				<td class="table_cell"><strong><?php echo $this->Paginator->sort('DoctorTemplate.template_type', __('Template Type', true)); ?>

				</strong>
				</td>
				<td class="table_cell"><strong><?php echo $this->Paginator->sort('DoctorTemplate.template_name', __('Template Name', true)); ?>

				</strong>
				</td>
				<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>



				</td>
			</tr>
			<?php 
			$cnt =0;
			if(count($data) > 0) {
		       foreach($data as $doctortemp):
		       $cnt++;
		       ?>
			<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
				<!-- <td class="row_format"><?php echo $doctortemp['DoctorTemplate']['id']; ?> </td>
		    -->



				<td class="row_format"><?php echo $templateType[$doctortemp['DoctorTemplate']['template_type']]; ?>
				</td>
				<td class="row_format"><?php echo $doctortemp['DoctorTemplate']['template_name']; ?>
				</td>
				<td><?php
				//echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('Histo Template View', true),
		   			 					//'alt'=> __('View Template Text', true))), array('action' => 'template_histo', $doctortemp['DoctorTemplate']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Histo Template Edit', true),
		   			 					'alt'=> __('Edit', true))), array('action' => 'histo', $doctortemp['DoctorTemplate']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Histo Template Delete', true),
		   			 					'alt'=> __('Delete', true))), array('action' => 'template_delete_histo', $doctortemp['DoctorTemplate']['id']), array('escape' => false ),"Are you sure you wish to delete this template?");

		   ?>
			
			</tr>
			<?php endforeach;  ?>
			<tr>
				<TD colspan="8" align="center" class="table_format"><?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#doctemp_content',    												
						'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
					<?php echo $this->Paginator->next(__('Next »', true), array('update'=>'#doctemp_content',    												
							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>

					<span class="paginator_links"> <?php echo $this->Paginator->counter(array('class' => 'paginator_links')); echo $this->Paginator->numbers();?>
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
$(document).on("keydown",".histopath_tests",function() {
   $(this).autocomplete({
		 source: "<?php echo $this->Html->url(array("controller" => "App", "action" => "advance_autocomplete","Laboratory","name",'null',"null","null","lab_type=2","admin" => false,"plugin"=>false)); ?>" ,
		 minLength: 1,
		 select: function( event, ui ) {
			 var id = ui.item.id;
			 $('#histoSpeciality').show();
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});

    $(this).autocomplete("search");
});
			jQuery(document).ready(function(){
				$('#template_type').click(function(){
					var selectedTemlateType = $(this).val();
					if(selectedTemlateType == 'histo_pathology'){
						$('#generalSpeciality').hide();
						$(".histoTemplateSubCategories").show();
					}else{
						$('#generalSpeciality').show();
						$(".histoTemplateSubCategories").hide();
					}
				});

				
				
				
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
		 	
				// binds form submission and fields to the validation engine
				  jQuery("#doctortemplatefrm").validationEngine();
					 
				 
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
