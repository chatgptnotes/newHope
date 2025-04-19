<div style="float:right;" id="printButton">
	<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
</div>
<style>
	.patientHub{width:70%;margin-left:20%}
	.boxBorder{border:1px solid #000000;}
	.boxBorderBot{border-bottom:1px solid #000000;}
	.boxBorderRight{border-right:1px solid #000000;}
	.tdBorderRtBt{border-right:1px solid #000000; border-bottom:1px solid #000000;}
	.tdBorderBt{border-bottom:1px solid #000000;}
	.tdBorderTp{border-top:1px solid #000000;}
	.tdBorderRt{border-right:1px solid #000000;}
	.tdBorderTpBt{border-bottom:1px solid #000000; border-top:1px solid #000000;}
	.tdBorderTpRt{border-top:1px solid #000000; border-right:1px solid #000000;}
	.columnPad{padding:5px;}
	.columnLeftPad{padding-left:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
</style>
 
<div class="clr ht5"></div>
<?php echo $this->element('print_patient_info');?>
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<div class="hindi-para"><h4>Patient Statement and Consent for Operation</h4>
 <p>I hereby authorize <strong><?php echo ucfirst($treating_consultant[0]['fullname']) ;?></strong>,and any associates or assistants of his
choice to perform upon me <strong><?php echo  ucfirst($patient[0]['lookup_name']) ;?></strong>.</p>

<p>I understand that the Procedure may serve in the progress of medical education therefore, I will allow/refuse  observers during my procedure. I also Consent/refuse  audio-visual documentation (photos/video0 of the procedure and its use for medical education and research. I understand that my privacy and identity will be protected at all times When I consent with the documentation .</p> 

<p>I recognize that during the course of the procedure, unforeseen conditions may necessitate additional or different procedures than those explained. I, therefore, further authorize and request my doctor and any associates or assistants of his choice perform such as are, in their professional judgement , necessary or appropriate for such procedures. </p>

<p>I understand that the proposed care may involves risks and possibilities of complications, and that certain complications have been known to follow the procedure to which I am consenting even when the utmost care, judgement and skill are used. I acknowledge that no guarantees have been made to me as to the results of the procedure, nor are there any guarantees against unfavourable results.</p>

<p>I accept the risks of substantial and serious harm, if any, in hopes of obtaining desired beneficial results of such care and acknowledge that the physicians involved have explained my condition, the proposed health care, and alternatives forms of treatment in a satisfactory manner.</p>

<p>The basic procedures of the proposed surgery, the advantages , disadvantages, risks, possible complications, and alternative treatments have been explained and discussed with me by my doctor. Although it is impossible for the doctor to inform me of every possible complication that may occur, the doctor has answered all my questions to  my satisfaction .<strong>In signing this consent form, I am stating I have read this form (or it has been read to me), and I fully understand it and the possible risks, complications and benefits that can result from the surgery. I also acknowledge that the doctor has addressed all of my concerns regarding this surgery</strong>.</p>

<p>
Patient's Name :  <?php echo  ucfirst($patient[0]['lookup_name']) ;?><br/>
<table width="100%">
<!--  signature part start-->
<tr><td>Patient signature:<br/><?php 
                            	     if($TracheostomyConsent['TracheostomyConsent']['patient_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$TracheostomyConsent['TracheostomyConsent']['patient_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 } ?></td><td><td>Witness signature:<br/><?php 
                            	     if($TracheostomyConsent['TracheostomyConsent']['witness_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$TracheostomyConsent['TracheostomyConsent']['witness_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 }?></td><td><td>Doctor signature:<br/><?php 
                            	     if($TracheostomyConsent['TracheostomyConsent']['doctor_sign'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$TracheostomyConsent['TracheostomyConsent']['doctor_sign'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 }?></td></tr></table>
Date:<?php echo  $this->DateFormat->formatDate2local($TracheostomyConsent['TracheostomyConsent']['date1'],Configure::read('date_format')); ?><br/>

</p>
<p>
As parent , guardian, caretaker, next of kin or other legal representative responsible for the patient whose name appears above on the appropriate signature line, I have read this document and, to the limit of the patient's understanding, I have discussed this informed consent  and its terms with the patient. Due to the patient's inability to sign this informed consent, I agree , on behalf of the patient, to sign for the patient and bind him/her to the terms of this informed consent.</p>
<p>
Name : <?php echo $TracheostomyConsent['TracheostomyConsent']['name'] ; ?><br/>
<table width="100%">
<!--  signature part start-->
<tr><td>Signature :<br/><?php 
                            	     if($TracheostomyConsent['TracheostomyConsent']['signature'] != "") { 
                            	       echo $this->Html->image('/signpad/'.$TracheostomyConsent['TracheostomyConsent']['signature'], array('alt' => 'Signature', 'title' => 'Signature', 'width' => '320', 'height' => '150'));
                            		 }?><br/>
Relationship to patient : <?php echo $TracheostomyConsent['TracheostomyConsent']['relationship'] ; ?><br/>
Date:<?php echo  $this->DateFormat->formatDate2local($TracheostomyConsent['TracheostomyConsent']['date2'],Configure::read('date_format')); ?> <br/>
</p>
</div>



 
  