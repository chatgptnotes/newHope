<?php
echo $this->Html->css(array('internal_style'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css')); 

echo $this->Html->script(array('jquery.tree'/*,'jquery.validationEngine-en.js'*/));
echo $this->Html->css(array('jquery.tree'/*,'validationEngine.jquery.css'*/));
?>
<style>
body{
font-size:13px;
}
.red td{
	background-color:antiquewhite !important;
}
.idSelectable:hover{
		cursor: pointer;
		}
.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
	}
	.tabularForm td {
		 background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
	    padding: 3px 8px;
	}
#msg {
    width: 180px;
    margin-left: 34%;
}
#selectedBody_0 tr td{
	background-color: #E5E5E5 !important;
}

#selectedBody_1 tr td{
	background-color: #D3DCE3 !important;
}

#selectedBody_2 tr td{
	background-color: #E5E5E5 !important;
}

#selectedBody_3 tr td{
	background-color: #D3DCE3 !important;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Total Receipt Report', true); ?>
	</h3>
	<span>
		<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div> 
<?php echo $this->Form->create(); ?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="95%" valign="top">
		<table align="center" style="margin-top: 10px">
			<tr>
			<?php 
				$monthArray = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June',
                                        '07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
                 	for($i=2010;$i<=date('Y')+5;$i++){
            			$yearArray[$i] = $i; 
            		}
            ?>
                <td align="center"><?php echo "Month";?></td>
                <td align="center">
                	<?php echo $this->Form->input('month',array('empty'=>'Please Select','options'=>$monthArray,
                                                        'class'=>'textBoxExpnd ','id'=>'month','label'=>false,'default'=>date('m'))); ?>
                </td>
                <td align="center"><?php echo "Year"; ?></td>
                <td align="center">
                	<?php echo $this->Form->input('year',array('empty'=>'Please Select','options'=>$yearArray,
                                                        'class'=>'textBoxExpnd ','id'=>'year','label'=>false,'default'=>date('Y')));?>
                </td>
				<td>
					<?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?>
				</td>
				<td>
					<?php echo $this->Form->input('Generate Excel',array('type'=>'submit','value'=>'generate_excel','class'=>'blueBtn','name'=>"data[genrate_excel]",'label'=> false, 'div' => false));?>
				</td> 
			</tr>
		</table>

		<div id="container">
			<table width="70%" align="center" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
				<thead>
					<tr> 
						<th> 
							<span style="float:left"><?php echo __('Income Heads');?></span>
							<span style="float:right"><?php echo __('Amount');?></span>
						</th> 
					</tr> 
				</thead> 
				<?php foreach($admissionType as $key=> $type) { ?>
				<tbody id="selectedBody_<?php echo $key; ?>">
					<tr class="idSelectable showArrow" id="idSelectable_<?php echo $key; ?>" admissionType="<?php echo $type; ?>"> 
						<td>
							<span>
								<div id="showArrow_<?php echo $key; ?>"><?php echo $this->Html->image('down_arrow.png',array('title'=>'Click to Expand','alt'=>'Expand','id'=>'showAdmissionTr','escape'=>false)); ?></div> 
								<div id="hideArrow_<?php echo $key; ?>" style="display:none;"><?php echo $this->Html->image('right_arrow.png',array('title'=>'Collapse','alt'=>'Collapse','id'=>'hideAdmissionTr','escape'=>false)); ?></div>
							</span> 
							<span style="float:left">&nbsp;&nbsp;</span>
							<span style="float:left"><?php echo $type; ?></span>
							<span style="float:right"><?php echo $result[$type] ? number_format(round($result[$type])) :0;
							$totalCollection +=  (double) round($result[$type]); ?></span>
						</td> 
				  	</tr> 
				</tbody>
			  	<?php }?>  
				<tr>
					<td>
						<span style="float:left"><?php echo __('Total : '); ?></span>
						<span style="float:right"><strong><?php echo number_format(round($totalCollection)); ?></strong></span>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo $this->Number->getPriceFormat(round($totalCollection)); ?>
					</td>
				</tr>
			</table>
		</div>
	</td>
	</tr>
</table> 
<?php echo $this->Form->end();?>

<script type="text/javascript">
	var getData = "<?php echo $this->Html->url(array("controller" => 'Reports', "action" => "getTotalHeadReceived",'admin'=>false)); ?>";
var count = 1;
$(document).ready(function(){
	$(".idSelectable").click(function() {
		var id = $(this).attr('id').split("_")[1];
		var admissionType = $(this).attr('admissiontype');
		var month = $("#month").val();
		var year = $("#year").val();
		
		var showUpArrow = false;
		var hideUpArrow = false; 
		//console.log(count++);

		if($(this).hasClass('showArrow')){
			$(this).removeClass('showArrow');
			$(this).addClass('hideArrow');
			hideUpArrow = true; 
		}else{
			$(this).removeClass('hideArrow');
			$(this).addClass('showArrow');
			showUpArrow = true; 
		}  

		//if first click send ajax
		if($("#head_"+admissionType).length==0){  
			$.ajax({
				  type : "POST",
				  url: getData+'/'+admissionType+'/'+month+'/'+year,
				  beforeSend:function(){
					  $('#busy-indicator').show(); 
				  }, 	  		  
				  success: function(data){
				  	  $("#head_"+admissionType).remove();
				  	  closedAll();
					  $('#busy-indicator').hide();
					  $("#selectedBody_"+id).append(data);  
					  $("#showArrow_"+id).hide();
	  				  $("#hideArrow_"+id).show(); 
				  },
			}); 
		}

		// show/hide sub head 
		if(hideUpArrow == true && $("#head_"+admissionType).length>0){
			closedAll(id);
			$("#showArrow_"+id).hide();
	  		$("#hideArrow_"+id).show(); 
	  		$("#head_"+admissionType).show();
		}else{
			$("#showArrow_"+id).show();
	  		$("#hideArrow_"+id).hide(); 
	  		$("#head_"+admissionType).hide();
		}  
	});  
});

function closedAll(refId){
	$(".idSelectable").each(function(){
		var id = $(this).attr('id').split("_")[1];
		var admissionType = $(this).attr('admissiontype');
		if(id != refId){
			$("#showArrow_"+id).show();
	  		$("#hideArrow_"+id).hide(); 
	  		$("#head_"+admissionType).hide(); 
	  		if($(this).hasClass('hideArrow')){
				$(this).removeClass('hideArrow');
				$(this).addClass('showArrow'); 
			}  
		}
	});
}
 
</script>