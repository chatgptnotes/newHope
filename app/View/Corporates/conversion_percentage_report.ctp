<?php  echo $this->element("reports_menu");?>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php  echo __('Conversion Percentage Report', true); ?>
	</h3>
	<span><?php 
	echo $this->Html->link('Back',array('controller'=>'corporates','action'=>'lifespring_reports', 'admin'=>true),array('escape'=>false,'class'=>'blueBtn'));?> </span>
	<!-- <span style="float: right;"><?php	 
	echo $this->Html->link('Excel Report',array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',
'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));?></span> -->
	</div>
<?php echo $this->Form->create('physicianWiseList',array('type'=>get,'id'=>'physicianWiseList','url'=>array('controller'=>'corporates','action'=>'conversion_percentage_report','admin'=>false),
		'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));?>
<table width="62%" align="center">
	<tr>
		<td width="8%"><?php echo $this->Form->input('dateFrom',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateFrom",
						'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateFrom','placeholder'=>'Date From'));?>
		</td>
		<td width="8%"><?php echo $this->Form->input('dateTo',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateTo",
						'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateTo','placeholder'=>'Date To'));?>
		</td>
		
		<!-- <td width="4%"><?php echo $this->Form->input('doctors',array('id'=>"doctor",'options'=>$doctors,
 						'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'doctor','empty'=>'Select Doctor'));?>
		</td> -->
		<!-- <td width="16%" style="font-size:13px;"><?php echo $this->Form->input('Patients with multiple Appointment',array('type'=>'checkbox','id'=>"multiple",
						'div'=>false,'name'=>'multiple'));?> Patients with multiple Appointment
		</td> -->
		<td width="10%"><?php 
		echo $this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false)) ;
		?>
		</td>
	</tr>
</table>

<?php 
echo $this->Form->end();
?>

<div class="clr ht5"></div>
	<table width="80%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" align="center"> 
		<tr>
		  	<thead>
				
				<th width="5px" valign="top" align="center" style="text-align:center;">#</th>
				<th width="51px" valign="top" align="center" style="text-align:center;">Name Physician</th>
				<th width="60px" valign="top" align="center" style="text-align:center;">OPDs</th>
				 <th width="51px" valign="top" align="center" style="text-align:center;">No of Surgeries Performed</th>
				<!--<th width="51px" valign="top" align="center" style="text-align:center;">Date of Repair</th>
				<th width="60px" valign="top" align="center" style="text-align:center;">Status of Insurance claim</th> -->
				
	   		</thead>
      	</tr>
      
    
    
    <?php  $i=0; //debug($results);
    	foreach($pieData as $key=>$data) 
    	  {	
    	  	$patient_id = $result['Patient']['id'];
    	  	$bill_id = $result['FinalBilling']['id'];
    	  	$i++;  	
    ?>
     <tr>
    		<td width="8px" valign="top" align="center" style="text-align:center;">
    			<?php 
    				echo $i;
    			?>
    		</td>
    		<td width="55px" style="text-align:center;">
				<?php echo $data['name'];?>
			</td>
    		
    		<td width="66px" style="text-align:center;">
				<?php if(!empty($this->params->query)){
			echo $this->Html->link($data['count'],array('controller'=>$this->params->controller,'action'=>$this->params->action,'null',$key,
			'?'=>$this->params->query),array('target' => '_blank'));
		}else{
		echo $this->Html->link($data['count'],array('controller'=>$this->params->controller,'action'=>$this->params->action,'null',$key),array('target' => '_blank'));
		}?> 
			</td>
	    	
			<td width="66px" style="text-align:center;"><?php if(!empty($this->params->query)){
			echo $this->Html->link($data['surgery_count'],array('controller'=>$this->params->controller,'action'=>$this->params->action,'null','null',$key,
			'?'=>$this->params->query),array('target' => '_blank'));
		}else{
		echo $this->Html->link($data['surgery_count'],array('controller'=>$this->params->controller,'action'=>$this->params->action,'null','null',$key),array('target' => '_blank'));
		}?> </td>
    	

    <?php } ?>	
    </table>


<!--<table width="100%">
	<tr>
	<td><b>Physician Name</b></td>
	<td><b>No.of Patients</b></td>
	</tr>
	<?php //debug($this->params);
     foreach($pieData as $key=>$data){?>

		echo '<tr><td>'.$data['name'].'</td>';
		<td style="text-align:center;"><?php if(!empty($this->params->query)){
			echo $this->Html->link($data['count'],array('controller'=>$this->params->controller,'action'=>$this->params->action,'null',$key,
			'?'=>$this->params->query),array('target' => '_blank'));
		}else{
		echo $this->Html->link($data['count'],array('controller'=>$this->params->controller,'action'=>$this->params->action,'null',$key),array('target' => '_blank'));
		}?></td>
		</tr>
		
	<?php  }
     ?> 
	<tr>
	<td ><?php echo '<b> Total no.of Patients Arrived At Clinic'?></td>
	<td style="text-align:center;"><?php echo $totalPatient[0][0]['count'];?></td></tr>
	</table>-->
<script>
 $(document).ready(function (){ 
		
		
		$("#dateFrom").datepicker({
				showOn : "button",
				buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly : true,
				changeMonth : true,
				changeYear : true,
				dateFormat:'<?php echo $this->General->GeneralDate();?>',
				onSelect : function() {
					$(this).focus();
					$( "#seen-filter" ).trigger( "change" );
				}
		});
		$("#dateTo").datepicker({
			showOn : "button",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				$(this).focus();
				$( "#seen-filter" ).trigger( "change" );
			}
	});
 });
 </script>
