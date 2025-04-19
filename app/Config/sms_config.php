<?php
	/**
	sms configuration for message text and other configuration
	@Mahalaxmi
	**/

	//BOF-SMS Mgment Configuration Parameters-Mahalaxmi
	//$config['sms_host_name'] = 'localhost';  //192.168.1.5'
	$config['sms_host_name'] = '192.168.8.8';  
	$config['sms_external_host_name'] = '117.247.90.119'; 
	$config['sms_test_host_name']='192.168.8.254'; 
	$config['sender_id'] = 'DrHope';//'DrHope';
	$config['user_name'] = 'drmone';//'drmone';
	$config['pwd'] ='747095';//'747095';	
	$config['url'] = 'http://login.smsgatewayhub.com/smsapi/pushsms.aspx';
	$config['hosp_details'] = 'Hope hospitals (Call 08412030400 for details).';
	//$config['owner_no'] ='8087235965'; //9373111709----Dr. Murali Sir
	$config['owner_no'] ='9373111709'; //9373111709----Dr. Murali Sir 
	/***Remove ruby no-9373111709,7276623928***/
	$config['administrator_no'] ='9850341544'; //9850341544 ---Administrator-Shrikant
//We have give a options to send SMS multiple places 
	$config['sms_active']=array('0'=>'IPD Patient Registration','1'=>'Full Bill','2'=>'Discharge Patient','3'=>'Refund','4'=>'Discount','5'=>'Bed Transfer','6'=>'Radiology Request','7'=>'External Radiology Request','8'=>'OT Appointment','9'=>'Payment Voucher','10'=>'Receipt Voucher','11'=>'Hope2Sms','12'=>'Advance Billing','13'=>'Medication Remainder','14'=>'NOC Remainder','15'=>'Discount Request','16'=>'Discount Request Approval','17'=>'Cashier Handover');
	$config['sms_configuration_name']='SMS';
	$config['sms_confirmation']='yes';
	$config['sms_not_confirmation']='no';
	$config['rgjayOtSchedule'] ='9373111709,9423441926'; //9373111709----Dr. Murali Sir,7276623928--Ruby Maam---9423441926-Dr.Pallavi
	/***Remove ruby no-,7276623928,9373111709***/
	$config['hopeTwoSmsManageNo'] ='8956237137'; //9850341544 ---HOPE2SMS-Manage
	//EOF-SMS Mgment Configuration Parameters-Mahalaxmi	
		

	
		
	//HOPE2SMS
	$config['hopeTwoSMS'] = "%s";
	$config['hopeTwoSMSReturnToOwnerForMultiple'] = "Sent SMS to %s of Mobile %s-%s";
	$config['hopeTwoSMSReturnToOwnerForSingle'] = "Sent SMS to Mobile %s-%s";
	//HOPE2SMS
	$config['full_payment_msg'] ='We have received Rs. %d from you for availing various services.A Balance amount of Rs. %d is pending in your account . Please Pay as soon as possible! - %s';
	
	$config['full_payment_msg_withoutBal'] ='We have received Rs. %d from you for availing various services- %s';
	

	//$config['owner_final_bill']='(%s)Pt. %s(%s) %s with diagnosis of %s is discharged for %s - %s';
	//$config['owner_final_bill_withoutDia']='(%s)Pt. %s(%S) %s is discharged %s - %s';
	$config['owner_final_bill_withoutSurgery']='(%s)Pt. %s(%s) %s discharged.';
	$config['owner_final_bill_withSurgery']='(%s)Pt. %s(%s) %s discharged %s.';

	$config['DischargeDeathReferringDoc']='We regret to inform that your (%s)pt. %s(%s) %s expired today.-%s';
	$config['DischargeDeathReferringDocReturn']='Sent to %s -We regret to inform that your (%s)pt. %s(%s) %s expired today.';

	$config['DischargeOtherReasonReferringDoc']='Your (%s)pt. %s(%s) %s discharged today. He is being sent to you for review.';
	$config['DischargeOtherReasonReferringDocFemale']='Your (%s)pt. %s(%s) %s discharged today. She is being sent to you for review.';
	$config['DischargeOtherReasonReferringDocReturn']='Sent to %s -Your (%s)pt. %s(%s) %s discharged today. He is being sent to you for review.';
	$config['DischargeOtherReasonReferringDocReturnFemale']='Sent to %s -Your (%s)pt. %s(%s) %s discharged today. She is being sent to you for review.';

	
	
	$config['advance_msg_patient_ralative'] ='%s जो होप अस्पताल में भर्ती है । उसका आज तक का  अस्पताल का बिल %d रूपए है । इसके अलावा एडवांस डिपाजिट %d रूपए भरना है । आपको  बकाया %d रूपए आज दो घंटे के पहले भरना है ।-%s';


	$config['payment_voucher'] ='Cash payment of Rs.%d made to %s.';
	$config['payment_voucher_with_narration'] ='Cash payment of Rs.%d made to %s- %s.';
	$config['reciept_voucher'] ='Cash receipt of Rs.%d was from %s.';
	$config['reciept_voucher_with_narration'] ='Cash receipt of Rs.%d was from %s - %s.';

	$config['OwnerOT'] ='(%s)Pt. %s(%s) %s with diagnosis of %s scheduled on %s at %s under surgeon %s and Anaesthetist %s for %s in %s.';
	$config['OwnerOTWithoutAnas'] ='(%s)Pt. %s(%s) %s with diagnosis of %s scheduled on %s at %s under surgeon %s for %s in %s.';

	$config['OwnerOTWithoutdia'] ='(%s)Pt. %s(%s) %s scheduled on %s at %s under surgeon %s and Anaesthetist %s for %s in %s.';
	$config['OwnerOTWithoutdiaAnas'] ='(%s)Pt. %s(%s) %s scheduled on %s at %s under surgeon %s for %s in %s.';

	$config['OTPhysicianNO']='%s for (%s)Pt. %s(%s) %s scheduled on %s at %s in %s.- %s';
	$config['OTAnasthestistOTAssistantNO']='%s for (%s)Pt. %s(%s)(%s) %s scheduled on %s at %s under surgeon %s in %s.';
	$config['OTPatientNO']='Your surgery scheduled on %s at %s in %s. - %s ';


	/*BOF-Patient Reg 7 SMS*/
	$config['otherConsultantSms']='(%s)Pt. %s(%s) admitted in %s%s bed under you.-%s'; //for send other consultant mobile no.
	$config['RegReferringDocReffDocNo']='Your (%s)Pt. %s(%s) %s is being admitted under Dr. %s today.- %s';
	$config['RegReferringDocReffDocNoReturn']='Sent to %s. Your (%s)Pt. %s(%s) %s is being admitted under Dr. %s today.- %s';
	

	$config['regPhysicianOwnerNo']='(%s)Pt. %s(%s) %s admitted in %s%s bed under you.- %s';
	$config['regPhysicianOwnerNowithReferingDoc']='(%s)Pt. %s(%s) %s admitted in %s%s bed under you and referred by %s %s ,Contact No. %s.- %s';
	$config['regPhysicianOwnerNowithReferingDocNone']='(%s)Pt. %s(%s) %s admitted in %s%s bed under you and Pt. is a direct admission.- %s';	
	$config['regPhysicianOwnerNowithReferingDocNoneWithAddress']='(%s)Pt. %s(%s) %s admitted in %s%s bed under you and Pt. is a direct admission, Address : %s.- %s';
	
	//For Referal Doc
//	$config['regSendToOwnerForReferalDoc']='A patient of %s %s contact no.%s has been admitted.- %s'; //Only send to Murali Sir

	//$config['regSendToOwnerForNoneReferalDoc']='The patient is a direct admission,Name : %s.- %s'; //Only send to Murali Sir
	//$config['regSendToOwnerForNoneReferalDocwithAdd']='The patient is a direct admission,Name : %s,Address : %s.- %s'; //Only send to Murali Sir
	$config['regPatientRelativeNo']='(%s)Pt. %s(%s) assigned %s%s bed under Dr. %s.- %s';
	$config['regPatientMobile']='You have been assigned %s%s bed under Dr. %s.- %s';
		
	$config['bedTransfer']='Your (%s)pt. %s(%s) %s is transferred from %s bed %s%s to %s bed. %s%s.- %s';

	/*EOF-Patient Reg 7 SMS*/
		
	//BOF-Claim SMS 
	$config['claimSmsPreAuth']='Today is the 15th day after pre-auth approved. Time limit is 30 days for uploading surgery notes and treatment sheet. Name of Pt. : %s ,Pre_auth approved on :%s ,Deadline : %s.- %s';

	$config['claimSmsClaimRej']='This case was rejected %s days back. Justification has to be given before 20 days.Please send justification letter today. Name of Pt. : %s ,Claim Rejected on :%s ,Deadline for justification: %s.- %s';

	//$config['claimSms']='A patient name %s %s on date %s should be updated by date %s.- %s';
	$config['cordinator_rgjay_mobile_no'] ='9373111709,9423441926,8956007094,9325692295';  /***Remove ruby no-,7276623928,9373111709-Murali sir,***/
	//Dr.Murali,Ruby Maam,Dr.Pallavi Mobile No.,cordinator by RGJAY Mobile No.
	//$config['cordinator_rgjay_mobile_no'] ='8087235965'; // for testing
	//EOF-Claim SMS 

	//Scan upload 
	$config['upload']='Radiology report uploaded for pt. %s.';
	//$config['upload_withoutdia']='Radiologist-%s has uploaded a radiology report of pt. %s.';
	$config['upload_mobile_no']='9373111709,8412030400,7840960289,8600306395'; //Dr.Murali,Ruby Maam,Hope hospital Counter no, Naresh,Pratik
	/***Remove ruby no-,7276623928,9373111709,***/
	//$config['upload_mobile_no']='8087235965'; //Dr.Murali,Dr.Pallavi Mobile No.,Dr. Reena Mobile No.
	//

	//For Pharamacy Exceed 1/3rd

	$config['pharmacy_exceed_msg']='The pharmacy amount of Rs.%d for this pt. %s exceeds the 1/%s of package amount (Rs.%d) is Rs.%d.-%s';
	$config['pharmacy_exceed_mobile_no']='9373111709,9850341544,9960880189,9423441926,9970216998';
	/***Remove ruby no-,7276623928,9373111709,***/
	//Dr.Murali,Ruby,Shrikant,Vinod,Pallavi,Dr.Reena Rao Mobile No.        
    $config['pharmacy_exceed_tenThousand_msg']='The pharmacy amount for this pt. %s is Rs.%d that exceeds 10,000.-%s';
        
	$config['is_file_not_submitted_msg'] = "Pt. %s has come for review, %s has missing document or photo that must to be taken from %s.";
    $config['is_file_not_submitted_mobiles'] = '9373111709,9423441926,9325692295,8657395829'; 
	/***Remove ruby no-,7276623928,9373111709,***/
	
	//Dr.Murali,Ruby Maam,Dr.Pallavi, Zaid, Asit (RGJAY Team)

	$config['radiology_request']='Report requested for pt. %s(%s) %s to %s.-%s';
	$config['radiology_request_return']='Sent SMS-Report requested for pt. %s(%s) %s to %s.';
	$config['radiologist_manager']='7840960289,8600306395'; //Naresh & Pratik

	$config['medication_msg']='%s यह दवा आज %s को लेना है| ';

	//BOF-Before discharge Take Noc to inform patient
	$config['noc_msg']='Please take %d days NOC for pt. %s(%s).';
	//$config['MPKAY_NOC']='8087235965';
	$config['MPKAY_NOC']='8605283820,9665911916,9850341544,9373111709,8956007094'; /***Remove ruby no-,7276623928,9373111709,***/
	//'','','shrikant','murali','ruby','ml','seher'
	//$config['SECR_CGHS_ECHS_NOC']='8087235965';
	$config['SECR_CGHS_ECHS_NOC']='9561813223,8087933549,8805967912,9850341544,9373111709';//Kunal,Manoj parate,Ashok rakhade,shrikant bhalerao,murali sir,ruby mam,ml	
	/***Remove ruby no-,7276623928,9373111709,***/
	$config['OwnerDiscountRequest']='%s is requested for pt. %s.Total bill amt. is Rs. %d.';	 
	$config['OwnerDiscountRequestApproval']='%s is approved for pt. %s.Total bill amt. is Rs. %d.';
	$config['cashHanover']='Cash in account room is %d and Handover to next Cashier is %d.';
	$config['CahsierNo'] ='9373111709,8805369043'; //9373111709----Dr. Murali Sir 8805369043

?>