<div style="float:right;" id="printButton">
	<?php echo $this->Html->link('Print','#',array('onclick'=>'document.getElementById(\'language\').style.display=\'none\';window.print();','class'=>'blueBtn','escape'=>false));?>
</div>
<?php
$url = $this->Html->url(array("controller"=>"nursings","action"=>"ventilator_consent",$patient['Patient']['id'], $PatientVentilatorConsent['PatientVentilatorConsent']['id'],1));
?>

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
	#language{color:#000;border:1px solid;}
</style>
 
<div class="clr ht5"></div>
<?php echo $this->element('print_patient_info');?>
<div class="clr ht5"></div>
 
 <div class="clr ht5"></div>
<div class="clr ht5"></div>
 <?php
 //if(!isset($this->params->query['language']) || $this->params->query['language']=="hindi"){
 ?> 
<!--   <div class="hindi-para">
&#2361;&#2350;&#2375; &#2361;&#2350;&#2366;&#2352;&#2375; &#2350;&#2352;&#2368;&#2332; &#2358;&#2381;&#2352;&#2368; / &#2358;&#2381;&#2352;&#2368;&#2350;&#2340;&#2368;&nbsp; <?php //echo ucfirst($patient['Initial']['name'])." ".ucfirst($patient['Patient']['lookup_name']) ;?>&nbsp; &#2325;&#2375; &#2348;&#2368;&#2350;&#2366;&#2352;&#2368; &#2325;&#2375; &#2357;&#2367;&#2359;&#2351; &#2350;&#2375;&#2306; &#2337;&#2377;&#2325;&#2381;&#2335;&#2352;&#2379;&#2306; &#2344;&#2375; &#2348;&#2340;&#2366;&#2351;&#2366; &#2361;&#2376; &#2325;&#2368; , &#2350;&#2352;&#2368;&#2332; &nbsp;  <?php //echo $PatientVentilatorConsent['PatientVentilatorConsent']['disease'];?>&nbsp;  &#2348;&#2368;&#2350;&#2366;&#2352;&#2368; &#2360;&#2375; &#2346;&#2368;&#2337;&#2364;&#2367;&#2340; &#2361;&#2376; &#2404;

&#2350;&#2352;&#2368;&#2332; &#2325;&#2379; &#2360;&#2366;&#2306;&#2360; &#2354;&#2375;&#2344;&#2375; &#2350;&#2375;&#2306; &#2309;&#2340;&#2381;&#2351;&#2306;&#2340; &#2325;&#2336;&#2344;&#2366;&#2312; &#2361;&#2376; &#2311;&#2360;&#2354;&#2367;&#2319; &#2350;&#2352;&#2368;&#2332; &#2325;&#2379; &#2325;&#2371;&#2340;&#2381;&#2352;&#2367;&#2350; &#2358;&#2381;&#2357;&#2360;&#2344; &#2325;&#2375; &#2351;&#2344;&#2381;&#2340;&#2381;&#2352; &#2346;&#2352; (Mechanical Ventilator) &#2352;&#2326;&#2344;&#2375; &#2325;&#2368; &#2332;&#2352;&#2369;&#2352;&#2340; &#2361;&#2376; &#2404; &#2361;&#2350;&#2375;&#2306; &#2351;&#2361; &#2332;&#2366;&#2344;&#2325;&#2366;&#2352;&#2368; &#2337;&#2377;&#2325;&#2381;&#2335;&#2352;&#2379;&#2306; &#2344;&#2375; &#2342;&#2368; &#2361;&#2376; &#2404; &#2324;&#2352; &#2361;&#2350; &#2350;&#2352;&#2368;&#2332; &#2325;&#2379; (Ventilator) &#2354;&#2327;&#2366;&#2344;&#2375; &#2325;&#2368; &#2309;&#2344;&#2369;&#2350;&#2340;&#2367; &#2342;&#2375;&#2340;&#2375; &#2361;&#2376; &#2404; 
<div class="clr ht5"></div>
<div class="clr ht5"></div>
 
&#2342;&#2367;&#2344;&#2366;&#2306;&#2325;&nbsp;&nbsp;&nbsp;  <?php //echo  $this->DateFormat->formatDate2local($PatientVentilatorConsent['PatientVentilatorConsent']['date1'],Configure::read('date_format')); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp &nbsp;&nbsp;&#2361;&#2360;&#2381;&#2340;&#2366;&#2325;&#2381;&#2359;&#2352; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#2352;&#2367;&#2358;&#2381;&#2340;&#2366; &nbsp;  <?php //echo $PatientVentilatorConsent['PatientVentilatorConsent']['relationship'] ; ?>  &nbsp;

<div class="clr ht5"></div>
 <hr> 
<div class="clr ht5"></div>
<div class="clr ht5"></div>
&#2310;&#2325;&#2360;&#2381;&#2350;&#2367;&#2325; / &#2346;&#2381;&#2352;&#2366;&#2339;&#2328;&#2366;&#2340;&#2325; &#2309;&#2357;&#2360;&#2381;&#2341;&#2366; &#2350;&#2375;&#2306; , &#2350;&#2352;&#2368;&#2332; &#2325;&#2379; &#2332;&#2366;&#2344;&#2325;&#2366;&#2352;&#2368; &#2344;&#2361;&#2368;&#2306; &#2342;&#2368; &#2327;&#2312; , &#2325;&#2379;&#2312; &#2352;&#2367;&#2358;&#2381;&#2340;&#2375;&#2342;&#2366;&#2352; &#2344;&#2361;&#2368;&#2306; &#2361;&#2376; &#2324;&#2352; &#2350;&#2352;&#2368;&#2332; &#2361;&#2360;&#2381;&#2340;&#2366;&#2325;&#2381;&#2359;&#2352; &#2325;&#2352;&#2344;&#2375; &#2325;&#2368; &#2309;&#2357;&#2360;&#2381;&#2341;&#2366; &#2350;&#2375;&#2306; &#2341;&#2375;| &#2311;&#2360;&#2354;&#2367;&#2319; &#2350;&#2376;&#2306;&#2344;&#2375; &#2350;&#2352;&#2368;&#2332; &#2325;&#2368; &#2332;&#2366;&#2344; &#2348;&#2330;&#2344;&#2375; &#2325;&#2375; &#2354;&#2367;&#2319; &#2313;&#2360;&#2375; (Ventilator) &#2346;&#2352; &#2352;&#2326;&#2366; &#2327;&#2351;&#2366; &#2404;
<div class="clr ht5"></div>
<div class="clr ht5"></div>
&#2342;&#2367;&#2344;&#2366;&#2306;&#2325; &nbsp;  <?php //echo  $this->DateFormat->formatDate2local($PatientVentilatorConsent['PatientVentilatorConsent']['date2'],Configure::read('date_format')); ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp &#2337;&#2377;&#2325;&#2381;&#2335;&#2352; &#2325;&#2366; &#2344;&#2366;&#2350; &nbsp;  <?php echo ucfirst($treating_consultant[0]['fullname']) ;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&#2361;&#2360;&#2381;&#2340;&#2366;&#2325;&#2381;&#2359;&#2352; 

</div>-->
 
  <?php 
	//}else if( isset($this->params->query['language']) && $this->params->query['language']=="english"){

?>
<div class="english-para">

<p>I Mr/Mrs.&nbsp;<strong><?php  echo $PatientVentilatorConsent['PatientVentilatorConsent']['relationship'] ; ?></strong>&nbsp;(patient/person responsible) understand that <strong><?php echo  ucfirst($patient[0]['lookup_name']) ;?></strong> (the patient) requires Intensive Care admission for a life threatening or potentially life threatening condition.</p>
<p>Intensive care admission may include any or all of a number of complex procedure and treatments detailed which is available in the ICU reception. </p>
<p>I have read and understand the about procedure and treatment booklet. I understand that the ICU Staff will not be seeking consent for individual procedures/treatments listed in the booklet. I have had the oppurtunity to ask questions about the procedures listed and these questions have been answered to my satisfaction.  </p>
<p>I consent to ICU admission and the procedures/treatments that are integral to ICU admission</p>
<p>Signature of patient/person responsible:_____________</p>
<p>Date:<?php echo  $this->DateFormat->formatDate2local($PatientVentilatorConsent['PatientVentilatorConsent']['date1'],Configure::read('date_format')); ?>
<p>Signature of Doctor:___________</p>


<!--  We have been informed about our patient Mr/Mrs.&nbsp;<strong><?php echo ucfirst($patient['Initial']['name'])." ".ucfirst($patient['Patient']['lookup_name']) ;?></strong>&nbsp; by  thetreating doctor's / consultant that the patient is suffering from   <?php echo $PatientVentilatorConsent['PatientVentilatorConsent']['disease'];?> &nbsp;disease. Patient is facing extreme difficulty in breathing. Thereforethe  patient needs to be kept on mechanical ventilator. This information is given to us by the consulting doctors. We give our permission and consent for keeping our patient on ventilator. 
<div class="clr ht5"></div>
<div class="clr ht5"></div>
Date &nbsp; <?php echo  $this->DateFormat->formatDate2local($PatientVentilatorConsent['PatientVentilatorConsent']['date1'],Configure::read('date_format')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  Signature:  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;   &nbsp;  &nbsp;  &nbsp;  &nbsp;  Relation: &nbsp;<?php echo $PatientVentilatorConsent['PatientVentilatorConsent']['relationship'] ; ?> &nbsp;
 
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<hr/>
In emergency/life threatening condition, the patient was not informed, No relative was present,  thepatient was not in a condition to put its signature. Hence to save the life of the patient, I put the patient on ventilator.

 

<div class="clr ht5"></div>
<div class="clr ht5"></div>
 Date &nbsp; <?php echo  $this->DateFormat->formatDate2local($PatientVentilatorConsent['PatientVentilatorConsent']['date2'],Configure::read('date_format')); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  Signature:  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;   &nbsp  Name of Doctor:&nbsp;  <?php echo ucfirst($treating_consultant[0]['fullname']) ;?>
 
-->
</div>
<?php 
	//} 

?>