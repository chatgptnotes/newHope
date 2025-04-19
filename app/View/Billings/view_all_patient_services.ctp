<?php #pr($servicesData);exit;?>
<div class="inner_title">
	<h3>Patient Services</h3>
	<span>
		<?php 
			if($this->Session->read('nursingServiceReturn')=='nursing'){
				echo $this->Html->link(__('Back'),array('controller'=>'nursings','action' => 'addWardCharges',$patientId), array('escape' => false,'class'=>'blueBtn'));
			}else{
				echo $this->Html->link(__('Back'),array('action' => 'patient_information',$patientId), array('escape' => false,'class'=>'blueBtn')); 
			}		
		?>
				
	</span>	
</div> 
<div class='clr'>
	&nbsp;
</div>
<?php if(!empty($servicesData)){ ?>
 	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
		<tr>
	        <th width="70" style="text-align:center;">DATE</th>
	        <th width="150" style="text-align:center;">PARTICULAR</th>
	        <th width="85" style="text-align:center;">UNIT PRICE</th>
	        <th width="70" style="text-align:center;">MORNING</th>
	        <th width="70" style="text-align:center;">EVENING</th>
	        <th width="70" style="text-align:center;">NIGHT</th>
	        <th width="70" style="text-align:center;">No Of Times</th>
	        <th width="50" style="text-align:center;">Action</th>
        </tr>
     
<?php 
}
$morningCost=$eveningCost=$nightCost=0;
$hospitalType = $this->Session->read('hospitaltype');
if($hospitalType=="NABH"){
	$chargeType='nabh_charges';
}else{
	$chargeType='non_nabh_charges';
}
foreach($servicesData as $serviceData){ ?>
<tr>
	<td style="text-align:center;"><?php //echo $serviceData['ServiceBill']['date'];
	echo $this->DateFormat->formatDate2Local($serviceData['ServiceBill']['date'],Configure::read('date_format'));
	?></td>
	<td ><?php echo  $serviceData['TariffList']['name'];?></td>     
	 
	<td align="right" style="text-align:center;"><?php   
	echo $this->Number->format($serviceData['TariffAmount'][$chargeType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
	?></td>
	<td style="text-align:center;"><?php 
	if(isset($serviceData['ServiceBill']['morning']) && $serviceData['ServiceBill']['morning']!=0){
		echo $this->Html->image('icons/tick.png');
		//echo $this->Form->checkbox('', array('name'=>'morning_'.$serviceData['ServiceBill']['id'],'id' => 'morning_'.$serviceData['ServiceBill']['id'],'checked'=>'checked'));
		
	}else{
		echo $this->Html->image('icons/cross.png');
		//echo $this->Form->checkbox('', array('name'=>'morning_'.$serviceData['ServiceBill']['id'],'id' => 'morning_'.$serviceData['ServiceBill']['id']));
	}
	if(isset($serviceData['ServiceBill']['morning_quantity']) && $serviceData['ServiceBill']['morning_quantity'] != 0){
		echo '&nbsp;'.$serviceData['ServiceBill']['morning_quantity'];
		$morningCost = $morningCost + ($serviceData['ServiceBill']['morning_quantity']*$subServiceArr[$serviceData['ServiceBill']['sub_service_id']]['cost']);
	}
	?></td>
	<td style="text-align:center;"><?php 
	if(isset($serviceData['ServiceBill']['evening']) && $serviceData['ServiceBill']['evening']!=0){
		echo $this->Html->image('icons/tick.png');
		//echo $this->Form->checkbox('', array('name'=>'evening_'.$serviceData['ServiceBill']['id'],'id' => 'evening_'.$serviceData['ServiceBill']['id'],'checked'=>'checked'));
	}else{
		echo $this->Html->image('icons/cross.png');
		//echo $this->Form->checkbox('', array('name'=>'evening_'.$serviceData['ServiceBill']['id'],'id' => 'evening_'.$serviceData['ServiceBill']['id']));
	}
	if(isset($serviceData['ServiceBill']['evening_quantity']) && $serviceData['ServiceBill']['evening_quantity'] != 0){
		echo '&nbsp;'.$serviceData['ServiceBill']['evening_quantity'];
		$eveningCost = $eveningCost + ($serviceData['ServiceBill']['evening_quantity']*$subServiceArr[$serviceData['ServiceBill']['sub_service_id']]['cost']);
	}
	?></td>
	<td style="text-align:center;"><?php 
	if(isset($serviceData['ServiceBill']['night']) && $serviceData['ServiceBill']['night']!=0){
		echo $this->Html->image('icons/tick.png');
		//echo $this->Form->checkbox('', array('name'=>'night_'.$serviceData['ServiceBill']['id'],'id' => 'night_'.$serviceData['ServiceBill']['id'],'checked'=>'checked'));
	}else{
		echo $this->Html->image('icons/cross.png');
		//echo $this->Form->checkbox('', array('name'=>'night_'.$serviceData['ServiceBill']['id'],'id' => 'night_'.$serviceData['ServiceBill']['id']));
	}
	if(isset($serviceData['ServiceBill']['night_quantity']) && $serviceData['ServiceBill']['night_quantity'] != 0){
		echo '&nbsp;'.$serviceData['ServiceBill']['night_quantity'];
		$nightCost = $nightCost + ($serviceData['ServiceBill']['night_quantity']*$subServiceArr[$serviceData['ServiceBill']['sub_service_id']]['cost']);
	}
	
	?>
	</td>
	<td style="text-align:center;">
		<?php 
			echo $serviceData['ServiceBill']['no_of_times'] ;
		?>
	</td>
	<td align="center"><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'deleteServices', $serviceData['ServiceBill']['id'],$serviceData['ServiceBill']['patient_id']), array('escape' => false),__('Are you sure?', true));?></td>
	</tr>
     <?php }
     
     if(empty($servicesData)){
     	?>
     	<div align="center" style="border: 1px solid #3E474A; padding: 5px;" class="error">
     			No Record Found !! </div>
     <?php }
     ?>
     
     
    <!--  <tr>
                          <td valign="top" align="right" colspan="4"><strong>Total</strong></td>
                          <td valign="top" style="text-align: center;"><strong><?php echo $morningCost;?></strong></td>
                          <td valign="top" style="text-align: center;"><strong><?php echo $eveningCost;?></strong></td>
                          <td valign="top" style="text-align: center;"><strong><?php echo $nightCost;?></strong></td>
                        </tr> 
                        <tr>
                          <td valign="top" align="right" colspan="4"><strong>Grand Total</strong></td>
                          <td valign="top" style="text-align: center;" colspan="3"><strong><?php echo ($morningCost+$eveningCost+$nightCost);?></strong></td>
                          </tr>  -->
     </table>