<?php echo $this->Html->css('internal_style');?>
<style>
	.tabularForm th{
		text-align:center;	
	}
</style>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Result Details', true); ?></h3>
	<span></span>
</div>
<div class="clr">&nbsp;</div>  
	<table border="0" class="tabularForm"  cellpadding="0" cellspacing="1" width="500px" align="center">
		<tbody> 		    			 				    
			<tr >			 
				<th><label><?php echo __('Value') ?> </label></th> 
				<th><label><?php echo __('Valid From') ?> </label></th> 
				<th><label><?php echo __('Valid Until') ?> </label></th> 
			 </tr>	 
			 <?php 
			  	$u=0;
			 	foreach($data as $key =>$value){ 
			 	
			 	if($value['ReviewPatientDetail']['is_deleted']==1) {
			 		 
			 		$errorStr = '<tr> <td >In Error </td>
										<td >'.$this->DateFormat->formatDate2LocalForReport($value['ReviewPatientDetail']['date']." ".$value['ReviewPatientDetail']['actualTime'],Configure::read('date_format'),true).'</td>
										<td >';
			 		$updatedDate =  $this->DateFormat->formatDate2LocalForReport($value['ReviewPatientDetail']['edited_on'],Configure::read('date_format'),true);
			 		if(empty($updatedDate)) {
			 			$errorStr .= "Current" ;
			 			$updatedDate =  $this->DateFormat->formatDate2LocalForReport($value['ReviewPatientDetail']['uncharted_on'],Configure::read('date_format'),true);
			 		}else{
			 			$errorStr .= $updatedDate ;
			 		}
			 		$errorStr .= '</td>   </tr>	';
			 	}else{
					$updatedDate =  $this->DateFormat->formatDate2LocalForReport($value['ReviewPatientDetail']['edited_on'],Configure::read('date_format'),true);
			 		$errorStr='' ;
			 		
				}
			 		
			 		echo $errorStr ; //display additional row for deleted entry
			 		 
			 	?>
			 <tr>			 
				<td ><?php echo $value['ReviewPatientDetail']['values'];  ?></td> 
				<td ><?php echo $this->DateFormat->formatDate2LocalForReport($value['ReviewPatientDetail']['date']." ".$value['ReviewPatientDetail']['actualTime'],Configure::read('date_format'),true);  ?></td> 
				<td ><?php 
							if(empty($updatedDate) && $value['ReviewPatientDetail']['is_deleted']==1) {
								echo "Current" ; 
								if($u < 1){
									$currentVal = $value['ReviewPatientDetail']['values'] ;
									$is_deleted = $value['ReviewPatientDetail']['is_deleted'] ;
									$u++ ;
								}
							}else{ 
								echo ($updatedDate)?$updatedDate:'Current' ;
								if($u < 1){
									$currentVal = $value['ReviewPatientDetail']['values'] ;
									$is_deleted = $value['ReviewPatientDetail']['is_deleted'] ;
									$u++ ;
								}
							}
				?></td> 
			 </tr>	 
			 <?php } ?>		
		</tbody>	
	</table>	
 
 <div class="clr inner_title"  ><h3>&nbsp; &nbsp; Result </h3></div>  
 <table border="0" class="tabularForm"  cellpadding="0" cellspacing="1" width="500px" align="center">
		<tbody> 		    			 				    
			<tr>
				<td><strong>
					<?php echo $value['ReviewSubCategoriesOption']['name'];?>
					</strong>
				</td>			 
			<tr>
			<tr>
				<td>
					<?php echo $currentVal;?>
				</td>			 
			<tr>	
			<tr>
				<td><?php echo __('Date/Time')."&nbsp;&nbsp;" ; echo $this->DateFormat->formatDate2LocalForReport($value['ReviewPatientDetail']['date']." ".$value['ReviewPatientDetail']['actualTime'],Configure::read('date_format'),true);  ?></td>
			</tr>
			<tr>
				<td> <?php echo __('Status')."&nbsp;&nbsp;"  ;
					if(count($data) > 1){
						$status ='Modified' ;
					}else if($is_deleted==1) $status = 'In Error' ;
					else $status = "Auth (Verified)" ;
					
					echo $status; 
				 ?>
				</td>
			</tr>
		</tbody>	
	</table>
 
				