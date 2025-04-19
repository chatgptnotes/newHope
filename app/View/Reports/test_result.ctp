<?php  
	echo $this->Form->create('Patient', array('url'=>array('controller'=>'Reports','action'=>'testResult','pdf'),
			'id'=>'testResult','inputDefaults' => array('label' => false,'div' => false,'error'=>false,'legend'=>false,'O'))) ;
	
	$unserTestDetails=unserialize($testDetails['Patient']['test_result']);
	
	if($unserTestDetails){
		$date= $testDetails['Patient']['result_date'];
	}else{
		$date=date('d/m/Y h:i:s');
	}
?>
<table width="25%"  border="0" cellspacing="0"  cellpadding="1">
			<tr>
				<td colspan="3" align="center">-------------------------------------------------------------------------------------------------------------------------</td>
			</tr>
			<tr>
				<td  align="left">
				<?php echo __("i-STAT EG7+");?>
				</td>
			</tr>
			<tr>
				<td>Pt Name:</td>
				<td><?php echo $this->Form->input('patient_name',array('type'=>'text','class'=>'patient_name textBoxExpnd','id'=>"patient_name",
											'autocomplete'=>'off','label'=>false,'div'=>false,"placeholder"=>"Patient Name" ,'value'=>$unserTestDetails['patient_name']));
					echo $this->Form->hidden('patient_id',array('id'=>'patient_id','value'=>$unserTestDetails['patient_id']));?></td>
			</tr>
			<tr>
				 <td colspan="2" align="center">------------------------------------------------------</td>
			</tr>
			<tr>
				 <td align="left">37.0<sup>0</sup> C</td>
			</tr>
			<tr>
				 <td align="left">pH</td>
				 <td align="left"><?php echo $this->Form->input('pH',array('type'=>'text','id'=>'pH','class'=>'textBoxExpnd','label'=> false,'div' => false, 'error' => false,'value'=>$unserTestDetails['pH'] ))?></td>
			</tr>
			
			<tr>
				 <td align="left">PCO2</td>
				 <td align="left"><?php echo $this->Form->input('PCO2',array('type'=>'text','id'=>'pco','class'=>'textBoxExpnd','label'=> false,'div' => false, 'error' => false,'value'=>$unserTestDetails['PCO2']  ))?></td>
				 <td style="text-align: left;width: 26%">&nbsp;mmHg</td>
			</tr>
                   
            <tr>
				 <td align="left">PO2</td>
				 <td align="left"><?php echo $this->Form->input('PO2',array('type'=>'text','id'=>'po','class'=>'textBoxExpnd','label'=> false,'div' => false, 'error' => false,'value'=>$unserTestDetails['PO2']  ))?></td>
				 <td style="text-align: left">&nbsp;mmHg</td>
			</tr>
			
			<tr>
				 <td align="left">BEecf</td>
				 <td align="left"><?php echo $this->Form->input('BEecf',array('type'=>'text','id'=>'beecf','class'=>'textBoxExpnd','label'=> false,'div' => false, 'error' => false,'value'=>$unserTestDetails['BEecf']  ))?></td>
				<td style="text-align: left">&nbsp;mmo l/L</td>
			</tr>
			
			<tr>
				 <td align="left">HCO3</td>
				 <td align="left"><?php echo $this->Form->input('HCO3',array('type'=>'text','id'=>'hco','class'=>'textBoxExpnd','label'=> false,'div' => false, 'error' => false,'value'=>$unserTestDetails['HCO3']  ))?></td>
				<td style="text-align: left">&nbsp;mmo l/L</td>
			</tr>
			
			<tr>
				 <td align="left">TCO2</td>
				 <td align="left"><?php echo $this->Form->input('TCO2',array('type'=>'text','id'=>'tco','class'=>'textBoxExpnd','label'=> false,'div' => false, 'error' => false,'value'=>$unserTestDetails['TCO2']  ))?></td>
				<td style="text-align: left">&nbsp;mmo l/L</td>
			</tr>
			
			<tr>
				 <td align="left">sO2</td>
				 <td align="left"><?php echo $this->Form->input('sO2',array('type'=>'text','id'=>'so','class'=>'textBoxExpnd','label'=> false,'div' => false, 'error' => false,'value'=>$unserTestDetails['sO2']  ))?></td>
				<td style="text-align: left">%</td>
			</tr>  
			<tr>
				 <td colspan="2" align="center">------------------------------------------------------</td>
			</tr>
			
			<tr>
				 <td align="left">Na</td>
				 <td align="left"><?php echo $this->Form->input('Na',array('type'=>'text','id'=>'na','class'=>'textBoxExpnd','label'=> false,'div' => false, 'error' => false,'value'=>$unserTestDetails['Na'] ))?></td>
				 <td style="text-align: left">&nbsp;mmo l/L</td>
			</tr>  
			
			<tr>
				 <td align="left">K</td>
				 <td align="left"><?php echo $this->Form->input('K',array('type'=>'text','id'=>'k','class'=>'textBoxExpnd','label'=> false,'div' => false, 'error' => false,'value'=>$unserTestDetails['K'] ))?></td>
				 <td style="text-align: left">&nbsp;mmo l/L</td>
			</tr>
			
			<tr>
				 <td align="left">iCa</td>
				 <td align="left"><?php echo $this->Form->input('iCa',array('type'=>'text','id'=>'ica','class'=>'textBoxExpnd','label'=> false,'div' => false, 'error' => false,'value'=>$unserTestDetails['PCO2']  ))?></td>
				 <td style="text-align: left">&nbsp;mmo l/L</td>
			</tr>  
			<tr>
				 <td align="left">Hct</td>
				 <td align="left"><?php echo $this->Form->input('Hct',array('type'=>'text','id'=>'hct','class'=>'textBoxExpnd','label'=> false,'div' => false, 'error' => false,'value'=>$unserTestDetails['Hct'] ))?></td>
				 <td style="text-align: left">&nbsp;%PCV</td>
			</tr>   
			<tr>
				 <td align="left">Hb*</td>
				 <td align="left"><?php echo $this->Form->input('Hb',array('type'=>'text','id'=>'hb','class'=>'textBoxExpnd','label'=> false,'div' => false, 'error' => false,'value'=>$unserTestDetails['Hb'] ))?></td>
				 <td style="text-align: left">&nbsp;g/dl</td>
			</tr>
			<tr>
				 <td align="center">*Via Hct</td>
				 
			</tr>
			<tr>
				 <td align="left">CPB: No</td>
			</tr>
			<tr>
				 <td align="left"><?php echo $this->Form->input('result_date', array('id' => 'resultDate', 'label'=> false, 'div' => false, 'error' => false,
					'autocomplete'=>false,'class'=>' textBoxExpnd', 'div' => false,'type'=>'text','value'=>$date));?></td>
			</tr>
			
			<tr>
				 <td align="left">Operator ID:</td>
			</tr>
			
			<tr>
			      <td align="left">Physician: </td>
				 <td align="left"> _____________
				 </td>
			</tr>
			<tr>
				 <td align="left" style="width: 45%">Lot Number:426W151130236</td>
			</tr>
			<tr>
				 <td align="left">Serial:358440</td>
			</tr>
			<tr>
				 <td align="left">Version:JAMS139C</td>
			</tr>
			<tr>
				 <td align="left">CLEW:A30</td>
			</tr>
			<tr>
				 <td align="left">Custom:00000000</td>
			</tr>
			
			<tr>
				 <td colspan="2" align="center">------------------------------------------------------</td>
			</tr>
			
			<tr>
				 <td align="left">Reference Ranges</td>
			</tr>
			<tr>
				 <td align="left">pH</td>
				 <td align="left">7.130 &nbsp;&nbsp;&nbsp;7.410</td>
			</tr>
			<tr>
				 <td align="left">PCO2</td>
				 <td align="left">41.0 &nbsp;&nbsp;&nbsp;51.0  mmHg</td>
			</tr>
			<tr>
				 <td align="left">PO2</td>
				 <td align="left">80 &nbsp;&nbsp;&nbsp;105  mmHg</td>
			</tr>
			<tr>
				 <td align="left">BEecf</td>
				 <td align="left">-6 &nbsp;&nbsp;&nbsp;3  mmo l/L</td>
			</tr>
			<tr>
				 <td align="left">HCO3</td>
				 <td align="left">12.0 &nbsp;&nbsp;&nbsp;28.0  mmo l/L</td>
			</tr>
			<tr>
				 <td align="left">TCO2</td>
				 <td align="left">18 &nbsp;&nbsp;&nbsp;29  mmo l/L</td>
			</tr>
			<tr>
				 <td align="left">sO2</td>
				 <td align="left">48 &nbsp;&nbsp;&nbsp;98 %</td>
			</tr>
			<tr>
				 <td align="left">Na</td>
				 <td align="left">138 &nbsp;&nbsp;&nbsp;146 mmo l/L</td>
			</tr>
			<tr>
				 <td align="left">K</td>
				 <td align="left">3.5 &nbsp;&nbsp;&nbsp;4.9 mmo l/L</td>
			</tr>
			<tr>
				 <td align="left">iCa</td>
				 <td align="left">1.12 &nbsp;&nbsp;&nbsp;1.32 mmo l/L</td>
			</tr>
			<tr>
				 <td align="left">Hct</td>
				 <td align="left">38 &nbsp;&nbsp;&nbsp;51 %PCV</td>
			</tr>
			<tr>
				 <td align="left">Hb*</td>
				 <td align="left">12.0 &nbsp;&nbsp;&nbsp;17.0 g/dL</td>
			</tr>
			<tr>
				<td colspan="3" align="center">-------------------------------------------------------------------------------------------------------------------------</td>
			</tr>
			
			<tr>
				 <td colspan="3" align="right">
                                     <?php 
                                        //echo $this->Form->submit(__('Save & Generate PDF'), array('class'=>'blueBtn','div'=>false,'id'=>'submit'));
                                        echo $this->Form->submit(__('Save'), array('class'=>'blueBtn','div'=>false,'id'=>'submit'));

				 echo $this->Html->link(__('Back'),array('controller'=>'reports','action' => 'iStatReport','admin'=>false),array('escape' => false,'class'=>'blueBtn','title'=>'Back')) ;?></td>
			</tr>
			
		</table>
<?php echo $this->Form->end();?>
<script>

$(document).ready(function(){	
	$('#patient_name').autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete",'no',"admin" => false,"plugin"=>false)); ?>",
			select: function(event,ui){	
				$("#patient_id").val(ui.item.id);		
		},
		 messages: {
	         noResults: '',
	         results: function() {},
	   },
	});

	$("#resultDate").datepicker({
		showOn: "both",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		buttonText: "Calendar",
		changeMonth: true,
		changeYear: true,
		changeTime:true, 
        showTime: true,  		
		yearRange: '1950',			 
		dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
		onSelect : function() {
		}	
	});	
});


</script>