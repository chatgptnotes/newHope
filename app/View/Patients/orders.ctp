<?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));      
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js','slides.min.jquery.js',
									'jquery.isotope.min.js','jquery.custom.js','ibox.js','jquery.fancybox-1.3.4','jquery.selection.js','jquery.autocomplete','ui.datetimepicker.3.js'));?>

<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Orders Information');?>


		<span style='text-align: right; padding-top: 15px'><?php //echo $this->Html->link(__('Add Multiple Order Set'),'#',array('onclick'=>'orderaddmultiple("'.$patient_id.'")','class'=>'blueBtn','div'=>false,'label'=>false));?>&nbsp;&nbsp;
			<?php echo $this->Html->link(__('Add Order'),'#',array('onclick'=>'orderadd("'.$patient_id.'")','class'=>'blueBtn','div'=>false,'label'=>false));?>
			<?php echo $this->Html->link(__('Multiple Order'),array('controller'=>'MultipleOrderSets','action' =>'index',$patient_id),array('class'=>'blueBtn','div'=>false,'label'=>false));?>
			
		</span>
		
	</h3>

</div>
<div class="inner_left">
	<?php echo $this->element('patient_information');?>
</div>
<table width="100%" border="0">
	<tr>
		<td width="15%" valign="top" style="border-right: 1px solid gray">
			<table border="0" cellpadding="0" cellspacing="0" width="100%"
				align="center">
				<tr>
					<td><h3>
							<?php echo __('Order Categories');?>
						</h3></td>
				</tr>
				<tr>
					<?php //debug($setdata);?>
					<?php $cnt=0; foreach($getOrderData as $getOrderData){

						if($getOrderData['OrderCategory']['id']==$setdata[$cnt][PatientOrder]['0']['order_category_id']){

					$checked='checked';
					}
					else{
						$checked="";
					}
					?>
					<td><?php echo $this->Form->checkbox('hi',array('name'=>'order_category','disabled'=>"disabled",'checked'=>$checked)) .$getOrderData['OrderCategory']['order_description']."<br/>";?>
					</td>

				</tr>
				<?php $cnt++; 
}?>

			</table>
		</td>
		<div style="Text-align: center; color: red">
			<?php if($setCount<1){
				echo __('No Records Found');
			}
		else{?>
		</div>
		<td width="85%" valign="top">
			<table border="0" class="table_format" cellpadding="0"
				cellspacing="0" width="100%">

				<tr class="row_title">

					<td class="table_cell" width="10%"><strong><?php echo __(''); ?> </strong>
					</td>
					<td class="table_cell" width="30%"><strong><?php echo __('Order Name');?>
					</strong>
					</td>
					<td class="table_cell" width="10%"><strong><?php echo __('Status'); ?>
					</strong>
					</td>
					<td class="table_cell" width="30%"><strong><?php echo  __('Details'); ?>
					</strong>
					</td>

				</tr>


				<?php $i=0;
				//debug($setdata);
				foreach($setdata as $setdatas){
           $cnt_order=count($setdatas['PatientOrder']);
           if($cnt_order!=0)
           {
           	?>

				<tr class="row_gray">
					<td class="table_cell" colspan='5'><strong><?php echo $setdatas['OrderCategory']['order_description']?>
					</strong></td>


				</tr>
				<?php }
				$j=0;
				for($i=0;$i<count($setdatas['PatientOrder']);$i++){
			?>
				<tr class="">
					<?php if(($setdatas['PatientOrder'][$i]['status'])=='Ordered'){
						$orderchecked='checked';
					}
					else{
						$orderchecked='';
					}?>
					<td class="table_cell" align="right" width="10%"><strong><?php echo $this->Form->checkbox('checkSataus',
							array('name'=>'checkSataus','class'=>'chkStatus','id'=>$i.$cnt_order,'checked'=>$orderchecked,
'onclick'=>'update_patient_record("'.$setdatas['PatientOrder'][$i]['patient_id'].'","'.$setdatas['PatientOrder'][$i]['id'].'",this.id,"'.$setdatas['PatientOrder'][$i]['type'].'")')) ; ?>
					</strong></td>
					<td class="table_cell"><strong><a href="#formdisplayid"
							onclick="javascript:display_formdisplay(<?php echo $patient_id?>,<?php echo $setdatas['PatientOrder'][$i]['id']?>,'<?php echo $setdatas[PatientOrder][$i][type]?>')"><?php echo __($setdatas['PatientOrder'][$i]['name']);?>
						</a> </strong> <?php
						//echo  $this->Js->link('<input type="button" value="Add" class="blueBtn" id="submitMyData">',"#",
						///array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('hide', array('buffer' => false)),'update'=>'#formdisplayid', 'data' => '{finddata:$("#finddata").val(),patientid:$("#patientid").val(),category:$("#category").val()}','dataExpression' => true,'htmlAttributes' => array('escape' => false) ));echo $this->Js->writeBuffer();
						?>
					</td>
					<td class="table_cell"><strong><div
								id='updateStatus<?php echo $i.$cnt_order?>'>
								<?php echo __($setdatas['PatientOrder'][$i]['status']); ?>
							</div> </strong></td>
					<td class="table_cell"><strong><?php echo __(rtrim($setdatas['PatientOrder'][$i]['sentence'],", ")); ?>
					</strong>
					</td>

				</tr>
				<?php }
}
unset($cnt_order);
?>

				<tr>
					<td id="formdisplayid" colspan="5" style="margin-top: 10px"></td>
				</tr>
			</table> <?php }?>
		</td>
	</tr>
</table>
<script>

function update_patient_record(id,order_id,chkId,type){
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "patients", "action" => "updateorderset","admin"=>false)); ?>"+"/"+id+"/"+order_id+"/"+type;
			$.ajax({
				type : "POST",
				url : ajaxUrl , 
				
				beforeSend:function(){
					$('#busy-indicator').show('fast');
                },
				success: function(data){
					data = jQuery.parseJSON(data);
					data = data.status;
					$('#busy-indicator').hide('fast');
					if(data=='Y'|| data=='1'){
						var changeStatus='Cancelled';
					}
					else if(data=='N'|| data=='0'){
						alert(data);
						var changeStatus='Ordered';
					}
					else{
						alert(data);
						var changeStatus='Pending';
					}
				
					$("#updateStatus"+chkId).html(changeStatus);
					changeStatus = '';
					
					//window.location.href="<?php echo $this->Html->url(array("controller" => "patients", "action" => "orders")); ?>" +"/"+id+"/"+2
					},
				
				error: function(message){
				alert(message);
				}
				
			});
}

function orderadd(id) { 
	$
			.fancybox({

				'width' : '80%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "addorders")); ?>" +"/"+id,
				'onClosed':function (){
					window.top.location.href = '<?php echo $this->Html->url("/patients/orders"); ?>'+"/"+id+"/"+1;
				}		
			});

}
function orderaddmultiple(id) { 
	$
	.fancybox({

		'width' : '50%',
		'height' : '80%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller" => "patients", "action" => "addordermultiples")); ?>" +"/"+id
		 	
	});

}

function display_formdisplay(patient_id,patient_order_id,patient_order_type){
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "displayorderform","admin" => false)); ?>";
	   var formData = $('#patientnotesfrm').serialize();
         $.ajax({	
        	 beforeSend : function() {
        		// this is where we append a loading image
        		$('#busy-indicator').show('fast');
        		},
        		                           
          type: 'POST',
         url: ajaxUrl+"/"+patient_id+"/"+patient_order_id+"/"+patient_order_type,
          data: formData,
          dataType: 'html',
          success: function(data){
        	  $('#busy-indicator').hide('fast');	
	        	$("#formdisplayid").html(data);
	        
	        
          },
			error: function(message){
				alert("Error in Retrieving data");
          }        });
    
    return false; 
}


			</script>
