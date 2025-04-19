<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
	<tr class="row_title">
			<td class="table_cell" width="15%"><strong><?php echo __('Order Number'); ?> </strong></td>
			<td class="table_cell" width="15%"><strong><?php echo __('Order Date'); ?> </strong></td>
			<td class="table_cell" width="15%"><strong><?php echo __('View'); ?> </strong></td>
	</tr>
	<?php if(!empty($getList)) { 
  	  $toggle =0;
  	  $i=0 ;
  	  $cnt=0;
  	  foreach($getList as $key=>$data){ 

			       if($toggle == 0) {
				       	echo "<tr class='row_gray'>";
				       	$toggle = 1;
			       }else{
				       	echo "<tr>";
				       	$toggle = 0;
			       }
			       ?>
			<?php if(!empty($data['PatientOrderEncounter']['note_id'])){?>
			<td class="table_cell" width="15%"><?php echo $cnt+1; ?> </td>
			<td class="table_cell" width="15%"><?php echo $this->DateFormat->formatDate2Local($data['PatientOrderEncounter']['create_time'],Configure::read('date_format'),true) ?></td>
			<td class="table_cell" width="15%"><strong><?php echo $this->Html->image('icons/view-icon.png' , 
							array('class'=>'loadOrderPage','id'=>$data['PatientOrderEncounter']['patient_id']."_".$data['PatientOrderEncounter']['note_id']."_".$data['PatientOrderEncounter']['id'],'style'=>'padding-right: 5px;','title'=>"View Orders",'alt'=>'View Orders')); ?> </strong></td>
			<?php }?>
	</tr>
	<?php $cnt++;}
	}else{?>
	<tr>
		<td colspan="3" align="center">No prevoius notes recorded.</td>
	</tr>
	<?php }?>
</table>
<script>
	$('.loadOrderPage').on("click",function(){
		var currentID=$(this).attr('id');
		var idSplit=currentID.split('_');
		window.location.href =  "<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "orders")); ?>"
		+'/'+ idSplit['0']+'/'+'null'+'/'+idSplit['2']+'/?Preview=preview&noteId='+idSplit['1'];
		});	</script>