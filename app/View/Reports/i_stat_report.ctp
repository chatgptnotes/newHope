<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Submit i-STAT EG7+ Report', true);?>
	</h3>
	<span><?php echo $this->Html->link(__('Add'),array('controller'=>'reports','action' => 'testResult'),array('escape' => false,'class'=>'blueBtn','title'=>'Add Result'));
echo $this->Html->link(__('Back'),array('controller'=>'reports','action' => 'all_report','admin'=>true),array('escape' => false,'class'=>'blueBtn','title'=>'Back')) ;?></span>	
</div>
<table width="100%" cellspacing="1" cellpadding="0" border="0"
	class="tabularForm" style="clear: both;">
	<tr>
		<th>Sr.No</th>
		<th>Patient Name</th>
		<th>Patient Id</th>
		<th>Age/Sex</th>
		<th>Action</th>
	</tr>
	<?php 
	$srNo=1;
	foreach($patientData as $key => $value){ 
		?>
	<tr>
		<td ><?php echo $srNo;?>
		</td>
		<td ><?php echo $value['Patient']['lookup_name'] ; ?>
		</td>
		<td ><?php echo $value['Patient']['patient_id']; ?>
		</td>
		<td ><?php echo $value['Patient']['age']."/".$value['Patient']['sex']; ?>
		</td>
		<td ><?php echo  $this->Html->link($this->Html->image('icons/edit-icon.png',array('title'=>'Edit','alt'=>'Edit')), array('action' => 'testResult', $value['Patient']['id']), array('escape' => false));?>
                 <?php 
                   echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:16px;width:16px;')),'javascript:void(0);',
				array('onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'printTestResult',$value['Patient']['id']))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print'));
                 
                 //echo  $this->Html->link($this->Html->image('icons/view-icon.png',array('title'=>'View','alt'=>'View')), array('action' => 'testResult', $value['Patient']['id']), array('escape' => false));?></td>
	</tr>
	<?php $srNo++;} ?>
</table>

<script>
    var print="<?php echo isset($this->params->query['print'])?$this->params->query['print']:'' ?>";   
    if(print != ''){ 
        var url="<?php echo $this->Html->url(array('controller'=>'Reports','action'=>'printTestResult',$_GET['print'])); ?>";
        window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200"); 
    }	
</script>