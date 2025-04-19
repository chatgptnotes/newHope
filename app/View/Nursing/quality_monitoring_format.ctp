<style>
/*.tddate img{float:right;}*/
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
</style>
<script>
	$(function() {
	// For Skin Peeling / Pressure Ulcers
		$("#skin").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'			
		});	
			
	// For Thrombophlebits
	 $("#thrombophlebits").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'		
		});

	// For Blockage of Tubes / Lines
	$("#blockage").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'			
		});

	// For Accidental removal of Tubes / Lines
	$("#accidental").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'			
		});

	// For Patient_falls
	$("#patient_falls").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>'		
		});

	// For Date Insertion
	$("#date_insertion").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
			onSelect:function(){$(this).focus();}
			
		});
	
	// For Date Removel
	$("#date_removel").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			minDate:"+0D",			
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
			onSelect:function(){$(this).focus();}
	
				
		});
	});

</script>
<script>
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
	jQuery("#itemfrm").validationEngine();
	});
</script>

<div class="inner_title">
	<h3>
		<?php echo __('Nursing Sensitive Quality Indicators Monitoring Format'); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Back', true),array('controller'=>'nursings','action' => 'patient_information/',$this->params['pass'][0]), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>
<div class="clr ht5"></div>
<?php echo $this->element('patient_information');?>
<div class="clr ht5"></div>
<form name="itemfrm" id="itemfrm"
	action="<?php echo $this->Html->url(array("controller" => $this->params['controller'], "action" => "quality_monitoring_format/".$this->params['pass'][0], )); ?>"
	method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="0"
		class="tabularForm">
		<tr>
			<th width="40" style="text-align: center;">Sr.No.</th>
			<th width="190" style="text-align: center; min-width: 130px;">Parameters</th>
			<th width="160" style="text-align: center;">Date Observed</th>
			<th width="160" style="text-align: center;">Site with Extent of
				Injury</th>
			<th width="140" style="text-align: center;">Action Taken</th>
			<th style="text-align: center;">Remarks</th>
		</tr>
		<tr>
			<td align="center">1</td>
			<td>Skin Peeling / Pressure Ulcers</td>
			<td class="tddate"><?php 
			if(!empty($this->request->data['QualityMonitoringFormat']['skin_observed_date'])) {
				$skin_observed_date = explode(' ',$this->request->data['QualityMonitoringFormat']['skin_observed_date']);
				$this->request->data['QualityMonitoringFormat']['skin_observed_date'] = $this->DateFormat->formatDate2Local($this->request->data['QualityMonitoringFormat']['skin_observed_date'],Configure::read('date_format'),true);
			}
			echo $this->Form->input('QualityMonitoringFormat.skin_observed_date', array('type'=>'text','id'=>'skin','label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd','readonly'=>'readonly'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.skin_site',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.skin_action',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.skin_remark',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:90%;'));?>
			</td>
		</tr>
		<tr>
			<td align="center">2</td>
			<td>Thrombophlebits</td>
			<td  class="tddate"><?php 
			if(!empty($this->request->data['QualityMonitoringFormat']['thrombophlebits_observed_date'])) {
				$thrombophlebits_observed_date = explode(' ',$this->request->data['QualityMonitoringFormat']['thrombophlebits_observed_date']);
				$this->request->data['QualityMonitoringFormat']['thrombophlebits_observed_date'] = $this->DateFormat->formatDate2Local($this->request->data['QualityMonitoringFormat']['thrombophlebits_observed_date'],Configure::read('date_format'),true);
			}

			echo $this->Form->input('QualityMonitoringFormat.thrombophlebits_observed_date', array('type'=>'text','id'=>'thrombophlebits','label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd','readonly'=>'readonly'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.thrombophlebits_site',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.thrombophlebits_action',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.thrombophlebits_remark',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:90%;'));?>
			</td>
		</tr>
		<tr>
			<td align="center">3</td>
			<td>Blockage of Tubes / Lines</td>
			<td class="tddate"><?php 
			if(!empty($this->request->data['QualityMonitoringFormat']['blockage_observed_date'])) {
				$blockage_observed_date = explode(' ',$this->request->data['QualityMonitoringFormat']['blockage_observed_date']);
				$this->request->data['QualityMonitoringFormat']['blockage_observed_date'] = $this->DateFormat->formatDate2Local($this->request->data['QualityMonitoringFormat']['blockage_observed_date'],Configure::read('date_format'),true);
			}
			echo $this->Form->input('QualityMonitoringFormat.blockage_observed_date', array('type'=>'text','id'=>'blockage','label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd','readonly'=>'readonly'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.blockage_site',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.blockage_action',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.blockage_remark',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:90%;'));?>
			</td>
		</tr>
		<tr>
			<td align="center">4</td>
			<td>Accidental removal of Lines / Tubes</td>
			<td class="tddate"><?php 
			if(!empty($this->request->data['QualityMonitoringFormat']['accidential_line_observed_date'])) {
				$accidential_line_observed_date = explode(' ',$this->request->data['QualityMonitoringFormat']['accidential_line_observed_date']);
				$this->request->data['QualityMonitoringFormat']['accidential_line_observed_date'] = $this->DateFormat->formatDate2Local($this->request->data['QualityMonitoringFormat']['accidential_line_observed_date'],Configure::read('date_format'),true);
			}
			echo $this->Form->input('QualityMonitoringFormat.accidential_line_observed_date', array('type'=>'text','id'=>'accidental','label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd','readonly'=>'readonly'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.accidential_line_site',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.accidential_line_action',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.accidential_line_remark',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:90%;'));?>
			</td>
		</tr>
		<tr>
			<td align="center">5</td>
			<td>Patient Falls</td>
			<td class="tddate"><?php 
			if(!empty($this->request->data['QualityMonitoringFormat']['patient_fall_observed_date'])) {
				$patient_fall_observed_date = explode(' ',$this->request->data['QualityMonitoringFormat']['patient_fall_observed_date']);
				$this->request->data['QualityMonitoringFormat']['patient_fall_observed_date'] = $this->DateFormat->formatDate2Local($this->request->data['QualityMonitoringFormat']['patient_fall_observed_date'],Configure::read('date_format'),true);
			}
			echo $this->Form->input('QualityMonitoringFormat.patient_fall_observed_date', array('type'=>'text','id'=>'patient_falls','label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd','readonly'=>'readonly'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.patient_fall_site',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.patient_fall_action',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.patient_fall_remark',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:90%;'));?>
			</td>
		</tr>
	</table>
	<div class="clr">&nbsp;</div>

	<table width="100%" border="0" cellspacing="1" cellpadding="0"
		class="tabularForm">
		<tr>
			<th width="40" style="text-align: center;">Sr. No.</th>
			<th width="100" style="text-align: center; min-width: 100px;">Invasive
				Lines</th>
			<th width="200" style="text-align: center;">DOI with specification <br />(Type,
				Size &amp; Site)
			</th>
			<th width="160" style="text-align: center;">Site</th>
			<th width="140" style="text-align: center;">DOR with Condition of the
				Site</th>
			<th style="text-align: center;">Remarks</th>
		</tr>
		<tr>
			<td align="center">1</td>
			<td>RT / NGT</td>
			<td><?php 
			//echo $this->Form->hidden('QualityMonitoringFormat.rt_ngt_invasive', array('id'=>'rt_ngt_invasiveParameter','label'=> false, 'div' => false, 'error' => false));
			echo $this->Form->input('QualityMonitoringFormat.rt_ngt_doi_specification',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:200px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.rt_ngt_site',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.rt_ngt_dor',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.rt_ngt_remark',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'min-width:92%;'));?>
			</td>
		</tr>
		<tr>
			<td align="center">2</td>
			<td>Others (TMPI)</td>
			<td><?php 
			//echo $this->Form->hidden('QualityMonitoringFormat.other_invasive', array('id'=>'rt_ngt_invasiveParameter','label'=> false, 'div' => false, 'error' => false));
			echo $this->Form->input('QualityMonitoringFormat.other_doi_specification',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:200px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.other_site',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.other_dor',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'width:150px;'));?>
			</td>
			<td><?php echo $this->Form->input('QualityMonitoringFormat.other_remark',array('legend'=>false,'label'=>false,'div'=>false,'style'=>'min-width:92%;'));?>
			</td>
		</tr>
	</table>
	<div class="clr">&nbsp;</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td  align="right" >Date Of Insertion :<font color="red">*</font>&nbsp;
			</td>
			<td class="tddate" >
				<?php 
						if(!empty($this->request->data['QualityMonitoringFormat']['date_insertion'])) {
						$splitInsertion = explode(' ',$this->request->data['QualityMonitoringFormat']['date_insertion']);
						$this->request->data['QualityMonitoringFormat']['date_insertion'] = $this->DateFormat->formatDate2Local($this->request->data['QualityMonitoringFormat']['date_insertion'],Configure::read('date_format'),true);
					}
					echo $this->Form->input('QualityMonitoringFormat.date_insertion',array('type'=>'text','id'=>'date_insertion','class' => 'validate[required,custom[dateSelect]] textBoxExpnd','legend'=>false,'label'=>false,'div'=>false,'readonly'=>'readonly'));?>
					
			</td>
			<td width="50%"></td>
			<td align="right" >Date of Removal :<font color="red">*</font>&nbsp;
			</td>
			<td  class="tddate"  ><?php 
						if(!empty($this->request->data['QualityMonitoringFormat']['date_removel'])) {
						$splitRemovel = explode(' ',$this->request->data['QualityMonitoringFormat']['date_removel']);
						$this->request->data['QualityMonitoringFormat']['date_removel'] = $this->DateFormat->formatDate2Local($this->request->data['QualityMonitoringFormat']['date_removel'],Configure::read('date_format'),true);
					 }
					 echo $this->Form->input('QualityMonitoringFormat.date_removel',array('type'=>'text','id'=>'date_removel','class' => 'validate[required,custom[dateSelect]] textBoxExpnd','legend'=>false,'label'=>false,'div'=>false,'readonly'=>'readonly'));?>
						
			</td>
			
		</tr>
	</table>
	<div class="btns">
		<input type="submit" value="Save" id="submit" class="blueBtn"
			tabindex="17" />
		<?php
			
		if(!empty($count)){
				echo $this->Html->link(__('Print'),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'print_quality_monitoring_format',$this->params['pass'][0]))."', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=1000,left=(screen.1000 - 1000)/2), top=(screen.800 - 800)/2, height=800');  return false;"));
					
			} ?>

	</div>
	<form>
		<div class="clr ht5"></div>
		<script>
// On submit get validate the inputs	
	$(document).ready(function(){
	 $("#submit").click(function() {
		return getValidate();
	 });

	})
	function getValidate(){

		var SDate = document.getElementById('date_insertion').value.split('-');
		var EDate = document.getElementById('date_removel').value.split('-');    

		/*if (SDate == '' || EDate == '') {
		  alert("Plesae enter dates!");
		  return false;
		}*/

		
		var endDate = Date.parse(EDate);
		var startDate = Date.parse(SDate);
		
		if(startDate > endDate)
		{
			alert("Please ensure that the 'Insertion' Date is greater than or equal to the 'Removel' Date.");
			//theForm.txtEnd.focus();
			return false;
		}
		
	}
</script>