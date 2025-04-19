<?php if($action=='print' && !empty($echoId)){
    echo "<script>var openWin = window.open('".$this->Html->url(array("controller" => "Radiologies",'action'=>'printEchoServiceResult',$patientId,$radID,$testOrderID,$echoId))."', '_blank',
                       'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
                window.location='".$this->Html->url(array('action'=>'radDashBoard','?'=>array('conditionalFlag'=>$conditionalFlag)))."'</script>"  ;
   }?>
   
<style>
.tabularForm td {
    padding: 1px 4px !important;
}
.alignR{
float: right;
}
.blueBtn{
height: 23px !important;
}
</style>
<?php
echo $this->Html->script(array('topheaderfreeze')); ?> 
<div class="inner_title">
	<h3>Radiology Result</h3>
</div>
<?php $unserData=unserialize($serviceDetails['Radiology2DEchoResult']['comment']);
?>
<?php  echo $this->Form->create('Radiology2DEchoResult' ,array('id'=>'radResultfrm','type'=>'POST','inputDefaults' => array('label' => false, 'div' => false,'error'=>false)));
       echo $this->Form->hidden('Radiology2DEchoResult.radiology_id',array('value'=>$this->params->pass[1]));
	   echo $this->Form->hidden('Radiology2DEchoResult.patient_id',array('value'=>$this->params->pass[0]));
	   echo $this->Form->hidden('Radiology2DEchoResult.radiology_test_order_id',array('value'=>$this->params->pass[2]));
	   echo $this->Form->hidden('Radiology2DEchoResult.id',array('value'=>$this->params->pass[3	]));
?>
<?php $ageExp=explode(" ", $patientData['Patient']['age']);
	  $age=$ageExp[0];
	  if($patientData['Patient']['sex']=='male'){
	  	$sex="M";
	  }else if($patientData['Patient']['sex']=='female'){
	  	$sex="F";
	  }	  
	  ?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" align="center">
	<tr>
	<td style="float: right" colspan="6">
			<?php 	echo $this->Html->link(__('Cancel'), array('action'=>'radDashBoard','?'=>array('conditionalFlag'=>$conditionalFlag)), array('escape' => false,'class' => 'blueBtn','id'=>'	'));
				echo "&nbsp;&nbsp;";
				echo $this->Form->hidden('Radiology2DEchoResult.status',array('class'=>'status'));
				//echo $this->Form->submit(__('Save'), array('id'=>'save','title'=>'Save','escape' => false,'class' => 'blueBtn save','label' => false,'div' => false,'error'=>false));
				//echo "&nbsp;&nbsp;";
				echo $this->Form->submit(__('Save & Print'), array('id'=>'saveAndPrint','title'=>'Save','escape' => false,'class' => 'blueBtn saveAndPrint','label' => false,'div' => false,'error'=>false));
				?>
	</td>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" align="center" class="tabularForm" >
  <tr>
  	<td colspan="6" style="text-align: center;font-size: 21px"><b><?php echo "ECHO WITH COLOR DOPPLER";?></b></td>
  </tr>
  <tr>
    <td><?php echo __("Name");?></td>
    <td><strong><?php echo $patientData['Patient']['lookup_name'] ;?></strong></td>
    <td><?php echo __("Age/Sex");?></td>
    <td><strong><?php echo $age." / ".ucfirst($patientData['Patient']['sex']); ?></strong></td>
    <td><?php echo __("Date");?></td>
    <td><?php
    	if(!empty($serviceDetails['Radiology2DEchoResult']['result_date'])){
    		$newDate = $this->DateFormat->formatDate2Local($serviceDetails['Radiology2DEchoResult']['result_date'],Configure::read('date_format'),true);
    	}else{
    		$newDate =  $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
    	}
	    
	    echo $this->Form->input('result_date', array('class'=>'textBoxExpnd','type'=>'text','id' => 'result_publish_date','autocomplete'=>'off','value'=>$newDate)); ?></td>
  </tr>
 
</table>


<table width="100%" cellpadding="0" cellspacing="1" border="0" align="center" class="tabularForm" id="tableList1">
   
	<tr>
	 	<td style="text-align: left;">Aorta</td>
	 	<td style="text-align: left;"><?php echo $this->Form->input('aorta', array('id' => 'aorta','autocomplete'=>'off','tabindex'=>'1','value'=>$serviceDetails['Radiology2DEchoResult']['aorta'])); ?></td>
	 	<td style="text-align: left;">LVID(d)</td>
	 	<td style="text-align: left;"><?php echo $this->Form->input('lvid_d', array('id' => 'lvid_d','autocomplete'=>'off','tabindex'=>'2','value'=>$serviceDetails['Radiology2DEchoResult']['lvid_d'])); ?></td>
	</tr>
	
	<tr>
	 	<td style="text-align: left;">AV cusp opening</td>
	 	<td style="text-align: left;"><?php echo $this->Form->input('av_cusp_opening', array('id' => 'av_cusp_opening','autocomplete'=>'off','tabindex'=>'3','value'=>$serviceDetails['Radiology2DEchoResult']['av_cusp_opening'])); ?></td>
	 	<td style="text-align: left;">LVID(s)</td>
	 	<td style="text-align: left;"><?php echo $this->Form->input('lvid_s', array('id' => 'lvid_s','autocomplete'=>'off','tabindex'=>'4','value'=>$serviceDetails['Radiology2DEchoResult']['lvid_s'])); ?></td>
	</tr>
	<tr>
	 	<td style="text-align: left;">Left Atrium</td>
	 	<td style="text-align: left;"><?php echo $this->Form->input('left_atrium', array('id' => 'left_atrium','autocomplete'=>'off','tabindex'=>'5','value'=>$serviceDetails['Radiology2DEchoResult']['left_atrium'])); ?></td>
	 	<td style="text-align: left;">IVS(d)</td>
	 	<td style="text-align: left;"><?php echo $this->Form->input('ivs_d', array('id' => 'ivs_d','autocomplete'=>'off','tabindex'=>'6','value'=>$serviceDetails['Radiology2DEchoResult']['ivs_d'])); ?></td>
	</tr>
	<tr>
	 	<td style="text-align: left;">LVEF</td>
	 	<td style="text-align: left;"><?php echo $this->Form->input('lvef', array('id' => 'lvef','autocomplete'=>'off','tabindex'=>'7','value'=>$serviceDetails['Radiology2DEchoResult']['lvef'])); ?></td>
	 	<td style="text-align: left;">LVPW(d)</td>
	 	<td style="text-align: left;"><?php echo $this->Form->input('lvpw_d', array('id' => 'lvpw_d','autocomplete'=>'off','tabindex'=>'8','value'=>$serviceDetails['Radiology2DEchoResult']['lvpw_d'])); ?></td>
	</tr>
	<tr>
	 	<td style="text-align: left;">Right Atrium</td>
	 	<td style="text-align: left;"><?php echo $this->Form->input('right_atrium', array('id' => 'right_atrium','autocomplete'=>'off','tabindex'=>'9','value'=>$serviceDetails['Radiology2DEchoResult']['right_atrium'])); ?></td>
	 	<td style="text-align: left;">Right Ventricle(d)</td>
	 	<td style="text-align: left;"><?php echo $this->Form->input('right_ventricle_d', array('id' => 'right_ventricle_d','autocomplete'=>'off','tabindex'=>'10','value'=>$serviceDetails['Radiology2DEchoResult']['right_ventricle_d'])); ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">Septum</td>
		<td colspan="3"><?php echo $this->Form->textarea('septum', array('id' => 'septum','autocomplete'=>'off','tabindex'=>'11','value'=>$serviceDetails['Radiology2DEchoResult']['septum'])); ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">Cardiac valves</td>
		<td colspan="3"><?php echo $this->Form->textarea('cardiac_valves', array('id' => 'cardiac_valves','autocomplete'=>'off','tabindex'=>'12','value'=>$serviceDetails['Radiology2DEchoResult']['cardiac_valves'])); ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">Wall motion abnormality</td>
		<td colspan="3"><?php echo $this->Form->textarea('wall_motion_abnormality', array('id' => 'wall_motion_abnormality','autocomplete'=>'off','tabindex'=>'131','value'=>$serviceDetails['Radiology2DEchoResult']['wall_motion_abnormality'])); ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">LVEF</td>
		<td colspan="3"><?php echo $this->Form->textarea('lvef_text', array('id' => 'lvef_text','autocomplete'=>'off','tabindex'=>'14','value'=>$serviceDetails['Radiology2DEchoResult']['lvef_text'])); ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">LV clot/ vegetation/ pericardial effusion</td>
		<td colspan="3"><?php echo $this->Form->textarea('lv_clot_vegetation', array('id' => 'lv_clot_vegetation','autocomplete'=>'off','tabindex'=>'15','value'=>$serviceDetails['Radiology2DEchoResult']['lv_clot_vegetation'])); ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">IVC</td>
		<td colspan="3"><?php echo $this->Form->textarea('ivc', array('id' => 'ivc','autocomplete'=>'off','tabindex'=>'16','value'=>$serviceDetails['Radiology2DEchoResult']['ivc'])); ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">E/A</td>
		<td ><?php echo $this->Form->textarea('ea', array('id' => 'ea','autocomplete'=>'off','tabindex'=>'17','value'=>$serviceDetails['Radiology2DEchoResult']['ea'])); ?></td>
		<td style="text-align: left;">Diastolic Dysfunction</td>
		<td ><?php echo $this->Form->textarea('diastolic_dysfunction', array('id' => 'diastolic_dysfunction','autocomplete'=>'off','tabindex'=>'17','value'=>$serviceDetails['Radiology2DEchoResult']['diastolic_dysfunction'])); ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">PASP by TR jet</td>
		<td colspan="3"><?php echo $this->Form->textarea('pasp_by_tr_jet', array('id' => 'pasp_by_tr_jet','autocomplete'=>'off','tabindex'=>'18','value'=>$serviceDetails['Radiology2DEchoResult']['pasp_by_tr_jet'])); ?></td>
	</tr>

</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" align="center" class="tabularForm" id="tableList1">
	<thead>
	<tr>
		<th></th>
		<th>PG mm of Hg</th>
		<th>MG mm of Hg</th>
		<th>Grades of Regurgitation</th>
	</tr>
	<tr>
		<td>Mitral Valve</td>
		<td><?php echo $this->Form->input('mitral_valve_pg', array('id' => 'mitral_valve_pg','autocomplete'=>'off','tabindex'=>'6','value'=>$serviceDetails['Radiology2DEchoResult']['mitral_valve_pg'])); ?></td>
		<td><?php echo $this->Form->input('mitral_valve_mg', array('id' => 'mitral_valve_mg','autocomplete'=>'off','tabindex'=>'6','value'=>$serviceDetails['Radiology2DEchoResult']['mitral_valve_mg'])); ?></td>
		<td><?php echo $this->Form->input('mitral_valve_grade', array('id' => 'mitral_valve_grade','autocomplete'=>'off','tabindex'=>'6','value'=>$serviceDetails['Radiology2DEchoResult']['mitral_valve_grade'])); ?></td>
	</tr>
	<tr>
		<td>Aortic Valve</td>
		<td><?php echo $this->Form->input('aortic_valve_pg', array('id' => 'aortic_valve_pg','autocomplete'=>'off','tabindex'=>'6','value'=>$serviceDetails['Radiology2DEchoResult']['aortic_valve_pg'])); ?></td>
		<td><?php echo $this->Form->input('aortic_valve_mg', array('id' => 'aortic_valve_mg','autocomplete'=>'off','tabindex'=>'6','value'=>$serviceDetails['Radiology2DEchoResult']['aortic_valve_mg'])); ?></td>
		<td><?php echo $this->Form->input('aortic_valve_grade', array('id' => 'aortic_valve_grade','autocomplete'=>'off','tabindex'=>'6','value'=>$serviceDetails['Radiology2DEchoResult']['aortic_valve_grade'])); ?></td>
	</tr>
	<tr>
		<td>Tricuspid Valve</td>
		<td><?php echo $this->Form->input('tricuspid_valve_pg', array('id' => 'tricuspid_valve_pg','autocomplete'=>'off','tabindex'=>'6','value'=>$serviceDetails['Radiology2DEchoResult']['tricuspid_valve_pg'])); ?></td>
		<td><?php echo $this->Form->input('tricuspid_valve_mg', array('id' => 'tricuspid_valve_mg','autocomplete'=>'off','tabindex'=>'6','value'=>$serviceDetails['Radiology2DEchoResult']['tricuspid_valve_mg'])); ?></td>
		<td><?php echo $this->Form->input('tricuspid_valve_grade', array('id' => 'tricuspid_valve_grade','autocomplete'=>'off','tabindex'=>'6','value'=>$serviceDetails['Radiology2DEchoResult']['tricuspid_valve_grade'])); ?></td>
	</tr>
	<tr>
		<td>Pulm Valve/RVOT</td>
		<td><?php echo $this->Form->input('pulm_valve_pg', array('id' => 'pulm_valve_pg','autocomplete'=>'off','tabindex'=>'6','value'=>$serviceDetails['Radiology2DEchoResult']['pulm_valve_pg'])); ?></td>
		<td><?php echo $this->Form->input('pulm_valve_mg', array('id' => 'pulm_valve_mg','autocomplete'=>'off','tabindex'=>'6','value'=>$serviceDetails['Radiology2DEchoResult']['pulm_valve_mg'])); ?></td>
		<td><?php echo $this->Form->input('pulm_valve_grade', array('id' => 'pulm_valve_grade','autocomplete'=>'off','tabindex'=>'6','value'=>$serviceDetails['Radiology2DEchoResult']['pulm_valve_grade'])); ?></td>
	</tr>
</thed>
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" align="center" class="tabularForm" id="tableList1">
	<tr>
	    <td style="text-align: center;">FINAL IMPRESSION</td>
	 	<td style="text-align: center;" colspan="5"><?php echo $this->Form->input('', array('name'=>"data[Radiology2DEchoResult][final_impression]",'type'=>"textarea",	'id' => 'final_impression',
	 			'class'=>'textBoxExpnd','autocomplete'=>'off','maxlength'=>'700','value'=>$serviceDetails['Radiology2DEchoResult']['final_impression'])); ?></td>
	</tr>
	
</table>
<table width="100%" cellpadding="0" cellspacing="1" border="0" align="center">
	<tr>
		<td style="float: right" colspan="6">
			<?php 	echo $this->Html->link(__('Cancel'), array('action'=>'radDashBoard','?'=>array('conditionalFlag'=>$conditionalFlag)), array('escape' => false,'class' => 'blueBtn','id'=>'	'));
				echo "&nbsp;&nbsp;";
				echo $this->Form->hidden('Radiology2DEchoResult.status',array('class'=>'status'));
				//echo $this->Form->submit(__('Save'), array('id'=>'save','title'=>'Save','escape' => false,'class' => 'blueBtn save','label' => false,'div' => false,'error'=>false));
				//echo "&nbsp;&nbsp;";
				echo $this->Form->submit(__('Save & Print'), array('id'=>'saveAndPrint','title'=>'Save','escape' => false,'class' => 'blueBtn saveAndPrint','label' => false,'div' => false,'error'=>false));
				
				?>
	</td>
	</tr>
</table>
<script>
$(document).ready(function(){
$("#tableList").freezeHeader({ 'height': '500px' });
$( "#result_publish_date" ).datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true, 
	yearRange: '1950',	
	maxDate:new Date(), 
	dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
    onSelect:function(){	
    }
});

$(".saveAndPrint").click(function(){
	$(".status").val('Completed');
});
/*$(".save").click(function(){
	$(".status").val('Updated');
});*/
/*var print="<?php echo isset($this->params->pass[3])?$this->params->pass[3]:'' ?>";
if(print){
	       var url="<?php echo $this->Html->url(array('controller'=>'Radiologies','action'=>'printEchoServiceResult',$this->params->pass[0],$this->params->pass[1],$this->params->pass[2],$this->params->pass[3])); ?>"
	        window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200");
       
	}*/	
});
</script>