<?php echo $this->Html->css(array('validationEngine.jquery.css'));
echo $this->Html->script(array('jquery.blockUI','inline_msg.js'));?>

<div class="inner_title">
	<h3>
		<?php echo __('View/Edit Parent Category', true); ?>
	 </h3>
	<span> <div style="float:right;"> <?php $queryString = $this->request->query;
											$queryString['type']='master';
			echo $this->Html->link(__('Back', true),array('controller' => 'Templates', 'action' => 'template_sub_category','?'=>$queryString), array('escape' => false,'class'=>'blueBtn'));
			?>
			</div>
			</span>
</div>
<?php 
		echo $this->Form->create('sorttemplatefrm',array('id'=>'sorttemplatefrm','url'=>array('controller'=>'Templates',"action" => "sortParentCategory"),'inputDefaults'=>array('div'=>false,'label'=>false,)));
?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
			width="100%" >
			<tr class="row_title">
				<td class="table_cell"><strong><?php echo __('Parent Category', true); ?>
				</strong></td>
				<td class="table_cell"><strong><?php echo $this->Paginator->sort('Template.sort_no',__('Sort', true)); ?>
				</strong></td>
				<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
				</td>
			</tr>
			<?php 
			$cnt =0;
			if(count($dataTemplet) > 0) {
				for($s=1;$s<=count($dataTemplet);$s++){
					$sortDrop[$s] = $s ;
				}
		       foreach($dataTemplet as $dataTemp){
		       $cnt++;
		       ?>
			<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
				<td class="row_format"><?php echo ucfirst($dataTemp['Template']['category_name']);?></td>
				<td class="row_action" align="left">
			    <?php   
			   		$sortID = $dataTemp['Template']['id'] ;
			    	echo $this->Form->input('sort_no',array('id'=>$sortID,'class'=>'sort-drop validate[optional,custom[onlyNumber]]',
								'empty'=>'','label'=>false,'div'=>false,'value'=>$dataTemp['Template']['sort_order'],'onkeypress'=>"return isNumber(event)"));  

				?>
				<span id="div_<?php echo $sortID ;?>" style="margin: 0px auto; float:right;"></span> 
			   </td>
			   <td>
			   <?php echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
							'alt'=> __('Edit', true))), array('action' => 'editParentTemplate',$dataTemp['Template']['id'],$dataTemp['Template']['template_category_id']), array('escape' => false ));
			   echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		   			 					'alt'=> __('Delete', true))), array('controller'=>'Templates','action' => 'templateDelete',$dataTemp['Template']['id']), array('escape' => false ),"Are you sure ?");?>
			   </td>
			
			</tr>
			<?php }?>
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
			<?php }else {
		  	?>
			<tr>
				<td colspan="8" align="center"><?php echo __('No record found', true); ?>.</td>
			</tr>
			<?php }?>
</table>

<script>
	jQuery(document).ready(function(){
	
		$("#sorttemplatefrm").validationEngine();
	});
	
	$(".sort-drop").live("blur",function(){
		 obj = $(this); 
		 $(obj).attr("src",'<?php echo $this->Html->url("/img/ajax-loader.gif");?>');
		 var id = $(obj).attr('id');
		// alert(id);
		 $("#div_"+id).html("<img src='<?php echo $this->Html->url("/img/ajax-loader.gif");?>'>") ;
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Templates", "action" => "sortParent","admin" => false)); ?>";
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