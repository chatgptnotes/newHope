<style>
	@media print {

	#printButton {
		display: none;
	}

	table {
        page-break-inside: auto;
      }
      tr {
        page-break-inside: avoid;
        page-break-after: auto;
      }
      thead {
        display: table-header-group;
      }
      tfoot {
        display: table-footer-group;
      }
}

</style>

<div style="float:right;" id="printButton">
	<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
</div>
  
    <!-- Right Part Template -->
  	<div align="center" valign="top" class="heading" style="text-decoration:none;">
     	 Claim Submission Check List
  	</div> 
    <?php $claimSubmissionCheckList = array(
    '1'=>'Cliam submission check list (All the document should be completely filled or else the claim file will not be submittedfor payment)',
    '2'=>'Copy of Approval Letter',
    '3'=>'Copy of initial Intimation Letter',
    '4'=>'Copy of Unit Officer Member Verification Letter',
    '5'=>'MPKAY ID Card',
    '6'=>'Police ID card',
    '7'=>'NOC From District Unit Where Hospital Is Situated',
    '8'=>'Enhancement Certificate from Unit (In case of Execeeding Bills & Stay)',
    '9'=>'Application for Reimburesement',
    '10'=>'Annexure-1',
    '11'=>'Family Declaration',
    '12'=>'Dependency Certificate',
    '13'=>'Family Planning  Certificate Whenever Necessary.',
    '14'=>'Certificate For Unemployment of wife',
    '15'=>'Emergency Certificate',
    '16'=>'Stay Certificate',
    '17'=>'Form C',
    '18'=>'Form D',
    '19'=>'Discharge Card. In Case of Death Cerificate (Form no 4 copy)& Death Summary Compulsory. OT Notes With Date Of Operation.',
    '20'=>'Original Pharmacy Prescription & Bills Signed By Employee & Doctor.',
    '21'=>'Cosolidated Pharmacy List',
    '22'=>'Original Hospital Consolidated Bill with break -up',
    '23'=>'Original Investigation Reports With Invetigation Bill Break up with Stamp & Sign of Hospital.',
    '24'=>'Copy Of MLC/FIR Report (In Case Of RTA) / Injury Certificate (In Case Of Fall with Stamp & sign of Sr Police Inspector.',
    '25'=>'Indoor Case  Papers',
    '26'=>'All the above Documents should be Signed & Stamped By Hospital Authority Except Member Verification Letter & Member Forms',

);
?>
<?php 
        $unserializeChecklist = unserialize($checkList['ClaimSubmissionChecklist']['checklist']);
        if($checkList['ClaimSubmissionChecklist']['admission_date']){
            $admissionDate = $this->DateFormat->formatDate2Local($checkList['ClaimSubmissionChecklist']['admission_date'],Configure::read('date_format'),true);
        }

        if($checkList['ClaimSubmissionChecklist']['discharge_date']){
            $dischargeDate = $this->DateFormat->formatDate2Local($checkList['ClaimSubmissionChecklist']['discharge_date'],Configure::read('date_format'),true);
        }
        

?>  
    
   <table width="100%" border="1" cellspacing="1" cellpadding="3" class="">
    <tr>
        <td><?php echo __('Name of Hospital'); ?></td>
        <td>:</td>
        <td><?php echo $this->Session->read('facility');?></td>
    </tr>
    <tr>
        <td><?php echo __('Name of Patient'); ?></td>
        <td>:</td>
        <td><?php echo $patientData['Patient']['lookup_name'];?></td>
    </tr>
    <tr>
        <td><?php echo __('Date of Admission'); ?></td>
        <td>:</td>
        <td><?php echo $admissionDate ;
            ?>
                    
        </td>
    </tr>
    <tr>
        <td><?php echo __('Date of Discharge'); ?></td>
        <td>:</td>
        <td><?php echo $dischargeDate; 
            ?>
                    
        </td>
    </tr>
</table>
 <table width="100%" border="1" cellspacing="1" cellpadding="3" class="">
    <tr>
        <td colspan="3" align="center"><?php echo "Documents" ?></td>
      
    </tr>
    <?php foreach ($claimSubmissionCheckList as $key => $value) { ?>
            
    <tr>
        <td><?php echo $key; ?></td>
        <td><?php echo $value; ?></td>
        <td><?php echo $unserializeChecklist[$key];
            ?>
                    
        </td>
    </tr>

    <?php } ?>

</table>


			        