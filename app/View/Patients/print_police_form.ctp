<style>
	body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#000000;}
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
<?php  
if($patientPFDetails['PoliceForm']['inform_date']) {
 	    $informDate = $this->DateFormat->formatDate2Local($patientPFDetails['PoliceForm']['inform_date'],Configure::read('date_format'), false);
       } else {
       	$informDate = "";
       }
       if($patientPFDetails['PoliceForm']['accident_date']) {
 	    $accidentDate = $this->DateFormat->formatDate2Local($patientPFDetails['PoliceForm']['accident_date'],Configure::read('date_format'), false);
       } else {
       	$accidentDate = "";
       }
       if($patientPFDetails['PoliceForm']['admit_date']) {
 	    $admitDate = $this->DateFormat->formatDate2Local($patientPFDetails['PoliceForm']['admit_date'],Configure::read('date_format'), false);
       } else {
       	$admitDate = "";
       }
?>
<div style="float:right" id="printButton">
					<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
				  </div>&nbsp;<div>
				  </div>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
     <tr>
      <td width="100%" align="center"><b style="font-size:18px;">&#2346;&#2379;&#2354;&#2367;&#2358; &#2360;&#2381;&#2335;&#2375;&#2358;&#2344; &#2346;&#2352;&#2381;&#2330;&#2368;</b></td>
     </tr>
<tr>
   <td align="right"> &#2344;. 
               <?php 
		          echo $patientPFDetails['PoliceForm']['inform_no'];
		        ?>
		    </td>
  </tr>
 <tr>
 <td align="right" style="border-bottom:1px solid #000000;">&#2360;&#2369;&#2330;&#2344;&#2366; &#2342;&#2367;&#2344;&#2366;&#2306;&#2325;:<?php 
		          echo "&nbsp;".$informDate;
		        ?></td>
 </tr>
  <tr><td>
  </td></tr>
<tr>
   <td align="left">&#2346;&#2381;&#2352;&#2340;&#2367;<br>
&#2346;&#2379;&#2354;&#2367;&#2358; &#2344;&#2367;&#2352;&#2368;&#2325;&#2381;&#2359;&#2325;<br>
&#2346;&#2379;&#2354;&#2367;&#2358; &#2360;&#2381;&#2335;&#2375;&#2358;&#2344; <?php 
		          echo $patientPFDetails['PoliceForm']['police_station_location']; 
		        ?><br>
<?php 
		          echo $patientPFDetails['PoliceForm']['location']; 
		        ?></td>
  </tr>
 <tr>
  <td>&#2350;&#2361;&#2379;&#2342;&#2351;,</td>
 </tr>
 <tr>
 <td>
 <p>
 
&#2310;&#2346;&#2325;&#2379; &#2360;&#2370;&#2330;&#2367;&#2340; &#2325;&#2367;&#2351;&#2366; &#2332;&#2366;&#2340;&#2366; &#2361;&#2376; &#2325;&#2368; &#2352;&#2369;&#2327;&#2381;&#2339;   &nbsp;<?php echo $patient[0]['lookup_name']; ?>&nbsp;   &#2313;&#2350;&#2381;&#2352;   <?php echo $patient['Patient']['age']; ?>   &#2357;&#2352;&#2381;&#2359;  &#2354;&#2367;&#2306;&#2327;
&nbsp;<?php 
	echo ucfirst($patient['Patient']['sex']);
?> &#2344;&#2367;&#2357;&#2366;&#2360;&#2368; &#2327;&#2381;&#2352;&#2366;&#2350; <?php 
		          echo $patientPFDetails['PoliceForm']['address']; 
		        ?> &#2340;&#2366;&#2354;&#2369;&#2325;&#2366; <?php 
		          echo $patientPFDetails['PoliceForm']['taluka'];
		        ?> &#2332;&#2367;&#2354;&#2366; <?php 
		          echo $patientPFDetails['PoliceForm']['district'];
		        ?> &#2354;&#2366;&#2344;&#2375; &#2357;&#2366;&#2354;&#2375; &#2357;&#2381;&#2351;&#2325;&#2381;&#2340;&#2367; &#2325;&#2366; &#2344;&#2366;&#2350; <?php 
		          echo $patientPFDetails['PoliceForm']['brought_person_name']; 
		        ?> &#2352;&#2367;&#2358;&#2381;&#2340;&#2366; <?php 
		          echo $patientPFDetails['PoliceForm']['relation'];
		        ?> &#2344;&#2367;&#2357;&#2366;&#2360;&#2368; &#2327;&#2381;&#2352;&#2366;&#2350; <?php 
		          echo $patientPFDetails['PoliceForm']['brought_person_address'];
		        ?> &#2340;&#2366;&#2354;&#2369;&#2325;&#2366; <?php 
		          echo $patientPFDetails['PoliceForm']['brought_person_taluka'];
		        ?> &#2332;&#2367;&#2354;&#2366; <?php 
		          echo $patientPFDetails['PoliceForm']['brought_person_district'];
		        ?> 
&#2342;&#2381;&#2357;&#2366;&#2352;&#2366; &#2354;&#2366;&#2351;&#2366; &#2327;&#2351;&#2366; &#2361;&#2376; &#2404; &#2357;&#2361; &#2309;&#2360;&#2381;&#2346;&#2340;&#2366;&#2354; &#2350;&#2375;&#2306; /&#2360;&#2375;  &#2342;&#2367;&#2344;&#2366;&#2306;&#2325; <?php 
		          echo $admitDate;
		        ?> &#2360;&#2350;&#2351; <?php 
		          echo date("H:i", strtotime($patientPFDetails['PoliceForm']['admit_time']));
		        ?> &#2325;&#2379; &#2342;&#2366;&#2326;&#2367;&#2354; &#2361;&#2369;&#2310; / &#2344;&#2367;&#2357;&#2371;&#2340;&#2381;&#2340;  &#2361;&#2369;&#2310; / &#2350;&#2371;&#2340;&#2381;&#2351;&#2369; &#2361;&#2369;&#2312; &#2404;<br /><br /> &#2313;&#2360;&#2375; (&#2350;&#2352;&#2368;&#2332; &#2325;&#2379;) <?php 
		          echo $patientPFDetails['PoliceForm']['patient_details']; 
		        ?>
&#2330;&#2379;&#2335; &#2310;&#2351;&#2368; &#2361;&#2376; &#2404;

&#2313;&#2360;&#2325;&#2368; &#2330;&#2379;&#2335;&#2379; &#2325;&#2366; &#2360;&#2350;&#2381;&#2346;&#2370;&#2352;&#2381;&#2339; &#2357;&#2367;&#2357;&#2352;&#2339; &#2344;&#2367;&#2350;&#2381;&#2344;&#2354;&#2367;&#2326;&#2367;&#2340;  &#2361;&#2376; &#2404;
&#2309;&#2346;&#2328;&#2366;&#2340; &#2342;&#2367;&#2344;&#2366;&#2306;&#2325; <?php 
		          echo $accidentDate;
		        ?> &#2309;&#2346;&#2328;&#2366;&#2340; &#2360;&#2350;&#2351; <?php 
		          echo date("H:i", strtotime($patientPFDetails['PoliceForm']['accident_time']));
		        ?> &#2309;&#2346;&#2328;&#2366;&#2340; &#2360;&#2381;&#2341;&#2366;&#2344; &nbsp;<?php 
		          echo $patientPFDetails['PoliceForm']['accident_place'];
		        ?>&nbsp;
&#2327;&#2381;&#2352;&#2366;&#2350; <?php 
		          echo $patientPFDetails['PoliceForm']['accident_address'];
		        ?> &#2340;&#2366;&#2354;&#2369;&#2325;&#2366; <?php 
		          echo $patientPFDetails['PoliceForm']['accident_taluka'];
		        ?> &#2332;&#2367;&#2354;&#2366; <?php 
		          echo $patientPFDetails['PoliceForm']['accident_district'];
		        ?> 
&#2346;&#2379;&#2354;&#2367;&#2358; &#2360;&#2381;&#2335;&#2375;&#2358;&#2344; <?php 
		          echo $patientPFDetails['PoliceForm']['police_station'];
		        ?> &#2309;&#2306;&#2340;&#2352;&#2381;&#2327;&#2340; <?php 
		          echo $patientPFDetails['PoliceForm']['other_details'];
		        ?><br />
&#2309;&#2340;&#2307;  &#2310;&#2346;&#2360;&#2375; &#2344;&#2367;&#2357;&#2375;&#2342;&#2344; &#2361;&#2376; &#2325;&#2368;, &#2310;&#2346; &#2352;&#2369;&#2327;&#2381;&#2339; &#2325;&#2379; &#2346;&#2381;&#2352;&#2340;&#2381;&#2351;&#2325;&#2381;&#2359; &#2342;&#2375;&#2326;&#2344;&#2375; &#2310;&#2351;&#2375; &#2324;&#2352; &#2351;&#2358;&#2379;&#2330;&#2367;&#2340;  &#2325;&#2366;&#2352;&#2381;&#2351;&#2357;&#2366;&#2361;&#2368; &#2325;&#2352;&#2375; &#2404; 
<br /><br /><br />
&#2343;&#2344;&#2381;&#2351;&#2357;&#2366;&#2342; !
</p>
 </td>
 </tr>   
 <tr>
 <td align="right">
  <table width="300" border="0">
   <tr><td align="center"><?php 
		          echo $patientPFDetails['PoliceForm']['hospital_name'];
		        ?> &#2361;&#2377;&#2360;&#2381;&#2346;&#2367;&#2335;&#2354;</td></tr>
   <tr>
   <td align="center"> &#2357;&#2352;&#2368;&#2359;&#2381;&#2336; &#2330;&#2367;&#2325;&#2367;&#2340;&#2381;&#2360;&#2325;/&#2344;&#2367;&#2357;&#2366;&#2360;&#2368; &#2330;&#2367;&#2325;&#2367;&#2340;&#2381;&#2360;&#2325;</td>
 </tr> 
  </table>
  </td>
 </tr> 
                                                         
                                                                                                                 
</table>

