 
<style>
	.tabularForm th{
		text-align:center;	
	}
</style>

<table width="100%">
	<tr>
		<td class='rightTopBg'>
			<div class="inner_title">
				<h3>
					&nbsp;
					<?php echo __('Unchart', true); ?>
				</h3>
				<span></span>
			</div>
			<div class="clr">&nbsp;</div>
			<table border="0" class="tabularForm" cellpadding="0" cellspacing="1"
				width="100%" align="center">
				<tbody>
					<tr>
						<th><label><?php echo __('Unchart') ?> </label></th>
						<th><label><?php echo __('Date/Time') ?> </label></th>
						<th><label><?php echo __('Item') ?> </label></th>
						<th><label><?php echo __('Result') ?> </label></th>
						<th><label><?php echo __('Reason') ?> </label></th>
						<th><label><?php echo __('Comment') ?> </label></th>
					</tr>

					<tr>
						<td><?php echo $this->Form->input('unchart_checkbox',array('type'=>'checkbox','checked'=>'checked','div'=>false,'label'=>false)) ?>
						</td>
						<td><?php echo $this->DateFormat->formatDate2LocalForReport($data['ReviewPatientDetail']['date']." ".$data['ReviewPatientDetail']['actualTime'],Configure::read('date_format'),true);  ?>
						</td>
						<td><?php echo ($data['ReviewSubCategoriesOption']['name'])?$data['ReviewSubCategoriesOption']['name']:$data['ReviewSubCategoriesOption']['drug_name']?></td>
						<td><?php echo $data['ReviewPatientDetail']['values']; ?></td>
						<td><?php echo $data['ReviewPatientDetail']['unchart_reason']; ?></td>
						<td><?php echo $data['ReviewPatientDetail']['unchart_comment']; ?></td>
					</tr>
					<tr>
						<td colspan="6">&nbsp;</td>
					</tr>
				</tbody>
			</table>
			<div class="clr">&nbsp;</div>
			<div class="clr inner_title">
				<h3>&nbsp; &nbsp; Result</h3>
			</div>
			<div class="clr">&nbsp;</div> <?php echo $this->Form->create('Nursing',array('id'=>'unchart-form','controller'=>'nursings','action'=>'unchart_result'  ,'default'=>false,'inputDefaults'=>array('div'=>false,'label'=>false))); 
			echo $this->Form->hidden('id',array('value'=>$id,'id'=>'option_id'));

		 ?>
			<table border="0" class="tabularForm" cellpadding="0" cellspacing="1"
				width="100%" align="center" id="unchart-html">
				<tbody>
					<tr>
						<td><?php echo __('Reason')."&nbsp;&nbsp;" ; ?>
						</td>
					</tr>
					<tr>
						<td><?php  	$reasons = array('Charted at Incorret Time'=>'Charted at Incorret Time',
								'Charted on Incorret Order'=>'Charted on Incorret Order',
								'Charted on Incorret Patient'=>'Charted on Incorret Patient',
								'Other'=>'Other');
						echo $this->Form->input('unchart_reason',array('id'=>'reason','type'=>'select','options'=>$reasons,'empty'=>'','autocomplete'=>'off'));  ?>
						</td>
					</tr>
					<tr>
						<td><?php echo __('Comment')."&nbsp;&nbsp;"  ; ?></td>
					</tr>
					<tr>
						<td><?php 
						echo $this->Form->input('unchart_comment',array('type'=>'textarea','style'=>"width:500px;resize: horizontal;"));
						?>
						</td>
					</tr>
					<tr>
						<td><?php  	 echo $this->Form->button('Sign',array('id'=>'unchart-save','class'=>'blueBtn','div'=>false,'disabled'=>'disabled'));
									 echo $this->Form->button('Cancel',array('class'=>'grayBtn','id'=>'cancel')); ?>
						</td>
					</tr>
				</tbody>
			</table>
			<?php echo $this->Form->end(); ?> 
		</td>
	</tr>
</table> 
<script>
							 
	$(document).ready(function(){ 
		$('#reason').change(function(){
			 
			if($(this).val() != '')
				$("#unchart-save").attr('disabled',false);
			else
				$("#unchart-save").attr('disabled',true);
		});

		$("#unchart-save").click(function(){
		    
			$.ajax({
				  beforeSend: function(){
					  loading(); // loading screen
				  },
				  'type':'post',
			      url: "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "unchart_result", "admin" => false)); ?>" ,
			      data:$('#unchart-form').serialize(), //form data
			      context: document.body,
			      success: function(data){ 
			    	  onCompleteRequest(); //remove loading sreen
			    	  optionID= $('#option_id').val(); 
					  $(".in-error"+optionID).html('In Error') ; //set temp text 
			    	  $.fancybox.close(true);
				  },
				  error:function(){
						alert('Please try again');
						onCompleteRequest(); //remove loading sreen
				  }
			});
		});

		$("#cancel").click(function(){  
	     	$.fancybox.close(true); 
	    }); //close fancybox on cancel button click
		
		function loading(){
			  
			 $('#unchart-html').block({ 
		        message: '<h1><img src="../../theme/Black/img/icons/ajax-loader_dashboard.gif" /> Please wait...</h1>', 
		        css: {            
		            padding: '5px 0px 5px 18px',
		            border: 'none', 
		            padding: '15px', 
		            backgroundColor: '#000000', 
		            '-webkit-border-radius': '10px', 
		            '-moz-border-radius': '10px',               
		            color: '#fff',
		            'text-align':'left' 
		        },
		        overlayCSS: { backgroundColor: '#000000' } 
		    }); 
		}

		function onCompleteRequest(){
			$('#unchart-html').unblock(); 
			return false ;
		}
	});
</script>
 
				