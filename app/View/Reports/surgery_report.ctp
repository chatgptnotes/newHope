<style>
body{
font-size:13px;
}
.red td{
	background-color:antiquewhite !important;
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
</style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<?php if($type != 'excel') { ?>
<div class="inner_title">
	<h3>
		<?php echo __('Surgery Report', true); ?>
	</h3>
	<span>
		<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div> 
<?php }else{ ?>
	<table>
		<tr>
			<th colspan="8">
			
				<?php echo __('Surgery Report', true); ?>
		
			</th>
		</tr>
	</table>
<?php } ?>
<?php echo $this->Form->create('Patient',array('type'=>'get','id'=>'Patient','url'=>array('controller'=>'Reports','action'=>'surgery_report','admin'=>false),));?>
<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="95%" valign="top">
		<?php if($type != 'excel') { ?>
		<table align="center" style="margin-top: 10px">
			<tr>
				<td><?php echo $this->Form->input('Patient.from_date', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'from_date','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Select Date','value'=>$this->params->query['from_date']));?></td>
				<td><?php echo $this->Form->input('Patient.to_date', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'to_date','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Select Date','value'=>$this->params->query['to_date']));?></td>

				<td><?php echo $this->Form->input('Patient.internal_surgery_name', array('class'=>'textBoxExpnd','style'=>'width:150px','id'=>'internal_surgery_name','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Internal Surgery','value'=>$this->params->query['internal_surgery_name']));
				 echo $this->Form->hidden('Patient.internal_surgery_id',array('id'=>'internal_surgery_id','value'=>$this->params->query['internal_surgery_id']))

			?></td>

				<!-- <td><?php echo $this->Form->input('Patient.surgery_for_billing', array('class'=>'textBoxExpnd','style'=>'width:150px','id'=>'surgery_for_billing','label'=> false, 'div' => false, 'error' => false,'placeholder'=>'Billing Surgery','value'=>$this->params->query['surgery_for_billing']));
						  echo $this->Form->hidden('Patient.surgery_for_billing_id',array('id'=>'surgery_for_billing_id','value'=>$this->params->query['surgery_for_billing_id']));
			?></td>
 -->
			

			
				<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?></td>
				<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'surgery_report'),array('escape'=>false));?></td>
				
				<?php if($this->params->query){
						$qryStr=$this->params->query;
						}?>
				
				<td><?php echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>'Reports','action'=>'surgery_report','excel','?'=>$qryStr,'admin'=>false,'alt'=>'Export To Excel'),array('escape'=>false,'title' => 'Export To Excel'))?><?php echo $this->Form->end();?></td>
			</tr>
		</table>
		<?php $border = '0' ;  }else{  $border = '1' ; }?>
		<div id="container">
		    	<?php
// Doctor ID aur naam ke liye array
$doctorNames = array(
    65 => "Dr. Sandip Meshram (anaesthesia)",
    72 => "Dr. Vinay Kulkarni MBBS, DA, DNB",
    73 => "Dr. Shrikant Bobade MBBS, MD (Anaes.)",
    98 => "Dr. Dipali Gomase",
    105 => "Dr. Manisha Pakhmode MBBS, DA",
    122 => "Dr. Rajendra Jikar MBBS, MD (Anaes.)",
    123 => "Dr. Pranali Shende MBBS, MD (Anaes.)",
    124 => "Dr. Indhrajeet Agrawal MBBS, MD (Anaes.)",
    130 => "Dr. Rajkumari Wadhwani",
    148 => "Dr. R N Sugandh",
    162 => "Dr. Gagan Agrawal",
    166 => "Dr. E N Qureshi",
    167 => "Dr. Neha Madam",
    171 => "Dr. Jayant Nikose",
    172 => "Dr. Vikrant Sawarkar",
    173 => "Dr. Raksha Anaesthetic",
    174 => "Dr. Ravi Gubani",
    177 => "Dr. S Jambhorkar",
    178 => "Dr. Sagar Chimalwar",
    179 => "Dr. Suhas Ambade",
    183 => "Dr. Dilip Wasnik",
    204 => "Dr. Sumit Jaiswal",
    212 => "Dr. Vinod Borkar",
    226 => "Dr. Monika Raghuwanshi",
    281 => "Dr. Rachana Naitam",
    416 => "Dr. Sachin Gondane",
    467 => "Dr. Rajesh Diwedi",
    291 => "Dr. Nilesh Sarojkar",
    495 => "Dr. Samir Tarsekar",
    510 => "Dr. Sameer Tarsekar (Anasthetic)"
);
?>
			<table width="100%" cellpadding="0" cellspacing="1" border="<?php echo $border ;  ?>" 	class="tabularForm">
			    <button id="downloadBtnsurgery" style=" background: green; color: white; ">Download Excel</button>

				<thead>
					<tr> 
						<th width="2%" align="center" valign="top"><?php echo __('Sr.No');?></th> 
						<th width="15%" align="center" valign="top"><?php echo __('Patient Name');?></th> 
						<th width="7%" align="center" valign="top" style="text-align: center;"><?php echo __('Admission ID');?></th> 
						<th width="10%" align="center" valign="top" style="text-align: center;"><?php echo __('Age/Gender');?></th> 
						<th width="20%" align="center" valign="top" style="text-align: center;"><?php echo __('Surgery For Billing');?></th> 
						<th width="20%" align="center" valign="top" style="text-align: center;"><?php echo __('Surgery For Internal Report & Yojna');?></th> 
						<th width="7%" align="center" valign="top" style="text-align: center;"><?php echo __('Schedule Date');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Surgeon');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Anaesthetist');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Description');?></th> 

					</tr> 
				</thead>
				
				<tbody>
				<?php 
				$i = 1 ;
				foreach($record as $key=> $value) { 
						if($value['Patient']['lookup_name'] == '') continue;
						$explodeAge = explode(" ", $value['Patient']['age']);
 					?>
 					

					<tr>
						<td><?php echo $i ; ?></td>
						<td><?php echo $value['Patient']['lookup_name'] ; ?></td>
						<td><?php echo $value['Patient']['admission_id'] ; ?></td>
						<td><?php echo $explodeAge[0]." / ".ucfirst($value['Patient']['sex']) ; ?></td>
						<td><?php echo $value['Surgery']['name'] ; ?></td>
						<td><?php echo $value['TariffList']['name'] ; ?></td>
						<td><?php echo $this->DateFormat->formatdate2Local($value['OptAppointment']['schedule_date'],Configure::read('date_format'),false); ?></td>
						<td><?php echo $value['DoctorProfile']['doctor_name'] ; ?></td>
						<td>
                            <?php 
                                // Backend se aayi department ID ko fetch karna
                                $departmentId = $value['OptAppointment']['department_id'];
                        
                                // Agar ID array mein hai to naam dikhao, warna 'Unknown Doctor' dikhao
                                echo isset($doctorNames[$departmentId]) ? $doctorNames[$departmentId] : "Unknown Doctor";
                            ?>
                        </td>
						<td><?php echo $value['OptAppointment']['description'] ; ?></td>
				  	</tr>
			  	<?php $i++; }?>
				</tbody>
		
			
			</table>
		</div>
	</td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<!--download excel @7387737062-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
document.getElementById('downloadBtnsurgery').addEventListener('click', function () {
    // Excel डाटा तैयार करें
    const table = document.querySelector('.tabularForm');
    const wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
    
    // Excel फाइल डाउनलोड करें
    XLSX.writeFile(wb, 'patient_records.xlsx');
});
</script>
<script>

$(document).ready(function(){
	
	
 	$("#from_date").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});

	$("#to_date").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',
		maxDate: new Date(),
		dateFormat: '<?php echo $this->General->GeneralDate();?>',	 		
	});

	$("#internal_surgery_name").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "NewOptAppointments", "action" => "getPackageSurgeryAutocomplete","admin" => false,"plugin"=>false)); ?>",
		setPlaceHolder : false,
			select:function( event, ui ) {				     
				$('#internal_surgery_id').val(ui.item.id);
		},
		messages: {
	        noResults: '',
	        results: function() {}
	 	}
	});

	$("#surgery_for_billing").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "NewOptAppointments", "action" => "getSurgeryAutocomplete","admin" => false,"plugin"=>false)); ?>",
		setPlaceHolder : false,
			select:function( event, ui ) {				     
				$('#surgery_for_billing_id').val(ui.item.id);
		},
		messages: {
	        noResults: '',
	        results: function() {}
	 	}
	});

});
</script>
	