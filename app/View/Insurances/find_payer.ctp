<?php echo $this->Html->script(array('pager'));?>
<?php 
$this->Paginator->options(array(
		'update' => '#findBatch',
		'evalScripts' => true,
		'before' => $this->Js->get('#busy-indicator')->effect(
				'fadeIn',
				array('buffer' => false)
		),
		'url'=>array('controller'=>'Insurances',
				'action'=>'findPayer'),
		'complete' => $this->Js->get('#busy-indicator')->effect(
				'fadeOut',
				array('buffer' => false)
		),
));
?>
<table width="100%">
	<tr class="row_title">
		<td width="1%" align="center"><?php echo __('#')?></td>
		<td width="1%" align="center"><?php echo __('Batch Name')?></td>
		<td width="1%" align="center"><?php echo __('Group Control Number')?></td>
		<td width="1%" align="center"><?php echo __('Member in Batch')?></td>
		<td width="1%" align="center"><?php echo __('Action')?></td>
	</tr>
	<?php foreach($getBatch as $key=>$getBatch){ ?>
	<tr class="">
		<td width="1%" align="center"><?php echo $key+1;?></td>
		<?php $id=$getBatch['Batch']['id'];?>
		<td width="1%" align="center"><?php echo  $this->Html->link($getBatch['Batch']['batch_name'],'javascript:void(0)',array('onclick'=>'getDetails('.$getBatch['Batch']['id'].')'));?></td>
		<td width="1%" align="center"><?php echo $getBatch['Batch']['group_control_number'];?></td>
		<td width="1%" align="center"><?php echo $getBatch['Batch']['member_in_batch'];?></td>
		<td width="1%" align="center">
		<?php echo $this->Html->image('/img/icons/notes_error.png',array('alt'=>'Generate EDI','title'=>'Generate EDI',
				'id'=>$id,'class'=>'generate'));?>
		<span id='sendEDI<?php echo $id;?>' style='display:none'><?php echo $this->Html->image('/img/icons/notes_error.png',
				array('alt'=>'Generate EDI','title'=>'Generate EDI'));?><?php if($getBatch['Batch']['file_created']=='1'){
			$display='block';
				}else{
$display='none';
}?></span>
		<?php echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download EDI','title'=>'Download EDI','width'=>'20','height'=>'18')),
array('action'=>'downloadEdi',$getBatch['Batch']['batch_name']),array('id'=>'down_'.$id,'escape'=>false ,'style'=>'display:'.$display)); ?>
				
		
		
		</td>
	</tr>
	<?php }?>
</table>
<table width="100%">
	<tr>
		<td align='center'><?php
		echo $this->Paginator->prev('<< ' . __('Previous '), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ' | '));
		echo $this->Paginator->next(__(' Next') . ' >>', array(), null, array('class' => 'next disabled'));
		echo $this->Js->writeBuffer();
		?>
		</td>
	</tr>
</table>
<script>
		$('.generate').click(function(){
			var current_id=$(this).attr('id');
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "readBatch","admin" => false)); ?>";
	         $.ajax({	
	        	 beforeSend : function() {
	        		// this is where we append a loading image
	        		$('#busy-indicator').show('fast');
	        		},
	        		                           
	          	type: 'POST',
	         	url: ajaxUrl+"/"+current_id,
	          	dataType: 'html',
	          	success: function(data){
	        	  $('#busy-indicator').hide('fast');
	        	  inlineMsg(current_id,'EDI Generate');
	        	  $('#down_'+current_id).css('display','block');
	        		//location.href="<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "findBatch")); ?>";
	          },
				error: function(message){
					alert("Error in Retrieving data");
	          }        }); 
			});

		function getDetails(ids){
			$
			.fancybox({
				'width' : '100%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "patientInPayer")); ?>"+"/"+ids,
				
						
			});	
		}
		function downloadedi(name){
			var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Insurances", "action" => "downloadEdi","admin" => false)); ?>";
	         $.ajax({	
	        	 beforeSend : function() {
	        		// this is where we append a loading image
	        		$('#busy-indicator').show('fast');
	        		},
	        		                           
	          type: 'POST',
	         url: ajaxUrl+"/"+name,
	          dataType: 'html',
	          success: function(data){
	        	  $('#busy-indicator').hide('fast');
	          },
				error: function(message){
					alert("Error in Retrieving data");
	          }        }); 
		}
		</script>