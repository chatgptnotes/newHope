<?php echo $this->Html->script('jquery.autocomplete');//debug($queryString = $this->request->query;);
echo $this->Html->css('jquery.autocomplete.css');?>
<?php echo $this->Html->css(array('internal_style','jquery.autocomplete','validationEngine.jquery.css'));
echo $this->Html->script(array('jquery.validationEngine','/js/languages/jquery.validationEngine-en'));
echo $this->Html->script(array('jquery.blockUI','inline_msg.js'));?>
<div class="inner_title">
	<h3>
	 <?php 
		if($this->request->query['template_category_id']=='1')$title='Review Of System';
		elseif($this->request->query['template_category_id']=='2')$title='Physical Examination';
		elseif($this->request->query['template_category_id']=='3')$title='HPI';
		echo $title; ?>
	 </h3>
	<span> <div style="float:right;"> <?php $queryString = $this->request->query;
											$queryString['type']='master';
			echo $this->Html->link(__('Add', true),array('controller' => 'Templates', 'action' => 'addTemplateContent','?'=>$queryString, 'admin' => false), 
			array('escape' => false,'class'=>'blueBtn'));?>
	<?php
			//echo $this->Form->input(__('Add', true),array('type' => 'button','class'=>'blueBtn','id'=>'addCategory','label'=>false,'div'=>false));
			if(empty($patientId)){
			echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
			}
			else{
if(empty($controller)){
			echo $this->Html->link(__('Back', true),array('controller' => 'notes', 'action' =>$action,$patientId,$noteId), array('escape' => false,'class'=>'blueBtn'));
			}
			else{
echo $this->Html->link(__('Back', true),array('controller' => 'PatientForms', 'action' =>$action,$patientId,$noteId), array('escape' => false,'class'=>'blueBtn'));
}}
?>
<?php 
echo $this->Html->link(__('View/Edit Parent Category', true),array('controller' => 'Templates', 'action' => 'sortParentCategory','?'=>$queryString, 'admin' => false), 
			array('escape' => false,'class'=>'blueBtn','style'=>'margin:0 5px 0 5px;'));

echo $this->Html->link(__('Add Parent Category', true),array('controller' => 'Templates', 'action' => 'addParentCategory','?'=>$queryString, 'admin' => false),
		array('escape' => false,'class'=>'blueBtn'));
?>
			</div>
			</span>
</div>

<!-- show if come from Progress Note-->
						<?php echo $this->Form->input('',array('type'=>'hidden','id'=>'ros','value'=>$action));?>
						<!--  EOD-->
<?php 
if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"
	align="center">
	<tr>
		<td colspan="2" align="left"><?php 
		foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
     ?>
		</td>
	</tr>
</table>
<?php } ?>
<!-- 
<form name="templatecategoryfrm" id="templatecategoryfrm"
	action="<?php echo $this->Html->url(array("action" => "template_sub_category")); ?>"
	method="post">
	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="60%" align="center">
		<!-- <tr>
			<td class="form_lables"><?php //echo __('Template Category',true); ?><font
				color="red">*</font>
			</td>
			<td><?php  //echo $this->Form->input('TemplateSubCategories.template_category_id', array('options' => $category_option, 'empty' => 'Select', 'id' => 'template_category_id', 'label'=> false, 'div' => false, 'error' => false,'onChange'=>'javascript:category_onchange()','autocomplete'=> 'off','class' => 'class=validate[required,custom[mandatory-select]] textBoxExpnd')); ?>
			</td>
		</tr>   
		<tr>
			<td class="form_lables"><?php echo __('Parent Category',true); ?><font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->input('TemplateSubCategories.template_id',array('type'=>'select','id'=>'category_sub',
	  		'options'=>array($subCategory),'empty' => 'Select','label'=> false,'class' => 'class=validate[required,custom[mandatory-select]] textBoxExpnd' ));
					?>
			</td>
		</tr>
		<tr>
			<td class="form_lables"><?php echo __('Sub Category',true); ?> <font
				color="red">*</font>
			</td>
			<td><?php 
			echo $this->Form->textarea('TemplateSubCategories.sub_category', array('class' => 'validate[required,custom[customdescription]] textBoxExpnd', 'cols' => '35', 'rows' => '10', 'id' => 'sub_category', 'label'=> false, 'div' => false, 'error' => false));
			?>
			</td>
		</tr>
		<tr>
            <td></td>
			<td colspan="2" align="">
            <div style="margin-top:10px;">
            <input type="submit" value="Submit"
				class="blueBtn" id="submit">
                </div>
			</td>
		</tr>
	</table>
</form>

 -->
<!--Searching part -->
<?php echo $this->Form->create('',array('action'=>'template_sub_category','type'=>'get','id'=>'SearchForm'));?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" align="center" width="100%">
	<?php //debug($this->request->query);?>
	<tr class="row_title">
		<?php echo $this->Form->hidden('template_category_id',array('value'=>$this->params->query['template_category_id']));?>
		<?php if(!empty($this->params->query['template_id'])){
			echo $this->Form->hidden('template_id',array('value'=>$this->params->query['template_id']));
			}?>
		<td class="table_cell"><strong><?php echo __('Note Template', true); ?>
		</strong></td>
		<td class="table_cell"><?php //  echo $this->Form->input('template_category_id', array('empty'=>__('Select'),'options'=>$optionValues,'class' => 'textBoxExpnd','label'=>false)); ?>
			<?php echo $this->Form->input('TemplateSubCategories.note_template_id', array('value'=>$this->request->query['note_template_id'],'options' => $notesTemplate, 'empty' => 'Select', 'id' => 'template_category_id_search', 'label'=> false, 'div' => false, 'error' => false,'value'=>$this->params->query['note_template_id'])); ?>
		</td>
		<td class="table_cell"><strong><?php echo __('Parent Category', true); ?>
		</strong></td>
		<td class="table_cell"><?php    echo $this->Form->input('template_id', array('value'=>$this->request->query['template_id'],'empty'=>__('Select'),'options'=>$categoryName,'class' => 'textBoxExpnd','label'=>false)); ?>
			<?php //echo $this->Form->input('TemplateSubCategories.template_id',array('type'=>'select','id'=>'category_sub_search','options'=>$subCategory,'empty' => 'Select','label'=> false,'style'=>'width:175px;','class' => 'class=validate[required,custom[mandatory-select]] textBoxExpnd','value'=>$this->params->query['template_id'] ));?>
		</td>
		<td class="table_cell"><strong><?php echo __('Sub Category', true); ?>
		</strong></td>
		<td class="table_cell"><?php    echo $this->Form->input('sub_category', array('value'=>$this->request->query['sub_category'],'type'=>'text','id'=>'sub-category','class' => 'textBoxExpnd','label'=>false)); ?>
			<?php //echo $this->Form->input('TemplateSubCategories.template_id',array('type'=>'select','id'=>'category_sub_search','options'=>$subCategory,'empty' => 'Select','label'=> false,'style'=>'width:175px;','class' => 'class=validate[required,custom[mandatory-select]] textBoxExpnd','value'=>$this->params->query['template_id'] ));?>
		</td>
		<td class="table_cell"><strong><?php echo $this->Form->submit(__('Search'),array('id'=>'submit','class'=>'blueBtn','div'=>false,'label'=>false),array('alt'=>'Search','title'=>'Search'));?>
		</strong>
		</td>
		<?php if($this->params->query['action']!='hpiCall'){?>
		<td class="table_cell"><?php echo $this->Html->link(__('Reset'),array('controller'=>'Templates', 'action'=>'template_sub_category','?'=>array('template_category_id'=>$this->params->query['template_category_id']), 'admin' => false), array('id'=>'reset','label'=> false,'div' => false,'error' => false,'class'=>'blueBtn', 'style'=>'text-decoration:none' ));?>
		</td>
		<?php }?>
	</tr>
</table>
<?php echo $this->Form->end();?>
<!--Eof Searching  -->

<table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="100%">
			<tr class="row_title">
		<!-- 		<td class="table_cell"><strong><?php echo __('Template Category', true); ?>
				</strong></td> -->
				<td class="table_cell"><strong><?php echo __('Parent Category', true); ?>
				</strong></td>
				<td class="table_cell"><strong><?php echo __('Sub Category', true); ?>
				</strong></td>
				<td class="table_cell"><strong><?php echo __('Note Template', true); ?>
				</strong></td>
				<td class="table_cell"><strong><?php echo $this->Paginator->sort('TemplateSubCategories.sort_no',__('Sort Order', true)); ?>
				</strong></td>
				<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
				</td>
			</tr>
			<?php 
			
			$cnt =0;
			if(count($dataTemplateSub) > 0) {
				for($s=1;$s<=count($dataTemplateSub);$s++){
					$sortDrop[$s] = $s ;
				}
		       foreach($dataTemplateSub as $datatemp):
		       $cnt++;
		       ?>
			<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<!-- <td class="row_format"><?php echo $parentOption[$datatemp['TemplateSubCategories']['template_category_id']]; ?>
				</td> -->
				<td class="row_format"><?php echo $option[$datatemp['TemplateSubCategories']['template_id']]; ?>
				</td>
				<td class="row_format"><?php echo $datatemp['TemplateSubCategories']['sub_category']; ?>
				</td>
				<td class="row_format"><?php echo $datatemp['NoteTemplate']['template_name']; ?>
				</td>
				
				<td class="row_action" align="left">
			    <?php   
			   		$sortID = $datatemp['TemplateSubCategories']['id'] ;
			    	$sortVal = $sortOrder[$sortID]; //key from sort array 
			   		//echo $this->Form->input('sort_no',array('id'=>$sortID,'class'=>'sort-drop',
								//'options'=>$sortDrop,'empty'=>'','label'=>false,'div'=>false,'value'=>$datatemp['TemplateSubCategories']['sort_no']));  
			    	echo $this->Form->input('sort_no',array('id'=>$sortID,'class'=>'sort-drop validate[optional,custom[onlyNumber]]',
			    			'empty'=>'','label'=>false,'div'=>false,'value'=>$datatemp['TemplateSubCategories']['sort_no'],'onkeypress'=>"return isNumber(event)"));
				?>
				<span id="div_<?php echo $sortID ;?>" style="margin: 0px auto; float:right;"></span> 
			   </td>
				<td><?php 
		   			//echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
		   			// 					'alt'=> __('Edit', true))), array('action' => 'edit_sub_temp', $datatemp['TemplateSubCategories']['id']), array('escape' => false ));
		   			
					echo $this->Html->link('Add to other notes template', array('action' => 'addNotesTemplateContent',$datatemp['TemplateSubCategories']['template_category_id'],$datatemp['TemplateSubCategories']['id'],
						'?'=>$this->params->query), array('escape' => false ));
				
					echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
							'alt'=> __('Edit', true))), array('action' => 'editTemplateContent',$datatemp['TemplateSubCategories']['template_category_id'],$datatemp['TemplateSubCategories']['id'],'?'=>$queryString), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		   			 					'alt'=> __('Delete', true))), array('action' => 'sub_template_delete', $datatemp['TemplateSubCategories']['id']), array('escape' => false ),"Are you sure you wish to delete this template?");
			   ?>			
			</tr>
			<?php endforeach;  ?>
			<tr>
				<TD colspan="8" align="center" class="table_format"><?php 
				$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
				$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
				echo $this->Paginator->counter(array('class' => 'paginator_links'));
				echo $this->Paginator->prev(__('« Previous', true), array(/*'update'=>'#doctemp_content',*/    												
						'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
					
					<?php 
					echo $this->Paginator->numbers(); ?>
					
					<?php echo $this->Paginator->next(__('Next »', true), array(/*'update'=>'#doctemp_content',*/    												
							'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>

					<span class="paginator_links"> 
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

<script>

	$(document).ready(function(){
		 $("#sub-category").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TemplateSubCategories","sub_category",'null','null','no',"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			}); 
	});
	function category_onchange(){
		var id = $('#template_category_id').val();
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Templates", "action" => "category_onchange","admin" => false)); ?>";
		$.ajax({
		type: 'POST',
		url: ajaxUrl+"/"+id,
		data: '',
		dataType: 'html',
		success: function(data){
		  	data= $.parseJSON(data);
		  	if(data !=''){
		  		$("#category_sub option").remove();
		  		//$("#save").removeAttr('disabled');
			  	$.each(data, function(val, text) {
				  	if(text)
				    $("#category_sub").append( "<option value='"+val+"'>"+text+"</option>" );
				}); 
		  	}else{  
		  		$("#category_sub option").remove();
		  		//$("#save").attr('disabled','disabled');
			  	//alert("Data not available");
		  	} 
		  	
		  	    
		},
	
		error: function(message){
		alert("Internal Error Occured. Unable to set data.");
		} });
	
		return false;
	}



	function category_onchange_search(){
		var id = $('#template_category_id_search').val();
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Templates", "action" => "category_onchange","admin" => false)); ?>";
		$.ajax({
		type: 'POST',
		url: ajaxUrl+"/"+id,
		data: '',
		dataType: 'html',
		success: function(data){
		  	data= $.parseJSON(data);
		  	if(data !=''){
		  		$("#category_sub_search option").remove();
		  		//$("#save").removeAttr('disabled');
			  	$.each(data, function(val, text) {
				  	if(text)
				    $("#category_sub_search").append( "<option value='"+val+"'>"+text+"</option>" );
				}); 
		  	}else{  
		  		$("#category_sub_search option").remove();
		  		//$("#save").attr('disabled','disabled');
			  //	alert("Data not available");
		  	} 
		  	
		  	    
		},
	
		error: function(message){
		alert("Internal Error Occured. Unable to set data.");
		} });
	
		return false;
		}
		jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
			jQuery("#templatecategoryfrm").validationEngine();
	
			if($('#ros').val()=='reviewOfSystem'){
				$('#template_category_id').val('1');
				category_onchange();
			}
			if($('#ros').val()=='systemicExamination'){
				$('#template_category_id').val('2');
				category_onchange();
			}
			if($('#ros').val()=='hpiCall'){
				$('#template_category_id').val('3');
				category_onchange();
			}
		});
	
		$(".sort-drop").live("blur",function(){
			 obj = $(this); 
		 	 $(obj).attr("src",'<?php echo $this->Html->url("/img/ajax-loader.gif");?>');
		 	 var id = $(obj).attr('id');
		 	 $("#div_"+id).html("<img src='<?php echo $this->Html->url("/img/ajax-loader.gif");?>'>") ;
		 	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Templates", "action" => "sort","admin" => false)); ?>";
			 $.ajax({
				  type: "POST",
				  url: ajaxUrl+"/"+id,
				  data: "sort_order="+obj.val(),
	
				  success: function(data){
					  	if(data){
						    inlineMsg(id,'Done');
						    $("#div_"+id).html('');
					}
				  
				 }
		 });
	
	});
		function isNumber(evt) {
		    evt = (evt) ? evt : window.event;
		    var charCode = (evt.which) ? evt.which : evt.keyCode;
		    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		        return false;
		    }
		    return true;
		}
</script>
