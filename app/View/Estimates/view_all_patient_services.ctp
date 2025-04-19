<?php #pr($servicesData);exit;?>
<div class="inner_title">
	<h3>Patient Services</h3> 
	<span>
		<?php  echo $this->Html->link(__('Back'),array('action' => 'estimateTypes',$patientId), array('escape' => false,'class'=>'blueBtn')); ?>
	</span>	
</div>
<div class='clr'>
	&nbsp;
</div>
 
 <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">
 <?php if(!empty($servicesData)){ ?>
                   		<tr>
                   			<th width="150">DATE</th>
                        	<th width="150">PARTICULAR</th>
                             
                            <th width="85" style="text-align:right;">UNIT PRICE</th>
                            <th width="70" style="text-align:center;">MORNING</th>
                            <th width="70" style="text-align:center;">EVENING</th>
                            <th width="70" style="text-align:center;">NIGHT</th>
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
foreach($servicesData as $serviceData){#echo'<pre>';print_r($serviceData);exit;?>
<tr>
	<td><?php //echo $serviceData['EstimateServiceBill']['date'];
	echo $this->DateFormat->formatDate2Local($serviceData['EstimateServiceBill']['date'],Configure::read('date_format'));
	?></td>
	<td><?php echo  $serviceData['TariffList']['name'];?></td>     
	 
	<td align="right"><?php   
	echo $this->Number->format($serviceData['TariffAmount'][$chargeType],array('places'=>2,'decimal'=>'.','before'=>false,'thousands'=>false));
	?></td>
	<td><?php 
	if(isset($serviceData['EstimateServiceBill']['morning']) && $serviceData['EstimateServiceBill']['morning']!=0){
		echo $this->Html->image('icons/tick.png');
		//echo $this->Form->checkbox('', array('name'=>'morning_'.$serviceData['EstimateServiceBill']['id'],'id' => 'morning_'.$serviceData['EstimateServiceBill']['id'],'checked'=>'checked'));
		
	}else{
		echo $this->Html->image('icons/cross.png');
		//echo $this->Form->checkbox('', array('name'=>'morning_'.$serviceData['EstimateServiceBill']['id'],'id' => 'morning_'.$serviceData['EstimateServiceBill']['id']));
	}
	if(isset($serviceData['EstimateServiceBill']['morning_quantity']) && $serviceData['EstimateServiceBill']['morning_quantity'] != 0){
		echo '&nbsp;'.$serviceData['EstimateServiceBill']['morning_quantity'];
		$morningCost = $morningCost + ($serviceData['EstimateServiceBill']['morning_quantity']*$subServiceArr[$serviceData['EstimateServiceBill']['sub_service_id']]['cost']);
	}
	?></td>
	<td><?php 
	if(isset($serviceData['EstimateServiceBill']['evening']) && $serviceData['EstimateServiceBill']['evening']!=0){
		echo $this->Html->image('icons/tick.png');
		//echo $this->Form->checkbox('', array('name'=>'evening_'.$serviceData['EstimateServiceBill']['id'],'id' => 'evening_'.$serviceData['EstimateServiceBill']['id'],'checked'=>'checked'));
	}else{
		echo $this->Html->image('icons/cross.png');
		//echo $this->Form->checkbox('', array('name'=>'evening_'.$serviceData['EstimateServiceBill']['id'],'id' => 'evening_'.$serviceData['EstimateServiceBill']['id']));
	}
	if(isset($serviceData['EstimateServiceBill']['evening_quantity']) && $serviceData['EstimateServiceBill']['evening_quantity'] != 0){
		echo '&nbsp;'.$serviceData['EstimateServiceBill']['evening_quantity'];
		$eveningCost = $eveningCost + ($serviceData['EstimateServiceBill']['evening_quantity']*$subServiceArr[$serviceData['EstimateServiceBill']['sub_service_id']]['cost']);
	}
	?></td>
	<td><?php 
	if(isset($serviceData['EstimateServiceBill']['night']) && $serviceData['EstimateServiceBill']['night']!=0){
		echo $this->Html->image('icons/tick.png');
		//echo $this->Form->checkbox('', array('name'=>'night_'.$serviceData['EstimateServiceBill']['id'],'id' => 'night_'.$serviceData['EstimateServiceBill']['id'],'checked'=>'checked'));
	}else{
		echo $this->Html->image('icons/cross.png');
		//echo $this->Form->checkbox('', array('name'=>'night_'.$serviceData['EstimateServiceBill']['id'],'id' => 'night_'.$serviceData['EstimateServiceBill']['id']));
	}
	if(isset($serviceData['EstimateServiceBill']['night_quantity']) && $serviceData['EstimateServiceBill']['night_quantity'] != 0){
		echo '&nbsp;'.$serviceData['EstimateServiceBill']['night_quantity'];
		$nightCost = $nightCost + ($serviceData['EstimateServiceBill']['night_quantity']*$subServiceArr[$serviceData['EstimateServiceBill']['sub_service_id']]['cost']);
	}
	
	?></td>
	<td align="center"><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png',array('title'=>'Delete','alt'=>'Delete')), array('action' => 'deleteServices', $serviceData['EstimateServiceBill']['id'],$serviceData['EstimateServiceBill']['patient_id']), array('escape' => false),__('Are you sure?', true));?></td>
	</tr>
     <?php }if(empty($servicesData)){
     	?>
     	<tr><td>
     	<div align="center" style="border: 1px solid #3E474A; padding: 5px;" class="error">
     			No Record Found !! </div>
     			</td></tr>
     <?php } ?>
     </table>