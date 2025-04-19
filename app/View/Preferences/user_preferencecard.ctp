<style>.row_action img{float:inherit;}</style>
<div class="inner_title">
<h3><?php echo __('Manage Preference Card', true); ?></h3>
<span>
<?php 
	//echo $this->Html->link(__('Add Preference Card', true),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'Add-Preference-Card'));
	echo $this->Html->link(__('Add Preference Card', true),array('action' => 'add',$patient_id,$this->request->pass[1]), array('escape' => false,'class'=>'blueBtn'));
	if($this->request->pass[1]=="OR") {
		echo $this->Html->link(__('Back'), array('controller'=>'OptAppointments','action' => 'search'), array('escape' => false,'class'=>"blueBtn"));
	}
?>
</span>
</div>

<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%">
  <tr>
  <td colspan="8" align="right">
  <?php 
       ?>
  </td>
  </tr>
  <tr ><td colspan="8">&nbsp;</td></tr>
  <tr class="row_title">
   
    <td class="table_cell" align="left"><strong>Preference Card</strong></td>
   <td class="table_cell" align="left" width="40%"><strong>Procedure Name</strong></td>
   <td class="table_cell" align="left"><strong>Primary care provider</strong></td>
   <td class="table_cell" align="left"><strong>Action</strong></td>
 
  </tr>
  <?php 
      $cnt=0; $i=0;
      if(count($getData) > 0) { 
      foreach($getData as $pref_data){ 
      $cnt++;
  ?>
  <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
  
   <td class="row_format" align="left"><?php echo ucwords($pref_data['Preferencecard']['card_title']); ?> </td>
   <td class="row_format" align="left" style="text-align: left;">
   <table border="0"   cellpadding="0" cellspacing="0" width="100%" style="margin: 0;" >
	   <?php 
	  	foreach($pref_data['Surgery'] as $surgName){ 
	   			if($surgName!=''){?>
				<tr <?php if($i%2 == 0) echo "class='row_gray'"; ?> style="background-color:  "><td style="text-align: left;"><?php echo $surgName;?></td></tr>
	   <?php  	}
	  		 $i++;}
	   		
	   ?>
	</table>
   </td>
   <td class="row_format" align="left"><?php echo "Dr. ".$pref_data['User']['first_name']." ".$pref_data['User']['last_name'] ?> </td>
   <td class="row_action" align="left">
   
    <?php  //echo $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Add/Edit')),array('controller'=>'radiologies','action' => 'radiology_result',$labs['RadioManager']['patient_id'],$labs['Radiology']['id'],$labs['RadioManager']['id']), array('escape'=>false));
		echo  $this->Html->link($this->Html->image('icons/view-icon.png'), array('controller'=>'preferences','action' => 'view_preference',$pref_data['Preferencecard']['id'],$pref_data['Preferencecard']['patient_id'],$this->request->pass[1]), array('escape' => false,'title' => __('View', true), 'alt'=>__('View', true)));
		echo  $this->Html->link($this->Html->image('icons/edit-icon.png'), array('controller'=>'preferences','action' => 'edit_preference',$pref_data['Preferencecard']['id'],$pref_data['Preferencecard']['patient_id'],$this->request->pass[1]), array('escape' => false,'title' => __('Edit', true), 'alt'=>__('Edit', true)));
     	echo $this->Html->link($this->Html->image('icons/print.png'),'#',array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_preferencecard',$pref_data['Preferencecard']['id']))."', '_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=850,left=400,top=300,height=700');  return false;"));
    	echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('alt'=>__('Delete'),'title'=>__('Delete'))), array('controller'=>'preferences','action' => 'delete', $pref_data['Preferencecard']['id']), array('escape' => false,'title'=>'Delete'),"Are you sure you wish to delete this Preference card?");
	?>
   </td>
  </tr>
  <?php }?>
   <tr>
    <TD colspan="8" align="center">
    <!-- Shows the page numbers -->
 <?php //echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
 <!-- Shows the next and previous links -->
 <?php //echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
 <?php //echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
 <!-- prints X of Y, where X is current page and Y is number of pages -->
 <span class="paginator_links"><?php //echo $this->Paginator->counter(); ?></span>
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
  ?>
  
 </table>
 <script>

 $("#Add-Pre-Operative-Checklist").click(function(){
		$.ajax({
			url: '<?php echo $this->Html->url(array('controller'=>'opt_appointments','action' => 'add_ot_pre_operative_checklist', $patient_id));?>',
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success: function(data){
				$('#busy-indicator').hide();
				$("#render-ajax").html(data);
		     }
		});
	});
 
	$("#Add-Preference-Card").click(function(){
		$.ajax({
			url: '<?php echo $this->Html->url(array('controller'=>'Preferences','action' => 'add',$patient_id));?>',
			beforeSend:function(data){
				$('#busy-indicator').show();
			},
			success: function(data){
				$('#busy-indicator').hide();
				$("#render-ajax").html(data);
		     }
		});
	});
</script>
