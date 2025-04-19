
<script>
if(typeof(openWin) == 'object'){
openWin.close();
}

</script>
<?php 
  if(!empty($errors)) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
<div class="inner_title">
<h3> &nbsp; <?php echo __('Bed Management', true); ?></h3>
</div>

<table width="100%"><tr>
<td width="80%">

<table class="table_format"  border="0" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
  
  <tr class="row_title">
  <td class="table_cell"><strong><?php echo __('Bed', true); ?> </strong></td>
  <td class="table_cell"><strong><?php echo __('Name', true); ?></strong></td>
  <td class="table_cell"><strong><?php echo __('Date of Birth', true); ?></strong></td>
  <td class="table_cell"><strong><?php echo __('Admisson No.', true); ?></strong></td>
  <td class="table_cell"><strong><?php echo __('Actions', true); ?></strong></td>
  </tr>
  
  <?php 
  $toggle = 0;
  for($i=1; $i <= $data['Ward']['no_of_rooms']; $i++) { 
  	if($toggle == 0) {
       	echo "<tr class='row_gray'>";
       	$toggle = 1;
       }else{
       	echo "<tr>";
       	$toggle = 0;
       }
  ?>
	
  <?php if($data['Ward']['bed_prefix'] != '') { ?>
  <td class="row_format"><?php echo $data['Ward']['bed_prefix'].$i;?> </td>
  <?php }else{ ?>
  <td><?php echo $i;?> </td>
  <?php } ?>
  
  <?php #echo '<pre>';print_r($data['Ward']['id']);exit;
  	$isAssigned = 0;
  	foreach($patientsData as $patient){
  	
  		if($patient['Patient']['bed_id'] == $i){
  			echo '<td class="row_format">'.$patient['Patient']['last_name'].'&nbsp;'. $patient['Patient']['first_name'].'</td>';
  			echo '<td class="row_format">'.$patient['Patient']['dob'].'</td>';
  			echo '<td class="row_format">'.$patient['Patient']['admission_id'].'</td>';
  			echo '<td class="row_format">';
  			#echo $this->Html->link($this->Html->image("icons/xchange.gif"), array('action' => 'selectWard', 'admin' => false, $patient['Patient']['id'],$data['Ward']['id'],$patient['Patient']['bed_id']), array('escape' => false),__('Are you sure?', true));
  			echo $this->Html->link($this->Html->image("icons/xchange.gif"),'#',
			 array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('admin' => false, 'action'=>'view_waiting_list',$patient['Patient']['id'],$data['Ward']['id'],$patient['Patient']['bed_id']))."', '_blank',
			 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,height=600,left=400,top=400');  return false;"));
   			
   			echo $this->Html->link($this->Html->image("icons/admission_data.gif"), array('action' => 'patient_information', $patient['Patient']['id'],'admin' => false, 'controller' => 'patients'), array('escape' => false));
   
   		
  			echo '</td></tr>';
  			$isAssigned =1;
  			break;
  		}
  	}
  	if($isAssigned == 0){
  		echo '<td>&nbsp;</td>';
  		echo '<td>&nbsp;</td>';
  		echo '<td>&nbsp;</td>';
  		echo '<td>';
  		#echo $this->Html->link($this->Html->image("icons/xchange.gif"), array('action' => 'add', $data['Ward']['id']), array('escape' => false),__('Are you sure?', true));
   		echo '&nbsp;</td>';
  		echo '</tr>';
  	}
  	
  ?> 
  </tr>
  <?php } ?>
 
  
 </table>
</td>
<td width="20%" align="center" valign="top">
<table width="100%" class="waiting_list">
<tr class="row_title"><strong><td class="table_cell" align="center"><strong><?php echo __('Waiting List'); ?> </strong></td></tr>


								
<?php foreach($waitingList as $waiting){?>
	<tr><td align="center"><?php  
	
	echo $this->Html->link(__($waiting['Patient']['first_name'].'&nbsp;'.$waiting['Patient']['last_name']),
								     '#',
								     array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('admin' => false, 'action'=>'view_waiting_list',$waiting['Patient']['id'],$data['Ward']['id']))."', '_blank',
								           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=600,height=600,left=400,top=400');  return false;"));
   									
	?></td></tr>

<?php } ?>


</table>
</td>
</tr>
</table>