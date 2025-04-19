<?php 
  	echo $this->Html->script('jquery.autocomplete');
  	echo $this->Html->css('jquery.autocomplete.css');
?>

<div class="inner_title">
		<h3>
			<?php echo __('Order Sets', true); ?>
		</h3>
		<span> <?php if(!empty($patientIdNew)){
		echo $this->Html->link(__('Back', true),array('controller' => 'Notes', 'action' => 'clinicalNote',$patientIdNew,$appointmentIdNew,$noteIdNew,'admin'=>false), array('escape' => false,'class'=>'blueBtn'));
		}else{
		echo $this->Html->link(__('Back', true),array('controller' => 'Users', 'action' => 'menu', '?' => array('type'=>'master'),'admin'=>true), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px'));
		}
		?>
		</span>
	</div>
	<div id="docTemplate">
	<?php echo $this->Form->create('',array('url'=>array('controller'=>'MultipleOrderSets','action'=>'save_orderset','admin'=>false),'type' => 'post','id'=>'OrdersetMasterFrm','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false,
																								        'legend'=>false,
																								        'fieldset'=>false
																								    )
			));
		echo $this->Form->hidden('OrdersetMaster.id',array('id'=>'OrdersetMaster_id','value'=>$this->request->data['OrdersetMaster']['id']));
//echo $this->Form->hidden('OrdersetCategoryMapping.id',array('value'=>''));	
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
			<td valign="top" width="15%" colspan="2"><?php echo $this->Html->link(__('Order Category', true),array('controller' => 'OrderCategories', 'action' => 'index','admin'=>true), array('escape' => false,'style'=>'text-decoration:underline;color:#11556f;','target'=>'_blank'));?>
			</td>
	</tr>
	<tr>
	<td colspan="4" valign="top" width="10%">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid; background: none repeat scroll 0 0 #8A9C9C;
    color: #FFFFFF !important; display: block;
    float: left;
    margin: 0 1px 0 0;
    padding: 8px 17px 6px;
    text-decoration: none;">
					
			<?php $r=1;
							foreach($getOrderCategoryData as $getOrderCategoryDatas){?>				
							<tr>
							<td style="font-size:14px;color:#11556f;"><li><strong><?php echo $this->Html->link($getOrderCategoryDatas['OrderCategory']['order_description'], 'javascript:void(0)', array('title'=>'Click here to .'.$getOrderCategoryDatas['OrderCategory']['order_description'],'alt'=>$getOrderCategoryDatas['OrderCategory']['order_description'],'class'=>'orderdescription clreffect','id'=>$getOrderCategoryDatas['OrderCategory']['id'],'escape' => false,'style'=>"cursor:pointer;color: #FFFFFF !important;",'value'=>$getOrderCategoryDatas['OrderCategory']['order_description']));
									?></strong></li></td></tr>&nbsp;&nbsp;&nbsp;
							<?php $r++; }											
									//echo $this->Form->hidden('OrdersetMaster.ordercategory_id',array('id'=>'ordercategory_id'));
								?>
		
			
			</table>
			
			</td>		
			<td valign="top" width="90%">
	
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_format">
		<tr>
			<td valign="top" width="15%"><?php echo __('Order Set Name');?>:<font color="red">*</font>
			</td>
			<td  valign="top" width="10%"><?php	
			$readOnly = ($this->request->data['OrdersetMaster']['id']) ? true : false;			
				echo $this->Form->input('OrdersetMaster.name', array('style'=>'width:157px;','class' => 'validate[required,custom[mandatory-enter],ajax[ajaxOrdersetNameCall]] ','id' => 'name','readonly'=>$readOnly)); ?>
			</td>	
			<td valign="top" width="75%"><input type="submit" value="Submit" class="blueBtn" id="Submit"/>
			</td>
			</tr>
			
			<?php $i=0;
					foreach($getOrderCategoryData as $getOrderCategoryDataShowDiff){
					 $OrderNameRemoveSp = str_replace(' ', '', $getOrderCategoryDataShowDiff['OrderCategory']['order_description']);?>				
			<tr>
			<td></td>
			<td></td>
			<td id="<?php echo $OrderNameRemoveSp; ?>_ajax" class="diffshowBlock" style="display:none" width="80%" valign="top"></td>
			</tr>
			<?php //echo $this->Form->hidden('',array('id'=>'ordercategory'.$OrderNameRemoveSp.'_id'.$i,'name'=>"ordercategory".$OrderNameRemoveSp."_id[]",'class'=>'ordercategory'.$OrderNameRemoveSp.'_Cls'));
				echo $this->Form->hidden('',array('id'=>'ordercategory'.$OrderNameRemoveSp.'id','name'=>"ordercategory_id[]",'class'=>'ordercategory'.$OrderNameRemoveSp.'_Cls1'));
				$i++;
				}	?>		
			</table>
		
			</td>
			</tr>					
	</table>
<?php echo $this->Form->end();?>		
<?php echo $this->Form->create('',array('action'=>'admin_index','type'=>'get'));?>	
<table border="0" class=""  cellpadding="0" cellspacing="0" width="465px" align="center">
	<tbody>				    			 				    
		<tr class="row_title">				 		
			<td><?php echo __('Order Set Name') ?> :</td>		
			<td>											 
		    	<?php 
		    		 echo    $this->Form->input('ordersetname', array('id' => 'ordersetname', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td> 
		 	<td align="right">
				<?php
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
							
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>
 </div>
	<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
		<tr class="row_title">
			<td class="table_cell"><strong><?php echo $this->Paginator->sort('OrdersetMaster.name', __('Order Set Name', true)); ?>
			</strong></td>		
			<td class="table_cell"><strong><?php echo __('Action', true); ?> </strong>
			</td>
		</tr>
		<?php 
		$cnt =0;
		if(count($dataTest) > 0) {
		       foreach($dataTest as $ordersetData):
		       $cnt++;
		       ?>
		<tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td class="row_format"><?php echo $ordersetData['OrdersetMaster']['name']; ?>
			</td>
			<!-- <td class="row_format"><?php echo substr($ordersetData['OrdersetMaster']['phrase_text'],0,50); ?>
			</td>-->
			<td><?php
			echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title'=> __('View', true),
		   			 					'alt'=> __('View', true))), array('action' => 'admin_template_index', $ordersetData['OrdersetMaster']['id']), array('escape' => false ));
		   			echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title'=> __('Edit', true),
		   			 					'alt'=> __('Edit', true))), array('controller'=>'MultipleOrderSets', $ordersetData['OrdersetMaster']['id'],'admin'=>true), array('escape' => false));
		   			echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title'=> __('Delete', true),
		   			 					'alt'=> __('Delete', true))), array('action' => 'order_delete', $ordersetData['OrdersetMaster']['id'],'admin'=>true), array('escape' => false ),"Are you sure you wish to delete this Order?");

		   ?>
		
		</tr>
		<?php endforeach;  ?>
			<?php /*$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column		
			$this->Paginator->options(array('url' =>array("?"=>$queryStr)));*/?>
		<tr>
			<TD colspan="8" align="center" class="table_format"><?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#docTemplate',    												
					'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), array('update'=>'#docTemplate',    												
						'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
		    												'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false))), null, array('class' => 'paginator_links')); ?>

				<span class="paginator_links"> <?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			</span><?php echo $this->Paginator->numbers(array('update'=>'#docTemplate'));
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

		   // echo $this->Js->writeBuffer(); 	//please do not remove
		      ?>

	</table>
		
	<script>	
	
	jQuery(document).ready(function(){
		var ordersetMasterId=$('#OrdersetMaster_id').val();
		if(ordersetMasterId!=""){
		jQuery("#name").removeClass('validate[required,custom[mandatory-enter],ajax[ajaxSmartPhraseCall]]');
		}
		jQuery("#OrdersetMasterFrm").validationEngine();		
		
		$('.orderdescription').click(function(){		
			var currentId = $(this).attr('id') ;
			var currenttitle = $('#'+currentId).attr('title') ;
			var currentAlt = $('#'+currentId).attr('alt') ;
		
			splitedId=currenttitle.split('.');
			IDTitle=splitedId['1'];			
			
			var ordersetMasterId=$('#OrdersetMaster_id').val();			
			
			if(IDTitle==currentAlt){	
			currentAlt=currentAlt.replace(" ", "");
			var currentName = $('.diffshowBlock').attr('id') ;			
				$('#'+currentAlt+'_ajax').show();				
				if(ordersetMasterId!==''){
					ajaxDefaultList(currentId,currentAlt,ordersetMasterId);
				}else{					
					ajaxDefaultList(currentId,currentAlt);
				}			
				//$('.ordercategory'+currentAlt+'_Cls').val(currentId);
			
				$('#ordercategory'+currentAlt+'id').val(currentId);
				$("#"+currentId).attr('style','color:#11556f !important');
			}else{
				$('#ordercategory'+currentAlt+'id').val('');
			}
			
		});
		  $("#ordersetname").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","OrdersetMaster","name","admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true,
				
			});		 
	
	});
	 function ajaxDefaultList(orderCategoryId,currentAlt,ordersetMasterId){
		   var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "ajaxDefaultList","admin" => false)); ?>";
			$.ajax({
		    	beforeSend : function() {
		    		$('#busy-indicator').show('fast');
		    	},
		   	type: 'POST',
		    url: ajaxUrl+'/'+orderCategoryId+'/'+ordersetMasterId,		
		  	dataType: 'html',
			  	success: function(data){			  	
				 	if(data!=''){
				   		$('#busy-indicator').hide('fast');
				   		var currentName = $('.diffshowBlock').attr('id') ;						
				   		$('#'+currentAlt+'_ajax').html(data);					   		
				  	}	
			 	},
			});
		  }
	 	
	
	
		$(document).on('click','.removeRow', function() { 	 
			if(confirm("Do you really want to delete this record?")){
				currentId=$(this).attr('id'); 			
				splitedId=currentId.split('_');
				var splitedIdForCond=currentId.split('Row');
				NameForCategry=splitedIdForCond['0'];				
				ID=splitedId['1'];	
				var setToCondId=$('#OrderSubcategory'+NameForCategry+'_id'+ID).val();	
				if(setToCondId)deleteAllCategory(setToCondId);
				$("#"+NameForCategry+"Group"+ID).remove();		
			}else{
				return false;
			}			
		});
		
		$(document).on('click','.HideCtegoryData', function() { 
			currentId=$(this).attr('id'); 			
			splitedId=currentId.split('_');			
			$('#'+splitedId['0']+'Group').hide();		
			$('#hide'+splitedId['0']+'Button').hide();		
			$(this).hide();	
			$("#"+splitedId['1']).attr('style','color:#FFFFFF !important');
		});
		//*********************************************Ajax call to delete Records of all type***************************************
	 	function deleteAllCategory(code){ 
	 	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "deleteSubCategoryRecord","admin" => false)); ?>"+"/"+code;
	 	$.ajax({	
	 		 beforeSend : function() {
	 			// this is where we append a loading image
	 			$('#busy-indicator').show('fast');
	 			},
	 			                           
	 	 type: 'POST',
	 	 url: ajaxUrl,
	 	 dataType: 'html',
	 	 success: function(data){
	 		  $('#busy-indicator').hide('fast'); 		
	 	 },
	 		error: function(message){
	 			alert("Error in Retrieving data");
	 	 }        
	 	 });
	 	}
	 	 //**************************************************end of ajax calls****************************************************** 
		
	
	
	</script>