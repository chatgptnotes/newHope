<?php echo $this->Html->script(array('topheaderfreeze')) ;?>
<div class="inner_title">
	<h3>
		<?php echo __('Diagnosis Report', true); ?>
	</h3>
	<span>
		<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div>  

<?php echo $this->Form->create('DiagnosisReport',array('id'=>'diagnosis','type'=>'get'));?>

<table align="center" style="margin-top: 10px">
	<tr>
		<td><?php echo __("Select ICD10 Code :");?></td>
		<td>
		<?php echo $this->Form->input('DiagnosisReport.ICD_code', array('class'=>'textBoxExpnd','style'=>'width:120px','id'=>'ICD_code','label'=> false, 
				'div' => false, 'error' => false,'placeholder'=>'Select Code','value'=>$this->params->query['ICD_code']));
		?>
		</td>
		<td><?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?></td>
		<td><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'diagnosisReport'),array('escape'=>false));?></td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm" id="container-table">
				<thead>
					<tr> 
						<th width="2%" align="center" valign="top" style="text-align: center;"><?php echo __('Sr No');?></th> 
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('Gender');?></th> 
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('Age');?></th> 
						<th width="5%" align="center" valign="top" style="text-align: center;"><?php echo __('Patient ID');?></th> 
						<th width="20%" align="center" valign="top" style="text-align: center;"><?php echo __('Patient Name');?></th>
						<th width="20%" align="center" valign="top" style="text-align: center;"><?php echo __('Tariff');?></th>
					</tr> 
				</thead>
				
				<tbody>
				<?php 
				foreach($diagData as $key=> $userData) {
						
					?>
					<tr>
						<td align="left" valign="top" style= "text-align: center;">
							<?php echo $srNo=$key+1; ?>
						</td>
						<td valign="top" style= "text-align: center;">
							<?php echo strtoupper($userData['Patient']['sex']); ?>
						</td>
						<td valign="top" style= "text-align: center;">
							<?php echo strtoupper($userData['Patient']['age']); ?>
						</td>
						<td style= "text-align: center;">
							<?php echo $userData['Patient']['admission_id'];?>
						</td>
						<td style= "text-align: center;">
							<?php echo $userData['Patient']['lookup_name'];?>
						</td>
						<td style= "text-align: center;">
							<?php echo $userData['TariffStandard']['name'];?>
						</td>
						
				  	</tr>
			  	<?php }	
					?>
					
				</tbody>
			</table>

<script>
$(document).ready(function(){
	   $("#container-table").freezeHeader({ 'height': '500px' });
	   $('#ICD_code').autocomplete({
           
           source: "<?php echo $this->Html->url(array("controller" => "Diagnoses", "action" => "icdAutocomplete", "admin" => false, "plugin" => false)); ?>",
          // setPlaceHolder : false,
           select:function(event,ui){
           }, 
           messages: {
               noResults: '',
               results: function() {}
           }
       });
});
</script>