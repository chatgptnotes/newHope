<?php 
$dateofbirth=explode("-",$UIDpatient_details['Person']['dob']);
$subscriberDob=explode(" ",$patient_insurance_details['NewInsurance']['subscriber_dob']);
$subscriberDob=explode("-",$subscriberDob[0]);

$person_landline=explode(" ",$UIDpatient_details['Person']['person_lindline_no']);
$areaCode=str_replace("(", "", $person_landline["0"]);
$areaCode=str_replace(")", "", $areaCode);

$subscriberPhone=explode(" ",$patient_insurance_details['NewInsurance']['subscriber_primary_phone']);
$subscriberPhoneAreacode=str_replace("(", "", $subscriberPhone["0"]);
$subscriberPhoneAreacode=str_replace(")", "", $subscriberPhoneAreacode);
$gender=$UIDpatient_details['Person']['sex'];
$getPrDatacount=count($getPrData);

//alphabet array
$alphabet=array("0"=>"A","1"=>"B","2"=>"C","3"=>"D","4"=>"E","5"=>"F","6"=>"G","7"=>"H","8"=>"I","9"=>"J","10"=>"K","11"=>"L");
if($getPrDatacount==0)//for default procedure which is set to 99214- office visit done in clinic , Place of service - 22 for outpatient hospital
{
	$serviceFromDateMM=date('m');
	$serviceFromDatedd=date('d');
	$serviceFromDateyy=date('y');
	$procedureCode="99214";
	$placeServiceCode="22";
	$procedureName="Clinic Visit";
	$cost=explode(".",configure::read("ambulatoryCost"));
	$totalAmt=explode(".",configure::read("ambulatoryCost"));
	
}
else 
{   //for default visit procedure code
	$serviceFromDateMM=date('m');
	$serviceFromDatedd=date('d');
	$serviceFromDateyy=date('y');
	$procedureCode="99214";
	$placeServiceCode="22";
	$procedureName="Clinic Visit";
    $cost=explode(".",configure::read("ambulatoryCost"));
	
	foreach($getIcdData as $key=>$getIcdDataNew)
	{
		$icdList[$key]=$getIcdDataNew["NoteDiagnosis"]["icd_id"];
	}
	
	$cntProc=0;
	foreach($getPrData as $procedureData)
	{ 
		$procedureDataVal[$cntProc]['procedureName']=$procedureData['ProcedurePerform']['procedure_name'];
		$procedureDataVal[$cntProc]['procedureCode']=$procedureData['ProcedurePerform']['snowmed_code'];
		$procedureDataVal[$cntProc]['modifier1']=$procedureData['ProcedurePerform']['modifier1'];
		$procedureDataVal[$cntProc]['modifier2']=$procedureData['ProcedurePerform']['modifier2'];
		$procedureDataVal[$cntProc]['modifier3']=$procedureData['ProcedurePerform']['modifier3'];
		$procedureDataVal[$cntProc]['modifier4']=$procedureData['ProcedurePerform']['modifier4'];
		$procedureDataVal[$cntProc]['procedureFromdate']=$procedureData['ProcedurePerform']['procedure_date'];
		$procedureDataVal[$cntProc]['procedureTodate']=$procedureData['ProcedurePerform']['procedure_to_date'];
		$procedureDataVal[$cntProc]['placeService']=$procedureData['ProcedurePerform']['place_service'];
		$procedureDataVal[$cntProc]['units']=$procedureData['ProcedurePerform']['units'];
		$procedureDataVal[$cntProc]['patientDiagnosis']=unserialize($procedureData['ProcedurePerform']['patient_daignosis']);
		$procedureDataVal[$cntProc]['cost']=$procedureData['TariffAmount']['non_nabh_charges'];

		//find diagnoses pointer for each procedure
	    foreach($procedureDataVal[$cntProc]['patientDiagnosis'] as $patientDiagnoses)
	    {
		  $patientDiagnosesNew=explode(": (",$patientDiagnoses);
		  $diagCode=rtrim($patientDiagnosesNew[1],")");
		  $diagnosesarraySearch=array_search($diagCode, $icdList);
		  $diagnosesarraySearchAlphabet[$cntProc][]=$alphabet[$diagnosesarraySearch];
	    }
	   //end
		
	$cntProc++;
	   
	}
	
	//find total cost
	$totalAmt=(float)configure::read("ambulatoryCost")+(float)$procedureDataVal[0]['cost']+(float)$procedureDataVal[1]['cost']+(float)$procedureDataVal[2]['cost']+(float)$procedureDataVal[3]['cost']+(float)$procedureDataVal[4]['cost'];
	$totalAmt=explode(".",$totalAmt);
	
	$amtPaid="0.00";
	$amtPaidArr=explode(".",$amtPaid);

	
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CMS Form 1500</title>

<style>
body{ background:#fff; margin:0px; padding:0px; color:#f54d2d; font-size:12px!important; font-family:Arial, Helvetica, sans-serif;}
.wrapper_main{ width:1200px; margin:0 auto;}
.main_box{ width:1090px; margin:0 auto; position:relative;}
.pica_section{ width:100%; float:left; margin-top:10px;}
.pica_textfeild{ width:3% !important; float:left; margin:0px; padding:0px;}
.pica_textfeild .textBoxExpnd{ margin:0px; padding:0px;width:100% !important; border: 1px solid #f54d2d;}
.picalbl .tdLabel{ margin:0px; padding:0px 0 0 2px !important; color:#f54d2d !important;}
.tdLabel{color:#f54d2d !important;}
.picalbl{ float:left;}
.pica_right{ float:right;}
.pica_righttxtfeild{ float:left; width:20% !important; }
.pica_righttxtfeild .textBoxExpnd{ margin:0px; padding:0px;width: 100% !important; border: 1px solid #f54d2d;}
.pica_right {
    float: right;
    width:9%;
	margin: 0 -10px 0 0;
}

.pica_left {
    float: left;
    width: 50%;
}

.txt_fld {
    height: 36px;
    line-height: 50px;
	font-size:15px;
	color:#000;
}
.birtsection{
	padding: 5px 0 0;
}
#birthtxtbox .textBoxExpnd {
    height: 24px;
    margin: 0 0 0 -4px;
    padding: 0;
    width: 30px;
}

.textfeilds {
    float: left;
	padding: 10px 0 0;
   /* width:56%;*/
}
.birtsection .birth_date:last-child{ border:none;}	
.birth_date {
    border-right: 1px dashed #FFFFFF;
    height: 43px;
    width: 40px;
	margin:0 4px 0 5px;
	float:left;
}

.birthtxtfld .textBoxExpnd{margin:0px; padding:0px;}
.txt_fld1
{
    color: #000;
    float: left;
    font-size:15px;
    height: 43px;
    line-height: 43px;
	
}
.top_header{background:none!important;}
.patrelchkbx .checkfeild {
    float: left;
    padding: 0 12px 0 0;
}
.patrelchkbx .checkfeild span{font-style:normal;}
input{ background:none !important;; padding:0px !important; margin:0px !important;}


</style>
</head>

<body>
 <div id="wrapper_main">
 
 <div class="main_box">
 <div style="position:absolute; top:22px; right:-33px;"><img src="<?php echo $this->webroot?>img/top_strip.png" /></div>
  <div class="header" style="width:100%; float:left;">
    <div class="top_header" style="float:left; width:100%;">
     <!--<div class="bar_code" style="float:left; width:600px;">
      <img src="<?php echo $this->webroot?>theme/black/img/icons/barcode1.png" />
     </div>-->
     
    </div>
     <div class="bottom_header" style="float:left; width:100%;">
       <div class="health_insu">
       <h1 style="margin:0px; padding:0px;">HEALTH INSURANCE CLAIM FORM<span style="text-align:right;padding-left:290px;color:#000;font-weight:normal"><?php echo $patient_insurance_details['NewInsurance']['tariff_standard_name']?></span></h1>
       </div>
       <div class="approved_text">
       <h3 style="float:left; margin:0px; padding:0px;">APPROVED BY NATIONAL UN FORM CLAIM COMMITTEE(NUCC)02/12</h3>
       </div>
     </div>
  </div>
   <div class="pica_section">
    <div class="pica_left">
         <div class="pica_textfeild">
           <input type="text" class="textBoxExpnd" name="" value="" />
         </div>
         <div class="pica_textfeild">
           <input type="text" class="textBoxExpnd" name="" value="" />
         </div>
         <div class="pica_textfeild">
           <input type="text" class="textBoxExpnd" name="" value="" />
         </div>
         <div class="picalbl"><span id="boxSpace" class="">PICA</span></div>
       </div>
       <div class="pica_right">
          <div class="picalbl"><span id="boxSpace" class="">PICA</span></div>
           <div class="pica_rightinput">
           <div class="pica_righttxtfeild">
             <input type="text" class="textBoxExpnd" name="" value="" />
           </div>
           <div class="pica_righttxtfeild">
             <input type="text" class="textBoxExpnd" name="" value="" />
           </div>
           <div class="pica_righttxtfeild">
             <input type="text" class="textBoxExpnd" name="" value="" />
           </div>
           </div>
       </div>
   </div><div class="inner_box" style="width:1090px;border: 1px solid #f54d2d; float:left;">
    <div class="left_side" style="width:690px; float:left;">
      <div class="sec_1" style="float:left; width:100%;border-right: 1px solid #f54d2d;border-bottom: 1px solid #f54d2d;">
        <div class="box_1" style="width:97px; float:left;">
         <span style="float:left;">1. MEDICARE</span>
         <div style="float:left;margin:15px 0 2px 2px;">
          <div style="width:23px; float:left;">
            <div style="float:left;border:1px solid #f54d2d;height:18px; width:18px;"></div>
          </div>
          <div class="" style="float:left; font-style:italic">
           (Medicare#)
          </div>
         </div>
        </div>
        <div class="box_1" style="width:91px; float:left;">
         <span style="float:left;"> MEDICAID</span>
         <div style="float:left;margin:15px 0 0 2px;">
          <div style="width:23px; float:left;">
            <div style="float:left;border:1px solid #f54d2d;height:18px; width:18px;" ></div>
          </div>
          <div class="" style="float:left; font-style:italic">
           (Medicaid#)
          </div>
         </div>
        </div>
        <div class="box_1" style="width:91px; float:left;">
         <span style="float:left;">TRICARE</span>
         <div style="float:left;margin:15px 0 0 2px;">
          <div style="width:23px; float:left;">
            <div style="float:left;border:1px solid #f54d2d;height:18px; width:18px;"></div>
          </div>
          <div class="" style="float:left; font-style:italic">
           (ID#/DoD#)
          </div>
         </div>
        </div>
        <div class="box_1" style="width:109px; float:left;">
         <span style="float:left;">CHAMPVA</span>
         <div style="float:left;margin:15px 0 0 2px;">
          <div style="width:23px; float:left;">
            <div style="float:left;border:1px solid #f54d2d;height:18px; width:18px;"></div>
          </div>
          <div class="" style="float:left; font-style:italic">
           (Member ID#)
          </div>
         </div>
        </div>
        <div class="box_1" style="width:97px; float:left;">
         <span style="float:left;">GROUP<br />
HEALTH PLAN</span>
         <div style="float:left;margin: 0 0 0 2px;">
          <div style="width:23px; float:left;">
            <div style="float:left;border:1px solid #f54d2d;height:18px; width:18px;"></div>
          </div>
          <div class="" style="float:left; font-style:italic">
           (ID#)
          </div>
         </div>
        </div>
        <div class="box_1" style="width:97px; float:left;">
         <span style="float:left;">FECA<br />
BLK LUNG</span>
         <div style="float:left;margin: 0 0 0 2px;">
          <div style="width:23px; float:left;">
            <div style="float:left;border:1px solid #f54d2d; height:18px; width:18px;"></div>
          </div>
          <div class="" style="float:left; font-style:italic">
           (ID#)
          </div>
         </div>
        </div>
        <div class="box_1" style="width:97px; float:left;">
         <span style="float:left; width:100%">OTHER</span>
         <div style="float:left;margin:15px 0 0 2px;;">
          <div style="width:18px; height:18px; float:left;">
            <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png" />
          </div>
          <div class="" style="float:left; font-style:italic">
           (ID#)
          </div>
         </div>
        </div>
      </div>
      <div class="section_2" style="float:left; width:100%;border-right: 1px solid #f54d2d; border-bottom:1px solid #f54d2d">
        <div class="patient_name" style="width:389px; float:left;border-right: 1px solid;">
         <span style="float:left;margin: 0px 0px 0px 5px; width:100%;">2. PATIENT'S NAME (Last Name, First Name, Middle Initial)</span>
          <div class="pnt_name" style="height:59px; line-height:35px; font-size:15px; color:#000;margin: 0px 0px 0px 5px;">
            <?php echo $UIDpatient_details['Person']['last_name'].", ".$UIDpatient_details['Person']['first_name'];?>
          </div>
        </div>
        <div class="patient_dob" style="float:left;">
          <div class="dob" style="float:left; width:181px;">
            <span style="float:left;margin: 0px 0px 0px 5px;">3. PATIENT'S BIRTH DATE</span>
            <div class="birtsection">
                 <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">MM</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:35px; float:left;color:#000">
                    <?php echo $dateofbirth["1"];?>
                    </div>
                   </div>
                  </div>
                  <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">DD</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:35px; float:left;color:#000">
                    <?php echo $dateofbirth["2"];?>
                    </div>
                   </div>
                  </div>
                  <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">YY</span>
                   <div id="birthtxtbox" style="height:20px; width:35px; float:left;color:#000">
                    <?php echo $dateofbirth["0"];?>
                    </div>
                   </div>
                  </div>
                  </div>
          </div>
          <div class="gender" style="float:left; text-align:center;">
            <span>SEX</span><br />
             <div style="width:50px; float:left;margin:15px 15px 0 0;">  
               M 
               <?php if($gender=="M" or $gender=="Male"){?>
               <div style=" float:right; height:19px; width:20px;">
                <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png"  />
               </div>
               <?php } else {?>
               <div style="float:right; height:18px; width:18px;border:1px solid #f54d2d">
               </div>
               <?php }?>
             </div>
             <div style="width:50px; float:left;margin-top: 15px;">
               F
               <?php if($gender=="F" or $gender=="Female"){?>
               <div style=" float:right; height:19px; width:20px;border:1px solid #f54d2d">
                <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png"  />
               </div>
               <?php } else {?>
               <div style="float:right; height:18px; width:18px;border:1px solid #f54d2d">
               </div>
               <?php }?>
             </div>
          </div>
        </div>
      </div>
       <div class="section_3" style="float:left; width:100%;border-right: 1px solid #f54d2d; border-bottom:1px solid #f54d2d">
         <div class="patient_name" style="width:389px; float:left;border-right: 1px solid;">
         <span style="float:left;margin: 0px 0px 0px 5px;">5. PATIENT5S ADDRESS (No., Street)</span>
          <div class="pnt_name" style="height:43px; line-height:35px; font-size:15px; color:#000;margin: 0px 0px 0px 5px; clear:left; float:left;">
          <?php echo $UIDpatient_details['Person']['plot_no']; 
           if(!empty($UIDpatient_details['Person']['landmark']))
           {
             echo ",".$UIDpatient_details['Person']['landmark'];
           }?>
          </div>
        </div>
        <div style="float:left;">
         <span style="margin: 0px 0px 0px 5px;">6. PATIENT RELATIONSHIP TO INSURED</span>
         <div class="patrelchkbx">
             <div>&nbsp;</div>
             <div class="checkfeild">
                  <span style="float:left;margin: 0 5px 0 3px;">Self</span>
                   <?php if($patient_insurance_details["NewInsurance"]["relation"]=='self' || $patient_insurance_details["NewInsurance"]["relation"]=='18'){
                  ?>

                  <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png" />

                  <?php }else {?>
                  <div style="border: 1px solid rgb(245, 77, 45); width:18px; height:18px; float: right;"></div>
                  <?php }?>
             </div>
             <div class="checkfeild">
                  <span style="float:left;margin: 0 5px 0 3px;">Spouse</span>
                 <?php if($patient_insurance_details["NewInsurance"]["relation"]=='spouse' || $patient_insurance_details["NewInsurance"]["relation"]=='01'){
                  ?>

                  <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png" />

                  <?php }else {?>
                  <div style="border: 1px solid rgb(245, 77, 45); width:18px; height:18px; float: right;"></div>
                  <?php }?>
             </div>
             <div class="checkfeild">
                  <span style="float:left;margin: 0 5px 0 3px;">Child</span>
                  <?php if($patient_insurance_details["NewInsurance"]["relation"]=='child' || $patient_insurance_details["NewInsurance"]["relation"]=='09' || $patient_insurance_details["NewInsurance"]["relation"]=='10'){
                  ?>

                  <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png" />

                  <?php }else {?>
                  <div style="border: 1px solid rgb(245, 77, 45); width:18px; height:18px; float: right;"></div>
                  <?php }?>
             </div>
             <div class="checkfeild">
                  <span style="float:left;margin: 0 5px 0 3px;">Other</span>
                 <?php if($patient_insurance_details["NewInsurance"]["relation"]=='other' || $patient_insurance_details["NewInsurance"]["relation"]=='G8'){
                  ?>

                  <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png" />

                  <?php }else {?>
                  <div style="border: 1px solid rgb(245, 77, 45); width:18px; height:18px; float: right;"></div>
                  <?php }?>
             </div>
           </div>
        </div>
       </div>
       <div class="section_4" style="float:left; width:100%;border-right: 1px solid #f54d2d;">
        <div class="patient_name" style="width:389px; float:left;border-right: 1px solid #f54d2d; border-bottom:1px solid #f54d2d; height:44px;">
         <div style="float:left; width:310px;border-right: 1px solid #f54d2d;">
         <span style="float:left;margin: 0px 0px 0px 5px;">CITY</span>
          <div class="pnt_name" style="height:30px; line-height:27px; font-size:15px; color:#000;margin: 0px 0px 0px 5px; float:left; clear:left;">
           <?php echo ucwords($UIDpatient_details['Person']['city'])?>
          </div>
          </div>
          <div style="float:left;">
          <span style="float:left;margin: 0px 0px 0px 5px;">STATE</span>
          <div class="pnt_name" style="height:43px; line-height:35px; font-size:15px; color:#000;margin: 0px 0px 0px 5px; float:left; clear:left;">
           <?php echo ucwords($state_location_patient['State']['state_code'])?>
          </div>
          </div>
        </div>
        <div style="float:left">
         <span style="margin: 0px 0px 0px 5px;">8. RESERVED FOR NUCC USE</span>
        </div>
       </div>
      
         <div class="section_5" style="float:left; width:100%;border-right: 1px solid #f54d2d;">
         <div class="patient_name" style="width:389px; float:left;border-right: 1px solid #f54d2d; border-bottom:1px solid #f54d2d; height:44px;">
          <div style="float:left; width:184px;border-right: 1px solid #f54d2d;">
           <span style="float:left;margin: 0px 0px 0px 5px;">ZIP CODE</span>
           <div class="pnt_name" style="height:30px; line-height:27px; font-size:15px; color:#000;margin: 0px 0px 0px 5px; float:left; clear:left;">
           <?php echo $UIDpatient_details['Person']['pin_code']?>
          </div>
          </div>
          <div style="float:left;">
          <span style="float:left;margin: 0px 0px 0px 5px;">TELEPHONE (Include Area Code)</span>
          <div class="pnt_name" style="height:43px; line-height:35px; font-size:15px; color:#000; margin: 0px 0px 0px 5px; float:left; clear:left;">
           <span style="color:#f54d2d;">(</span> <?php if(empty($areaCode)){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}else {echo $areaCode;}?><span style="color:#f54d2d;"> )</span><?php echo $person_landline["1"];?>
          </div>
          </div>
         </div>
         </div>
         <div class="section_6" style="float:left; width:100%;border-right: 1px solid #f54d2d;">
         <div class="patient_name" style="width:389px; float:left;border-right: 1px solid #f54d2d; border-bottom:1px solid #f54d2d;">
         <span style="float:left;margin: 0px 0px 0px 5px;">9. OTHER INSURED'S NAME (Last Name, First Name, Middle Initial)</span>
          <div class="pnt_name" style="height:35px; line-height:35px; font-size:15px; color:#000;margin: 0px 0px 0px 5px; float:left; clear:left;">
            
          </div>
        </div>
        <div style="float:left; border-top:1px solid #f54d2d; width:299px; margin-top:-1px;">
          <span style="float:left;margin: 0px 0px 0px 5px;">10. IS PATIENT'S CONDITION RELATED TO:</span>
        </div>
         </div>
         <div class="section_7" style="float:left; width:100%;border-right: 1px solid #f54d2d;">
         <div class="patient_name" style="width:389px; float:left;border-right: 1px solid #f54d2d; border-bottom:1px solid #f54d2d;">
         <span style="float:left;margin: 0px 0px 0px 5px;">a. OTHER INSURED'S POLICY OR GROUP NUMBER</span>
          <div class="pnt_name" style="height:35px; line-height:35px; font-size:15px; color:#000; margin: 0px 0px 0px 5px; float:left; clear:left;">
            
          </div>
        </div>
        <div style="float:left;width:299px; margin-top:-1px;">
          <span style=" margin-left: 5px;">a. EMPLOYMENT? (Current or Previous)</span>
          <div style="float: left; width: 100%;margin: 10px 0px 0px 30px;">
           <div style="float: left; width: 20%; margin: 0px 0px 0px 0px;">
             <div style="border: 1px solid rgb(245, 77, 45); width:18px; height:18px; float: left;">
             </div>
             <span style="float: left; margin: 2px 0px 0px 5px;">YES</span>
           </div>
           <div style="float: left; margin: 0px 0px 0px 23px;">
             <div style="width:18px; height: 18px; float: left;">
              <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png" />
             </div>
             <span style="float: left; margin: 2px 0px 0px 5px;">NO</span>
           </div>
          </div>
        </div>
         </div>
         <div class="section_8" style="float:left; width:100%;border-right: 1px solid #f54d2d;">
         <div class="patient_name" style="width:389px; float:left;border-right: 1px solid #f54d2d; border-bottom:1px solid #f54d2d;">
         <span style="float:left;margin: 0px 0px 0px 5px;">b. RESERVED FOR NUCC USE</span>
          <div class="pnt_name" style="height:35px; line-height:35px; font-size:15px; color:#000;margin: 0px 0px 0px 5px; float:left; clear:left;">
            
          </div>
        </div>
        <div style="float:left;width:164px; margin-top:-1px;">
          <span style="float: left; margin-left: 5px;">b. AUTO ACCIDENT?</span>
          <div style="float: left; width: 100%;margin: 10px 0px 0px 0px;">
           <div style="float: left; width: 33%; margin: 0px 0px 0px 30px;">
             <div style="border: 1px solid rgb(245, 77, 45); width:18px; height: 18px; float: left;">
             </div>
             <span style="float: left; margin: 2px 0px 0px 5px;">YES</span>
           </div>
           <div style="float: left; margin: 0px 0px 0px 30px;">
             <div style="width:18px; height: 18px; float: left;">
              <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png" />
             </div>
             <span style="float: left; margin: 2px 0px 0px 5px;">NO</span>
           </div>
          </div>
        </div>
        <div style="float:left; width:90px;">
         <span style="float: left; width: 100%;">PLACE (State)</span>
         <div style="border: 1px solid rgb(245, 77, 45); width: 40px; height: 18px; float: left; border-top:none;margin: 12px 0 0 18px;">
             </div>
        </div>
         </div>
         <div class="section_9" style="float:left; width:100%;border-right: 1px solid #f54d2d;">
         <div class="patient_name" style="width:389px; float:left;border-right: 1px solid #f54d2d; border-bottom:1px solid #f54d2d;">
         <span style="float:left;margin: 0px 0px 0px 5px;">c. RESERVED FOR NUCC USE</span>
          <div class="pnt_name" style="height:35px; line-height:35px; font-size:15px; color:#000; margin: 0px 0px 0px 5px; float:left; clear:left;">
            
          </div>
        </div>
        <div style="float:left;width:299px; margin-top:-1px;">
          <span style=" margin-left: 5px;">c. OTHER ACCIDENT?</span>
          <div style="float: left; width: 100%;margin: 10px 0px 0px 30px;">
           <div style="float: left; width: 20%; margin: 0px 0px 0px 0px;">
             <div style="border: 1px solid rgb(245, 77, 45); width:18px; height: 18px; float: left;">
             </div>
             <span style="float: left; margin: 2px 0px 0px 5px;">YES</span>
           </div>
           <div style="float: left; margin: 0px 0px 0px 23px;">
             <div style="width:18px; height: 18px; float: left;">
             <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png" />
             </div>
             <span style="float: left; margin: 2px 0px 0px 5px;">NO</span>
           </div>
          </div>
        </div>
         </div>
         <div class="section_10" style="float:left; width:100%;border-right: 1px solid #f54d2d;">
         <div class="patient_name" style="width:389px; float:left;border-right: 1px solid #f54d2d; border-bottom:1px solid #f54d2d;">
         <span style="float:left;margin: 0px 0px 0px 5px;">d. INSURANCE PLAN NAME OR PROGRAM NAME</span>
          <div class="pnt_name" style="height:35px; line-height:35px; font-size:15px; color:#000; margin: 0px 0px 0px 5px; float:left; clear:left;">
            
          </div>
        </div>
        <div style="float:left; border-top:1px solid #f54d2d; width:299px; margin-top:-1px;border-bottom:1px solid #f54d2d;">
          <span style=" margin-left: 5px; float:left; width:100%">10d. CLAIM CODES (Designated by NUCC)</span>
          <div class="pnt_name" style="height:35px; line-height:35px; font-size:15px; color:#000; margin: 0px 0px 0px 5px; float:left; clear:left;">
        
          </div>
        </div>
         </div>
         <div class="section_11" style="float:left; width:100%;border-right: 1px solid #f54d2d;border-bottom:5px solid #f54d2d; height:95px;">
         <span style="text-align: center; width: 100%; float: left; font-weight: bold;">READ BACK OF FORM BEFORE COMPLETING & SIGNING THIS FORM.</span>
          <div style="float:left; width:96%;margin: 0px 0px 0px 5px;">
           12. PATIENT'S OR AUTHORIZED PERSON'S SIGNATURE I authorize the release of any medical or other information necessary
to process this claim. I also request payment of government benefits either to myself or to the party who accepts assignment
below.
          </div>
           <div style="float:left; width:100%;padding-bottom: 5px;">
            <div class="signed_sec" style="float:left; width:386px; padding-top:15px;">
             <span style="float:left;margin: 0px 0px 0px 5px;">SIGNED&nbsp;&nbsp;</span>
             <div style="float:left;"><input type="textbox" readonly value="SOF" style="border-top:none;border-left:none;border-right:none;border-color:red;box-shadow:none;width:320px;"></div>
            </div>
            <div class="date_sec" style="float:left; padding-top:15px;">
            <span style="float:left;margin: 0px 0px 0px 5px;">DATE&nbsp;&nbsp;</span>
             <div style="float:left; color:#f54d2d;"><input type="textbox" readonly value="<?php echo $this->DateFormat->formatDate2LocalForReport(date('Y-m-d'),Configure::read('date_format'),false)?>" style="border-top:none;border-left:none;border-right:none;border-color:red;box-shadow:none;width:250px;"></div>
            </div>
           </div>
        
         </div>
          <div class="section_12" style="float:left; width:100%;border-right: 1px solid #f54d2d;">
          <div class="patient_name" style="width:389px; float:left;border-right: 1px solid #f54d2d; border-bottom:1px solid #f54d2d;">
            <span style="float:left;margin: 0px 0px 0px 5px;">14.DATE OF CURRENT ILLNESS,INJURY or PREGNANCY(LMP)</span>
            <div class="birtsection">
                 <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">MM</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">DD</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">YY</span>
                   <div id="birthtxtbox" style="height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  </div>
                  <div class="qual_sec" style="float: left; width: 53%; margin: 17px 0px 0px 30px;">
                   <span style="float:left;">QUAL</span>
                    <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:6px; float:left;">
                    </div>
                    <div class="pnt_name" style="font-size: 20px; color:#000; font-weight: bold; height: 31px; line-height: 18px; margin: 0px; float: left; padding: 0px 0px 0px 5px;">
            
          </div>
                  </div>
          </div>
          <div style="float:left; width:299px;border-bottom:1px solid #f54d2d;">
            <span style="float: left; width: 100%;margin: 0px 0px 0px 5px;">15. OTHER DATE</span>
            <div class="qual_sec" style="float: left; margin: 17px 0px 0px 7px; width: 38%;">
                   <span style="float:left;">QUAL</span>
                    <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:6px; float:left;">
                    </div>
                    <div class="pnt_name" style="font-size: 20px; color:#000; font-weight: bold; height:15px; line-height:21px;
                     margin: 0px; float: left; padding: 0px 0px 5px 5px; border-right:1px dashed #f54d2d; width:30px; ">
          </div>
                  </div>
                  <div class="birtsection" style="float:left;">
                 <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">MM</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:40px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">DD</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:40px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">YY</span>
                   <div id="birthtxtbox" style="height:20px; width:40px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  </div>
            
          </div>
          </div>
           <div class="section_12" style="float:left; width:100%;border-right: 1px solid #f54d2d;">
          <div class="patient_name" style="width:389px; float:left;border-right: 1px solid #f54d2d; border-bottom:1px solid #f54d2d;">
            <span style="float: left; width: 100%; margin: 0px 0px 0px 5px;">17. NAME OF REFERRING PROVIDER OR OTHER SOURCE</span>
            <div style="float: left; height: 20px; width: 35px; border-right: 1px dashed rgb(245, 77, 45); margin: 7px 5px;">
       </div>
      <div class="pnt_name" style="height:63px; line-height:39px; font-size:15px; color:#000; ">
       
      </div>
          </div>
          <div style="float:left;  width:299px;">
            <div class="top_one" style="float:left;border-bottom:1px dashed #f54d2d;background:#fee7dc repeat-x; height:31px;">
             <span style="float:left; height:28px; width:20px; border-right:1px solid #f54d2d; padding:2px;">17a.</span>
        <div style="height:33px; width:70px; border-right:1px solid #f54d2d; float:left;">
             </div>
             <div style="height:20px; width:202px;float:left;">
             </div>
            </div>
            <div class="top_one" style="float:left;border-bottom:1px solid #f54d2d; height:31px; ">
             <span style="float:left; height:27px; width:20px; border-right:1px solid #f54d2d; padding:2px;">17a.</span>
        <div style="height:31px; width:70px; border-right:1px solid #f54d2d; float:left;">
             </div>
             <div style="height:20px; width:202px;float:left;">
             </div>
            </div>
          </div>
          </div>
          <div class="section_13" style="float:left; width:100%;border-right: 1px solid #f54d2d;">
          <span style="float:left; width:100%;margin: 0px 0px 0px 5px;">19. ADDITIONAL CLAIM INFORMATION (Designated by NUCC)</span>
          <div class="pnt_name" style="height:48px; line-height:39px; font-size:15px; color:#000;  width:100%;margin: 0px 0px 0px 5px; clear:left; float:left;">
       
      </div>
          </div>
          <div class="section_14" style="float:left; width:100%;border-right: 1px solid #f54d2d;border-top: 1px solid #f54d2d;">
           <div style="float:left; width:100%">
             <div style="float:left; width:546px;margin: 0px 0px 0px 5px;">
              21. DIAGNOSIS OR NATURE OF ILLNESS OR INJURY Relate A-L to service line below (24E)
             </div>
             <div style="float: left; width: 138px; margin-top: 8px;">
              <span style="float: left; border-right: 1px dashed rgb(245, 77, 45); height: 20px;">ICD Ind.&nbsp;</span>
              <div  style="float: left; width: 30px; border-right: 1px dashed rgb(245, 77, 45); height: 20px;color:#000">&nbsp;&nbsp;&nbsp;&nbsp;9
              </div>
              <div style="float: left; width: 56px; height: 20px;">
              </div>
             </div>
           </div>
           <div style="float:left; width:100%">
           <div class="part_1" style="float:left; width:100%; padding-bottom:10px">
            <div style="float:left; width:160px;">
             <span style="float:left;margin: 0px 0px 0px 5px">A.&nbsp;</span>
             <div style="float:left; width:100px; height:15px; border-bottom: 1px solid #f54d2d;border-left: 1px solid #f54d2d;font-size:15px; color:#000;margin: 0px 0px 0px 5px;">&nbsp;<?php echo str_replace(".","",$getIcdData["0"]["NoteDiagnosis"]["icd_id"]);?>
             </div>
            </div>
            <div style="float:left; width:160px;">
             <span style="float:left;">B.&nbsp;</span>
             <div style="float:left; width:100px; height:15px; border-bottom: 1px solid #f54d2d;border-left: 1px solid #f54d2d;font-size:15px; color:#000;margin: 0px 0px 0px 5px;">&nbsp;<?php echo str_replace(".","",$getIcdData["1"]["NoteDiagnosis"]["icd_id"]);?>
             </div>
            </div>
            <div style="float:left; width:160px;">
             <span style="float:left;">C.&nbsp;</span>
             <div style="float:left; width:100px; height:15px; border-bottom: 1px solid #f54d2d;border-left: 1px solid #f54d2d;font-size:15px; color:#000;margin: 0px 0px 0px 5px;">&nbsp;<?php echo str_replace(".","",$getIcdData["2"]["NoteDiagnosis"]["icd_id"]);?>
             </div>
            </div>
            <div style="float:left; width:160px;">
             <span style="float:left;">D.&nbsp;</span>
             <div style="float:left; width:100px; height:15px; border-bottom: 1px solid #f54d2d;border-left: 1px solid #f54d2d;font-size:15px; color:#000;margin: 0px 0px 0px 5px;">&nbsp;<?php echo str_replace(".","",$getIcdData["3"]["NoteDiagnosis"]["icd_id"]);?>
             </div>
            </div>
           </div>
           <div class="part_1" style="float:left; width:100%; padding-bottom:10px">
            <div style="float:left; width:160px;">
             <span style="float:left;margin: 0px 0px 0px 5px">E.&nbsp;</span>
             <div style="float:left; width:100px; height:15px; border-bottom: 1px solid #f54d2d;border-left: 1px solid #f54d2d;font-size:15px; color:#000;margin: 0px 0px 0px 5px;">&nbsp;<?php echo str_replace(".","",$getIcdData["4"]["NoteDiagnosis"]["icd_id"]);?>
             </div>
            </div>
            <div style="float:left; width:160px;">
             <span style="float:left;">F.&nbsp;</span>
             <div style="float:left; width:100px; height:15px; border-bottom: 1px solid #f54d2d;border-left: 1px solid #f54d2d;font-size:15px; color:#000;margin: 0px 0px 0px 5px;">&nbsp;<?php echo str_replace(".","",$getIcdData["5"]["NoteDiagnosis"]["icd_id"]);?>
             </div>
            </div>
            <div style="float:left; width:160px;">
             <span style="float:left;">G.&nbsp;</span>
             <div style="float:left; width:100px; height:15px; border-bottom: 1px solid #f54d2d;border-left: 1px solid #f54d2d;font-size:15px; color:#000;margin: 0px 0px 0px 5px;">&nbsp;<?php echo str_replace(".","",$getIcdData["6"]["NoteDiagnosis"]["icd_id"]);?>
             </div>
            </div>
            <div style="float:left; width:160px;">
             <span style="float:left;">H.&nbsp;</span>
             <div style="float:left; width:100px; height:15px; border-bottom: 1px solid #f54d2d;border-left: 1px solid #f54d2d;font-size:15px; color:#000;margin: 0px 0px 0px 5px;">&nbsp;<?php echo str_replace(".","",$getIcdData["7"]["NoteDiagnosis"]["icd_id"]);?>
             </div>
            </div>
           </div>
           <div class="part_1" style="float:left; width:100%; padding-bottom:10px">
            <div style="float:left; width:160px;">
             <span style="float:left;margin: 0px 0px 0px 5px">I.&nbsp;</span>
             <div style="float:left; width:100px; height:15px; border-bottom: 1px solid #f54d2d;border-left: 1px solid #f54d2d;font-size:15px; color:#000;margin: 0px 0px 0px 5px;">&nbsp;<?php echo str_replace(".","",$getIcdData["8"]["NoteDiagnosis"]["icd_id"]);?>
             </div>
            </div>
            <div style="float:left; width:160px;">
             <span style="float:left;">J.&nbsp;</span>
             <div style="float:left; width:100px; height:15px; border-bottom: 1px solid #f54d2d;border-left: 1px solid #f54d2d;font-size:15px; color:#000;margin: 0px 0px 0px 5px;">&nbsp;<?php echo str_replace(".","",$getIcdData["9"]["NoteDiagnosis"]["icd_id"]);?>
             </div>
            </div>
            <div style="float:left; width:160px;">
             <span style="float:left;">K.&nbsp;</span>
             <div style="float:left; width:100px; height:15px; border-bottom: 1px solid #f54d2d;border-left: 1px solid #f54d2d;font-size:15px; color:#000;margin: 0px 0px 0px 5px;">&nbsp;<?php echo str_replace(".","",$getIcdData["10"]["NoteDiagnosis"]["icd_id"]);?>
             </div>
            </div>
            <div style="float:left; width:160px;">
             <span style="float:left;">L.&nbsp;</span>
             <div style="float:left; width:100px; height:15px; border-bottom: 1px solid #f54d2d;border-left: 1px solid #f54d2d;font-size:15px; color:#000;margin: 0px 0px 0px 5px;">&nbsp;<?php echo str_replace(".","",$getIcdData["11"]["NoteDiagnosis"]["icd_id"]);?>
             </div>
            </div>
           </div>
           </div>
          </div>
          <div class="section_14" style="float:left; width:100%;border-right: 1px solid #f54d2d;border-top: 1px solid #f54d2d;">
           <div style="width:263px; float:left;border-right: 1px solid #f54d2d;margin: 0px 0px 0px 5px;">
            24. A. DATE(S) OF SERVICE
            <div style="width:269px; float:left;">
            <div style="float:left; width:50%">
             <span style="float:left; text-align:center; width:100%;">From</span>
             <div class="date_sec" style="float: left; margin: 0px 0px 0px 10px;">
            <div style="float: left; width: 45px;">MM</div>
            <div style="float: left; width: 45px;">DD</div>
            <div style="float:left;">YY</div>
           </div>
            </div>
            <div style="float:left; width:50%"">
             <span style="float:left; text-align:center; width:100%;">To</span>
              <div class="date_sec" style="float: left; margin: 0px 0px 0px 10px;">
            <div style="float: left; width: 45px;">MM</div>
            <div style="float: left; width: 45px;">DD</div>
            <div style="float:left;">YY</div>
           </div>
            </div>
           </div>
           
           </div>
           <div style="float:left; width:62px;border-right: 1px solid #f54d2d;">
           <span style="float:left; text-align:center; width:100%;">B.</span>
            PLACE OF
            SERVICE
           </div>
           <div style="float:left; width:31px;border-right: 1px solid #f54d2d;">
           <span style="float: left; text-align: center; width: 100%; padding-bottom: 16px;">C.</span>
          
            EMG
           </div>
           <div style="float:left; width:247px;border-right: 1px solid #f54d2d;">
           <span>D. PROCEDURES,SERVICES,OR SUPPLES</span>
           <div style="float:left; width:100%; text-align:center;" class="circumstances">
             <span>(Explain Unusual Circumstances)</span>
             <div style="float:left; width:100%">
               <div style="float:left; width:49%;border-right: 1px solid #f54d2d;">
                <span>CPT/HCPCS</span>
               </div>
               <div style="float:left; width:49%">
               <span>MODIFIER</span>
               </div>
             </div>
           </div>
           </div>
           <div style="float:left; width:70px; margin:0 0 0 4px;">
            <span style="float:left; text-align:center; width:100%;">E</span>
            DIAGNOSIS
            POINTER
           </div>
          </div>
          <div class="section_14" style="float:left; width:100%;border-top: 1px solid #f54d2d;">
          <div class="num_img" style="position:absolute; margin-top:6px;left: -18px;"><img style="height: 245px;" src="<?php echo $this->webroot?>img/number.png" /></div>
           <div class="feild_sec" style="background:#fee7dc repeat-x; width:100%; float:left;">
            <div style="float:left; width:100%; margin-top:20px;border-bottom:1px solid #f54d2d;">
             <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
             <?php echo $serviceFromDateMM;?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo $serviceFromDatedd;?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo $serviceFromDateyy;?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo "";?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo "";?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 25px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo "";?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 50px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $placeServiceCode;?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 8px; width: 23px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              
            </div>
            <div style="float:left; padding: 0px 0px 0px 31px; width: 90px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
             <?php echo $procedureCode;?> 
            </div>
            <div style="float:left;padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
            
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 25px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
             
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 66px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
             
            </div>
           </div>
           <div style="float:left; width:100%; margin-top:20px;border-bottom:1px solid #f54d2d;">
             <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php 
              $procedureDataValArr=explode("-",$procedureDataVal["0"]["procedureFromdate"]);
              echo $procedureDataValArr["2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo $procedureDataValArr["1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo str_replace("20","",$procedureDataValArr["0"]);?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php $procedureDataValTodateArr=explode("-",$procedureDataVal["0"]["procedureTodate"]);
              echo $procedureDataValTodateArr["2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo $procedureDataValTodateArr["1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 25px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo str_replace("20","",$procedureDataValTodateArr["0"]);?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 50px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["0"]["placeService"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 8px; width: 23px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              
            </div>
            <div style="float:left; padding: 0px 0px 0px 31px; width: 90px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["0"]["procedureCode"];?>
            </div>
            <div style="float:left;padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["0"]["modifier1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["0"]["modifier2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["0"]["modifier3"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 25px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["0"]["modifier4"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 66px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo implode(",",$diagnosesarraySearchAlphabet["0"])?>
            </div>
           </div>
           <div style="float:left; width:100%; margin-top:20px;border-bottom:1px solid #f54d2d;">
             <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php 
              $procedureDataValArr=explode("-",$procedureDataVal["1"]["procedureFromdate"]);
              echo $procedureDataValArr["2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000">
              <?php echo $procedureDataValArr["1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo str_replace("20","",$procedureDataValArr["1"]);?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000">
              <?php $procedureDataValTodateArr=explode("-",$procedureDataVal["1"]["procedureTodate"]);
              echo $procedureDataValTodateArr["2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000">
              <?php echo $procedureDataValTodateArr["1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 25px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo str_replace("20","",$procedureDataValTodateArr["0"]);?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 50px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["1"]["placeService"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 8px; width: 23px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              
            </div>
            <div style="float:left; padding: 0px 0px 0px 31px; width: 90px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["1"]["procedureCode"];?>
            </div>
            <div style="float:left;padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["1"]["modifier1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["1"]["modifier2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["1"]["modifier3"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 25px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["0"]["modifier4"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 66px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo implode(",",$diagnosesarraySearchAlphabet["1"])?>
            </div>
           </div>
           <div style="float:left; width:100%; margin-top:20px;border-bottom:1px solid #f54d2d;">
             <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php 
              $procedureDataValArr=explode("-",$procedureDataVal["2"]["procedureFromdate"]);
              echo $procedureDataValArr["2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo $procedureDataValArr["1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo str_replace("20","",$procedureDataValArr["0"]);?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php $procedureDataValTodateArr=explode("-",$procedureDataVal["2"]["procedureTodate"]);
              echo $procedureDataValTodateArr["2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo $procedureDataValTodateArr["1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 25px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo str_replace("20","",$procedureDataValTodateArr["0"]);?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 50px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["2"]["placeService"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 8px; width: 23px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              
            </div>
            <div style="float:left; padding: 0px 0px 0px 31px; width: 90px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["2"]["procedureCode"];?>
            </div>
            <div style="float:left;padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["2"]["modifier1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["2"]["modifier2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["2"]["modifier3"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 25px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["2"]["modifier4"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 66px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo implode(",",$diagnosesarraySearchAlphabet["2"])?>
            </div>
           </div>
           <div style="float:left; width:100%; margin-top:20px;border-bottom:1px solid #f54d2d;">
             <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php 
              $procedureDataValArr=explode("-",$procedureDataVal["3"]["procedureFromdate"]);
              echo $procedureDataValArr["2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d; color:#000 ">
              <?php echo $procedureDataValArr["1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo str_replace("20","",$procedureDataValArr["0"]);?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php $procedureDataValTodateArr=explode("-",$procedureDataVal["3"]["procedureTodate"]);
              echo $procedureDataValTodateArr["2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo $procedureDataValTodateArr["1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 25px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo str_replace("20","",$procedureDataValTodateArr["0"]);?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 50px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["3"]["placeService"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 8px; width: 23px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              
            </div>
            <div style="float:left; padding: 0px 0px 0px 31px; width: 90px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["3"]["procedureCode"];?>
            </div>
            <div style="float:left;padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["3"]["modifier1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["0"]["modifier2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["3"]["modifier3"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 25px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["3"]["modifier4"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 66px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo implode(",",$diagnosesarraySearchAlphabet["3"])?>
            </div>
           </div>
           <div style="float:left; width:100%; margin-top:20px;">
             <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php 
              $procedureDataValArr=explode("-",$procedureDataVal["4"]["procedureFromdate"]);
              echo $procedureDataValArr["2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo $procedureDataValArr["1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo str_replace("20","",$procedureDataValArr["0"]);?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php $procedureDataValTodateArr=explode("-",$procedureDataVal["4"]["procedureTodate"]);
              echo $procedureDataValTodateArr["2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 32px;height:21px; background:#fff;border-right: 1px dashed #f54d2d;color:#000 ">
              <?php echo $procedureDataValTodateArr["1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 25px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo str_replace("20","",$procedureDataValTodateArr["0"]);?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 50px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["4"]["placeService"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 8px; width: 23px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              
            </div>
            <div style="float:left; padding: 0px 0px 0px 31px; width: 90px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["4"]["procedureCode"];?>
            </div>
            <div style="float:left;padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["4"]["modifier1"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000">
              <?php echo $procedureDataVal["4"]["modifier2"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 22px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["4"]["modifier3"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 7px; width: 25px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo $procedureDataVal["4"]["modifier4"];?>
            </div>
            <div style="float:left; padding: 0px 0px 0px 13px; width: 66px;height:21px; background:#fff;border-right: 1px solid #f54d2d;color:#000 ">
              <?php echo implode(",",$diagnosesarraySearchAlphabet["4"])?>
            </div>
           </div>
           </div>
          </div>
          <div class="section_15" style="float:left; width:100%;border-top: 1px solid #f54d2d;">
           <div style="float:left; width:320px;border-right: 1px solid #f54d2d;">
            <div style="float:left; width:240px;">
             <span style="float:left; width:100%;padding-bottom:25px;margin: 0px 0px 0px 5px;">25. FEDERAL TAX I.D. NUMBER</span>
              <div style="float:left; width:100%; color:#000; height:25px; line-height:25px; font-size:15px;"></div>
            </div>
            <div style="width:80px; float:left">
             <span style="float:left; width:100%; padding-bottom:13px;">SSN EIN</span>
             <div style="float: left; width: 100%; margin-top: 5px;">
             <?php if(empty($UIDpatient_details['Person']['ssn_us'])){?>
               <div style="height:18px; width:18px; border:1px solid #f54d2d; float:left;margin: 0 6px 5px 7px;">
               </div>
               <?php }else {?>
               <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png" />
               <?php }?>
                <div style="height:18px; width:18px; border:1px solid #f54d2d; float:left;margin: 0 6px 5px 7px;">
                
               </div>
             </div>
            </div>
           </div>
           <div style="float:left; width:368px;border-right: 1px solid #f54d2d;">
           <div style="float:left; width:179px;border-right: 1px solid #f54d2d;">
             <span style="float:left; width:100%; padding-bottom:25px;">&nbsp;26. PATIENT'S ACCOUNT NO.</span>
              <div style="float:left; width:100%; color:#000; height:25px; line-height:25px; font-size:15px;"><?php echo $UIDpatient_details["Patient"]["account_number"]?></div>
            </div>
            <div style="width:166px; float:left">
             <span style="float:left; width:100%;"> &nbsp;27. ACCEPT ASSIGNMENT?</span>
             <div style="float: left; width: 100%; margin-top: 5px;">
               <span style="font-size:10px; float:left; text-align:center; width:100%;">(For govt. claims, see back)</span>

               <div style="float: left; width:121%;margin: 4px 0px 0px 30px;">
           <div style="float: left; width:25%; margin: 0px 0px 2px 0px;">
              <?php if($patient_insurance_details['NewInsurance']['assignment_of_benefits']=='Y'){?>
              <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png" />
              <?php }else {?>
             <div style="border: 1px solid rgb(245, 77, 45); width:18px; height: 18px; float: left;">
             </div>
             <?php }?>
             <span style="float: left; margin: 2px 0px 0px 5px;">YES</span>
           </div>
           <div style="float: left; margin: 0px 0px 0px 23px;">
            <?php if($patient_insurance_details['NewInsurance']['assignment_of_benefits']=='N'){?>
            <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png" />
             <?php }else {?>
             <div style="width:18px; height: 18px; float: left;border:1px solid #f54d2d">
             </div>
              <?php }?>
             <span style="float: left; margin: 2px 0px 0px 5px;">NO</span>
           </div>
          </div>
             </div>
            </div>
           </div>
          </div>
          <div class="section_16" style="float:left; width:100%;border-top: 1px solid #f54d2d;">
           <div style="float:left; width:320px; text-align:center;border-right: 1px solid #f54d2d;">
            <span>31. SIGNATURE OF PHYSICIAN OR SUPPLIER
INCLUDING DEGREES OR CREDENTIALS</span>
           <p style="float:left; margin:0px; padding-bottom:4px; width:320px;">(I certify that the statements on the reverse
apply to this bill and are made a part thereof.)</p>
 <div style="float:left; width:100%; min-height:50px;font-size:15px;color:#000;text-align:left;padding-left:5px">
 <?php echo Configure::read('zirmed_client_accountname');?>
 </div>
 <div style="float:left; width:100%;">

   <div style="float:left; padding: 0 0 0 10px;">
     SIGNED
   </div>
   
   <div style="float:right;padding: 0 15px 0 0;">
     DATE<span style="font-size:15px;color:#000;padding-left:5px"><?php echo $this->DateFormat->formatDate2LocalForReport(date('Y-m-d'),Configure::read('date_format'),false);?></span>
   </div>
 </div>
           </div>
           <div style="float:left; width:368px;border-right: 1px solid #f54d2d;">
            <span>&nbsp; &nbsp;32. SERVICE FACILITY LOCATION INFORMATION</span>
            <div style="float: left; width:99%; min-height:91px; font-size:15px; color:#000;margin: 0px 0px 0px 5px;">
            <?php if(!empty($facility["Facility"]["address2"])) 
            	$addressFacility2=" ,".$facility["Facility"]["address2"];
            echo $facility["Facility"]["name"]."<Br/>".$facility["Facility"]["address1"].$addressFacility2."<br/>".$city_facility["City"]["name"]." ".$state_facility["State"]["state_code"]
            ." ".$facility["Facility"]["zipcode"]." - 0000";?>
            </div>
            <div style="float: left; width: 100%; border-top: 1px solid; border-right: 1px solid; height: 25px;">
            <div style="float:left; width:50%;border-right: 1px solid; height: 25px; ">
              <span style="float:left;margin:0 0 0 5px;">a.</span>
              
            </div>
            <div style="float: left; width:49%; background: none repeat scroll 0% 0% rgb(254, 231, 220); height: 25px; padding: 0px;">
              <span style="float:left;margin:0 0 0 5px;">b.</span>
              
            </div>
            </div>
           </div>
          </div>
    </div>
     <!-- right_side start -->
    <div class="right_side" style="width:400px; float:left; ">
     <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
      <span style="float: left; clear: left; margin: 0px 0px 0px 5px;">1a. INSURED'S I.D. NUMBER &nbsp;&nbsp;&nbsp;&nbsp;(For Program in Item 1)</span>
      <div class="pnt_name" style="height:51px; line-height:20px; font-size:15px; color:#000; margin: 0 0 1px 5px;">
       <br/><?php echo $patient_insurance_details['NewInsurance']['policy_number'];?>
      </div>
     </div>
     <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
       <span style="float: left; clear: left; margin: 0px 0px 0px 5px; width:100%">4. INSURED'S NAME (Last Name, First Name, Middle Initial)</span>
      <div class="pnt_name" style="height:59px; line-height:35px; font-size:15px; color:#000; margin: 0 0 0 5px;">
        <?php echo $patient_insurance_details['NewInsurance']['subscriber_last_name'].", ".$patient_insurance_details['NewInsurance']['subscriber_name'];?>
      </div>
     </div>
     <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
       <span style="float: left; clear: left; margin: 0px 0px 0px 5px; width:100%;">7. INSURED'S ADDRESS (No., Street)</span>
      <div class="txt_fld1" style="height:43px; line-height:35px; font-size:15px; color:#000; margin: 0 0 0 5px;">
        <?php echo $patient_insurance_details['NewInsurance']['subscriber_address1']; 
           if(!empty($patient_insurance_details['NewInsurance']['subscriber_address2']))
           {
             echo ",".$patient_insurance_details['NewInsurance']['subscriber_address2'];
           }?>
      </div>
     </div>
    <div style="float:left; width:100%;border-bottom:1px solid #f54d2d; height:44px;">
     <div style="float:left; width:334px;border-right:1px solid #f54d2d; height:44px;">
         <span style="float: left; clear: left; margin: 0px 0px 0px 5px;">CITY</span>
          <div class="pnt_name" style="height:30px; line-height:27px; font-size:15px; color:#000; margin: 0 0 0 5px; float:left; clear:left;">
           <?php echo ucwords($patient_insurance_details['NewInsurance']['subscriber_city'])?>
          </div>
          </div>
          <div style="float:left">
          <span style="float: left; clear: left; margin: 0px 0px 0px 5px;">STATE</span>
          <div class="pnt_name" style="height:43px; line-height:35px; font-size:15px; color:#000;  float:left; clear:left;margin: 0 0 0 5px">
           <?php echo ucwords($state_location_subscriber['State']['state_code'])?>
          </div>
          </div>
    </div>
    <div style="float:left; width:100%; border-bottom:1px solid #f54d2d;">
    <div style="float:left; width:195px;border-right:1px solid #f54d2d; height:44px">
           <span style="float: left; clear: left; margin: 0px 0px 0px 5px;">ZIP CODE</span>
           <div class="pnt_name" style="height:30px; line-height:27px; font-size:15px; color:#000; margin: 0 0 0 5px;float:left; clear:left;">
           <?php echo $patient_insurance_details['NewInsurance']['subscriber_zip']?>
          </div>
          </div>
          <div style="float:left">
          <span style="float: left; clear: left; margin: 0px 0px 0px 5px;">TELEPHONE (Include Area Code)</span>
          <div class="pnt_name" style="height:43px; line-height:35px; font-size:15px; color:#000; margin: 0 0 0 5px;">

            <?php if(empty($subscriberPhoneAreacode)){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}else {?><span style="color:#f54d2d;">(</span> <?php echo substr($subscriberPhoneAreacode,0,3);?><span style="color:#f54d2d;"> )</span><?php } echo substr($subscriberPhoneAreacode,3,8);?>

          </div>
          </div>
    </div>
    <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
       <span style="float: left; clear: left; margin: 0px 0px 0px 5px; width:100%;">11. INSURED'S POLICY GROUP OR FECA NUMBER</span>
      <div class="pnt_name" style="height:51px; line-height:35px; font-size:15px; color:#000; margin: 0 0 0 5px;">
        <?php echo $patient_insurance_details['NewInsurance']['group_number'];?>
      </div>
     </div>
     <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
      <div class="patient_dob" style="float:left;">
          <div class="dob" style="float:left; width:200px;">
            <span style="float:left;clear: left; margin: 0px 0px 0px 5px;">a. INSURED'S DATE OF BIRTH</span>
            <div class="birtsection">
                 <div class="birth_date" style="height:39px !important;">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">MM</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:35px; float:left;color:#000">
                    <?php echo $subscriberDob["1"];?>
                    </div>
                   </div>
                  </div>
                  <div class="birth_date" style="height:39px !important;">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">DD</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:35px; float:left;color:#000">
                    <?php echo $subscriberDob["2"];?>
                    </div>
                   </div>
                  </div>
                  <div class="birth_date" style="height:39px !important;">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">YY</span>
                   <div id="birthtxtbox" style="height:20px; width:35px; float:left;color:#000">
                    <?php echo $subscriberDob["0"];?>
                    </div>
                   </div>
                  </div>
                  </div>
          </div>
          <div class="gender" style="float:left; text-align:center;">
            <span>SEX</span><br />
             <div style="width:50px; float:left;margin:15px 15px 0 0;">
              M 
               <?php if($patient_insurance_details['NewInsurance']['subscriber_gender']=="Male"){?>
               
                <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png"  />
               
               <?php } else {?>
               <div style="float:right; height:19px; width:20px;border:1px solid #f54d2d">
               </div>
               <?php }?>
             </div>
             <div style="width:50px; float:left;margin-top: 15px;">
               F
               <?php if($patient_insurance_details['NewInsurance']['subscriber_gender']=="Female"){?>
               
                <img src="<?php echo $this->webroot?>theme/black/img/icons/cross_1500.png"  />
               
               <?php } else {?>
               <div style="float:right; height:19px; width:20px;border:1px solid #f54d2d">
               </div>
               <?php }?>
             </div>
          </div>
        </div>
     </div>
     <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
       <span style="float: left; width: 100%; margin: 0px 0px 0px 5px;">b. OTHER CLAIM ID (Designated by NUCC)</span>
       <div style="float: left; height: 20px; width: 35px; border-right: 1px dashed rgb(245, 77, 45); margin: 7px 5px;">
       </div>
      <div class="pnt_name" style="height:43px; line-height:35px; font-size:15px; color:#000; ">
      
      </div>
     </div>
     <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
       <span style="float: left; width: 100%; margin: 0px 0px 0px 5px;">c. INSURANCE PLAN NAME OR PROGRAM NAME</span>
     <div class="pnt_name" style="height:31px; line-height:35px; font-size:15px; color:#000; margin:0 0 0 5px; float:left;">
        <?php echo $patient_insurance_details['NewInsurance']['insurance_name'];?>
      </div>
     </div>
     <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
      <span style="float: left; width: 100%; margin: 0px 0px 0px 5px;">d. IS THERE ANOTHER HEALTH BENEFIT PLAN?</span>
      <div style="float: left; width:42%;margin: 12px 0px 1px 30px;">
           <div style="float: left; width:37%; margin: 0px 0px 2px 0px;">
             <div style="border: 1px solid rgb(245, 77, 45); width:18px; height: 18px; float: left;">
             </div>
             <span style="float: left; margin: 2px 0px 0px 5px;">YES</span>
           </div>
           <div style="float: left; margin: 0px 0px 0px 23px;">
             <div style="width:18px; height: 18px; float: left;border:1px solid #f54d2d">
            
             </div>
             <span style="float: left; margin: 2px 0px 0px 5px;">NO</span>
           </div>
          </div>
          <div style="float:left;margin-top: 15px;">
           <span style="float:left; font-style:italic;">If yes,</span> complete items 9, 9a, 9d.
          </div>
     </div>
     <div style="float:left; width:100%;border-bottom:5px solid #f54d2d; padding-bottom:2px; height:93px;">
      <span style=" margin: 0px 0px 19px 5px; float:left;">13. INSURED’S OR AUTHORIZED PERSON’S SIGNATURE I authorize
payment of medical benefits to the undersigned physician or supplier for services described below.</span>
<div class="signed_sec" style="float: left; margin-top:0px; width: 360px; padding-top:13px;">
             <span style="float:left; margin:0 0 0px 5px;">SIGNED</span>
             <div style="float:left; color:#f54d2d;">______________________________________</div>
            </div>
     </div>
     <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
     <span>16. DATES PATIENT UNABLE TO WORK IN CURRENT OCCUPATION</span>
     <div style="float:left; width:100%;">
      <div class="from_sec" style="float: left;">
       <span style="float: left; margin: 20px 0px 0px 10px;">FROM</span>
       <div class="birtsection" style="float:left;">
                 <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">MM</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">DD</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">YY</span>
                   <div id="birthtxtbox" style="height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  </div>
      </div>
        <div class="to_sec" style="float: left;">
         <span style="float: left; margin: 20px 0px 0px 25px;">TO</span>
         <div class="birtsection" style="float:left;">
                 <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">MM</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">DD</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">YY</span>
                   <div id="birthtxtbox" style="height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  </div>
      </div>
     </div>
     </div>
     <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
     <span style=" margin: 0px 0px 0px 5px;">18. HOSPITALIZATION DATES RELATED TO CURRENT SERVICES</span>
     <div style="float:left; width:100%;">
      <div class="from_sec" style="float: left;">
       <span style="float: left; margin: 20px 0px 0px 10px;">FROM</span>
       <div class="birtsection" style="float:left;">
                 <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">MM</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">DD</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">YY</span>
                   <div id="birthtxtbox" style="height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  </div>
      </div>
        <div class="to_sec" style="float: left;">
         <span style="float: left; margin: 20px 0px 0px 25px;">TO</span>
         <div class="birtsection" style="float:left;">
                 <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">MM</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">DD</span>
                   <div id="birthtxtbox" style="border-right:1px dashed #f54d2d; height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  <div class="birth_date">
                  <div class="inner_birth">
                   <span id="boxSpace" class="">YY</span>
                   <div id="birthtxtbox" style="height:20px; width:35px; float:left;">
                    
                    </div>
                   </div>
                  </div>
                  </div>
      </div>
     </div>
     </div>
       <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
        <div class="lab_section" style="float:left;">
         <div class="outside_lab" style="float:left; width:200px;">
          <span style="float:left;margin: 0px 0px 0px 5px;">20. OUTSIDE LAB?</span>
          <div style="float: left; width:200px; margin: 24px 0px 0px 13px;">
           <div style="float: left; width: 50%; margin: 0px 0px 0px 12px;">
             <div style="border: 1px solid rgb(245, 77, 45); width:18px; height: 18px; float: left;">
             </div>
             <span style="float: left; margin: 2px 0px 0px 5px;">YES</span>
           </div>
           <div style="float: left; margin: 0px 0px 0px 4px;">
             <div style="width:18px; height: 18px; float: left;border:1px solid #f54d2d">
               <!--<img src="image/cross1.png" />-->
             </div>
             <span style="float: left; margin: 2px 0px 0px 5px;">NO</span>
           </div>
          </div>
         </div>
         <div class="charges" style="float:left; width:150px;">
          <span style="float: left; clear: both; width: 100%;">$ CHARGES</span>
          <div style="float: left; border-left: 1px solid rgb(245, 77, 45); width: 60px; height: 25px; margin-top: 23px;">
          </div>
          <div style="float: left; border-left: 1px solid rgb(245, 77, 45); width: 60px; height: 25px; margin: 22px 0px 0px 8px;">
          </div>
         </div>
        </div>
       </div>
       <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
         <div class="resubission_code" style="width:166px; float:left;">
          <span style="float:left;width:100%;margin: 0px 0px 0px 5px;">22. RESUBMISSION CODE</span>
          <div style="float:left; height:27PX; width:161px; border-right:1px solid #f54d2d;">
         </div>
         </div>
         <div class="ori_ref_no" style="width:150px; float:left;">
         <span style="float:left;width:100%;margin: 0px 0px 0px 5px;">ORIGINAL REF. NO.</span>
          <div style="float:left; height:25PX; width:180px;">
         </div>
         </div>
       </div>
        <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
        <span style="float: left; width: 100%;margin: 0px 0px 0px 5px;">b. OTHER CLAIM ID (Designated by NUCC)</span>
      
      <div class="pnt_name" style="height:63px; line-height:35px; font-size:15px; color:#000; margin: 0px 0px 0px 5px;">
       
      </div>
        </div>
        <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
         <div style="float:left; width:120px; text-align:center;border-right:1px solid #f54d2d;">
          <span style="float: left; width: 100%; text-align:center; padding-bottom:16px;">F.</span>
          $ CHARGES
         </div>
         <div style="float:left; width:70px; text-align:center;border-right:1px solid #f54d2d;">
          <span style="float: left; width: 100%; text-align:center;">G.</span>
          DAYS
           OR
          UNITS
         </div>
         <div style="float: left; text-align: center; font-size: 11px; width: 51px;border-right:1px solid #f54d2d;">
          <span style="float: left; width: 100%; text-align:center; padding-bottom:4px;">H.</span>
          EPSDT
Famly
Plan
         </div>
         <div style="float: left; text-align: center;width:49px;border-right:1px solid #f54d2d;padding-bottom:1px;">
          <span style="float: left; width: 100%; text-align:center;">I.</span><br>
         <div>ID.
		      QUAL</div>
         </div>
         <div style="float: left; text-align: center;width: 103px;">
          <span style="float: left; width: 100%; text-align:center;">J.</span>
         RENDERING
         PROVIDER ID.#
         </div>
        </div>
         <div style="float:left; width:100%; background:#fee7dc repeat-x;">
         <div style="float:left; width:100%;">
           <div style="width:70px; float:left;padding: 0px 0px 0px 13px;  height:20px;">
          
          </div>
          <div style="width:23px; float:left;padding: 0px 0px 0px 13px; height:20px">
          
          </div>
          <div style="width:57px; float:left;padding: 0px 0px 0px 13px;  height:20px;">
         
          </div>
          <div style="width:41px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; height:20px">
        
          </div>
          <div style="width:36px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px;height:20px">
         
          </div>
          <div style="width:90px; float:left;padding: 0px 0px 0px 13px; height:20px">
        
          </div>
         </div>
          <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
           <div style="width:70px; float:left; border-right:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
          <?php echo $cost[0];?>
          </div>
          <div style="width:23px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
         <?php echo $cost[1];?>
          </div>
          <div style="width:57px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           <?php echo "1";?>
          </div>
          <div style="width:38px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 1px 13px; background:#fff repeat-x; height:20px;color:#000 ">
          
          </div>
          <div style="width:36px; float:left; border-right:1px solid #f54d2d;border-top:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000">
           NPI
          </div>
          <div style="width:90px; float:left;border-top:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           
          </div>
         </div>
         <div style="float:left; width:100%;">
           <div style="width:70px; float:left;padding: 0px 0px 0px 13px;  height:20px;">
         
          </div>
          <div style="width:23px; float:left;padding: 0px 0px 0px 13px; height:20px">
          
          </div>
          <div style="width:57px; float:left;padding: 0px 0px 0px 13px;  height:20px;">
         
          </div>
          <div style="width:41px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; height:20px">
        
          </div>
          <div style="width:36px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px;height:20px">
         
          </div>
          <div style="width:90px; float:left;padding: 0px 0px 0px 13px; height:20px">
        
          </div>
         </div>
          <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
           <div style="width:70px; float:left; border-right:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           <?php $costProcedure=explode(".",$procedureDataVal["0"]["cost"]) ;
           echo $costProcedure["0"];?>
          </div>
          <div style="width:23px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000">
         <?php echo $costProcedure["1"];?>
          </div>
          <div style="width:57px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           <?php echo $procedureDataVal["0"]["units"];?>
          </div>
          <div style="width:38px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 1px 13px; background:#fff repeat-x; height:20px;color:#000 ">
          
          </div>
          <div style="width:36px; float:left; border-right:1px solid #f54d2d;border-top:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           NPI
          </div>
          <div style="width:90px; float:left;border-top:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           
          </div>
         </div>
         <div style="float:left; width:100%;">
           <div style="width:70px; float:left;padding: 0px 0px 0px 13px;  height:20px;">
          
          </div>
          <div style="width:23px; float:left;padding: 0px 0px 0px 13px; height:20px">
          
          </div>
          <div style="width:57px; float:left;padding: 0px 0px 0px 13px;  height:20px;">
         
          </div>
          <div style="width:41px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; height:20px">
        
          </div>
          <div style="width:36px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px;height:20px">
         
          </div>
          <div style="width:90px; float:left;padding: 0px 0px 0px 13px; height:20px">
        
          </div>
         </div>
          <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
           <div style="width:70px; float:left; border-right:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           <?php $costProcedure=explode(".",$procedureDataVal["1"]["cost"]) ;
           echo $costProcedure["0"];?>
          </div>
          <div style="width:23px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
         <?php echo $costProcedure["1"];?>
          </div>
          <div style="width:57px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           <?php echo $procedureDataVal["1"]["units"];?>
          </div>
          <div style="width:38px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 1px 13px; background:#fff repeat-x; height:20px;color:#000 ">
          
          </div>
          <div style="width:36px; float:left; border-right:1px solid #f54d2d;border-top:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           NPI
          </div>
          <div style="width:90px; float:left;border-top:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px">
           
          </div>
         </div>
         <div style="float:left; width:100%;">
           <div style="width:70px; float:left;padding: 0px 0px 0px 13px;  height:20px;">
          
          </div>
          <div style="width:23px; float:left;padding: 0px 0px 0px 13px; height:20px">
          
          </div>
          <div style="width:57px; float:left;padding: 0px 0px 0px 13px;  height:20px;">
         
          </div>
          <div style="width:41px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; height:20px">
        
          </div>
          <div style="width:36px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px;height:20px">
         
          </div>
          <div style="width:90px; float:left;padding: 0px 0px 0px 13px; height:20px">
        
          </div>
         </div>
          <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
           <div style="width:70px; float:left; border-right:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           <?php $costProcedure=explode(".",$procedureDataVal["2"]["cost"]) ;
           echo $costProcedure["0"];?>
          </div>
          <div style="width:23px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
         <?php echo $costProcedure["1"];?>
          </div>
          <div style="width:57px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           <?php echo $procedureDataVal["2"]["units"];?>
          </div>
          <div style="width:38px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 1px 13px; background:#fff repeat-x; height:20px;color:#000 ">
          
          </div>
          <div style="width:36px; float:left; border-right:1px solid #f54d2d;border-top:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           NPI
          </div>
          <div style="width:90px; float:left;border-top:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000">
           
          </div>
         </div>
         <div style="float:left; width:100%;">
           <div style="width:70px; float:left;padding: 0px 0px 0px 13px;  height:20px;">
          
          </div>
          <div style="width:23px; float:left;padding: 0px 0px 0px 13px; height:20px">
          
          </div>
          <div style="width:57px; float:left;padding: 0px 0px 0px 13px;  height:20px;">
         
          </div>
          <div style="width:41px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; height:20px">
        
          </div>
          <div style="width:36px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px;height:20px">
         
          </div>
          <div style="width:90px; float:left;padding: 0px 0px 0px 13px; height:20px">
        
          </div>
         </div>
          <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
           <div style="width:70px; float:left; border-right:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           <?php $costProcedure=explode(".",$procedureDataVal["3"]["cost"]) ;
           echo $costProcedure["0"];?>
          </div>
          <div style="width:23px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
         <?php echo $costProcedure["1"];?>
          </div>
          <div style="width:57px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           <?php echo $procedureDataVal["3"]["units"];?>
          </div>
          <div style="width:38px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 1px 13px; background:#fff repeat-x; height:20px;color:#000 ">
          
          </div>
          <div style="width:36px; float:left; border-right:1px solid #f54d2d;border-top:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           NPI
          </div>
          <div style="width:90px; float:left;border-top:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000;color:#000">
           
          </div>
         </div>
         <div style="float:left; width:100%;">
           <div style="width:70px; float:left;padding: 0px 0px 0px 13px;  height:20px;">
          
          </div>
          <div style="width:23px; float:left;padding: 0px 0px 0px 13px; height:20px">
          
          </div>
          <div style="width:57px; float:left;padding: 0px 0px 0px 13px;  height:20px;">
         
          </div>
          <div style="width:41px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; height:20px">
        
          </div>
          <div style="width:36px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px;height:20px">
         
          </div>
          <div style="width:90px; float:left;padding: 0px 0px 0px 13px; height:20px">
        
          </div>
         </div>
          <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
           <div style="width:70px; float:left; border-right:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
           <?php $costProcedure=explode(".",$procedureDataVal["4"]["cost"]) ;
           echo $costProcedure["0"];?>
          </div>
          <div style="width:23px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000 ">
         <?php echo $costProcedure["1"];?>
          </div>
          <div style="width:57px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000">
           <?php echo $procedureDataVal["4"]["units"];?>
          </div>
          <div style="width:38px; float:left; border-right:1px solid #f54d2d;padding: 0px 0px 1px 13px; background:#fff repeat-x; height:20px;color:#000">
          
          </div>
          <div style="width:36px; float:left; border-right:1px solid #f54d2d;border-top:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000">
           NPI
          </div>
          <div style="width:90px; float:left;border-top:1px dashed #f54d2d;padding: 0px 0px 0px 13px; background:#fff repeat-x; height:20px;color:#000">
           
          </div>
         </div>
        <div>
        </div>
    </div>
    <div style="float:left; width:100%;border-bottom:1px solid #f54d2d;">
      <div class="total_chrg" style="float:left; width:128px;border-right:1px solid #f54d2d;">
       <span>&nbsp;28. TOTAL CHARGE</span>
       <div style="float: left; width: 100%; padding-top: 25px;">
        <span style="float: left; width: 30px;margin: 0 0 0 10px;">$</span>
        <div style="float: left; border-right: 1px dashed rgb(245, 77, 45); height: 25px; width: 50px;color:#000">
       <?php echo $totalAmt[0];?>
        </div>
        <div style="float:left;height:25px; width:30px;color:#000"><?php echo $totalAmt[1];?></div>
       </div>
      </div>
      <div class="amt_paid" style="float:left; width:122px;border-right:1px solid #f54d2d;">
       <span>&nbsp;29. AMOUNT PAID</span>
       <div style="float: left; width: 100%; padding-top: 25px;">
        <span style="float: left; width: 30px;margin: 0 0 0 10px;">$</span>
        <div style="float: left; border-right: 1px dashed rgb(245, 77, 45); height: 25px; width: 50px;">
        <?php echo $amtPaid[0];?>
        </div>
        <div style="float:left;height:25px; width:30px;">
        <?php echo $amtPaid[1];?>
        </div>
       </div>
      </div>
      <div class="total_chrg" style="float:left; width:133px;">
       <span>&nbsp;30. Rsvd for NUCC Use</span>
       <div style="float: left; width: 100%; padding-top: 25px;">
        <span style="float: left; width: 30px;margin: 0 0 0 10px;"></span>
        <div style="float: left; border-right: 1px dashed rgb(245, 77, 45); height: 25px; width: 50px;">
        </div>
        <div style="float:left;height:25px; width:30px;"></div>
       </div>
      </div>
    </div>
    <div style="float:left; width:100%;">
    <div style="float:left; width:400px;">
            <span style="float:left; width:242px;margin:0 0 0 5px;">33. BILLING PROVIDER INFO & PH # </span>
           <div> <span style="color:#f54d2d">( </span>  <span style="color:#f54d2d">)</span></div>
            
            <div style="float: left; width: 100%; min-height:91px; font-size:15px; color:#000;margin: 0px 0px 0px 5px;"><?php if(!empty($hospital_location["Location"]["address2"])) 
            	$address2=" ,".$hospital_location["Location"]["address2"];
            echo $hospital_location["Location"]["name"]."<Br/>".$hospital_location["Location"]["address1"].$address2."<br/>".$city_location["City"]["name"]." ".$state_location["State"]["state_code"]
            ." ".$hospital_location["Location"]["zipcode"]."- 0000";?>
            </div>
            <div style="float: left; width: 100%; border-top: 1px solid; border-right: 1px solid; height: 25px;">
            <div style="float:left; width:50%;border-right: 1px solid; height: 25px; ">
              <span style="float:left; margin:0 0 0 5px;font-size:15px; color:#000;">a.<?php echo $hospital_location["Location"]["hospital_npi"];?></span>
              
            </div>
            <div style="float: left; width:49%; background: none repeat scroll 0% 0% rgb(254, 231, 220); height: 25px; padding: 0px;">
              <span style="float:left;margin:0 0 0 5px;">b.</span>
              
            </div>
            </div>
           </div>
    </div>
   </div>
 </div>
   
 <div style="float:left; width:100%; border-top:5px solid #ed1c24;">
   <div style="float:left; font-sixe:15px!important;">
    <span style="float:left; font-sixe:15px!important;">NUCC Instruction Manual available at: www.nucc.org</span>
   </div>
   <div style="float:left; font-style:italic; text-align:center; width:472px;font-weight:bold;">
    PLEASE PRINT OR TYPE
   </div>
   <div style="float:right;font-sixe:15px!important;">
    APPROVED OMB-0938-1197 FORM 1500 (02-12)
   </div>
 </div>
 
  <div style="position:absolute; top:786px; right:-37px;"><img src="<?php echo $this->webroot?>img/bottom_strip.png" /></div>
 </div>
 
 </div>
</body>
</html>
