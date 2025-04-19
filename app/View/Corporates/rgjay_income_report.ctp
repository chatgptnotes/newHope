<style> 
	.tabularForm {
	    background: none repeat scroll 0 0 #d2ebf2 !important;
	}
	.tabularForm td {
	    background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
	    padding: 5px 10px;
	}
    .tabularForm td {
       border: 1px black;
    }
    .greenn{
    	color: green;
    }
    .redd{
    	background: #ff5b2d none repeat scroll 0 0 !important;
	}
</style>
<?php
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
	<h3>
		<?php echo __('RGJAY Income Report', true); ?>
	</h3>
	<span>
		<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Corporates','action' => 'rgjay_income_report','admin'=>false), array('escape' => false,'class'=>'blueBtn'));?>
	</span>	
</div> 
<?php 
	echo $this->Form->create('rgjayIncome',array('type' => 'GET',
		'url' => array('controller' => 'Corporates', 'action' => 'rgjay_income_report'),'class'=>'manage','style'=>array("float"=>"left","width"=>"100%"),'id'=>'HeaderForm','inputDefaults' => array(
				'label' => false,
				'div' => false,
				'error' => false
		)
));
?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="95%" valign="top">
		<table align="center" style="margin-top: 10px">
		<?php if(!empty($this->request->query['from_date'])){
				$from = $this->request->query['from_date'];
			}else{
				$from = date("d/m/Y", strtotime("last month"));
			}
			
			if(!empty($this->request->query['to_date'])){
				$to = $this->request->query['to_date'];
			}else{
				$to = date("d/m/Y");
			}
		?>
			<tr>
				<td><?php echo __("Patient Name : ")."&nbsp;".$this->Form->input('patient_name', array('id' => 'patient_name','label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'name','placeholder'=>'Patient Name'));
						echo $this->Form->hidden('patient_id', array('id' => 'patient_id','label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));?></td>
				<td><?php echo __("Package Name : ")."&nbsp;".$this->Form->input('package_name', array('id' => 'package_name','label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'name','placeholder'=>'Package Name')); ?></td>
				<td><?php echo $this->Form->input('from_date', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'fromDate','label'=> false, 'div' => false, 'error' => false,'value'=>$from,'placeholder'=>'From Date'));?></td>
				<td><?php echo $this->Form->input('to_date', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'toDate','label'=> false, 'div' => false, 'error' => false,'value'=>$to,'placeholder'=>'To Date'));?></td>
				<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?></td>
				<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'), array('controller'=>'Corporates','action'=>'rgjay_income_report', 'admin'=>false),array('id'=>'refresh','class' => 'refresh', 'escape' => false, 'title' => 'Refresh'));?></td>
				<td><?php //echo $this->Html->link($this->Html->image('icons/printer.png',array('title'=>'Print Daily Collection Details')),'#',
						//array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Accounting','action'=>'daily_collection_details_print','?'=>array('date'=>$date)))."', '_blank',
						//'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1200,height=600,left=200,top=200');  return false;")); ?></td>
				<?php if($this->params->query){
						$qryStr=$this->params->query;
				}?>
				<td><?php /* echo $this->Html->link($this->Html->image('icons/excel.png'),
						array('controller'=>'Corporates','action'=>'rgjay_income_report','excel','?'=>$qryStr,'admin'=>false,'alt'=>'Export To Excel'),
						array('escape'=>false,'title' => 'Export To Excel')) */?>
				
				<?php echo $this->Form->end();?>
				</td>
			</tr>
		</table>
<div style="width:100%;float: left;max-height:550px;overflow:scroll;">
<table width="100%" border="0" cellspacing="" cellpadding="5" class="tabularForm" align="center">
    <thead>
        <tr>
            <th width="" style="text-align:center"><b>Patient Name</b></th>
            <th width="" style="text-align:left"><b>Discharge Status</b></th>
            <th width="" style="text-align:left"><b>Package Name</b></th>
            <th width="" style="text-align:left"><b>Package Cost</b></th>
            <th width="" style="text-align:left"><b>Total Package Cost</b></th>
            <th width="" style="text-align:left"><b>Expense Incurred</b></th> 
            <th width="" style="text-align:left	"><b>Profit/Loss</b></th>
        </tr>  
    </thead>
    
    <?php
    foreach($packgeArray as $patientId=> $patient){ 
		//if($packgeArray[$patient['Patient']['id']]['patient_name']){
		$totalPackage = $patient['rgjay_package'];								// Package amount
		$expeceAmount = $patient['total_amount'] - $patient['rgjay_package']; 	// Total services amount - Package amount
		$profitLoss = $totalPackage - $expeceAmount;							// only service amount
		$admissionId = $patient['admission_id'];
		
		if($patient['is_discharge'] == 1){
			$dischargeStatus = "Discharged";
		}else if($patient['is_discharge'] == 0){
			$dischargeStatus = "Not Discharged";
		}
	?>
	
   <tr>
   		<td><?php echo $patient['patient_name'];?></td>
   		<td><?php echo $dischargeStatus;?></td>
   		<td><?php $cnt=1; 
   		if(count($patient['package_name'])>1){
   			foreach($patient['package_name'] as $package){
   		 			echo $cnt.". ".$package."<br>"; 
   		 			$cnt++;
   				}
   		}else{
			echo $patient['package_name'][0];
		}
   		 	?>
   		</td>	
   		<td><?php $cntt=1;
   			foreach($patient['package_cost'] as $package){
   		 			echo $package."<br>"; 
   		 			$cntt++;
   				}
   		 	?> 
   		</td>
   		<td><?php echo $patient['rgjay_package'];?></td>
   		<td><?php echo $this->Html->link(__($expeceAmount), array('controller'=>'Billings','action' => 'multiplePaymentModeIpd',$patientId), array('escape' => false,'class'=>''));?></td>
   		<?php if($profitLoss<0){?>
   		<td><font color="red" weight="bold"><?php echo -$profitLoss;?></font></td>
   		<?php }?>
   		<?php if($profitLoss>0){?>
   		<td><font color="green"><?php echo $profitLoss;?></font></td>
   		<?php }?>
   	</tr>
   <?php //}
		} ?>
    
</table>

<script>
$(document).ready(function(){
 	$("#fromDate").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});

 	$("#toDate").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});


 	 /*$("#package_name").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "tariffs", "action" => "autocomplete","TariffList","name",'null','null','null',"admin" => false,"plugin"=>false)); ?>",
			select: function(event,ui){				
		  },
		 messages: {
	         noResults: '',
	         results: function() {},
	      },
	});*/
});
 	$(function() {
		$("#package_name").autocomplete("<?php echo $this->Html->url(array("controller" => "tariffs", "action" => "autocomplete","TariffList","name",'null','null','null', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true 
			});

		$("#patient_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name", "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst:true 
			});
	});


 		
</script>