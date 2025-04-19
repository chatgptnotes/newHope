<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
?>
<div id="doctemp_content">
	<?php if(!empty($errors)) {?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"
		align="center">
		<tr>
			<td colspan="2" align="left" class="error"><?php foreach($errors as $errorsval){
				echo $errorsval[0];
				echo "<br />";
			} ?></td>
		</tr>
	</table>
	<?php } ?>
	<div id="docTemplate">
		<div class="inner_title">
			<h3>
				<?php echo __('Notes Template', true); ?>
			</h3>
			<span> <?php
			 
			echo $this->Html->link(__('Add', true),"javascript:void(0);", array('escape' => false,'class'=>'blueBtn','id'=>'add-note'));
			 
			echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
			?>
			</span>
		</div>
		<?php echo $this->Form->create('Note',array('action'=>'admin_template_add','id'=>'NoteTemplatefrm', 'inputDefaults' => array('label' => false,'div' => false)));
			  echo $this->Form->hidden('NoteTemplate.id',array('id'=>'note-id'));
			  echo $this->Form->hidden('NoteTemplate.template_type', array('value'=>'all'));
			  if($action=='edit') $display  = '' ; 
			  else $display = 'none';
			  ?>
			  
		<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="500px" align="right" style="display:<?php echo $display; ?>;" id="note-add-form"> 
			<tr>
				<td><label style="width: 99px;"><?php echo __('Template Name');?>:<font
						color="red">*</font> </label>
				</td>
				<td><?php echo $this->Form->input('NoteTemplate.template_name', array('style'=>'width:157px;','type'=>'text','class' => 'validate[required,custom[mandatory-enter]]','id' => 'customdescription')); ?>
				</td>
			</tr>
			<tr>
				<td><label style="width: 99px;"><?php echo __('Search Keyword');?>:<font
						color="red">*</font> </label>
				</td>
				<td><?php echo $this->Form->textarea('NoteTemplate.search_keywords', array('id' => 'search_keywords')); ?>
				<br /> <i>Add comma(,) separated keywords</i>
				</td>
			</tr>
			<tr>
				<td><label><?php echo __("Specialty");?>:<font color="red">*</font>
				</label>
				</td>
				<td><?php echo $this->Form->input('NoteTemplate.department_id', array('empty'=>__('Please Select'),'options'=>$departments,'style'=>'width:172px;','class' => 'validate[required,custom[mandatory-select]]','id' => 'department_id','label'=> false)); ?>
				</td> 
			</tr>
			<tr>
				<td class="row_format" align="right" colspan="2"><?php
				echo $this->Html->link('Cancel','javascript:void(0);',array('escape' => false,'id'=>'note-cancel','class'=>'blueBtn'));
				echo $this->Form->submit(__('Submit'), array('label'=> false,'div' => false,'error' => false,'class'=>'blueBtn' ));
				?></td>
			</tr>
		</table>
		<?php echo $this->Form->end();?>
		<?php echo $this->Form->create('',array('controller'=>'Notes','action'=>'admin_index','id'=>'NoteTemplatefrmsearch', 'inputDefaults' => array('label' => false,'div' => false)));?>
		<table border="0" cellpadding="0" cellspacing="0" width="500px;"   style="padding-left: 19px; padding-right: 20px;">
			<tbody>
				<tr class="row_title"> 
					<td width="30%" class=""
						style="  border: none !important; font-size: 13px;"><?php echo __('Template Name :') ?>
					</td>
					<td width="30%" style="border: none !important;"><?php  echo $this->Form->input('NoteTemplate.template_name', array('type'=>'text','id' => 'template_name_search', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'style'=>'width:150px;'));?>
					</td>
					<td width="40%"
						style="border: none !important;"><?php echo $this->Form->submit(__('Search'),array('label'=> false, 'name'=>'button','div' => false, 'error' => false,'class'=>'blueBtn','title'=>'Search','style'=>'margin-left:10px;'));	?>
						<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'admin_index'),array('escape'=>false, 'title' => 'refresh'));?>
					</td>
				</tr>
			</tbody>
		</table>
		<?php echo $this->Form->end();?>
		<table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="100%">
			<tr class="row_title">
				<td class="table_cell"><strong><?php echo $this->Paginator->sort('NoteTemplate.template_name', __('Template Name', true)); ?>
				</strong>
				</td>
				<td class="table_cell"><strong><?php echo "Keywords" ; ?>
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
				<td class="row_format"><?php echo $doctortemp['NoteTemplate']['template_name']; ?> 	</td>
				<td class="row_format"><?php echo $doctortemp['NoteTemplate']['search_keywords']; ?> 	</td>
				<td><?php
				echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View', true),
		   			 					'alt'=> __('View', true))), array('action' => 'admin_template_index', $doctortemp['NoteTemplate']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
		   			 					'alt'=> __('Edit', true))), array('action' => 'index', $doctortemp['NoteTemplate']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		   			 					'alt'=> __('Delete', true))), array('action' => 'admin_template_delete', $doctortemp['NoteTemplate']['id']), array('escape' => false ),"Are you sure you wish to delete this template?");
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
			<?php }
			echo $this->Js->writeBuffer(); 	//please do not remove
			?>
		</table>
	</div>
</div>
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
 	jQuery("#NoteTemplatefrm").validationEngine();						 
				 
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
$(document).ready(function(){	
	$("#template_name_search").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","NoteTemplate","template_name",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
		width: 250,
		selectFirst: true
	});	  

	$("#add-note").click(function(){
		//$('#NoteTemplatefrm').trigger("reset"); 
		//$('form#NoteTemplatefrm')[0].reset();
		$( "#NoteTemplatefrm input[type=text],input[type=hidden],select,textarea" ).each(function( index ) {
			$(this).val('');
		});
		//document.getElementById('NoteTemplatefrm').reset()
		$("#note-add-form").show('slow') ;
	});

	$("#note-cancel").click(function(){
		$( "#NoteTemplatefrm input[type=text],input[type=hidden],select,textarea" ).each(function( index ) { //reset current form
			$(this).val('');
		});
		$("#note-add-form").hide('slow') ;
	});
});
</script>
