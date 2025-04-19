<style>
.resizeIcon {
	height: 55px;
	width: 55px;
}
</style>
<div class="tab_dept"
	id="accounting_left_navigation" style="width: 220px">

	<?php
		echo $this->Html->link($this->Html->image('/img/icons/patient_hub/accounts_receivable.PNG'). ' ' . __('Account Receivable Managment'), array('controller'=>'Insurances','action' => 'claim_balance_company'), array('escape' => false,'title'=>'Account Receivable Managment','class'=>"row_modules"));
		echo $this->Html->link($this->Html->image('/img/icons/patient_hub/accounts_receivable.PNG'). ' ' . __('Account Receivable'), array('controller'=>'Accounting','action' => 'paymentRecieved'), array('escape' => false,'title'=>'Account Receivable','class'=>"row_modules"));
		echo $this->Html->link($this->Html->image('/img/icons/patient_hub/daysheet_1.PNG'). ' ' . __('Day Sheet Billing'), array('controller'=>'Billings','action' => 'daySheetBilling'), array('escape' => false,'title'=>'Day Sheet Billing','class'=>"row_modules"));
		echo $this->Html->link($this->Html->image('/img/icons/patient_hub/liveclaimsfeed_1.PNG'). ' ' . __('Live Claims Feed'), array('controller'=>'Billings','action' => 'liveClaimsFeed',$patient['Patient']['id']), array('escape' => false,'title'=>'Live Claims Feed','class'=>"row_modules"));
		echo $this->Html->link($this->Html->image('/img/icons/patient_hub/transactions_2.PNG'). ' ' . __('Live Claim FeedGraph'), array('controller'=>'Billings','action' => 'liveClaimFeedGraph'), array('escape' => false,'title'=>'Live Claim FeedGraph','class'=>"row_modules"));
		echo $this->Html->link($this->Html->image('/img/icons/patient_hub/billingsummary_1.PNG'). ' ' . __('Patient Eligibility Check'), array('controller'=>'Billings','action' => 'patientEligibilityCheck',$patient['Patient']['id']), array('escape' => false,'title'=>'Patient Eligibility Check','class'=>"row_modules"));
		echo $this->Html->link($this->Html->image('/img/icons/patient_hub/billingsummary_1.PNG'). ' ' . __('Edit/Error Management'), array('controller'=>'Insurances','action' => 'editErrorManagement'), array('escape' => false,'title'=>'Edit/Error Management','class'=>"row_modules"));
		echo $this->Html->link($this->Html->image('/img/icons/patient_hub/billingsummary_1.PNG'). ' ' . __('External Consultant Bill'), array('controller'=>'Billings','action' => 'patient_information',$patient['Patient']['id'],'null',true), array('escape' => false,'title'=>'External Consultant Bill','class'=>"row_modules"));
		echo $this->Html->link($this->Html->image('/img/icons/patient_hub/claim_submission_2.png'). ' ' . __('Claim Submission-First Scrubbing'), array('controller'=>'Insurances','action' => 'claimManager',$patient['Patient']['id'],true), array('escape' => false,'title'=>'Claim Submission-First Scrubbing','class'=>"row_modules"));
		echo $this->Html->link($this->Html->image('/img/icons/patient_hub/claim_submission_2.png'). ' ' . __('Cash Book'), array('controller'=>'billings','action' => 'dailyCashBook',true), array('escape' => false,'title'=>'Cash Book','class'=>"row_modules"));
	?>

</div>


<script>
	var ajaxcreateCredentialsUrl ="<?php echo $this->Html->url(array("controller" => "messages", "action" => "createCredentials","admin" => false)); ?>"; ;//

	function createPatientCredentials(patientid){

		$
		.fancybox({
			'width' : '50%',
			'height' : '50%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "messages", "action" => "openFancyBox", $patient['Patient']['person_id'],$patient['Patient']['id'])); ?>"
		});
		 
	}
	
	function getAllergiesAddEdit(){
		$.fancybox({
			'width' : '70%',
			'height' : '100%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'onComplete' : function() {
				$("#allergies").css({
					'top' : '20px',

					'bottom' : 'auto',	
					
});
			},
			'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "allallergies",$patient['Patient']['id'])); ?>"

		});
	}

	$("#clinical-summary").click(function(){
		$ .fancybox({
			'width' : '60%',
			'height' : '125%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "clinical_summary", $patient['Patient']['id'],$patient['Prson']['patient_uid'])); ?>"
		});
	}) ;

	$('#patient_permissions').click(function(){
		$ .fancybox({
			'width' : '60%',
			'height' : '125%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "patient_permissions", $patient['Patient']['id'])); ?>"
		});
	})
	
	</script>
